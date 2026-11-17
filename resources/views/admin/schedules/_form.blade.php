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
        <label class="block text-sm font-medium text-slate-700 mb-1">Rute</label>
        <select name="route_id"
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm
                       focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
            <option value="">-- Pilih Rute --</option>
            @foreach ($routes as $route)
                <option value="{{ $route->id }}"
                    @selected(old('route_id', $schedule->route_id ?? '') == $route->id)>
                    {{ $route->departureAirport->code }} &rarr; {{ $route->arrivalAirport->code }}
                    ({{ $route->departureAirport->city }} - {{ $route->arrivalAirport->city }})
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Pesawat</label>
        <select name="plane_id"
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm
                       focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
            <option value="">-- Pilih Pesawat --</option>
            @foreach ($planes as $plane)
                <option value="{{ $plane->id }}"
                    @selected(old('plane_id', $schedule->plane_id ?? '') == $plane->id)>
                    {{ $plane->airline->name }} - {{ $plane->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Berangkat</label>
        {{-- input datetime-local butuh format Y-m-d\TH:i, bukan format
             default Carbon, makanya nilai dari database diformat manual --}}
        <input type="datetime-local" name="departure"
               value="{{ old('departure', isset($schedule) ? $schedule->departure->format('Y-m-d\TH:i') : '') }}"
               class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Tiba</label>
        <input type="datetime-local" name="arrival"
               value="{{ old('arrival', isset($schedule) ? $schedule->arrival->format('Y-m-d\TH:i') : '') }}"
               class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-1">Harga Tiket (Rp)</label>
        <input type="number" name="ticket_price" min="0" step="1000"
               value="{{ old('ticket_price', isset($schedule) ? (int) $schedule->ticket_price : '') }}"
               class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
    </div>
</div>

<button type="submit" class="bg-sky-600 text-white font-medium px-4 py-2 rounded-md hover:bg-sky-700 transition">
    Simpan
</button>