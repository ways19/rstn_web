<x-layouts.admin title="Manajemen Berita &amp; Artikel">
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <p class="text-xs text-slate-500">Kelola artikel berita, rilis kegiatan rumah sakit, dan edukasi kesehatan untuk masyarakat.</p>
        <a href="{{ route('admin.posts.create') }}" class="px-4 py-2 bg-[#007b83] hover:bg-[#005b64] text-white text-xs font-bold rounded-xl shadow transition">
            + Tulis Berita Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Judul Artikel</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Tanggal Rilis</th>
                    <th class="px-6 py-4">Pembaca</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($posts as $post)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 flex items-center space-x-3">
                            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-10 h-10 rounded-lg object-cover">
                            <div>
                                <span class="font-bold text-slate-900 block">{{ $post->title }}</span>
                                <span class="text-[11px] text-slate-400">/berita/{{ $post->slug }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                {{ $post->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $post->published_at ? $post->published_at->format('d M Y') : '-' }}</td>
                        <td class="px-6 py-4 text-teal-800 font-bold">{{ $post->views }}x</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $post->is_published ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-700' }}">
                                {{ $post->is_published ? 'Terbit' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-[#007b83] font-bold hover:underline">Edit</a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 font-bold hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</x-layouts.admin>
