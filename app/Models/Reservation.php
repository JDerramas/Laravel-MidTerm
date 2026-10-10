<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    // List of fillable attributes for student reservations
    protected $fillable = [
        'ref_code',       // Unique reference claim code (e.g. ICS-2026-X941K)
        'student_name',   // Full student name
        'student_id',     // Student ID number (e.g. 2024-10822-AIS)
        'department',     // Academic department / program
        'year_level',     // College year level
        'contact',        // Mobile contact number
        'pickup_date',    // Scheduled pickup date
        'pickup_slot',    // Scheduled pickup time window
        'items',          // JSON list of reserved items (size, qty, price)
        'total_amount',   // Total order payment amount
        'status',         // Reservation status: Pending, Ready for Pickup, Claimed, Cancelled
        'payment_method', // Cash on Pickup, GCash Online, Alipay Online
        'payment_status', // Unpaid, Pending Verification, Verified
        'payment_reference', // Online payment transaction reference number
        'receipt_image',  // Uploaded payment receipt screenshot path
        'notes',          // Additional instructions or student remarks
    ];

    // Automatic data type casting
    protected $casts = [
        'items' => 'array',
        'total_amount' => 'float',
    ];

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class, 'reservation_ref', 'ref_code');
    }

    public function activeTicket()
    {
        return $this->hasOne(SupportTicket::class, 'reservation_ref', 'ref_code')
            ->whereIn('status', ['Open', 'In Progress']);
    }
}
