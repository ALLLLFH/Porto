<x-app-layout>
    <div name="header" class="bg-white/40">
        <h2 class="font-semibold pl-3 text-xl text-gray-800 leading-tight">
            {{ __('Edit Portofolio') }}
        </h2>
    </div>

    <div class="py-12">
        <div class="w-full sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('dashboard.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-4 sm:p-8 bg-white/40 shadow sm:rounded-lg mb-6">
                    <h2 class="text-lg font-medium text-gray-900">Informasi Utama</h2>
                    <div class="mt-6 space-y-6">
                        <div>
                            <x-input-label for="title" :value="__('Judul Portfolio')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $portfolio->title)" required />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $portfolio->description) }}</textarea>
                        </div>
                        <div>
                            <x-input-label for="theme" :value="__('Tema')" />
                            <x-text-input id="theme" name="theme" type="text" class="mt-1 block w-full" :value="old('theme', $portfolio->theme)" required />
                        </div>
                        <div>
                            <x-input-label for="profile_image" :value="__('Foto Profil')" />
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $portfolio->profile_image_path) }}" alt="Current Profile Photo" class="rounded-full h-20 w-20 object-cover">
                                </div>
                            <input id="profile_image" name="profile_image" type="file" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                        </div>
                    </div>
                </div>

                @php
                $sections = [
                'projects' => 'Proyek',
                'experiences' => 'Pengalaman Kerja',
                'educations' => 'Pendidikan',
                'skills' => 'Keahlian',
                'socialLinks' => 'Tautan Sosial', // Menggunakan camelCase agar cocok dengan nama relasi
                ];
                $twoColumnSections = ['experiences', 'educations', 'skills', 'socialLinks']; // Sections yang akan ditampilkan dalam 2 kolom
                @endphp

                {{-- Render Proyek (satu kolom penuh) --}}
                <div class="p-4 sm:p-8 bg-white/40 shadow sm:rounded-lg mb-6">
                    <h2 class="text-lg font-medium text-gray-900">{{ $sections['projects'] }}</h2>
                    <div id="projects-wrapper" class="mt-6 space-y-4">
                        @if ($portfolio->projects)
                        @foreach ($portfolio->projects as $item)
                        @include('partials.form-project', ['item' => $item, 'index' => $loop->index])
                        @endforeach
                        @endif
                    </div>
                    <button type="button" class="add-item-btn mt-4 text-sm font-medium text-indigo-600 hover:text-indigo-500" data-section="projects">Tambah Proyek</button>
                </div>

                {{-- Render section dua kolom --}}
                @php
                $twoColumnSections = ['experiences', 'educations', 'skills', 'socialLinks'];
                @endphp
                @foreach (array_chunk($twoColumnSections, 2) as $sectionPair)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($sectionPair as $sectionName)
                    <div class="p-4 sm:p-8 bg-white/40 shadow sm:rounded-lg mb-6">
                        <h2 class="text-lg font-medium text-gray-900">{{ $sections[$sectionName] }}</h2>
                        <div id="{{ $sectionName }}-wrapper" class="mt-6 space-y-4">
                            @if ($portfolio->$sectionName)
                            @foreach ($portfolio->$sectionName as $item)
                            @include('partials.form-' . Str::singular($sectionName), ['item' => $item, 'index' => $loop->index])
                            @endforeach
                            @endif
                        </div>
                        <button type="button" class="add-item-btn mt-4 text-sm font-medium text-indigo-600 hover:text-indigo-500" data-section="{{ $sectionName }}">Tambah {{ $sections[$sectionName] }}</button>
                    </div>
                    @endforeach
                </div>
                @endforeach
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Simpan Semua Perubahan') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <div id="templates" class="hidden">
        {{-- Template untuk setiap section. 'item' => null karena ini untuk item baru --}}
        <template id="projects-template">
            @include('partials.form-project', ['item' => null, 'index' => 'INDEX'])
        </template>
        <template id="experiences-template">
            @include('partials.form-experience', ['item' => null, 'index' => 'INDEX'])
        </template>
        <template id="educations-template">
            @include('partials.form-education', ['item' => null, 'index' => 'INDEX'])
        </template>
        <template id="skills-template">
            @include('partials.form-skill', ['item' => null, 'index' => 'INDEX'])
        </template>
        <template id="socialLinks-template">
            @include('partials.form-socialLink', ['item' => null, 'index' => 'INDEX'])
        </template>
    </div>


    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logika untuk tombol "Tambah"
            document.querySelectorAll('.add-item-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const section = this.dataset.section;
                    const wrapper = document.getElementById(`${section}-wrapper`);
                    const template = document.getElementById(`${section}-template`).innerHTML;

                    // Hitung index baru berdasarkan jumlah item yang sudah ada di wrapper
                    const newIndex = wrapper.querySelectorAll('.item-container').length;

                    // Ganti placeholder 'INDEX' dengan index yang benar
                    const newItemHtml = template.replace(/INDEX/g, newIndex);

                    wrapper.insertAdjacentHTML('beforeend', newItemHtml);
                });
            });

            // Logika untuk tombol "Hapus"
            document.querySelector('body').addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-item-btn')) {
                    e.target.closest('.item-container').remove();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>