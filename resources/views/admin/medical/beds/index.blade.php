<x-layouts.admin title="Ketersediaan Kamar Rawat Inap">
<div class="space-y-6">
    <p class="text-xs text-slate-500">Ubah kapasitas total dan jumlah bed terisi di sini. Data ketersediaan (kosong) dan persentase okupansi akan dihitung otomatis serta langsung diperbarui di web publik.</p>

    <form action="{{ route('admin.beds.update') }}" method="POST">
        @csrf
        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Kelas / Ruang Perawatan</th>
                        <th class="px-6 py-4">Kategori Ruang</th>
                        <th class="px-6 py-4">Total Kapasitas</th>
                        <th class="px-6 py-4">Jumlah Terisi</th>
                        <th class="px-6 py-4">Tersedia (Kosong)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($beds as $b)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-bold text-slate-900">{{ $b->class_name }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $b->gender_room }}</td>
                            <td class="px-6 py-4">
                                <input type="number" name="beds[{{ $b->id }}][total]" value="{{ $b->total }}" class="w-24 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-800">
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" name="beds[{{ $b->id }}][occupied]" value="{{ $b->occupied }}" class="w-24 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-red-600">
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-black text-emerald-600">{{ $b->available }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-[#007b83] hover:bg-[#005b64] text-white font-bold rounded-xl shadow transition">
                    Simpan Perubahan Ketersediaan Bed
                </button>
            </div>
        </div>
    </form>
</div>
</x-layouts.admin>
