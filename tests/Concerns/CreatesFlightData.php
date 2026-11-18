<?php

namespace Tests\Concerns;

use App\Models\Airline;
use App\Models\Airport;
use App\Models\FlightClass;
use App\Models\Order;
use App\Models\Passenger;
use App\Models\Plane;
use App\Models\Route as FlightRoute;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\User;

/**
 * Pembuat data uji. Dipakai bersama oleh banyak file tes supaya tiap tes
 * cukup satu baris ("buat jadwal") dan tidak mengulang belasan baris create().
 */
trait CreatesFlightData
{
    protected function makeUser(string $role = 'user', array $attrs = []): User
    {
        static $n = 0;
        $n++;

        return User::create(array_merge([
            'name' => "User {$n}",
            'email' => "user{$n}@example.test",
            'password' => 'password123',
            'role' => $role,
        ], $attrs));
    }

    protected function makeAirport(string $code): Airport
    {
        return Airport::create([
            'code' => $code,
            'country' => 'Indonesia',
            'city' => "Kota {$code}",
            'name' => "Bandara {$code}",
        ]);
    }

    protected function makePlane(): Plane
    {
        $airline = Airline::create(['name' => 'Maskapai Uji']);

        return Plane::create(['airline_id' => $airline->id, 'name' => 'Boeing Uji']);
    }

    protected function makeSeat(Plane $plane, string $number = 'A01'): Seat
    {
        $class = FlightClass::firstOrCreate(['name' => 'Economy']);

        return Seat::create([
            'plane_id' => $plane->id,
            'class_id' => $class->id,
            'seat_number' => $number,
            'status' => 'tersedia',
        ]);
    }

    protected function makeRoute(): FlightRoute
    {
        return FlightRoute::create([
            'departure_airport_id' => $this->makeAirport('AAA')->id,
            'arrival_airport_id' => $this->makeAirport('BBB')->id,
        ]);
    }

    protected function makeSchedule(?Plane $plane = null, ?FlightRoute $route = null): Schedule
    {
        return Schedule::create([
            'route_id' => ($route ?? $this->makeRoute())->id,
            'plane_id' => ($plane ?? $this->makePlane())->id,
            'departure' => now()->addDays(3),
            'arrival' => now()->addDays(3)->addHours(2),
            'ticket_price' => 1000000,
        ]);
    }

    protected function makePassenger(): Passenger
    {
        return Passenger::create([
            'full_name' => 'Penumpang Uji',
            'phone_number' => '0800000000',
            'email' => 'penumpang@example.test',
            'birth_date' => '1999-01-01',
            'gender' => 'L',
        ]);
    }

    protected function makeOrder(User $user, Schedule $schedule, Seat $seat): Order
    {
        return Order::create([
            'user_id' => $user->id,
            'passenger_id' => $this->makePassenger()->id,
            'schedule_id' => $schedule->id,
            'seat_id' => $seat->id,
            'order_date' => now(),
        ]);
    }
}
