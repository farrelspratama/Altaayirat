@extends('layouts.app')

@section('title', 'Kelola Rute')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Kelola Rute</h1>
        <a href="{{ route('routes.create') }}"
           class="bg-sky-600 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-sky-700 transition">
            + Tambah Rute
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white rounded-lg border border-slate-200 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-3 text-left">Dari</th>
                    <th class="px-4 py-3 text-left">Ke</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($routes as $route)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">{{ $route->departureAirport->city }} ({{ $route->departureAirport->code }})</td>
                        <td class="px-4 py-3">{{ $route->arrivalAirport->city }} ({{ $route->arrivalAirport->code }})</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('routes.edit', $route) }}" class="text-sky-600 hover:underline text-xs font-medium">Edit</a>
                            <form action="{{ route('routes.destroy', $route) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin hapus rute ini?')">
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