<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/logoweb.png') }}" type="image/png">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center gap-3">
                        <!-- Logo Placeholder -->
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                            K
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900 leading-tight">
                                Kinerja LPSPL Sorong
                            </h1>
                            <p class="text-xs text-gray-500">Sistem Publikasi Kinerja Pemerintah</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <!-- Admin Link Removed -->
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} Kinerja LPSPL Sorong. Hak Cipta Dilindungi.
                </p>
            </div>
        </footer>
    </div>

    @livewire('ai-chat-widget')
</body>
</html>