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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique(); // KBT-XXXXXX
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->integer('total_seats');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('addon_total', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('promo_code')->nullable();
            $table->enum('payment_method', ['bank_transfer', 'e_wallet', 'credit_card', 'pay_at_counter'])->nullable();
            $table->enum('status', ['pending', 'confirmed', 'checked_in', 'completed', 'cancelled', 'refunded'])->default('pending');
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('expires_at')->nullable(); // untuk pending payments
            $table->string('qr_code')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['booking_code']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
