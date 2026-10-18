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
        'snoozed_until',
        'warning_count',
        'ban_reason',
        'password',
    ];

    protected $casts = [
        'snoozed_until' => 'datetime',
        'warning_count' => 'integer',
    ];

    public function isBanned(): bool
    {
        return $this->status === 'Banned';
    }

    public function isSnoozed(): bool
    {
        if ($this->status !== 'Snoozed') return false;
        if ($this->snoozed_until === null) return true;
        return $this->snoozed_until->isFuture();
    }

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
     * Get resolved avatar with fallback to matching student accounts
     */
    public function getResolvedAvatarAttribute(): ?string
    {
        if (!empty($this->avatar)) {
            return $this->avatar;
        }

        try {
            $other = self::where(function ($q) {
                if ($this->student_id) $q->where('student_id', $this->student_id);
                if ($this->email) $q->orWhere('email', $this->email);
                if ($this->name) $q->orWhere('name', $this->name);
            })->whereNotNull('avatar')->where('avatar', '!=', '')->first();

            if ($other && !empty($other->avatar)) {
                return $other->avatar;
            }
        } catch (\Throwable $e) {}

        return null;
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
            'avatar'       => $this->resolved_avatar,
            'status'       => $this->status,
            'initials'     => $this->initials,
            'verified_at'  => now()->toDateTimeString(),
            'provider'     => 'ICS Student Portal (Localhost)',
        ];
    }
}
