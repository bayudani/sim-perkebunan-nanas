<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIM Perkebunan Nanas') }}</title>

        <!-- Fonts Custom (Plus Jakarta Sans) -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts Tailwind / Vite bawaan Laravel -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-200 selection:text-emerald-900">
        
        <div class="min-h-screen flex">
            <!-- 1. Memanggil Component Sidebar Buatan Kita -->
            <x-sidebar />

            <!-- 2. Main Content Area (diberi margin-left 64 agar tidak tertutup sidebar) -->
            <main class="ml-64 w-full p-8 transition-all duration-300">
                
                <!-- Topbar/Header Dinamis -->
                @isset($header)
                    <header class="mb-8 flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">{{ $header }}</h1>
                            @isset($description)
                                <p class="text-sm text-slate-500 mt-1">{{ $description }}</p>
                            @endisset
                        </div>
                        
                        <!-- Tanggal Hari Ini -->
                        <div class="flex items-center gap-4 bg-white px-4 py-2 rounded-2xl shadow-sm border border-slate-100">
                            <span class="text-sm font-medium text-slate-600">{{ now()->translatedFormat('l, d F Y') }}</span>
                        </div>
                    </header>
                @endisset

                <!-- Tempat konten dinamis (dashboard, dll) disisipkan -->
                <div class="animate-fade-in-up">
                    {{ $slot }}
                </div>

            </main>
        </div>

    </body>
</html>