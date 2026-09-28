<x-layouts.admin title="Edit Berita">
<div class="max-w-2xl bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
    <form action="{{ route('admin.posts.update', $post) }}" method="POST" class="space-y-4 text-xs">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Berita *</label>
            <input type="text" name="title" required value="{{ old('title', $post->title) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori *</label>
                <select name="category" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                    <option value="Berita RS" {{ $post->category === 'Berita RS' ? 'selected' : '' }}>Berita RS</option>
                    <option value="Artikel Kesehatan" {{ $post->category === 'Artikel Kesehatan' ? 'selected' : '' }}>Artikel Kesehatan</option>
                    <option value="Kegiatan & Edukasi" {{ $post->category === 'Kegiatan & Edukasi' ? 'selected' : '' }}>Kegiatan & Edukasi</option>
                    <option value="Pengumuman Resmi" {{ $post->category === 'Pengumuman Resmi' ? 'selected' : '' }}>Pengumuman Resmi</option>
                </select>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Tanggal Publikasi</label>
                <input type="date" name="published_at" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d') : date('Y-m-d')) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Ringkasan Berita *</label>
            <textarea name="excerpt" rows="2" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">{{ old('excerpt', $post->excerpt) }}</textarea>
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Isi Artikel Lengkap *</label>
            <textarea name="content" rows="8" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">{{ old('content', $post->content) }}</textarea>
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">URL Gambar Utama</label>
            <input type="text" name="image" value="{{ old('image', $post->image) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
        </div>

        <div class="flex items-center space-x-2 pt-2">
            <input type="checkbox" name="is_published" value="1" {{ $post->is_published ? 'checked' : '' }} id="published" class="rounded text-teal-600">
            <label for="published" class="font-bold text-slate-700">Publikasikan Langsung ke Publik</label>
        </div>

        <div class="pt-4 flex justify-between">
            <a href="{{ route('admin.posts.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-[#007b83] hover:bg-[#005b64] text-white font-bold rounded-xl shadow transition">Perbarui Berita</button>
        </div>
    </form>
</div>
</x-layouts.admin>
