<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * File ini adalah "pintu masuk" - satu-satunya seeder yang dipanggil
     * langsung lewat `php artisan db:seed`. Tugasnya cuma memanggil
     * seeder lain SESUAI URUTAN yang benar (mengikuti urutan dependency
     * foreign key, sama persis logikanya dengan urutan file migration).
     *
     * Urutan di bawah WAJIB seperti ini:
     * 1. Airport, Airline, FlightClass dulu (tidak bergantung tabel lain)
     * 2. Plane (butuh Airline sudah ada)
     * 3. Seat (butuh Plane dan FlightClass sudah ada)
     * 4. Route (butuh Airport sudah ada)
     * 5. Schedule (butuh Route dan Plane sudah ada)
     */
    public function run(): void
    {
        $this->call([
            AirportSeeder::class,
            AirlineSeeder::class,
            FlightClassSeeder::class,
            PlaneSeeder::class,
            SeatSeeder::class,
            RouteSeeder::class,
            ScheduleSeeder::class,
        ]);
    }
}
