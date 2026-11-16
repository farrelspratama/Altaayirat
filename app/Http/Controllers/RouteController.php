<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Route as FlightRoute;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RouteController extends Controller
{
    public function index(): View
    {
        $routes = FlightRoute::with(['departureAirport', 'arrivalAirport'])->get();

        return view('admin.routes.index', compact('routes'));
    }

    public function create(): View
    {
        $airports = Airport::orderBy('city')->get();

        return view('admin.routes.create', compact('airports'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'departure_airport_id' => ['required', 'exists:airports,id'],
            // 'different:departure_airport_id' - ATURAN YANG SAMA PERSIS
            // yang sudah kamu tulis dulu di SearchScheduleRequest untuk sisi
            // user. Di sini perlu ditulis ULANG karena ini request yang
            // berbeda (validasi inline di Controller, bukan Form Request
            // terpisah) - aturan validasi tidak otomatis "dibagikan" antar
            // tempat berbeda hanya karena nama field-nya sama.
            'arrival_airport_id' => ['required', 'exists:airports,id', 'different:departure_airport_id'],
        ]);

        FlightRoute::create($validated);

        return redirect()->route('routes.index')->with('status', 'Rute berhasil ditambahkan.');
    }

    public function edit(FlightRoute $route): View
    {
        $airports = Airport::orderBy('city')->get();

        return view('admin.routes.edit', compact('route', 'airports'));
    }

    public function update(Request $request, FlightRoute $route): RedirectResponse
    {
        $validated = $request->validate([
            'departure_airport_id' => ['required', 'exists:airports,id'],
            'arrival_airport_id' => ['required', 'exists:airports,id', 'different:departure_airport_id'],
        ]);

        $route->update($validated);

        return redirect()->route('routes.index')->with('status', 'Rute berhasil diperbarui.');
    }

    public function destroy(FlightRoute $route): RedirectResponse
    {
        $route->delete();

        return redirect()->route('routes.index')->with('status', 'Rute berhasil dihapus.');
    }
}