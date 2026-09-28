<x-layouts.admin title="Tambah Layanan Baru">
<div class="max-w-2xl bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
    <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-4 text-xs">
        @csrf
        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Layanan *</label>
            <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Poliklinik Penyakit Dalam" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori *</label>
                <select name="category" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                    <option value="rawat-jalan">Rawat Jalan</option>
                    <option value="rawat-inap">Rawat Inap</option>
                    <option value="darurat">Gawat Darurat (24 Jam)</option>
                    <option value="unggulan">Layanan Unggulan</option>
                    <option value="penunjang">Penunjang Medis</option>
                </select>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Tag / Label</label>
                <input type="text" name="tag" value="{{ old('tag') }}" placeholder="Contoh: Standar Paripurna" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Ringkasan Singkat *</label>
            <textarea name="excerpt" rows="2" required placeholder="Penjelasan singkat untuk kartu preview..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">{{ old('excerpt') }}</textarea>
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Lengkap *</label>
            <textarea name="description" rows="5" required placeholder="Deskripsi lengkap mengenai prosedur, keunggulan, dan alur layanan..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Daftar Fasilitas Utama (1 baris per fasilitas)</label>
            <textarea name="facilities_text" rows="3" placeholder="Ruang Resusitasi&#10;Ambulans 24 Jam&#10;Defibrilator" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">{{ old('facilities_text') }}</textarea>
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">URL Gambar Layanan</label>
            <input type="text" name="image" value="{{ old('image') }}" placeholder="https://..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
        </div>

        <div class="flex items-center space-x-2 pt-2">
            <input type="checkbox" name="is_active" value="1" checked id="active" class="rounded text-teal-600">
            <label for="active" class="font-bold text-slate-700">Tampilkan di Web Publik</label>
        </div>

        <div class="pt-4 flex justify-between">
            <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-[#007b83] hover:bg-[#005b64] text-white font-bold rounded-xl shadow transition">Simpan Layanan</button>
        </div>
    </form>
</div>
</x-layouts.admin>
