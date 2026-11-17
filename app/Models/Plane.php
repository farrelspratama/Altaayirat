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

    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Membuat kursi untuk pesawat ini sekaligus.
     *
     * $counts berisi jumlah kursi per nama kelas, misal:
     *   ['Economy' => 24, 'Premium Economy' => 0, 'Business' => 4]
     *
     * Nomor kursi mengikuti pola SeatSeeder: huruf kelas + nomor dua digit
     * (A01, A02, ... untuk Economy; P01 untuk Premium Economy; B01 untuk Business).
     */
    public function generateSeats(array $counts): void
    {
        $prefixes = [
            'Economy' => 'A',
            'Premium Economy' => 'P',
            'Business' => 'B',
        ];

        $now = now();
        $rows = [];

        foreach ($prefixes as $className => $prefix) {
            $total = (int) ($counts[$className] ?? 0);

            if ($total < 1) {
                continue;
            }

            // firstOrFail: kalau nama kelas tidak ada di tabel classes
            // (belum di-seed), langsung error jelas, bukan diam-diam kosong.
            $classId = FlightClass::where('name', $className)->firstOrFail()->id;

            for ($i = 1; $i <= $total; $i++) {
                $rows[] = [
                    'plane_id' => $this->id,
                    'class_id' => $classId,
                    'seat_number' => $prefix . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'status' => 'tersedia',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // insert() satu kali untuk semua baris jauh lebih cepat daripada
        // create() berulang di dalam loop (satu query vs puluhan query).
        // Catatan: insert() tidak mengisi timestamp otomatis, makanya
        // created_at & updated_at diisi manual di atas.
        Seat::insert($rows);
    }
}