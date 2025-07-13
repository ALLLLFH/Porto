<div class="item-container p-4 border rounded-md">
    <div class="space-y-4">
        <div>
            <x-input-label :value="__('Judul Proyek')" />
            <x-text-input name="projects[{{ $index }}][title]" type="text" class="mt-1 block w-full" :value="old('projects.'.$index.'.title', $item->title ?? '')" />
        </div>
        <div>
            <x-input-label :value="__('Deskripsi')" />
            <textarea name="projects[{{ $index }}][description]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('projects.'.$index.'.description', $item->description ?? '') }}</textarea>
        </div>
        <div>
            <x-input-label :value="__('Teknologi')" />
            <x-text-input name="projects[{{ $index }}][technologies]" type="text" class="mt-1 block w-full" :value="old('projects.'.$index.'.technologies', $item->technologies ?? '')" />
        </div>
    </div>
    <button type="button" class="remove-item-btn mt-4 text-sm font-medium text-red-600 hover:text-red-900">Hapus</button>
</div>