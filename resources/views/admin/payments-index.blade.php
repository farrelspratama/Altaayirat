@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran - Panel Admin')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-xl font-semibold text-stone-800 mb-6">Konfirmasi Pembayaran</h1>

        @if ($payments->isEmpty())
            <div class="bg-white rounded-lg border border-stone-200 p-8 text-center text-stone-500 shadow-sm">
                Tidak ada pembayaran yang menunggu konfirmasi.
            </div>
        @else
            <div class="bg-white rounded-lg border border-stone-200 overflow-x-auto shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-stone-50 text-xs uppercase text-stone-500">
                        <tr>
                            <th class="px-4 py-3 text-left">Order</th>
                            <th class="px-4 py-3 text-left">User</th>
                            <th class="px-4 py-3 text-left">Penumpang</th>
                            <th class="px-4 py-3 text-left">Rute</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($payments as $payment)
                            <tr class="hover:bg-stone-50 transition">
                                <td class="px-4 py-3 font-medium text-stone-800">
                                    #{{ $payment->order->id }}
                                </td>
                                <td class="px-4 py-3 text-stone-600">
                                    {{ $payment->order->user->name }}
                                </td>
                                <td class="px-4 py-3 text-stone-600">
                                    {{ $payment->order->passenger->full_name }}
                                </td>
                                <td class="px-4 py-3 text-stone-600 whitespace-nowrap">
                                    {{ $payment->order->schedule->route->departureAirport->city }} &rarr; {{ $payment->order->schedule->route->arrivalAirport->city }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium border {{ $payment->status_badge_classes }}">
                                        {{ $payment->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    <form action="{{ route('payments.update', $payment) }}" method="POST" class="inline-flex gap-2">
                                        @csrf
                                        <button type="submit" name="status" value="lunas" class="bg-green-600 text-white text-xs font-medium px-3 py-1.5 rounded-md hover:bg-green-700 transition cursor-pointer">
                                            Setujui
                                        </button>
                                        <button type="submit" name="status" value="ditolak" class="border border-red-300 text-red-600 text-xs font-medium px-3 py-1.5 rounded-md hover:bg-red-50 transition cursor-pointer">
                                            Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection