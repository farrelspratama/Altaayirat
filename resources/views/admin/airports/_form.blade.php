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
        <label class="block text-sm font-medium text-stone-700 mb-1">Kode (IATA)</label>
        <input type="text" name="code" value="{{ old('code', $airport->code ?? '') }}" maxlength="4"
               class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm uppercase
                      focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Negara</label>
        <input type="text" name="country" value="{{ old('country', $airport->country ?? '') }}"
               class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Kota</label>
        <input type="text" name="city" value="{{ old('city', $airport->city ?? '') }}"
               class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Nama Bandara</label>
        <input type="text" name="name" value="{{ old('name', $airport->name ?? '') }}"
               class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" required>
    </div>
</div>

<button type="submit" class="bg-brand-600 text-white font-medium px-4 py-2 rounded-md hover:bg-brand-700 transition">
    Simpan
</button>