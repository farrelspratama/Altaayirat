{{-- Kerangka bersama untuk 403, 404, 419. Tiap halaman hanya mengisi kode, judul, dan pesan. --}}
@extends('layouts.app')

@section('title', $__env->yieldContent('code') . ' ' . $__env->yieldContent('heading'))

@section('content')
<div class="mx-auto max-w-md py-16 text-center">
    <p class="text-7xl font-bold tracking-tight text-brand-300">@yield('code')</p>

    <h1 class="mt-4 text-2xl font-bold tracking-tight text-stone-900">@yield('heading')</h1>
    <p class="mt-3 text-stone-600">@yield('message')</p>

    <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
        <a href="{{ route('home') }}"
           class="rounded-xl bg-stone-900 px-6 py-3 font-medium text-white hover:bg-stone-700 transition-colors">
            Ke Beranda
        </a>
        <a href="javascript:history.back()"
           class="rounded-xl px-6 py-3 font-medium text-brand-700 hover:bg-brand-100 transition-colors">
            Kembali
        </a>
    </div>
</div>
@endsection
