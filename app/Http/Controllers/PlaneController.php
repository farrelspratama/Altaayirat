<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Plane;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PlaneController extends Controller
{
    public function index(): View
    {
        // withCount('seats') menambahkan kolom virtual seats_count (jumlah
        // kursi) lewat satu query, tanpa memuat semua baris kursi.
        $planes = Plane::with('airline')->withCount('seats')->orderBy('name')->get();

        return view('admin.planes.index', compact('planes'));
    }

    public function create(): View
    {
        $airlines = Airline::orderBy('name')->get();

        return view('admin.planes.create', compact('airlines'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'airline_id' => ['required', 'exists:airlines,id'],
            'name' => ['required', 'string', 'max:255'],
        ] + $this->seatRules());

        $counts = $this->seatCounts($validated);

        if (array_sum($counts) < 1) {
            return back()->withInput()->withErrors([
                'seats_economy' => 'Isi minimal 1 kursi di salah satu kelas.',
            ]);
        }

        // Transaction: pesawat dan kursinya harus berhasil bersama-sama.
        // Kalau pembuatan kursi gagal di tengah jalan, pesawatnya ikut
        // dibatalkan, tidak ada pesawat "yatim" tanpa kursi.
        DB::transaction(function () use ($validated, $counts) {
            $plane = Plane::create([
                'airline_id' => $validated['airline_id'],
                'name' => $validated['name'],
            ]);

            $plane->generateSeats($counts);
        });

        return redirect()->route('planes.index')
            ->with('status', 'Pesawat dan kursinya berhasil ditambahkan.');
    }

    public function edit(Plane $plane): View
    {
        $airlines = Airline::orderBy('name')->get();

        return view('admin.planes.edit', compact('plane', 'airlines'));
    }

    public function update(Request $request, Plane $plane): RedirectResponse
    {
        $validated = $request->validate([
            'airline_id' => ['required', 'exists:airlines,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $plane->update($validated);

        return redirect()->route('planes.index')->with('status', 'Pesawat berhasil diperbarui.');
    }

    public function destroy(Plane $plane): RedirectResponse
    {
        if ($plane->schedules()->exists()) {
            return back()->withErrors(['plane' => 'Pesawat masih dipakai oleh jadwal.']);
        }

        $plane->delete();

        return redirect()->route('planes.index')->with('status', 'Pesawat berhasil dihapus.');
    }

    /**
     * Halaman daftar kursi sebuah pesawat. Kalau pesawat belum punya kursi
     * (misal dibuat sebelum fitur ini ada), halaman menampilkan form generate.
     */
    public function seats(Plane $plane): View
    {
        $plane->load('airline');

        $seatsByClass = $plane->seats()
            ->with('flightClass')
            ->orderBy('seat_number')
            ->get()
            ->groupBy(fn ($seat) => $seat->flightClass->name);

        return view('admin.planes.seats', compact('plane', 'seatsByClass'));
    }

    public function generateSeats(Request $request, Plane $plane): RedirectResponse
    {
        // Hanya boleh untuk pesawat yang belum punya kursi. Kalau kursi
        // sudah ada (apalagi sudah dipesan), generate ulang akan bentrok
        // dengan unique(plane_id, seat_number) dan berisiko merusak order.
        if ($plane->seats()->exists()) {
            return back()->withErrors(['seats_economy' => 'Pesawat ini sudah memiliki kursi.']);
        }

        $validated = $request->validate($this->seatRules());
        $counts = $this->seatCounts($validated);

        if (array_sum($counts) < 1) {
            return back()->withInput()->withErrors([
                'seats_economy' => 'Isi minimal 1 kursi di salah satu kelas.',
            ]);
        }

        $plane->generateSeats($counts);

        return redirect()->route('planes.seats', $plane)->with('status', 'Kursi berhasil dibuat.');
    }

    private function seatRules(): array
    {
        return [
            'seats_economy' => ['required', 'integer', 'min:0', 'max:200'],
            'seats_premium' => ['required', 'integer', 'min:0', 'max:200'],
            'seats_business' => ['required', 'integer', 'min:0', 'max:200'],
        ];
    }

    // Mengubah nama field form menjadi nama kelas yang dipakai generateSeats().
    private function seatCounts(array $validated): array
    {
        return [
            'Economy' => (int) $validated['seats_economy'],
            'Premium Economy' => (int) $validated['seats_premium'],
            'Business' => (int) $validated['seats_business'],
        ];
    }
}