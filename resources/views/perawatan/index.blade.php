<x-app-layout>
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Perawatan</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola Data Kegiatan Perawatan Tanaman</p>
        </div>
        
        <!-- Tombol Tambah Perawatan -->
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('perawatan.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Perawatan
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
        
        <!-- Card Total Kegiatan -->
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-5 w-full shadow-sm">
            <p class="text-sm font-semibold text-emerald-700 mb-1">Total Kegiatan Perawatan</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ $perawatans->count() }} <span class="text-lg text-slate-500 font-medium">Kegiatan</span></h3>
            <p class="text-xs font-medium text-slate-500 mt-1">{{ $perawatans->unique('jenis_kegiatan')->count() }} Jenis kegiatan berbeda</p>
        </div>

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
                            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider shadow-sm">Tanggal</div>
                        </th>
                        <th class="px-2">
                            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider shadow-sm">Jenis Kegiatan</div>
                        </th>
                        <th class="px-2">
                            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider shadow-sm">Blok/Lahan</div>
                        </th>
                        <th class="px-2">
                            <div class="bg-slate-50 border border-slate-200 rounded-full px-4 py-1.5 inline-block text-xs font-semibold text-slate-500 uppercase tracking-wider shadow-sm">Pekerja</div>
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
                    @forelse($perawatans as $index => $item)
                    <tr class="group drop-shadow-sm hover:drop-shadow-md transition-all">
                        <td class="bg-white p-4 text-center rounded-l-2xl group-hover:bg-emerald-50/30 transition-colors">
                            {{ $index + 1 }}
                        </td>
                        <td class="bg-white p-4 group-hover:bg-emerald-50/30 transition-colors">
                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                        </td>
                        <td class="bg-white p-4 font-medium group-hover:bg-emerald-50/30 transition-colors">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">
                                {{ $item->jenis_kegiatan }}
                            </span>
                        </td>
                        <td class="bg-white p-4 group-hover:bg-emerald-50/30 transition-colors">
                            {{ $item->blok_lahan }}
                        </td>
                        <td class="bg-white p-4 {{ auth()->user()->role === 'admin' ? '' : 'rounded-r-2xl' }} group-hover:bg-emerald-50/30 transition-colors">
                            @if($item->pekerjas->count() > 0)
                                <span class="text-xs font-semibold text-emerald-700">{{ $item->pekerjas->count() }} orang</span>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($item->pekerjas->take(3) as $pk)
                                        <span class="text-[11px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full">{{ $pk->nama }}</span>
                                    @endforeach
                                    @if($item->pekerjas->count() > 3)
                                        <span class="text-[11px] text-slate-400">+{{ $item->pekerjas->count() - 3 }} lainnya</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="bg-white p-4 text-slate-500 group-hover:bg-emerald-50/30 transition-colors">
                            {{ $item->keterangan ?? '-' }}
                        </td>
                        
                        @if(auth()->user()->role === 'admin')
                        <td class="bg-white p-4 rounded-r-2xl group-hover:bg-emerald-50/30 transition-colors">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('perawatan.edit', $item->id) }}" class="px-4 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-full transition-colors font-semibold text-xs">
                                    Edit
                                </a>
                                <form action="{{ route('perawatan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                        <td colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}" class="bg-white p-8 text-center text-slate-400 rounded-2xl shadow-sm">
                            Belum ada data perawatan tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    </div>
</x-app-layout>
