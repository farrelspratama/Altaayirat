@extends('layouts.app')

@section('title', 'Hasil Pencarian - Altaayirat')

@section('content')
    <h1>Hasil Pencarian Penerbangan</h1>
    
    <p><a href="{{ route('schedules.search') }}">&larr; Cari lagi</a></p>

    {{-- $schedules->isEmpty() mengecek apakah Collection kosong --}}
    @if ($schedules->isEmpty())
        <p>Tidak ada penerbangan yang ditemukan untuk pencarian ini.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr style="background-color: #f2f2f2; text-align: left;">
                    <th>Maskapai</th>
                    <th>Pesawat</th>
                    <th>Rute</th>
                    <th>Berangkat</th>
                    <th>Tiba</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Eager loading relasi dari controller mencegah N+1 query problem --}}
                @foreach ($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->plane->airline->name }}</td>
                        <td>{{ $schedule->plane->name }}</td>
                        <td>
                            {{ $schedule->route->departureAirport->city }}
                            &rarr;
                            {{ $schedule->route->arrivalAirport->city }}
                        </td>
                        <td>{{ $schedule->departure->format('d M Y, H:i') }} WIB</td>
                        <td>{{ $schedule->arrival->format('H:i') }} WIB</td>
                        <td>Rp {{ number_format($schedule->ticket_price, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('orders.create', $schedule) }}">Pesan</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection