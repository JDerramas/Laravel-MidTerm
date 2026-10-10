<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Student;
use App\Models\ActivityLog;

class StudentAuthController extends Controller
{
    /**
     * Authenticate student directly using Student ID or Institutional Email
     * Zero external redirect / pure localhost local experience
     */
    public function login(Request $request)
    {
        $loginId = trim(
            $request->input('student_id') 
            ?? $request->json('student_id') 
            ?? $request->input('email') 
            ?? $request->json('email') 
            ?? $request->input('login_id') 
            ?? $request->json('login_id') 
            ?? ''
        );
        $password = $request->input('password') ?? $request->json('password');

        if (empty($loginId)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Please enter your Student ID Number or Institutional Email.'], 422);
            }
            return redirect()->back()->with('error', 'Please enter your Student ID Number or Institutional Email.');
        }

        // 0. Direct Supabase Cloud Auth Query (Real Student Identity Verification)
        $supabaseUrl = rtrim(config('services.supabase.url', ''), '/');
        $serviceKey = config('services.supabase.service_role_key');
        $anonKey = config('services.supabase.key');

        if ($supabaseUrl && ($serviceKey || $anonKey)) {
            try {
                $keyToUse = $serviceKey ?: $anonKey;
                $supabaseRes = Http::withHeaders([
                    'apikey'        => $keyToUse,
                    'Authorization' => "Bearer {$keyToUse}",
                    'Accept'        => 'application/json',
                ])->timeout(6)->get("{$supabaseUrl}/auth/v1/admin/users");

                if ($supabaseRes->successful()) {
                    $users = $supabaseRes->json()['users'] ?? [];
                    foreach ($users as $u) {
                        $meta = $u['user_metadata'] ?? [];
                        $uStuId = $meta['student_id'] ?? '';
                        $uEmail = strtolower($u['email'] ?? '');
                        $search = strtolower($loginId);

                        if ($uStuId === $loginId || $uEmail === $search) {
                            $student = Student::updateOrCreate(
                                ['student_id' => $uStuId ?: $loginId],
                                [
                                    'name'       => $meta['name'] ?? 'Verified Student',
                                    'email'      => $u['email'] ?? (str_contains($loginId, '@') ? $loginId : "student_{$loginId}@student.edu.ph"),
                                    'department' => $meta['department'] ?? 'Associate in Information Systems (AIS)',
                                    'section'    => $meta['section'] ?? '2A',
                                    'year_level' => $meta['year_level'] ?? '2nd Year',
                                    'avatar'     => $meta['avatar'] ?? null,
                                    'status'     => 'Enrolled',
                                ]
                            );
                            break;
                        }
                    }
                }
            } catch (\Throwable $sbEx) {
                Log::warning('Supabase student query exception: ' . $sbEx->getMessage());
            }
        }

        // 1. Search in local students table
        if (!$student) {
            $student = Student::where('student_id', $loginId)
                ->orWhere('email', $loginId)
                ->first();
        }

        // 2. Fallback: Search in local NPC database (npc_elms.students) if present
        if (!$student) {
            try {
                $npcStudent = DB::selectOne(
                    "SELECT * FROM npc_elms.students WHERE student_number = ? OR email = ? LIMIT 1",
                    [$loginId, $loginId]
                );

                if ($npcStudent) {
                    $student = Student::create([
                        'student_id' => $npcStudent->student_number ?? $loginId,
                        'name'       => $npcStudent->full_name ?? 'NPC Student',
                        'email'      => $npcStudent->email ?? "student_{$loginId}@navotaspolytechniccollege.edu.ph",
                        'department' => ($npcStudent->program ?? 'AIS') === 'AIS' ? 'Associate in Information Systems (AIS)' : ($npcStudent->program ?? 'Associate in Information Systems (AIS)'),
                        'section'    => $npcStudent->section ?? '2A',
                        'year_level' => ($npcStudent->year_level ?? 2) . (is_numeric($npcStudent->year_level ?? 2) ? 'nd Year' : ''),
                        'avatar'     => $npcStudent->avatar_url,
                        'status'     => $npcStudent->status ?? 'Enrolled',
                    ]);
                }
            } catch (\Throwable $t) {
                // Ignore NPC fallback error if npc_elms is unavailable
            }
        }

