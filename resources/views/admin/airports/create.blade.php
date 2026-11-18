@extends('layouts.app')

@section('title', 'Tambah Bandara')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-sm border border-stone-200">
    <h1 class="text-xl font-semibold text-stone-800 mb-6">Tambah Bandara</h1>
    <form action="{{ route('airports.store') }}" method="POST">
        @csrf
        @include('admin.airports._form')
    </form>
</div>
@endsection