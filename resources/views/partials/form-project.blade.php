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
        <div>
            <x-input-label for="projects_{{ $index }}_image" :value="__('Gambar Proyek')" />
            @if(isset($item) && $item->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="Project Image" class="rounded-md h-20 w-20 object-cover">
                    <p class="text-xs text-gray-500 mt-1">Gambar saat ini. Upload file baru untuk mengganti.</p>
                </div>
            @endif
            <input id="projects_{{ $index }}_image" name="projects[{{ $index }}][image]" type="file" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
        </div>
        <div>
            <x-input-label for="projects_{{ $index }}_project_link" :value="__('Link Proyek (jika ada)')" />
            <x-text-input id="projects_{{ $index }}_project_link" name="projects[{{ $index }}][project_link]" type="url" class="mt-1 block w-full" :value="old('projects.' . $index . '.project_link', $item->project_link ?? '')" placeholder="https://contoh.com/proyek-saya" />
        </div>
    </div>
    <button type="button" class="remove-item-btn mt-4 text-sm font-medium text-red-600 hover:text-red-900">Hapus</button>
</div>