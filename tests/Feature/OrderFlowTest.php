<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Passenger;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesFlightData;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase, CreatesFlightData;

    public function test_tamu_diarahkan_ke_login_saat_membuka_atau_memesan(): void
    {
        $schedule = $this->makeSchedule();
        $seat = $this->makeSeat($schedule->plane);

        $this->get(route('orders.create', $schedule))->assertRedirect(route('auth.login.form'));
        $this->post(route('orders.store', $schedule), $this->bookingData($seat))
            ->assertRedirect(route('auth.login.form'));

        $this->assertSame(0, Order::count());
    }

    public function test_form_pemesanan_menampilkan_kursi_pesawat_jadwal_itu(): void
    {
        $schedule = $this->makeSchedule();
        $this->makeSeat($schedule->plane, 'A07');

        $this->actingAs($this->makeUser())
            ->get(route('orders.create', $schedule))
            ->assertOk()
            ->assertSee('A07');
    }

    public function test_jadwal_yang_tidak_ada_memberi_404(): void
    {
        $this->actingAs($this->makeUser())
            ->get(route('orders.create', 99999))
            ->assertNotFound();
    }

    public function test_pemesanan_berhasil_membuat_penumpang_order_dan_pembayaran_menunggu(): void
    {
        $user = $this->makeUser();
        $schedule = $this->makeSchedule();
        $seat = $this->makeSeat($schedule->plane);

        $response = $this->actingAs($user)
            ->post(route('orders.store', $schedule), $this->bookingData($seat));

        $order = Order::firstOrFail();
        $response->assertRedirect(route('orders.show', $order));

        $this->assertSame($user->id, $order->user_id);
        $this->assertSame($schedule->id, $order->schedule_id);
        $this->assertSame($seat->id, $order->seat_id);
        $this->assertDatabaseHas('passengers', ['id' => $order->passenger_id, 'full_name' => 'Budi Santoso']);
        $this->assertDatabaseHas('payments', ['order_id' => $order->id, 'status' => 'menunggu_konfirmasi']);
        $this->assertSame('dipesan', $seat->fresh()->status);
    }

    public function test_order_selalu_atas_nama_user_yang_login_bukan_yang_dikirim_di_request(): void
    {
        $penyerang = $this->makeUser();
        $korban = $this->makeUser();
        $schedule = $this->makeSchedule();
        $seat = $this->makeSeat($schedule->plane);

        $this->actingAs($penyerang)
            ->post(route('orders.store', $schedule), $this->bookingData($seat, ['user_id' => $korban->id]));

        $this->assertSame($penyerang->id, Order::firstOrFail()->user_id);
    }

    /**
     * Ini bukan bukti lockForUpdate() menahan dua permintaan SERENTAK
     * (SQLite satu proses tidak bisa menguji itu). Yang dibuktikan di sini:
     * begitu kursi sudah dipesan, pemesan berikutnya ditolak dan datanya bersih.
     */
    public function test_kursi_yang_sudah_dipesan_ditolak_untuk_pemesan_kedua(): void
    {
        $schedule = $this->makeSchedule();
        $seat = $this->makeSeat($schedule->plane);
        $pertama = $this->makeUser();
        $kedua = $this->makeUser();

        $this->actingAs($pertama)->post(route('orders.store', $schedule), $this->bookingData($seat));

        $this->actingAs($kedua)
            ->post(route('orders.store', $schedule), $this->bookingData($seat, ['full_name' => 'Orang Kedua']))
            ->assertSessionHasErrors('seat_id');

        $this->assertSame(1, Order::count());
        $this->assertSame(1, Payment::count());
        $this->assertSame(1, Passenger::count());          // tidak ada penumpang "yatim"
        $this->assertSame($pertama->id, Order::first()->user_id);
    }

    public function test_kursi_tidak_tersedia_ditolak(): void
    {
        $schedule = $this->makeSchedule();
        $seat = $this->makeSeat($schedule->plane);
        $seat->update(['status' => 'tidak_tersedia']);

        $this->actingAs($this->makeUser())
            ->post(route('orders.store', $schedule), $this->bookingData($seat))
            ->assertSessionHasErrors('seat_id');

        $this->assertSame(0, Order::count());
    }

    public function test_validasi_form_pemesanan(): void
    {
        $schedule = $this->makeSchedule();
        $seat = $this->makeSeat($schedule->plane);
        $this->actingAs($this->makeUser());

        $kasus = [
            'seat_id kosong' => [['seat_id' => ''], 'seat_id'],
            'seat_id tidak ada' => [['seat_id' => 99999], 'seat_id'],
            'nama kosong' => [['full_name' => ''], 'full_name'],
            'telepon kosong' => [['phone_number' => ''], 'phone_number'],
            'email salah' => [['email' => 'bukan-email'], 'email'],
            'lahir di masa depan' => [['birth_date' => now()->addDay()->toDateString()], 'birth_date'],
            'gender di luar L/P' => [['gender' => 'X'], 'gender'],
        ];

        foreach ($kasus as [$override, $field]) {
            $this->post(route('orders.store', $schedule), $this->bookingData($seat, $override))
                ->assertSessionHasErrors($field);
        }

        $this->assertSame(0, Order::count());
    }

    /**
     * BUG YANG DITEMUKAN: OrderController::store() hanya memeriksa status kursi,
     * tidak memeriksa apakah kursi itu milik pesawat pada jadwal yang dipesan.
     * Tes ini GAGAL sampai perbaikan di panduan diterapkan.
     */
    public function test_kursi_milik_pesawat_lain_ditolak(): void
    {
        $schedule = $this->makeSchedule();                 // pesawat X
        $kursiPesawatLain = $this->makeSeat($this->makePlane(), 'A01');   // pesawat Y

        $this->actingAs($this->makeUser())
            ->post(route('orders.store', $schedule), $this->bookingData($kursiPesawatLain))
            ->assertSessionHasErrors('seat_id');

        $this->assertSame(0, Order::count());
        $this->assertSame('tersedia', $kursiPesawatLain->fresh()->status);
    }
}