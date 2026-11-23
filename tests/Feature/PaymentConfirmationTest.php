<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesFlightData;
use Tests\TestCase;

class PaymentConfirmationTest extends TestCase
{
    use RefreshDatabase, CreatesFlightData;

    public function test_hanya_staff_yang_bisa_mengubah_status_pembayaran(): void
    {
        $order = $this->makeFullOrder($this->makeUser());
        $payment = $order->payment;

        // Tamu
        $this->post(route('payments.update', $payment), ['status' => 'lunas'])
            ->assertRedirect(route('auth.login.form'));

        // Pemilik order sendiri (user biasa) tidak boleh "melunasi" pesanannya
        $this->actingAs($order->user)
            ->post(route('payments.update', $payment), ['status' => 'lunas'])
            ->assertForbidden();

        $this->assertSame('menunggu_konfirmasi', $payment->fresh()->status);
        $this->assertSame(0, Ticket::count());
    }

    public function test_panel_hanya_menampilkan_pembayaran_yang_menunggu(): void
    {
        $menunggu = $this->makeFullOrder($this->makeUser(), 'menunggu_konfirmasi');
        $this->makeFullOrder($this->makeUser(), 'lunas');   // sudah lunas: tidak boleh tampil

        $this->actingAs($this->makeUser('admin'))
            ->get(route('payments.index'))
            ->assertOk()
            ->assertViewHas('payments', fn ($payments) => $payments->count() === 1
                && $payments->first()->id === $menunggu->payment->id);
    }

    public function test_konfirmasi_lunas_membuat_tiket_dengan_kode(): void
    {
        $order = $this->makeFullOrder($this->makeUser());

        $this->actingAs($this->makeUser('admin'))
            ->post(route('payments.update', $order->payment), ['status' => 'lunas'])
            ->assertRedirect(route('payments.index'));

        $this->assertSame('lunas', $order->payment->fresh()->status);

        $ticket = Ticket::where('payment_id', $order->payment->id)->firstOrFail();
        $this->assertStringStartsWith('TIX-', $ticket->ticket_code);
    }

    public function test_penjual_juga_boleh_mengonfirmasi(): void
    {
        $order = $this->makeFullOrder($this->makeUser());

        $this->actingAs($this->makeUser('penjual'))
            ->post(route('payments.update', $order->payment), ['status' => 'lunas']);

        $this->assertSame('lunas', $order->payment->fresh()->status);
    }

    public function test_penolakan_tidak_membuat_tiket(): void
    {
        $order = $this->makeFullOrder($this->makeUser());

        $this->actingAs($this->makeUser('admin'))
            ->post(route('payments.update', $order->payment), ['status' => 'ditolak']);

        $this->assertSame('ditolak', $order->payment->fresh()->status);
        $this->assertSame(0, Ticket::count());
    }

    public function test_status_di_luar_lunas_dan_ditolak_dianggap_tidak_valid(): void
    {
        $order = $this->makeFullOrder($this->makeUser());

        foreach (['', 'selesai', 'menunggu_konfirmasi'] as $status) {
            $this->actingAs($this->makeUser('admin'))
                ->post(route('payments.update', $order->payment), ['status' => $status])
                ->assertSessionHasErrors('status');
        }

        $this->assertSame('menunggu_konfirmasi', $order->payment->fresh()->status);
    }

    /**
     * BUG YANG DITEMUKAN: update() tidak memeriksa apakah pembayaran sudah
     * diproses. Staff yang menekan "lunas" dua kali (klik ganda, tab ganda)
     * membuat dua tiket untuk satu pembayaran, dan pembayaran yang sudah
     * "ditolak" bisa diubah jadi "lunas". Tes ini GAGAL sampai perbaikan
     * di panduan diterapkan.
     */
    public function test_pembayaran_yang_sudah_diproses_tidak_bisa_diproses_lagi(): void
    {
        $order = $this->makeFullOrder($this->makeUser());
        $admin = $this->makeUser('admin');

        $this->actingAs($admin)->post(route('payments.update', $order->payment), ['status' => 'lunas']);
        $this->actingAs($admin)
            ->post(route('payments.update', $order->payment), ['status' => 'lunas'])
            ->assertSessionHas('error');

        $this->assertSame(1, Ticket::where('payment_id', $order->payment->id)->count());
    }

    public function test_alur_lengkap_pesan_konfirmasi_lalu_tiket_terbuka(): void
    {
        $user = $this->makeUser();
        $schedule = $this->makeSchedule();
        $seat = $this->makeSeat($schedule->plane);

        $this->actingAs($user)->post(route('orders.store', $schedule), $this->bookingData($seat));
        $order = $user->orders()->firstOrFail();

        // Sebelum dikonfirmasi: tiket belum ada
        $this->actingAs($user)->get(route('tickets.show', $order))->assertNotFound();

        $this->actingAs($this->makeUser('admin'))
            ->post(route('payments.update', $order->payment), ['status' => 'lunas']);

        // Setelah dikonfirmasi: tiket terbuka untuk pemiliknya
        $this->actingAs($user)->get(route('tickets.show', $order))->assertOk();
    }
}
