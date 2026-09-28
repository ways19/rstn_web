<x-layouts.admin title="Pengelolaan Menu Navigasi">
<div class="space-y-6">

    <!-- Location Switch Tabs & Action Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center space-x-2 p-1 bg-slate-100 rounded-xl">
            <a href="{{ route('admin.menus.index', ['location' => 'public']) }}"
               class="px-5 py-2.5 rounded-lg text-sm font-bold transition flex items-center space-x-2 {{ $location === 'public' ? 'bg-white text-[#3b7ddd] shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                <span>Menu Web Publik</span>
                <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $location === 'public' ? 'bg-blue-50 text-[#3b7ddd]' : 'bg-slate-200 text-slate-600' }}">
                    {{ $stats['total_public'] }}
                </span>
            </a>

            <a href="{{ route('admin.menus.index', ['location' => 'admin']) }}"
               class="px-5 py-2.5 rounded-lg text-sm font-bold transition flex items-center space-x-2 {{ $location === 'admin' ? 'bg-white text-[#3b7ddd] shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                <span>Menu Sidebar Admin</span>
                <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $location === 'admin' ? 'bg-blue-50 text-[#3b7ddd]' : 'bg-slate-200 text-slate-600' }}">
                    {{ $stats['total_admin'] }}
                </span>
            </a>
        </div>

        <a href="{{ route('admin.menus.create', ['location' => $location]) }}" class="inline-flex items-center space-x-2 px-5 py-2.5 bg-[#3b7ddd] hover:bg-[#2b65b6] text-white text-sm font-bold rounded-xl shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Menu {{ ucfirst($location) }}</span>
        </a>
    </div>

    <!-- Tree Table of Menus -->
    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-left text-sm">
                <thead class="bg-slate-50 font-bold uppercase text-xs text-slate-500 tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Hierarki Menu & Label</th>
                        <th class="px-6 py-4">Tujuan Tautan / Route</th>
                        @if($location === 'admin')
                            <th class="px-6 py-4">Wewenang / Hak Akses</th>
                        @else
                            <th class="px-6 py-4">Target Tab</th>
                        @endif
                        <th class="px-6 py-4 text-center">Urutan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($menus as $m1)
                        <!-- LEVEL 1 (Root Parent) -->
                        <tr class="bg-slate-50/50 hover:bg-slate-50 font-semibold transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#3b7ddd]"></span>
                                    <span class="text-slate-900 font-extrabold text-sm md:text-base">{{ $m1->title }}</span>
                                    @if($m1->children->count() > 0)
                                        <span class="text-xs px-2 py-0.5 rounded-full bg-blue-50 text-[#3b7ddd] font-bold">
                                            {{ $m1->children->count() }} submenu
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-slate-600">
                                {{ $m1->route_name ?? ($m1->url ?? '#') }}
                            </td>
                            @if($location === 'admin')
                                <td class="px-6 py-4">
                                    @if($m1->permission_name)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100 font-mono">
                                            {{ $m1->permission_name }}
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Bebas Akses (Semua Staf)</span>
                                    @endif
                                </td>
                            @else
                                <td class="px-6 py-4 text-xs font-mono text-slate-500">
                                    {{ $m1->target }}
                                </td>
                            @endif
                            <td class="px-6 py-4 text-center font-bold text-slate-700">
                                {{ $m1->order }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.menus.toggle', $m1) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase transition {{ $m1->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-rose-100 text-rose-800 hover:bg-rose-200' }}" title="Klik untuk ubah status">
                                        {{ $m1->is_active ? 'Aktif' : 'Non-Aktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.menus.edit', $m1) }}" class="text-[#3b7ddd] font-bold hover:underline">Edit</a>
                                <form action="{{ route('admin.menus.destroy', $m1) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus menu {{ $m1->title }} beserta seluruh sub-menunya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 font-bold hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- LEVEL 2 CHILDREN -->
                        @foreach($m1->children as $m2)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-3.5 pl-12">
                                    <div class="flex items-center space-x-2.5">
                                        <span class="text-slate-400 font-mono text-xs">└─</span>
                                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                                        <span class="text-slate-800 font-semibold text-sm">{{ $m2->title }}</span>
                                        @if($m2->children->count() > 0)
                                            <span class="text-[11px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-500 font-bold">
                                                {{ $m2->children->count() }} sub
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-3.5 font-mono text-xs text-slate-500">
                                    {{ $m2->route_name ?? ($m2->url ?? '#') }}
                                </td>
                                @if($location === 'admin')
                                    <td class="px-6 py-3.5">
                                        @if($m2->permission_name)
                                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-purple-50 text-purple-700 border border-purple-100 font-mono">
                                                {{ $m2->permission_name }}
                                            </span>
                                        @else
                                            <span class="text-xs text-slate-400 italic">—</span>
                                        @endif
                                    </td>
                                @else
                                    <td class="px-6 py-3.5 text-xs font-mono text-slate-500">
                                        {{ $m2->target }}
                                    </td>
                                @endif
                                <td class="px-6 py-3.5 text-center text-xs text-slate-600">
                                    {{ $m2->order }}
                                </td>
                                <td class="px-6 py-3.5 text-center">
                                    <form action="{{ route('admin.menus.toggle', $m2) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-2 py-0.5 rounded-full text-[11px] font-bold uppercase transition {{ $m2->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
                                            {{ $m2->is_active ? 'Aktif' : 'Mati' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-3.5 text-right space-x-2 text-xs">
                                    <a href="{{ route('admin.menus.edit', $m2) }}" class="text-[#3b7ddd] font-semibold hover:underline">Edit</a>
                                    <form action="{{ route('admin.menus.destroy', $m2) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus submenu {{ $m2->title }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 font-semibold hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- LEVEL 3 CHILDREN -->
                            @foreach($m2->children as $m3)
                                <tr class="hover:bg-slate-50/70 transition bg-slate-50/20">
                                    <td class="px-6 py-3 pl-20">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-slate-400 font-mono text-xs">├──</span>
                                            <span class="text-slate-600 text-xs md:text-sm font-medium">{{ $m3->title }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 font-mono text-[11px] text-slate-400">
                                        {{ $m3->route_name ?? ($m3->url ?? '#') }}
                                    </td>
                                    @if($location === 'admin')
                                        <td class="px-6 py-3">
                                            @if($m3->permission_name)
                                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-purple-50 text-purple-700 border border-purple-100 font-mono">
                                                    {{ $m3->permission_name }}
                                                </span>
                                            @else
                                                <span class="text-xs text-slate-400 italic">—</span>
                                            @endif
                                        </td>
                                    @else
                                        <td class="px-6 py-3 text-xs font-mono text-slate-400">
                                            {{ $m3->target }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-3 text-center text-xs text-slate-500">
                                        {{ $m3->order }}
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <form action="{{ route('admin.menus.toggle', $m3) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="px-2 py-0.5 rounded text-[10px] font-bold uppercase transition {{ $m3->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
                                                {{ $m3->is_active ? 'Aktif' : 'Mati' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-3 text-right space-x-2 text-xs">
                                        <a href="{{ route('admin.menus.edit', $m3) }}" class="text-[#3b7ddd] font-semibold hover:underline">Edit</a>
                                        <form action="{{ route('admin.menus.destroy', $m3) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus menu {{ $m3->title }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 font-semibold hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-sm">
                                Belum ada menu untuk lokasi {{ ucfirst($location) }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-layouts.admin>
