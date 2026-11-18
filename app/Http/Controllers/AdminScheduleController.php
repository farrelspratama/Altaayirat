<?php

namespace App\Http\Controllers;

use App\Models\Plane;
use App\Models\Route as FlightRoute;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminScheduleController extends Controller
{
    public function index(): View
    {
        $schedules = Schedule::with(['route.departureAirport', 'route.arrivalAirport', 'plane.airline'])
            ->orderByDesc('departure')
            ->get();

        return view('admin.schedules.index', compact('schedules'));
    }

    public function create(): View
    {
        return view('admin.schedules.create', $this->formOptions());
    }

    public function store(Request $request): RedirectResponse
    {
        Schedule::create($this->validated($request));

        return redirect()->route('schedules.index')->with('status', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule): View
    {
        return view('admin.schedules.edit', $this->formOptions() + ['schedule' => $schedule]);
    }

    public function update(Request $request, Schedule $schedule): RedirectResponse
    {
        $schedule->update($this->validated($request));

        return redirect()->route('schedules.index')->with('status', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule): RedirectResponse
    {
        // Migration orders memakai cascadeOnDelete, jadi menghapus jadwal
        // yang sudah punya pesanan akan ikut menghapus order, payment, dan
        // tiket milik user. Karena itu kita blokir di sini.
        if ($schedule->orders()->exists()) {
            return back()->with('error', 'Jadwal ini sudah memiliki pesanan, tidak bisa dihapus.');
        }

        $schedule->delete();

        return redirect()->route('schedules.index')->with('status', 'Jadwal berhasil dihapus.');
    }

    // Aturan validasi sama untuk store & update, jadi ditaruh di satu method
    // supaya tidak ditulis dua kali.
    private function validated(Request $request): array
    {
        return $request->validate([
            'route_id' => ['required', 'exists:routes,id'],
            'plane_id' => ['required', 'exists:planes,id'],
            'departure' => ['required', 'date'],
            'arrival' => ['required', 'date', 'after:departure'],
            'ticket_price' => ['required', 'numeric', 'min:0'],
        ]);
    }

    // Data untuk mengisi dua dropdown di form.
    private function formOptions(): array
    {
        return [
            'routes' => FlightRoute::with(['departureAirport', 'arrivalAirport'])->get(),
            'planes' => Plane::with('airline')->orderBy('name')->get(),
        ];
    }
}