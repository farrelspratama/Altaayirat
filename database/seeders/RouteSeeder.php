<?php

namespace Database\Seeders;

use App\Models\Airport;
use App\Models\Route;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        $cgk = Airport::where('code', 'CGK')->firstOrFail();
        $dps = Airport::where('code', 'DPS')->firstOrFail();
        $sub = Airport::where('code', 'SUB')->firstOrFail();

        $routes = [
            ['departure_airport_id' => $cgk->id, 'arrival_airport_id' => $dps->id], // Jakarta -> Bali
            ['departure_airport_id' => $dps->id, 'arrival_airport_id' => $cgk->id], // Bali -> Jakarta
            ['departure_airport_id' => $cgk->id, 'arrival_airport_id' => $sub->id], // Jakarta -> Surabaya
        ];

        foreach ($routes as $route) {
            Route::updateOrCreate($route);
        }
    }
}
