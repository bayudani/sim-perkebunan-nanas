<x-app-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Laporan Keuangan</h1>
        <p class="text-sm text-slate-500 mt-1">Laporan keuangan perkebunan nanas</p>
    </div>

    <div class="space-y-6">
        
        <!-- Filter Box (Sesuai Wireframe) -->
        <div class="bg-emerald-100 border border-emerald-300 rounded-2xl p-5 shadow-sm">
            <p class="text-sm font-bold text-emerald-800 mb-4">Filter Laporan</p>
            
            <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="w-full md:w-1/3">
                    <label class="block text-xs font-semibold text-emerald-700 mb-1">Pilih Bulan</label>
                    <select name="bulan" class="w-full border-emerald-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                        @foreach($namaBulan as $key => $nama)
                            <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="w-full md:w-1/3">
                    <label class="block text-xs font-semibold text-emerald-700 mb-1">Pilih Tahun</label>
                    <select name="tahun" class="w-full border-emerald-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                        @for($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="w-full md:w-auto flex gap-2">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-colors shadow-sm w-full md:w-auto">
                        Tampilkan
                    </button>
                    <!-- Tombol Cetak PDF -->
                    <a href="{{ route('laporan.cetak', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-colors shadow-sm w-full md:w-auto text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Laporan (PDF)
                    </a>
                </div>
            </form>
        </div>

        <!-- Banner Laporan -->
        <div class="bg-emerald-200/50 border border-emerald-300 rounded-2xl py-6 text-center shadow-sm">
            <h2 class="text-xl font-bold text-emerald-900">Laporan Keuangan</h2>
            <p class="text-emerald-700 font-medium">Perkebunan Nanas</p>
            <p class="text-sm text-emerald-600 mt-1">Periode: {{ $namaBulan[$bulan] }} {{ $tahun }}</p>
        </div>

        <!-- Cards (Pemasukan, Pengeluaran, Saldo) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Pemasukan (Hijau) -->
            <div class="bg-[#10B981] rounded-2xl p-6 shadow-md text-white relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/20 rounded-full"></div>
                <p class="text-sm font-semibold opacity-90 mb-1">Total Pemasukan</p>
                <h3 class="text-2xl font-bold">Rp. {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                <p class="text-xs opacity-80 mt-2">{{ $pemasukans->count() }} Transaksi</p>
            </div>

            <!-- Pengeluaran (Merah) -->
            <div class="bg-[#EF4444] rounded-2xl p-6 shadow-md text-white relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/20 rounded-full"></div>
                <p class="text-sm font-semibold opacity-90 mb-1">Total Pengeluaran</p>
                <h3 class="text-2xl font-bold">Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                <p class="text-xs opacity-80 mt-2">{{ $pengeluarans->count() }} Transaksi</p>
            </div>

            <!-- Saldo (Biru) -->
            <div class="bg-[#2563EB] rounded-2xl p-6 shadow-md text-white relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/20 rounded-full"></div>
                <p class="text-sm font-semibold opacity-90 mb-1">Saldo Bersih</p>
                <h3 class="text-2xl font-bold">Rp. {{ number_format($saldo, 0, ',', '.') }}</h3>
                <p class="text-xs opacity-80 mt-2">Pemasukan - Pengeluaran</p>
            </div>
        </div>

        <!-- Detail Breakdown (2 Kolom) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Box Detail Pemasukan -->
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 shadow-sm">
                <p class="text-sm font-bold text-emerald-800 mb-4 border-b border-emerald-200 pb-2">Detail Pemasukan</p>
                <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                    @forelse($pemasukans as $masuk)
                    <div class="bg-white p-3 rounded-xl border border-slate-100 flex justify-between items-center shadow-sm">
                        <div>
                            <p class="text-sm font-medium text-slate-700">
                                @if($masuk->hasilPanen)
                                    Penjualan nanas ({{ $masuk->hasilPanen->kualitas }})
                                @else
                                    Penjualan Nanas
                                @endif
                            </p>
                            <p class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($masuk->tanggal)->translatedFormat('d M Y') }}</p>
                        </div>
                        <p class="text-sm font-bold text-green-600">+ Rp. {{ number_format($masuk->total_pendapatan, 0, ',', '.') }}</p>
                    </div>
                    @empty
                    <div class="text-center text-sm text-slate-400 py-4">Belum ada pemasukan di bulan ini.</div>
                    @endforelse
                </div>
            </div>

            <!-- Box Detail Pengeluaran -->
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 shadow-sm">
                <p class="text-sm font-bold text-emerald-800 mb-4 border-b border-emerald-200 pb-2">Detail Pengeluaran</p>
                <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                    @forelse($pengeluarans as $keluar)
                    <div class="bg-white p-3 rounded-xl border border-slate-100 flex justify-between items-center shadow-sm">
                        <div>
                            <p class="text-sm font-medium text-slate-700">{{ $keluar->jenis_biaya }}</p>
                            <p class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($keluar->tanggal)->translatedFormat('d M Y') }}</p>
                        </div>
                        <p class="text-sm font-bold text-red-600">- Rp. {{ number_format($keluar->jumlah, 0, ',', '.') }}</p>
                    </div>
                    @empty
                    <div class="text-center text-sm text-slate-400 py-4">Belum ada pengeluaran di bulan ini.</div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</x-app-layout>