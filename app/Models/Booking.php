<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_code',
        'user_id',
        'schedule_id',
        'total_seats',
        'subtotal',
        'addon_total',
        'discount',
        'total_amount',
        'promo_code',
        'payment_method',
        'status',
        'checked_in_at',
        'expires_at',
        'qr_code',
        'cancellation_reason',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'addon_total' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'checked_in_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * ==========================================
     * RELATIONSHIPS (Relasi Database)
     * ==========================================
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'booking_seats')
                    ->withPivot('passenger_id', 'seat_price')
                    ->withTimestamps();
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    /**
     * FIX: Relasi ke tabel Payment.
     * Ini adalah kunci perbaikan untuk error RelationNotFoundException di image_bf03b4.png.
     */
    public function payment()
    {
        // Menghubungkan Booking dengan satu data Payment (Struk Transfer)
        return $this->hasOne(Payment::class);
    }

    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'booking_addons')
                    ->withPivot('quantity', 'price', 'subtotal')
                    ->withTimestamps();
    }

    /**
     * ==========================================
     * LOGIC & BOOT METHOD
     * ==========================================
     */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            // Membuat kode booking otomatis jika kosong
            if (empty($booking->booking_code)) {
                $booking->booking_code = 'KBT-' . strtoupper(Str::random(8));
            }
            
            // Membuat QR Code otomatis jika kosong
            if (empty($booking->qr_code)) {
                $booking->qr_code = (string) Str::uuid();
            }
        });
    }

    /**
     * ==========================================
     * HELPERS (Mengecek Status)
     * ==========================================
     */

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
}