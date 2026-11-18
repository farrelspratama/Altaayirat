{{-- Pesan flash global. Dipasang SEKALI di layouts/app.blade.php.
     Controller cukup memanggil:
       ->with('status', '...')   sukses  (hijau)
       ->with('error',  '...')   gagal   (merah)
     Error validasi form ($errors) TIDAK ditampilkan di sini: itu tetap
     ditampilkan di dekat formnya masing-masing. --}}
@php
    $flashes = array_filter([
        'success' => session('status'),
        'error'   => session('error'),
    ]);

    $styles = [
        'success' => 'border-green-200 bg-green-50 text-green-800',
        'error'   => 'border-red-200 bg-red-50 text-red-800',
    ];
@endphp

@if ($flashes)
    <div class="max-w-5xl w-full mx-auto px-4 pt-6 space-y-3">
        @foreach ($flashes as $type => $message)
            <div role="{{ $type === 'error' ? 'alert' : 'status' }}"
                 class="flex items-start justify-between gap-4 rounded-xl border px-4 py-3 text-sm {{ $styles[$type] }}">
                <span>{{ $message }}</span>
                <button type="button" aria-label="Tutup"
                        onclick="this.parentElement.remove()"
                        class="-mr-1 shrink-0 rounded p-0.5 opacity-60 hover:opacity-100">&times;</button>
            </div>
        @endforeach
    </div>
@endif
