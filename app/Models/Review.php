<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'schedule_id',
        'rating',
        'comment',
        'ratings_breakdown',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
        'ratings_breakdown' => 'array',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
