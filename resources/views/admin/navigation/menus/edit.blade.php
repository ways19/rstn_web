<x-layouts.admin :title="'Ubah Menu: ' . $menu->title">
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.menus.index', ['location' => $menu->location]) }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-1.5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali ke Daftar Menu</span>
        </a>
    </div>

    <form action="{{ route('admin.menus.update', $menu) }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="border-b border-slate-100 pb-4">
            <h3 class="text-base font-bold text-slate-800">Ubah Menu: {{ $menu->title }}</h3>
            <p class="text-xs text-slate-500 mt-0.5">Lokasi: <span class="font-bold text-[#3b7ddd] uppercase">{{ $menu->location }}</span></p>
        </div>

        <div class="space-y-4">
            <!-- Lokasi Menu -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Lokasi Menu <span class="text-rose-500">*</span></label>
                <select name="location" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                    <option value="public" {{ old('location', $menu->location) === 'public' ? 'selected' : '' }}>Web Publik (Header / Navbar Pengunjung)</option>
                    <option value="admin" {{ old('location', $menu->location) === 'admin' ? 'selected' : '' }}>Sidebar Admin (Panel Petugas SIMRS)</option>
                </select>
                @error('location') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Parent Menu (Hierarki) -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Induk Menu (Parent)</label>
                <select name="parent_id" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                    <option value="">— Menu Utama (Level 1) —</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}" {{ old('parent_id', $menu->parent_id) == $p->id ? 'selected' : '' }}>
                            {{ $p->title }} (Level 1)
                        </option>
                        @foreach($p->children as $c)
                            @if($c->id != $menu->id)
                                <option value="{{ $c->id }}" {{ old('parent_id', $menu->parent_id) == $c->id ? 'selected' : '' }}>
                                    &nbsp;&nbsp;└─ {{ $c->title }} (Level 2)
                                </option>
                            @endif
                        @endforeach
                    @endforeach
                </select>
                @error('parent_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Judul Menu -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1.5">Judul / Label Menu <span class="text-rose-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $menu->title) }}" required
                       class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                @error('title') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Route Name or URL -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Route Internal</label>
                    <input type="text" name="route_name" value="{{ old('route_name', $menu->route_name) }}" placeholder="Contoh: services / admin.doctors.index"
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition font-mono">
                    @error('route_name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Custom URL / Path</label>
                    <input type="text" name="url" value="{{ old('url', $menu->url) }}" placeholder="Contoh: /tentang-kami#sejarah"
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                    @error('url') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Target Tab & Permission -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Target Buka Halaman <span class="text-rose-500">*</span></label>
                    <select name="target" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                        <option value="_self" {{ old('target', $menu->target) === '_self' ? 'selected' : '' }}>Tab Yang Sama (_self)</option>
                        <option value="_blank" {{ old('target', $menu->target) === '_blank' ? 'selected' : '' }}>Tab Baru (_blank - Link Luar/File)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Hak Akses Wajib (Khusus Admin)</label>
                    <select name="permission_name" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition font-mono">
                        <option value="">— Bebas Akses (Semua Staf) —</option>
                        @foreach($permissions as $perm)
                            <option value="{{ $perm->name }}" {{ old('permission_name', $menu->permission_name) === $perm->name ? 'selected' : '' }}>
                                {{ $perm->name }} ({{ $perm->label }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Urutan & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Urutan Tampil (Order) <span class="text-rose-500">*</span></label>
                    <input type="number" name="order" value="{{ old('order', $menu->order) }}" required
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                    @error('order') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Status Menu <span class="text-rose-500">*</span></label>
                    <select name="is_active" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/20 focus:border-[#3b7ddd] transition">
                        <option value="1" {{ old('is_active', $menu->is_active) ? 'selected' : '' }}>Aktif (Ditampilkan)</option>
                        <option value="0" {{ !old('is_active', $menu->is_active) ? 'selected' : '' }}>Non-Aktif (Disembunyikan)</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.menus.index', ['location' => $menu->location]) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#3b7ddd] hover:bg-[#2b65b6] text-sm font-semibold text-white shadow-sm transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
</x-layouts.admin>
