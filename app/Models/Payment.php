<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_code',
        'payment_method',
        'amount',
        'status',
        'payment_url',
        'virtual_account_number',
        'transaction_id',
        'paid_at',
        'expires_at',
        'payment_proof',
        'confirmed_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    // Boot
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->payment_code)) {
                $payment->payment_code = 'PAY-' . strtoupper(Str::random(10));
            }
        });
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function markAsPaid()
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }
}
