@extends('layouts.app')

@section('title', 'Tambah Rute')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-slate-200">
    <h1 class="text-xl font-semibold text-slate-800 mb-6">Tambah Rute</h1>
    <form action="{{ route('routes.store') }}" method="POST">
        @csrf
        @include('admin.routes._form')
    </form>
</div>
@endsection