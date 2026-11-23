<?php

namespace Tests\Concerns;

use App\Models\Airline;
use App\Models\Airport;
use App\Models\FlightClass;
use App\Models\Order;
use App\Models\Passenger;
use App\Models\Payment;
use App\Models\Plane;
use App\Models\Route as FlightRoute;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\Ticket;
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

    /**
     * Kode bandara harus unik (kolom airports.code unique). Kalau tidak diberi,
     * dibuat otomatis (AAA, AAB, AAC, ...) supaya satu tes boleh membuat
     * beberapa rute atau order tanpa bentrok.
     */
    protected function makeAirport(?string $code = null): Airport
    {
        static $n = 0;

        if ($code === null) {
            $code = chr(65 + intdiv($n, 676) % 26) . chr(65 + intdiv($n, 26) % 26) . chr(65 + $n % 26);
            $n++;
        }

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
            'departure_airport_id' => $this->makeAirport()->id,
            'arrival_airport_id' => $this->makeAirport()->id,
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

    protected function makePayment(Order $order, string $status = 'menunggu_konfirmasi'): Payment
    {
        return Payment::create(['order_id' => $order->id, 'status' => $status]);
    }

    protected function makeTicket(Payment $payment): Ticket
    {
        return Ticket::create([
            'payment_id' => $payment->id,
            'ticket_code' => 'TIX-' . strtoupper(uniqid()),
        ]);
    }

    /** Order lengkap: jadwal + kursi + order + pembayaran (+ tiket kalau lunas). */
    protected function makeFullOrder(User $owner, string $paymentStatus = 'menunggu_konfirmasi'): Order
    {
        $schedule = $this->makeSchedule();
        $seat = $this->makeSeat($schedule->plane);
        $seat->update(['status' => 'dipesan']);

        $order = $this->makeOrder($owner, $schedule, $seat);
        $payment = $this->makePayment($order, $paymentStatus);

        if ($paymentStatus === 'lunas') {
            $this->makeTicket($payment);
        }

        return $order;
    }

    /** Data form pemesanan yang valid; $overrides untuk mengubah satu-dua field. */
    protected function bookingData(Seat $seat, array $overrides = []): array
    {
        return array_merge([
            'seat_id' => $seat->id,
            'full_name' => 'Budi Santoso',
            'phone_number' => '081234567890',
            'email' => 'budi@example.test',
            'birth_date' => '1995-05-20',
            'gender' => 'L',
        ], $overrides);
    }
}