<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cari Penerbangan - Altaayirat</title>
</head>
<body>
    @include('partials.nav')
    <h1>Cari Penerbangan</h1>

    {{-- Tampilkan pesan error validasi jika ada. $errors selalu tersedia
         otomatis di semua Blade view, disuntikkan oleh Laravel. --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- method GET (default form), jadi hasilnya berupa query string di URL --}}
    <form action="{{ route('schedules.results') }}" method="GET">

        <label for="departure_airport_id">Dari:</label>
        <select name="departure_airport_id" id="departure_airport_id" required>
            <option value="">-- Pilih Bandara Asal --</option>
            @foreach ($airports as $airport)
                {{-- old() mengembalikan input sebelumnya jika validasi gagal,
                     supaya user tidak perlu mengisi ulang dari nol --}}
                <option value="{{ $airport->id }}" @selected(old('departure_airport_id') == $airport->id)>
                    {{ $airport->city }} ({{ $airport->code }})
                </option>
            @endforeach
        </select>

        <label for="arrival_airport_id">Ke:</label>
        <select name="arrival_airport_id" id="arrival_airport_id" required>
            <option value="">-- Pilih Bandara Tujuan --</option>
            @foreach ($airports as $airport)
                <option value="{{ $airport->id }}" @selected(old('arrival_airport_id') == $airport->id)>
                    {{ $airport->city }} ({{ $airport->code }})
                </option>
            @endforeach
        </select>

        <label for="date">Tanggal:</label>
        <input type="date" name="date" id="date" value="{{ old('date') }}" required>

        <button type="submit">Cari</button>
    </form>
</body>
</html>
