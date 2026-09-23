<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Airport extends Model
{
    protected $fillable = [
        'code',
        'country',
        'city',
        'name',
    ];

    /**
     * Satu bandara bisa jadi TITIK KEBERANGKATAN dari banyak rute.
     * Perhatikan argumen kedua: karena tabel `routes` punya DUA kolom
     * yang sama-sama menunjuk ke `airports` (departure_airport_id dan
     * arrival_airport_id), kita WAJIB menyebutkan secara eksplisit
     * foreign key mana yang dipakai relasi ini. Tanpa argumen kedua,
     * Eloquent akan menebak nama kolom secara otomatis dan salah.
     */
    public function departureRoutes(): HasMany
    {
        return $this->hasMany(Route::class, 'departure_airport_id');
    }

    /**
     * Satu bandara bisa jadi TITIK KEDATANGAN dari banyak rute lain.
     */
    public function arrivalRoutes(): HasMany
    {
        return $this->hasMany(Route::class, 'arrival_airport_id');
    }
}
