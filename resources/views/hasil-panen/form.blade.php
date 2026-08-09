<x-app-layout>
    <x-slot name="header">{{ isset($panen) ? 'Edit Hasil Panen' : 'Tambah Hasil Panen' }}</x-slot>
    <x-slot name="description">Pastikan data panen yang diinputkan sudah benar.</x-slot>

    <div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        
        <form action="{{ isset($panen) ? route('hasil-panen.update', $panen->id) : route('hasil-panen.store') }}" method="POST" class="space-y-6"
              x-data="{
                jumlah_panen: {{ old('jumlah_panen', isset($panen) ? (int)$panen->jumlah_panen : 0) }},
                jumlah_terjual: {{ old('jumlah_terjual', isset($panen) ? (int)$panen->jumlah_terjual : 0) }},
                get sisa() {
                    return this.jumlah_panen - this.jumlah_terjual;
                }
              }">
            @csrf
            @if(isset($panen))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal Panen -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Panen <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_panen" value="{{ old('tanggal_panen', $panen->tanggal_panen ?? date('Y-m-d')) }}" required
                        class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                    @error('tanggal_panen') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Blok/Lahan -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Blok / Lahan <span class="text-red-500">*</span></label>
                    <select name="blok_lahan" required class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Pilih Blok/Lahan --</option>
                        @foreach(['Blok A', 'Blok B', 'Blok C', 'Blok D'] as $blok)
                            <option value="{{ $blok }}" {{ old('blok_lahan', $panen->blok_lahan ?? '') == $blok ? 'selected' : '' }}>{{ $blok }}</option>
                        @endforeach
                    </select>
                    @error('blok_lahan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kualitas Panen -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kualitas Panen <span class="text-red-500">*</span></label>
                    <select name="kualitas" required class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Pilih Kualitas --</option>
                        <option value="Grade A" {{ old('kualitas', $panen->kualitas ?? '') == 'Grade A' ? 'selected' : '' }}>Grade A (Premium)</option>
                        <option value="Grade B" {{ old('kualitas', $panen->kualitas ?? '') == 'Grade B' ? 'selected' : '' }}>Grade B (Standar)</option>
                        <option value="Grade C" {{ old('kualitas', $panen->kualitas ?? '') == 'Grade C' ? 'selected' : '' }}>Grade C (Biasa)</option>
                    </select>
                    @error('kualitas') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Jumlah Panen -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Panen (Total) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="jumlah_panen" x-model="jumlah_panen" value="{{ old('jumlah_panen', isset($panen) ? (int)$panen->jumlah_panen : '') }}" required min="1"
                            class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: 20000">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <span class="text-slate-400 text-sm">Biji</span>
                        </div>
                    </div>
                    @error('jumlah_panen') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Terjual <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="jumlah_terjual" x-model="jumlah_terjual" value="{{ old('jumlah_terjual', isset($panen) ? (int)$panen->jumlah_terjual : 0) }}" required min="0"
                            class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: 15000">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <span class="text-slate-400 text-sm">Biji</span>
                        </div>
                    </div>
                    @error('jumlah_terjual') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    <div x-show="jumlah_terjual > jumlah_panen" x-cloak
                         class="mt-2 flex items-center gap-2 px-3 py-2 bg-red-50 border border-red-200 rounded-xl text-xs text-red-700">
                        <svg class="w-4 h-4 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                        <span>Jumlah terjual tidak boleh melebihi jumlah panen.</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Sisa Hasil Panen</label>
                    <div class="relative">
                        <input type="number" :value="sisa" readonly
                            class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50/50 cursor-not-allowed" placeholder="Otomatis">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <span class="text-slate-400 text-sm">Biji</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Otomatis: total panen - jumlah terjual.</p>
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Keterangan Tambahan (Opsional)</label>
                <textarea name="keterangan" rows="3" class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Panen lahan bagian timur...">{{ old('keterangan', $panen->keterangan ?? '') }}</textarea>
                @error('keterangan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-medium transition-colors">
                    {{ isset($panen) ? 'Simpan Perubahan' : 'Tambah Data' }}
                </button>
                <a href="{{ route('hasil-panen.index') }}" class="text-slate-500 hover:text-slate-700 font-medium px-4 py-2">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>