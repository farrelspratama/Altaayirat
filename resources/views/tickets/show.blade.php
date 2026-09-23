<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket - {{ $order->payment->ticket->ticket_code }}</title>
</head>
<body style="font-family: sans-serif; margin: 20px; line-height: 1.5;">

    @include('partials.nav')

    <div style="border: 2px solid #333; padding: 25px; max-width: 500px; margin: 20px 0; border-radius: 6px;">
        <h1 style="margin-top: 0; text-transform: uppercase; letter-spacing: 1px;">E-Tiket</h1>
        
        <p style="font-size: 16px;">
            Kode Tiket: <strong style="font-size: 18px; color: #1a237e;">{{ $order->payment->ticket->ticket_code }}</strong>
        </p>

        <hr style="border: none; border-top: 1px solid #ccc; margin: 15px 0;">

        <p style="margin: 5px 0;">
            <small style="color: #666;">Nama Penumpang:</small><br>
            <strong style="font-size: 16px;">{{ $order->passenger->full_name }}</strong>
        </p>

        <p style="margin: 10px 0;">
            <small style="color: #666;">Rute Penerbangan:</small><br>
            <strong>{{ $order->schedule->route->departureAirport->city }} ({{ $order->schedule->route->departureAirport->code }})</strong>
            &rarr;
            <strong>{{ $order->schedule->route->arrivalAirport->city }} ({{ $order->schedule->route->arrivalAirport->code }})</strong>
        </p>

        <p style="margin: 10px 0;">
            <small style="color: #666;">Waktu Keberangkatan:</small><br>
            <strong>{{ $order->schedule->departure->format('d M Y, H:i') }} WIB</strong>
        </p>

        <p style="margin: 10px 0;">
            <small style="color: #666;">Pesawat & Maskapai:</small><br>
            {{ $order->schedule->plane->airline->name }} - {{ $order->schedule->plane->name }}
        </p>

        <p style="margin: 10px 0;">
            <small style="color: #666;">Nomor Kursi & Kelas:</small><br>
            <strong>Kursi {{ $order->seat->seat_number }}</strong> ({{ $order->seat->flightClass->name }})
        </p>
    </div>

    <div>
        <button onclick="window.print()" style="padding: 8px 16px; cursor: pointer;">Cetak E-Tiket</button>
        <a href="{{ route('orders.show', $order) }}" style="margin-left: 10px;">Kembali ke Status Pesanan</a>
    </div>

</body>
</html>