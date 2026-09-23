<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pencarian - Altaayirat</title>
</head>
<body>
    @include('partials.nav')
    <h1>Hasil Pencarian Penerbangan</h1>
    <p><a href="{{ route('schedules.search') }}">&larr; Cari lagi</a></p>

    {{-- $schedules->isEmpty() mengecek apakah Collection kosong -
         menggantikan pengecekan manual mysqli_num_rows() == 0 di versi lama --}}
    @if ($schedules->isEmpty())
        <p>Tidak ada penerbangan yang ditemukan untuk pencarian ini.</p>
    @else
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Maskapai</th>
                    <th>Pesawat</th>
                    <th>Rute</th>
                    <th>Berangkat</th>
                    <th>Tiba</th>
                    <th>Harga</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {{-- Karena relasi sudah di-eager load lewat with() di Controller,
                     setiap pemanggilan $schedule->route, $schedule->plane->airline
                     di sini TIDAK memicu query baru ke database. --}}
                @foreach ($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->plane->airline->name }}</td>
                        <td>{{ $schedule->plane->name }}</td>
                        <td>
                            {{ $schedule->route->departureAirport->city }}
                            &rarr;
                            {{ $schedule->route->arrivalAirport->city }}
                        </td>
                        <td>{{ $schedule->departure->format('d M Y, H:i') }}</td>
                        <td>{{ $schedule->arrival->format('H:i') }}</td>
                        <td>Rp {{ number_format($schedule->ticket_price, 0, ',', '.') }}</td>
                        <td>
                            {{-- Route 'schedules.book' belum kita buat - ini
                                 tujuan langkah SELANJUTNYA setelah ini (fitur
                                 pemilihan kursi & pemesanan) --}}
                            <a href="{{ route('orders.create', $schedule) }}">Pesan</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
