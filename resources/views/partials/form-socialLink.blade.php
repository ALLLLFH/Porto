<div class="item-container p-4 border rounded-md">
    <div class="space-y-4">
        <div>
            <x-input-label :value="__('Platform (Contoh: GitHub, LinkedIn)')" />
            <x-text-input name="social_links[{{ $index }}][platform]" type="text" class="mt-1 block w-full" :value="old('social_links.'.$index.'.platform', $item->platform ?? '')" />
        </div>
        <div>
            <x-input-label :value="__('URL Lengkap')" />
            <x-text-input name="social_links[{{ $index }}][url]" type="url" class="mt-1 block w-full" :value="old('social_links.'.$index.'.url', $item->url ?? '')" />
        </div>
    </div>
    <button type="button" class="remove-item-btn mt-4 text-sm font-medium text-red-600 hover:text-red-900">Hapus</button>
</div>