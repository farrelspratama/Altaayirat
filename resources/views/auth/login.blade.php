@extends('layouts.app')

@section('title', 'Login - Altaayirat')

@section('content')
    <h1>Login</h1>

    {{-- Komponen error validasi terpusat --}}
    @include('partials.errors')

    <form action="{{ route('auth.login') }}" method="POST">
        @csrf

        <div style="margin-bottom: 15px;">
            <label for="email" style="display: block; font-weight: bold; margin-bottom: 5px;">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required style="width: 100%; max-width: 320px; padding: 6px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password" style="display: block; font-weight: bold; margin-bottom: 5px;">Password:</label>
            <input type="password" name="password" id="password" required style="width: 100%; max-width: 320px; padding: 6px;">
        </div>

        <button type="submit" style="padding: 8px 16px; cursor: pointer;">Login</button>
    </form>

    <p style="margin-top: 15px;">Belum punya akun? <a href="{{ route('auth.register.form') }}">Daftar di sini</a></p>
@endsection