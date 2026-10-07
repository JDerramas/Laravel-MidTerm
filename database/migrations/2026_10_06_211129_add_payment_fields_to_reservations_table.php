<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('payment_method')->default('Cash on Pickup')->after('total_amount');
            $table->string('payment_status')->default('Unpaid')->after('payment_method');
            $table->string('payment_reference')->nullable()->after('payment_status');
            $table->text('receipt_image')->nullable()->after('payment_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status', 'payment_reference', 'receipt_image']);
        });
    }
};
