<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plane extends Model
{
    protected $fillable = [
        'airline_id',
        'name',
    ];

    /**
     * Kebalikan dari Airline::planes() di atas. Karena kolom airline_id
     * ADA di tabel planes, maka Plane "belongsTo" (milik) satu Airline.
     */
    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }

    /**
     * Satu pesawat mempunyai banyak baris kursi.
     */
    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    /**
     * Satu pesawat bisa dipakai di banyak jadwal penerbangan berbeda
     * (pesawat yang sama terbang di rute/waktu berbeda-beda).
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
