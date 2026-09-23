<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function show(Request $request, Order $order): View
    {
        // 1. Cek Otorisasi: Pastikan pesanan adalah milik user yang sedang login
        if ($order->user_id !== $request->user()->id) {
            abort(403, 'Kamu tidak berhak melihat tiket ini.');
        }

        // 2. Eager loading relasi yang dibutuhkan pada e-tiket
        $order->load([
            'payment.ticket',
            'schedule.route.departureAirport',
            'schedule.route.arrivalAirport',
            'schedule.plane.airline',
            'seat.flightClass',
            'passenger',
        ]);

        // 3. Validasi status pembayaran & keberadaan tiket
        if (! $order->payment || $order->payment->status !== 'lunas' || ! $order->payment->ticket) {
            abort(404, 'Tiket belum tersedia - pastikan pembayaran sudah dikonfirmasi lunas.');
        }

        return view('tickets.show', [
            'order' => $order,
        ]);
    }
}