<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMPENAS</title>
    
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Laravel Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-200 antialiased text-slate-800 flex items-center justify-center min-h-screen p-4 md:p-8">

    <div class="flex w-full max-w-[1100px] min-h-[650px] bg-white rounded-[2rem] shadow-2xl overflow-hidden relative">
        
        <div class="hidden lg:flex lg:w-1/2 relative bg-cover bg-center" style="background-image: url('/images/bg.jpeg');">
            <div class="absolute inset-0 bg-gradient-to-b from-white/80 via-white/30 to-transparent pointer-events-none"></div>
            
            <div class="relative z-10 p-12 w-full">
                <!-- Logo & Text SIMPENAS -->
                <div class="flex items-center gap-4">
                    <!-- Icon Nanas Custom SVG -->
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-sm">
                        <!-- Daun Nanas -->
                        <path d="M12 2C12 2 9 4 9 7C9 9 12 11 12 11C12 11 15 9 15 7C15 4 12 2 12 2Z" fill="#10B981"/>
                        <path d="M9 7C9 7 6 7 6 10C6 12 9 14 9 14" fill="#059669"/>
                        <path d="M15 7C15 7 18 7 18 10C18 12 15 14 15 14" fill="#059669"/>
                        <!-- Badan Nanas -->
                        <path d="M7 14C7 18.4183 9.23858 22 12 22C14.7614 22 17 18.4183 17 14C17 12 15 11 12 11C9 11 7 12 7 14Z" fill="#F59E0B"/>
                        <!-- Garis Nanas -->
                        <path d="M9.5 13.5L14.5 18.5M14.5 13.5L9.5 18.5" stroke="#D97706" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M8 16.5L11 19.5M16 16.5L13 19.5" stroke="#D97706" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    
                    <div>
                        <h1 class="text-3xl font-extrabold text-emerald-900 tracking-tight">SIMPENAS</h1>
                        <p class="text-sm font-semibold text-emerald-800/80 leading-snug">
                            Sistem Informasi Manajemen<br>Perkebunan Nanas
                        </p>
                    </div>
                </div>
                
                <div class="mt-8 text-emerald-900/90 max-w-sm">
                    <p class="font-medium text-lg leading-relaxed">
                        Hadir untuk manajemen perkebunan yang lebih terpadu, presisi, dan efisien.
                    </p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center relative overflow-hidden bg-slate-50">
            
            <div class="absolute -bottom-40 -right-20 w-[40rem] h-[40rem] bg-emerald-600/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 right-0 w-[25rem] h-[25rem] bg-emerald-500 rounded-tl-full opacity-10 pointer-events-none translate-x-1/4 translate-y-1/4"></div>

            <!-- Card Login -->
            <div class="relative z-10 w-full max-w-[420px] px-8 py-10 bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white">
                
                <!-- Icon User (Selamat Datang) -->
                <div class="flex flex-col items-center mb-8">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mb-5 border border-emerald-100 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-[22px] font-bold text-slate-800 text-center leading-snug">
                        Selamat Datang 👋
                    </h2>
                    <p class="text-sm text-slate-500 text-center mt-2 leading-relaxed">
                        Masuk untuk melanjutkan ke<br>Sistem Informasi Perkebunan Nanas
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-6 font-medium text-sm text-emerald-600 text-center bg-emerald-50 py-3 rounded-xl border border-emerald-100">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-[13px] font-semibold text-slate-600 mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="block w-full pl-11 pr-4 py-3 bg-white border @error('email') border-red-300 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm"
                                placeholder="Masukkan email Anda">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label for="password" class="block text-[13px] font-semibold text-slate-600 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required
                                class="block w-full pl-11 pr-10 py-3 bg-white border @error('password') border-red-300 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm"
                                placeholder="Masukkan password">
                            
                            <!-- Icon Mata -->
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-slate-400 hover:text-slate-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 rounded cursor-pointer">
                            <label for="remember_me" class="ml-2 block text-[13px] text-slate-600 cursor-pointer">Ingat Saya</label>
                        </div>

                        {{-- @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[13px] font-medium text-emerald-600 hover:text-emerald-700 transition-colors">
                                Lupa password?
                            </a>
                        @endif --}}
                    </div>

                    <!-- Tombol Login -->
                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-md shadow-emerald-500/30 text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                            Login Sistem
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>


            </div>
            
            <!-- Watermark Bawah -->
            <div class="absolute bottom-6 text-center w-full z-10 pointer-events-none">
                <p class="text-[11px] text-slate-500 font-medium">© 2024 SIMPENAS. All rights reserved.</p>
            </div>
        </div>
    </div>

</body>
</html>