@extends('layouts.app')

@section('title', 'Hasil Pencarian - Altaayirat')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-semibold text-stone-800">Hasil Pencarian Penerbangan</h1>
                <p class="text-sm text-stone-500">Pilih penerbangan yang tersedia sesuai rute dan tanggal pilihanmu.</p>
            </div>
            <a href="{{ route('schedules.search') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700 hover:underline transition">
                &larr; Cari lagi
            </a>
        </div>

        @if ($schedules->isEmpty())
            <div class="bg-white rounded-lg border border-stone-200 p-8 text-center shadow-sm">
                <p class="text-stone-600 mb-4">Tidak ada penerbangan yang ditemukan untuk pencarian ini.</p>
                <a href="{{ route('schedules.search') }}" class="inline-block bg-brand-600 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-brand-700 transition">
                    Ubah Kriteria Pencarian
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg border border-stone-200 shadow-sm overflow-x-auto">
                    <table class="w-full text-left text-sm text-stone-700">
                        <thead class="bg-stone-50 text-xs uppercase font-semibold text-stone-500 border-b border-stone-200">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Maskapai & Pesawat</th>
                                <th scope="col" class="px-6 py-3.5">Rute</th>
                                <th scope="col" class="px-6 py-3.5">Keberangkatan</th>
                                <th scope="col" class="px-6 py-3.5">Kedatangan</th>
                                <th scope="col" class="px-6 py-3.5">Harga</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-200">
                            @foreach ($schedules as $schedule)
                                <tr class="hover:bg-stone-50/80 transition">
                                    
                                    <td class="px-6 py-4 font-medium text-stone-900">
                                        <div class="font-semibold text-stone-800">{{ $schedule->plane->airline->name }}</div>
                                        <div class="text-xs text-stone-500">{{ $schedule->plane->name }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 font-medium text-stone-800">
                                            <span>{{ $schedule->route->departureAirport->city }}</span>
                                            <span class="text-stone-400">&rarr;</span>
                                            <span>{{ $schedule->route->arrivalAirport->city }}</span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-stone-600">
                                        {{ $schedule->departure->format('d M Y, H:i') }} WIB
                                    </td>
                                    
                                    <td class="px-6 py-4 text-stone-600">
                                        {{ $schedule->arrival->format('H:i') }} WIB
                                    </td>
                                    
                                    <td class="px-6 py-4 font-semibold text-emerald-600">
                                        Rp {{ number_format($schedule->ticket_price, 0, ',', '.') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('orders.create', $schedule) }}" 
                                           class="inline-block bg-brand-600 text-white font-medium px-4 py-1.5 rounded-md hover:bg-brand-700 transition shadow-sm text-xs">
                                            Pesan Tiket
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection