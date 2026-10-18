<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\ActivityLog;
use App\Models\SystemUser;
use App\Models\SupportTicket;
use App\Models\SupportMessage;

class MerchController extends Controller
{
    /**
     * MAIN PAGE: Displays the ICS Merchandise & Reservation System.
     * Retrieves data from database models and passes it to the blade view.
     */
    public function index(Request $request)
    {
        // 1. Fetch active merchandise products for the catalog
        $products = Product::where('is_active', true)->orderBy('id', 'asc')->get();

        // 2. Check for active student session and sync avatar if available in database or Supabase
        $studentUser = session('student_user');
        if ($studentUser && empty($studentUser['avatar'])) {
            try {
                $userEmail = $studentUser['email'] ?? '';
                $stuId = $studentUser['student_id'] ?? '';
                $userName = $studentUser['name'] ?? '';
                $localStu = \App\Models\Student::where(function ($q) use ($userEmail, $stuId, $userName) {
                    if ($userEmail) $q->where('email', $userEmail);
                    if ($stuId) $q->orWhere('student_id', $stuId);
                    if ($userName) $q->orWhere('name', $userName);
                })->whereNotNull('avatar')->where('avatar', '!=', '')->first();

                if ($localStu && !empty($localStu->avatar)) {
                    $studentUser['avatar'] = $localStu->avatar;
                    session(['student_user' => $studentUser]);
                } else {
                    $supaAvatar = $this->fetchAvatarFromSupabase($userEmail, $stuId, $userName);
                    if ($supaAvatar) {
                        $studentUser['avatar'] = $supaAvatar;
                        session(['student_user' => $studentUser]);
                        // Cache it locally so subsequent page loads don't make remote API calls
                        \App\Models\Student::where(function ($q) use ($userEmail, $stuId, $userName) {
                            if ($userEmail) $q->where('email', $userEmail);
                            if ($stuId) $q->orWhere('student_id', $stuId);
                            if ($userName) $q->orWhere('name', $userName);
                        })->update(['avatar' => $supaAvatar]);
                    }
                }
            } catch (\Throwable $e) {}
        }

        // 3. User-to-User Privacy Guard: Fetch reservations ONLY for the currently logged-in student
        if ($studentUser) {
            $userStuId = $studentUser['student_id'] ?? null;
            $userEmail = $studentUser['email'] ?? null;
            $userName  = $studentUser['name'] ?? null;

            $reservations = Reservation::where(function ($q) use ($userStuId, $userEmail, $userName) {
                if ($userStuId) {
                    $q->where('student_id', $userStuId);
                }
                if ($userEmail) {
                    $q->orWhere('student_id', $userEmail);
                }
                if ($userName) {
                    $q->orWhere('student_name', $userName);
                }
            })->where(function ($q) {
                $q->where('status', '!=', 'Cancelled')
                  ->orWhere('updated_at', '>=', now()->subMinutes(10));
            })->orderBy('created_at', 'desc')->get();
        } else {
            // Unauthenticated guest: empty list so other students' orders are NEVER visible
            $reservations = collect([]);
        }

        // 4. Fetch Helpdesk Tickets & active count for student support
        if ($studentUser) {
            $supportTickets = SupportTicket::with(['messages', 'reservation'])
                ->where(function ($q) use ($studentUser) {
                    $q->where('student_id', $studentUser['student_id'] ?? '')
                        ->orWhere('student_name', $studentUser['name'] ?? '');
                })
                ->orderBy('created_at', 'desc')
                ->take(20)
                ->get();
            $openTicketsCount = SupportTicket::where(function ($q) use ($studentUser) {
                $q->where('student_id', $studentUser['student_id'] ?? '')
                    ->orWhere('student_name', $studentUser['name'] ?? '');
            })->whereIn('status', ['Open', 'In Progress'])->count();
        } else {
            $supportTickets = collect([]);
            $openTicketsCount = 0;
        }

        // 5. Verified student roster (empty collection for storefront to optimize database query speed)
        $studentsList = collect([]);

        // 6. Check if current student has active admin privileges strictly in system_users database table
        $isAdminUser = false;
        if ($studentUser) {
            $userEmailLower = strtolower(trim($studentUser['email'] ?? ''));
            $userCodeLower  = strtolower(trim($studentUser['student_id'] ?? ''));
            $isAdminUser = SystemUser::where(function ($q) use ($userEmailLower, $userCodeLower) {
                    if ($userEmailLower) {
                        $q->whereRaw('LOWER(TRIM(email)) = ?', [$userEmailLower]);
                    }
                    if ($userCodeLower) {
                        $q->orWhereRaw('LOWER(TRIM(user_code)) = ?', [$userCodeLower]);
                    }
                })
                ->where('status', 'Active')
                ->exists();
        }

        // 7. Return the student view
        return view('merch', compact(
            'products',
            'reservations',
            'supportTickets',
            'openTicketsCount',
            'studentUser',
            'studentsList',
            'isAdminUser'
        ));
    }


