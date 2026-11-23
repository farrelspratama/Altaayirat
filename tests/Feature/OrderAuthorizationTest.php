<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesFlightData;
use Tests\TestCase;

/**
 * IDOR (Insecure Direct Object Reference): user A menebak ID milik user B
 * di URL (/pesanan/5, /tiket/5). Di versi lama ini lolos. Tes ini memastikan
 * kini selalu ditolak.
 */
class OrderAuthorizationTest extends TestCase
{
    use RefreshDatabase, CreatesFlightData;

    public function test_pemilik_bisa_melihat_pesanannya(): void
    {
        $user = $this->makeUser();
        $order = $this->makeFullOrder($user);

        $this->actingAs($user)->get(route('orders.show', $order))->assertOk();
    }

    public function test_user_lain_tidak_bisa_melihat_pesanan_orang(): void
    {
        $pemilik = $this->makeUser();
        $order = $this->makeFullOrder($pemilik);

        $this->actingAs($this->makeUser())
            ->get(route('orders.show', $order))
            ->assertForbidden();
    }

    public function test_staff_pun_tidak_otomatis_boleh_membuka_pesanan_orang(): void
    {
        // Staff mengonfirmasi pembayaran lewat panel, bukan lewat halaman pesanan user.
        $order = $this->makeFullOrder($this->makeUser());

        $this->actingAs($this->makeUser('admin'))
            ->get(route('orders.show', $order))
            ->assertForbidden();
    }

    public function test_tamu_diarahkan_ke_login_untuk_pesanan_dan_tiket(): void
    {
        $order = $this->makeFullOrder($this->makeUser(), 'lunas');

        $this->get(route('orders.show', $order))->assertRedirect(route('auth.login.form'));
        $this->get(route('tickets.show', $order))->assertRedirect(route('auth.login.form'));
    }

    public function test_pemilik_bisa_membuka_tiket_yang_sudah_lunas(): void
    {
        $user = $this->makeUser();
        $order = $this->makeFullOrder($user, 'lunas');

        $this->actingAs($user)
            ->get(route('tickets.show', $order))
            ->assertOk()
            ->assertSee($order->payment->ticket->ticket_code);
    }

    public function test_user_lain_tidak_bisa_membuka_tiket_walau_sudah_lunas(): void
    {
        $order = $this->makeFullOrder($this->makeUser(), 'lunas');

        $this->actingAs($this->makeUser())
            ->get(route('tickets.show', $order))
            ->assertForbidden();
    }

    public function test_tiket_belum_tersedia_selama_pembayaran_belum_lunas(): void
    {
        $user = $this->makeUser();

        foreach (['menunggu_konfirmasi', 'ditolak'] as $status) {
            $order = $this->makeFullOrder($user, $status);

            $this->actingAs($user)
                ->get(route('tickets.show', $order))
                ->assertNotFound();
        }
    }
}
