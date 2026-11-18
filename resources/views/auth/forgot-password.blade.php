@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="mx-auto max-w-md">
    <div class="rounded-2xl border border-stone-200 bg-white p-8">
        <h1 class="text-xl font-bold tracking-tight text-stone-900">Lupa password?</h1>
        <p class="mt-2 text-sm text-stone-600">
            Masukkan email akunmu dan password baru.
        </p>

        @if ($errors->any())
            <div class="mt-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="mt-6 space-y-4">
            @csrf

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-stone-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm
                              focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-stone-700">Password baru</label>
                <input type="password" name="password" id="password" required minlength="8"
                       class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm
                              focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500">
                <p class="mt-1 text-xs text-stone-500">Minimal 8 karakter.</p>
            </div>

            <div>
                <label for="password_confirmation" class="mb-1 block text-sm font-medium text-stone-700">Ulangi password baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm
                              focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <button type="submit"
                    class="w-full rounded-md bg-brand-600 px-4 py-2.5 font-medium text-white transition hover:bg-brand-700">
                Simpan Password Baru
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-stone-600">
            <a href="{{ route('auth.login.form') }}" class="font-medium text-brand-700 hover:underline">&larr; Kembali ke login</a>
        </p>
    </div>
</div>
@endsection