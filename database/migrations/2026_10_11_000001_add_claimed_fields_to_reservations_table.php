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
        if (Schema::hasTable('reservations')) {
            Schema::table('reservations', function (Blueprint $table) {
                if (!Schema::hasColumn('reservations', 'claimed_at')) {
                    $table->timestamp('claimed_at')->nullable()->after('status');
                }
                if (!Schema::hasColumn('reservations', 'claimed_by')) {
                    $table->string('claimed_by')->nullable()->after('claimed_at');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('reservations')) {
            Schema::table('reservations', function (Blueprint $table) {
                if (Schema::hasColumn('reservations', 'claimed_at')) {
                    $table->dropColumn('claimed_at');
                }
                if (Schema::hasColumn('reservations', 'claimed_by')) {
                    $table->dropColumn('claimed_by');
                }
            });
        }
    }
};
