<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Student;
use App\Models\ActivityLog;

class PaymentSandboxController extends Controller
{
    /**
     * Directory for storing cross-device real-time payment sessions (Laptop <-> Phone QR Scan)
     */
    protected function getSessionFilePath(string $token): string
    {
        $cleanToken = preg_replace('/[^a-zA-Z0-9_-]/', '', $token);
        $dir = storage_path('app/sandbox_payments');
        if (!file_exists($dir)) {
            @mkdir($dir, 0777, true);
        }
        return $dir . DIRECTORY_SEPARATOR . $cleanToken . '.json';
    }

    protected function readSessionData(string $token): ?array
    {
        $path = $this->getSessionFilePath($token);
        if (!file_exists($path)) {
            return null;
        }

        $raw = @file_get_contents($path);
        if (!$raw) {
            return null;
        }

        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : null;
    }

    protected function writeSessionData(string $token, array $data): void
    {
        $path = $this->getSessionFilePath($token);
        @file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Detect LAN IPv4 address so a real phone on the same Wi-Fi/Hotspot can scan localhost QR codes
     */
    protected function detectLanUrl(Request $request, string $relativePath): string
    {
        $host = $request->getHost();
        $port = $request->getPort();
        $scheme = $request->getScheme();
        $baseUrl = rtrim($request->getBaseUrl(), '/');

        if (in_array($host, ['localhost', '127.0.0.1', '::1'])) {
            $lanIp = null;
            try {
                $hostname = gethostname();
                if ($hostname) {
                    $ips = gethostbynamel($hostname);
                    if (is_array($ips)) {
                        foreach ($ips as $ip) {
                            // Prefer 192.168.x.x or 10.x.x.x or 172.16-31.x.x private Wi-Fi/LAN IPs
                            if (preg_match('/^(192\.168\.|10\.|172\.(1[6-9]|2[0-9]|3[0-1])\.)/', $ip)) {
                                $lanIp = $ip;
                                break;
                            }
                        }
                    }
                }
            } catch (\Throwable $e) {
            }

            if ($lanIp) {
                $portPart = ($port && !in_array($port, [80, 443])) ? ":{$port}" : '';
                return "{$scheme}://{$lanIp}{$portPart}{$baseUrl}{$relativePath}";
            }
        }

        return url($relativePath);
    }

    /**
     * 1. CREATE SANDBOX / QR PAYMENT SESSION
     * Called when student selects GCash Online, Maya Online, or Debit/Credit Card in Checkout Modal
     */
    public function createSession(Request $request)
    {
        $studentUser = session('student_user') ?? [];

        $method = $request->input('method', 'GCash Online');
        if (!in_array($method, ['GCash Online', 'Maya Online', 'Debit/Credit Card'])) {
            $method = 'GCash Online';
        }

        $amount = max(1, floatval($request->input('amount', 150)));
        $studentName = trim($request->input('student_name') ?: ($studentUser['name'] ?? 'Juan Dela Cruz'));
        $studentId   = trim($request->input('student_id') ?: ($studentUser['student_id'] ?? '2024-10822-AIS'));
        $department  = trim($request->input('department') ?: ($studentUser['department'] ?? 'Associate in Information Systems (AIS)'));
        $yearLevel   = trim($request->input('year_level') ?: ($studentUser['year_level'] ?? '2nd Year'));
        $contact     = trim($request->input('contact') ?: ($studentUser['contact'] ?? '09171234567'));
        if ($contact === 'Verified Student' || $contact === 'N/A' || empty($contact)) {
            $contact = '09171234567';
        }

        $items = $request->input('items', []);
        $token = 'pay_' . strtolower(Str::random(14));

        $relativePath = "/payment/sandbox/{$token}";
        $sandboxUrl = url($relativePath);
        $qrScanUrl  = $this->detectLanUrl($request, $relativePath);

        $sessionData = [
            'token'                => $token,
            'status'               => 'pending', // pending -> scanned -> authenticated -> paid
            'method'               => $method,
            'amount'               => $amount,
            'student_name'         => $studentName,
            'student_id'           => $studentId,
            'department'           => $department,
            'year_level'           => $yearLevel,
            'contact'              => $contact,
            'items'                => is_array($items) ? $items : [],
            'sandbox_url'          => $sandboxUrl,
            'qr_scan_url'          => $qrScanUrl,
            'paymongo_session_id'  => null,
            'paymongo_checkout_url'=> null,
            'reference_number'     => null,
            'receipt_image'        => null,
            'created_at'           => now()->toIso8601String(),
            'scanned_at'           => null,
            'authenticated_at'     => null,
            'paid_at'              => null,
        ];

        // If client explicitly requested a live PayMongo Checkout Session URL too
        if ($request->boolean('with_paymongo')) {
            $pmData = $this->createPayMongoCheckoutSession($sessionData);
            if ($pmData) {
                $sessionData['paymongo_session_id']   = $pmData['id'];
                $sessionData['paymongo_checkout_url'] = $pmData['checkout_url'];
            }
        }

        $this->writeSessionData($token, $sessionData);

        return response()->json([
            'success'      => true,
            'token'        => $token,
            'sandbox_url'  => $sandboxUrl,
            'qr_scan_url'  => $qrScanUrl,
            'session'      => $sessionData,
        ]);
    }

    /**
     * Create an official PayMongo Test Mode Checkout Session
     */
    public function createPayMongoRedirect(Request $request, string $token)
    {
        $sessionData = $this->readSessionData($token);
        if (!$sessionData) {
            return redirect()->route('home')->with('error', 'Payment session expired.');
        }

        if (!empty($sessionData['paymongo_checkout_url'])) {
            return redirect()->away($sessionData['paymongo_checkout_url']);
        }

        $pmData = $this->createPayMongoCheckoutSession($sessionData);
        if ($pmData && !empty($pmData['checkout_url'])) {
            $sessionData['paymongo_session_id']   = $pmData['id'];
            $sessionData['paymongo_checkout_url'] = $pmData['checkout_url'];
            $sessionData['status']                = 'scanned';
            $this->writeSessionData($token, $sessionData);

            return redirect()->away($pmData['checkout_url']);
        }

        // Fallback to local interactive sandbox portal if offline
        return redirect()->route('payment.sandbox.portal', ['token' => $token]);
    }

    protected function createPayMongoCheckoutSession(array $sessionData): ?array
    {
        $secretKey = config('services.paymongo.secret_key');
        if (empty($secretKey)) {
            return null;
        }

        try {
            $amountInCentavos = max(10000, intval(round($sessionData['amount'] * 100))); // PayMongo min is PHP 100.00 (10000 centavos)
            $token = $sessionData['token'];

            $response = Http::withBasicAuth($secretKey, '')
                ->timeout(8)
                ->post('https://api.paymongo.com/v1/checkout_sessions', [
                    'data' => [
                        'attributes' => [
                            'billing' => [
                                'name'  => $sessionData['student_name'] ?: 'Juan Dela Cruz',
                                'email' => strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $sessionData['student_id'] ?: 'student')) . '@student.npc.edu.ph',
                                'phone' => $sessionData['contact'] ?: '09171234567',
                            ],
                            'send_email_receipt' => false,
                            'show_description'   => true,
                            'show_line_items'    => true,
                            'description'        => 'ICS Apparel & Merch Reservation (' . $sessionData['student_name'] . ')',
                            'line_items'         => [
                                [
                                    'currency' => 'PHP',
                                    'amount'   => $amountInCentavos,
                                    'name'     => 'ICS Merchandise Order (' . $sessionData['method'] . ')',
                                    'quantity' => 1,
                                ],
                            ],
                            'payment_method_types' => ['gcash', 'paymaya', 'card'],
                            'success_url' => url("/payment/sandbox/{$token}?paymongo_success=1"),
                            'cancel_url'  => url("/payment/sandbox/{$token}"),
                        ],
                    ],
                ]);

            if ($response->successful()) {
                $data = $response->json('data');
                return [
                    'id'           => $data['id'] ?? null,
                    'checkout_url' => $data['attributes']['checkout_url'] ?? null,
                ];
            }
        } catch (\Throwable $e) {
            // Non-blocking fallback
        }