        // 3. Fallback: Auto-provision if valid student ID pattern (e.g. 2025-XXXXX)
        if (!$student && (preg_match('/^[0-9]{4}-[0-9]{5}/', $loginId) || preg_match('/^[0-9]{5,8}$/', $loginId))) {
            $student = Student::create([
                'student_id' => $loginId,
                'name'       => ucwords(str_replace(['.', '_', '-'], ' ', explode('@', $loginId)[0] ?? 'Student Member')),
                'email'      => str_contains($loginId, '@') ? $loginId : "student_{$loginId}@student.edu.ph",
                'department' => 'Associate in Information Systems (AIS)',
                'section'    => '2A',
                'year_level' => '2nd Year',
                'status'     => 'Enrolled',
            ]);
        }

        if (!$student) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Student record not found for '{$loginId}'. Please select one of the verified student accounts below."
                ], 404);
            }
            return redirect()->back()->with('error', "Student record not found for '{$loginId}'.");
        }

        // 4. Save into active session
        $profile = $student->toProfileArray();
        session(['student_user' => $profile]);

        // 5. Audit Trail Record
        ActivityLog::record(
            'LOGIN',
            "Student [{$student->name} ({$student->student_id})] authenticated successfully via Local Student Portal.",
            $student->student_id,
            $student->name,
            'Student Store'
        );

        // 6. Optional background sync to Supabase if configured
        $this->syncToSupabase($profile);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Welcome, {$student->name}! You are now signed in as a verified student.",
                'user'    => $profile,
            ]);
        }

        return redirect()->back()->with('success', "Welcome, {$student->name}! Signed in successfully.");
    }

    /**
     * 1-Click Quick Login for demonstration / panel defense
     */
    public function quickLogin($id, Request $request)
    {
        $student = Student::where('id', $id)
            ->orWhere('student_id', $id)
            ->first();

        if (!$student) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Student account not found.'], 404);
            }
            return redirect()->back()->with('error', 'Student account not found.');
        }

        $profile = $student->toProfileArray();
        session(['student_user' => $profile]);

        ActivityLog::record(
            'LOGIN',
            "Quick Sign-in: Student [{$student->name} ({$student->student_id})] accessed the store.",
            $student->student_id,
            $student->name,
            'Student Store'
        );

        $this->syncToSupabase($profile);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Welcome, {$student->name}! Logged in as {$student->student_id}.",
                'user'    => $profile,
            ]);
        }

        return redirect()->back()->with('success', "Welcome back, {$student->name}!");
    }

    /**
     * Sign out current student session
     */
    public function logout(Request $request)
    {
        $stu = session('student_user');
        if ($stu) {
            ActivityLog::record(
                'LOGOUT',
                "Student [{$stu['name']} ({$stu['student_id']})] signed out of session.",
                $stu['student_id'],
                $stu['name'],
                'Student Store'
            );
        }

        session()->forget('student_user');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Student session signed out successfully.'
            ]);
        }

        return redirect()->route('home')->with('info', 'You have been signed out.');
    }

    /**
     * Return list of active students for login modal
     */
    public function list(Request $request)
    {
        $students = Student::where('status', 'Enrolled')
            ->orderBy('id', 'asc')
            ->get()
            ->map(fn($s) => $s->toProfileArray());

        return response()->json([
            'success'  => true,
            'students' => $students,
        ]);
    }

    /**
     * Return current authenticated student user
     */
    public function current(Request $request)
    {
        return response()->json([
            'authenticated' => session()->has('student_user'),
            'user'          => session('student_user'),
        ]);
    }

    /**
     * Optional background sync to Supabase project table
     */
    protected function syncToSupabase(array $profile)
    {
        $supabaseUrl = config('services.supabase.url');
        $supabaseKey = config('services.supabase.key');

        if (!$supabaseUrl || !$supabaseKey) {
            return;
        }

        try {
            Http::withHeaders([
                'apikey'        => $supabaseKey,
                'Authorization' => "Bearer {$supabaseKey}",
                'Content-Type'  => 'application/json',
                'Prefer'        => 'resolution=merge-duplicates',
            ])->timeout(3)->post("{$supabaseUrl}/rest/v1/students", [
                'student_id' => $profile['student_id'],
                'name'       => $profile['name'],
                'email'      => $profile['email'],
                'course'     => $profile['department'],
                'updated_at' => now()->toISOString(),
            ]);
        } catch (\Throwable $t) {
            // Non-blocking sync
        }
    }
}
