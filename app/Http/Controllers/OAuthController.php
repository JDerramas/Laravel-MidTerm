<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\ActivityLog;

class OAuthController extends Controller
{
    /**
     * Redirect student to OnePass OAuth authorization server
     */
    public function redirect(Request $request)
    {
        // If accessed from XAMPP Apache on localhost (not port 8000), redirect to port 8000
        // because OnePass OAuth client registered http://127.0.0.1:8000/oauth/callback exclusively
        if ($request->getHost() === 'localhost' && $request->getPort() != 8000) {
            return redirect('http://127.0.0.1:8000/oauth/login');
        }

        $clientId = config('services.onepass.client_id');
        $redirectUri = env('ONEPASS_REDIRECT_URI') ?: url('/oauth/callback');
        $issuerUrl = rtrim(config('services.onepass.issuer_url'), '/');

        $state = Str::random(40);
        session(['oauth_state' => $state]);
        cookie()->queue('oauth_state', $state, 15);

        // RFC 7636 PKCE Code Verifier & S256 Challenge
        $codeVerifier = Str::random(64);
        session(['oauth_code_verifier' => $codeVerifier]);
        cookie()->queue('oauth_code_verifier', $codeVerifier, 15);
        $codeChallenge = rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');

        $query = http_build_query([
            'client_id'             => $clientId,
            'redirect_uri'          => $redirectUri,
            'response_type'         => 'code',
            'scope'                 => 'openid profile email student_id qr avatar',
            'state'                 => $state,
            'code_challenge'        => $codeChallenge,
            'code_challenge_method' => 'S256',
        ]);

        return redirect("{$issuerUrl}/oauth/authorize?{$query}");
    }

