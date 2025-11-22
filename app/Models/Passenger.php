<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'full_name',
        'id_card_number',
        'phone_number',
        'email',
        'passenger_type',
        'special_requirements',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
