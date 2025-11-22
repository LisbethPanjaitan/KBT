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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained()->onDelete('cascade');
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->date('departure_date');
            $table->time('departure_time');
            $table->time('estimated_arrival_time');
            $table->decimal('price', 10, 2); // harga untuk jadwal ini (bisa beda dari base_price)
            $table->integer('available_seats');
            $table->enum('status', ['scheduled', 'boarding', 'departed', 'arrived', 'cancelled'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamp('actual_departure_time')->nullable();
            $table->timestamp('actual_arrival_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['departure_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
