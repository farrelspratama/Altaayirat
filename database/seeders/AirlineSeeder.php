<?php

namespace Database\Seeders;

use App\Models\Airline;
use Illuminate\Database\Seeder;

class AirlineSeeder extends Seeder
{
    public function run(): void
    {
        $airlines = [
            'Garuda Indonesia',
            'Lion Air',
            'Citilink',
            'Batik Air',
            'Super Air Jet',
        ];

        foreach ($airlines as $name) {
            Airline::updateOrCreate(['name' => $name]);
        }
    }
}
