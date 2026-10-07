<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemUser extends Model
{
    // List of fillable attributes for system users and administrators
    protected $fillable = [
        'user_code',   // System user ID (e.g. USR-001)
        'name',        // Full name
        'email',       // Institutional email address
        'role',        // Faculty Adviser, Officer, Team Leader, Student
        'department',  // Academic department / college affiliation
        'status',      // Active or Inactive
        'avatar',      // Profile avatar initials or image URL
    ];
}
