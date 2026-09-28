<x-layouts.admin title="Hak Akses & Role (RBAC)">
<div class="space-y-6">
    <!-- Header Card -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-base font-bold text-slate-800">Manajemen Peran & Otorisasi Sistem (RBAC)</h2>
            <p class="text-sm text-slate-500 mt-1">Atur batasan hak akses modul pendaftaran, poliklinik, admisi bed rawat inap, humas, dan konfigurasi profil RS.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center space-x-2 px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span>Kelola Akun Petugas</span>
            </a>
            <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-[#3b7ddd] hover:bg-[#2b65b6] text-white text-xs font-semibold rounded-xl shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Tambah Role Baru</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center space-x-4">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#3b7ddd] flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-medium block">Total Role Peran</span>
                <span class="text-lg font-bold text-slate-800">{{ $roles->count() }} Role</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center space-x-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-medium block">Total Petugas Terdaftar</span>
                <span class="text-lg font-bold text-slate-800">{{ \App\Models\User::count() }} Pengguna</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center space-x-4">
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-medium block">Matriks Hak Akses Modul</span>
                <span class="text-lg font-bold text-slate-800">{{ \App\Models\Permission::count() }} Modul Izin</span>
            </div>
        </div>
    </div>

    <!-- Role Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($roles as $role)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between hover:border-slate-300 transition-all duration-200">
                <div class="p-6">
                    <!-- Top Badge & Icon -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $role->name === 'superadmin' ? 'bg-amber-100 text-amber-700' : 'bg-blue-50 text-[#3b7ddd]' }}">
                            @if($role->name === 'superadmin')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            @endif
                        </div>
                        <span class="text-xs font-mono px-2.5 py-1 rounded-full {{ $role->name === 'superadmin' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600' }} font-semibold">
                            {{ $role->name }}
                        </span>
                    </div>

                    <!-- Role Name & Desc -->
                    <h3 class="text-base font-bold text-slate-800 mb-1">{{ $role->label }}</h3>
                    <p class="text-sm text-slate-500 mb-4 line-clamp-2 leading-relaxed min-h-[36px]">
                        {{ $role->description ?? 'Peran operasional sistem SIMRS.' }}
                    </p>

                    <!-- User Count -->
                    <div class="flex items-center text-sm text-slate-600 mb-4 pb-4 border-b border-slate-100">
                        <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="font-semibold text-slate-800">{{ $role->users->count() }}</span>
                        <span class="ml-1 text-slate-500">petugas ditugaskan</span>
                    </div>

                    <!-- Permissions Granted -->
                    <div>
                        <span class="text-xs md:text-sm font-bold text-slate-700 block mb-2">Cakupan Hak Akses Modul:</span>
                        @if($role->name === 'superadmin')
                            <div class="p-2.5 rounded-xl bg-amber-50/80 border border-amber-200/70 text-xs md:text-sm text-amber-900 flex items-center space-x-2">
                                <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="font-semibold">Akses penuh ke semua modul sistem & pengaturan</span>
                            </div>
                        @else
                            <div class="flex flex-wrap gap-1.5 max-h-32 overflow-y-auto">
                                @forelse($role->permissions as $perm)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                        <svg class="w-2.5 h-2.5 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        {{ $perm->label }}
                                    </span>
                                @empty
                                    <span class="text-xs md:text-sm text-slate-400 italic">Belum ada izin modul yang dipilih</span>
                                @endforelse
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-6 py-3.5 bg-slate-50/80 border-t border-slate-100 rounded-b-2xl flex items-center justify-between text-xs">
                    <a href="{{ route('admin.roles.edit', $role) }}" class="text-[#3b7ddd] font-semibold hover:text-[#2b65b6] flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <span>Ubah Hak Akses</span>
                    </a>

                    @if($role->name !== 'superadmin')
                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Hapus role {{ $role->label }}? Petugas dengan role ini akan kehilangan hak akses terkait.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-500 hover:text-rose-700 font-semibold flex items-center space-x-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                <span>Hapus</span>
                            </button>
                        </form>
                    @else
                        <span class="text-xs text-slate-400 font-medium italic">Role Inti Sistem</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
</x-layouts.admin>
