<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'plate_number',
        'bus_type',
        'total_seats',
        'rows',
        'seats_per_row',
        'seat_layout',
        'status',
        'facilities',
        'manufacture_year',
        'image',
    ];

    protected $casts = [
        'seat_layout' => 'array',
        'manufacture_year' => 'integer',
    ];

    // Relationships
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->status === 'active';
    }
}