        return null;
    }

    /**
     * 2. RENDER INTERACTIVE MOBILE / QR SANDBOX PORTAL (GCash / Maya / Debit Card UI)
     * Opened when scanning the QR code with any normal phone camera or clicking "Simulate QR Scan"
     */
    public function showPortal(Request $request, string $token)
    {
        $sessionData = $this->readSessionData($token);

        if (!$sessionData) {
            // Auto-create a demo session if accessed directly
            $sessionData = [
                'token'          => $token,
                'status'         => 'scanned',
                'method'         => $request->query('method', 'GCash Online'),
                'amount'         => floatval($request->query('amount', 460.00)),
                'student_name'   => session('student_user.name') ?? 'Juan Dela Cruz',
                'student_id'     => session('student_user.student_id') ?? '2024-10822-AIS',
                'department'     => session('student_user.department') ?? 'Associate in Information Systems (AIS)',
                'year_level'     => session('student_user.year_level') ?? '2nd Year',
                'contact'        => session('student_user.contact') ?? '09171234567',
                'items'          => [],
                'created_at'     => now()->toIso8601String(),
                'scanned_at'     => now()->toIso8601String(),
            ];
        } else {
            // If returning from PayMongo success redirect, auto-complete it!
            if ($request->boolean('paymongo_success') && ($sessionData['status'] ?? '') !== 'paid') {
                $prefix = str_contains($sessionData['method'], 'Maya') ? 'MAYA' : (str_contains($sessionData['method'], 'Card') ? 'CARD' : 'GCASH');
                $sessionData['status'] = 'paid';
                $sessionData['paid_at'] = now()->toIso8601String();
                $sessionData['reference_number'] = $prefix . '-' . date('Ymd') . '-' . mt_rand(100000, 999999);
            } elseif (($sessionData['status'] ?? 'pending') === 'pending') {
                $sessionData['status'] = 'scanned';
                $sessionData['scanned_at'] = now()->toIso8601String();
            }
        }

        $this->writeSessionData($token, $sessionData);

        return view('payment_sandbox', [
            'token'       => $token,
            'paymentData' => $sessionData,
            'publicKey'   => config('services.paymongo.public_key'),
        ]);
    }

    /**
     * 3. UPDATE REAL-TIME STEP (e.g. Method Switched or Auto-Login Completed on Phone)
     */
    public function updateStep(Request $request, string $token)
    {
        $sessionData = $this->readSessionData($token);
        if (!$sessionData) {
            return response()->json(['success' => false, 'message' => 'Session not found'], 404);
        }

        if ($sessionData['status'] !== 'paid') {
            if ($request->filled('status')) {
                $sessionData['status'] = $request->input('status');
            }
            if ($request->input('status') === 'authenticated') {
                $sessionData['authenticated_at'] = now()->toIso8601String();
            }
        }

        if ($request->filled('method')) {
            $sessionData['method'] = $request->input('method');
        }
        if ($request->filled('student_name')) {
            $sessionData['student_name'] = trim($request->input('student_name'));
        }
        if ($request->filled('student_id')) {
            $sessionData['student_id'] = trim($request->input('student_id'));
        }
        if ($request->filled('contact')) {
            $sessionData['contact'] = trim($request->input('contact'));
        }

        $this->writeSessionData($token, $sessionData);

        return response()->json([
            'success' => true,
            'session' => $sessionData,
        ]);
    }

    /**
     * 4. COMPLETE TEST PAYMENT (From Phone QR Scan or Simulator UI)
     * Generates Official Reference No., Saves Digital Receipt Screenshot, and Triggers Real-Time Checkout Sync
     */
    public function completePayment(Request $request, string $token)
    {
        $sessionData = $this->readSessionData($token) ?? ['token' => $token, 'amount' => 460.00];

        $method = $request->input('method', $sessionData['method'] ?? 'GCash Online');
        $studentName = trim($request->input('student_name') ?: ($sessionData['student_name'] ?? 'Juan Dela Cruz'));
        $studentId   = trim($request->input('student_id') ?: ($sessionData['student_id'] ?? '2024-10822-AIS'));
        $contact     = trim($request->input('contact') ?: ($sessionData['contact'] ?? '09171234567'));
        $department  = trim($request->input('department') ?: ($sessionData['department'] ?? 'Associate in Information Systems (AIS)'));
        $yearLevel   = trim($request->input('year_level') ?: ($sessionData['year_level'] ?? '2nd Year'));

        $prefix = 'GCASH';
        if (stripos($method, 'Maya') !== false) {
            $prefix = 'MAYA';
        } elseif (stripos($method, 'Card') !== false || stripos($method, 'Debit') !== false) {
            $prefix = 'CARD';
        }

        $refNo = $request->input('reference_number') ?: ($prefix . '-' . date('Ymd') . '-' . mt_rand(100000, 999999));

        // Save generated digital receipt screenshot if provided
        $receiptPath = $sessionData['receipt_image'] ?? null;
        $rawImg = $request->input('receipt_image');
        if (!empty($rawImg) && str_contains($rawImg, ';base64,')) {
            try {
                $dir = public_path('uploads/receipts');
                if (!file_exists($dir)) {
                    @mkdir($dir, 0777, true);
                }
                $parts = explode(';base64,', $rawImg);
                if (count($parts) === 2) {
                    $decoded = base64_decode(str_replace(' ', '+', $parts[1]));
                    if ($decoded !== false && strlen($decoded) > 0) {
                        $filename = 'receipt_' . strtolower($prefix) . '_' . time() . '_' . Str::random(6) . '.png';
                        $targetFilePath = $dir . DIRECTORY_SEPARATOR . $filename;
                        if (@file_put_contents($targetFilePath, $decoded) !== false) {
                            $receiptPath = 'uploads/receipts/' . $filename;
                        }
                    }
                }
            } catch (\Throwable $e) {
            }
            if (empty($receiptPath)) {
                $receiptPath = $rawImg;
            }
        }

        $sessionData['status']           = 'paid';
        $sessionData['method']           = $method;
        $sessionData['student_name']     = $studentName;
        $sessionData['student_id']       = $studentId;
        $sessionData['contact']          = $contact;
        $sessionData['department']       = $department;
        $sessionData['year_level']       = $yearLevel;
        $sessionData['reference_number'] = $refNo;
        $sessionData['receipt_image']    = $receiptPath;
        $sessionData['receipt_base64']   = $rawImg ?: $receiptPath;
        $sessionData['paid_at']          = now()->toIso8601String();
        $sessionData['paid_display']     = now()->format('M d, Y h:i:s A');

        $this->writeSessionData($token, $sessionData);

        // Auto-provision / auto-login student record so if they filled up details on the payment page, they are logged in
        try {
            $student = Student::firstOrCreate(
                ['student_id' => $studentId],
                [
                    'name'       => $studentName,
                    'email'      => strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $studentId)) . '@student.npc.edu.ph',
                    'department' => $department,
                    'section'    => '2A',
                    'year_level' => $yearLevel,
                    'contact'    => $contact,
                    'status'     => 'Enrolled',
                ]
            );
            if ($studentName && $student->name !== $studentName) {
                $student->name = $studentName;
                $student->contact = $contact;
                $student->save();
            }
            session(['student_user' => $student->toProfileArray()]);
        } catch (\Throwable $e) {
        }

        return response()->json([
            'success' => true,
            'message' => "Test payment via {$method} completed in real-time!",
            'session' => $sessionData,
        ]);
    }

    /**
     * 5. REAL-TIME STATUS POLLING ENDPOINT
     * Polled every 1.5s by the Laptop Checkout Modal to detect QR Scan, Auto-Login, and Payment Completion
     */
    public function checkStatus(Request $request, string $token)
    {
        $sessionData = $this->readSessionData($token);
        if (!$sessionData) {
            return response()->json([
                'success' => false,
                'status'  => 'not_found',
            ], 404);
        }

        // If linked to a PayMongo Checkout Session and not yet marked paid, check PayMongo API
        if (($sessionData['status'] ?? '') !== 'paid' && !empty($sessionData['paymongo_session_id'])) {
            $secretKey = config('services.paymongo.secret_key');
            if ($secretKey) {
                try {
                    $pmRes = Http::withBasicAuth($secretKey, '')
                        ->timeout(4)
                        ->get('https://api.paymongo.com/v1/checkout_sessions/' . $sessionData['paymongo_session_id']);

                    if ($pmRes->successful()) {
                        $payments = $pmRes->json('data.attributes.payments') ?? [];
                        $isPaid = collect($payments)->contains(fn($p) => data_get($p, 'attributes.status') === 'paid');
                        if ($isPaid) {
                            $pmRef = data_get($payments, '0.id', 'PM-' . strtoupper(Str::random(8)));
                            $sessionData['status']           = 'paid';
                            $sessionData['reference_number'] = strtoupper($pmRef);
                            $sessionData['paid_at']          = now()->toIso8601String();
                            $sessionData['paid_display']     = now()->format('M d, Y h:i:s A');
                            $this->writeSessionData($token, $sessionData);
                        }
                    }
                } catch (\Throwable $e) {
                }
            }
        }

        // If paid or authenticated, ensure the current browser session is also auto-logged in with the student profile
        if (in_array($sessionData['status'] ?? '', ['authenticated', 'paid']) && !empty($sessionData['student_id'])) {
            if (!session()->has('student_user')) {
                try {
                    $stu = Student::where('student_id', $sessionData['student_id'])->first();
                    if ($stu) {
                        session(['student_user' => $stu->toProfileArray()]);
                    }
                } catch (\Throwable $e) {
                }
            }
        }

        return response()->json([
            'success' => true,
            'status'  => $sessionData['status'] ?? 'pending',
            'session' => $sessionData,
        ]);
    }
}
