<div class="item-container p-4 border rounded-md">
    <div class="space-y-4">
        <div>
            <x-input-label for="social_links-{{ $index }}-platform" :value="__('Platform')" />
            <select name="social_links[{{ $index }}][platform]" id="social_links-{{ $index }}-platform" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">-- Pilih Platform --</option>
                @php
                    $platforms = ['GitHub', 'Facebook', 'LinkedIn', 'Instagram', 'Twitter'];
                    $currentPlatform = old('socialLinks.'.$index.'.platform', $item->platform ?? '');
                @endphp
                @foreach ($platforms as $platform)
                    <option value="{{ $platform }}" @selected($currentPlatform == $platform)>
                        {{ $platform }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <x-input-label for="social_links-{{ $index }}-url" :value="__('URL Lengkap')" />
            <x-text-input id="social_links-{{ $index }}-url" name="social_links[{{ $index }}][url]" type="url" class="mt-1 block w-full" :value="old('social_links.'.$index.'.url', $item->url ?? '')" />
        </div>
    </div>
    <button type="button" class="remove-item-btn mt-4 text-sm font-medium text-red-600 hover:text-red-900">Hapus</button>
</div>