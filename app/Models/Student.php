<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'student_id',
        'name',
        'email',
        'department',
        'section',
        'year_level',
        'contact',
        'avatar',
        'status',
        'password',
    ];

    /**
     * Get 2-letter initials for avatar fallback
     */
    public function getInitialsAttribute(): string
    {
        $words = preg_split("/\s+/", trim($this->name));
        $initials = '';
        foreach ($words as $w) {
            $initials .= mb_substr($w, 0, 1);
        }
        return strtoupper(substr($initials, 0, 2)) ?: 'ST';
    }

    /**
     * Return formatted profile array suitable for session('student_user')
     */
    public function toProfileArray(): array
    {
        return [
            'id'           => $this->id,
            'student_id'   => $this->student_id,
            'name'         => $this->name,
            'email'        => $this->email,
            'department'   => $this->department,
            'course'       => $this->department,
            'section'      => $this->section,
            'year_level'   => $this->year_level,
            'contact'      => $this->contact ?? 'N/A',
            'avatar'       => $this->avatar,
            'status'       => $this->status,
            'initials'     => $this->initials,
            'verified_at'  => now()->toDateTimeString(),
            'provider'     => 'ICS Student Portal (Localhost)',
        ];
    }
}
