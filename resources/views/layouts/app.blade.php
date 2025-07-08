<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
<body class="font-sans antialiased relative">

    <!-- Background Gambar -->
    <div class="fixed inset-0 -z-10 bg-cover bg-center" style="background-image: url('/images/bg.jpg');"></div>

    {{-- SIDEBAR sticky, di luar kontainer blur --}}
    <div x-data="{ sidebarCollapsed: false }">
        @include('layouts.sidebar', ['collapsed' => 'sidebarCollapsed'])

        <!-- Konten utama dan navbar -->
        <div class="flex flex-col min-h-screen backdrop-blur-sm">
            @include('layouts.navigation')

            <main :class="sidebarCollapsed ? 'ml-20' : 'ml-64'" class="transition-all duration-300 min-h-screen">
                @if (isset($header))
                <header class="bg-white shadow mb-6">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
                @endif

                {{ $slot }}
            </main>

            @include('layouts.footer')
        </div>
    </div>

    @stack('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>