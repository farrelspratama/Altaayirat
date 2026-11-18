@extends('layouts.app')

@section('title', 'Tambah Pesawat')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-sm border border-stone-200">
    <h1 class="text-xl font-semibold text-stone-800 mb-6">Tambah Pesawat</h1>
    <form action="{{ route('planes.store') }}" method="POST">
        @csrf
        @include('admin.planes._form')
    </form>
</div>
@endsection