    /**
     * DEDICATED ADMIN PORTAL: Renders admin.blade.php with all management modules
     * (Dashboard KPIs, Products CRUD, Reservations Queue, Reports, Users, Logs, Helpdesk)
     */
    public function admin(Request $request)
    {
        // 0. ACCESS CONTROL GUARD: Check OnePass authenticated student/user session
        $studentUser = session('student_user');
        if (!$studentUser) {
            return redirect()->route('oauth.login')->with('info', 'Please sign in with your OnePass campus account to access the Admin Console.');
        }

        // Sync avatar for admin if missing
        if (empty($studentUser['avatar'])) {
            try {
                $userEmail = $studentUser['email'] ?? '';
                $stuId = $studentUser['student_id'] ?? '';
                $userName = $studentUser['name'] ?? '';
                $localStu = \App\Models\Student::where(function ($q) use ($userEmail, $stuId, $userName) {
                    if ($userEmail) $q->where('email', $userEmail);
                    if ($stuId) $q->orWhere('student_id', $stuId);
                    if ($userName) $q->orWhere('name', $userName);
                })->whereNotNull('avatar')->where('avatar', '!=', '')->first();

                if ($localStu && !empty($localStu->avatar)) {
                    $studentUser['avatar'] = $localStu->avatar;
                    session(['student_user' => $studentUser]);
                } else {
                    $supaAvatar = $this->fetchAvatarFromSupabase($userEmail, $stuId, $userName);
                    if ($supaAvatar) {
                        $studentUser['avatar'] = $supaAvatar;
                        session(['student_user' => $studentUser]);
                    }
                }
            } catch (\Throwable $e) {}
        }

        $userEmail = strtolower(trim($studentUser['email'] ?? ''));
        $userCode  = strtolower(trim($studentUser['student_id'] ?? ''));

        // Check if user's email or user_code exists in User Management (system_users) and is Active
        $adminUser = SystemUser::where(function ($q) use ($userEmail, $userCode) {
                if ($userEmail) {
                    $q->whereRaw('LOWER(TRIM(email)) = ?', [$userEmail]);
                }
                if ($userCode) {
                    $q->orWhereRaw('LOWER(TRIM(user_code)) = ?', [$userCode]);
                }
            })
            ->where('status', 'Active')
            ->first();

        if (!$adminUser) {
            return redirect()->route('home')->with('error', "Access Denied: Your account ({$userEmail}) is not authorized as an Administrator in User Management.");
        }

        // Audit Trail: Record Admin Login once per session
        if (!session('admin_audit_logged')) {
            try {
                ActivityLog::record(
                    'LOGIN',
                    "Admin [{$adminUser->name} ({$adminUser->user_code})] authenticated and accessed the Admin Console.",
                    $adminUser->user_code,
                    $adminUser->name,
                    'Admin Console'
                );
                session(['admin_audit_logged' => true]);
            } catch (\Throwable $e) {}
        }

        // 1. Fetch records from each database table using Eloquent queries
        $products = Product::where('is_active', true)->orderBy('id', 'asc')->get();
        $reservations = Reservation::with('activeTicket')
            ->where(function ($q) {
                $q->where('status', '!=', 'Cancelled')
                  ->orWhere('updated_at', '>=', now()->subMinutes(10));
            })
            ->orderByRaw("CASE WHEN status = 'Pending' THEN 1 WHEN status = 'Ready for Pickup' THEN 2 ELSE 3 END ASC, created_at ASC")
            ->get();
        $activityLogs = ActivityLog::orderBy('created_at', 'desc')->take(200)->get();
        $users = SystemUser::orderBy('id', 'asc')->get();

        // 2. Compute Dashboard KPI summary metrics
        $totalProducts = $products->count();
        $totalStockUnits = $products->sum('current_stock');
        $totalSoldUnits = $products->sum('units_sold');
        $totalReservedUnits = $products->sum('units_reserved');

        $totalRevenue = 0;
        foreach ($products as $p) {
            $totalRevenue += ($p->units_sold * $p->price);
        }

        $pendingReservationsCount = $reservations->where('status', 'Pending')->count();
        $readyReservationsCount   = $reservations->where('status', 'Ready for Pickup')->count();
        $claimedReservationsCount = $reservations->where('status', 'Claimed')->count();

        // 3. Compute Sales vs Stock per item & buyers ledger
        $salesVsStock = [];
        foreach ($products as $p) {
            $initial = $p->initial_stock > 0 ? $p->initial_stock : ($p->current_stock + $p->units_sold + $p->units_reserved);
            $stockPct = $initial > 0 ? round(($p->current_stock / $initial) * 100) : 0;
            $soldPct  = $initial > 0 ? round(($p->units_sold / $initial) * 100) : 0;

            $statusText = 'In Stock';
            if ($p->current_stock <= 0) {
                $statusText = 'Out of Stock';
            } elseif ($p->current_stock < 20) {
                $statusText = 'Low Stock';
            }

            // Extract matching buyers for this merchandise item
            $matchedBuyers = $this->getBuyersForProduct($p, $reservations);

            $salesVsStock[] = [
                'id'            => $p->id,
                'item_code'     => $p->item_code,
                'name'          => $p->name,
                'category'      => $p->category,
                'price'         => $p->price,
                'initial_stock' => $initial,
                'current_stock' => $p->current_stock,
                'units_sold'    => $p->units_sold,
                'units_reserved' => $p->units_reserved,
                'revenue'       => $p->units_sold * $p->price,
                'stock_pct'     => $stockPct,
                'sold_pct'      => $soldPct,
                'image_path'    => $p->image_path,
                'status'        => $statusText,
                'buyer_count'   => count($matchedBuyers),
                'buyers'        => $matchedBuyers,
            ];
        }

        $totalInitialStock = 0;
        foreach ($salesVsStock as $item) {
            $totalInitialStock += $item['initial_stock'];
        }

        // 4. Fetch Support Helpdesk Tickets
        $supportTickets = SupportTicket::with(['messages', 'reservation'])->orderBy('created_at', 'desc')->get();
        $openTicketsCount = $supportTickets->whereIn('status', ['Open', 'In Progress'])->count();

        // 5. Category Performance Stats for Admin Charts
        $categoryStats = [
            'general'     => ['label' => 'Collegiate',    'stock' => 0, 'sold' => 0],
            'pe'          => ['label' => 'Athletics & PE', 'stock' => 0, 'sold' => 0],
            'department'  => ['label' => 'Dept Apparel',  'stock' => 0, 'sold' => 0],
            'accessory'   => ['label' => 'Accessories',   'stock' => 0, 'sold' => 0],
        ];
        foreach ($products as $p) {
            $cat = strtolower(trim($p->category));
            if ($cat === 'accessories') $cat = 'accessory';
            if (!isset($categoryStats[$cat])) {
                $categoryStats[$cat] = ['label' => ucfirst($cat), 'stock' => 0, 'sold' => 0];
            }
            $categoryStats[$cat]['stock'] += intval($p->current_stock);
            $categoryStats[$cat]['sold'] += intval($p->units_sold);
        }

        // 6. Fetch verified students for Student Directory (Excluding Admins)
        $adminEmails = SystemUser::where('role', 'like', '%Admin%')
            ->pluck('email')
            ->map(fn($e) => strtolower(trim($e)))
            ->filter()
            ->toArray();

        if ($adminUser && !empty($adminUser->email)) {
            $adminEmails[] = strtolower(trim($adminUser->email));
        }

        // Auto-sync students from reservations if not already in students table
        try {
            $resStudents = Reservation::select('student_name', 'student_id', 'department', 'year_level', 'contact')
                ->whereNotNull('student_id')
                ->distinct()
                ->get();
            foreach ($resStudents as $rs) {
                if (empty($rs->student_id)) continue;
                \App\Models\Student::firstOrCreate(
                    ['student_id' => $rs->student_id],
                    [
                        'name' => $rs->student_name,
                        'email' => strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $rs->student_id)) . '@student.npc.edu.ph',
                        'department' => $rs->department ?: 'Associate in Information Systems (AIS)',
                        'year_level' => $rs->year_level ?: '2nd Year',
                        'contact' => $rs->contact,
                        'status' => 'Enrolled',
                    ]
                );
            }
        } catch (\Throwable $e) {}

        // ALL USERS EXCEPT ADMIN (Student role only / non-admins)
        $studentUsers = \App\Models\Student::all()->filter(function ($s) use ($adminEmails) {
            $sEmail = strtolower(trim($s->email ?? ''));
            return !in_array($sEmail, $adminEmails);
        })->sortBy('name')->values();

        $verifiedStudents = $studentUsers;

        // 7. Fetch official claimed orders ledger for physical pickup tracking & sign-off audit
        $claimedReservations = Reservation::where('status', 'Claimed')
            ->orderBy('claimed_at', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        // 8. Return dedicated admin blade view
        return view('admin', compact(
            'products',
            'reservations',
            'claimedReservations',
            'activityLogs',
            'users',
            'studentUsers',
            'adminUser',
            'studentUser',
            'verifiedStudents',
            'supportTickets',
            'openTicketsCount',
            'totalProducts',
            'totalStockUnits',
            'totalSoldUnits',
            'totalReservedUnits',
            'totalInitialStock',
            'totalRevenue',
            'pendingReservationsCount',
            'readyReservationsCount',
            'claimedReservationsCount',
            'salesVsStock',
            'categoryStats'
        ));
    }

    /**
     * API: Retrieve list of catalog items in JSON format
     */
    public function getCatalog()
    {
        $products = Product::where('is_active', true)->get();
        return response()->json($products);
    }

    /**
     * STUDENT CHECKOUT: Save new student reservation into database
     */
    public function storeReservation(Request $request)
    {
        // Simple input validation
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_id'   => 'required|string|max:50',
            'department'   => 'required|string|max:255',
            'year_level'   => 'required|string|max:50',
            'contact'      => 'nullable|string|max:50',
            'pickup_date'  => 'nullable|string',
            'pickup_slot'  => 'nullable|string',
            'items'        => 'required|array|min:1',
            'total_amount' => 'required|numeric',
            'notes'        => 'nullable|string',
            'payment_method' => 'nullable|string',
            'payment_reference' => 'nullable|string',
            'receipt_image' => 'nullable|string',
        ]);

        // Process uploaded receipt if provided
        $receiptPath = null;
        if ($request->hasFile('receipt_file')) {
            $dir = public_path('uploads/receipts');
            if (!file_exists($dir)) {
                @mkdir($dir, 0777, true);
            }
            $file = $request->file('receipt_file');
            $filename = 'receipt_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $receiptPath = 'uploads/receipts/' . $filename;
        } elseif (!empty($request->receipt_image)) {
            $rawImg = trim($request->receipt_image);

            // Handle base64 data URI (from mobile/desktop canvas, file reader, or direct base64)
            if (str_contains($rawImg, ';base64,')) {
                try {
                    $dir = public_path('uploads/receipts');
                    if (!file_exists($dir)) {
                        @mkdir($dir, 0777, true);
                    }

                    $ext = 'jpg';
                    $parts = explode(';base64,', $rawImg);
                    if (count($parts) === 2) {
                        $meta = strtolower($parts[0]);
                        if (str_contains($meta, 'png')) $ext = 'png';
                        elseif (str_contains($meta, 'webp')) $ext = 'webp';
                        elseif (str_contains($meta, 'gif')) $ext = 'gif';
                        else $ext = 'jpg';

                        $decoded = base64_decode(str_replace(' ', '+', $parts[1]));
                        if ($decoded !== false && strlen($decoded) > 0) {
                            $filename = 'receipt_' . time() . '_' . Str::random(10) . '.' . $ext;
                            $targetFilePath = $dir . DIRECTORY_SEPARATOR . $filename;
                            if (@file_put_contents($targetFilePath, $decoded) !== false) {
                                $receiptPath = 'uploads/receipts/' . $filename;
                            }
                        }
                    }
                } catch (\Throwable $e) {
                    \Log::warning('Receipt upload save warning: ' . $e->getMessage());
                }

                // If file writing on disk failed, keep the raw base64 data URL in DB (now longText)
                if (empty($receiptPath)) {
                    $receiptPath = $rawImg;
                }
            } elseif ($rawImg !== 'images/gcash_qr.jpg' && !str_contains($rawImg, 'gcash_qr')) {
                // Already a valid path or web URL, ignore placeholder qr codes
                $receiptPath = $rawImg;
            }
        }

        $paymentMethod = $request->input('payment_method', 'Cash on Pickup');
        $paymentRef = trim($request->input('payment_reference') ?? '');
        $paymentStatus = ($paymentMethod === 'Cash on Pickup') ? 'Unpaid' : 'Pending Verification';

        // GCash Online Validation: Require either Reference Number OR Receipt Image
        if ($paymentMethod === 'GCash Online') {
            if (empty($paymentRef) && empty($receiptPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'For GCash Online, please provide at least one verification: either your GCash Reference Number OR upload a Receipt Screenshot.',
                ], 422);
            }
        }

        // Moderation Check: Block banned students from placing reservations
        $studentModCheck = \App\Models\Student::where('student_id', $validated['student_id'])->first();
        if ($studentModCheck && $studentModCheck->isBanned()) {
            return response()->json([
                'success' => false,
                'message' => 'Banned Account: Hindi ka pinapayagang mag-reserve dahil sa paglabag sa alituntunin.',
            ], 403);
        }

        // Idempotency / Anti-Spam Check:
        // Prevent duplicate reservations from rapid / spam clicking "Confirm and Generate Slip"
        $recentReservation = Reservation::where('student_id', $validated['student_id'])
            ->where('total_amount', $validated['total_amount'])
            ->where('created_at', '>=', now()->subSeconds(10))
            ->latest('id')
            ->first();

        if ($recentReservation) {
            return response()->json([
                'success' => true,
                'message' => 'Your reservation is already recorded in the queue!',
                'reservation' => $recentReservation,
                'is_duplicate' => true,
            ]);
        }

        // Generate unique Reference Code (e.g. ICS-2026-X941K)
        $refCode = 'ICS-' . date('Y') . '-' . strtoupper(Str::random(5));

        // Save into reservations table
        $reservation = Reservation::create([
            'ref_code'          => $refCode,
            'student_name'      => $validated['student_name'],
            'student_id'        => $validated['student_id'],
            'department'        => $validated['department'],
            'year_level'        => $validated['year_level'],
            'contact'           => $validated['contact'] ?? 'Student Account Verified',
            'pickup_date'       => $validated['pickup_date'] ?? date('Y-m-d', strtotime('+2 days')),
            'pickup_slot'       => $validated['pickup_slot'] ?? '10:30 AM - 12:30 PM (Batch 2 Midday)',
            'items'             => $validated['items'],
            'total_amount'      => $validated['total_amount'],
            'status'            => 'Pending',
            'payment_method'    => $paymentMethod,
            'payment_status'    => $paymentStatus,
            'payment_reference' => !empty($paymentRef) ? $paymentRef : null,
            'receipt_image'     => $receiptPath,
            'notes'             => $validated['notes'] ?? 'Online Reservation',
        ]);

        // Deduct available stock and increment reserved stock
        foreach ($validated['items'] as $item) {
            $itemId = $item['productId'] ?? $item['id'] ?? $item['item_code'] ?? 0;
            $prod = Product::where('item_code', $itemId)
                ->orWhere('id', $itemId)
                ->first();

            if ($prod) {
                $qty = intval($item['quantity'] ?? 1);
                $prod->current_stock = max(0, $prod->current_stock - $qty);
                $prod->units_reserved = ($prod->units_reserved ?? 0) + $qty;

                // Also deduct stock for the specific selected size (XS, S, M, L, etc.)
                if (is_array($prod->sizes) && isset($item['size']) && isset($prod->sizes[$item['size']])) {
                    $sizes = $prod->sizes;
                    $sizes[$item['size']] = max(0, $sizes[$item['size']] - $qty);
                    $prod->sizes = $sizes;
                }
                $prod->save();
            }
        }

        // Record in Audit Trail log with GCash details
        $auditPaymentInfo = $paymentMethod;
        if (!empty($paymentRef)) {
            $auditPaymentInfo .= " [Ref: {$paymentRef}]";
        }
        if (!empty($receiptPath)) {
            $auditPaymentInfo .= " [Receipt Attached]";
        }

        ActivityLog::record(
            'CREATE',
            "New reservation [{$refCode}] from {$validated['student_name']} ({$validated['student_id']}) with total PHP " . number_format($validated['total_amount'], 2) . " via {$auditPaymentInfo}",
            $validated['student_id'],
            $validated['student_name'],
            'Reservations'
        );

        return response()->json([
            'success' => true,
            'message' => 'Your reservation has been placed successfully!',
            'reservation' => $reservation,
        ]);
    }

    /**
     * ADMIN: Update status of Reservation (Pending -> Ready for Pickup -> Claimed)
     */
    public function updateReservationStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Ready for Pickup,Claimed,Cancelled',
        ]);

        $reservation = Reservation::findOrFail($id);
        $oldStatus = $reservation->status;
        $newStatus = $validated['status'];

        // Conflict prevention: If there is an unresolved support ticket for this reservation, block claiming/readying
        if (in_array($newStatus, ['Claimed', 'Ready for Pickup'])) {
            $activeTicket = SupportTicket::where('reservation_ref', $reservation->ref_code)
                ->whereIn('status', ['Open', 'In Progress'])
                ->first();

            if ($activeTicket) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot mark as {$newStatus}: This reservation has an active Helpdesk Support Ticket [{$activeTicket->ticket_code} - {$activeTicket->reason}]. Please resolve or address the ticket first to prevent conflicts.",
                ], 422);
            }
        }

        $reservation->status = $newStatus;
        if ($request->has('payment_status')) {
            $reservation->payment_status = $request->input('payment_status');
        } elseif ($newStatus === 'Claimed') {
            $reservation->payment_status = ($reservation->payment_method === 'Cash on Pickup') ? 'Paid on Pickup' : 'Verified';
        } elseif ($newStatus === 'Ready for Pickup' && $reservation->payment_method === 'GCash Online') {
            $reservation->payment_status = 'Verified';
        }

        // Set or clear physical pickup claim timestamp & releasing officer
        if ($newStatus === 'Claimed') {
            if (!$reservation->claimed_at) {
                $reservation->claimed_at = now();
            }
            $currentAdminName = session('student_user.name') ?? session('admin_user.name') ?? 'J. Derramas (ICS Officer)';
            $reservation->claimed_by = $request->input('claimed_by', $currentAdminName);
        } elseif ($oldStatus === 'Claimed' && $newStatus !== 'Claimed') {
            $reservation->claimed_at = null;
            $reservation->claimed_by = null;
        }

        $reservation->save();

        // If changed to 'Claimed': move item count from reserved to sold
        if ($oldStatus !== 'Claimed' && $newStatus === 'Claimed') {
            if (is_array($reservation->items)) {
                foreach ($reservation->items as $item) {
                    $prod = Product::where('item_code', $item['productId'] ?? '')
                        ->orWhere('id', $item['productId'] ?? 0)
                        ->first();
                    if ($prod) {
                        $qty = intval($item['quantity'] ?? 1);
                        $prod->units_reserved = max(0, ($prod->units_reserved ?? 0) - $qty);
                        $prod->units_sold = ($prod->units_sold ?? 0) + $qty;
                        $prod->save();
                    }
                }
            }
        }

        // If changed to 'Cancelled': return reserved quantity back to available stock
        if ($oldStatus !== 'Cancelled' && $newStatus === 'Cancelled') {
            if (is_array($reservation->items)) {
                foreach ($reservation->items as $item) {
                    $prod = Product::where('item_code', $item['productId'] ?? '')
                        ->orWhere('id', $item['productId'] ?? 0)
                        ->first();
                    if ($prod) {
                        $qty = intval($item['quantity'] ?? 1);
                        $prod->units_reserved = max(0, ($prod->units_reserved ?? 0) - $qty);
                        $prod->current_stock = ($prod->current_stock ?? 0) + $qty;

                        // Also restore size count
                        if (is_array($prod->sizes) && isset($item['size']) && isset($prod->sizes[$item['size']])) {
                            $sizes = $prod->sizes;
                            $sizes[$item['size']] = ($sizes[$item['size']] ?? 0) + $qty;
                            $prod->sizes = $sizes;
                        }

                        $prod->save();
                    }
                }
            }
        }

        // Record in Audit Trail log
        $operatorCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';
        $operatorName = session('student_user.name') ?? session('admin_user.name') ?? 'J. Derramas';

        if ($newStatus === 'Claimed') {
            // Detailed physical release log entry with item breakdown & timestamps
            $itemListSummary = [];
            if (is_array($reservation->items)) {
                foreach ($reservation->items as $it) {
                    $qty = $it['quantity'] ?? 1;
                    $itemName = $it['name'] ?? $it['productId'] ?? 'Item';
                    $size = isset($it['size']) && !empty($it['size']) ? " ({$it['size']})" : '';
                    $itemListSummary[] = "{$qty}x {$itemName}{$size}";
                }
            }
            $itemsText = !empty($itemListSummary) ? implode(', ', $itemListSummary) : 'Merchandise Items';
            $purchasedDateStr = $reservation->created_at ? $reservation->created_at->format('M d, Y h:i A') : 'N/A';
            $claimedDateStr = $reservation->claimed_at ? $reservation->claimed_at->format('M d, Y h:i A') : now()->format('M d, Y h:i A');

            ActivityLog::record(
                'CLAIM',
                "CLAIMED/RELEASED [{$reservation->ref_code}] to {$reservation->student_name} ({$reservation->student_id}). Purchased: {$purchasedDateStr} | Claimed: {$claimedDateStr} | Items: {$itemsText} | Total: ₱" . number_format($reservation->total_amount, 2) . " | Released By: {$reservation->claimed_by}",
                $operatorCode,
                $operatorName,
                'Releases & Claiming'
            );
        } else {
            ActivityLog::record(
                'UPDATE',
                "Updated reservation [{$reservation->ref_code}] status: '{$oldStatus}' -> '{$newStatus}'",
                $operatorCode,
                $operatorName,
                'Reservations'
            );
        }

        return response()->json([
            'success' => true,
            'message' => "Reservation status updated to {$newStatus}",
            'reservation' => $reservation,
        ]);
    }

    /**
     * ADMIN: Permanently Delete Reservation from database and UI
     */
    public function destroyReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $refCode = $reservation->ref_code;
        $status = $reservation->status;

        // If not already Claimed or Cancelled, restore reserved units back to available stock
        if ($status !== 'Claimed' && $status !== 'Cancelled') {
            if (is_array($reservation->items)) {
                foreach ($reservation->items as $item) {
                    $prod = Product::where('item_code', $item['productId'] ?? '')
                        ->orWhere('id', $item['productId'] ?? 0)
                        ->first();
                    if ($prod) {
                        $qty = intval($item['quantity'] ?? 1);
                        $prod->units_reserved = max(0, ($prod->units_reserved ?? 0) - $qty);
                        $prod->current_stock = ($prod->current_stock ?? 0) + $qty;
                        if (is_array($prod->sizes) && isset($item['size']) && isset($prod->sizes[$item['size']])) {
                            $sizes = $prod->sizes;
                            $sizes[$item['size']] = ($sizes[$item['size']] ?? 0) + $qty;
                            $prod->sizes = $sizes;
                        }
                        $prod->save();
                    }
                }
            }
        }

        // Delete any related support tickets
        SupportTicket::where('reservation_ref', $refCode)->delete();

        // Delete the reservation from database
        $reservation->delete();

        // Record in Audit Trail log
        $operatorCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';
        $operatorName = session('student_user.name') ?? session('admin_user.name') ?? 'J. Derramas';
        ActivityLog::record(
            'DELETE',
            "Permanently deleted reservation [{$refCode}] ({$status}) from database records",
            $operatorCode,
            $operatorName,
            'Reservations'
        );

        return response()->json([
            'success' => true,
            'message' => "Reservation [{$refCode}] permanently deleted from database.",
            'deleted_id' => $id,
            'ref_code' => $refCode
        ]);
    }

    /**
     * ADMIN: Bulk Delete Selected Reservations (e.g. from Claimed Ledger)
     */
    public function bulkDeleteReservations(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids) || !is_array($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No reservations selected for deletion.'
            ], 422);
        }

        $deletedCount = 0;
        $deletedRefs = [];

        foreach ($ids as $id) {
            $reservation = Reservation::find($id);
            if (!$reservation) continue;

            $refCode = $reservation->ref_code;
            $status = $reservation->status;

            // If not already Claimed or Cancelled, restore reserved units back to stock
            if ($status !== 'Claimed' && $status !== 'Cancelled') {
                if (is_array($reservation->items)) {
                    foreach ($reservation->items as $item) {
                        $prod = Product::where('item_code', $item['productId'] ?? '')
                            ->orWhere('id', $item['productId'] ?? 0)
                            ->first();
                        if ($prod) {
                            $qty = intval($item['quantity'] ?? 1);
                            $prod->units_reserved = max(0, ($prod->units_reserved ?? 0) - $qty);
                            $prod->current_stock = ($prod->current_stock ?? 0) + $qty;
                            if (is_array($prod->sizes) && isset($item['size']) && isset($prod->sizes[$item['size']])) {
                                $sizes = $prod->sizes;
                                $sizes[$item['size']] = ($sizes[$item['size']] ?? 0) + $qty;
                                $prod->sizes = $sizes;
                            }
                            $prod->save();
                        }
                    }
                }
            }

            // Delete support tickets
            SupportTicket::where('reservation_ref', $refCode)->delete();

            $reservation->delete();
            $deletedCount++;
            $deletedRefs[] = $refCode;
        }

        $operatorCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';
        $operatorName = session('student_user.name') ?? session('admin_user.name') ?? 'J. Derramas';
        ActivityLog::record(
            'DELETE',
            "Bulk deleted {$deletedCount} reservation(s) [" . implode(', ', array_slice($deletedRefs, 0, 5)) . ($deletedCount > 5 ? '...' : '') . "] from database records",
            $operatorCode,
            $operatorName,
            'Reservations'
        );

        return response()->json([
            'success' => true,
            'message' => "Successfully deleted {$deletedCount} reservation(s).",
            'deleted_count' => $deletedCount,
            'deleted_ids' => $ids
        ]);
    }

    /**
     * ADMIN: Delete All Claimed Reservations from Release Ledger
     */
    public function deleteAllClaimedReservations(Request $request)
    {
        $claimed = Reservation::where('status', 'Claimed')->get();
        $count = $claimed->count();

        if ($count === 0) {
            return response()->json([
                'success' => true,
                'message' => 'No claimed reservations to delete.',
                'deleted_count' => 0
            ]);
        }

        foreach ($claimed as $r) {
            SupportTicket::where('reservation_ref', $r->ref_code)->delete();
            $r->delete();
        }

        $operatorCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';
        $operatorName = session('student_user.name') ?? session('admin_user.name') ?? 'J. Derramas';
        ActivityLog::record(
            'DELETE',
            "Deleted all {$count} claimed reservation(s) from release ledger.",
            $operatorCode,
            $operatorName,
            'Claimed Ledger'
        );

        return response()->json([
            'success' => true,
            'message' => "Successfully deleted all {$count} claimed reservation(s).",
            'deleted_count' => $count
        ]);
    }


    /**
     * ADMIN: Add new Merchandise Item (supports picture upload)
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'item_code'    => 'required|string|unique:products,item_code|max:50',
            'name'         => 'required|string|max:255',
            'category'     => 'required|string|max:50',
            'dept'         => 'nullable|string|max:50',
            'gender'       => 'nullable|string|max:50',
            'price'        => 'required|numeric|min:0',
            'material'     => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'sizes'        => 'nullable',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_preset' => 'nullable|string',
        ]);

        $imagePath = 'images/male_polo.jpg'; // default image path

        // Handle file upload if an image was uploaded from local computer
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $fileName);
            $imagePath = 'uploads/products/' . $fileName;
        } elseif (!empty($validated['image_preset'])) {
            $imagePath = $validated['image_preset'];
        }

        // Sizes inventory breakdown
        $sizes = ['XS' => 10, 'S' => 20, 'M' => 30, 'L' => 25, 'XL' => 15, '2XL' => 5, '3XL' => 2];
        if (!empty($validated['sizes'])) {
            if (is_array($validated['sizes'])) {
                $sizes = $validated['sizes'];
            } elseif (is_string($validated['sizes'])) {
                $decoded = json_decode($validated['sizes'], true);
                if (is_array($decoded)) $sizes = $decoded;
            }
        }

        $totalStock = array_sum($sizes);

        $product = Product::create([
            'item_code'      => strtoupper(trim($validated['item_code'])),
            'name'           => $validated['name'],
            'category'       => $validated['category'],
            'dept'           => $validated['dept'] ?? 'all',
            'gender'         => $validated['gender'] ?? 'Unisex',
            'price'          => $validated['price'],
            'material'       => $validated['material'] ?? '',
            'description'    => $validated['description'] ?? '',
            'image_path'     => $imagePath,
            'sizes'          => $sizes,
            'initial_stock'  => $totalStock,
            'current_stock'  => $totalStock,
            'units_sold'     => 0,
            'units_reserved' => 0,
            'is_active'      => true,
        ]);

        $operatorCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';
        $operatorName = session('student_user.name') ?? session('admin_user.name') ?? 'J. Derramas';

        ActivityLog::record(
            'CREATE',
            "Added new merchandise item: '{$product->name}' [{$product->item_code}] with initial stock: {$totalStock}",
            $operatorCode,
            $operatorName,
            'Information Management'
        );

        return response()->json([
            'success' => true,
            'message' => 'Merchandise item created successfully!',
            'product' => $product,
        ]);
    }

    /**
     * ADMIN: Update Product details and replace image (Edit Photo & Details)
     */
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|string|max:50',
            'dept'         => 'nullable|string|max:50',
            'gender'       => 'nullable|string|max:50',
            'price'        => 'required|numeric|min:0',
            'material'     => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'sizes'        => 'nullable',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_preset' => 'nullable|string',
        ]);

        // Replace picture if a new image was uploaded
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $fileName);
            $product->image_path = 'uploads/products/' . $fileName;
        } elseif (!empty($validated['image_preset'])) {
            $product->image_path = $validated['image_preset'];
        }

        $product->name = $validated['name'];
        $product->category = $validated['category'];
        if (isset($validated['dept'])) $product->dept = $validated['dept'];
        if (isset($validated['gender'])) $product->gender = $validated['gender'];
        $product->price = $validated['price'];
        if (isset($validated['material'])) $product->material = $validated['material'];
        if (isset($validated['description'])) $product->description = $validated['description'];

        // Update sizes inventory breakdown if submitted
        if (!empty($validated['sizes'])) {
            if (is_array($validated['sizes'])) {
                $product->sizes = $validated['sizes'];
                $product->current_stock = array_sum($validated['sizes']);
            } elseif (is_string($validated['sizes'])) {
                $decoded = json_decode($validated['sizes'], true);
                if (is_array($decoded)) {
                    $product->sizes = $decoded;
                    $product->current_stock = array_sum($decoded);
                }
            }
        }

        $product->save();

        $operatorCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';
        $operatorName = session('student_user.name') ?? session('admin_user.name') ?? 'J. Derramas';

        ActivityLog::record(
            'UPDATE',
            "Updated details and photo for item: '{$product->name}' [{$product->item_code}]",
            $operatorCode,
            $operatorName,
            'Information Management'
        );

        return response()->json([
            'success' => true,
            'message' => 'Product and photo updated successfully!',
            'product' => $product,
        ]);
    }

    /**
     * ADMIN: Delete Product
     */
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $name = $product->name;
        $code = $product->item_code;
        $product->delete();

        $operatorCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';
        $operatorName = session('student_user.name') ?? session('admin_user.name') ?? 'J. Derramas';

        ActivityLog::record(
            'DELETE',
            "Deleted merchandise item: '{$name}' [{$code}]",
            $operatorCode,
            $operatorName,
            'Information Management'
        );

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.',
        ]);
    }

    /**
     * ADMIN: Add New User (User Management CRUD)
     * Strictly verifies email against the OnePass student database
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'user_code'  => 'required|string|unique:system_users,user_code|max:50',
            'name'       => 'nullable|string|max:255',
            'email'      => 'required|email|unique:system_users,email|max:255',
            'role'       => 'required|string|max:50',
            'department' => 'nullable|string|max:100',
        ]);

        $searchEmail = strtolower(trim($validated['email']));

        // Database Guard: Verify that the email exists in the verified students database
        $student = \App\Models\Student::whereRaw('LOWER(TRIM(email)) = ?', [$searchEmail])->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => "Hindi mahanap ang email [{$validated['email']}] sa database. Kailangang rehistrado o nakapag-login na ang estudyante sa OnePass gamit ang exactong email na ito bago mabigyan ng admin access.",
            ], 422);
        }

        // Auto-match exact student attributes if name or dept wasn't provided
        $userName = !empty($validated['name']) ? trim($validated['name']) : $student->name;
        $userDept = !empty($validated['department']) ? trim($validated['department']) : ($student->department ?: 'AIS');

        $user = SystemUser::create([
            'user_code'  => strtoupper(trim($validated['user_code'])),
            'name'       => $userName,
            'email'      => $searchEmail,
            'role'       => $validated['role'],
            'department' => $userDept,
            'status'     => 'Active',
        ]);

        $adminName = session('student_user.name') ?? 'Admin';
        $adminCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';

        ActivityLog::record(
            'CREATE',
            "Registered system user account: '{$user->name}' ({$user->role}) [{$user->user_code}] linked to OnePass email [{$user->email}]",
            $adminCode,
            $adminName,
            'User Management'
        );

        return response()->json([
            'success' => true,
            'message' => "User account matagumpay na na-create para kay {$user->name} ({$user->email})!",
            'user' => $user,
        ]);
    }

    /**
     * ADMIN: Update User
     * Strictly verifies email against the OnePass student database
     */
    public function updateUser(Request $request, $id)
    {
        $user = SystemUser::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'nullable|string|max:255',
            'email'      => 'required|email|max:255|unique:system_users,email,' . $id,
            'role'       => 'required|string|max:50',
            'department' => 'nullable|string|max:100',
            'status'     => 'required|in:Active,Inactive',
        ]);

        $searchEmail = strtolower(trim($validated['email']));

        // Database Guard: Ensure updated email exists in the student database
        $student = \App\Models\Student::whereRaw('LOWER(TRIM(email)) = ?', [$searchEmail])->first();
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => "Hindi mahanap ang email [{$validated['email']}] sa database. Kailangang rehistrado sa OnePass ang account na ito.",
            ], 422);
        }

        $validated['email'] = $searchEmail;
        if (empty($validated['name'])) {
            $validated['name'] = $student->name;
        }

        $user->update($validated);

        $adminName = session('student_user.name') ?? 'Admin';
        $adminCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';

        ActivityLog::record(
            'UPDATE',
            "Updated account info for '{$user->name}' [{$user->user_code}]",
            $adminCode,
            $adminName,
            'User Management'
        );

        return response()->json([
            'success' => true,
            'message' => 'User account updated successfully!',
            'user' => $user,
        ]);
    }

    /**
     * ADMIN: Delete User
     */
    public function deleteUser($id)
    {
        $user = SystemUser::findOrFail($id);
        $name = $user->name;
        $code = $user->user_code;
        $user->delete();

        $adminName = session('student_user.name') ?? session('admin_user.name') ?? 'Admin';
        $adminCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';

        ActivityLog::record(
            'DELETE',
            "Deleted user account: '{$name}' [{$code}]",
            $adminCode,
            $adminName,
            'User Management'
        );

        return response()->json([
            'success' => true,
            'message' => 'User account deleted successfully.',
        ]);
    }

    /**
     * Helper: Extract student buyers for a specific product.
     */
    public function getBuyersForProduct($product, $reservations = null)
    {
        if ($reservations === null) {
            $reservations = Reservation::where('status', '!=', 'Cancelled')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $buyers = [];
        foreach ($reservations as $r) {
            if (!is_array($r->items)) continue;
            foreach ($r->items as $it) {
                $itId = $it['productId'] ?? $it['id'] ?? null;
                $itName = $it['name'] ?? $it['productName'] ?? null;

                $match = false;
                if ($itId && ($itId == $product->id || strtolower((string)$itId) === strtolower((string)$product->item_code))) {
                    $match = true;
                } elseif ($itName && strtolower(trim((string)$itName)) === strtolower(trim((string)$product->name))) {
                    $match = true;
                }

                if ($match) {
                    $qty = intval($it['quantity'] ?? 1);
                    $price = floatval($it['price'] ?? $product->price);
                    $buyers[] = [
                        'reservation_id' => $r->id,
                        'ref_code'       => $r->ref_code,
                        'student_id'     => $r->student_id,
                        'student_name'   => $r->student_name,
                        'department'     => $r->department ?? 'ICS',
                        'year_level'     => $r->year_level ?? 'N/A',
                        'contact'        => $r->contact ?? 'N/A',
                        'quantity'       => $qty,
                        'size'           => $it['size'] ?? 'Standard',
                        'unit_price'     => $price,
                        'subtotal'       => $qty * $price,
                        'ordered_at'     => $r->created_at ? $r->created_at->format('Y-m-d h:i A') : 'N/A',
                        'ordered_display'=> $r->created_at ? $r->created_at->format('M d, Y h:i A') : 'N/A',
                        'claimed_at'     => $r->claimed_at ? $r->claimed_at->format('Y-m-d h:i A') : ($r->status === 'Claimed' && $r->updated_at ? $r->updated_at->format('Y-m-d h:i A') : 'Pending Pickup'),
                        'claimed_display'=> $r->claimed_at ? $r->claimed_at->format('M d, Y h:i A') : ($r->status === 'Claimed' && $r->updated_at ? $r->updated_at->format('M d, Y h:i A') : 'Pending Pickup'),
                        'status'         => $r->status,
                        'payment_method' => $r->payment_method ?? 'Cash on Pickup',
                        'payment_status' => $r->payment_status ?? 'Paid',
                        'claimed_by'     => $r->claimed_by ?? ($r->status === 'Claimed' ? 'Admin Officer' : 'N/A'),
                    ];
                }
            }
        }
        return $buyers;
    }

    /**
     * REPORTS: Download Sales vs Stock CSV file
     * Supports:
     * - Single Item Download: ?product_id=X (includes inventory summary + full buyer breakdown)
     * - Selected Items Download: ?product_ids=1,2,3
     * - All Merchandise Master Download (default)
     */
    public function exportReportCsv(Request $request)
    {
        $productId = $request->query('product_id');
        $productIds = $request->query('product_ids');

        $adminCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';
        $adminName = session('student_user.name') ?? session('admin_user.name') ?? 'Admin';

        // 1. Single Product Export ("makikita don kung ilan bumili or ano")
        if (!empty($productId) && $productId !== 'all') {
            $product = Product::where('id', $productId)
                ->orWhere('item_code', $productId)
                ->firstOrFail();

            $buyers = $this->getBuyersForProduct($product);
            $initial = $product->initial_stock > 0 ? $product->initial_stock : ($product->current_stock + $product->units_sold + $product->units_reserved);
            $status = $product->current_stock <= 0 ? 'Out of Stock' : ($product->current_stock < 20 ? 'Low Stock' : 'In Stock');
            $revenue = $product->units_sold * $product->price;

            $cleanCode = preg_replace('/[^A-Za-z0-9_-]/', '_', $product->item_code);
            $filename = "ICS_Sales_Report_{$cleanCode}_" . date('Ymd_His') . '.csv';

            $headers = [
                'Content-Type'        => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                'Pragma'              => 'no-cache',
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Expires'             => '0',
            ];

            $callback = function () use ($product, $buyers, $initial, $status, $revenue) {
                $handle = fopen('php://output', 'w');
                // Write UTF-8 BOM for Microsoft Excel Philippine Peso (₱) symbol support
                fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

                fputcsv($handle, ['========================================================================================']);
                fputcsv($handle, ['NAVOTAS POLYTECHNIC COLLEGE - INSTITUTE OF COMPUTER STUDIES']);
                fputcsv($handle, ['OFFICIAL SINGLE PRODUCT SALES & STUDENT BUYERS DISTRIBUTION AUDIT REPORT']);
                fputcsv($handle, ['Report Generated: ' . date('Y-m-d h:i:s A')]);
                fputcsv($handle, ['========================================================================================']);
                fputcsv($handle, []);

                // 1. Inventory & Financial Specifications
                fputcsv($handle, ['[1. PRODUCT INVENTORY & SALES SPECIFICATIONS]']);
                fputcsv($handle, ['Item Code', 'Product Name', 'Category', 'Unit Price (PHP)', 'Initial Stock', 'Claimed (Sold)', 'Reserved', 'Available Stock', 'Total Revenue (PHP)', 'Stock Status']);
                fputcsv($handle, [
                    $product->item_code,
                    $product->name,
                    strtoupper($product->category),
                    number_format($product->price, 2),
                    $initial,
                    $product->units_sold,
                    $product->units_reserved,
                    $product->current_stock,
                    number_format($revenue, 2),
                    $status
                ]);
                fputcsv($handle, []);

                // 2. Buyer Summary Metrics ("Makikita don kung ilan bumili")
                $totalOrderedUnits = array_sum(array_column($buyers, 'quantity'));
                $totalOrderValue = array_sum(array_column($buyers, 'subtotal'));

                fputcsv($handle, ['[2. BUYER SUMMARY METRICS - ILAN ANG BUMILI]']);
                fputcsv($handle, ['Total Student Orders / Purchases Registered:', count($buyers)]);
                fputcsv($handle, ['Total Units Sold / Claimed (Physical Pickups):', $product->units_sold]);
                fputcsv($handle, ['Total Units Currently Reserved (Pending Pickup):', $product->units_reserved]);
                fputcsv($handle, ['Total Units Ordered Across All Statuses:', $totalOrderedUnits]);
                fputcsv($handle, ['Total Remitted Revenue (PHP):', number_format($revenue, 2)]);
                fputcsv($handle, []);

                // 3. Official Buyers Ledger ("Sinu-sino at Ilan ang Bumili")
                fputcsv($handle, ['[3. OFFICIAL STUDENT BUYERS & DISTRIBUTION LEDGER]']);
                fputcsv($handle, [
                    '#',
                    'Student Number (ID)',
                    'Student Buyer Name',
                    'Department / Program',
                    'Year Level',
                    'Contact Number',
                    'Quantity Purchased',
                    'Size',
                    'Unit Price (PHP)',
                    'Subtotal Amount (PHP)',
                    'Order Ref Code',
                    'Date Ordered',
                    'Date Claimed (Pickup)',
                    'Order Status',
                    'Payment Method',
                    'Released By'
                ]);

                if (empty($buyers)) {
                    fputcsv($handle, ['No student orders recorded for this merchandise item yet.']);
                } else {
                    foreach ($buyers as $i => $b) {
                        fputcsv($handle, [
                            $i + 1,
                            $b['student_id'],
                            $b['student_name'],
                            $b['department'],
                            $b['year_level'],
                            $b['contact'],
                            $b['quantity'],
                            $b['size'],
                            number_format($b['unit_price'], 2),
                            number_format($b['subtotal'], 2),
                            $b['ref_code'],
                            $b['ordered_at'],
                            $b['claimed_at'],
                            $b['status'],
                            $b['payment_method'],
                            $b['claimed_by']
                        ]);
                    }
                }

                fputcsv($handle, []);
                fputcsv($handle, ['TOTAL BUYERS RECORDED:', count($buyers)]);
                fputcsv($handle, ['TOTAL UNITS ORDERED:', $totalOrderedUnits]);
                fputcsv($handle, ['TOTAL SALES VALUE (PHP):', number_format($totalOrderValue, 2)]);

                fclose($handle);
            };

            ActivityLog::record(
                'READ',
                "Downloaded Single Product Sales & Buyers CSV Report for [{$product->name} ({$product->item_code})]",
                $adminCode,
                $adminName,
                'Reports'
            );

            return response()->stream($callback, 200, $headers);
        }

        // 2. Selected Products or All Products
        if (!empty($productIds)) {
            $ids = is_array($productIds) ? $productIds : explode(',', $productIds);
            $products = Product::whereIn('id', $ids)->get();
        } else {
            $products = Product::all();
        }

        $allReservations = Reservation::where('status', '!=', 'Cancelled')
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'ICS_Sales_vs_Stock_' . (!empty($productIds) ? 'Selected_Items_' : 'Master_Report_') . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $self = $this;
        $callback = function () use ($products, $allReservations, $self) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['========================================================================================']);
            fputcsv($handle, ['NAVOTAS POLYTECHNIC COLLEGE - INSTITUTE OF COMPUTER STUDIES']);
            fputcsv($handle, ['OFFICIAL MERCHANDISE SALES VS STOCK & BUYERS AUDIT REPORT']);
            fputcsv($handle, ['Report Generated: ' . date('Y-m-d h:i:s A')]);
            fputcsv($handle, ['========================================================================================']);
            fputcsv($handle, []);

            // Summary Table
            fputcsv($handle, ['[1. MERCHANDISE SALES & STOCK INVENTORY MASTER SUMMARY]']);
            fputcsv($handle, ['Item Code', 'Product Name', 'Category', 'Price (PHP)', 'Initial Stock', 'Claimed (Sold)', 'Reserved', 'Available Stock', 'Total Revenue (PHP)', 'Stock Status']);

            $totalInitial = 0;
            $totalSold = 0;
            $totalReserved = 0;
            $totalStock = 0;
            $totalRev = 0;

            foreach ($products as $p) {
                $initial = $p->initial_stock > 0 ? $p->initial_stock : ($p->current_stock + $p->units_sold + $p->units_reserved);
                $status = $p->current_stock <= 0 ? 'Out of Stock' : ($p->current_stock < 20 ? 'Low Stock' : 'In Stock');
                $rev = $p->units_sold * $p->price;

                $totalInitial += $initial;
                $totalSold += $p->units_sold;
                $totalReserved += $p->units_reserved;
                $totalStock += $p->current_stock;
                $totalRev += $rev;

                fputcsv($handle, [
                    $p->item_code,
                    $p->name,
                    strtoupper($p->category),
                    number_format($p->price, 2),
                    $initial,
                    $p->units_sold,
                    $p->units_reserved,
                    $p->current_stock,
                    number_format($rev, 2),
                    $status
                ]);
            }

            fputcsv($handle, [
                'TOTALS',
                count($products) . ' Items',
                '',
                '',
                $totalInitial,
                $totalSold,
                $totalReserved,
                $totalStock,
                number_format($totalRev, 2),
                '100% Audited'
            ]);
            fputcsv($handle, []);

            // Breakdown by Product
            fputcsv($handle, ['[2. DETAILED STUDENT BUYERS BREAKDOWN BY ITEM]']);
            fputcsv($handle, ['Product Code', 'Product Name', 'Student ID', 'Student Name', 'Program / Dept', 'Qty', 'Size', 'Subtotal (PHP)', 'Status', 'Date Ordered', 'Date Claimed', 'Claim Ref']);

            foreach ($products as $p) {
                $buyers = $self->getBuyersForProduct($p, $allReservations);
                if (empty($buyers)) {
                    fputcsv($handle, [$p->item_code, $p->name, 'NO BUYERS YET', '', '', '', '', '', '', '', '', '']);
                } else {
                    foreach ($buyers as $b) {
                        fputcsv($handle, [
                            $p->item_code,
                            $p->name,
                            $b['student_id'],
                            $b['student_name'],
                            $b['department'] . ' - ' . $b['year_level'],
                            $b['quantity'],
                            $b['size'],
                            number_format($b['subtotal'], 2),
                            $b['status'],
                            $b['ordered_at'],
                            $b['claimed_at'],
                            $b['ref_code']
                        ]);
                    }
                }
            }

            fclose($handle);
        };

        ActivityLog::record(
            'READ',
            'Downloaded Merchandise Sales vs Stock CSV Report (' . count($products) . ' products)',
            $adminCode,
            $adminName,
            'Reports'
        );

        return response()->stream($callback, 200, $headers);
    }

    /**
     * REPORTS: Export Official Merchandise Sales & Distribution as Printable PDF Document
     * Formatted with institutional header, single item or master breakdown, student buyer records, and certifying signatures.
     */
    public function exportReportPdf(Request $request)
    {
        $productId = $request->query('product_id');
        $productIds = $request->query('product_ids');

        $operatorName = session('student_user.name') ?? session('admin_user.name') ?? 'J. Derramas';
        $operatorCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';

        // 1. Single Product View ("makikita don kung ilan bumili or ano")
        if (!empty($productId) && $productId !== 'all') {
            $product = Product::where('id', $productId)
                ->orWhere('item_code', $productId)
                ->firstOrFail();

            $buyers = $this->getBuyersForProduct($product);
            $initial = $product->initial_stock > 0 ? $product->initial_stock : ($product->current_stock + $product->units_sold + $product->units_reserved);

            $metrics = [
                'total_buyers'  => count($buyers),
                'total_ordered' => array_sum(array_column($buyers, 'quantity')),
                'claimed_units' => $product->units_sold,
                'pending_units' => $product->units_reserved,
                'revenue'       => $product->units_sold * $product->price,
                'gross_sales'   => array_sum(array_column($buyers, 'subtotal')),
                'initial_stock' => $initial,
            ];

            ActivityLog::record(
                'READ',
                "Generated and viewed Single Product Sales & Buyers PDF Report for [{$product->name} ({$product->item_code})]",
                $operatorCode,
                $operatorName,
                'Reports'
            );

            $isSingle = true;
            $pageTitle = "Sales & Buyers Report - {$product->name}";
            $reportTitle = "Official Product Sales & Student Distribution Report";

            return view('reports.sales_pdf', compact('product', 'buyers', 'metrics', 'operatorName', 'operatorCode', 'isSingle', 'pageTitle', 'reportTitle'));
        }

        // 2. Selected Products or All Products View
        if (!empty($productIds)) {
            $ids = is_array($productIds) ? $productIds : explode(',', $productIds);
            $products = Product::whereIn('id', $ids)->get();
        } else {
            $products = Product::where('is_active', true)->orderBy('id', 'asc')->get();
        }

        $allReservations = Reservation::where('status', '!=', 'Cancelled')
            ->orderBy('created_at', 'desc')
            ->get();

        $salesVsStock = [];
        $totalInitialStock = 0;
        $totalSoldUnits = 0;
        $totalReservedUnits = 0;
        $totalStockUnits = 0;
        $totalRevenue = 0;

        foreach ($products as $p) {
            $initial = $p->initial_stock > 0 ? $p->initial_stock : ($p->current_stock + $p->units_sold + $p->units_reserved);
            $statusText = $p->current_stock <= 0 ? 'Out of Stock' : ($p->current_stock < 20 ? 'Low Stock' : 'In Stock');
            $rev = $p->units_sold * $p->price;

            $totalInitialStock += $initial;
            $totalSoldUnits += $p->units_sold;
            $totalReservedUnits += $p->units_reserved;
            $totalStockUnits += $p->current_stock;
            $totalRevenue += $rev;

            $salesVsStock[] = [
                'id'            => $p->id,
                'item_code'     => $p->item_code,
                'name'          => $p->name,
                'category'      => $p->category,
                'price'         => $p->price,
                'initial_stock' => $initial,
                'current_stock' => $p->current_stock,
                'units_sold'    => $p->units_sold,
                'units_reserved' => $p->units_reserved,
                'revenue'       => $rev,
                'status'        => $statusText,
            ];
        }

        ActivityLog::record(
            'READ',
            'Generated and viewed Master Sales vs Stock PDF Report (' . count($products) . ' products)',
            $operatorCode,
            $operatorName,
            'Reports'
        );

        $isSingle = false;
        $pageTitle = 'Master Merchandise Sales vs Stock Report';
        $reportTitle = 'Official Master Sales vs Stock Inventory & Distribution Report';

        return view('reports.sales_pdf', compact(
            'products',
            'salesVsStock',
            'operatorName',
            'operatorCode',
            'isSingle',
            'pageTitle',
            'reportTitle',
            'totalInitialStock',
            'totalSoldUnits',
            'totalReservedUnits',
            'totalStockUnits',
            'totalRevenue'
        ));
    }

    /**
     * API: Retrieve official Claimed orders and physical pickup release logs.
     * Filterable by search term (ref_code, student_name, student_id, contact).
     */
    public function getClaimedLogs(Request $request)
    {
        $query = Reservation::where('status', 'Claimed');

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('ref_code', 'LIKE', "%{$s}%")
                  ->orWhere('student_name', 'LIKE', "%{$s}%")
                  ->orWhere('student_id', 'LIKE', "%{$s}%")
                  ->orWhere('contact', 'LIKE', "%{$s}%");
            });
        }

        $claimed = $query->orderBy('claimed_at', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count'   => $claimed->count(),
            'logs'    => $claimed->map(function ($r) {
                $itemStrings = [];
                if (is_array($r->items)) {
                    foreach ($r->items as $it) {
                        $qty = $it['quantity'] ?? 1;
                        $name = $it['name'] ?? $it['productId'] ?? 'Item';
                        $size = isset($it['size']) && !empty($it['size']) ? " ({$it['size']})" : '';
                        $itemStrings[] = "{$qty}x {$name}{$size}";
                    }
                }

                return [
                    'id'                => $r->id,
                    'ref_code'          => $r->ref_code,
                    'student_name'      => $r->student_name,
                    'student_id'        => $r->student_id,
                    'department'        => $r->department,
                    'year_level'        => $r->year_level,
                    'contact'           => $r->contact,
                    'items'             => $r->items,
                    'items_summary'     => implode(', ', $itemStrings),
                    'total_amount'      => $r->total_amount,
                    'payment_method'    => $r->payment_method,
                    'payment_status'    => $r->payment_status,
                    'payment_reference' => $r->payment_reference,
                    'purchased_at'      => $r->created_at ? $r->created_at->format('Y-m-d H:i:s') : null,
                    'purchased_display' => $r->created_at ? $r->created_at->format('M d, Y h:i A') : 'N/A',
                    'claimed_at'        => $r->claimed_at ? $r->claimed_at->format('Y-m-d H:i:s') : ($r->updated_at ? $r->updated_at->format('Y-m-d H:i:s') : null),
                    'claimed_display'   => $r->claimed_at ? $r->claimed_at->format('M d, Y h:i A') : ($r->updated_at ? $r->updated_at->format('M d, Y h:i A') : 'N/A'),
                    'claimed_by'        => $r->claimed_by ?? 'J. Derramas (ICS Officer)',
                ];
            }),
        ]);
    }

    /**
     * REPORTS: Export Official Claimed Releases & Pickup Logsheet (CSV)
     * Provides an unalterable digital audit ledger to resolve disputes against physical sign-off sheets or manual spreadsheets.
     */
    public function exportClaimedLedgerCsv()
    {
        $claimed = Reservation::where('status', 'Claimed')
            ->orderBy('claimed_at', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        $filename = 'ICS_Claimed_Releases_Logsheet_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($claimed) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM so Microsoft Excel correctly displays Philippine Peso (₱) and accents
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // CSV Header Row (Highlighting Student Number, Name, Items, Price, and Date/Time)
            fputcsv($handle, [
                'Student Number (Student ID)',
                'Student Buyer Name',
                'Items Purchased (Name & Sizes)',
                'Total Price (PHP)',
                'Date & Time Purchased (Ordered)',
                'Date & Time Claimed (Released)',
                'Claim Reference Code',
                'Department / Program',
                'Year Level',
                'Contact Number',
                'Payment Method',
                'Payment Status',
                'Released By (Officer / Admin)'
            ]);

            foreach ($claimed as $r) {
                // Format item breakdown string
                $itemStrings = [];
                if (is_array($r->items)) {
                    foreach ($r->items as $it) {
                        $qty = $it['quantity'] ?? 1;
                        $name = $it['name'] ?? $it['productName'] ?? $it['productId'] ?? 'Item';
                        $size = isset($it['size']) && !empty($it['size']) ? " [Size: {$it['size']}]" : '';
                        $price = isset($it['price']) ? " @ PHP " . number_format($it['price'], 2) : '';
                        $itemStrings[] = "{$qty}x {$name}{$size}{$price}";
                    }
                }
                $itemsBreakdown = !empty($itemStrings) ? implode('; ', $itemStrings) : 'N/A';

                $purchasedAt = $r->created_at ? $r->created_at->format('Y-m-d h:i:s A') : 'N/A';
                $claimedAt = $r->claimed_at ? $r->claimed_at->format('Y-m-d h:i:s A') : ($r->updated_at ? $r->updated_at->format('Y-m-d h:i:s A') : 'N/A');
                $releasedBy = $r->claimed_by ?? 'J. Derramas (ICS Officer)';

                fputcsv($handle, [
                    $r->student_id,
                    $r->student_name,
                    $itemsBreakdown,
                    number_format($r->total_amount, 2, '.', ''),
                    $purchasedAt,
                    $claimedAt,
                    $r->ref_code,
                    $r->department ?? 'ICS',
                    $r->year_level ?? 'N/A',
                    $r->contact ?? 'N/A',
                    $r->payment_method ?? 'Cash on Pickup',
                    $r->payment_status ?? 'Paid',
                    $releasedBy
                ]);
            }

            fclose($handle);
        };

        $adminCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';
        $adminName = session('student_user.name') ?? session('admin_user.name') ?? 'Admin Officer';

        ActivityLog::record(
            'READ',
            'Downloaded Official Claimed Releases & Pickup Logsheet (CSV)',
            $adminCode,
            $adminName,
            'Reports & Releases'
        );

        return response()->stream($callback, 200, $headers);
    }

    /**
     * REPORTS: Export Official Claimed Releases & Distribution Ledger as Printable PDF Document
     * Formatted with institutional header, student numbers, item breakdown, prices, dual timestamps, and certifying signatures.
     */
    public function exportClaimedPdf(Request $request)
    {
        $claimed = Reservation::where('status', 'Claimed')
            ->orderBy('claimed_at', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        $operatorName = session('student_user.name') ?? session('admin_user.name') ?? 'J. Derramas';
        $operatorCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';

        ActivityLog::record(
            'READ',
            'Generated and viewed Official Claimed Releases PDF & Distribution Report',
            $operatorCode,
            $operatorName,
            'Reports & Releases'
        );

        $totalRevenue = $claimed->sum('total_amount');
        $totalItems = 0;
        foreach ($claimed as $r) {
            if (is_array($r->items)) {
                foreach ($r->items as $it) {
                    $totalItems += intval($it['quantity'] ?? 1);
                }
            }
        }

        return view('reports.claimed_pdf', compact('claimed', 'operatorName', 'operatorCode', 'totalRevenue', 'totalItems'));
    }

    // =========================================================================
    // MODULE: SUPPORT TICKETS & CHAT HELPDESK (STUDENT & ADMIN)
    // =========================================================================

    /**
     * API: Get support tickets.
     * Enforces privacy: Students can only view their own tickets.
     */
    public function getSupportTickets(Request $request)
    {
        $query = SupportTicket::with(['messages', 'reservation'])->orderBy('created_at', 'desc');

        // Privacy check: If student_id is provided, isolate to that student only
        if ($request->has('student_id') && !empty($request->student_id)) {
            $query->where('student_id', $request->student_id);
        }

        $tickets = $query->get();
        return response()->json([
            'success' => true,
            'tickets' => $tickets,
        ]);
    }

    /**
     * API: Create a new support ticket.
     * Prevents spam by checking for active duplicate tickets.
     */
    public function storeSupportTicket(Request $request)
    {
        $request->validate([
            'student_id'   => 'required|string',
            'student_name' => 'required|string',
            'reason'       => 'required|string',
            'subject'      => 'required|string',
            'message'      => 'required|string',
        ]);

        // Moderation Check: Is student Banned or Snoozed?
        $studentMod = \App\Models\Student::where('student_id', $request->student_id)->first();
        if ($studentMod) {
            if ($studentMod->isBanned()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Banned Account: Hindi ka pinapayagang mag-file ng support ticket dahil sa paglabag sa alituntunin.',
                ], 403);
            }
            if ($studentMod->isSnoozed()) {
                $untilStr = $studentMod->snoozed_until ? $studentMod->snoozed_until->diffForHumans() : 'pansamantala';
                return response()->json([
                    'success' => false,
                    'message' => "Naka-snooze ang iyong account ({$untilStr}) dahil sa warning. Hindi ka muna makakapag-submit ng bagong ticket.",
                ], 403);
            }
        }

        // Daily Limit: Maximum 5 tickets per day per student
        $todayTicketsCount = SupportTicket::where('student_id', $request->student_id)
            ->whereDate('created_at', today())
            ->count();

        if ($todayTicketsCount >= 5) {
            return response()->json([
                'success' => false,
                'message' => 'Nakaabot ka na sa limit na 5 tickets ngayong araw (Maximum 5 tickets per day). Pakisubukan muli bukas.',
            ], 429);
        }

        // Anti-spam rule 1: If student already has an unresolved ticket for this specific reservation
        if ($request->filled('reservation_ref')) {
            $existingActive = SupportTicket::where('student_id', $request->student_id)
                ->where('reservation_ref', $request->reservation_ref)
                ->whereIn('status', ['Open', 'In Progress'])
                ->first();

            if ($existingActive) {
                return response()->json([
                    'success' => false,
                    'message' => "You already have an active ticket ({$existingActive->ticket_code}) for this reservation. Please use your existing conversation.",
                    'existing_ticket' => $existingActive->load('messages'),
                ], 422);
            }
        }

        // Anti-spam rule 2: Limit rapid ticket creation within 5 minutes
        $recentTicket = SupportTicket::where('student_id', $request->student_id)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->whereIn('status', ['Open', 'In Progress'])
            ->first();

        if ($recentTicket && !$request->filled('reservation_ref')) {
            return response()->json([
                'success' => false,
                'message' => "Please wait before creating another ticket. You have an active ticket ({$recentTicket->ticket_code}) currently waiting for response.",
                'existing_ticket' => $recentTicket->load('messages'),
            ], 429);
        }

        // Generate clean unique ticket code: TCK-2026-XXXX
        $count = SupportTicket::count() + 1;
        $ticketCode = 'TCK-' . date('Y') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        while (SupportTicket::where('ticket_code', $ticketCode)->exists()) {
            $count++;
            $ticketCode = 'TCK-' . date('Y') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        }

        $priority = ($request->reason === 'Cancel Reservation') ? 'Urgent' : 'Normal';

        $ticket = SupportTicket::create([
            'ticket_code'     => $ticketCode,
            'student_id'      => $request->student_id,
            'student_name'    => $request->student_name,
            'department'      => $request->department ?? 'General',
            'reservation_ref' => $request->reservation_ref ?: null,
            'reason'          => $request->reason,
            'subject'         => $request->subject,
            'status'          => 'Open',
            'priority'        => $priority,
        ]);

        // Create initial opening message
        $msg = SupportMessage::create([
            'ticket_id'   => $ticket->id,
            'sender_type' => 'student',
            'sender_name' => $request->student_name,
            'sender_id'   => $request->student_id,
            'message'     => $request->message,
            'is_system'   => false,
        ]);

        // Audit Trail Activity Log
        ActivityLog::record(
            'CREATE',
            "Student {$request->student_name} ({$request->student_id}) opened support ticket {$ticketCode}: '{$request->reason}'",
            $request->student_id,
            $request->student_name,
            'Support Helpdesk'
        );

        return response()->json([
            'success' => true,
            'message' => 'Support ticket created successfully! An admin officer will reply shortly.',
            'ticket'  => $ticket->load(['messages', 'reservation']),
        ]);
    }

    /**
     * API: Get messages for a ticket.
     * Enforces privacy: Verifies student ownership if student_id is sent.
     */
    public function getTicketMessages(Request $request, $id)
    {
        $isPolling = $request->filled('after_id');
        $ticket = $isPolling
            ? SupportTicket::select('id', 'student_id', 'status', 'subject', 'reason')->findOrFail($id)
            : SupportTicket::with('reservation')->findOrFail($id);

        // Privacy check
        if ($request->has('student_id') && !empty($request->student_id)) {
            if ($ticket->student_id !== $request->student_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: You do not have access to this conversation.',
                ], 403);
            }
        }

        $query = $ticket->messages()->orderBy('created_at', 'asc');

        if ($request->filled('after_id')) {
            $query->where('id', '>', (int)$request->query('after_id'));
        }

        $messages = $query->get();

        return response()->json([
            'success'       => true,
            'ticket'        => $ticket,
            'ticket_status' => $ticket->status,
            'messages'      => $messages,
            'last_id'       => $messages->last()?->id ?? (int)$request->query('after_id', 0),
        ]);
    }

    /**
     * API: Post a new message in ticket conversation.
     */
    public function storeTicketMessage(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        $request->validate([
            'sender_type' => 'required|in:student,admin,system',
            'sender_name' => 'required|string',
            'message'     => 'required|string',
        ]);

        // Privacy check for student
        if ($request->sender_type === 'student') {
            if ($request->filled('sender_id') && $ticket->student_id !== $request->sender_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized.',
                ], 403);
            }
        }

        // Anti-spam rule: Prevent sending messages if ticket is already closed/resolved
        if ($ticket->status === 'Resolved') {
            return response()->json([
                'success' => false,
                'message' => 'This support ticket has been resolved and closed. Please open a new ticket if you need further help.',
            ], 422);
        }

        $msg = SupportMessage::create([
            'ticket_id'   => $ticket->id,
            'sender_type' => $request->sender_type,
            'sender_name' => $request->sender_name,
            'sender_id'   => $request->sender_id ?: null,
            'message'     => $request->message,
            'is_system'   => false,
        ]);

        // If admin replies and ticket was 'Open', mark as 'In Progress'
        if ($request->sender_type === 'admin' && $ticket->status === 'Open') {
            $ticket->update(['status' => 'In Progress']);
        }

        return response()->json([
            'success'        => true,
            'message'        => $msg,
            'message_record' => $msg,
            'ticket'         => $ticket->fresh(['messages', 'reservation']),
        ]);
    }

    /**
     * API: Update ticket status (e.g. Mark as Resolved / Done or Reopen).
     */
    public function updateTicketStatus(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Open,In Progress,Resolved',
        ]);

        $newStatus = $request->status;
        $adminName = $request->admin_name ?? 'ICS Admin Support';

        if ($newStatus === 'Resolved') {
            $ticket->update([
                'status'      => 'Resolved',
                'resolved_by' => $adminName,
                'resolved_at' => now(),
            ]);

            // Add system notification in the chat
            SupportMessage::create([
                'ticket_id'   => $ticket->id,
                'sender_type' => 'system',
                'sender_name' => 'System',
                'message'     => "Ticket was marked as Resolved and closed by {$adminName}.",
                'is_system'   => true,
            ]);

            $adminCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';
            ActivityLog::record(
                'UPDATE',
                "Admin {$adminName} marked support ticket {$ticket->ticket_code} as Resolved",
                $adminCode,
                $adminName,
                'Support Helpdesk'
            );
        } else {
            $ticket->update([
                'status'      => $newStatus,
                'resolved_by' => null,
                'resolved_at' => null,
            ]);

            SupportMessage::create([
                'ticket_id'   => $ticket->id,
                'sender_type' => 'system',
                'sender_name' => 'System',
                'message'     => "Ticket status changed to {$newStatus}.",
                'is_system'   => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Ticket status updated to {$newStatus}.",
            'ticket'  => $ticket->fresh(['messages', 'reservation']),
        ]);
    }

    /**
     * API: Admin 1-Click Action to Cancel Reservation directly from Chat Support
     * Automatically restocks inventory, marks reservation as Cancelled,
     * updates the ticket status to Resolved, and sends a system chat receipt.
     */
    public function cancelReservationFromTicket(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        if (!$ticket->reservation_ref) {
            return response()->json([
                'success' => false,
                'message' => 'This ticket is not linked to any specific reservation reference.',
            ], 422);
        }

        $reservation = Reservation::where('ref_code', $ticket->reservation_ref)->first();
        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => "Reservation [{$ticket->reservation_ref}] was not found in the system.",
            ], 404);
        }

        if ($reservation->status === 'Cancelled') {
            return response()->json([
                'success' => false,
                'message' => "Reservation [{$reservation->ref_code}] is already cancelled.",
            ], 422);
        }

        // 1. Restore product inventory
        $items = is_string($reservation->items) ? json_decode($reservation->items, true) : $reservation->items;
        if (is_array($items)) {
            foreach ($items as $item) {
                $product = Product::where('item_code', $item['productId'] ?? '')
                    ->orWhere('id', $item['productId'] ?? ($item['id'] ?? 0))
                    ->first();
                if ($product) {
                    $qty = (int)($item['quantity'] ?? 1);
                    $product->current_stock += $qty;
                    $product->units_reserved = max(0, ($product->units_reserved ?? 0) - $qty);

                    // Also restore size count
                    if (is_array($product->sizes) && isset($item['size']) && isset($product->sizes[$item['size']])) {
                        $sizes = $product->sizes;
                        $sizes[$item['size']] = ($sizes[$item['size']] ?? 0) + $qty;
                        $product->sizes = $sizes;
                    }

                    $product->save();
                }
            }
        }

        // 2. Mark reservation as Cancelled
        $reservation->status = 'Cancelled';
        $reservation->save();

        $adminName = $request->admin_name ?? 'ICS Admin Support';

        // 3. Post system confirmation message in the chat
        SupportMessage::create([
            'ticket_id'   => $ticket->id,
            'sender_type' => 'system',
            'sender_name' => 'System',
            'message'     => "Reservation [{$reservation->ref_code}] was successfully CANCELLED by Admin. Reserved apparel units have been restored to inventory.",
            'is_system'   => true,
        ]);

        // 4. Mark ticket as Resolved
        $ticket->update([
            'status'      => 'Resolved',
            'resolved_by' => $adminName,
            'resolved_at' => now(),
        ]);

        // 5. Activity Log
        $adminCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';
        ActivityLog::record(
            'UPDATE',
            "Admin approved cancellation for reservation {$reservation->ref_code} through Support Ticket {$ticket->ticket_code}",
            $adminCode,
            $adminName,
            'Reservation Logistics'
        );

        return response()->json([
            'success'     => true,
            'message'     => "Reservation {$reservation->ref_code} cancelled and stock restored! Ticket marked as Resolved.",
            'ticket'      => $ticket->fresh(['messages', 'reservation']),
            'reservation' => $reservation,
        ]);
    }

    /**
     * API: Edit Reservation Items / Size from Support Ticket
     * Allows Admin to adjust size or item specifications directly from support ticket.
     */
    public function editReservationFromTicket(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        if (!$ticket->reservation_ref) {
            return response()->json([
                'success' => false,
                'message' => 'This ticket is not linked to any specific reservation reference.',
            ], 422);
        }

        $reservation = Reservation::where('ref_code', $ticket->reservation_ref)->first();
        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => "Reservation [{$ticket->reservation_ref}] was not found in the system.",
            ], 404);
        }

        if ($reservation->status === 'Cancelled') {
            return response()->json([
                'success' => false,
                'message' => "Cannot edit items: Reservation [{$reservation->ref_code}] is already cancelled.",
            ], 422);
        }

        $validated = $request->validate([
            'new_size'   => 'nullable|string',
            'remarks'    => 'nullable|string',
            'admin_name' => 'nullable|string',
        ]);

        $newSize = trim($validated['new_size'] ?? '');
        $remarks = trim($validated['remarks'] ?? '');
        $adminName = $validated['admin_name'] ?? (session('student_user.name') ?? session('admin_user.name') ?? 'ICS Support Officer');

        $items = is_string($reservation->items) ? json_decode($reservation->items, true) : $reservation->items;
        $oldSize = 'N/A';
        $itemTitle = 'Apparel';

        if (is_array($items) && count($items) > 0 && !empty($newSize)) {
            $oldSize = $items[0]['size'] ?? 'N/A';
            $itemTitle = $items[0]['name'] ?? ($items[0]['title'] ?? 'Apparel');

            if ($oldSize !== $newSize) {
                // Adjust size stocks if product exists
                $product = Product::where('item_code', $items[0]['productId'] ?? '')
                    ->orWhere('id', $items[0]['productId'] ?? ($items[0]['id'] ?? 0))
                    ->first();

                if ($product && is_array($product->sizes)) {
                    $sizes = $product->sizes;
                    if (isset($sizes[$oldSize])) {
                        $sizes[$oldSize] = ($sizes[$oldSize] ?? 0) + 1;
                    }
                    if (isset($sizes[$newSize])) {
                        $sizes[$newSize] = max(0, ($sizes[$newSize] ?? 0) - 1);
                    }
                    $product->sizes = $sizes;
                    $product->save();
                }

                $items[0]['size'] = $newSize;
                $reservation->items = $items;
                $reservation->save();
            }
        }

        $auditDesc = "Size changed from [{$oldSize}] to [{$newSize}] for {$itemTitle}";
        if (!empty($remarks)) {
            $auditDesc .= " (Note: {$remarks})";
        }

        // Post system message in support chat
        SupportMessage::create([
            'ticket_id'   => $ticket->id,
            'sender_type' => 'system',
            'sender_name' => 'System',
            'message'     => "Reservation [{$reservation->ref_code}] details UPDATED by {$adminName}: {$auditDesc}.",
            'is_system'   => true,
        ]);

        // Activity log
        $adminCode = session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505';
        ActivityLog::record(
            'UPDATE',
            "Admin edited items for reservation {$reservation->ref_code} through Support Ticket {$ticket->ticket_code}: {$auditDesc}",
            $adminCode,
            $adminName,
            'Reservation Logistics'
        );

        return response()->json([
            'success'     => true,
            'message'     => "Reservation {$reservation->ref_code} updated successfully! {$auditDesc}",
            'ticket'      => $ticket->fresh(['messages', 'reservation']),
            'reservation' => $reservation,
        ]);
    }

    /**
     * API: Delete Resolved Support Ticket
     * Only allowed if ticket status is 'Resolved'.
     * If user is student, verifies that ticket belongs to that student.
     * Prevents accidental deletion of active/pending tickets.
     */
    public function deleteTicket(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        // Strict rule: Only allow deletion if ticket is already Resolved
        if ($ticket->status !== 'Resolved') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete ticket: Ticket must be marked as Resolved before deletion to prevent accidental loss of active support inquiries.',
            ], 422);
        }

        // Ownership validation for student
        $studentId = $request->input('student_id');
        $role = $request->input('role', 'student');
        $isAdmin = ($role === 'admin') || $request->filled('admin_name');

        if (!$isAdmin) {
            if (empty($studentId) || $ticket->student_id !== $studentId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: You can only delete your own resolved support tickets.',
                ], 403);
            }
        }

        $code = $ticket->ticket_code;
        $deleterName = $isAdmin ? ($request->input('admin_name') ?? 'ICS Admin Support') : ($ticket->student_name ?: 'Student');

        // Delete associated messages first
        $ticket->messages()->delete();
        $ticket->delete();

        $operatorCode = $isAdmin ? (session('student_user.student_id') ?? session('admin_user.user_code') ?? '251505') : ($studentId ?: 'STUDENT');

        ActivityLog::record(
            'DELETE',
            "Deleted resolved support ticket [{$code}] by {$deleterName}",
            $operatorCode,
            $deleterName,
            'Support Helpdesk'
        );

        return response()->json([
            'success' => true,
            'message' => "Resolved support ticket [{$code}] has been successfully deleted.",
        ]);
    }

    /**
     * API: Admin messages a student buyer regarding their reservation.
     * Reuses an active linked SupportTicket or creates a new conversation with the admin inquiry.
     */
    public function messageBuyerFromReservation(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|min:2',
            'subject' => 'nullable|string',
        ]);

        $reservation = Reservation::findOrFail($id);
        $adminName = session('admin_user.name') ?? 'ICS Council Officer';
        $adminCode = session('admin_user.user_code') ?? '251505';

        // 1. Check for existing open or in-progress ticket linked to this reservation
        $ticket = SupportTicket::where('reservation_ref', $reservation->ref_code)
            ->whereIn('status', ['Open', 'In Progress'])
            ->first();

        $isNew = false;
        if (!$ticket) {
            $isNew = true;
            $ticketCode = 'TCK-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            $subject = $request->input('subject') ?: "Inquiry regarding Reservation {$reservation->ref_code}";

            $ticket = SupportTicket::create([
                'ticket_code'     => $ticketCode,
                'student_id'      => $reservation->student_id ?: 'Student',
                'student_name'    => $reservation->student_name ?: 'Student Buyer',
                'reservation_ref' => $reservation->ref_code,
                'reason'          => 'Admin Inquiry / Order Clarification',
                'subject'         => $subject,
                'status'          => 'In Progress',
            ]);
        }

        // 2. Create the message
        $msg = SupportMessage::create([
            'ticket_id'   => $ticket->id,
            'sender_type' => 'admin',
            'sender_name' => $adminName,
            'sender_id'   => $adminCode,
            'message'     => $request->message,
            'is_system'   => false,
        ]);

        // 3. Record in Activity Log
        ActivityLog::record(
            'CREATE',
            "Admin {$adminName} sent inquiry to buyer {$reservation->student_name} for order {$reservation->ref_code}",
            $adminCode,
            $adminName,
            'Support Helpdesk'
        );

        return response()->json([
            'success'      => true,
            'is_new'       => $isNew,
            'message'      => "Message successfully sent to {$reservation->student_name}!",
            'ticket'       => $ticket->load(['messages', 'reservation']),
            'sent_message' => $msg,
        ]);
    }

    /**
     * FUNCTION 19: REALTIME LIVE SYNC API
     * Returns lightweight JSON with latest products (stock), reservations (queue & status),
     * support tickets & chat messages, and admin dashboard KPI metrics.
     * Polled automatically by frontend without requiring page reloads.
     */
    public function getRealtimeSync(Request $request)
    {
        // 1. Fetch active products with current stock and sizing inventory
        $products = Product::where('is_active', true)
            ->select('id', 'item_code', 'name', 'category', 'gender', 'price', 'initial_stock', 'current_stock', 'units_sold', 'units_reserved', 'sizes', 'image_path')
            ->orderBy('id', 'asc')
            ->get();

        // 2. Fetch latest reservations with privacy & role scoping
        $trackingCode = $request->query('tracking_code');
        $scope = $request->query('scope');
        $studentUser = session('student_user');

        if ($scope === 'admin') {
            // Admin scope: verify authenticated administrator in system_users
            $userEmail = strtolower(trim($studentUser['email'] ?? ''));
            $userCode  = strtolower(trim($studentUser['student_id'] ?? ''));
            $isAdmin = ($userEmail || $userCode) && SystemUser::where(function ($q) use ($userEmail, $userCode) {
                    if ($userEmail) {
                        $q->whereRaw('LOWER(TRIM(email)) = ?', [$userEmail]);
                    }
                    if ($userCode) {
                        $q->orWhereRaw('LOWER(TRIM(user_code)) = ?', [$userCode]);
                    }
                })
                ->where('status', 'Active')
                ->exists();

            if ($isAdmin) {
                $reservations = Reservation::with('activeTicket')
                    ->where(function ($q) {
                        $q->where('status', '!=', 'Cancelled')
                          ->orWhere('updated_at', '>=', now()->subMinutes(10));
                    })
                    ->orderByRaw("CASE WHEN status = 'Pending' THEN 1 WHEN status = 'Ready for Pickup' THEN 2 ELSE 3 END ASC, created_at ASC")
                    ->take(50)->get();
            } else {
                $reservations = collect([]);
            }
        } else {
            // Student storefront scope: strictly filter by the currently logged-in student!
            if ($studentUser) {
                $userStuId = $studentUser['student_id'] ?? null;
                $userEmail = $studentUser['email'] ?? null;
                $userName  = $studentUser['name'] ?? null;

                $reservations = Reservation::where(function ($q) use ($userStuId, $userEmail, $userName) {
                    if ($userStuId) $q->where('student_id', $userStuId);
                    if ($userEmail) $q->orWhere('student_id', $userEmail);
                    if ($userName)  $q->orWhere('student_name', $userName);
                })->where(function ($q) {
                    $q->where('status', '!=', 'Cancelled')
                      ->orWhere('updated_at', '>=', now()->subMinutes(10));
                })->with('activeTicket')->orderBy('created_at', 'desc')->take(20)->get();
            } else {
                $reservations = collect([]);
            }
        }

        // Specific tracked reservation if student is tracking an order
        $trackedReservation = null;
        if (!empty($trackingCode)) {
            $trackedReservation = Reservation::where('ref_code', $trackingCode);

            // If regular student, ensure they can only track their own order
            if ($scope !== 'admin' && $studentUser) {
                $userStuId = $studentUser['student_id'] ?? '';
                $userEmail = $studentUser['email'] ?? '';
                $userName  = $studentUser['name'] ?? '';
                $trackedReservation = $trackedReservation->where(function ($q) use ($userStuId, $userEmail, $userName) {
                    if ($userStuId) $q->where('student_id', $userStuId);
                    if ($userEmail) $q->orWhere('student_id', $userEmail);
                    if ($userName)  $q->orWhere('student_name', $userName);
                });
            }
            $trackedReservation = $trackedReservation->first();
        }

        // 3. Support Tickets & chat messages
        $activeTicketId = $request->query('ticket_id');
        $activeTicket = null;
        if (!empty($activeTicketId)) {
            $activeTicket = SupportTicket::with('messages')->find($activeTicketId);
        }

        if ($scope === 'admin') {
            $supportTickets = SupportTicket::with(['messages', 'reservation'])->orderBy('created_at', 'desc')->take(30)->get();
            $openTicketsCount = SupportTicket::whereIn('status', ['Open', 'In Progress'])->count();
            $pendingCount = Reservation::where('status', 'Pending')->count();
            $readyCount   = Reservation::where('status', 'Ready for Pickup')->count();
            $claimedCount = Reservation::where('status', 'Claimed')->count();
        } else {
            // Student storefront scope: return student's own tickets in real-time
            if ($studentUser) {
                $userStuId = $studentUser['student_id'] ?? '';
                $userName  = $studentUser['name'] ?? '';
                $supportTickets = SupportTicket::with(['messages', 'reservation'])
                    ->where(function ($q) use ($userStuId, $userName) {
                        if ($userStuId) $q->where('student_id', $userStuId);
                        if ($userName)  $q->orWhere('student_name', $userName);
                    })->orderBy('created_at', 'desc')->take(10)->get();
                $openTicketsCount = SupportTicket::where(function ($q) use ($userStuId, $userName) {
                    if ($userStuId) $q->where('student_id', $userStuId);
                    if ($userName)  $q->orWhere('student_name', $userName);
                })->whereIn('status', ['Open', 'In Progress'])->count();
            } else {
                $supportTickets = collect([]);
                $openTicketsCount = 0;
            }
            $pendingCount = 0;
            $readyCount   = 0;
            $claimedCount = 0;
        }

        // 4. Compute live KPI summary metrics for Admin Dashboard
        $totalStockUnits = $products->sum('current_stock');
        $totalSoldUnits  = $products->sum('units_sold');
        $totalReservedUnits = $products->sum('units_reserved');

        $totalRevenue = 0;
        foreach ($products as $p) {
            $totalRevenue += ($p->units_sold * $p->price);
        }

        $categoryStats = [
            'general'     => ['label' => 'Collegiate',    'stock' => 0, 'sold' => 0],
            'pe'          => ['label' => 'Athletics & PE', 'stock' => 0, 'sold' => 0],
            'department'  => ['label' => 'Dept Apparel',  'stock' => 0, 'sold' => 0],
            'accessory'   => ['label' => 'Accessories',   'stock' => 0, 'sold' => 0],
        ];
        foreach ($products as $p) {
            $cat = strtolower(trim($p->category));
            if ($cat === 'accessories') $cat = 'accessory';
            if (!isset($categoryStats[$cat])) {
                $categoryStats[$cat] = ['label' => ucfirst($cat), 'stock' => 0, 'sold' => 0];
            }
            $categoryStats[$cat]['stock'] += intval($p->current_stock);
            $categoryStats[$cat]['sold'] += intval($p->units_sold);
        }

        $activityLogs = [];
        $claimedReservations = [];
        if ($scope === 'admin') {
            $activityLogs = ActivityLog::orderBy('created_at', 'desc')->take(200)->get();
            $claimedReservations = Reservation::where('status', 'Claimed')
                ->orderBy('claimed_at', 'desc')
                ->orderBy('updated_at', 'desc')
                ->take(50)
                ->get();
        }

        return response()->json([
            'success'              => true,
            'timestamp'            => now()->toIso8601String(),
            'products'             => $products,
            'reservations'         => $reservations,
            'claimed_reservations' => $claimedReservations,
            'tracked_reservation'  => $trackedReservation,
            'support_tickets'      => $supportTickets,
            'active_ticket'        => $activeTicket,
            'open_tickets_count'   => $openTicketsCount,
            'activity_logs'        => $activityLogs,
            'metrics'              => [
                'total_products'   => $products->count(),
                'total_stock'      => $totalStockUnits,
                'total_sold'       => $totalSoldUnits,
                'total_reserved'   => $totalReservedUnits,
                'total_revenue'    => $totalRevenue,
                'pending_count'    => $pendingCount,
                'ready_count'      => $readyCount,
                'claimed_count'    => $claimedCount,
                'category_stats'   => $categoryStats,
            ]
        ]);
    }

    /**
     * Dedicated Admin Console Sign Out with Audit Logging
     */
    public function adminLogout(Request $request)
    {
        $studentUser = session('student_user');
        $userEmail = strtolower(trim($studentUser['email'] ?? ''));
        $adminUser = $userEmail ? SystemUser::whereRaw('LOWER(TRIM(email)) = ?', [$userEmail])->first() : null;

        $operatorCode = $adminUser->user_code ?? $studentUser['student_id'] ?? '251505';
        $operatorName = $adminUser->name ?? $studentUser['name'] ?? 'Administrator';

        try {
            ActivityLog::record(
                'LOGOUT',
                "Admin [{$operatorName} ({$operatorCode})] signed out of the Admin Console.",
                $operatorCode,
                $operatorName,
                'Admin Console'
            );
        } catch (\Throwable $e) {}

        session()->forget(['student_user', 'admin_audit_logged', 'student_last_activity']);
        cookie()->queue(cookie()->forget(\App\Http\Middleware\PersistentStudentDeviceSession::COOKIE_NAME));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Admin session signed out successfully.',
                'redirect' => route('home')
            ]);
        }

        return redirect()->route('home')->with('info', "Admin session signed out successfully.");
    }

    /**
     * API: Clear all activity audit logs to avoid database overload.
     * Truncates the logs table and records a fresh administrative purge log.
     */
    public function clearActivityLogs(Request $request)
    {
        $studentUser = session('student_user');
        $adminName = $studentUser['name'] ?? 'ICS Admin';
        $adminCode = $studentUser['student_id'] ?? session('admin_user.user_code') ?? '251505';

        // Purge existing activity logs
        ActivityLog::truncate();

        // Record the purge action itself as the initial log entry
        ActivityLog::record(
            'DELETE',
            "All activity audit trail logs were cleared by {$adminName}",
            $adminCode,
            $adminName,
            'Activity Logs'
        );

        $freshLogs = ActivityLog::orderBy('created_at', 'desc')->take(200)->get();

        return response()->json([
            'success' => true,
            'message' => 'All activity audit logs have been successfully cleared.',
            'logs'    => $freshLogs,
        ]);
    }

    /**
     * API: Fetch latest activity audit logs (up to 200 items)
     */
    public function getActivityLogs(Request $request)
    {
        $logs = ActivityLog::orderBy('created_at', 'desc')->take(200)->get();

        return response()->json([
            'success' => true,
            'logs'    => $logs,
        ]);
    }

    /**
     * MODERATION: Snooze / warn a student (temporary timeout / restriction)
     */
    public function snoozeStudent(Request $request, $id)
    {
        $student = \App\Models\Student::findOrFail($id);
        $hours = intval($request->input('hours', 24));
        if ($hours <= 0) $hours = 24;

        $student->status = 'Snoozed';
        $student->snoozed_until = now()->addHours($hours);
        $student->warning_count = ($student->warning_count ?? 0) + 1;
        $student->save();

        // Audit Trail
        $adminUser = session('student_user');
        $adminName = $adminUser['name'] ?? 'Admin';
        $adminCode = $adminUser['student_id'] ?? 'ADM-01';

        ActivityLog::record(
            'UPDATE',
            "Student [{$student->name} ({$student->student_id})] was SNOOZED for {$hours}h (Warning #{$student->warning_count}) by {$adminName}",
            $adminCode,
            $adminName,
            'User Moderation'
        );

        return response()->json([
            'success' => true,
            'message' => "Student {$student->name} has been snoozed for {$hours} hours (Warning Count: {$student->warning_count}).",
            'student' => $student,
        ]);
    }

    /**
     * MODERATION: Ban a student (blocks reservations and tickets)
     */
    public function banStudent(Request $request, $id)
    {
        $student = \App\Models\Student::findOrFail($id);
        $reason = $request->input('reason', 'Policy violation / spamming');

        $student->status = 'Banned';
        $student->ban_reason = $reason;
        $student->save();

        // Audit Trail
        $adminUser = session('student_user');
        $adminName = $adminUser['name'] ?? 'Admin';
        $adminCode = $adminUser['student_id'] ?? 'ADM-01';

        ActivityLog::record(
            'UPDATE',
            "Student [{$student->name} ({$student->student_id})] was BANNED (Reason: {$reason}) by {$adminName}",
            $adminCode,
            $adminName,
            'User Moderation'
        );

        return response()->json([
            'success' => true,
            'message' => "Student {$student->name} has been BANNED.",
            'student' => $student,
        ]);
    }

    /**
     * MODERATION: Unban / restore student to Active/Enrolled status
     */
    public function unbanStudent(Request $request, $id)
    {
        $student = \App\Models\Student::findOrFail($id);

        $student->status = 'Enrolled';
        $student->snoozed_until = null;
        $student->ban_reason = null;
        $student->save();

        // Audit Trail
        $adminUser = session('student_user');
        $adminName = $adminUser['name'] ?? 'Admin';
        $adminCode = $adminUser['student_id'] ?? 'ADM-01';

        ActivityLog::record(
            'UPDATE',
            "Student [{$student->name} ({$student->student_id})] was UNBANNED / RESTORED by {$adminName}",
            $adminCode,
            $adminName,
            'User Moderation'
        );

        return response()->json([
            'success' => true,
            'message' => "Student {$student->name} has been restored to Active / Enrolled status.",
            'student' => $student,
        ]);
    }

    /**
     * Fetch avatar from Supabase Auth user metadata
     */
    protected function fetchAvatarFromSupabase($email = null, $studentId = null, $name = null): ?string
    {
        $supabaseUrl = rtrim(config('services.supabase.url', ''), '/');
        $serviceKey = config('services.supabase.service_role_key');
        if (!$supabaseUrl || !$serviceKey) return null;

        try {
            $res = \Illuminate\Support\Facades\Http::withHeaders([
                'apikey'        => $serviceKey,
                'Authorization' => "Bearer {$serviceKey}",
            ])->timeout(3)->get("{$supabaseUrl}/auth/v1/admin/users");

            if ($res->successful()) {
                $users = $res->json()['users'] ?? [];
                foreach ($users as $u) {
                    $uEmail = strtolower($u['email'] ?? '');
                    $meta = $u['user_metadata'] ?? [];
                    $mStuId = $meta['student_id'] ?? '';
                    $mName = strtolower($meta['name'] ?? '');

                    $matched = false;
                    if ($email && strtolower($email) === $uEmail) $matched = true;
                    if ($studentId && (string)$studentId === (string)$mStuId) $matched = true;
                    if ($name && $mName && (strtolower($name) === $mName || str_contains($mName, strtolower($name)))) $matched = true;

                    if ($matched && !empty($meta['avatar'])) {
                        return $meta['avatar'];
                    }
                }
            }
        } catch (\Throwable $t) {}
        return null;
    }
}
