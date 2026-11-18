<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Al-Taayirat — Pesan Tiket Pesawat yang Aman dan Halal</title>
    <meta name="description" content="Tempat memesan tiket pesawat yang aman dan halal.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#A7672D] text-white antialiased">

    {{-- NAVBAR: hitam transparan, fixed di atas, hover kuning (sama seperti versi lama) --}}
    <nav class="fixed top-0 inset-x-0 z-50 bg-black/80 hover:bg-black/90 backdrop-blur transition-colors">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Al-Taayirat" class="h-9 w-auto">
                <span class="text-xl font-semibold">Al-Taayirat</span>
            </a>

            <div class="hidden md:flex items-center gap-8 text-[17px]">
                <a href="#beranda" class="hover:text-yellow-300 transition-colors">Beranda</a>
                <a href="#keunggulan" class="hover:text-yellow-300 transition-colors">Keunggulan</a>
                <a href="#cara-pesan" class="hover:text-yellow-300 transition-colors">Cara Pesan</a>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="px-5 py-2 border border-white rounded-md hover:bg-yellow-300 hover:text-black hover:border-yellow-300 active:opacity-50 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('auth.login.form') }}"
                       class="px-5 py-2 border border-white rounded-md hover:bg-yellow-300 hover:text-black hover:border-yellow-300 active:opacity-50 transition">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <header id="beranda" class="pt-28 pb-16 md:pt-36 md:pb-24">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-10 items-center">
            <div class="text-center md:text-left">
                <p class="text-yellow-300 font-medium tracking-widest text-sm mb-3">SELAMAT DATANG</p>
                <h1 class="text-4xl sm:text-5xl font-bold leading-tight">Al-Taayirat.com</h1>
                <p class="mt-4 text-lg sm:text-xl text-white/90">
                    Tempat memesan tiket yang aman dan halal.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center md:justify-start">
                    <a href="{{ route('schedules.search') }}"
                       class="inline-block bg-yellow-300 text-black font-semibold px-7 py-3 rounded-md hover:bg-yellow-200 active:opacity-80 transition">
                        Pesan Sekarang
                    </a>
                    @guest
                        <a href="{{ route('auth.register.form') }}"
                           class="inline-block border border-white/80 px-7 py-3 rounded-md hover:bg-white/10 transition">
                            Daftar Akun
                        </a>
                    @endguest
                </div>
            </div>

            <div>
                <picture>
                    <source srcset="{{ asset('images/hero-plane.webp') }}" type="image/webp">
                    <img src="{{ asset('images/hero-plane.png') }}" alt="Ilustrasi pesawat terbang"
                         class="w-full max-w-md mx-auto rounded-xl" width="900" height="900">
                </picture>
            </div>
        </div>
    </header>

    {{-- KEUNGGULAN --}}
    <section id="keunggulan" class="bg-black/70 py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl sm:text-3xl font-semibold text-center mb-10">Mengapa Al-Taayirat?</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-xl border border-white/15 bg-white/5 p-6">
                    <h3 class="text-yellow-300 font-semibold mb-2">Aman</h3>
                    <p class="text-white/80 text-sm leading-relaxed">
                        Data akun terlindungi dan setiap pesanan hanya bisa diakses oleh pemesannya.
                    </p>
                </div>
                <div class="rounded-xl border border-white/15 bg-white/5 p-6">
                    <h3 class="text-yellow-300 font-semibold mb-2">Pilih Kursi Sendiri</h3>
                    <p class="text-white/80 text-sm leading-relaxed">
                        Lihat kursi yang tersedia dan pilih sesuai keinginan. Kursi yang sudah dipesan tidak bisa dobel.
                    </p>
                </div>
                <div class="rounded-xl border border-white/15 bg-white/5 p-6">
                    <h3 class="text-yellow-300 font-semibold mb-2">E-Tiket Langsung</h3>
                    <p class="text-white/80 text-sm leading-relaxed">
                        Setelah pembayaran dikonfirmasi, e-tiket langsung tersedia di akunmu.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CARA PESAN --}}
    <section id="cara-pesan" class="py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl sm:text-3xl font-semibold text-center mb-10">Cara Memesan</h2>

            <ol class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach ([
                    ['Cari penerbangan', 'Pilih kota asal, tujuan, dan tanggal.'],
                    ['Pilih kursi', 'Tentukan kursi dan isi data penumpang.'],
                    ['Bayar', 'Lakukan pembayaran, lalu tunggu konfirmasi.'],
                    ['Terima e-tiket', 'Tiket muncul di akunmu setelah dikonfirmasi.'],
                ] as $i => [$title, $desc])
                    <li class="text-center">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-yellow-300 text-black font-bold mb-3">
                            {{ $i + 1 }}
                        </span>
                        <h3 class="font-semibold mb-1">{{ $title }}</h3>
                        <p class="text-white/80 text-sm">{{ $desc }}</p>
                    </li>
                @endforeach
            </ol>

            <div class="text-center mt-10">
                <a href="{{ route('schedules.search') }}"
                   class="inline-block bg-yellow-300 text-black font-semibold px-7 py-3 rounded-md hover:bg-yellow-200 transition">
                    Mulai Cari Tiket
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-black/80 text-center text-sm text-white/80 py-4">
        &copy; {{ date('Y') }} Al-Taayirat.com
    </footer>

</body>
</html>