@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Kelola Maskapai</h1>
        <a href="{{ route('airlines.create') }}" class="bg-sky-600 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-sky-700 transition">
            + Tambah Maskapai
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
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($airlines as $airline)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">{{ $airline->name }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('airlines.edit', $airline) }}" class="text-sky-600 hover:underline text-xs font-medium">Edit</a>
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