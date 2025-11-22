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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('origin_city');
            $table->string('origin_terminal');
            $table->string('destination_city');
            $table->string('destination_terminal');
            $table->integer('distance_km');
            $table->integer('estimated_duration_minutes');
            $table->decimal('base_price', 10, 2);
            $table->json('stops')->nullable(); // pemberhentian di tengah jalan
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
