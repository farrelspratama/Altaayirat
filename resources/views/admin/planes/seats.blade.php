@extends('layouts.app')

@section('title', 'Kursi ' . $plane->name)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Kursi {{ $plane->name }}</h1>
            <p class="text-sm text-slate-500">{{ $plane->airline->name }}</p>
        </div>
        <a href="{{ route('planes.index') }}" class="text-sm text-sky-600 hover:underline">&larr; Kembali</a>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($seatsByClass->isEmpty())
        <div class="bg-white p-8 rounded-lg shadow-sm border border-slate-200">
            <p class="text-sm text-slate-600 mb-4">
                Pesawat ini belum punya kursi, jadi belum bisa dipesan. Isi jumlah kursi per kelas lalu buat sekarang.
            </p>
            <form action="{{ route('planes.seats.generate', $plane) }}" method="POST">
                @csrf
                @include('admin.planes._seat_fields')
                <button type="submit" class="bg-sky-600 text-white font-medium px-4 py-2 rounded-md hover:bg-sky-700 transition">
                    Buat Kursi
                </button>
            </form>
        </div>
    @else
        <div class="bg-white p-8 rounded-lg shadow-sm border border-slate-200">
            <div class="flex gap-4 text-xs text-slate-500 mb-4">
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-sm border border-slate-300"></span> Tersedia</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-sm bg-slate-200"></span> Dipesan / tidak tersedia</span>
            </div>

            @foreach ($seatsByClass as $className => $seats)
                <p class="text-xs font-semibold text-slate-500 uppercase mb-2">{{ $className }} ({{ $seats->count() }})</p>
                <div class="grid grid-cols-4 sm:grid-cols-6 gap-2 mb-6">
                    @foreach ($seats as $seat)
                        <div class="rounded-md border text-center py-2 text-sm font-medium
                            {{ $seat->status === 'tersedia'
                                ? 'border-slate-300 text-slate-700'
                                : 'bg-slate-200 border-slate-200 text-slate-400' }}">
                            {{ $seat->seat_number }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection