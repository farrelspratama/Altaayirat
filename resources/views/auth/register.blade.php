@extends('layouts.app')

@section('title', 'Daftar - Altaayirat')

@section('content')
    <div class="max-w-sm mx-auto bg-white p-8 rounded-lg shadow-sm border border-slate-200">
        <h1 class="text-xl font-semibold text-slate-800 mb-6 text-center">Daftar Akun</h1>

        @include('partials.errors')

        <form action="{{ route('auth.register') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password" id="password" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Ulangi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
            </div>

            <button type="submit" class="w-full bg-sky-600 text-white font-medium py-2 rounded-md hover:bg-sky-700 cursor-pointer transition">
                Daftar
            </button>
        </form>

        <p class="mt-4 text-sm text-slate-600 text-center">
            Sudah punya akun? <a href="{{ route('auth.login.form') }}" class="text-sky-600 hover:underline">Login di sini</a>
        </p>
    </div>
@endsection