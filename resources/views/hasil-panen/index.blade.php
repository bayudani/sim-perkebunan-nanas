<x-app-layout>
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Hasil Panen</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola Data Hasil Panen Nanas</p>
        </div>
        
        <!-- Tombol Tambah Panen -->
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('hasil-panen.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Panen
        </a>
        @endif
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-emerald-100 border border-emerald-400 text-emerald-700 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">
        
        <!-- Card Total Panen -->
        

        <!-- Card Untung/Rugi Per Blok/Lahan -->
        @if($totalPerBlok->count() > 0)
        <div>
            <div class="flex items-center gap-2 mb-4">
                <h2 class="text-lg font-bold text-slate-800">Untung / Rugi per Blok</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($totalPerBlok as $blok => $total)
                    @php
                        $pendapatanBlok = $pendapatanPerBlok[$blok] ?? 0;
                        $biayaBlok = $biayaPerBlok[$blok] ?? 0;
                        $selisih = $pendapatanBlok - $biayaBlok;
                        $untung = $selisih >= 0;
                    @endphp
                    <div class="rounded-2xl p-6 shadow-sm relative overflow-hidden border {{ $untung ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200' }}">
                        <div class="absolute -right-4 -top-4 w-20 h-20 {{ $untung ? 'bg-emerald-200/30' : 'bg-red-200/30' }} rounded-full"></div>
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm font-bold {{ $untung ? 'text-emerald-700' : 'text-red-700' }}">{{ $blok }}</p>
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $untung ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ $untung ? 'UNTUNG' : 'RUGI' }}
                            </span>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500">Pendapatan</span>
                                <span class="font-semibold text-green-600">Rp {{ number_format($pendapatanBlok, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500">Biaya</span>
                                <span class="font-semibold text-red-600">Rp {{ number_format($biayaBlok, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center border-t pt-2 mt-2">
                                <span class="font-medium text-slate-600">{{ $untung ? 'Keuntungan' : 'Kerugian' }}</span>
                                <span class="font-bold {{ $untung ? 'text-emerald-600' : 'text-red-600' }}">Rp {{ number_format(abs($selisih), 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <p class="text-xs font-medium text-slate-400 mt-3">Total panen {{ number_format($total, 0, ',', '.') }} biji · {{ $panens->where('blok_lahan', $blok)->count() }} data</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-5 w-full shadow-sm">
            <p class="text-sm font-semibold text-emerald-700 mb-1">Total Hasil Panen</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ number_format($totalPanen, 0, ',', '.') }} <span class="text-lg text-slate-500 font-medium">Biji</span></h3>
            <p class="text-xs font-medium text-slate-500 mt-1">{{ $panens->count() }} Data panen tercatat</p>
        </div> --}}

        <!-- Container Tabel -->
        <div class="overflow-x-auto pb-4">
            
            <table class="w-full text-left border-separate border-spacing-y-3 min-w-max">
                
                <!-- Header Tabel "Pill" -->
                <thead>
                    <tr>
                        <th class="px-2 text-center w-16">
                            <div class="bg-slate-50 border border-slate-200 rounded-full px-3 py-1.5 inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider shadow-sm">No</div>
                        </th>
                        <th class="px-2">
                            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider shadow-sm">Tanggal Panen</div>
                        </th>
                        <th class="px-2">
                            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider shadow-sm">Blok/Lahan</div>
                        </th>
                        <th class="px-2">
                            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider shadow-sm">Jumlah Panen</div>
                        </th>
                        <th class="px-2">
                            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider shadow-sm">Terjual</div>
                        </th>
                        <th class="px-2">
                            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider shadow-sm">Sisa</div>
                        </th>
                        <th class="px-2">
                            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider shadow-sm">Kualitas</div>
                        </th>
                        <th class="px-2">
                            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider shadow-sm">Keterangan</div>
                        </th>
                        @if(auth()->user()->role === 'admin')
                        <th class="px-2 text-center w-40">
                            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider shadow-sm">Aksi</div>
                        </th>
                        @endif
                    </tr>
                </thead>
                
                <!-- Isi Tabel -->
                <tbody class="text-slate-700 text-sm">
                    @forelse($panens as $index => $item)
                    <tr class="group drop-shadow-sm hover:drop-shadow-md transition-all">
                        <td class="bg-white p-4 text-center rounded-l-2xl group-hover:bg-emerald-50/30 transition-colors">
                            {{ $index + 1 }}
                        </td>
                        <td class="bg-white p-4 group-hover:bg-emerald-50/30 transition-colors">
                            {{ \Carbon\Carbon::parse($item->tanggal_panen)->translatedFormat('d F Y') }}
                        </td>
                        <td class="bg-white p-4 font-medium text-emerald-700 group-hover:bg-emerald-50/30 transition-colors">
                            {{ $item->blok_lahan ?? '-' }}
                        </td>
                        <td class="bg-white p-4 font-bold text-amber-600 group-hover:bg-emerald-50/30 transition-colors">
                            {{ number_format($item->jumlah_panen, 0, ',', '.') }}
                        </td>
                        <td class="bg-white p-4 font-medium text-green-600 group-hover:bg-emerald-50/30 transition-colors">
                            {{ number_format($item->jumlah_terjual, 0, ',', '.') }}
                        </td>
                        <td class="bg-white p-4 font-medium text-slate-600 group-hover:bg-emerald-50/30 transition-colors">
                            {{ number_format($item->sisa, 0, ',', '.') }}
                        </td>
                        <td class="bg-white p-4 group-hover:bg-emerald-50/30 transition-colors">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $item->kualitas == 'Grade A' ? 'bg-green-100 text-green-700' : 
                                  ($item->kualitas == 'Grade B' ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-700') }}">
                                {{ $item->kualitas }}
                            </span>
                        </td>
                        <td class="bg-white p-4 text-slate-500 {{ auth()->user()->role === 'admin' ? '' : 'rounded-r-2xl' }} group-hover:bg-emerald-50/30 transition-colors">
                            {{ $item->keterangan ?? '-' }}
                        </td>
                        
                        @if(auth()->user()->role === 'admin')
                        <td class="bg-white p-4 rounded-r-2xl group-hover:bg-emerald-50/30 transition-colors">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('hasil-panen.edit', $item->id) }}" class="px-4 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-full transition-colors font-semibold text-xs">
                                    Edit
                                </a>
                                <form action="{{ route('hasil-panen.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-full transition-colors font-semibold text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? 9 : 8 }}" class="bg-white p-8 text-center text-slate-400 rounded-2xl shadow-sm">
                            Belum ada data hasil panen tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    </div>
</x-app-layout>