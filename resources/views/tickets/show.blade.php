@extends('layouts.app')

@section('title', 'E-Tiket - ' . $order->payment->ticket->ticket_code)

@section('content')
    <div class="max-w-md mx-auto">
        {{-- Card Boarding Pass --}}
        <div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden mb-6">
            {{-- Header Berwarna (Kop Tiket) --}}
            <div class="bg-brand-600 text-white px-6 py-5">
                <div class="flex items-center justify-between">
                    <p class="text-xs uppercase tracking-wide text-brand-100">E-Tiket Boarding Pass</p>
                    <span class="text-xs font-medium bg-brand-700/60 px-2 py-0.5 rounded text-brand-100">
                        {{ $order->schedule->plane->name }}
                    </span>
                </div>
                <p class="text-lg font-semibold mt-1">{{ $order->schedule->plane->airline->name }}</p>
                <p class="text-sm font-mono text-brand-100 mt-1 tracking-wider">
                    {{ $order->payment->ticket->ticket_code }}
                </p>
            </div>

            {{-- Efek Sobekan Tiket (Garis Putus-Putus) --}}
            <div class="border-t-2 border-dashed border-stone-200"></div>

            {{-- Body Tiket --}}
            <div class="p-6 space-y-4">
                {{-- Data Penumpang --}}
                <div>
                    <p class="text-xs text-stone-500 uppercase tracking-wider">Penumpang</p>
                    <p class="font-medium text-stone-800 text-base">{{ $order->passenger->full_name }}</p>
                </div>

                {{-- Rute Asal -> Tujuan --}}
                <div class="flex items-center justify-between py-2">
                    <div>
                        <p class="text-xs text-stone-500 uppercase tracking-wider">Dari</p>
                        <p class="text-2xl font-bold text-stone-800">{{ $order->schedule->route->departureAirport->code }}</p>
                        <p class="text-xs text-stone-500">{{ $order->schedule->route->departureAirport->city }}</p>
                    </div>

                    <span class="text-stone-300 text-xl font-light">&rarr;</span>

                    <div class="text-right">
                        <p class="text-xs text-stone-500 uppercase tracking-wider">Ke</p>
                        <p class="text-2xl font-bold text-stone-800">{{ $order->schedule->route->arrivalAirport->code }}</p>
                        <p class="text-xs text-stone-500">{{ $order->schedule->route->arrivalAirport->city }}</p>
                    </div>
                </div>

                {{-- Grid Detail: Tanggal & Nomor Kursi --}}
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-stone-100">
                    <div>
                        <p class="text-xs text-stone-500 uppercase tracking-wider">Tanggal & Jam</p>
                        <p class="font-medium text-stone-800">{{ $order->schedule->departure->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-xs text-stone-500 uppercase tracking-wider">Kursi</p>
                        <p class="font-medium text-stone-800">
                            Kursi {{ $order->seat->seat_number }} 
                            <span class="text-xs text-stone-500 font-normal">({{ $order->seat->flightClass->name }})</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aksi: Cetak & Kembali (Disembunyikan saat mode Print kertas) --}}
        <div class="flex items-center justify-between gap-4 print:hidden">
            <a href="{{ route('orders.show', $order) }}" class="text-sm font-medium text-stone-600 hover:text-stone-800 transition">
                &larr; Status Pesanan
            </a>
            <button onclick="window.print()" 
                class="bg-brand-600 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-brand-700 cursor-pointer transition shadow-sm">
                Cetak E-Tiket
            </button>
        </div>
    </div>
@endsection