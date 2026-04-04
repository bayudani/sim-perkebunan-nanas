<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIM Perkebunan Nanas</title>
    <!-- Load Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen relative overflow-hidden">

    <!-- Efek Background (Lingkaran Hijau Abstrak) -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
    <div class="absolute top-40 -right-40 w-96 h-96 bg-emerald-300 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-40 left-20 w-96 h-96 bg-emerald-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>

    <!-- Container Login -->
    <div class="relative w-full max-w-md bg-white px-10 py-12 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 z-10">
        
        <!-- Logo & Header -->
        <div class="flex flex-col items-center mb-10">
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-4 shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-slate-800 text-center leading-snug">
                Sistem Informasi Manajemen<br>
                <span class="text-emerald-600">Perkebunan Nanas Berbasis Web</span>
            </h1>
        </div>

        <!-- Session Status (Jika ada pesan error/sukses dari Breeze) -->
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-emerald-600 text-center bg-emerald-50 py-2 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-600 mb-2">Email Akun</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="block w-full pl-10 pr-3 py-3 border @error('email') border-red-300 @else border-slate-200 @enderror rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-shadow"
                        placeholder="Masukkan email Anda">
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-600 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required
                        class="block w-full pl-10 pr-3 py-3 border @error('password') border-red-300 @else border-slate-200 @enderror rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-shadow"
                        placeholder="Masukkan password">
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-slate-600">Ingat Saya</label>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-emerald-600 hover:text-emerald-500">Lupa password?</a>
                    </div>
                @endif
            </div>

            <!-- Tombol Login -->
            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                    Login Sistem
                </button>
            </div>
        </form>

        <!-- Catatan Testing (Bisa dihapus nanti saat mau sidang) -->
        <div class="mt-8 pt-6 border-t border-slate-100">
            <p class="text-xs text-center text-slate-400 mb-2">Akun Testing Joki:</p>
            <div class="flex justify-center gap-4 text-xs">
                <div class="bg-slate-100 px-3 py-1.5 rounded-md">
                    <span class="font-bold text-slate-700">Admin:</span> admin@kebun.com
                </div>
                <div class="bg-slate-100 px-3 py-1.5 rounded-md">
                    <span class="font-bold text-slate-700">Pengelola:</span> pengelola@kebun.com
                </div>
            </div>
            <p class="text-xs text-center text-slate-400 mt-2">Pass: password</p>
        </div>

    </div>
</body>
</html>