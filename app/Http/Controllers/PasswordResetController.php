<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    public function request(): View
    {
        return view('auth.forgot-password');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        if (in_array($user->role, ['admin', 'penjual'])) {
            return back()->withErrors(['email' => 'Akun staff tidak bisa direset dari sini.']);
        }

        $user->forceFill(['password' => $validated['password']])->save();

        return redirect()->route('auth.login.form')
            ->with('status', 'Password berhasil diubah. Silakan masuk dengan password baru.');
    }
}