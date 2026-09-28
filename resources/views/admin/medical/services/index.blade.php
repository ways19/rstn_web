<x-layouts.admin title="Manajemen Layanan RS">
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <p class="text-xs text-slate-500">Kelola seluruh layanan rawat jalan, rawat inap, IGD, dan penunjang medis yang tampil di web publik.</p>
        <a href="{{ route('admin.services.create') }}" class="px-4 py-2 bg-[#007b83] hover:bg-[#005b64] text-white text-xs font-bold rounded-xl shadow transition">
            + Tambah Layanan
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Layanan</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Tag</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($services as $svc)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 flex items-center space-x-3">
                            <img src="{{ $svc->image }}" alt="{{ $svc->title }}" class="w-10 h-10 rounded-lg object-cover">
                            <div>
                                <span class="font-bold text-slate-900 block">{{ $svc->title }}</span>
                                <span class="text-[11px] text-slate-400">/layanan/{{ $svc->slug }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                {{ $svc->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-teal-700 font-semibold">{{ $svc->tag }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $svc->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-700' }}">
                                {{ $svc->is_active ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.services.edit', $svc) }}" class="text-[#007b83] font-bold hover:underline">Edit</a>
                            <form action="{{ route('admin.services.destroy', $svc) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus layanan ini?')">
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
