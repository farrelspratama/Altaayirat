<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchScheduleRequest;
use App\Models\Airport;
use App\Models\Schedule;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    /**
     * Menampilkan FORM pencarian (menggantikan tampilan awal cari-pesawat.php).
     * Method ini tidak menerima input apapun, tugasnya cuma menyiapkan
     * data untuk mengisi dropdown bandara di form.
     */
    public function searchForm(): View
    {
        $airports = Airport::orderBy('city')->get();

        return view('schedules.search', [
            'airports' => $airports,
        ]);
    }

    /**
     * Memproses pencarian dan menampilkan hasil (menggantikan hasil-cari.php).
     *
     * Perhatikan tipe parameter: SearchScheduleRequest, bukan Request biasa.
     * Ini artinya SEBELUM kode di dalam method ini dijalankan, Laravel
     * SUDAH otomatis menjalankan validasi dari SearchScheduleRequest.
     * Kalau validasi gagal, Laravel otomatis redirect balik ke form
     * dengan pesan error - kamu TIDAK PERLU menulis pengecekan manual.
     */
    public function searchResults(SearchScheduleRequest $request): View
    {
        $validated = $request->validated();

        $schedules = Schedule::query()
            // whereHas: cari Schedule yang relasi 'route'-nya memenuhi kondisi ini.
            // Ini setara JOIN + WHERE di SQL manual, tapi ditulis lebih aman & jelas.
            ->whereHas('route', function ($query) use ($validated) {
                $query->where('departure_airport_id', $validated['departure_airport_id'])
                    ->where('arrival_airport_id', $validated['arrival_airport_id']);
            })
            ->whereDate('departure', $validated['date'])
            // eager loading (with): ambil sekaligus relasi yang dibutuhkan View,
            // supaya tidak query berulang-ulang di dalam loop Blade nanti
            // (masalah ini disebut N+1 query problem).
            ->with(['route.departureAirport', 'route.arrivalAirport', 'plane.airline'])
            ->orderBy('departure')
            ->get();

        return view('schedules.results', [
            'schedules' => $schedules,
            'searchParams' => $validated,
        ]);
    }
}
