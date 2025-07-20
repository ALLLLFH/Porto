<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/e5bf66877e.js" crossorigin="anonymous"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js untuk interaktivitas -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="font-sans antialiased bg-gray-50">

    <!-- Navbar Section Scroll -->
    <nav class="sticky top-0 z-40 bg-white px-4 py-4">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <i class="fa-solid fa-splotch"></i>
                <!-- Atur jarak antara logo dan menu -->
            </div>
            <div class="flex space-x-6">
                <a href="#tentang" class="text-gray-700 hover:text-blue-500 font-medium transition">Tentang</a>
                <a href="#proyek" class="text-gray-700 hover:text-blue-500 font-medium transition">Proyek</a>
                <a href="#pengalaman" class="text-gray-700 hover:text-blue-500 font-medium transition">Pengalaman</a>
                <a href="#pendidikan" class="text-gray-700 hover:text-blue-500 font-medium transition">Pendidikan</a>
                <a href="#keahlian" class="text-gray-700 hover:text-blue-500 font-medium transition">Keahlian</a>
                <a href="#tautan" class="text-gray-700 hover:text-blue-500 font-medium transition">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-white" id="#tentang">
        <div class="container mx-auto px-6 py-24">
            <div class="flex flex-col md:flex-row items-center">
                <!-- Kolom Kiri: Teks -->
                <div class="md:w-1/2 lg:w-3/5 md:pr-16 text-center md:text-left mb-10 md:mb-0">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 leading-tight mb-4">
                        Halo, Saya <span class="text-blue-600">{{$portfolio->title}}</span>
                        </span>
                    </h1>
                    <p class="text-lg text-gray-600 leading-relaxed">{{$portfolio->description}}</p>
                    <div class="mt-8">
                        <a href="#tautan" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition duration-300 shadow-lg transform hover:scale-105">Hubungi Saya</a>
                        <a href="#proyek" class="ml-4 text-gray-700 font-semibold hover:text-blue-600 transition">Lihat Proyek</a>
                    </div>
                </div>

                <!-- Kolom Kanan: Gambar -->
                <div class="md:w-1/2 lg:w-2/5 flex justify-center md:justify-end">
                    <div class="relative w-64 h-64 md:w-80 md:h-80">
                        <img src="/images/profile-placeholder.png" alt="Foto Profil" class="rounded-full w-full h-full object-cover shadow-2xl border-4 border-gray-100">
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Section Example -->
    <section id="proyek" class="py-12">
                <div class="container mx-auto px-6" x-data="{ selectedProject: null }">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800">Proyek Saya</h2>
                <p class="text-gray-600 mt-2">Klik pada proyek untuk melihat detailnya.</p>
            </div>

            @if ($portfolio->projects->isNotEmpty())
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                    @foreach ($portfolio->projects as $project)
                        <!-- Project Bubble -->
                        <div @click="selectedProject = {{ json_encode($project) }}"
                             class="group bg-white p-6 rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300 cursor-pointer flex flex-col items-center text-center">
                            {{-- Tampilkan logo proyek, atau gambar placeholder jika tidak ada --}}
                            <img src="{{ $project->logo ? asset('storage/' . $project->logo) : '/images/project-placeholder.png' }}"
                                 alt="Logo {{ $project->title }}"
                                 class="h-20 w-20 object-contain mb-4 transition-transform duration-300 group-hover:scale-110">
                            <h3 class="font-bold text-gray-800">{{ $project->title }}</h3>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500">Belum ada proyek yang ditambahkan.</p>
            @endif

            <!-- Project Detail Modal -->
            <div x-show="selectedProject"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                 style="display: none;">

                <!-- Modal Overlay -->
                <div @click="selectedProject = null" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

                <!-- Modal Content -->
                <div x-show="selectedProject"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-90"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-90"
                     class="relative bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-8">

                    <!-- Close Button -->
                    <button @click="selectedProject = null" class="absolute top-4 right-4 text-gray-400 hover:text-gray-800">
                        <i class="fa-solid fa-times text-2xl"></i>
                    </button>

                    <h2 class="text-3xl font-bold text-gray-900 mb-4" x-text="selectedProject?.title"></h2>
                    <p class="text-gray-600 mb-6" x-text="selectedProject?.description"></p>

                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-800 mb-2">Teknologi yang Digunakan:</h4>
                        <p class="text-gray-600" x-text="selectedProject?.technologies"></p>
                    </div>

                    <div x-show="selectedProject?.project_link">
                        <a :href="selectedProject?.project_link" target="_blank"
                           class="inline-block bg-blue-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-300">
                            Kunjungi Proyek <i class="fa-solid fa-arrow-up-right-from-square ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="pengalaman" class="py-12">
        <h2 class="text-2xl font-bold mb-4">Pengalaman Kerja</h2>
        {{-- ...konten pengalaman... --}}
    </section>
    <section id="pendidikan" class="py-12">
        <h2 class="text-2xl font-bold mb-4">Pendidikan</h2>
        {{-- ...konten pendidikan... --}}
    </section>
    <section id="keahlian" class="py-12">
        <h2 class="text-2xl font-bold mb-4">Keahlian</h2>
        {{-- ...konten keahlian... --}}
    </section>
    {{-- Hanya tampilkan section ini jika ada data social links --}}
    @if ($portfolio->socialLinks->isNotEmpty())
    <section id="tautan" class="py-12">
        <div class="container mx-auto px-auto text-center">

            {{-- Definisikan mapping antara nama platform dan kelas ikon Font Awesome --}}
            @php
            $icons = [
            'GitHub' => 'fa-github',
            'Facebook' => 'fa-facebook',
            'LinkedIn' => 'fa-linkedin',
            'Instagram' => 'fa-instagram',
            'Twitter' => 'fa-twitter',
            'Website' => 'fa-globe',
            ];
            @endphp

            {{-- Lakukan looping untuk setiap social link yang ada di database --}}
            @foreach ($portfolio->socialLinks as $link)
            <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-full bg-gray-200 hover:bg-blue-200 h-8 w-8 mx-1">
                {{-- Pilih ikon secara dinamis berdasarkan nama platform --}}
                <i class="fab {{ $icons[$link->platform] ?? 'fa-link' }}"></i>
            </a>
            @endforeach

        </div>
    </section>
    @endif

</body>

</html>