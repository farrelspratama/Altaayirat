@extends('layouts.app')

@section('title', 'Daftar - Altaayirat')

@section('content')
    <h1>Daftar Akun</h1>

    {{-- Partial komponen error validasi --}}
    @include('partials.errors')

    <form action="{{ route('auth.register') }}" method="POST">
        @csrf

        <div style="margin-bottom: 15px;">
            <label for="name" style="display: block; font-weight: bold; margin-bottom: 5px;">Nama:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required style="width: 100%; max-width: 320px; padding: 6px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="email" style="display: block; font-weight: bold; margin-bottom: 5px;">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required style="width: 100%; max-width: 320px; padding: 6px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="password" style="display: block; font-weight: bold; margin-bottom: 5px;">Password:</label>
            <input type="password" name="password" id="password" required style="width: 100%; max-width: 320px; padding: 6px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password_confirmation" style="display: block; font-weight: bold; margin-bottom: 5px;">Ulangi Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required style="width: 100%; max-width: 320px; padding: 6px;">
        </div>

        <button type="submit" style="padding: 8px 16px; cursor: pointer;">Daftar</button>
    </form>

    <p style="margin-top: 15px;">Sudah punya akun? <a href="{{ route('auth.login.form') }}">Login di sini</a></p>
@endsection