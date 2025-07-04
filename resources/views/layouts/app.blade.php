{{-- resources/views/components/app-layout.blade.php (VERSI PERBAIKAN) --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Blok <style> tidak lagi diperlukan dan telah dihapus --}}
    </head>
    
    <body class="font-sans antialiased bg-gray-100">

        {{-- Container utama yang mengatur layout vertikal (Navbar, Konten, Footer) --}}
        <div class="flex flex-col min-h-screen">

            {{-- NAVBAR --}}
            @include('layouts.navigation')

            {{-- Wrapper untuk Sidebar dan Konten Utama --}}
            {{-- KUNCI UTAMA ADA DI SINI: --}}
            {{-- 'flex' menata sidebar & main secara horizontal --}}
            {{-- 'flex-1' membuat wrapper ini mengisi sisa ruang vertikal antara navbar dan footer --}}
            <div class="flex flex-1">

                {{-- SIDEBAR --}}
                @include('layouts.sidebar')

                {{-- KONTEN UTAMA --}}
                {{-- 'flex-1' membuat main mengisi sisa ruang horizontal --}}
                {{-- 'overflow-y-auto' memberikan scroll hanya pada area ini jika kontennya panjang --}}
                <main class="flex-1 p-6 overflow-y-auto">
                    @if (isset($header))
                        <header class="bg-white shadow mb-6">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endif

                    {{-- Slot untuk konten halaman spesifik --}}
                    {{ $slot }}
                </main>

            </div>

            {{-- FOOTER --}}
            {{-- Footer akan otomatis terdorong ke bawah --}}
            @include('layouts.footer')

        </div>
        @stack('scripts')
    </body>
</html>