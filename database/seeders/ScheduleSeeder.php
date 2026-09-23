<?php

namespace Database\Seeders;

use App\Models\Plane;
use App\Models\Route;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $route = Route::first();   // ambil rute pertama yang ada (Jakarta -> Bali)
        $plane = Plane::first();   // ambil pesawat pertama (Boeing 737-800 Garuda)

        Schedule::updateOrCreate(
            [
                'route_id' => $route->id,
                'plane_id' => $plane->id,
                'departure' => now()->addDays(3)->setTime(8, 0),
            ],
            [
                'arrival' => now()->addDays(3)->setTime(9, 30),
                'ticket_price' => 850000,
            ]
        );
    }
}
