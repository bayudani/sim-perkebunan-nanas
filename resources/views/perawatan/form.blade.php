<x-app-layout>
    <x-slot name="header">{{ isset($perawatan) ? 'Edit Perawatan' : 'Tambah Perawatan' }}</x-slot>
    <x-slot name="description">Pastikan data kegiatan perawatan yang diinputkan sudah benar.</x-slot>

    <div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        
        <form action="{{ isset($perawatan) ? route('perawatan.update', $perawatan->id) : route('perawatan.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($perawatan))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $perawatan->tanggal ?? date('Y-m-d')) }}" required
                        class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                    @error('tanggal') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Jenis Kegiatan -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Kegiatan <span class="text-red-500">*</span></label>
                    <select name="jenis_kegiatan" required class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Pilih Jenis Kegiatan --</option>
                        @foreach(['Pemupukan', 'Penyemprotan', 'Penyiangan', 'Pembersihan', 'Gotong Royong'] as $jenis)
                            <option value="{{ $jenis }}" {{ old('jenis_kegiatan', $perawatan->jenis_kegiatan ?? '') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                    @error('jenis_kegiatan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Blok/Lahan -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Blok / Lahan <span class="text-red-500">*</span></label>
                    <select name="blok_lahan" required class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Pilih Blok/Lahan --</option>
                        @foreach(['Blok A', 'Blok B', 'Blok C', 'Blok D'] as $blok)
                            <option value="{{ $blok }}" {{ old('blok_lahan', $perawatan->blok_lahan ?? '') == $blok ? 'selected' : '' }}>{{ $blok }}</option>
                        @endforeach
                    </select>
                    @error('blok_lahan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Pilih Pekerja -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pekerja yang Terlibat</label>
                    <div class="border border-slate-200 rounded-xl bg-white overflow-y-auto max-h-48 px-3 py-2 space-y-1.5">
                        @forelse($pekerjas as $pk)
                            <label class="flex items-center gap-2 cursor-pointer hover:bg-slate-50 rounded-lg px-2 py-1.5">
                                <input type="checkbox" name="pekerja_ids[]" value="{{ $pk->id }}"
                                    class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ in_array($pk->id, old('pekerja_ids', isset($perawatan) ? $perawatan->pekerjas->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
                                <span class="text-sm text-slate-700">{{ $pk->nama }}</span>
                                <span class="text-xs text-slate-400 ml-auto">{{ $pk->id_pekerja }}</span>
                            </label>
                        @empty
                            <p class="text-xs text-slate-400 py-2 text-center">Belum ada data pekerja. Tambahkan dulu di menu Data Pekerja.</p>
                        @endforelse
                    </div>
                    @error('pekerja_ids') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    <p class="text-xs text-slate-400 mt-1">Centang pekerja yang ikut dalam kegiatan ini.</p>
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Keterangan Tambahan (Opsional)</label>
                <textarea name="keterangan" rows="3" class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Pemupukan NPK di blok A1...">{{ old('keterangan', $perawatan->keterangan ?? '') }}</textarea>
                @error('keterangan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-medium transition-colors">
                    {{ isset($perawatan) ? 'Simpan Perubahan' : 'Tambah Data' }}
                </button>
                <a href="{{ route('perawatan.index') }}" class="text-slate-500 hover:text-slate-700 font-medium px-4 py-2">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
