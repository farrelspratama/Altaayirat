@extends('layouts.app')

@section('title', 'Cari Penerbangan')

@section('content')
    <h1>Cari Penerbangan</h1>

    {{-- Komponen error validasi yang sudah dipisah ke partials --}}
    @include('partials.errors')

    <form action="{{ route('schedules.results') }}" method="GET">
        {{-- Bandara Asal --}}
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Bandara Asal:</label>
            <select name="departure_airport_id" required style="width: 100%; max-width: 320px; padding: 6px;">
                <option value="">-- Pilih Bandara Asal --</option>
                @foreach ($airports as $airport)
                    <option value="{{ $airport->id }}" {{ old('departure_airport_id', request('departure_airport_id')) == $airport->id ? 'selected' : '' }}>
                        {{ $airport->city }} ({{ $airport->code }}) - {{ $airport->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Bandara Tujuan --}}
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Bandara Tujuan:</label>
            <select name="arrival_airport_id" required style="width: 100%; max-width: 320px; padding: 6px;">
                <option value="">-- Pilih Bandara Tujuan --</option>
                @foreach ($airports as $airport)
                    <option value="{{ $airport->id }}" {{ old('arrival_airport_id', request('arrival_airport_id')) == $airport->id ? 'selected' : '' }}>
                        {{ $airport->city }} ({{ $airport->code }}) - {{ $airport->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal Keberangkatan --}}
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Tanggal Keberangkatan:</label>
            <input type="date" name="date" value="{{ old('date', request('date')) }}" required style="width: 100%; max-width: 320px; padding: 6px;">
        </div>

        <button type="submit" style="padding: 8px 16px; cursor: pointer;">Cari Jadwal</button>
    </form>
@endsection