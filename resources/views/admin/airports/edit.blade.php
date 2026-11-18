@extends('layouts.app')

@section('title', 'Edit Bandara')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-sm border border-stone-200">
    <h1 class="text-xl font-semibold text-stone-800 mb-6">Edit Bandara</h1>
    <form action="{{ route('airports.update', $airport) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.airports._form')
    </form>
</div>
@endsection