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
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique();
            $table->string('bus_type'); // Minibus, Microbus, etc
            $table->integer('total_seats');
            $table->integer('rows'); // jumlah baris kursi
            $table->integer('seats_per_row'); // kursi per baris
            $table->json('seat_layout')->nullable(); // konfigurasi seat map
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->text('facilities')->nullable(); // AC, Wifi, USB Port, etc
            $table->year('manufacture_year')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};
