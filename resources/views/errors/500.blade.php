<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 Terjadi kesalahan — Al-Taayirat</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen grid place-items-center bg-canvas px-4 font-sans text-stone-800 antialiased">
    {{-- Halaman ini berdiri sendiri (tanpa layouts.app dan tanpa @auth).
         Penyebab error 500 bisa saja database atau sesi yang mati; kalau halaman
         error ikut membutuhkan keduanya, ia ikut gagal dan pengguna melihat layar kosong. --}}
    <div class="max-w-md text-center">
        <p class="text-7xl font-bold tracking-tight text-brand-300">500</p>
        <h1 class="mt-4 text-2xl font-bold tracking-tight text-stone-900">Terjadi kesalahan di server</h1>
        <p class="mt-3 text-stone-600">
            Maaf, ada masalah di pihak kami. Coba muat ulang beberapa saat lagi.
        </p>
        <a href="/" class="mt-8 inline-block rounded-xl bg-stone-900 px-6 py-3 font-medium text-white hover:bg-stone-700 transition-colors">
            Ke Beranda
        </a>
    </div>
</body>
</html>
