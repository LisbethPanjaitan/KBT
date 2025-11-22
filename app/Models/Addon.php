<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Addon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'price',
        'status',
        'icon',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relationships
    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_addons')
                    ->withPivot('quantity', 'price', 'subtotal')
                    ->withTimestamps();
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
