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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->string('payment_code')->unique();
            $table->enum('payment_method', ['bank_transfer', 'gopay', 'ovo', 'dana', 'shopeepay', 'credit_card', 'va_bca', 'va_mandiri', 'va_bni', 'pay_at_counter']);
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'processing', 'paid', 'failed', 'expired', 'refunded'])->default('pending');
            $table->string('payment_url')->nullable(); // untuk redirect ke payment gateway
            $table->string('virtual_account_number')->nullable();
            $table->string('transaction_id')->nullable(); // dari payment gateway
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->text('payment_proof')->nullable(); // untuk upload bukti transfer
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->onDelete('set null'); // admin yang konfirmasi
            $table->timestamps();
            
            $table->index(['booking_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
