<?php

namespace Database\Seeders;

use App\Models\FlightClass;
use App\Models\Plane;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        $economy = FlightClass::where('name', 'Economy')->firstOrFail();
        $business = FlightClass::where('name', 'Business')->firstOrFail();

        // Untuk SETIAP pesawat yang ada, kita generate kursinya.
        // Ini contoh kenapa hasMany relation yang sudah kita buat berguna:
        // kita bisa loop semua plane tanpa peduli berapa jumlahnya.
        foreach (Plane::all() as $plane) {
            // 2 baris kursi Business: B01 - B02
            foreach (range(1, 2) as $number) {
                $seatNumber = 'B' . str_pad($number, 2, '0', STR_PAD_LEFT); // hasil: B01, B02

                Seat::updateOrCreate(
                    ['plane_id' => $plane->id, 'seat_number' => $seatNumber],
                    ['class_id' => $business->id, 'status' => 'tersedia']
                );
            }

            // 10 baris kursi Economy: A01 - A10
            foreach (range(1, 10) as $number) {
                $seatNumber = 'A' . str_pad($number, 2, '0', STR_PAD_LEFT); // hasil: A01, A02, ..., A10

                Seat::updateOrCreate(
                    ['plane_id' => $plane->id, 'seat_number' => $seatNumber],
                    ['class_id' => $economy->id, 'status' => 'tersedia']
                );
            }
        }
    }
}
