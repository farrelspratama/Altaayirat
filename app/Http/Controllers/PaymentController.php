<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $validated = $request->validate([
            'status' => ['required', 'in:lunas,ditolak'],
        ]);

        // Status diperbarui dan tiket dibuat dalam satu transaksi: keduanya
        // berhasil bersama atau batal bersama (tidak ada "lunas tanpa tiket").
        $processed = DB::transaction(function () use ($payment, $validated) {
            // Baca ulang baris ini DENGAN KUNCI. Kalau staff menekan tombol dua kali
            // (atau dua staff menekan bersamaan), permintaan kedua menunggu di sini,
            // lalu melihat status yang sudah berubah dan berhenti.
            $locked = Payment::lockForUpdate()->findOrFail($payment->id);

            if ($locked->status !== 'menunggu_konfirmasi') {
                return false;
            }

            $locked->update(['status' => $validated['status']]);

            if ($validated['status'] === 'lunas') {
                Ticket::create([
                    'payment_id' => $locked->id,
                    'ticket_code' => 'TIX-' . strtoupper(uniqid()),
                ]);
            }

            return true;
        });

        if (! $processed) {
            return back()->with('error', 'Pembayaran ini sudah diproses dan tidak bisa diubah lagi.');
        }

        return redirect()->route('payments.index')
            ->with('status', 'Status pembayaran order #' . $payment->order_id . ' berhasil diperbarui.');
    }
}