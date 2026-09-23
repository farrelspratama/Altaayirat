<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seat extends Model
{
    protected $fillable = [
        'plane_id',
        'class_id',
        'seat_number',
        'status',
    ];

    /**
     * Satu baris kursi adalah milik satu pesawat tertentu.
     * Ini kunci perbaikan bug versi lama: dulu kursi bersifat global
     * lintas pesawat, sekarang setiap kursi terikat ke plane_id spesifik.
     */
    public function plane(): BelongsTo
    {
        return $this->belongsTo(Plane::class);
    }

    /**
     * Satu baris kursi termasuk dalam satu kelas (Business/Economy/dst).
     */
    public function flightClass(): BelongsTo
    {
        return $this->belongsTo(FlightClass::class, 'class_id');
    }

    /**
     * Satu kursi BISA muncul di banyak order sepanjang waktu (kursi A01
     * dipesan bulan ini oleh si A, bulan depan oleh si B setelah selesai
     * diterbangkan) - jadi hasMany, bukan hasOne.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
