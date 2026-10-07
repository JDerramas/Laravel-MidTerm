<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    // Audit trail fields matching specification:
    // USER CODE | ACTION | ACTIVITY | DATE/TIMESTAMP
    protected $fillable = [
        'user_code',   // Operator identifier (e.g. USR-001 or Student ID)
        'user_name',   // Operator display name
        'action',      // Action verb: CREATE, READ, UPDATE, DELETE, LOGIN, LOGOUT
        'activity',    // Human-readable description of the performed action
        'module',      // Module category: Dashboard, Information Management, Reports, etc.
        'ip_address',  // Client IP address
    ];

    /**
     * Helper method to quickly record audit log entries
     */
    public static function record($action, $activity, $userCode = 'USR-001', $userName = 'Admin', $module = 'General')
    {
        return self::create([
            'user_code'  => $userCode,
            'user_name'  => $userName,
            'action'     => strtoupper($action),
            'activity'   => $activity,
            'module'     => $module,
            'ip_address' => request()->ip() ?? '127.0.0.1',
        ]);
    }
}
