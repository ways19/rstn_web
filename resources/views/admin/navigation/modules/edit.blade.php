<x-layouts.admin :title="'Ubah Modul: ' . $module->name">
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.modules.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-1.5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali ke Daftar Modul</span>
        </a>
    </div>

    <form action="{{ route('admin.modules.update', $module) }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="border-b border-slate-100 pb-4">
            <h3 class="text-base font-bold text-slate-800">Detail Modul: {{ $module->name }}</h3>
            <p class="text-xs text-slate-400 font-mono mt-0.5">Kode Unik: {{ $module->slug }}</p>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Modul <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $module->name) }}" required
                       class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Grup Kategori <span class="text-rose-500">*</span></label>
                <select name="group" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                    <option value="Pelayanan & Pasien" {{ $module->group === 'Pelayanan & Pasien' ? 'selected' : '' }}>Pelayanan & Pasien</option>
                    <option value="Pelayanan Medis" {{ $module->group === 'Pelayanan Medis' ? 'selected' : '' }}>Pelayanan Medis</option>
                    <option value="Informasi & Konten" {{ $module->group === 'Informasi & Konten' ? 'selected' : '' }}>Informasi & Konten</option>
                    <option value="Master & Pengaturan" {{ $module->group === 'Master & Pengaturan' ? 'selected' : '' }}>Master & Pengaturan</option>
                </select>
                @error('group') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Deskripsi Modul</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">{{ old('description', $module->description) }}</textarea>
                @error('description') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Route Utama</label>
                    <input type="text" name="route_name" value="{{ old('route_name', $module->route_name) }}" placeholder="Contoh: admin.registrations.index"
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                    @error('route_name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Urutan Tampil</label>
                    <input type="number" name="order" value="{{ old('order', $module->order) }}" required
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                    @error('order') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Status Ketersediaan Modul</label>
                <select name="is_active" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                    <option value="1" {{ $module->is_active ? 'selected' : '' }}>Aktif (Tersedia untuk pengguna)</option>
                    <option value="0" {{ !$module->is_active ? 'selected' : '' }}>Non-Aktif (Sedang ditutup/maintenance)</option>
                </select>
                @error('is_active') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.modules.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#3b7ddd] hover:bg-[#2b65b6] text-sm font-semibold text-white shadow-sm transition">
                Simpan Perubahan Modul
            </button>
        </div>
    </form>
</div>
</x-layouts.admin>
