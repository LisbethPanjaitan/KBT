<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'origin_city',
        'origin_terminal',
        'destination_city',
        'destination_terminal',
        'distance_km',
        'estimated_duration_minutes',
        'base_price',
        'stops',
        'status',
    ];

    protected $casts = [
        'stops' => 'array',
        'base_price' => 'decimal:2',
        'distance_km' => 'integer',
        'estimated_duration_minutes' => 'integer',
    ];

    // Relationships
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Helper methods
    public function getFullRouteAttribute()
    {
        return "{$this->origin_city} ({$this->origin_terminal}) → {$this->destination_city} ({$this->destination_terminal})";
    }

    public function isActive()
    {
        return $this->status === 'active';
    }
}
