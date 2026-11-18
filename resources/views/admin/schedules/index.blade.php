@extends('layouts.app')

@section('title', 'Kelola Jadwal')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Kelola Jadwal</h1>
        <a href="{{ route('schedules.create') }}"
           class="bg-sky-600 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-sky-700 transition">
            + Tambah Jadwal
        </a>
    </div>

    <div class="bg-white rounded-lg border border-slate-200 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-3 text-left">Rute</th>
                    <th class="px-4 py-3 text-left">Pesawat</th>
                    <th class="px-4 py-3 text-left">Berangkat</th>
                    <th class="px-4 py-3 text-left">Tiba</th>
                    <th class="px-4 py-3 text-left">Harga</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($schedules as $schedule)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-800">
                            {{ $schedule->route->departureAirport->code }} &rarr; {{ $schedule->route->arrivalAirport->code }}
                        </td>
                        <td class="px-4 py-3">
                            <div>{{ $schedule->plane->name }}</div>
                            <div class="text-xs text-slate-500">{{ $schedule->plane->airline->name }}</div>
                        </td>
                        <td class="px-4 py-3">{{ $schedule->departure->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3">{{ $schedule->arrival->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($schedule->ticket_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('schedules.edit', $schedule) }}" class="text-sky-600 hover:underline text-xs font-medium">Edit</a>
                            <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-xs font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection