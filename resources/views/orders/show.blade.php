<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->id }}</title>
</head>
<body style="font-family: sans-serif; margin: 20px; line-height: 1.6;">
    @include('partials.nav')

    <h1>Status Pesanan #{{ $order->id }}</h1>

    {{-- Notifikasi Flash Message --}}
    @if (session('status'))
        <p style="color: green; font-weight: bold; background: #e8f5e9; padding: 10px; border-radius: 4px;">
            {{ session('status') }}
        </p>
    @endif

    {{-- Detail Penerbangan --}}
    <h3>Detail Penerbangan</h3>
    <p>
        <strong>Rute:</strong>
        {{ $order->schedule->route->departureAirport->city }} &rarr; {{ $order->schedule->route->arrivalAirport->city }}
    </p>
    <p>
        <strong>Jadwal & Maskapai:</strong>
        {{ $order->schedule->departure->format('d M Y, H:i') }} - {{ $order->schedule->plane->airline->name }}
    </p>
    <p>
        <strong>Nomor Kursi:</strong>
        {{ $order->seat->seat_number }} ({{ $order->seat->flightClass->name }})
    </p>

    <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">

    {{-- Data Penumpang --}}
    <h3>Data Penumpang</h3>
    <p>
        <strong>Nama:</strong> {{ $order->passenger->full_name }}<br>
        <strong>Kontak:</strong> {{ $order->passenger->phone_number }}
    </p>

    <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">

    {{-- Status Pembayaran --}}
    <h3>Status Pembayaran</h3>
    <div>
        @if ($order->payment->status === 'lunas')
            <strong style="color: green;">LUNAS</strong> 
            @if (Route::has('tickets.show'))
                - <a href="{{ route('tickets.show', $order) }}">Lihat E-Tiket</a>
            @else
                - <span>(E-Tiket segera tersedia)</span>
            @endif
        @elseif ($order->payment->status === 'ditolak')
            <strong style="color: red;">DITOLAK</strong>
        @else
            <strong style="color: orange;">MENUNGGU KONFIRMASI</strong>
            <p style="color: #555; margin-top: 5px;">
                Silakan lakukan pembayaran manual, admin akan mengonfirmasi setelah dana diterima.
            </p>
        @endif
    </div>

</body>
</html>