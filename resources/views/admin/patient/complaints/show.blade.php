<x-layouts.admin title="Tanggapi Pengaduan">
<div class="max-w-2xl bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6 text-xs">
    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-2">
        <div class="flex justify-between items-center">
            <span class="font-bold text-slate-900 text-sm">{{ $complaint->name }}</span>
            <span class="text-[11px] text-slate-400">{{ $complaint->created_at->format('d M Y, H:i') }} WIB</span>
        </div>
        <div class="text-[11px] text-slate-500">
            <span>Kategori: <strong class="text-teal-700">{{ $complaint->category }}</strong></span> • 
            <span>Kontak: {{ $complaint->phone ?? '-' }} | {{ $complaint->email ?? '-' }}</span>
        </div>
        <p class="text-slate-800 pt-2 leading-relaxed italic border-t border-slate-200">
            "{{ $complaint->message }}"
        </p>
    </div>

    <form action="{{ route('admin.complaints.reply', $complaint) }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Status Penanganan *</label>
            <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                <option value="baru" {{ $complaint->status === 'baru' ? 'selected' : '' }}>Baru Masuk</option>
                <option value="diproses" {{ $complaint->status === 'diproses' ? 'selected' : '' }}>Sedang Ditindaklanjuti (Diproses)</option>
                <option value="selesai" {{ $complaint->status === 'selesai' ? 'selected' : '' }}>Selesai / Dituntaskan</option>
            </select>
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Tanggapan / Catatan Tindak Lanjut Resmi</label>
            <textarea name="reply" rows="4" placeholder="Tuliskan tindak lanjut atau tanggapan resmi rumah sakit..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">{{ old('reply', $complaint->reply) }}</textarea>
        </div>

        <div class="pt-4 flex justify-between">
            <a href="{{ route('admin.complaints.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition">&larr; Kembali</a>
            <button type="submit" class="px-6 py-2.5 bg-[#007b83] hover:bg-[#005b64] text-white font-bold rounded-xl shadow transition">Simpan Tanggapan</button>
        </div>
    </form>
</div>
</x-layouts.admin>
