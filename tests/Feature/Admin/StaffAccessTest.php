<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Concerns\CreatesFlightData;
use Tests\TestCase;

class StaffAccessTest extends TestCase
{
    use RefreshDatabase, CreatesFlightData;

    /** Semua halaman khusus staff. Satu daftar, dipakai oleh semua tes di bawah. */
    public static function halamanStaff(): array
    {
        return [
            'konfirmasi pembayaran' => ['payments.index'],
            'maskapai' => ['airlines.index'],
            'bandara' => ['airports.index'],
            'pesawat' => ['planes.index'],
            'rute' => ['routes.index'],
            'jadwal' => ['schedules.index'],
        ];
    }

    #[DataProvider('halamanStaff')]
    public function test_tamu_diarahkan_ke_login(string $routeName): void
    {
        $this->get(route($routeName))->assertRedirect(route('auth.login.form'));
    }

    #[DataProvider('halamanStaff')]
    public function test_user_biasa_mendapat_403(string $routeName): void
    {
        $this->actingAs($this->makeUser('user'))
            ->get(route($routeName))
            ->assertForbidden();
    }

    #[DataProvider('halamanStaff')]
    public function test_admin_bisa_masuk(string $routeName): void
    {
        $this->actingAs($this->makeUser('admin'))
            ->get(route($routeName))
            ->assertOk();
    }

    #[DataProvider('halamanStaff')]
    public function test_penjual_bisa_masuk(string $routeName): void
    {
        $this->actingAs($this->makeUser('penjual'))
            ->get(route($routeName))
            ->assertOk();
    }

    public function test_user_biasa_tidak_bisa_mengubah_data_master_lewat_post(): void
    {
        // Bukan hanya halaman GET yang dilindungi, aksi tulis juga.
        $this->actingAs($this->makeUser('user'))
            ->post(route('airlines.store'), ['name' => 'Maskapai Gelap'])
            ->assertForbidden();

        $this->assertDatabaseMissing('airlines', ['name' => 'Maskapai Gelap']);
    }
}
