@if ($errors->any())
    <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Bandara Asal</label>
        <select name="departure_airport_id"
                class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm
                       focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" required>
            <option value="">-- Pilih Bandara Asal --</option>
            @foreach ($airports as $airport)
                <option value="{{ $airport->id }}"
                    @selected(old('departure_airport_id', $route->departure_airport_id ?? '') == $airport->id)>
                    {{ $airport->city }} ({{ $airport->code }})
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Bandara Tujuan</label>
        {{-- INI DUA dropdown yang sama persis isinya ($airports), beda cuma
             name dan variabel mana yang dicek @selected. Keduanya bukan dua
             sumber data terpisah - cukup satu query $airports yang dipakai
             dua kali dalam loop yang berbeda. --}}
        <select name="arrival_airport_id"
                class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm
                       focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" required>
            <option value="">-- Pilih Bandara Tujuan --</option>
            @foreach ($airports as $airport)
                <option value="{{ $airport->id }}"
                    @selected(old('arrival_airport_id', $route->arrival_airport_id ?? '') == $airport->id)>
                    {{ $airport->city }} ({{ $airport->code }})
                </option>
            @endforeach
        </select>
    </div>
</div>

<button type="submit" class="bg-brand-600 text-white font-medium px-4 py-2 rounded-md hover:bg-brand-700 transition">
    Simpan
</button>