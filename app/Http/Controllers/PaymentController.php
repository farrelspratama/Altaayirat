<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::where('status', 'menunggu_konfirmasi')
            ->with([
                'order.user',
                'order.passenger',
                'order.schedule.route.departureAirport',
                'order.schedule.route.arrivalAirport',
            ])
            ->latest()
            ->get();

        return view('admin.payments-index', [
            'payments' => $payments,
        ]);
    }

    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:lunas,ditolak'],
        ]);

        $payment->update([
            'status' => $request->status,
        ]);

        // Kalau dikonfirmasi lunas, generate e-tiket otomatis di sini.
        if ($request->status === 'lunas') {
            Ticket::create([
                'payment_id' => $payment->id,
                'ticket_code' => 'TIX-' . strtoupper(uniqid()),
            ]);
        }

        return redirect()->route('payments.index')
            ->with('status', 'Status pembayaran order #' . $payment->order_id . ' berhasil diperbarui.');
    }
}