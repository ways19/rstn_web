<x-layouts.admin title="Pengelolaan Modul Sistem">
<div class="space-y-6">

    <!-- Quick Stats Bar -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#3b7ddd] flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            </div>
            <div>
                <span class="text-xs md:text-sm font-semibold text-slate-400 block uppercase tracking-wider">Total Modul Terdaftar</span>
                <span class="text-2xl font-extrabold text-slate-800">{{ $modules->count() }} Modul</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <span class="text-xs md:text-sm font-semibold text-slate-400 block uppercase tracking-wider">Status Modul Aktif</span>
                <span class="text-2xl font-extrabold text-emerald-600">{{ $modules->where('is_active', true)->count() }} Aktif</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div>
                <span class="text-xs md:text-sm font-semibold text-slate-400 block uppercase tracking-wider">Tautan RBAC Terkoneksi</span>
                <span class="text-2xl font-extrabold text-purple-600">{{ \App\Models\Permission::count() }} Hak Akses</span>
            </div>
        </div>
    </div>

    <!-- Modules Grouped Display -->
    @php
        $groupedModules = $modules->groupBy('group');
    @endphp

    @foreach($groupedModules as $groupName => $modList)
        <div class="space-y-4">
            <div class="flex items-center space-x-3">
                <span class="w-3 h-3 rounded-full bg-[#3b7ddd]"></span>
                <h2 class="text-lg font-extrabold text-slate-800 tracking-tight">{{ $groupName }}</h2>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">{{ count($modList) }} Modul</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($modList as $mod)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm flex flex-col justify-between hover:border-slate-300 transition duration-200 {{ !$mod->is_active ? 'opacity-75 bg-slate-50/50' : '' }}">
                        <div>
                            <!-- Header Card -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ $mod->is_active ? 'bg-blue-50 text-[#3b7ddd]' : 'bg-slate-100 text-slate-400' }}">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $mod->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $mod->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </div>

                            <!-- Title & Desc -->
                            <h3 class="text-base font-bold text-slate-900 mb-1">{{ $mod->name }}</h3>
                            <span class="text-xs font-mono text-slate-400 block mb-3">slug: {{ $mod->slug }}</span>
                            <p class="text-sm text-slate-600 leading-relaxed mb-4 min-h-[42px]">
                                {{ $mod->description ?? 'Modul fungsional terintegrasi SIMRS.' }}
                            </p>
                        </div>

                        <!-- Footer Actions -->
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            @if($mod->route_name && Route::has($mod->route_name))
                                <a href="{{ route($mod->route_name) }}" class="text-sm font-bold text-[#3b7ddd] hover:text-[#2b65b6] hover:underline flex items-center space-x-1">
                                    <span>Buka Modul</span>
                                    <span>&rarr;</span>
                                </a>
                            @else
                                <span class="text-xs text-slate-400 italic">Sistem Internal</span>
                            @endif

                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.modules.edit', $mod) }}" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition" title="Ubah Pengaturan Modul">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                <form action="{{ route('admin.modules.toggle', $mod) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition" title="{{ $mod->is_active ? 'Nonaktifkan Modul' : 'Aktifkan Modul' }}" onclick="return confirm('Ubah status aktif modul {{ $mod->name }}?')">
                                        <svg class="w-4 h-4 {{ $mod->is_active ? 'text-amber-500' : 'text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

</div>
</x-layouts.admin>
