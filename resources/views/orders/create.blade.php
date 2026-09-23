@extends('layouts.app')

@section('title', 'Pilih Kursi & Isi Data Penumpang')

@section('content')
    <h1>Pilih Kursi & Isi Data Penumpang</h1>
    <p>{{ $schedule->route->departureAirport->city }} &rarr; {{ $schedule->route->arrivalAirport->city }}</p>
    <p>{{ $schedule->departure->format('d M Y, H:i') }} - {{ $schedule->plane->airline->name }}</p>

    {{-- Komponen error validasi terpusat --}}
    @include('partials.errors')

    <form action="{{ route('orders.store', $schedule) }}" method="POST">
        @csrf

        <h3>Pilih Kursi:</h3>
        @foreach ($seats as $seat)
            <label>
                <input type="radio" name="seat_id" value="{{ $seat->id }}" @disabled($seat->status !== 'tersedia')>
                {{ $seat->seat_number }} ({{ $seat->flightClass->name }})
                @if ($seat->status !== 'tersedia')
                    - <span style="color: red;">Sudah dipesan</span>
                @endif
            </label><br>
        @endforeach

        <h3 style="margin-top: 25px;">Data Penumpang:</h3>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Nama Lengkap:</label>
            <input type="text" name="full_name" placeholder="Contoh: Budi Santoso" value="{{ old('full_name') }}" required style="width: 100%; max-width: 300px; padding: 6px;">
            <br>
            <small style="color: gray;">* Harap isi dengan nama depan dan nama belakang sesuai KTP/identitas.</small>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">No. HP:</label>
            <input type="text" name="phone_number" placeholder="Contoh: 08123456789" value="{{ old('phone_number') }}" required style="width: 100%; max-width: 300px; padding: 6px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Email:</label>
            <input type="email" name="email" placeholder="contoh@email.com" value="{{ old('email') }}" required style="width: 100%; max-width: 300px; padding: 6px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Tanggal Lahir:</label>
            <input type="date" name="birth_date" value="{{ old('birth_date') }}" required style="width: 100%; max-width: 300px; padding: 6px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Jenis Kelamin:</label>
            <select name="gender" required style="width: 100%; max-width: 300px; padding: 6px;">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <button type="submit" style="padding: 10px 20px; cursor: pointer;">Konfirmasi Pesan</button>
    </form>
@endsection