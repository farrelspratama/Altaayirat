@extends('layouts.app')

@section('title', 'Edit Rute')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-stone-200">
    <h1 class="text-xl font-semibold text-stone-800 mb-6">Edit Rute</h1>
    <form action="{{ route('routes.update', $route) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.routes._form')
    </form>
</div>
@endsection