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
        <h2 class="text-2xl font-bold mb-4">Proyek</h2>
        {{-- ...konten proyek... --}}
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