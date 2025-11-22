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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->string('seat_number'); // A1, A2, B1, B2, etc
            $table->integer('row_number');
            $table->integer('column_number');
            $table->enum('status', ['available', 'booked', 'held', 'broken'])->default('available');
            $table->enum('seat_type', ['standard', 'premium', 'wheelchair', 'near_door'])->default('standard');
            $table->decimal('extra_price', 10, 2)->default(0); // harga tambahan untuk kursi premium
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('held_until')->nullable(); // untuk temporary hold saat checkout
            $table->timestamps();
            
            $table->unique(['schedule_id', 'seat_number']);
            $table->index(['schedule_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
