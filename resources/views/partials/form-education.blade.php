<div class="item-container p-4 border rounded-md">
    <div class="space-y-4">
        <div>
            <x-input-label :value="__('Nama Institusi')" />
            <x-text-input name="educations[{{ $index }}][institution]" type="text" class="mt-1 block w-full" :value="old('educations.'.$index.'.institution', $item->institution ?? '')" />
        </div>
        <div>
            <x-input-label :value="__('Gelar')" />
            <x-text-input name="educations[{{ $index }}][degree]" type="text" class="mt-1 block w-full" :value="old('educations.'.$index.'.degree', $item->degree ?? '')" />
        </div>
        <div>
            <x-input-label :value="__('Tahun Mulai')" />
            <x-text-input name="educations[{{ $index }}][start_year]" type="number" placeholder="YYYY" class="mt-1 block w-full" :value="old('educations.'.$index.'.start_year', $item->start_year ?? '')" />
        </div>
        <div>
            <x-input-label :value="__('Tahun Selesai')" />
            <x-text-input name="educations[{{ $index }}][end_year]" type="number" placeholder="YYYY" class="mt-1 block w-full" :value="old('educations.'.$index.'.end_year', $item->end_year ?? '')" />
        </div>
        <div>
            <x-input-label :value="__('Deskripsi')" />
            <textarea name="educations[{{ $index }}][description]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('educations.'.$index.'.description', $item->description ?? '') }}</textarea>
        </div>
    </div>
    <button type="button" class="remove-item-btn mt-4 text-sm font-medium text-red-600 hover:text-red-900">Hapus</button>
</div>