@extends('layouts.app')

@section('title', 'Tambah Jadwal')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-stone-200">
    <h1 class="text-xl font-semibold text-stone-800 mb-6">Tambah Jadwal</h1>
    <form action="{{ route('schedules.store') }}" method="POST">
        @csrf
        @include('admin.schedules._form')
    </form>
</div>
@endsection