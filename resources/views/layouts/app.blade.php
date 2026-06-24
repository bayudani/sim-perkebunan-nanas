<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIM Perkebunan Nanas') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-200 selection:text-emerald-900 overflow-x-hidden">
        
        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex relative">

            <div x-show="sidebarOpen" 
                 x-transition.opacity 
                 @click="sidebarOpen = false" 
                 class="fixed inset-0 z-40 bg-slate-900/50 md:hidden backdrop-blur-sm cursor-pointer"
                 style="display: none;"></div>

            <x-sidebar />

            <!-- 2. Main Content Area -->
            <div class="flex-1 w-full md:ml-64 transition-all duration-300 flex flex-col min-h-screen">
                
                <!-- Navbar Mobile Khusus HP-->
                <div class="md:hidden flex items-center justify-between bg-emerald-900 text-white p-4 shadow-md sticky top-0 z-30">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">🍍</span>
                        <span class="font-bold tracking-wide">SIM Nanas</span>
                    </div>
                    <!-- Tombol Hamburger -->
                    <button @click="sidebarOpen = true" class="p-2 bg-emerald-800 rounded-lg focus:outline-none hover:bg-emerald-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>

                <!-- Area Konten Dinamis -->
                <main class="p-4 md:p-8 flex-1 w-full overflow-x-hidden">
                    
                    <!-- Topbar/Header Desktop  -->
                    <header class="hidden md:flex mb-8 items-center justify-between">
                        <div>
                            @isset($header)
                                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">{{ $header }}</h1>
                                @isset($description)
                                    <p class="text-sm text-slate-500 mt-1">{{ $description }}</p>
                                @endisset
                            @endisset
                        </div>
                        
                        <div class="flex items-center gap-4">
                            {{-- <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-2xl shadow-sm border border-slate-100">
                                <span class="text-sm font-medium text-slate-600">{{ now()->translatedFormat('l, d F Y') }}</span>
                            </div> --}}
                            <!-- Profile Preview -->
                            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-2xl shadow-sm border border-slate-100">
                                <div class="w-9 h-9 rounded-full bg-emerald-500 flex items-center justify-center text-white font-bold shadow-inner text-sm">
                                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="flex flex-col leading-tight">
                                    <span class="text-sm font-semibold text-slate-800">{{ auth()->user()->name ?? 'User' }}</span>
                                    <span class="text-xs text-emerald-600 capitalize">{{ auth()->user()->role ?? 'Role' }}</span>
                                </div>
                            </div>
                        </div>
                    </header>

                    <!-- Slot Konten Utama (Dashboard, Tabel, dll) -->
                    <div class="animate-fade-in-up">
                        {{ $slot }}
                    </div>

                </main>
            </div>
        </div>

    </body>
</html>