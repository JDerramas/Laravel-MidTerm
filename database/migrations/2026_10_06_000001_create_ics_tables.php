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
        // 1. Products / Merchandise Catalog Table
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();
            $table->string('name');
            $table->string('category')->index(); // general, pe, department, accessory
            $table->string('dept')->default('all'); // all, BSIS, AIS, CICS, CBAA
            $table->string('gender')->default('Unisex'); // Male, Female, Unisex
            $table->decimal('price', 10, 2);
            $table->string('material')->nullable();
            $table->text('description')->nullable();
            $table->text('image_path')->nullable();
            $table->json('sizes')->nullable(); // Size to quantity mapping
            $table->integer('initial_stock')->default(0);
            $table->integer('current_stock')->default(0);
            $table->integer('units_sold')->default(0);
            $table->integer('units_reserved')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Reservations Table
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('ref_code')->unique();
            $table->string('student_name');
            $table->string('student_id');
            $table->string('department');
            $table->string('year_level');
            $table->string('contact');
            $table->date('pickup_date')->nullable();
            $table->string('pickup_slot')->nullable();
            $table->json('items'); // JSON list of reserved items
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('status')->default('Pending'); // Pending, Ready for Pickup, Claimed, Cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 3. Activity Logs / Audit Trail Table (Whiteboard Schema)
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_code')->default('1');
            $table->string('user_name')->default('Admin');
            $table->string('action'); // CREATE, READ, UPDATE, DELETE, LOGIN, LOGOUT
            $table->text('activity');
            $table->string('module')->default('General');
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        // 4. System Users Table
        Schema::create('system_users', function (Blueprint $table) {
            $table->id();
            $table->string('user_code')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role')->default('Officer'); // Admin, Officer, Student
            $table->string('department')->default('AIS');
            $table->string('status')->default('Active'); // Active, Inactive
            $table->text('avatar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_users');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('products');
    }
};
