<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('ics:reset-stats', function () {
    \App\Models\Product::query()->update([
        'units_sold' => 0,
        'units_reserved' => 0,
    ]);
    \App\Models\Reservation::query()->delete();
    \App\Models\SupportMessage::query()->delete();
    \App\Models\SupportTicket::query()->delete();

    \App\Models\ActivityLog::record(
        'UPDATE',
        'Reset system sales, revenue, and active reservations to zero for testing.',
        'USR-010',
        'ICS Administrator',
        'System'
    );

    $this->info('Successfully reset Units Claimed / Sold, Revenue, and Active Reservations to ZERO.');
})->purpose('Reset system sales, revenue, and reservations back to zero for testing');

