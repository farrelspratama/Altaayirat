<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'passenger_id',
        'schedule_id',
        'seat_id',
        'order_date',
    ];

    protected function casts(): array
    {
        return [
            'order_date' => 'datetime',
        ];
    }

    // Order "belongsTo" 4 hal sekaligus, karena tabel orders punya
    // 4 foreign key: user_id, passenger_id, schedule_id, seat_id.

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function passenger(): BelongsTo
    {
        return $this->belongsTo(Passenger::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    /**
     * Satu order punya TEPAT SATU record pembayaran (relasi 1-ke-1),
     * makanya pakai hasOne, bukan hasMany.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
