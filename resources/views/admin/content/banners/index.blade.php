<x-layouts.admin title="Hero Banner Slider">
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <p class="text-xs text-slate-500">Banner besar yang tampil berputar (carousel) di bagian atas homepage.</p>
        <a href="{{ route('admin.banners.create') }}" class="px-4 py-2 bg-[#007b83] hover:bg-[#005b64] text-white text-xs font-bold rounded-xl shadow transition">
            + Tambah Slide Banner
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Slide Banner</th>
                    <th class="px-6 py-4">Subtitle & Tag</th>
                    <th class="px-6 py-4">Tombol CTA</th>
                    <th class="px-6 py-4">Urutan</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($banners as $banner)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 flex items-center space-x-3">
                            <img src="{{ $banner->image }}" alt="{{ $banner->title }}" class="w-16 h-10 rounded-lg object-cover">
                            <div>
                                <span class="font-bold text-slate-900 block">{{ $banner->title }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $banner->subtitle }}</td>
                        <td class="px-6 py-4 text-teal-800 font-bold">{{ $banner->cta_text }}</td>
                        <td class="px-6 py-4 font-bold">{{ $banner->order }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $banner->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-700' }}">
                                {{ $banner->is_active ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="text-[#007b83] font-bold hover:underline">Edit</a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus banner ini?')">
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
