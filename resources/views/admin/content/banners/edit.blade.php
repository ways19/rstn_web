<x-layouts.admin title="Edit Banner">
<div class="max-w-2xl bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" class="space-y-4 text-xs">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Banner *</label>
            <input type="text" name="title" required value="{{ old('title', $banner->title) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Sub Judul / Badge</label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
            <textarea name="description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">{{ old('description', $banner->description) }}</textarea>
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">URL Gambar Latar Banner</label>
            <input type="text" name="image" value="{{ old('image', $banner->image) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Teks Tombol Utama</label>
                <input type="text" name="cta_text" value="{{ old('cta_text', $banner->cta_text) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Link Tombol Utama</label>
                <input type="text" name="cta_link" value="{{ old('cta_link', $banner->cta_link) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Teks Tombol Kedua</label>
                <input type="text" name="cta_text2" value="{{ old('cta_text2', $banner->cta_text2) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Link Tombol Kedua</label>
                <input type="text" name="cta_link2" value="{{ old('cta_link2', $banner->cta_link2) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Urutan</label>
                <input type="number" name="order" value="{{ old('order', $banner->order) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
            <div class="flex items-center space-x-2 pt-6">
                <input type="checkbox" name="is_active" value="1" {{ $banner->is_active ? 'checked' : '' }} id="active" class="rounded text-teal-600">
                <label for="active" class="font-bold text-slate-700">Slide Aktif</label>
            </div>
        </div>

        <div class="pt-4 flex justify-between">
            <a href="{{ route('admin.banners.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-[#007b83] hover:bg-[#005b64] text-white font-bold rounded-xl shadow transition">Perbarui Banner</button>
        </div>
    </form>
</div>
</x-layouts.admin>
