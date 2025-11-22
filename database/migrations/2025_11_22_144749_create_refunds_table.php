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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->string('refund_code')->unique();
            $table->decimal('refund_amount', 10, 2);
            $table->decimal('cancellation_fee', 10, 2)->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected', 'processed'])->default('pending');
            $table->text('reason');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            $table->string('refund_method')->nullable(); // bank_transfer, e_wallet, etc
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
