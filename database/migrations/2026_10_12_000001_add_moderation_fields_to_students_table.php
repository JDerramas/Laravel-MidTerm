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
        Schema::table('students', function (Blueprint $table) {
            $table->timestamp('snoozed_until')->nullable()->after('status');
            $table->unsignedInteger('warning_count')->default(0)->after('snoozed_until');
            $table->string('ban_reason')->nullable()->after('warning_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['snoozed_until', 'warning_count', 'ban_reason']);
        });
    }
};
