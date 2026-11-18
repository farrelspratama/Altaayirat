<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesFlightData;
use Tests\TestCase;

/**
 * Migration memakai cascadeOnDelete, jadi menghapus induk yang masih dipakai
 * akan ikut menghapus anak-anaknya (bahkan order dan tiket milik user).
 * Tes ini memastikan penghapusan diblokir dan datanya tetap ada.
 */
class DeleteGuardsTest extends TestCase
{
    use RefreshDatabase, CreatesFlightData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs($this->makeUser('admin'));
    }

    public function test_maskapai_yang_punya_pesawat_tidak_bisa_dihapus(): void
    {
        $plane = $this->makePlane();

        $this->delete(route('airlines.destroy', $plane->airline))->assertSessionHas('error');

        $this->assertDatabaseHas('airlines', ['id' => $plane->airline_id]);
        $this->assertDatabaseHas('planes', ['id' => $plane->id]);
    }

    public function test_bandara_yang_dipakai_rute_tidak_bisa_dihapus(): void
    {
        $route = $this->makeRoute();

        $this->delete(route('airports.destroy', $route->departureAirport))->assertSessionHas('error');
        $this->delete(route('airports.destroy', $route->arrivalAirport))->assertSessionHas('error');

        $this->assertDatabaseHas('routes', ['id' => $route->id]);
    }

    public function test_pesawat_yang_dipakai_jadwal_tidak_bisa_dihapus(): void
    {
        $schedule = $this->makeSchedule();

        $this->delete(route('planes.destroy', $schedule->plane_id))->assertSessionHas('error');

        $this->assertDatabaseHas('planes', ['id' => $schedule->plane_id]);
    }

    public function test_rute_yang_dipakai_jadwal_tidak_bisa_dihapus(): void
    {
        $schedule = $this->makeSchedule();

        $this->delete(route('routes.destroy', $schedule->route_id))->assertSessionHas('error');

        $this->assertDatabaseHas('routes', ['id' => $schedule->route_id]);
    }

    public function test_jadwal_yang_sudah_ada_pesanan_tidak_bisa_dihapus_dan_order_aman(): void
    {
        $schedule = $this->makeSchedule();
        $seat = $this->makeSeat($schedule->plane);
        $order = $this->makeOrder($this->makeUser(), $schedule, $seat);

        $this->delete(route('schedules.destroy', $schedule))->assertSessionHas('error');

        $this->assertDatabaseHas('schedules', ['id' => $schedule->id]);
        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }

    public function test_data_yang_tidak_dipakai_bisa_dihapus(): void
    {
        $plane = $this->makePlane();

        // Hapus pesawat dulu (belum ada jadwal), baru maskapainya (sudah kosong).
        $this->delete(route('planes.destroy', $plane))->assertSessionHas('status');
        $this->delete(route('airlines.destroy', $plane->airline_id))->assertSessionHas('status');

        $this->assertDatabaseMissing('planes', ['id' => $plane->id]);
        $this->assertDatabaseMissing('airlines', ['id' => $plane->airline_id]);
    }
}
