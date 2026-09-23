<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    protected $fillable = [
        'departure_airport_id',
        'arrival_airport_id',
    ];

    /**
     * Sama seperti kasus Seat->flightClass, karena ada dua foreign key
     * yang menunjuk ke tabel yang sama (airports), setiap relasi WAJIB
     * disebutkan eksplisit foreign key-nya sebagai argumen kedua.
     */
    public function departureAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }

    public function arrivalAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'arrival_airport_id');
    }

    /**
     * Satu rute (misal Jakarta-Bali) dijadwalkan berkali-kali di
     * tanggal/jam berbeda.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
