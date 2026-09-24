<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->status) {
                'lunas' => 'Lunas',
                'ditolak' => 'Ditolak',
                default => 'Menunggu Konfirmasi',
            },
        );
    }

    protected function statusBadgeClasses(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->status) {
                'lunas' => 'bg-green-50 text-green-700 border-green-200',
                'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                default => 'bg-amber-50 text-amber-700 border-amber-200',
            },
        );
    }
}
