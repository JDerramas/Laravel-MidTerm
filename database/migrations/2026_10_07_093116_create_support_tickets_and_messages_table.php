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
        // 1. Support Tickets Table
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->unique();
            $table->string('student_id')->index();
            $table->string('student_name');
            $table->string('department')->nullable();
            $table->string('reservation_ref')->nullable()->index();
            $table->string('reason')->index(); // 'Cancel Reservation', 'Change Item Size', 'Wrong Item Selected', 'Payment Inquiry', 'General Inquiry'
            $table->string('subject');
            $table->string('status')->default('Open')->index(); // 'Open', 'In Progress', 'Resolved'
            $table->string('priority')->default('Normal'); // 'Normal', 'Urgent'
            $table->string('resolved_by')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });

        // 2. Support Messages Table
        Schema::create('support_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('support_tickets')->onDelete('cascade');
            $table->string('sender_type')->default('student'); // 'student', 'admin', 'system'
            $table->string('sender_name');
            $table->string('sender_id')->nullable();
            $table->text('message');
            $table->boolean('is_system')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_messages');
        Schema::dropIfExists('support_tickets');
    }
};
