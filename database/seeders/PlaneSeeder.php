<?php

namespace Database\Seeders;

use App\Models\Airline;
use App\Models\Plane;
use Illuminate\Database\Seeder;

class PlaneSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil airline yang SUDAH ada di database (dibuat oleh AirlineSeeder).
        // Ini kenapa urutan seeder penting - kalau PlaneSeeder dijalankan
        // duluan sebelum AirlineSeeder, firstOrFail() akan error karena
        // belum ada airline sama sekali untuk dicari.
        $garuda = Airline::where('name', 'Garuda Indonesia')->firstOrFail();
        $lion = Airline::where('name', 'Lion Air')->firstOrFail();

        $planes = [
            ['airline_id' => $garuda->id, 'name' => 'Boeing 737-800'],
            ['airline_id' => $garuda->id, 'name' => 'Airbus A330-300'],
            ['airline_id' => $lion->id, 'name' => 'Boeing 737 MAX 8'],
        ];

        foreach ($planes as $plane) {
            Plane::updateOrCreate(
                ['airline_id' => $plane['airline_id'], 'name' => $plane['name']],
                $plane
            );
        }
    }
}
