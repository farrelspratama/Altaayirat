@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-stone-800">Kelola Maskapai</h1>
            <a href="{{ route('airlines.create') }}" class="bg-brand-600 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-brand-700 transition">
                + Tambah Maskapai
            </a>
        </div>

        <div class="bg-white rounded-lg border border-stone-200 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-stone-50 text-xs uppercase text-stone-500">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($airlines as $airline)
                        <tr class="hover:bg-stone-50">
                            <td class="px-4 py-3">{{ $airline->name }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('airlines.edit', $airline) }}" class="text-brand-600 hover:underline text-xs font-medium">Edit</a>
                                <form action="{{ route('airlines.destroy', $airline) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus maskapai ini?')">
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