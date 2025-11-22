<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'refund_code',
        'refund_amount',
        'cancellation_fee',
        'status',
        'reason',
        'rejection_reason',
        'processed_by',
        'processed_at',
        'refund_method',
        'account_number',
        'account_name',
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',
        'cancellation_fee' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Boot
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($refund) {
            if (empty($refund->refund_code)) {
                $refund->refund_code = 'REF-' . strtoupper(Str::random(8));
            }
        });
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isProcessed()
    {
        return $this->status === 'processed';
    }
}
