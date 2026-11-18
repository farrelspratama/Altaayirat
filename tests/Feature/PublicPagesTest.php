<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_home_bisa_dibuka_tanpa_login(): void
    {
        $this->get('/')->assertOk()->assertSee('Al-Taayirat');
    }

    public function test_halaman_pencarian_bisa_dibuka_tanpa_login(): void
    {
        $this->get(route('schedules.search'))->assertOk();
    }

    public function test_url_yang_tidak_ada_menampilkan_halaman_404_kustom(): void
    {
        $this->get('/halaman-yang-tidak-ada')
            ->assertNotFound()
            ->assertSee('Halaman tidak ditemukan');
    }
}
