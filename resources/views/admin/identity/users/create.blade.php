<x-layouts.admin title="Tambah Akun Petugas">
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-1 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali ke Daftar Petugas</span>
        </a>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
        @csrf

        <div class="border-b border-slate-100 pb-5">
            <h3 class="text-sm font-bold text-slate-800 mb-1">Kredensial Login Petugas</h3>
            <p class="text-xs text-slate-500">Masukkan nama lengkap dan email resmi yang digunakan untuk login ke portal SIMRS.</p>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap Petugas <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: dr. Budi Santoso / Siti Rahma, S.Kom"
                       class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email Login <span class="text-rose-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="petugas@rstjokronegoro.id"
                       class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                @error('email') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi (Password) <span class="text-rose-500">*</span></label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter"
                       class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                @error('password') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Role Assignment -->
        <div class="pt-5 border-t border-slate-100">
            <h3 class="text-sm font-bold text-slate-800 mb-1">Penugasan Role / Peran Akses <span class="text-rose-500">*</span></h3>
            <p class="text-xs text-slate-500 mb-4">Pilih satu atau beberapa role yang menentukan modul apa saja yang dapat dikelola.</p>

            @error('roles')
                <div class="mb-4 p-3 bg-rose-50 text-rose-700 text-xs rounded-xl border border-rose-200">
                    {{ $message }}
                </div>
            @enderror

            <div class="space-y-3">
                @foreach($roles as $role)
                    <label class="flex items-start space-x-3 p-3.5 rounded-xl border border-slate-200/80 hover:border-[#3b7ddd]/50 hover:bg-slate-50/50 cursor-pointer transition">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                               {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}
                               class="mt-1 rounded text-[#3b7ddd] focus:ring-[#3b7ddd] h-4 w-4">
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-800">{{ $role->label }}</span>
                                <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-slate-100 text-slate-600">{{ $role->name }}</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-0.5">{{ $role->description ?? 'Tidak ada deskripsi khusus.' }}</p>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Submit & Cancel -->
        <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#3b7ddd] hover:bg-[#2b65b6] text-xs font-semibold text-white shadow-sm transition">
                Simpan Petugas Baru
            </button>
        </div>
    </form>
</div>
</x-layouts.admin>