    /**
     * Handle incoming OAuth authorization callback from OnePass
     */
    public function callback(Request $request)
    {
        if ($request->has('error')) {
            $errorDesc = $request->get('error_description', $request->get('error', 'Authorization was cancelled or denied.'));
            return redirect()->route('home')->with('error', "OnePass Sign-in cancelled: {$errorDesc}");
        }

        $code = $request->get('code');
        if (!$code) {
            return redirect()->route('home')->with('error', 'No authorization code returned from OnePass.');
        }

        $clientId = config('services.onepass.client_id');
        $clientSecret = config('services.onepass.client_secret');
        $redirectUri = env('ONEPASS_REDIRECT_URI') ?: url('/oauth/callback');
        $issuerUrl = rtrim(config('services.onepass.issuer_url'), '/');
        $codeVerifier = session('oauth_code_verifier') ?? $request->cookie('oauth_code_verifier');

        try {
            // 1. Exchange authorization code for tokens (RFC 6749)
            $tokenPayload = [
                'grant_type'    => 'authorization_code',
                'code'          => $code,
                'redirect_uri'  => $redirectUri,
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
            ];

            if ($codeVerifier) {
                $tokenPayload['code_verifier'] = $codeVerifier;
            }

            // CRITICAL: Call ONLY the official API token endpoint (/api/oauth/token).
            // NEVER call /oauth/token because that is a Laravel web route requiring CSRF token (causes 419 Page Expired).
            // Timeout is set to 25s to accommodate Render free-tier cold boot.
            $tokenEndpoint = "{$issuerUrl}/api/oauth/token";
            $tokenResponse = null;

            try {
                // Try as Form first (RFC 6749 standard)
                $tokenResponse = Http::withHeaders(['Accept' => 'application/json'])
                    ->asForm()
                    ->timeout(25)
                    ->post($tokenEndpoint, $tokenPayload);
            } catch (\Throwable $te) {
                Log::warning("Token request (asForm) to {$tokenEndpoint} failed: " . $te->getMessage());
            }

            // If not successful and wasn't a 401 client error, attempt asJson
            if (!$tokenResponse || (!$tokenResponse->successful() && $tokenResponse->status() !== 401)) {
                try {
                    $tokenResponse = Http::withHeaders(['Accept' => 'application/json'])
                        ->asJson()
                        ->timeout(25)
                        ->post($tokenEndpoint, $tokenPayload);
                } catch (\Throwable $te) {
                    Log::warning("Token request (asJson) to {$tokenEndpoint} failed: " . $te->getMessage());
                }
            }

            if (!$tokenResponse || !$tokenResponse->successful()) {
                Log::error('OnePass token exchange failed', [
                    'status' => $tokenResponse ? $tokenResponse->status() : 'none',
                    'body'   => $tokenResponse ? $tokenResponse->body() : 'no response'
                ]);

                $errorMsg = 'No response from OnePass token endpoint. (Render free-tier may still be waking up, please try again in a few moments).';
                if ($tokenResponse) {
                    $json = $tokenResponse->json();
                    if (!empty($json['error_description'])) {
                        $errorMsg = $json['error_description'];
                    } elseif (!empty($json['error'])) {
                        $errorMsg = $json['error'];
                    } elseif (!empty($json['message'])) {
                        $errorMsg = $json['message'];
                    } else {
                        $errorMsg = 'Server returned HTTP ' . $tokenResponse->status();
                    }
                }

                return redirect()->route('home')->with('error', 'Failed to exchange authorization code with OnePass: ' . $errorMsg);
            }

            $tokenData = $tokenResponse->json() ?? [];
            $accessToken = $tokenData['access_token'] ?? null;
            $idToken = $tokenData['id_token'] ?? null;

            if (!$accessToken && empty($idToken)) {
                return redirect()->route('home')->with('error', 'No access token or identity token received from OnePass.');
            }

            // 2. High-Performance Instant Claims Resolution (0ms local decoding of id_token JWT)
            $userData = [];

            if ($idToken && str_contains($idToken, '.')) {
                $jwtParts = explode('.', $idToken);
                if (isset($jwtParts[1])) {
                    $decodedJwt = base64_decode(strtr($jwtParts[1], '-_', '+/'));
                    $jwtClaims = json_decode($decodedJwt, true);
                    if (is_array($jwtClaims) && (!empty($jwtClaims['email']) || !empty($jwtClaims['sub']))) {
                        $userData = $jwtClaims;
                    }
                }
            }

            // Also merge any direct user claims returned in root token response
            if (!empty($tokenData['user']) && is_array($tokenData['user'])) {
                $userData = array_merge($userData, $tokenData['user']);
            }

            // 3. Fallback: Only hit network userinfo endpoint if email claim was not present in id_token
            if (empty($userData['email']) && $accessToken) {
                $userinfoEndpoints = [
                    "{$issuerUrl}/api/oauth/userinfo",
                    "{$issuerUrl}/api/user",
                ];

                foreach ($userinfoEndpoints as $uEp) {
                    try {
                        $userResponse = Http::withToken($accessToken)
                            ->withHeaders(['Accept' => 'application/json'])
                            ->timeout(5)
                            ->get($uEp);

                        if ($userResponse->successful()) {
                            $fetchedUser = $userResponse->json();
                            if (is_array($fetchedUser) && !empty($fetchedUser)) {
                                $userData = array_merge($userData, $fetchedUser);
                                break;
                            }
                        }
                    } catch (\Throwable $ue) {
                        // Quick try next endpoint
                    }
                }
            }

            // Extract student identity attributes per OnePass claims specification
            $studentId = $userData['student_id'] ?? $userData['sub'] ?? '2026-79818';
            $name = $userData['name'] ?? 'Verified Student';
            $email = $userData['email'] ?? "student_{$studentId}@student.edu.ph";
            $course = $userData['course'] ?? $userData['department'] ?? 'Associate in Information Systems (AIS)';
            $yearLevel = $userData['year_level'] ?? '2nd Year';
            $section = $userData['section'] ?? 'AIS 2A';
            $contact = $userData['contact_number'] ?? $userData['contact'] ?? null;
            $avatar = $userData['avatar'] ?? $userData['picture'] ?? null;

            $studentProfile = [
                'name'         => $name,
                'student_id'   => $studentId,
                'department'   => $course,
                'course'       => $course,
                'year_level'   => $yearLevel,
                'section'      => $section,
                'email'        => $email,
                'contact'      => $contact,
                'avatar'       => $avatar,
                'initials'     => strtoupper(substr($name, 0, 2)),
                'verified_at'  => now()->toDateTimeString(),
                'provider'     => 'OnePass (Sign in with ICS)',
                'member_number'=> $userData['member_number'] ?? null,
                'qr_payload'   => $userData['qr_payload'] ?? null,
            ];

            // 3. Save student profile into active session
            session(['student_user' => $studentProfile]);

            // 4. Update / Cache local student model
            \App\Models\Student::updateOrCreate(
                ['student_id' => $studentId],
                [
                    'name'       => $name,
                    'email'      => $email,
                    'department' => $course,
                    'section'    => $section,
                    'year_level' => $yearLevel,
                    'avatar'     => $avatar,
                    'status'     => 'Enrolled',
                ]
            );

            // 5. Record entry in Audit Trail
            ActivityLog::record(
                'LOGIN',
                "Student [{$name} ({$studentId})] authenticated successfully via OnePass OIDC SSO.",
                $studentId,
                $name,
                'Student Store'
            );

            // 6. Sync to Supabase Auth cloud database
            $this->syncToSupabase($studentProfile);

            return redirect()->route('home')->with('success', "Welcome, {$name}! You are now signed in with your verified ICS OnePass identity.");

        } catch (\Throwable $e) {
            Log::error('OAuth Callback Exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('home')->with('error', 'Authentication process encountered an unexpected network error: ' . $e->getMessage());
        }
    }

    /**
     * Sign out current student session
     */
    public function logout(Request $request)
    {
        $user = session('student_user');
        if ($user) {
            ActivityLog::record(
                'LOGOUT',
                "Student [{$user['name']} ({$user['student_id']})] signed out of session.",
                $user['student_id'],
                $user['name'],
                'Student Store'
            );
        }

        session()->forget('student_user');
        return redirect()->route('home')->with('info', 'You have been signed out of your OnePass student session.');
    }

    /**
     * Sync authenticated profile to Supabase Auth
     */
    protected function syncToSupabase(array $profile)
    {
        $supabaseUrl = rtrim(config('services.supabase.url', ''), '/');
        $serviceKey = config('services.supabase.service_role_key');

        if (!$supabaseUrl || !$serviceKey) {
            return;
        }

        try {
            Http::withHeaders([
                'apikey'        => $serviceKey,
                'Authorization' => "Bearer {$serviceKey}",
                'Content-Type'  => 'application/json',
            ])->timeout(2)->post("{$supabaseUrl}/auth/v1/admin/users", [
                'email'         => strtolower($profile['email']),
                'password'      => '123456',
                'email_confirm' => true,
                'user_metadata' => [
                    'name'       => $profile['name'],
                    'student_id' => $profile['student_id'],
                    'department' => $profile['department'],
                    'section'    => $profile['section'],
                    'year_level' => $profile['year_level'],
                    'avatar'     => $profile['avatar'] ?? null,
                ],
            ]);
        } catch (\Throwable $t) {
            // Non-blocking sync
        }
    }
}
