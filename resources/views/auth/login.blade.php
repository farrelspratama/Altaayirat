@extends('layouts.app')

@section('title', 'Login - Altaayirat')

@section('content')
    <div class="max-w-sm mx-auto bg-white p-8 rounded-lg shadow-sm border border-stone-200">
        <h1 class="text-xl font-semibold text-stone-800 mb-6 text-center">Login</h1>

        @include('partials.errors')

        <form action="{{ route('auth.login') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-stone-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-stone-700 mb-1">Password</label>
                <input type="password" name="password" id="password" class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" required>
            </div>

            <button type="submit" class="w-full bg-brand-600 text-white font-medium py-2 rounded-md hover:bg-brand-700 cursor-pointer transition">
                Login
            </button>
        </form>

        <p class="mt-4 text-sm text-stone-600 text-center">
            Belum punya akun? <a href="{{ route('auth.register.form') }}" class="text-brand-600 hover:underline">Daftar di sini</a>
        </p>
    </div>
@endsection