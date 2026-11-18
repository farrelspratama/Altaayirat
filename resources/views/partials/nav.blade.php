@php
    $isStaff = auth()->check() && in_array(auth()->user()->role, ['admin', 'penjual']);

    $userLinks = [
        ['Beranda',   route('home'),            request()->routeIs('home')],
        ['Cari Tiket', route('schedules.search'), request()->routeIs('schedules.search', 'schedules.results')],
    ];

    $staffLinks = [
        ['Konfirmasi', route('payments.index'),  request()->routeIs('payments.*')],
        ['Maskapai',   route('airlines.index'),  request()->routeIs('airlines.*')],
        ['Bandara',    route('airports.index'),  request()->routeIs('airports.*')],
        ['Pesawat',    route('planes.index'),    request()->routeIs('planes.*')],
        ['Rute',       route('routes.index'),    request()->routeIs('routes.*')],
        ['Jadwal',     route('schedules.index'), request()->routeIs('schedules.index', 'schedules.create', 'schedules.edit')],
    ];

    $linkClass = fn ($active) => $active
        ? 'text-stone-900 font-medium'
        : 'text-stone-500 hover:text-stone-900 transition-colors';
@endphp

<header class="sticky top-0 z-40 bg-canvas/80 backdrop-blur border-b border-stone-200">
    <nav class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between gap-6">

        {{-- Logo: bulan sabit kuning di atas kotak gelap, supaya terbaca di latar terang --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0">
            <span class="grid h-9 w-9 place-items-center rounded-xl bg-stone-900">
                <img src="{{ asset('images/logo.png') }}" alt="" class="h-5 w-auto">
            </span>
            <span class="font-semibold tracking-tight text-stone-900">Al-Taayirat</span>
        </a>

        {{-- Menu desktop --}}
        <div class="hidden md:flex items-center gap-6 text-sm">
            @foreach ($userLinks as [$label, $url, $active])
                <a href="{{ $url }}" class="{{ $linkClass($active) }}">{{ $label }}</a>
            @endforeach

            @if ($isStaff)
                <details class="relative">
                    <summary class="cursor-pointer list-none text-stone-500 hover:text-stone-900 transition-colors select-none">
                        Kelola &#9662;
                    </summary>
                    <div class="absolute right-0 mt-3 w-44 rounded-xl border border-stone-200 bg-white p-1 shadow-lg">
                        @foreach ($staffLinks as [$label, $url, $active])
                            <a href="{{ $url }}"
                               class="block rounded-lg px-3 py-2 text-sm hover:bg-stone-100 {{ $active ? 'text-stone-900 font-medium' : 'text-stone-600' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </details>
            @endif
        </div>

        {{-- Aksi akun --}}
        <div class="hidden md:flex items-center gap-2 text-sm">
            @auth
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="rounded-lg px-4 py-2 text-stone-600 hover:bg-stone-100 transition-colors">
                        Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('auth.login.form') }}"
                   class="rounded-lg px-4 py-2 text-stone-600 hover:bg-stone-100 transition-colors">Masuk</a>
                <a href="{{ route('auth.register.form') }}"
                   class="rounded-lg bg-brand-600 px-4 py-2 font-medium text-white hover:bg-brand-700 transition-colors">Daftar</a>
            @endauth
        </div>

        {{-- Menu mobile: <details> bawaan HTML, tanpa JavaScript --}}
        <details class="md:hidden">
            <summary class="grid h-10 w-10 cursor-pointer list-none place-items-center rounded-lg hover:bg-stone-100"
                     aria-label="Menu">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </summary>
            <div class="absolute inset-x-0 top-16 border-b border-stone-200 bg-white px-4 py-3 shadow-sm">
                @foreach (array_merge($userLinks, $isStaff ? $staffLinks : []) as [$label, $url, $active])
                    <a href="{{ $url }}" class="block py-2 text-sm {{ $linkClass($active) }}">{{ $label }}</a>
                @endforeach

                <div class="mt-2 border-t border-stone-100 pt-3">
                    @auth
                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm text-stone-600">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('auth.login.form') }}" class="mr-4 text-sm text-stone-600">Masuk</a>
                        <a href="{{ route('auth.register.form') }}" class="text-sm font-medium text-brand-600">Daftar</a>
                    @endauth
                </div>
            </div>
        </details>
    </nav>
</header>