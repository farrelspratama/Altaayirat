<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model ini mewakili tabel `classes` (Business/Premium Economy/Economy).
 * Dinamai FlightClass (bukan "Class") karena `Class` adalah kata kunci
 * reserved di PHP dan tidak boleh dipakai sebagai nama class apapun.
 */
class FlightClass extends Model
{
    // Karena nama model (FlightClass -> tebakan default: flight_classes)
    // tidak cocok dengan nama tabel asli, kita timpa manual di sini.
    protected $table = 'classes';

    protected $fillable = [
        'name',
    ];

    /**
     * Satu kelas (misal "Economy") dipakai oleh banyak baris kursi
     * di berbagai pesawat.
     */
    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class, 'class_id');
    }
}
