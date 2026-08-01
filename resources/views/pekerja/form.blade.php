<x-app-layout>
    <x-slot name="header">{{ isset($pekerja) ? 'Edit Data Pekerja' : 'Tambah Data Pekerja' }}</x-slot>
    <x-slot name="description">Pastikan data pekerja yang diinputkan sudah benar.</x-slot>

    <div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        
        <form action="{{ isset($pekerja) ? route('pekerja.update', $pekerja->id) : route('pekerja.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($pekerja))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- ID Pekerja -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">ID Pekerja <span class="text-red-500">*</span></label>
                    <input type="text" name="id_pekerja" value="{{ old('id_pekerja', $pekerja->id_pekerja ?? '') }}" required
                        class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: PK-001">
                    @error('id_pekerja') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $pekerja->nama ?? '') }}" required
                        class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Budi Santoso">
                    @error('nama') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" required class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $pekerja->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $pekerja->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- No HP -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">No. HP <span class="text-red-500">*</span></label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $pekerja->no_hp ?? '') }}" required
                        class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: 081234567890">
                    @error('no_hp') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-medium transition-colors">
                    {{ isset($pekerja) ? 'Simpan Perubahan' : 'Tambah Data' }}
                </button>
                <a href="{{ route('pekerja.index') }}" class="text-slate-500 hover:text-slate-700 font-medium px-4 py-2">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
