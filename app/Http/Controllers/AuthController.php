<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Meski kita sudah set casts 'password' => 'hashed' di model User
        // (artinya password OTOMATIS di-hash setiap kali diisi), kita tidak
        // perlu manual panggil Hash::make() di sini - cukup masukkan
        // password mentahnya, Eloquent yang urus proses hashing di belakang layar.
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'user',
        ]);

        // Langsung login-kan user setelah berhasil daftar, supaya tidak
        // perlu login manual lagi setelah register (pengalaman lebih baik).
        Auth::login($user);

        // WAJIB dipanggil setelah login berhasil - meregenerasi ID session
        // untuk mencegah "session fixation attack" (celah keamanan di mana
        // penyerang bisa membajak session ID yang sudah ada SEBELUM user login).
        $request->session()->regenerate();

        return redirect()->route('schedules.search')
            ->with('status', 'Pendaftaran berhasil! Selamat datang, ' . $user->name . '.');
    }

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        // Auth::attempt() melakukan 3 hal sekaligus:
        // 1. Cari user dengan email yang cocok
        // 2. Bandingkan password yang dikirim dengan hash tersimpan (Hash::check otomatis)
        // 3. Kalau cocok, simpan status login ke session, dan return true
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('schedules.search'))
                ->with('status', 'Berhasil login.');
        }

        // Kalau gagal, balik ke form dengan 1 pesan error umum.
        // SENGAJA tidak dibedakan "email tidak ada" vs "password salah" -
        // ini praktik keamanan standar supaya orang tidak bisa menebak-nebak
        // email mana saja yang terdaftar di sistem kita.
        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        // Hancurkan session lama sepenuhnya, lalu buat token CSRF baru -
        // mencegah session lama dipakai ulang oleh siapapun.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login.form')
            ->with('status', 'Kamu sudah logout.');
    }
}
