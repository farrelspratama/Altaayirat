<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $airlines = Airline::orderBy('name')->get();

        return view('admin.airlines.index', compact('airlines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.airlines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:255']]);

        Airline::create($validated);

        return redirect()->route('airlines.index')->with('status', 'Maskapai berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Airline $airline): View
    {
        return view('admin.airlines.edit', compact('airline'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Airline $airline): RedirectResponse
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:255']]);

        $airline->update($validated);

        return redirect()->route('airlines.index')->with('status', 'Maskapai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airline $airline): RedirectResponse
    {

        if ($airline->planes()->exists()) {
            return back()->withErrors(['airline' => 'Maskapai masih memiliki pesawat.']);
        }

        $airline->delete();

        return redirect()->route('airlines.index')->with('status', 'Maskapai berhasil dihapus.');
    }
}