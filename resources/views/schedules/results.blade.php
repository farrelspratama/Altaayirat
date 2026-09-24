@extends('layouts.app')

@section('title', 'Hasil Pencarian - Altaayirat')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-semibold text-slate-800">Hasil Pencarian Penerbangan</h1>
                <p class="text-sm text-slate-500">Pilih penerbangan yang tersedia sesuai rute dan tanggal pilihanmu.</p>
            </div>
            <a href="{{ route('schedules.search') }}" class="text-sm font-medium text-sky-600 hover:text-sky-700 hover:underline transition">
                &larr; Cari lagi
            </a>
        </div>

        @if ($schedules->isEmpty())
            <div class="bg-white rounded-lg border border-slate-200 p-8 text-center shadow-sm">
                <p class="text-slate-600 mb-4">Tidak ada penerbangan yang ditemukan untuk pencarian ini.</p>
                <a href="{{ route('schedules.search') }}" class="inline-block bg-sky-600 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-sky-700 transition">
                    Ubah Kriteria Pencarian
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700">
                        <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Maskapai & Pesawat</th>
                                <th scope="col" class="px-6 py-3.5">Rute</th>
                                <th scope="col" class="px-6 py-3.5">Keberangkatan</th>
                                <th scope="col" class="px-6 py-3.5">Kedatangan</th>
                                <th scope="col" class="px-6 py-3.5">Harga</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach ($schedules as $schedule)
                                <tr class="hover:bg-slate-50/80 transition">
                                    
                                    <td class="px-6 py-4 font-medium text-slate-900">
                                        <div class="font-semibold text-slate-800">{{ $schedule->plane->airline->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $schedule->plane->name }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 font-medium text-slate-800">
                                            <span>{{ $schedule->route->departureAirport->city }}</span>
                                            <span class="text-slate-400">&rarr;</span>
                                            <span>{{ $schedule->route->arrivalAirport->city }}</span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $schedule->departure->format('d M Y, H:i') }} WIB
                                    </td>
                                    
                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $schedule->arrival->format('H:i') }} WIB
                                    </td>
                                    
                                    <td class="px-6 py-4 font-semibold text-emerald-600">
                                        Rp {{ number_format($schedule->ticket_price, 0, ',', '.') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('orders.create', $schedule) }}" 
                                           class="inline-block bg-sky-600 text-white font-medium px-4 py-1.5 rounded-md hover:bg-sky-700 transition shadow-sm text-xs">
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