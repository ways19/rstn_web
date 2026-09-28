<x-layouts.admin title="Edit Dokter">
<div class="max-w-2xl bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
    <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" class="space-y-4 text-xs">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap & Gelar *</label>
            <input type="text" name="name" required value="{{ old('name', $doctor->name) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Spesialisasi *</label>
                <input type="text" name="speciality" required value="{{ old('speciality', $doctor->speciality) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Sub-Spesialisasi / Keahlian</label>
                <input type="text" name="sub_speciality" value="{{ old('sub_speciality', $doctor->sub_speciality) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Poliklinik Tujuan *</label>
                <input type="text" name="poli" required value="{{ old('poli', $doctor->poli) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Jadwal Praktik (Teks Ringkas) *</label>
                <input type="text" name="schedule" required value="{{ old('schedule', $doctor->schedule) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Pendidikan</label>
                <input type="text" name="education" value="{{ old('education', $doctor->education) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Pengalaman</label>
                <input type="text" name="experience" value="{{ old('experience', $doctor->experience) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            </div>
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">URL Foto Profil Dokter</label>
            <input type="text" name="photo" value="{{ old('photo', $doctor->photo) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
        </div>

        <div class="flex items-center space-x-2 pt-2">
            <input type="checkbox" name="is_active" value="1" {{ $doctor->is_active ? 'checked' : '' }} id="active" class="rounded text-teal-600">
            <label for="active" class="font-bold text-slate-700">Dokter Aktif Melayani</label>
        </div>

        <div class="pt-4 flex justify-between">
            <a href="{{ route('admin.doctors.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-[#007b83] hover:bg-[#005b64] text-white font-bold rounded-xl shadow transition">Perbarui Data Dokter</button>
        </div>
    </form>
</div>
</x-layouts.admin>
