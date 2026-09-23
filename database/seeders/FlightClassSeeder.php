<?php

namespace Database\Seeders;

use App\Models\FlightClass;
use Illuminate\Database\Seeder;

class FlightClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            'Economy',
            'Premium Economy',
            'Business',
        ];

        foreach ($classes as $name) {
            FlightClass::updateOrCreate(['name' => $name]);
        }
    }
}
