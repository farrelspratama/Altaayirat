@extends('layouts.app')

@section('title', 'Pesan Tiket Pesawat')
@section('main_class', '')   {{-- lebar penuh: tiap section mengatur kontainernya sendiri --}}

@section('content')

{{-- HERO --}}
<section class="max-w-5xl mx-auto px-4 pt-14 pb-20 md:pt-24 md:pb-28 grid md:grid-cols-2 gap-12 items-center">
    <div>
        <span class="inline-flex items-center gap-2 rounded-full bg-brand-100 px-3 py-1 text-xs font-medium text-brand-800">
            <span class="h-1.5 w-1.5 rounded-full bg-accent"></span>
            Aman dan halal
        </span>

        <h1 class="mt-5 text-4xl sm:text-5xl font-bold tracking-tight text-stone-900 leading-[1.1]">
            Selamat datang di
            <span class="text-brand-600">Al-Taayirat</span>
        </h1>

        <p class="mt-5 text-lg text-stone-600 max-w-md">
            Tempat memesan tiket yang aman dan halal. Cari penerbangan, pilih kursi, dan terima e-tiket dalam satu alur.
        </p>

        <div class="mt-8 flex flex-wrap items-center gap-4">
            <a href="{{ route('schedules.search') }}"
               class="rounded-xl bg-stone-900 px-6 py-3 font-medium text-white hover:bg-stone-700 transition-colors">
                Pesan Sekarang
            </a>
            <a href="#cara-pesan" class="font-medium text-brand-700 hover:text-brand-900 transition-colors">
                Lihat cara pesan &rarr;
            </a>
        </div>
    </div>

    <div class="relative">
        {{-- Lingkaran kuning dekoratif di belakang panel --}}
        <div class="absolute -top-4 -right-4 h-24 w-24 rounded-full bg-accent/80" aria-hidden="true"></div>

        <div class="relative rounded-3xl bg-brand-100 p-8 sm:p-12">
            <picture>
                <source srcset="{{ asset('images/hero-plane.webp') }}" type="image/webp">
                <img src="{{ asset('images/hero-plane.png') }}" alt="Ilustrasi pesawat terbang"
                     class="mx-auto w-full max-w-xs" width="900" height="900">
            </picture>
        </div>
    </div>
</section>

{{-- KEUNGGULAN --}}
<section class="border-y border-stone-200 bg-white">
    <div class="max-w-5xl mx-auto px-4 py-16 grid gap-10 md:grid-cols-3">
        @foreach ([
            ['Aman', 'Data akun terlindungi, dan setiap pesanan hanya bisa dibuka oleh pemesannya.',
             'M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z'],
            ['Pilih kursi sendiri', 'Lihat kursi yang tersedia dan pilih sesuai keinginan. Kursi yang sudah dipesan tidak bisa dobel.',
             'M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z'],
            ['E-tiket langsung', 'Setelah pembayaran dikonfirmasi, e-tiket langsung tersedia di akunmu.',
             'M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z'],
        ] as [$title, $desc, $icon])
            <div>
                <span class="grid h-11 w-11 place-items-center rounded-xl bg-brand-100 text-brand-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/>
                    </svg>
                </span>
                <h3 class="mt-4 font-semibold text-stone-900">{{ $title }}</h3>
                <p class="mt-2 text-sm leading-relaxed text-stone-600">{{ $desc }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- CARA PESAN --}}
<section id="cara-pesan" class="max-w-5xl mx-auto px-4 py-20">
    <h2 class="text-2xl font-bold tracking-tight text-stone-900">Cara memesan</h2>
    <p class="mt-2 text-stone-600">Empat langkah, dari mencari sampai terbang.</p>

    <ol class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            ['Cari penerbangan', 'Pilih bandara asal, tujuan, dan tanggal.'],
            ['Pilih kursi', 'Tentukan kursi dan isi data penumpang.'],
            ['Bayar', 'Lakukan pembayaran, lalu tunggu konfirmasi.'],
            ['Terima e-tiket', 'Tiket muncul di akunmu setelah dikonfirmasi.'],
        ] as $i => [$title, $desc])
            <li>
                <span class="text-3xl font-bold text-brand-300">0{{ $i + 1 }}</span>
                <h3 class="mt-2 font-semibold text-stone-900">{{ $title }}</h3>
                <p class="mt-1 text-sm text-stone-600">{{ $desc }}</p>
            </li>
        @endforeach
    </ol>
</section>

{{-- CTA: satu-satunya blok gelap, mengingatkan pada tema hitam versi lama --}}
<section class="max-w-5xl mx-auto px-4 pb-20">
    <div class="rounded-3xl bg-stone-900 px-8 py-12 text-center">
        <h2 class="text-2xl font-bold text-white">Siap terbang?</h2>
        <p class="mt-2 text-stone-400">Temukan jadwal yang cocok sekarang.</p>
        <a href="{{ route('schedules.search') }}"
           class="mt-6 inline-block rounded-xl bg-accent px-6 py-3 font-semibold text-stone-900 hover:brightness-95 transition">
            Cari Tiket
        </a>
    </div>
</section>

@endsection