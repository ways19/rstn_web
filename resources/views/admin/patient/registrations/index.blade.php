<x-layouts.admin title="Pendaftaran Antrean Online">
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.registrations.index') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ !$status ? 'bg-[#007b83] text-white' : 'bg-white border text-slate-700' }}">Semua</a>
            <a href="{{ route('admin.registrations.index', ['status' => 'terdaftar']) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ $status === 'terdaftar' ? 'bg-[#007b83] text-white' : 'bg-white border text-slate-700' }}">Terdaftar</a>
            <a href="{{ route('admin.registrations.index', ['status' => 'dipanggil']) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ $status === 'dipanggil' ? 'bg-[#007b83] text-white' : 'bg-white border text-slate-700' }}">Dipanggil</a>
            <a href="{{ route('admin.registrations.index', ['status' => 'selesai']) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ $status === 'selesai' ? 'bg-[#007b83] text-white' : 'bg-white border text-slate-700' }}">Selesai</a>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">No. Antrean</th>
                    <th class="px-6 py-4">Data Pasien</th>
                    <th class="px-6 py-4">Poli & Dokter</th>
                    <th class="px-6 py-4">Tgl Kunjungan</th>
                    <th class="px-6 py-4">Penjamin</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Ubah Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($registrations as $reg)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-black text-lg text-teal-800">{{ $reg->queue_number }}</td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900 block">{{ $reg->patient_name }}</span>
                            <span class="text-[11px] text-slate-400">NIK: {{ $reg->nik }} {{ $reg->rm_number ? '• RM: ' . $reg->rm_number : '' }}</span>
                            <span class="text-[11px] text-slate-500 block">WA: {{ $reg->phone }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800 block">{{ $reg->clinic }}</span>
                            <span class="text-[11px] text-teal-700">{{ $reg->doctor_name ?? 'Dokter Jaga' }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-700">{{ $reg->visit_date ? $reg->visit_date->format('d/m/Y') : '-' }}</td>
                        <td class="px-6 py-4 uppercase font-bold text-[10px] text-slate-600">{{ $reg->insurance }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase
                                {{ $reg->status === 'terdaftar' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $reg->status === 'dipanggil' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $reg->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                {{ $reg->status === 'batal' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $reg->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.registrations.status', $reg) }}" method="POST" class="inline-flex space-x-1">
                                @csrf
                                @method('PATCH')
                                @if($reg->status === 'terdaftar')
                                    <input type="hidden" name="status" value="dipanggil">
                                    <button type="submit" class="px-2.5 py-1 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700">Panggil</button>
                                @elseif($reg->status === 'dipanggil')
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" class="px-2.5 py-1 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700">Selesai</button>
                                @else
                                    <span class="text-slate-400 text-[11px] italic">Tuntas</span>
                                @endif
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-6 py-8 text-center text-slate-400">Tidak ada data pendaftaran online.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100">
            {{ $registrations->links() }}
        </div>
    </div>
</div>
</x-layouts.admin>
