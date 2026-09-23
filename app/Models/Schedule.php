<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    protected $fillable = [
        'route_id',
        'plane_id',
        'departure',
        'arrival',
        'ticket_price',
    ];

    protected function casts(): array
    {
        return [
            'departure' => 'datetime',
            'arrival' => 'datetime',
        ];
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function plane(): BelongsTo
    {
        return $this->belongsTo(Plane::class);
    }

    /**
     * Satu jadwal bisa dipesan oleh banyak order berbeda (banyak
     * penumpang naik pesawat yang sama di jadwal yang sama).
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
