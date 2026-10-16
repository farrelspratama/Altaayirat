<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AirportController extends Controller
{
    public function index(): View
    {
        $airports = Airport::orderBy('city')->get();

        return view('admin.airports.index', compact('airports'));
    }

    public function create(): View
    {
        return view('admin.airports.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:4', 'unique:airports,code'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        Airport::create($validated);

        return redirect()->route('airports.index')->with('status', 'Bandara berhasil ditambahkan.');
    }

    public function edit(Airport $airport): View
    {
        return view('admin.airports.edit', compact('airport'));
    }

    public function update(Request $request, Airport $airport): RedirectResponse
    {
        $validated = $request->validate([
            // 'unique:airports,code,' . $airport->id artinya: cek unique di tabel
            // airports kolom code, TAPI kecualikan baris dengan id = $airport->id
            // (baris itu sendiri) - tanpa ini, edit airport tanpa ubah kode akan
            // selalu gagal validasi karena dianggap "sudah dipakai" oleh dirinya sendiri.
            'code' => ['required', 'string', 'max:4', 'unique:airports,code,' . $airport->id],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $airport->update($validated);

        return redirect()->route('airports.index')->with('status', 'Bandara berhasil diperbarui.');
    }

    public function destroy(Airport $airport): RedirectResponse
    {
        $airport->delete();

        return redirect()->route('airports.index')->with('status', 'Bandara berhasil dihapus.');
    }
}