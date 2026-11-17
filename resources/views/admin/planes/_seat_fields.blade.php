<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Kursi Economy</label>
        <input type="number" name="seats_economy" min="0" max="200" value="{{ old('seats_economy', 24) }}"
               class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Kursi Premium Economy</label>
        <input type="number" name="seats_premium" min="0" max="200" value="{{ old('seats_premium', 0) }}"
               class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Kursi Business</label>
        <input type="number" name="seats_business" min="0" max="200" value="{{ old('seats_business', 4) }}"
               class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
    </div>
</div>