<x-layouts.admin title="Manajemen Dokter">
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <p class="text-xs text-slate-500">Kelola daftar dokter spesialis, jadwal poliklinik, dan profil kredensial dokter.</p>
        <a href="{{ route('admin.doctors.create') }}" class="px-4 py-2 bg-[#007b83] hover:bg-[#005b64] text-white text-xs font-bold rounded-xl shadow transition">
            + Tambah Dokter
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Dokter</th>
                    <th class="px-6 py-4">Spesialisasi & Poliklinik</th>
                    <th class="px-6 py-4">Jadwal Praktik</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($doctors as $doc)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 flex items-center space-x-3">
                            <img src="{{ $doc->photo }}" alt="{{ $doc->name }}" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <span class="font-bold text-slate-900 block">{{ $doc->name }}</span>
                                <span class="text-[11px] text-slate-400">{{ $doc->sub_speciality }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-teal-800 block">{{ $doc->speciality }}</span>
                            <span class="text-[11px] text-slate-500">{{ $doc->poli }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 font-medium">{{ $doc->schedule }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $doc->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-700' }}">
                                {{ $doc->is_active ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.doctors.edit', $doc) }}" class="text-[#007b83] font-bold hover:underline">Edit</a>
                            <form action="{{ route('admin.doctors.destroy', $doc) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus dokter ini?')">
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
