<x-layouts.admin title="Pengaduan &amp; Saran Pasien">
<div class="space-y-6">
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Nama Pengirim</th>
                    <th class="px-6 py-4">Kategori & Kontak</th>
                    <th class="px-6 py-4">Isi Pesan / Pengaduan</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($complaints as $comp)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $comp->name }}</td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-teal-800 block">{{ $comp->category }}</span>
                            <span class="text-[11px] text-slate-400">{{ $comp->phone ?? $comp->email }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 max-w-xs line-clamp-2">{{ $comp->message }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $comp->status === 'baru' ? 'bg-red-100 text-red-700' : ($comp->status === 'diproses' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                {{ $comp->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.complaints.show', $comp) }}" class="px-3 py-1.5 bg-[#007b83] hover:bg-[#005b64] text-white font-bold rounded-lg shadow-sm">
                                Respon &rarr;
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-slate-400">Belum ada saran atau pengaduan.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100">
            {{ $complaints->links() }}
        </div>
    </div>
</div>
</x-layouts.admin>
