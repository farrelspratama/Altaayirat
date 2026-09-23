@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran - Panel Admin')

@section('content')
    <h1>Konfirmasi Pembayaran</h1>

    {{-- Tampilan tabel jika ada pembayaran yang menunggu --}}
    @if ($payments->isEmpty())
        <p>Tidak ada pembayaran yang menunggu konfirmasi.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 900px;">
            <thead>
                <tr style="background-color: #f2f2f2; text-align: left;">
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Penumpang</th>
                    <th>Rute</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td>#{{ $payment->order->id }}</td>
                        <td>{{ $payment->order->user->name }}</td>
                        <td>{{ $payment->order->passenger->full_name }}</td>
                        <td>
                            {{ $payment->order->schedule->route->departureAirport->city }} &rarr; 
                            {{ $payment->order->schedule->route->arrivalAirport->city }}
                        </td>
                        <td>
                            {{-- Form tunggal dengan 2 tombol pengirim nilai status berbeda --}}
                            <form action="{{ route('payments.update', $payment) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" name="status" value="lunas" style="background-color: #2e7d32; color: white; border: none; padding: 6px 12px; cursor: pointer; border-radius: 3px;">
                                    Setujui
                                </button>
                                <button type="submit" name="status" value="ditolak" style="background-color: #c62828; color: white; border: none; padding: 6px 12px; cursor: pointer; border-radius: 3px;" onclick="return confirm('Apakah Anda yakin ingin menolak pembayaran ini?');">
                                    Tolak
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection