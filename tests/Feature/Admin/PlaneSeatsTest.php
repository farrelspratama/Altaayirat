<?php

namespace Tests\Feature\Admin;

use App\Models\Plane;
use Database\Seeders\FlightClassSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesFlightData;
use Tests\TestCase;

class PlaneSeatsTest extends TestCase
{
    use RefreshDatabase, CreatesFlightData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(FlightClassSeeder::class);   // tabel classes harus berisi Economy/Premium/Business
        $this->actingAs($this->makeUser('admin'));
    }

    public function test_membuat_pesawat_otomatis_membuat_kursi_per_kelas(): void
    {
        $plane = $this->makePlane();

        $this->post(route('planes.store'), [
            'airline_id' => $plane->airline_id,
            'name' => 'Airbus Baru',
            'seats_economy' => 3,
            'seats_premium' => 1,
            'seats_business' => 2,
        ])->assertRedirect(route('planes.index'));

        $baru = Plane::where('name', 'Airbus Baru')->firstOrFail();

        $this->assertSame(6, $baru->seats()->count());
        $this->assertEqualsCanonicalizing(
            ['A01', 'A02', 'A03', 'P01', 'B01', 'B02'],
            $baru->seats()->pluck('seat_number')->all()
        );
        $this->assertSame(6, $baru->seats()->where('status', 'tersedia')->count());
    }

    public function test_pesawat_tanpa_satu_pun_kursi_ditolak_dan_tidak_tersimpan(): void
    {
        $plane = $this->makePlane();

        $this->post(route('planes.store'), [
            'airline_id' => $plane->airline_id,
            'name' => 'Pesawat Kosong',
            'seats_economy' => 0,
            'seats_premium' => 0,
            'seats_business' => 0,
        ])->assertSessionHasErrors('seats_economy');

        $this->assertDatabaseMissing('planes', ['name' => 'Pesawat Kosong']);
    }

    public function test_jumlah_kursi_negatif_atau_terlalu_besar_ditolak(): void
    {
        $plane = $this->makePlane();

        $this->post(route('planes.store'), [
            'airline_id' => $plane->airline_id, 'name' => 'X',
            'seats_economy' => -1, 'seats_premium' => 0, 'seats_business' => 0,
        ])->assertSessionHasErrors('seats_economy');

        $this->post(route('planes.store'), [
            'airline_id' => $plane->airline_id, 'name' => 'X',
            'seats_economy' => 201, 'seats_premium' => 0, 'seats_business' => 0,
        ])->assertSessionHasErrors('seats_economy');
    }

    public function test_pesawat_lama_tanpa_kursi_bisa_digenerate_sekali_saja(): void
    {
        $plane = $this->makePlane();   // dibuat langsung, tanpa kursi

        $data = ['seats_economy' => 2, 'seats_premium' => 0, 'seats_business' => 0];

        $this->post(route('planes.seats.generate', $plane), $data)->assertRedirect();
        $this->assertSame(2, $plane->seats()->count());

        // Kedua kali ditolak: kursi tidak boleh bertambah atau tertimpa.
        $this->post(route('planes.seats.generate', $plane), $data)
            ->assertSessionHas('error');
        $this->assertSame(2, $plane->seats()->count());
    }
}
