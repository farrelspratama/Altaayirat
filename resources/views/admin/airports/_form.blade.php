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
        <label class="block text-sm font-medium text-slate-700 mb-1">Kode (IATA)</label>
        <input type="text" name="code" value="{{ old('code', $airport->code ?? '') }}" maxlength="4"
               class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm uppercase
                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Negara</label>
        <input type="text" name="country" value="{{ old('country', $airport->country ?? '') }}"
               class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Kota</label>
        <input type="text" name="city" value="{{ old('city', $airport->city ?? '') }}"
               class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Bandara</label>
        <input type="text" name="name" value="{{ old('name', $airport->name ?? '') }}"
               class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
    </div>
</div>

<button type="submit" class="bg-sky-600 text-white font-medium px-4 py-2 rounded-md hover:bg-sky-700 transition">
    Simpan
</button>