@extends('layouts.app')

@section('title', 'Cari Penerbangan')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-slate-200">
        
        <h1 class="text-xl font-semibold text-slate-800">Cari Penerbangan</h1>
        <p class="text-sm text-slate-500 mb-6">Temukan jadwal penerbangan yang sesuai untuk perjalananmu.</p>
        
        @include('partials.errors')

        <form action="{{ route('schedules.results') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Bandara Asal --}}
            <div>
                <label for="departure_airport_id" class="block text-sm font-medium text-slate-700 mb-1">Dari</label>
                <select name="departure_airport_id" id="departure_airport_id" required
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    <option value="">-- Pilih Asal --</option>
                    @foreach ($airports as $airport)
                        <option value="{{ $airport->id }}" @selected(old('departure_airport_id', request('departure_airport_id')) == $airport->id)>
                            {{ $airport->city }} ({{ $airport->code }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="arrival_airport_id" class="block text-sm font-medium text-slate-700 mb-1">Ke</label>
                <select name="arrival_airport_id" id="arrival_airport_id" required
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    <option value="">-- Pilih Tujuan --</option>
                    @foreach ($airports as $airport)
                        <option value="{{ $airport->id }}" @selected(old('arrival_airport_id', request('arrival_airport_id')) == $airport->id)>
                            {{ $airport->city }} ({{ $airport->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date" class="block text-sm font-medium text-slate-700 mb-1">Tanggal</label>
                <input type="date" name="date" id="date" value="{{ old('date', request('date')) }}" required
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
            </div>
            
            <div class="md:col-span-3 pt-2">
                <button type="submit"
                    class="w-full bg-sky-600 text-white font-medium py-2.5 rounded-md hover:bg-sky-700 cursor-pointer transition shadow-sm">
                    Cari Penerbangan
                </button>
            </div>
        </form>
    </div>
@endsection