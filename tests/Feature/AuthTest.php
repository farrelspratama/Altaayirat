<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\Concerns\CreatesFlightData;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, CreatesFlightData;

    public function test_register_membuat_user_dengan_password_ter_hash_dan_role_user(): void
    {
        $response = $this->post(route('auth.register'), [
            'name' => 'Budi',
            'email' => 'budi@example.test',
            'password' => 'Rahasia123!',
            'password_confirmation' => 'Rahasia123!',
        ]);

        $response->assertRedirect(route('schedules.search'));
        $this->assertAuthenticated();

        $user = User::where('email', 'budi@example.test')->firstOrFail();
        $this->assertSame('user', $user->role);
        $this->assertNotSame('Rahasia123!', $user->password);   // tidak disimpan mentah
        $this->assertTrue(Hash::check('Rahasia123!', $user->password));
    }

    public function test_register_tidak_bisa_memilih_role_sendiri(): void
    {
        // Celah klasik: penyerang menambahkan field role=admin di request.
        $this->post(route('auth.register'), [
            'name' => 'Penyerang',
            'email' => 'x@example.test',
            'password' => 'Rahasia123!',
            'password_confirmation' => 'Rahasia123!',
            'role' => 'admin',
        ]);

        $this->assertSame('user', User::where('email', 'x@example.test')->value('role'));
    }

    public function test_register_menolak_email_yang_sudah_terdaftar(): void
    {
        $this->makeUser('user', ['email' => 'dobel@example.test']);

        $this->post(route('auth.register'), [
            'name' => 'Lain',
            'email' => 'dobel@example.test',
            'password' => 'Rahasia123!',
            'password_confirmation' => 'Rahasia123!',
        ])->assertSessionHasErrors('email');

        $this->assertSame(1, User::where('email', 'dobel@example.test')->count());
    }

    public function test_register_menolak_password_pendek_atau_tidak_cocok(): void
    {
        $this->post(route('auth.register'), [
            'name' => 'A', 'email' => 'a@example.test',
            'password' => 'pendek', 'password_confirmation' => 'pendek',
        ])->assertSessionHasErrors('password');

        $this->post(route('auth.register'), [
            'name' => 'A', 'email' => 'a@example.test',
            'password' => 'Rahasia123!', 'password_confirmation' => 'Beda12345!',
        ])->assertSessionHasErrors('password');
    }

    public function test_login_berhasil_dengan_kredensial_benar(): void
    {
        $user = $this->makeUser('user', ['email' => 'ani@example.test', 'password' => 'Rahasia123!']);

        $this->post(route('auth.login'), ['email' => 'ani@example.test', 'password' => 'Rahasia123!'])
            ->assertRedirect();

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_gagal_memberi_pesan_yang_sama_untuk_email_salah_dan_password_salah(): void
    {
        $this->makeUser('user', ['email' => 'ani@example.test', 'password' => 'Rahasia123!']);

        $passwordSalah = $this->post(route('auth.login'), ['email' => 'ani@example.test', 'password' => 'salah']);
        $emailSalah = $this->post(route('auth.login'), ['email' => 'tidakada@example.test', 'password' => 'salah']);

        $this->assertGuest();
        // Pesan identik: penyerang tidak bisa membedakan "email tidak ada" dari "password salah".
        $passwordSalah->assertSessionHasErrors(['email' => 'Email atau password salah.']);
        $emailSalah->assertSessionHasErrors(['email' => 'Email atau password salah.']);
    }

    public function test_logout_mengakhiri_sesi(): void
    {
        $this->actingAs($this->makeUser());

        $this->post(route('auth.logout'));

        $this->assertGuest();
    }

    public function test_user_yang_sudah_login_tidak_bisa_membuka_halaman_login(): void
    {
        $this->actingAs($this->makeUser())
            ->get(route('auth.login.form'))
            ->assertRedirect();
    }
}