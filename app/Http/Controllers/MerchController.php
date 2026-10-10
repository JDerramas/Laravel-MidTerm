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

        // 2. Check for active student session
        $studentUser = session('student_user');

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

        // 5. Fetch verified student roster for local direct sign-in modal
        $studentsList = \App\Models\Student::where('status', 'Enrolled')->orderBy('id', 'asc')->get();

        // 6. Check if current student has active admin privileges in system_users
        $isAdminUser = false;
        if ($studentUser && !empty($studentUser['email'])) {
            $userEmailLower = strtolower(trim($studentUser['email']));
            $isAdminUser = SystemUser::whereRaw('LOWER(TRIM(email)) = ?', [$userEmailLower])
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
            return redirect()->route('home')->with('error', 'Access Restricted: Please sign in with your OnePass campus account first to access the Admin Console.');
        }

        $userEmail = strtolower(trim($studentUser['email'] ?? ''));

        // Check if user's email exists in User Management (system_users) and is Active
        $adminUser = SystemUser::whereRaw('LOWER(TRIM(email)) = ?', [$userEmail])
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
            ->orderBy('created_at', 'desc')->get();
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

        // 3. Compute Sales vs Stock per item
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

        // 6. Fetch verified OnePass students from database for User Management
        $verifiedStudents = \App\Models\Student::orderBy('name', 'asc')->get();

        // 7. Return dedicated admin blade view
        return view('admin', compact(
            'products',
            'reservations',
            'activityLogs',
            'users',
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
            $file = $request->file('receipt_file');
            $filename = 'receipt_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/receipts'), $filename);
            $receiptPath = 'uploads/receipts/' . $filename;
        } elseif (!empty($request->receipt_image) && str_starts_with($request->receipt_image, 'data:image')) {
            $parts = explode(";base64,", $request->receipt_image);
            $typeAux = explode("image/", $parts[0]);
            $ext = $typeAux[1] ?? 'png';
            $data = base64_decode($parts[1]);
            $filename = 'receipt_' . time() . '_' . Str::random(6) . '.' . $ext;
            if (!file_exists(public_path('uploads/receipts'))) {
                mkdir(public_path('uploads/receipts'), 0777, true);
            }
            file_put_contents(public_path('uploads/receipts/' . $filename), $data);
            $receiptPath = 'uploads/receipts/' . $filename;
        } elseif (!empty($request->receipt_image)) {
            $receiptPath = $request->receipt_image;
        }

        $paymentMethod = $request->input('payment_method', 'Cash on Pickup');
        $paymentStatus = ($paymentMethod === 'Cash on Pickup') ? 'Unpaid' : 'Pending Verification';

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
            'payment_reference' => $request->input('payment_reference'),
            'receipt_image'     => $receiptPath,
            'notes'             => $validated['notes'] ?? 'Online Reservation',
        ]);

        // Deduct available stock and increment reserved stock
        foreach ($validated['items'] as $item) {
            $prod = Product::where('item_code', $item['productId'])
                ->orWhere('id', $item['productId'] ?? 0)
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

        // Record in Audit Trail log
        ActivityLog::record(
            'CREATE',
            "New reservation [{$refCode}] from {$validated['student_name']} ({$validated['student_id']}) with total PHP " . number_format($validated['total_amount'], 2),
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
        ActivityLog::record(
            'UPDATE',
            "Updated reservation [{$reservation->ref_code}] status: '{$oldStatus}' -> '{$newStatus}'",
            'USR-002',
            'J. Derramas',
            'Reservations'
        );

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
        ActivityLog::record(
            'DELETE',
            "Permanently deleted reservation [{$refCode}] ({$status}) from database records",
            'USR-002',
            'J. Derramas',
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

        ActivityLog::record(
            'CREATE',
            "Added new merchandise item: '{$product->name}' [{$product->item_code}] with initial stock: {$totalStock}",
            'USR-002',
            'J. Derramas',
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

        ActivityLog::record(
            'UPDATE',
            "Updated details and photo for item: '{$product->name}' [{$product->item_code}]",
            'USR-002',
            'J. Derramas',
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

        ActivityLog::record(
            'DELETE',
            "Deleted merchandise item: '{$name}' [{$code}]",
            'USR-002',
            'J. Derramas',
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
        $adminCode = session('student_user.student_id') ?? 'USR-001';

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
        $adminCode = session('student_user.student_id') ?? 'USR-001';

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

        ActivityLog::record(
            'DELETE',
            "Deleted user account: '{$name}' [{$code}]",
            'USR-001',
            'E. Moreno',
            'User Management'
        );

        return response()->json([
            'success' => true,
            'message' => 'User account deleted successfully.',
        ]);
    }

    /**
     * REPORTS: Download Sales vs Stock CSV file
     */
    public function exportReportCsv()
    {
        $products = Product::all();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="ICS_Sales_vs_Stock_Report_' . date('Ymd_His') . '.csv"',
        ];

        $callback = function () use ($products) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Item Code', 'Product Name', 'Category', 'Price (PHP)', 'Initial Stock', 'Claimed (Sold)', 'Reserved', 'Available Stock', 'Total Revenue (PHP)', 'Stock Status']);

            foreach ($products as $p) {
                $initial = $p->initial_stock > 0 ? $p->initial_stock : ($p->current_stock + $p->units_sold + $p->units_reserved);
                $status = $p->current_stock <= 0 ? 'Out of Stock' : ($p->current_stock < 20 ? 'Low Stock' : 'In Stock');
                $revenue = $p->units_sold * $p->price;

                fputcsv($handle, [
                    $p->item_code,
                    $p->name,
                    strtoupper($p->category),
                    number_format($p->price, 2),
                    $initial,
                    $p->units_sold,
                    $p->units_reserved,
                    $p->current_stock,
                    number_format($revenue, 2),
                    $status
                ]);
            }
            fclose($handle);
        };

        ActivityLog::record(
            'READ',
            'Downloaded Sales vs Stock CSV Report',
            'USR-001',
            'E. Moreno',
            'Reports'
        );

        return response()->stream($callback, 200, $headers);
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
            ? SupportTicket::select('id', 'student_id', 'status', 'subject', 'category')->findOrFail($id)
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

            ActivityLog::record(
                'UPDATE',
                "Admin {$adminName} marked support ticket {$ticket->ticket_code} as Resolved",
                'USR-001',
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
        ActivityLog::record(
            'UPDATE',
            "Admin approved cancellation for reservation {$reservation->ref_code} through Support Ticket {$ticket->ticket_code}",
            'USR-001',
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

        ActivityLog::record(
            'DELETE',
            "Deleted resolved support ticket [{$code}] by {$deleterName}",
            $isAdmin ? 'USR-001' : ($studentId ?: 'STUDENT'),
            $deleterName,
            'Support Helpdesk'
        );

        return response()->json([
            'success' => true,
            'message' => "Resolved support ticket [{$code}] has been successfully deleted.",
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
            $isAdmin = $userEmail && SystemUser::whereRaw('LOWER(TRIM(email)) = ?', [$userEmail])->where('status', 'Active')->exists();

            if ($isAdmin) {
                $reservations = Reservation::with('activeTicket')
                    ->where(function ($q) {
                        $q->where('status', '!=', 'Cancelled')
                          ->orWhere('updated_at', '>=', now()->subMinutes(10));
                    })
                    ->orderBy('created_at', 'desc')->take(50)->get();
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
        if ($scope === 'admin') {
            $activityLogs = ActivityLog::orderBy('created_at', 'desc')->take(200)->get();
        }

        return response()->json([
            'success'             => true,
            'timestamp'           => now()->toIso8601String(),
            'products'            => $products,
            'reservations'        => $reservations,
            'tracked_reservation' => $trackedReservation,
            'support_tickets'     => $supportTickets,
            'active_ticket'       => $activeTicket,
            'open_tickets_count'  => $openTicketsCount,
            'activity_logs'       => $activityLogs,
            'metrics'             => [
                'total_products'  => $products->count(),
                'total_stock'     => $totalStockUnits,
                'total_sold'      => $totalSoldUnits,
                'total_reserved'  => $totalReservedUnits,
                'total_revenue'   => $totalRevenue,
                'pending_count'   => $pendingCount,
                'ready_count'     => $readyCount,
                'claimed_count'   => $claimedCount,
                'category_stats'  => $categoryStats,
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

        $operatorCode = $adminUser->user_code ?? $studentUser['student_id'] ?? 'USR-001';
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

        session()->forget(['student_user', 'admin_audit_logged']);

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
        $adminCode = $studentUser['student_id'] ?? 'USR-001';

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
}
