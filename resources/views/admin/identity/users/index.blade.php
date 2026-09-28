<x-layouts.admin title="Manajemen Petugas (Users & Roles)">
<div class="space-y-6">
    <!-- Header Card -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-base font-bold text-slate-800">Daftar Akun Pengguna SIMRS</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola kredensial petugas dan tentukan peran (role) untuk tiap staf pengelola modul.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center space-x-2 px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <span>Kelola Role RBAC</span>
            </a>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-[#3b7ddd] hover:bg-[#2b65b6] text-white text-xs font-semibold rounded-xl shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                <span>Tambah Petugas Baru</span>
            </a>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-left text-sm">
                <thead class="bg-slate-50/70 text-slate-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nama Petugas</th>
                        <th class="px-6 py-4">Email Login</th>
                        <th class="px-6 py-4">Role / Hak Akses</th>
                        <th class="px-6 py-4">Terdaftar Sejak</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#3b7ddd] to-[#1cbb8c] text-white flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">{{ $user->name }}</span>
                                        @if($user->id === auth()->id())
                                            <span class="text-xs text-[#3b7ddd] font-semibold">(Akun Anda Sendiri)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-600 text-xs">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($user->roles as $r)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $r->name === 'superadmin' ? 'bg-amber-100 text-amber-800' : 'bg-blue-50 text-blue-700 border border-blue-100' }}">
                                            {{ $r->label }}
                                        </span>
                                    @empty
                                        <span class="text-xs md:text-sm text-slate-400 italic">Belum ada role</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-[#3b7ddd] font-semibold hover:text-[#2b65b6] hover:underline">
                                    Edit
                                </a>

                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus akun petugas {{ $user->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 font-semibold hover:text-rose-700 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-xs">
                                Tidak ada data petugas ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
</x-layouts.admin>
