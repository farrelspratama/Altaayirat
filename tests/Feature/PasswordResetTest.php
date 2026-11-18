<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\Concerns\CreatesFlightData;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase, CreatesFlightData;

    public function test_password_berhasil_diganti_lalu_bisa_login_dengan_password_baru(): void
    {
        $user = $this->makeUser('user', ['email' => 'ani@example.test', 'password' => 'lama12345']);

        $this->post(route('password.update'), [
            'email' => 'ani@example.test',
            'password' => 'baru12345',
            'password_confirmation' => 'baru12345',
        ])->assertRedirect(route('auth.login.form'));

        $this->assertTrue(Hash::check('baru12345', $user->fresh()->password));
        $this->assertFalse(Hash::check('lama12345', $user->fresh()->password));
    }

    public function test_email_tidak_terdaftar_ditolak(): void
    {
        $this->post(route('password.update'), [
            'email' => 'hantu@example.test',
            'password' => 'baru12345',
            'password_confirmation' => 'baru12345',
        ])->assertSessionHasErrors('email');
    }

    public function test_konfirmasi_password_harus_cocok(): void
    {
        $user = $this->makeUser('user', ['password' => 'lama12345']);

        $this->post(route('password.update'), [
            'email' => $user->email,
            'password' => 'baru12345',
            'password_confirmation' => 'beda12345',
        ])->assertSessionHasErrors('password');

        $this->assertTrue(Hash::check('lama12345', $user->fresh()->password));
    }
}
