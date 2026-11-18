@extends('layouts.app')

@section('title', 'Kelola Pesawat')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-stone-800">Kelola Pesawat</h1>
        <a href="{{ route('planes.create') }}"
           class="bg-brand-600 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-brand-700 transition">
            + Tambah Pesawat
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
                    <th class="px-4 py-3 text-left">Nama Pesawat</th>
                    <th class="px-4 py-3 text-left">Maskapai</th>
                    <th class="px-4 py-3 text-left">Kursi</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @foreach ($planes as $plane)
                    <tr class="hover:bg-stone-50">
                        <td class="px-4 py-3 font-medium text-stone-800">{{ $plane->name }}</td>
                        <td class="px-4 py-3">{{ $plane->airline->name }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('planes.seats', $plane) }}" class="text-brand-600 hover:underline">
                                @if ($plane->seats_count > 0)
                                    {{ $plane->seats_count }} kursi
                                @else
                                    <span class="text-amber-600">Belum ada kursi</span>
                                @endif
                            </a>
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('planes.edit', $plane) }}" class="text-brand-600 hover:underline text-xs font-medium">Edit</a>
                            <form action="{{ route('planes.destroy', $plane) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin hapus pesawat ini?')">
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