<div class="item-container bg-white/40 p-4 border rounded-md">
    <div class="space-y-4">
        <div>
            <x-input-label :value="__('Nama Perusahaan')" />
            <x-text-input name="experiences[{{ $index }}][company]" type="text" class="mt-1 block w-full" :value="old('experiences.'.$index.'.company', $item->company ?? '')" />
        </div>
        <div>
            <x-input-label :value="__('Posisi')" />
            <x-text-input name="experiences[{{ $index }}][position]" type="text" class="mt-1 block w-full" :value="old('experiences.'.$index.'.position', $item->position ?? '')" />
        </div>
        <div>
            <x-input-label :value="__('Tanggal Mulai')" />
            <x-text-input name="experiences[{{ $index }}][start_date]" type="date" class="mt-1 block w-full" :value="old('experiences.'.$index.'.start_date', $item->start_date ?? '')" />
        </div>
        <div>
            <x-input-label :value="__('Tanggal Selesai (Kosongkan jika masih bekerja)')" />
            <x-text-input name="experiences[{{ $index }}][end_date]" type="date" class="mt-1 block w-full" :value="old('experiences.'.$index.'.end_date', $item->end_date ?? '')" />
        </div>
        <div>
            <x-input-label :value="__('Deskripsi Pekerjaan')" />
            <textarea name="experiences[{{ $index }}][description]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('experiences.'.$index.'.description', $item->description ?? '') }}</textarea>
        </div>
    </div>
    <button type="button" class="remove-item-btn mt-4 text-sm font-medium text-red-600 hover:text-red-900">Hapus</button>
</div>