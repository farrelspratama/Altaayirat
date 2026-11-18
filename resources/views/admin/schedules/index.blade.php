@extends('layouts.app')

@section('title', 'Kelola Jadwal')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-stone-800">Kelola Jadwal</h1>
        <a href="{{ route('schedules.create') }}"
           class="bg-brand-600 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-brand-700 transition">
            + Tambah Jadwal
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="bg-white rounded-lg border border-stone-200 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-stone-50 text-xs uppercase text-stone-500">
                <tr>
                    <th class="px-4 py-3 text-left">Rute</th>
                    <th class="px-4 py-3 text-left">Pesawat</th>
                    <th class="px-4 py-3 text-left">Berangkat</th>
                    <th class="px-4 py-3 text-left">Tiba</th>
                    <th class="px-4 py-3 text-left">Harga</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @foreach ($schedules as $schedule)
                    <tr class="hover:bg-stone-50">
                        <td class="px-4 py-3 font-medium text-stone-800">
                            {{ $schedule->route->departureAirport->code }} &rarr; {{ $schedule->route->arrivalAirport->code }}
                        </td>
                        <td class="px-4 py-3">
                            <div>{{ $schedule->plane->name }}</div>
                            <div class="text-xs text-stone-500">{{ $schedule->plane->airline->name }}</div>
                        </td>
                        <td class="px-4 py-3">{{ $schedule->departure->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3">{{ $schedule->arrival->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($schedule->ticket_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('schedules.edit', $schedule) }}" class="text-brand-600 hover:underline text-xs font-medium">Edit</a>
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