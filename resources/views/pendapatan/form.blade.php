<x-app-layout>
    <x-slot name="header">{{ isset($pendapatan) ? 'Edit Pendapatan' : 'Tambah Pendapatan' }}</x-slot>
    <x-slot name="description">Pastikan data pendapatan dan sumber panen yang diinputkan sudah sesuai.</x-slot>

    <div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        
        <form action="{{ isset($pendapatan) ? route('pendapatan.update', $pendapatan->id) : route('pendapatan.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($pendapatan))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal Pendapatan -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Penjualan/Pendapatan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $pendapatan->tanggal ?? date('Y-m-d')) }}" required
                        class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                    @error('tanggal') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Pilihan Hasil Panen Terkait -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Sumber Data Panen Terjual <span class="text-red-500">*</span></label>
                    <select name="hasil_panen_id" required class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50">
                        <option value="">-- Pilih Data Panen --</option>
                        @foreach($hasilPanens as $panen)
                            <option value="{{ $panen->id }}" {{ old('hasil_panen_id', $pendapatan->hasil_panen_id ?? '') == $panen->id ? 'selected' : '' }}>
                                Panen {{ \Carbon\Carbon::parse($panen->tanggal_panen)->translatedFormat('d M Y') }} — [{{ $panen->kualitas }}] — Total: {{ number_format($panen->jumlah_panen, 0, ',', '.') }} Biji/Kg
                            </option>
                        @endforeach
                    </select>
                    @error('hasil_panen_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    <p class="text-xs text-slate-400 mt-1">Pilih data panen yang menjadi sumber pemasukan ini.</p>
                </div>

                <!-- Harga Per Kg/Satuan -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Harga Jual per Satuan (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-500 font-medium">Rp</span>
                        </div>
                        <input type="number" name="harga_per_kg" value="{{ old('harga_per_kg', isset($pendapatan) ? (int)$pendapatan->harga_per_kg : '') }}" required min="0"
                            class="w-full pl-12 border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: 15000">
                    </div>
                    @error('harga_per_kg') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Total Pendapatan -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Total Pendapatan (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-500 font-medium">Rp</span>
                        </div>
                        <input type="number" name="total_pendapatan" value="{{ old('total_pendapatan', isset($pendapatan) ? (int)$pendapatan->total_pendapatan : '') }}" required min="0"
                            class="w-full pl-12 border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50/50" placeholder="Contoh: 15000000">
                    </div>
                    @error('total_pendapatan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Keterangan Tambahan (Opsional)</label>
                <textarea name="keterangan" rows="3" class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Penjualan ke pabrik sirup... ">{{ old('keterangan', $pendapatan->keterangan ?? '') }}</textarea>
                @error('keterangan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-medium transition-colors">
                    {{ isset($pendapatan) ? 'Simpan Perubahan' : 'Tambah Data' }}
                </button>
                <a href="{{ route('pendapatan.index') }}" class="text-slate-500 hover:text-slate-700 font-medium px-4 py-2">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>