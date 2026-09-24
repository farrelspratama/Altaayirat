@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id . ' - Altaayirat')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-slate-200">
        {{-- Header Pesanan --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-800">Pesanan #{{ $order->id }}</h1>
            <a href="{{ route('schedules.search') }}" class="text-xs text-sky-600 hover:underline">
                &larr; Beranda
            </a>
        </div>

        {{-- Detail Penerbangan --}}
        <div class="space-y-1 text-sm text-slate-600 mb-6 pb-6 border-b border-slate-100">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Detail Penerbangan</p>
            <p class="font-medium text-slate-800 text-base">
                {{ $order->schedule->route->departureAirport->city }} &rarr; {{ $order->schedule->route->arrivalAirport->city }}
            </p>
            <p>{{ $order->schedule->departure->format('d M Y, H:i') }} WIB &bull; {{ $order->schedule->plane->airline->name }}</p>
            <p>Kursi {{ $order->seat->seat_number }} ({{ $order->seat->flightClass->name }})</p>
        </div>

        {{-- Data Penumpang --}}
        <div class="text-sm text-slate-600 mb-6 pb-6 border-b border-slate-100 space-y-1">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Data Penumpang</p>
            <p class="font-medium text-slate-800">{{ $order->passenger->full_name }}</p>
            <p>{{ $order->passenger->phone_number }}</p>
        </div>

        {{-- Status Pembayaran & Aksi --}}
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status Pembayaran</p>
            
            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium border {{ $order->payment->status_badge_classes }}"> 
                {{ $order->payment->status_label }} 
            </span>

            @if ($order->payment->status === 'lunas')
                @if (Route::has('tickets.show'))
                    <a href="{{ route('tickets.show', $order) }}" 
                       class="block mt-4 text-center bg-sky-600 text-white font-medium py-2 rounded-md hover:bg-sky-700 transition shadow-sm">
                        Lihat E-Tiket
                    </a>
                @else
                    <p class="text-xs text-slate-400 italic mt-3">E-Tiket segera tersedia.</p>
                @endif
            @elseif ($order->payment->status === 'menunggu_konfirmasi')
                <div class="mt-4 rounded-md bg-slate-50 border border-slate-200 p-3 text-xs text-slate-500">
                    Silakan lakukan pembayaran manual, staff akan mengonfirmasi pesanan setelah dana diterima.
                </div>
            @elseif ($order->payment->status === 'ditolak')
                <div class="mt-4 rounded-md bg-red-50/50 border border-red-200 p-3 text-xs text-red-600">
                    Pembayaran tidak dapat diverifikasi atau telah dibatalkan.
                </div>
            @endif
        </div>
    </div>
@endsection