<x-layouts.admin title="Pengaturan Umum RS">
<div class="max-w-3xl bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-4 text-xs">
        @csrf
        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Resmi Rumah Sakit</label>
            <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'RSUD R.A.A. Tjokronegoro Purworejo' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Slogan / Tagline</label>
            <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Lengkap</label>
            <textarea name="address" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">{{ $settings['address'] ?? '' }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor Telepon Utama</label>
                <input type="text" name="phone" value="{{ $settings['phone'] ?? '(0275) 2973040' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Hotline IGD 24 Jam</label>
                <input type="text" name="emergency_phone" value="{{ $settings['emergency_phone'] ?? '(0275) 2973040' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">WhatsApp Center / Aduan</label>
                <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '08112521118' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Email Resmi</label>
                <input type="email" name="email" value="{{ $settings['email'] ?? 'rsud.tjokronegoro@purworejokab.go.id' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Status Akreditasi</label>
                <input type="text" name="accreditation" value="{{ $settings['accreditation'] ?? 'Terakreditasi Paripurna (KARS)' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Direktur RS</label>
                <input type="text" name="director_name" value="{{ $settings['director_name'] ?? 'dr. Tolkha Amaruddin, Sp.THT-KL., M.Kes' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-[#007b83] hover:bg-[#005b64] text-white font-bold rounded-xl shadow transition">
                Simpan Konfigurasi RS
            </button>
        </div>
    </form>
</div>
</x-layouts.admin>
