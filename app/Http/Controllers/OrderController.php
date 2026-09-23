<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Passenger;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Seat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function create(Schedule $schedule): View
    {
        // Tampilkan form pemesanan untuk jadwal tertentu
        $schedule->load(['route.departureAirport', 'route.arrivalAirport', 'plane.airline']); // eager loading relasi yang dibutuhkan di view
        $seats = $schedule->plane->seats()->with('flightClass') ->orderBy('seat_number') ->get();
        
        return view('orders.create', [
            'schedule' => $schedule,
            'seats' => $seats,
        ]);
    }
    
    public function store(StoreOrderRequest $request, Schedule $schedule): RedirectResponse 
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated, $schedule, $request) {
            
            // lockForUpdate() MENGUNCI baris kursi ini di database selama
            // transaksi berjalan - kalau ada 2 orang klik "Pesan" di detik
            // yang SAMA untuk kursi yang SAMA, orang kedua akan MENUNGGU
            // sampai transaksi orang pertama selesai, baru query-nya jalan.
            // Tanpa ini, dua order bisa lolos untuk 1 kursi yang sama
            // (race condition) - inilah bug yang TIDAK PERNAH ditangani
            // di versi lama sama sekali.
            $seat = Seat::lockForUpdate()->findOrFail($validated['seat_id']);

            if ($seat->status !== 'tersedia') {
                return back()->withErrors([
                    'seat_id' => 'Kursi ini baru saja dipesan orang lain, silakan pilih kursi lain.'
                ]);
            }

            $passenger = Passenger::create([
                'full_name' => $validated['full_name'],
                'phone_number' => $validated['phone_number'],
                'email' => $validated['email'],
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
            ]);

            $order = Order::create([
                'user_id' => $request->user()->id,
                'passenger_id' => $passenger->id,
                'schedule_id' => $schedule->id,
                'seat_id' => $seat->id,
                'order_date' => now(),
            ]);

            Payment::create([
                'order_id' => $order->id,
                'status' => 'menunggu_konfirmasi',
            ]);

            $seat->update([
                'status' => 'dipesan'
            ]);

            return redirect()->route('orders.show', $order)
                ->with('status', 'Pemesanan berhasil dibuat! Silakan lakukan pembayaran.');
        });
    }

    public function show(Request $request, Order $order): View
    {
        // Pengecekan otorisasi: pastikan user yang login adalah pemilik pesanan
        if ($order->user_id !== $request->user()->id) {
            abort(403, 'Kamu tidak berhak melihat pesanan ini.');
        }

        // Eager load seluruh relasi yang dibutuhkan di view orders/show.blade.php
        $order->load([
            'schedule.route.departureAirport',
            'schedule.route.arrivalAirport',
            'schedule.plane.airline',
            'seat.flightClass',
            'passenger',
            'payment',
        ]);

        return view('orders.show', [
            'order' => $order,
        ]);
    }
}
