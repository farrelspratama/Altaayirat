@extends('layouts.app')

@section('title', 'Kursi ' . $plane->name)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-stone-800">Kursi {{ $plane->name }}</h1>
            <p class="text-sm text-stone-500">{{ $plane->airline->name }}</p>
        </div>
        <a href="{{ route('planes.index') }}" class="text-sm text-brand-600 hover:underline">&larr; Kembali</a>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
            {{ session('status') }}
        </div>
    @endif

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
        <div class="bg-white p-8 rounded-lg shadow-sm border border-stone-200">
            <p class="text-sm text-stone-600 mb-4">
                Pesawat ini belum punya kursi, jadi belum bisa dipesan. Isi jumlah kursi per kelas lalu buat sekarang.
            </p>
            <form action="{{ route('planes.seats.generate', $plane) }}" method="POST">
                @csrf
                @include('admin.planes._seat_fields')
                <button type="submit" class="bg-brand-600 text-white font-medium px-4 py-2 rounded-md hover:bg-brand-700 transition">
                    Buat Kursi
                </button>
            </form>
        </div>
    @else
        <div class="bg-white p-8 rounded-lg shadow-sm border border-stone-200">
            <div class="flex gap-4 text-xs text-stone-500 mb-4">
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-sm border border-stone-300"></span> Tersedia</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-sm bg-stone-200"></span> Dipesan / tidak tersedia</span>
            </div>

            @foreach ($seatsByClass as $className => $seats)
                <p class="text-xs font-semibold text-stone-500 uppercase mb-2">{{ $className }} ({{ $seats->count() }})</p>
                <div class="grid grid-cols-4 sm:grid-cols-6 gap-2 mb-6">
                    @foreach ($seats as $seat)
                        <div class="rounded-md border text-center py-2 text-sm font-medium
                            {{ $seat->status === 'tersedia'
                                ? 'border-stone-300 text-stone-700'
                                : 'bg-stone-200 border-stone-200 text-stone-400' }}">
                            {{ $seat->seat_number }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection