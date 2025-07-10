<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="{{ asset('build/assets/app.css') }}" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">

    <!-- Navbar Section Scroll -->
    <nav class="sticky top-0 z-40 bg-white/80 backdrop-blur px-4 py-2 shadow flex gap-4 justify-center">
        <a href="#tentang" class="text-gray-700 hover:text-blue-600 font-semibold transition">Tentang</a>
        <a href="#proyek" class="text-gray-700 hover:text-blue-600 font-semibold transition">Proyek</a>
        <a href="#pengalaman" class="text-gray-700 hover:text-blue-600 font-semibold transition">Pengalaman Kerja</a>
        <a href="#pendidikan" class="text-gray-700 hover:text-blue-600 font-semibold transition">Pendidikan</a>
        <a href="#keahlian" class="text-gray-700 hover:text-blue-600 font-semibold transition">Keahlian</a>
        <a href="#tautan" class="text-gray-700 hover:text-blue-600 font-semibold transition">Tautan Sosial</a>
    </nav>

    <!-- Section Example -->
    <section id="tentang" class="py-12">
        <h2 class="text-2xl font-bold mb-4">Informasi Utama</h2>
        {{-- ...konten tentang... --}}
    </section>
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
    <section id="tautan" class="py-12">
        <h2 class="text-2xl font-bold mb-4">Tautan Sosial</h2>
        {{-- ...konten tautan sosial... --}}
    </section>

</body>
</html>