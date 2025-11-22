<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bus_id',
        'route_id',
        'departure_date',
        'departure_time',
        'estimated_arrival_time',
        'price',
        'available_seats',
        'status',
        'notes',
        'actual_departure_time',
        'actual_arrival_time',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'price' => 'decimal:2',
        'available_seats' => 'integer',
        'actual_departure_time' => 'datetime',
        'actual_arrival_time' => 'datetime',
    ];

    // Relationships
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper methods
    public function getDepartureDateTime()
    {
        return Carbon::parse($this->departure_date->format('Y-m-d') . ' ' . $this->departure_time);
    }

    public function hasAvailableSeats()
    {
        return $this->available_seats > 0;
    }

    public function isBookable()
    {
        return $this->status === 'scheduled' && $this->hasAvailableSeats();
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('departure_date', '>=', now()->toDateString())
                     ->where('status', 'scheduled');
    }

    public function scopeAvailable($query)
    {
        return $query->where('available_seats', '>', 0)
                     ->where('status', 'scheduled');
    }
}
