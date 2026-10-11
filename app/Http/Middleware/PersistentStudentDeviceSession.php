<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Student;
use App\Models\SystemUser;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class PersistentStudentDeviceSession
{
    const COOKIE_NAME = 'ics_device_auth_token';
    const INACTIVITY_TIMEOUT_MINUTES = 60; // 1-hour auto-logout rule for inactivity

    /**
     * Handle an incoming request.
     * Keeps student logged in seamlessly on the same device/browser across refreshes.
     * Enforces automatic session expiration after 1 hour of inactivity.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $now = now()->timestamp;

        // 1. Check if user already has an active session
        if ($request->session()->has('student_user')) {
            $lastActivity = $request->session()->get('student_last_activity', $now);
            $minutesInactive = ($now - $lastActivity) / 60;

            // Inactive for 60+ minutes: auto logout and wipe device remember token
            if ($minutesInactive >= self::INACTIVITY_TIMEOUT_MINUTES) {
                $request->session()->forget(['student_user', 'student_last_activity', 'admin_audit_logged']);
                cookie()->queue(cookie()->forget(self::COOKIE_NAME));
            } else {
                // Update active timestamp and keep device token fresh
                $request->session()->put('student_last_activity', $now);
                $studentUser = $request->session()->get('student_user');
                $this->queueDeviceCookie($studentUser, $now);
            }
        } else {
            // 2. User has no active session in PHP memory (e.g. browser refresh, cold restart, container spin-up)
            // Restore from secure persistent device cookie if within 1 hour
            $deviceToken = $request->cookie(self::COOKIE_NAME);
            if ($deviceToken) {
                try {
                    $payload = json_decode(Crypt::decryptString($deviceToken), true);
                    if (is_array($payload) && !empty($payload['identifier'])) {
                        $tokenTimestamp = $payload['timestamp'] ?? 0;
                        $minutesInactive = ($now - $tokenTimestamp) / 60;

                        if ($minutesInactive < self::INACTIVITY_TIMEOUT_MINUTES) {
                            $identifier = $payload['identifier'];

                            // Attempt matching from Student model
                            $student = Student::where('student_id', $identifier)
                                ->orWhere('email', $identifier)
                                ->first();

                            if ($student) {
                                $profile = $student->toProfileArray();
                                $request->session()->put('student_user', $profile);
                                $request->session()->put('student_last_activity', $now);
                                $this->queueDeviceCookie($profile, $now);
                            } else {
                                // Fallback: Check SystemUser (Admin accounts)
                                $sysUser = SystemUser::where('user_code', $identifier)
                                    ->orWhere('email', $identifier)
                                    ->first();

                                if ($sysUser && $sysUser->status === 'Active') {
                                    $profile = [
                                        'name'         => $sysUser->name,
                                        'student_id'   => $sysUser->user_code,
                                        'email'        => $sysUser->email,
                                        'role'         => $sysUser->role,
                                        'department'   => 'Integrated Computer Society (ICS)',
                                        'section'      => 'Faculty/Admin',
                                        'year_level'   => 'Admin',
                                        'initials'     => strtoupper(substr($sysUser->name, 0, 2)),
                                        'verified_at'  => now()->toDateTimeString(),
                                        'provider'     => 'ICS System Admin',
                                    ];
                                    $request->session()->put('student_user', $profile);
                                    $request->session()->put('student_last_activity', $now);
                                    $this->queueDeviceCookie($profile, $now);
                                }
                            }
                        } else {
                            // Expired after 1 hour of inactivity
                            cookie()->queue(cookie()->forget(self::COOKIE_NAME));
                        }
                    }
                } catch (\Throwable $e) {
                    cookie()->queue(cookie()->forget(self::COOKIE_NAME));
                }
            }
        }

        return $next($request);
    }

    /**
     * Queues an encrypted persistent device cookie valid for 60 minutes
     */
    protected function queueDeviceCookie($user, $timestamp)
    {
        if (empty($user)) return;
        $identifier = $user['student_id'] ?? $user['email'] ?? null;
        if (!$identifier) return;

        $payload = json_encode([
            'identifier' => $identifier,
            'timestamp'  => $timestamp,
        ]);

        $encrypted = Crypt::encryptString($payload);

        cookie()->queue(cookie(
            self::COOKIE_NAME,
            $encrypted,
            self::INACTIVITY_TIMEOUT_MINUTES,
            '/',
            null,
            request()->isSecure(),
            true, // httpOnly
            false,
            'lax'
        ));
    }
}
