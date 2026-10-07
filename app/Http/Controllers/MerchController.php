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
        // 1. Fetch records from each database table using simple Eloquent queries
        $products = Product::where('is_active', true)->orderBy('id', 'asc')->get();
        $reservations = Reservation::orderBy('created_at', 'desc')->get();
        $activityLogs = ActivityLog::orderBy('created_at', 'desc')->take(50)->get();
        $users = SystemUser::orderBy('id', 'asc')->get();

        // 2. Simple math calculations for dashboard KPI summary cards
        $totalProducts = $products->count();
        $totalStockUnits = $products->sum('current_stock');
        $totalSoldUnits = $products->sum('units_sold');
        $totalReservedUnits = $products->sum('units_reserved');
        
        // Total sales revenue (Units Sold x Price)
        $totalRevenue = 0;
        foreach ($products as $p) {
            $totalRevenue += ($p->units_sold * $p->price);
        }

        // Count reservations by status
        $pendingReservationsCount = $reservations->where('status', 'Pending')->count();
        $readyReservationsCount   = $reservations->where('status', 'Ready for Pickup')->count();
        $claimedReservationsCount = $reservations->where('status', 'Claimed')->count();

        // 3. Sales vs Stock calculation for each item (Dashboard & Reports)
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
                'units_reserved'=> $p->units_reserved,
                'revenue'       => $p->units_sold * $p->price,
                'stock_pct'     => $stockPct,
                'sold_pct'      => $soldPct,
                'image_path'    => $p->image_path,
                'status'        => $statusText,
            ];
        }

        // Total initial stock across all items
        $totalInitialStock = 0;
        foreach ($salesVsStock as $item) {
            $totalInitialStock += $item['initial_stock'];
        }

        // 4. Record entry in Activity Logs (Module 5 Audit Trail requirement)
        ActivityLog::record('READ', 'Opened ICS Merch & Reservation Dashboard', 'USR-001', 'E. Moreno', 'Dashboard');

        // 5. Fetch Support Helpdesk Tickets & Stats
        $supportTickets = SupportTicket::with(['messages', 'reservation'])->orderBy('created_at', 'desc')->get();
        $openTicketsCount = $supportTickets->whereIn('status', ['Open', 'In Progress'])->count();

        // 6. Pass data variables to the view
        return view('merch', compact(
            'products',
            'reservations',
            'activityLogs',
            'users',
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
            'salesVsStock'
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
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'user_code'  => 'required|string|unique:system_users,user_code|max:50',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:system_users,email|max:255',
            'role'       => 'required|string|max:50',
            'department' => 'required|string|max:100',
        ]);

        $user = SystemUser::create([
            'user_code'  => strtoupper(trim($validated['user_code'])),
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'role'       => $validated['role'],
            'department' => $validated['department'],
            'status'     => 'Active',
        ]);

        ActivityLog::record(
            'CREATE',
            "Registered new user account: '{$user->name}' ({$user->role}) [{$user->user_code}]",
            'USR-001',
            'E. Moreno',
            'User Management'
        );

        return response()->json([
            'success' => true,
            'message' => 'User account created successfully!',
            'user' => $user,
        ]);
    }

    /**
     * ADMIN: Update User
     */
    public function updateUser(Request $request, $id)
    {
        $user = SystemUser::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:system_users,email,' . $id,
            'role'       => 'required|string|max:50',
            'department' => 'required|string|max:100',
            'status'     => 'required|in:Active,Inactive',
        ]);

        $user->update($validated);

        ActivityLog::record(
            'UPDATE',
            "Updated account info for '{$user->name}' [{$user->user_code}]",
            'USR-001',
            'E. Moreno',
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
        $ticket = SupportTicket::with('reservation')->findOrFail($id);

        // Privacy check
        if ($request->has('student_id') && !empty($request->student_id)) {
            if ($ticket->student_id !== $request->student_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: You do not have access to this conversation.',
                ], 403);
            }
        }

        $messages = $ticket->messages()->orderBy('created_at', 'asc')->get();

        return response()->json([
            'success'  => true,
            'ticket'   => $ticket,
            'messages' => $messages,
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
            'success' => true,
            'message' => $msg,
            'ticket'  => $ticket->fresh(['messages', 'reservation']),
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
}

