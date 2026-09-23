<?php

namespace Database\Seeders;

use App\Models\Airport;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    public function run(): void
    {
        // Data bandara nyata di Indonesia (kode IATA asli), supaya nanti
        // saat kamu bikin form pencarian, dropdown-nya realistis.
        $airports = [
            ['code' => 'CGK', 'country' => 'Indonesia', 'city' => 'Jakarta', 'name' => 'Soekarno-Hatta International Airport'],
            ['code' => 'DPS', 'country' => 'Indonesia', 'city' => 'Denpasar', 'name' => 'Ngurah Rai International Airport'],
            ['code' => 'SUB', 'country' => 'Indonesia', 'city' => 'Surabaya', 'name' => 'Juanda International Airport'],
            ['code' => 'BDO', 'country' => 'Indonesia', 'city' => 'Bandung', 'name' => 'Husein Sastranegara International Airport'],
            ['code' => 'MES', 'country' => 'Indonesia', 'city' => 'Medan', 'name' => 'Kualanamu International Airport'],
            ['code' => 'UPG', 'country' => 'Indonesia', 'city' => 'Makassar', 'name' => 'Sultan Hasanuddin International Airport'],
        ];

        // updateOrCreate dipakai (bukan create) supaya seeder AMAN dijalankan
        // berkali-kali tanpa membuat data duplikat - ia akan mencari baris
        // dengan 'code' yang sama, lalu update jika sudah ada, atau membuat
        // baru jika belum ada.
        foreach ($airports as $airport) {
            Airport::updateOrCreate(
                ['code' => $airport['code']],
                $airport
            );
        }
    }
}
