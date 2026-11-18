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
    <label class="block text-sm font-medium text-stone-700 mb-1">Nama Maskapai</label>
    <input type="text" name="name" value="{{ old('name', $airline->name ?? '') }}" class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" required>
</div>

<button type="submit" class="bg-brand-600 text-white font-medium px-4 py-2 rounded-md hover:bg-brand-700 transition">
    Simpan
</button>