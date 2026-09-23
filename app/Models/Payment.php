<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'method',
        'status',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Satu pembayaran (begitu lunas) menghasilkan tepat satu e-tiket.
     */
    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }
}
