<x-layouts.admin title="Ubah Role &amp; Hak Akses">
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.roles.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-1 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali ke Daftar Role</span>
        </a>
    </div>

    <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-8">
        @csrf
        @method('PUT')

        <!-- Section 1: Informasi Role -->
        <div class="border-b border-slate-100 pb-6">
            <h3 class="text-sm font-bold text-slate-800 mb-1">Informasi Identitas Role</h3>
            <p class="text-xs text-slate-500 mb-5">Perbarui nama label dan deskripsi wewenang role ini.</p>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Label Role <span class="text-rose-500">*</span></label>
                    <input type="text" name="label" value="{{ old('label', $role->label) }}" required
                           class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                    @error('label') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Peran</label>
                    <textarea name="description" rows="2"
                              class="w-full px-4 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">{{ old('description', $role->description) }}</textarea>
                    @error('description') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Section 2: Matriks Hak Akses Modul -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Matriks Hak Akses Modul</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih modul yang diizinkan untuk diakses oleh role ini.</p>
                </div>
                <div class="space-x-3 text-xs">
                    <button type="button" onclick="document.querySelectorAll('.perm-check').forEach(c => c.checked = true)"
                            class="text-[#3b7ddd] font-semibold hover:underline">
                        Pilih Semua
                    </button>
                    <span class="text-slate-300">|</span>
                    <button type="button" onclick="document.querySelectorAll('.perm-check').forEach(c => c.checked = false)"
                            class="text-rose-500 font-semibold hover:underline">
                        Batal Semua
                    </button>
                </div>
            </div>

            @error('permissions')
                <div class="mb-4 p-3 bg-rose-50 text-rose-700 text-xs rounded-xl border border-rose-200">
                    {{ $message }}
                </div>
            @enderror

            <div class="space-y-4">
                @foreach($permissions as $group => $perms)
                    <div class="rounded-xl border border-slate-200/80 p-4 bg-slate-50/50">
                        <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-200/60">
                            <span class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-[#3b7ddd]"></span>
                                <span>{{ $group }}</span>
                            </span>
                            <span class="text-[11px] text-slate-400">{{ count($perms) }} Hak Akses</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($perms as $perm)
                                @php
                                    $isChecked = in_array($perm->id, old('permissions', $rolePermissionIds ?? []));
                                @endphp
                                <label class="flex items-start space-x-3 p-3 rounded-xl bg-white border border-slate-200/70 hover:border-[#3b7ddd]/50 cursor-pointer transition">
                                    <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                                           {{ $isChecked ? 'checked' : '' }}
                                           class="perm-check mt-0.5 rounded text-[#3b7ddd] focus:ring-[#3b7ddd] h-4 w-4">
                                    <div>
                                        <span class="text-xs font-bold text-slate-800 block">{{ $perm->label }}</span>
                                        <span class="text-[10px] font-mono text-slate-400">{{ $perm->name }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Submit & Cancel -->
        <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.roles.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#3b7ddd] hover:bg-[#2b65b6] text-xs font-semibold text-white shadow-sm transition">
                Perbarui Hak Akses
            </button>
        </div>
    </form>
</div>
</x-layouts.admin>
