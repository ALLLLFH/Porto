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
    <section class="bg-white" id="tentang">
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
                        <img src="{{ asset('storage/' . $portfolio->profile_image_path) }}" alt="Foto Profil" class="rounded-full w-full h-full object-cover shadow-2xl border-4 border-gray-100">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Example -->
    <section id="proyek" class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800">Proyek Saya</h2>
                <p class="text-gray-600 mt-2">Berikut adalah beberapa proyek yang telah saya kerjakan.</p>
            </div>

            @if ($portfolio->projects->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($portfolio->projects as $project)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all duration-300">
                    <img src="{{ $project->image ? asset('storage/' . $project->image) : '/images/project-placeholder-rect.png' }}" alt="{{ $project->title }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2">{{ $project->title }}</h3>
                        <p class="text-gray-700 text-base mb-4">{{ Str::limit($project->description, 100) }}</p>
                        <div class="mb-4">
                            @foreach(explode(',', $project->technologies) as $tech)
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ trim($tech) }}</span>
                            @endforeach
                        </div>
                        @if ($project->project_link)
                        <a href="{{ $project->project_link }}" target="_blank" class="font-bold text-blue-600 hover:underline">Lihat Proyek &rarr;</a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500">Belum ada proyek yang ditambahkan.</p>
            @endif
        </div>
    </section>
    <section id="pengalaman" class="py-20 bg-white" x-data="{ selectedExperience: null }">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800">Pengalaman Kerja</h2>
                <p class="text-gray-600 mt-2">Klik pada pengalaman untuk melihat detailnya.</p>
            </div>
            @if ($portfolio->experiences->isNotEmpty())
            <div class="relative">
                <div class="absolute left-1/2 w-0.5 h-full bg-gray-200 transform -translate-x-1/2"></div>

                @foreach ($portfolio->experiences as $experience)
                <div class="relative mb-8 flex justify-between items-center w-full {{ $loop->odd ? 'flex-row-reverse' : '' }}">
                    <div class="w-5/12"></div>
                    <div class="z-10 bg-blue-500 rounded-full w-4 h-4"></div>
                    <div class="w-5/12">
                        <div @click="selectedExperience = {{ json_encode($experience) }}"
                            class="bg-gray-100 p-6 rounded-lg shadow-md hover:shadow-xl cursor-pointer transform hover:scale-105 transition-transform duration-300">
                            <p class="text-sm font-semibold text-blue-600">{{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} - {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('M Y') : 'Sekarang' }}</p>
                            <h3 class="text-xl font-bold mt-1">{{ $experience->position }}</h3>
                            <p class="text-gray-600">{{ $experience->company }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500">Belum ada pengalaman yang ditambahkan.</p>
            @endif
        </div>

        <div x-show="selectedExperience" x-transition.opacity.duration.300ms class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
            <div @click.away="selectedExperience = null" x-show="selectedExperience" x-transition.scale.duration.300ms class="relative bg-white rounded-lg shadow-2xl w-full max-w-2xl p-8">
                <button @click="selectedExperience = null" class="absolute top-4 right-4 text-gray-400 hover:text-gray-800">&times;</button>
                <h2 class="text-3xl font-bold text-gray-900 mb-2" x-text="selectedExperience?.position"></h2>
                <p class="text-xl text-gray-700 font-semibold" x-text="selectedExperience?.company"></p>
                <p class="text-sm text-gray-500 mb-6" x-text="new Date(selectedExperience?.start_date).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' }) + ' - ' + (selectedExperience?.end_date ? new Date(selectedExperience?.end_date).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' }) : 'Sekarang')"></p>
                <div class="prose max-w-none" x-html="selectedExperience?.description"></div>
            </div>
        </div>
    </section>
    <section id="pendidikan" class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800">Riwayat Pendidikan</h2>
                <p class="text-gray-600 mt-2">Perjalanan akademis yang telah saya tempuh.</p>
            </div>

            @if ($portfolio->educations->isNotEmpty())
            <div class="max-w-3xl mx-auto space-y-8">
                @foreach ($portfolio->educations as $education)
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="bg-blue-500 text-white rounded-full h-12 w-12 flex items-center justify-center">
                            <i class="fa-solid fa-graduation-cap text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-6">
                        <p class="font-bold text-lg text-gray-900">{{ $education->institution }}</p>
                        <p class="font-semibold text-gray-700">{{ $education->degree }}</p>
                        <p class="text-sm text-gray-500 mb-2">{{ $education->start_year }} - {{ $education->end_year ?? 'Lulus' }}</p>
                        <p class="text-gray-600">{{ $education->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500">Belum ada riwayat pendidikan yang ditambahkan.</p>
            @endif
        </div>
    </section>
    <section id="keahlian" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800">Keahlian Saya</h2>
                <p class="text-gray-600 mt-2">Beberapa teknologi dan kemampuan yang saya kuasai.</p>
            </div>

            @if ($portfolio->skills->isNotEmpty())
            @php
            // Kelompokkan skill berdasarkan levelnya
            $groupedSkills = $portfolio->skills->groupBy('level');
            // Tentukan urutan level yang diinginkan
            $levels = ['Expert', 'Intermediate', 'Beginner'];
            @endphp

            <div class="max-w-4xl mx-auto space-y-10">
                @foreach ($levels as $level)
                @if (isset($groupedSkills[$level]))
                <div>
                    <h3 class="text-2xl font-bold text-center text-gray-800 mb-6">{{ $level }}</h3>
                    <div class="flex flex-wrap justify-center gap-4">
                        @foreach ($groupedSkills[$level] as $skill)
                        <div class="bg-blue-100 text-blue-800 text-base font-semibold px-5 py-2 rounded-full shadow-sm">
                            {{ $skill->skill_name }}
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500">Belum ada keahlian yang ditambahkan.</p>
            @endif
        </div>
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