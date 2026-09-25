@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-sm border border-slate-200">
    <h1 class="text-xl font-semibold text-slate-800 mb-6">Edit Maskapai</h1>

    <form action="{{ route('airlines.update', $airline) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.airlines._form')
    </form>
</div>
@endsection