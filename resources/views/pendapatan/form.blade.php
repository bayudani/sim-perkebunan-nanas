<x-app-layout>
    <x-slot name="header">{{ isset($pendapatan) ? 'Edit Pendapatan' : 'Tambah Pendapatan' }}</x-slot>
    <x-slot name="description">Pastikan data pendapatan dan sumber panen yang diinputkan sudah sesuai.</x-slot>

    <div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        
        <form action="{{ isset($pendapatan) ? route('pendapatan.update', $pendapatan->id) : route('pendapatan.store') }}" method="POST" class="space-y-6"
              x-data="{
                harga_per_kg: {{ old('harga_per_kg', isset($pendapatan) ? (int)$pendapatan->harga_per_kg : 0) }},
                jumlah_terjual: {{ old('jumlah_terjual', isset($pendapatan) ? (int)$pendapatan->jumlah_terjual : 0) }},
                stokTersedia: 0,
                get total() {
                    return this.harga_per_kg * this.jumlah_terjual;
                },
                updateStok(el) {
                    const selected = el.options[el.selectedIndex];
                    this.stokTersedia = selected ? parseFloat(selected.dataset.stok || 0) : 0;
                }
              }"
              x-init="updateStok($el.querySelector('[name=hasil_panen_id]'))">
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
                    <select name="hasil_panen_id" required x-on:change="updateStok($el)" class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50">
                        <option value="">-- Pilih Data Panen --</option>
                        @php
                            $editingId = isset($pendapatan) ? $pendapatan->hasil_panen_id : null;
                            $editingJumlah = isset($pendapatan) ? $pendapatan->jumlah_terjual : 0;
                        @endphp
                        @foreach($hasilPanens as $panen)
                            @php
                                $terjual = $panen->pendapatans->sum('jumlah_terjual');
                                if ($panen->id === $editingId) $terjual -= $editingJumlah;
                                $stok = $panen->jumlah_panen - $terjual;
                            @endphp
                            <option value="{{ $panen->id }}" {{ old('hasil_panen_id', $pendapatan->hasil_panen_id ?? '') == $panen->id ? 'selected' : '' }}
                                data-stok="{{ $stok }}">
                                Panen {{ \Carbon\Carbon::parse($panen->tanggal_panen)->translatedFormat('d M Y') }} — [{{ $panen->kualitas }}] — Stok: {{ number_format($stok, 0, ',', '.') }} / {{ number_format($panen->jumlah_panen, 0, ',', '.') }} Biji
                            </option>
                        @endforeach
                    </select>
                    @error('hasil_panen_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    <p class="text-xs text-slate-400 mt-1" x-show="stokTersedia > 0" x-cloak>
                        Stok tersedia: <strong x-text="stokTersedia.toLocaleString('id-ID')"></strong> Biji
                    </p>
                </div>

                <!-- Jumlah Terjual -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Terjual (Biji) <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_terjual" x-model="jumlah_terjual" required min="0"
                        class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: 10000">
                    @error('jumlah_terjual') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    <div x-show="stokTersedia > 0 && jumlah_terjual > stokTersedia" x-cloak
                         class="mt-2 flex items-center gap-2 px-3 py-2 bg-red-50 border border-red-200 rounded-xl text-xs text-red-700">
                        <svg class="w-4 h-4 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                        <span>Jumlah terjual melebihi stok tersedia (<strong x-text="stokTersedia.toLocaleString('id-ID')"></strong> Biji). Sesuaikan jumlahnya.</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Jumlah biji yang terjual dari sumber panen ini.</p>
                </div>

                <!-- Harga Per Satuan -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Harga Jual per Satuan (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-500 font-medium">Rp</span>
                        </div>
                        <input type="number" name="harga_per_kg" x-model="harga_per_kg" required min="0"
                            class="w-full pl-12 border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: 15000">
                    </div>
                    @error('harga_per_kg') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Total Pendapatan (Auto) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Total Pendapatan (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-500 font-medium">Rp</span>
                        </div>
                        <input type="number" name="total_pendapatan" :value="total" readonly required
                            class="w-full pl-12 border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 bg-emerald-50/50 cursor-not-allowed" placeholder="Otomatis terhitung">
                    </div>
                    @error('total_pendapatan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    <p class="text-xs text-slate-400 mt-1">Otomatis terhitung dari harga satuan × jumlah terjual.</p>
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