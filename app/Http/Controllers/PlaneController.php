<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Plane;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlaneController extends Controller
{
    public function index(): View
    {
        // with('airline') - eager load supaya nama maskapai bisa ditampilkan
        // di tabel tanpa memicu query tambahan per baris (N+1 problem).
        $planes = Plane::with('airline')->orderBy('name')->get();

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
        ]);

        Plane::create($validated);

        return redirect()->route('planes.index')->with('status', 'Pesawat berhasil ditambahkan.');
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
        $plane->delete();

        return redirect()->route('planes.index')->with('status', 'Pesawat berhasil dihapus.');
    }
}