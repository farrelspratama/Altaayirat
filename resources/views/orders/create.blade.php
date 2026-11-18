@extends('layouts.app')

@section('title', 'Pilih Kursi & Isi Data Penumpang')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-stone-200">
        {{-- Header & Ringkasan Jadwal --}}
        <h1 class="text-xl font-semibold text-stone-800 mb-1">Pilih Kursi & Data Penumpang</h1>
        <p class="text-sm text-stone-500 mb-6">
            {{ $schedule->route->departureAirport->city }} &rarr; {{ $schedule->route->arrivalAirport->city }} &bull;
            {{ $schedule->departure->format('d M Y, H:i') }} WIB &bull;
            {{ $schedule->plane->airline->name }}
        </p>

        {{-- Komponen error validasi terpusat --}}
        @include('partials.errors')

        <form action="{{ route('orders.store', $schedule) }}" method="POST">
            @csrf

            {{-- Bagian Pemilihan Kursi --}}
            <div class="mb-6">
                <h3 class="text-sm font-medium text-stone-700 mb-2">Pilih Kursi</h3>

                {{-- Legenda Status Warna Kursi --}}
                <div class="flex items-center gap-4 text-xs text-stone-500 mb-4">
                    <span class="flex items-center gap-1.5">
                        <span class="w-3.5 h-3.5 rounded-sm border border-stone-300 bg-white"></span>
                        Tersedia
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3.5 h-3.5 rounded-sm bg-brand-600"></span>
                        Dipilih
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3.5 h-3.5 rounded-sm bg-stone-100 border border-stone-200"></span>
                        Sudah dipesan
                    </span>
                </div>

                {{-- Pengelompokan Kursi Berdasarkan Kelas --}}
                @foreach ($seats->groupBy(fn($seat) => $seat->flightClass->name) as $className => $seatsInClass)
                    <p class="text-xs font-semibold text-stone-500 uppercase tracking-wider mb-2">
                        Kelas {{ $className }}
                    </p>

                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-2 mb-6">
                        @foreach ($seatsInClass as $seat)
                            <label class="relative block">
                                {{-- Radio tersembunyi dengan penanda 'peer' --}}
                                <input type="radio" name="seat_id" value="{{ $seat->id }}" class="peer sr-only"
                                    @disabled($seat->status !== 'tersedia') @checked(old('seat_id') == $seat->id) required>

                                {{-- Kotak visual yang bereaksi terhadap state 'peer' --}}
                                <div
                                    class="cursor-pointer select-none rounded-md border border-stone-300 text-center py-2 text-sm font-medium text-stone-700 
                                                hover:border-brand-400 transition
                                                peer-checked:bg-brand-600 peer-checked:text-white peer-checked:border-brand-600 peer-checked:shadow-sm
                                                peer-disabled:bg-stone-100 peer-disabled:text-stone-400 peer-disabled:cursor-not-allowed peer-disabled:border-stone-200">
                                    {{ $seat->seat_number }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <hr class="border-stone-200 my-6">
            
            {{-- Bagian Data Penumpang --}}
            <h3 class="text-sm font-medium text-stone-700 mb-2">Data Penumpang</h3>

            {{-- Nama Lengkap --}}
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Nama Lengkap</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Contoh: Budi Santoso"
                    class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                    required>
                <p class="mt-1 text-xs text-stone-500">
                    * Harap isi dengan nama depan dan belakang sesuai KTP/identitas.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                {{-- Nomor HP --}}
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Nomor HP</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                        placeholder="Contoh: 08123456789"
                        class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                        required>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com"
                        class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                        required>
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                        class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                        required>
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Jenis Kelamin</label>
                    <select name="gender"
                        class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                        required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" @selected(old('gender') == 'L')>Laki-laki</option>
                        <option value="P" @selected(old('gender') == 'P')>Perempuan</option>
                    </select>
                </div>
            </div>

            {{-- Tombol Konfirmasi --}}
            <button type="submit"
                class="w-full bg-brand-600 text-white font-medium py-2 rounded-md hover:bg-brand-700 transition">
                Konfirmasi Pesan
            </button>
        </form>
    </div>
@endsection