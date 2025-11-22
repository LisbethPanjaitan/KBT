<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'seat_number',
        'row_number',
        'column_number',
        'status',
        'seat_type',
        'extra_price',
        'booking_id',
        'held_until',
    ];

    protected $casts = [
        'extra_price' => 'decimal:2',
        'row_number' => 'integer',
        'column_number' => 'integer',
        'held_until' => 'datetime',
    ];

    // Relationships
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_seats')
                    ->withPivot('passenger_id', 'seat_price')
                    ->withTimestamps();
    }

    // Helper methods
    public function isAvailable()
    {
        if ($this->status === 'available') {
            return true;
        }
        
        // Check if hold has expired
        if ($this->status === 'held' && $this->held_until && Carbon::now()->isAfter($this->held_until)) {
            $this->release();
            return true;
        }
        
        return false;
    }

    public function hold($minutes = 10)
    {
        $this->update([
            'status' => 'held',
            'held_until' => Carbon::now()->addMinutes($minutes),
        ]);
    }

    public function book($bookingId)
    {
        $this->update([
            'status' => 'booked',
            'booking_id' => $bookingId,
            'held_until' => null,
        ]);
    }

    public function release()
    {
        $this->update([
            'status' => 'available',
            'booking_id' => null,
            'held_until' => null,
        ]);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'available')
              ->orWhere(function($q2) {
                  $q2->where('status', 'held')
                     ->where('held_until', '<', Carbon::now());
              });
        });
    }

    public function scopeByType($query, $type)
    {
        return $query->where('seat_type', $type);
    }
}
