<x-app-layout>
    <x-slot name="header">{{ isset($biaya) ? 'Edit Biaya Operasional' : 'Tambah Biaya Operasional' }}</x-slot>
    <x-slot name="description">Pastikan data yang diinputkan sudah benar.</x-slot>

    <div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        
        <form action="{{ isset($biaya) ? route('biaya-operasional.update', $biaya->id) : route('biaya-operasional.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($biaya))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Pengeluaran <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $biaya->tanggal ?? date('Y-m-d')) }}" required
                        class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                    @error('tanggal') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Jenis Biaya -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Biaya <span class="text-red-500">*</span></label>
                    <select name="jenis_biaya" required class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Pilih Jenis --</option>
                        @foreach(['Pembelian Pupuk', 'Pembelian Pestisida', 'Upah Pekerja', 'Transportasi', 'Peralatan'] as $jenis)
                            <option value="{{ $jenis }}" {{ old('jenis_biaya', $biaya->jenis_biaya ?? '') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                        <option value="Lainnya" {{ old('jenis_biaya', $biaya->jenis_biaya ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis_biaya') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Blok/Lahan -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Blok / Lahan</label>
                    <select name="blok_lahan" class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Umum / Tidak Tentu --</option>
                        @foreach(['Blok A', 'Blok B', 'Blok C', 'Blok D'] as $blok)
                            <option value="{{ $blok }}" {{ old('blok_lahan', $biaya->blok_lahan ?? '') == $blok ? 'selected' : '' }}>{{ $blok }}</option>
                        @endforeach
                    </select>
                    @error('blok_lahan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    <p class="text-xs text-slate-400 mt-1">Pilih blok untuk perhitungan untung/rugi per blok.</p>
                </div>

                <!-- Kegiatan Perawatan Terkait -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kegiatan Perawatan Terkait (Opsional)</label>
                    <select name="perawatan_id" class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50">
                        <option value="">-- Tidak Ada / Pilih Kegiatan Perawatan --</option>
                        @foreach($perawatans as $per)
                            <option value="{{ $per->id }}" {{ old('perawatan_id', $biaya->perawatan_id ?? '') == $per->id ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($per->tanggal)->translatedFormat('d M Y') }} — [{{ $per->jenis_kegiatan }}] — {{ $per->blok_lahan }}
                            </option>
                        @endforeach
                    </select>
                    @error('perawatan_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    <p class="text-xs text-slate-400 mt-1">Kaitkan biaya ini dengan kegiatan perawatan tertentu jika ada.</p>
                </div>
            </div>

            <!-- Nominal / Jumlah -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nominal Biaya (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-slate-500 font-medium">Rp</span>
                    </div>
                    <input type="number" name="jumlah" value="{{ old('jumlah', isset($biaya) ? (int)$biaya->jumlah : '') }}" required min="0"
                        class="w-full pl-12 border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: 1500000">
                </div>
                @error('jumlah') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Keterangan Tambahan (Opsional)</label>
                <textarea name="keterangan" rows="3" class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Pembelian pupuk NPK 5 karung...">{{ old('keterangan', $biaya->keterangan ?? '') }}</textarea>
                @error('keterangan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-medium transition-colors">
                    {{ isset($biaya) ? 'Simpan Perubahan' : 'Tambah Data' }}
                </button>
                <a href="{{ route('biaya-operasional.index') }}" class="text-slate-500 hover:text-slate-700 font-medium px-4 py-2">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>