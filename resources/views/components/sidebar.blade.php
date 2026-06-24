<aside 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-emerald-800 text-white flex flex-col shadow-2xl transition-transform duration-300 ease-in-out md:translate-x-0"
>
    <button @click="sidebarOpen = false" class="md:hidden absolute top-4 right-4 p-2 bg-emerald-700 hover:bg-red-500 rounded-lg text-white transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>

    <div class="flex items-center justify-center h-20 border-b border-emerald-700/50 bg-emerald-900/30 mt-12 md:mt-0">
        <div class="flex items-center gap-3">
            <span class="text-3xl">🍍</span>
            <div class="flex flex-col">
                <span class="text-lg font-bold tracking-wide text-emerald-50">SIM Perkebunan</span>
                <span class="text-xs text-emerald-300 font-medium uppercase tracking-widest">Nanas</span>
            </div>
        </div>
    </div>

    <div class="px-4 pt-5 pb-1">
        <div class="bg-emerald-700/50 border border-emerald-600/50 rounded-xl px-4 py-2.5 flex items-center justify-center shadow-sm">
            <div class="flex items-center gap-1.5">
                <div class="w-1.5 h-1.5 rounded-full {{ auth()->user()->role === 'admin' ? 'bg-amber-400' : 'bg-blue-400' }} animate-pulse"></div>
                <span class="text-sm font-bold text-white capitalize">{{ auth()->user()->role ?? 'Guest' }}</span>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
        <p class="px-4 text-xs font-semibold text-emerald-400 uppercase tracking-wider mb-2">Menu Utama</p>

        <!-- Dashboard -->
        <a href="/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('dashboard') ? 'bg-emerald-600 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-700/50 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Biaya Operasional -->
        <a href="/biaya-operasional" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('biaya-operasional*') ? 'bg-emerald-600 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-700/50 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">Biaya Operasional</span>
        </a>

        <!-- Hasil Panen -->
        <a href="/hasil-panen" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('hasil-panen*') ? 'bg-emerald-600 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-700/50 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            <span class="font-medium">Hasil Panen</span>
        </a>

        <!-- Pendapatan -->
        <a href="/pendapatan" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('pendapatan*') ? 'bg-emerald-600 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-700/50 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            <span class="font-medium">Pendapatan</span>
        </a>

        <!-- Laporan Keuangan -->
        <a href="/laporan" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('laporan*') ? 'bg-emerald-600 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-700/50 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span class="font-medium">Laporan Keuangan</span>
        </a>
    </nav>

    <!-- Logout Section -->
    <div class="p-4 border-t border-emerald-700/50 bg-emerald-900/50">
        <!-- Form Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 bg-red-500/90 hover:bg-red-600 text-white rounded-xl transition-colors font-medium text-sm shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout Sistem
            </button>
        </form>
    </div>
</aside>