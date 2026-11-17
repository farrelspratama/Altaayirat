@if ($errors->any())
    <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-4">
    <label class="block text-sm font-medium text-slate-700 mb-1">Maskapai</label>
    <select name="airline_id"
            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm
                   focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
        <option value="">-- Pilih Maskapai --</option>
        @foreach ($airlines as $airline)
            <option value="{{ $airline->id }}"
                @selected(old('airline_id', $plane->airline_id ?? '') == $airline->id)>
                {{ $airline->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Pesawat</label>
    <input type="text" name="name" value="{{ old('name', $plane->name ?? '') }}"
           placeholder="Misal: Boeing 737-800"
           class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm
                  focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
</div>

{{-- Jumlah kursi hanya diisi saat membuat pesawat baru. Di halaman edit
     ($plane sudah ada) bagian ini disembunyikan, karena mengubah jumlah
     kursi setelah ada pesanan berisiko merusak data order. --}}
@unless (isset($plane))
    @include('admin.planes._seat_fields')
@endunless

<button type="submit" class="bg-sky-600 text-white font-medium px-4 py-2 rounded-md hover:bg-sky-700 transition">
    Simpan
</button>