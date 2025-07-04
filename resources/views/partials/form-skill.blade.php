<div class="item-container p-4 border rounded-md">
    <div class="space-y-4">
        <div>
            <x-input-label :value="__('Nama Keahlian')" />
            <x-text-input name="skills[{{ $index }}][skill_name]" type="text" class="mt-1 block w-full" :value="old('skills.'.$index.'.skill_name', $item->skill_name ?? '')" />
        </div>
        <div>
            <x-input-label :value="__('Level')" />
            <select name="skills[{{ $index }}][level]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @foreach (['Beginner', 'Intermediate', 'Expert'] as $level)
                    <option value="{{ $level }}" @selected(old('skills.'.$index.'.level', $item->level ?? '') == $level)>{{ $level }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <button type="button" class="remove-item-btn mt-4 text-sm font-medium text-red-600 hover:text-red-900">Hapus</button>
</div>