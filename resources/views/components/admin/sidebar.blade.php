<!-- Mobile Backdrop Overlay -->
<div x-show="mobileSidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="mobileSidebarOpen = false" 
     class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-30 lg:hidden"
     style="display: none;"></div>

<!-- AdminKit Sidebar with Collapsible State & 3-Level Dropdown -->
<aside class="fixed inset-y-0 left-0 z-40 w-72 bg-[#222e3c] text-[#adb5bd] flex flex-col justify-between transition-all duration-300 ease-in-out"
       :class="[
           mobileSidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full',
           sidebarCollapsed ? 'lg:-translate-x-full' : 'lg:translate-x-0'
       ]">
    
    <div class="flex-grow overflow-y-auto">
        <!-- Sidebar Brand Header (Clean: Title & Kabupaten Purworejo) -->
        <div class="h-20 flex items-center px-4 border-b border-slate-800/80">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-white hover:text-white transition group w-full">
                <img src="{{ asset('logo.png') }}" alt="Logo Purworejo" class="w-10 h-10 object-contain drop-shadow-md flex-shrink-0 transition-transform group-hover:scale-105">
                <div class="flex flex-col min-w-0 flex-1">
                    <div class="font-bold text-[14px] text-white tracking-tight leading-tight whitespace-nowrap" title="RSUD R.A.A. Tjokronegoro">
                        RSUD R.A.A. Tjokronegoro
                    </div>
                    <div class="text-[11.5px] text-slate-400 font-medium tracking-wide mt-1 whitespace-nowrap">
                        Kabupaten Purworejo
                    </div>
                </div>
            </a>
            <!-- Close Button on Mobile -->
            <button type="button" @click="mobileSidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1.5 rounded-lg focus:outline-none ml-2 cursor-pointer" aria-label="Close Sidebar">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="pb-6">
            <!-- Group 1: Pages -->
            <div class="px-6 pt-5 pb-2 text-xs font-bold text-[#889097] uppercase tracking-wider">
                Halaman Utama
            </div>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3.5 px-6 py-3.5 text-sm md:text-[15px] transition {{ request()->routeIs('admin.dashboard') ? 'adminkit-sidebar-active' : 'hover:text-[#e9ecef] hover:bg-slate-800/30' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-[#3b7ddd]' : 'text-[#889097]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Dashboard</span>
            </a>

            <!-- Group 2: Pelayanan & Pasien -->
            @canany(['manage_services', 'manage_beds', 'manage_registrations', 'manage_complaints'])
                <div class="px-6 pt-5 pb-2 text-xs font-bold text-[#889097] uppercase tracking-wider">
                    Layanan & Pasien
                </div>
            @endcanany

            <!-- 3-LEVEL DROPDOWN 1: Pelayanan RS -->
            @canany(['manage_services', 'manage_beds'])
            <div>
                <!-- LEVEL 1 BUTTON -->
                <button type="button" @click="toggle('pelayanan')" 
                        class="w-full flex items-center justify-between px-6 py-3.5 text-sm md:text-[15px] transition text-left hover:text-[#e9ecef] hover:bg-slate-800/30 cursor-pointer"
                        :class="openMenus['pelayanan'] ? 'text-[#e9ecef] font-semibold' : ''">
                    <div class="flex items-center space-x-3.5">
                        <svg class="w-5 h-5 text-[#889097]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        <span>Pelayanan RS</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="openMenus['pelayanan'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <!-- LEVEL 2 CONTAINER -->
                <div x-show="openMenus['pelayanan']" x-transition class="bg-[#1b2531]/70 border-l-2 border-[#3b7ddd]/40 ml-5 pl-2 space-y-1 py-1" style="display: none;">
                    
                    @can('manage_services')
                    <!-- LEVEL 2 ITEM A: Rawat Jalan -->
                    <div>
                        <button type="button" @click="toggle('rawat_jalan')" 
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                                :class="openMenus['rawat_jalan'] ? 'text-white font-bold' : 'text-[#adb5bd]'">
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-teal-400"></span>
                                <span>Rawat Jalan & Poli</span>
                            </span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openMenus['rawat_jalan'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        <!-- LEVEL 3 ITEMS FOR RAWAT JALAN -->
                        <div x-show="openMenus['rawat_jalan']" x-transition class="pl-7 pr-3 py-1.5 space-y-2 text-sm" style="display: none;">
                            <a href="{{ route('admin.services.index') }}" class="block text-slate-300 font-medium hover:text-white transition py-0.5">• Poliklinik & Spesialis</a>
                            <a href="{{ route('admin.doctors.index') }}" class="block text-slate-400 hover:text-white transition py-0.5">• Jadwal Praktik Dokter</a>
                            <a href="{{ route('admin.services.create') }}" class="block text-teal-300 font-semibold hover:text-white transition py-0.5">+ Tambah Layanan Baru</a>
                        </div>
                    </div>
                    @endcan

                    @can('manage_beds')
                    <!-- LEVEL 2 ITEM B: Rawat Inap & ICU -->
                    <div>
                        <button type="button" @click="toggle('rawat_inap')" 
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                                :class="openMenus['rawat_inap'] ? 'text-white font-bold' : 'text-[#adb5bd]'">
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                <span>Rawat Inap & Kamar</span>
                            </span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openMenus['rawat_inap'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        <!-- LEVEL 3 ITEMS FOR RAWAT INAP -->
                        <div x-show="openMenus['rawat_inap']" x-transition class="pl-7 pr-3 py-1.5 space-y-2 text-sm" style="display: none;">
                            <a href="{{ route('admin.beds.index') }}" class="block text-slate-300 font-medium hover:text-white transition py-0.5">• Ketersediaan Tempat Tidur</a>
                            <a href="{{ route('admin.beds.index') }}" class="block text-slate-400 hover:text-white transition py-0.5">• Ruang VIP & Kelas 1, 2, 3</a>
                            <a href="{{ route('admin.beds.index') }}" class="block text-slate-400 hover:text-white transition py-0.5">• ICU & Isolasi Tekanan Negatif</a>
                        </div>
                    </div>
                    @endcan

                    @can('manage_services')
                    <!-- LEVEL 2 ITEM C: Darurat & Penunjang -->
                    <div>
                        <button type="button" @click="toggle('darurat_bedah')" 
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                                :class="openMenus['darurat_bedah'] ? 'text-white font-bold' : 'text-[#adb5bd]'">
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                                <span>IGD & Operasi</span>
                            </span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openMenus['darurat_bedah'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        <!-- LEVEL 3 ITEMS FOR DARURAT -->
                        <div x-show="openMenus['darurat_bedah']" x-transition class="pl-7 pr-3 py-1.5 space-y-2 text-sm" style="display: none;">
                            <a href="{{ route('admin.services.index') }}" class="block text-slate-400 hover:text-white transition py-0.5">• IGD 24 Jam & Triage</a>
                            <a href="{{ route('admin.services.index') }}" class="block text-slate-400 hover:text-white transition py-0.5">• Kamar Operasi (IBS)</a>
                            <a href="{{ route('admin.services.index') }}" class="block text-slate-400 hover:text-white transition py-0.5">• Laboratorium & Radiologi</a>
                        </div>
                    </div>
                    @endcan

                </div>
            </div>
            @endcanany

            <!-- 3-LEVEL DROPDOWN 2: Pasien & Antrean -->
            @canany(['manage_registrations', 'manage_complaints'])
            <div>
                <!-- LEVEL 1 BUTTON -->
                <button type="button" @click="toggle('pasien')" 
                        class="w-full flex items-center justify-between px-6 py-3.5 text-sm md:text-[15px] transition text-left hover:text-[#e9ecef] hover:bg-slate-800/30 cursor-pointer"
                        :class="openMenus['pasien'] ? 'text-[#e9ecef] font-semibold' : ''">
                    <div class="flex items-center space-x-3.5">
                        <svg class="w-5 h-5 text-[#889097]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span>Pasien & Antrean</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="openMenus['pasien'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <!-- LEVEL 2 CONTAINER -->
                <div x-show="openMenus['pasien']" x-transition class="bg-[#1b2531]/70 border-l-2 border-[#3b7ddd]/40 ml-5 pl-2 space-y-1 py-1" style="display: none;">
                    
                    @can('manage_registrations')
                    <!-- LEVEL 2 ITEM A: Pendaftaran Online -->
                    <div>
                        <button type="button" @click="toggle('antrean')" 
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                                :class="openMenus['antrean'] ? 'text-white font-bold' : 'text-[#adb5bd]'">
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                <span>Pendaftaran Online</span>
                            </span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openMenus['antrean'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        <!-- LEVEL 3 ITEMS FOR PENDAFTARAN -->
                        <div x-show="openMenus['antrean']" x-transition class="pl-7 pr-3 py-1.5 space-y-2 text-sm" style="display: none;">
                            <a href="{{ route('admin.registrations.index') }}" class="block text-slate-300 font-medium hover:text-white transition py-0.5">• Daftar Antrean Masuk</a>
                            <a href="{{ route('admin.registrations.index') }}?status=pending" class="block text-amber-300 hover:text-white transition py-0.5">• Antrean Menunggu Konfirmasi</a>
                            <a href="{{ route('admin.registrations.index') }}?status=confirmed" class="block text-emerald-300 hover:text-white transition py-0.5">• Antrean Terverifikasi</a>
                        </div>
                    </div>
                    @endcan

                    @can('manage_complaints')
                    <!-- LEVEL 2 ITEM B: Pengaduan & Aduan Pasien -->
                    <div>
                        <button type="button" @click="toggle('aduan')" 
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                                :class="openMenus['aduan'] ? 'text-white font-bold' : 'text-[#adb5bd]'">
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                                <span>Aduan & Saran</span>
                            </span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openMenus['aduan'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        <!-- LEVEL 3 ITEMS FOR ADUAN -->
                        <div x-show="openMenus['aduan']" x-transition class="pl-7 pr-3 py-1.5 space-y-2 text-sm" style="display: none;">
                            <a href="{{ route('admin.complaints.index') }}" class="block text-slate-300 font-medium hover:text-white transition py-0.5">• Semua Aduan Pasien</a>
                            <a href="{{ route('admin.complaints.index') }}?status=new" class="block text-rose-300 hover:text-white transition py-0.5">• Tiket Aduan Baru</a>
                            <a href="{{ route('admin.complaints.index') }}?status=in_progress" class="block text-yellow-300 hover:text-white transition py-0.5">• Aduan Sedang Diproses</a>
                            <a href="{{ route('admin.complaints.index') }}?status=resolved" class="block text-emerald-300 hover:text-white transition py-0.5">• Aduan Selesai / Arsip</a>
                        </div>
                    </div>
                    @endcan

                </div>
            </div>
            @endcanany

            <!-- Group 3: Informasi & Publikasi -->
            @canany(['manage_posts', 'manage_banners', 'manage_pages', 'manage_settings'])
                <div class="px-6 pt-5 pb-2 text-xs font-bold text-[#889097] uppercase tracking-wider">
                    Informasi & Konten
                </div>
            @endcanany

            {{-- 3-LEVEL DROPDOWN 3A: Berita & Banner --}}
            @canany(['manage_posts', 'manage_banners'])
            <div>
                {{-- LEVEL 1 BUTTON: BERITA & BANNER --}}
                <button
                    type="button"
                    @click="toggle('ppid')"
                    class="w-full flex items-center justify-between px-6 py-3.5 text-sm md:text-[15px] transition text-left hover:text-[#e9ecef] hover:bg-slate-800/30 cursor-pointer"
                    :class="openMenus['ppid'] ? 'text-[#e9ecef] font-semibold' : ''"
                >
                    <div class="flex items-center space-x-3.5">
                        <svg class="w-5 h-5 text-[#889097]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <span>Berita & Banner</span>
                    </div>

                    <svg
                        class="w-4 h-4 transition-transform duration-200"
                        :class="openMenus['ppid'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                {{-- LEVEL 2 CONTAINER --}}
                <div
                    x-show="openMenus['ppid']"
                    x-transition
                    class="bg-[#1b2531]/70 border-l-2 border-[#3b7ddd]/40 ml-5 pl-2 space-y-1 py-1"
                    style="display: none;"
                >

                    {{-- ITEM A: BERITA & EDUKASI --}}
                    @can('manage_posts')
                    <div>
                        <button
                            type="button"
                            @click="toggle('publikasi')"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                            :class="openMenus['publikasi'] ? 'text-white font-bold' : 'text-[#adb5bd]'"
                        >
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span>Berita & Edukasi</span>
                            </span>

                            <svg
                                class="w-3.5 h-3.5 transition-transform duration-200"
                                :class="openMenus['publikasi'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        <div
                            x-show="openMenus['publikasi']"
                            x-transition
                            class="pl-7 pr-3 py-1.5 space-y-2 text-sm"
                            style="display: none;"
                        >
                            <a href="{{ route('admin.posts.index') }}" class="block {{ request()->routeIs('admin.posts.index') && !request('category') ? 'text-cyan-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5">
                                • Daftar Artikel & Berita
                            </a>

                            <a href="{{ route('admin.posts.index') }}?category=pengumuman" class="block {{ request('category') === 'pengumuman' ? 'text-cyan-300 font-bold' : 'text-slate-400' }} hover:text-white transition py-0.5">
                                • Maklumat & Pengumuman
                            </a>

                            <a href="{{ route('admin.posts.create') }}" class="block text-emerald-300 font-semibold hover:text-white transition py-0.5">
                                + Tulis Berita Baru
                            </a>
                        </div>
                    </div>
                    @endcan

                    {{-- ITEM B: BANNER & PROMOSI --}}
                    @can('manage_banners')
                    <div>
                        <button
                            type="button"
                            @click="toggle('info_publik')"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                            :class="openMenus['info_publik'] ? 'text-white font-bold' : 'text-[#adb5bd]'"
                        >
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-indigo-400"></span>
                                <span>Banner & Promosi</span>
                            </span>

                            <svg
                                class="w-3.5 h-3.5 transition-transform duration-200"
                                :class="openMenus['info_publik'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        <div
                            x-show="openMenus['info_publik']"
                            x-transition
                            class="pl-7 pr-3 py-1.5 space-y-2 text-sm"
                            style="display: none;"
                        >
                            <a href="{{ route('admin.banners.index') }}" class="block {{ request()->routeIs('admin.banners.index') ? 'text-cyan-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5">
                                • Slider Beranda Utama
                            </a>

                            <a href="{{ route('admin.banners.create') }}" class="block text-indigo-300 font-semibold hover:text-white transition py-0.5">
                                + Tambah Banner Baru
                            </a>
                        </div>
                    </div>
                    @endcan

                </div>
            </div>
            @endcanany

            {{-- 3-LEVEL DROPDOWN 3B: Halaman & Navigasi CMS --}}
            @canany(['manage_pages', 'manage_settings'])
            <div>
                {{-- LEVEL 1 BUTTON: HALAMAN & NAVIGASI CMS --}}
                <button
                    type="button"
                    @click="toggle('cms_menu')"
                    class="w-full flex items-center justify-between px-6 py-3.5 text-sm md:text-[15px] transition text-left hover:text-[#e9ecef] hover:bg-slate-800/30 cursor-pointer"
                    :class="openMenus['cms_menu'] ? 'text-[#e9ecef] font-semibold' : ''"
                >
                    <div class="flex items-center space-x-3.5">
                        <svg class="w-5 h-5 text-[#889097]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                        </svg>
                        <span>Halaman & Navigasi CMS</span>
                    </div>

                    <svg
                        class="w-4 h-4 transition-transform duration-200"
                        :class="openMenus['cms_menu'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                {{-- LEVEL 2 CONTAINER --}}
                <div
                    x-show="openMenus['cms_menu']"
                    x-transition
                    class="bg-[#1b2531]/70 border-l-2 border-[#3b7ddd]/40 ml-5 pl-2 space-y-1 py-1"
                    style="display: none;"
                >
                    {{-- ITEM A: HALAMAN (PAGES) --}}
                    @can('manage_pages')
                    <div>
                        <button
                            type="button"
                            @click="toggle('cms_pages')"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                            :class="openMenus['cms_pages'] ? 'text-white font-bold' : 'text-[#adb5bd]'"
                        >
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                                <span>Halaman (Pages)</span>
                            </span>

                            <svg
                                class="w-3.5 h-3.5 transition-transform duration-200"
                                :class="openMenus['cms_pages'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        <div
                            x-show="openMenus['cms_pages']"
                            x-transition
                            class="pl-7 pr-3 py-1.5 space-y-2 text-sm"
                            style="display: none;"
                        >
                            <a
                                href="{{ route('admin.pages.index', ['tab' => 'pages']) }}"
                                class="block {{ request()->routeIs('admin.pages.*') && request('tab', 'pages') === 'pages' ? 'text-cyan-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5"
                            >
                                • Daftar Halaman (Pages)
                            </a>

                            <a
                                href="{{ route('admin.pages.create') }}"
                                class="block text-cyan-300 font-semibold hover:text-white transition py-0.5"
                            >
                                + Tambah Halaman Baru
                            </a>
                        </div>
                    </div>
                    @endcan

                    {{-- ITEM B: TAB & REFERENSI MENU --}}
                    @can('manage_settings')
                    <div>
                        <button
                            type="button"
                            @click="toggle('cms_tabs')"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                            :class="openMenus['cms_tabs'] ? 'text-white font-bold' : 'text-[#adb5bd]'"
                        >
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-sky-400"></span>
                                <span>Tab & Referensi Menu</span>
                            </span>

                            <svg
                                class="w-3.5 h-3.5 transition-transform duration-200"
                                :class="openMenus['cms_tabs'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        <div
                            x-show="openMenus['cms_tabs']"
                            x-transition
                            class="pl-7 pr-3 py-1.5 space-y-2 text-sm"
                            style="display: none;"
                        >
                            <a
                                href="{{ route('admin.tab-references.index') }}"
                                class="block {{ request()->routeIs('admin.tab-references.*') ? 'text-cyan-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5"
                            >
                                • Kelola Tab & Referensi
                            </a>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
            @endcanany

            {{-- DROPDOWN 3C: Layanan PPID --}}
            @can('manage_pages')
            <div>
                {{-- LEVEL 1 BUTTON: LAYANAN PPID --}}
                <button
                    type="button"
                    @click="toggle('menu_ppid')"
                    class="w-full flex items-center justify-between px-6 py-3.5 text-sm md:text-[15px] transition text-left hover:text-[#e9ecef] hover:bg-slate-800/30 cursor-pointer"
                    :class="openMenus['menu_ppid'] ? 'text-[#e9ecef] font-semibold' : ''"
                >
                    <div class="flex items-center space-x-3.5">
                        <svg class="w-5 h-5 text-[#889097]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Layanan PPID</span>
                    </div>

                    <svg
                        class="w-4 h-4 transition-transform duration-200"
                        :class="openMenus['menu_ppid'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                {{-- LEVEL 2 CONTAINER LAYANAN PPID --}}
                <div
                    x-show="openMenus['menu_ppid']"
                    x-transition
                    class="bg-[#1b2531]/70 border-l-2 border-[#3b7ddd]/40 ml-5 pl-2 space-y-1 py-1"
                    style="display: none;"
                >
                    {{-- PARENT A: INFORMASI PUBLIK --}}
                    <div>
                        <button
                            type="button"
                            @click="toggle('ppid_info_publik')"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                            :class="openMenus['ppid_info_publik'] ? 'text-white font-bold' : 'text-[#adb5bd]'"
                        >
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                                <span>Informasi Publik</span>
                            </span>

                            <svg
                                class="w-3.5 h-3.5 transition-transform duration-200"
                                :class="openMenus['ppid_info_publik'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        <div
                            x-show="openMenus['ppid_info_publik']"
                            x-transition
                            class="pl-7 pr-3 py-1.5 space-y-2 text-sm"
                            style="display: none;"
                        >
                            <a
                                href="{{ route('admin.pages.index', ['tab' => 'sections']) }}"
                                class="block {{ (request()->routeIs('admin.pages.index') && request('tab') === 'sections') || request()->routeIs('admin.page-sections.*') ? 'text-cyan-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5"
                            >
                                • Section Halaman Informasi Publik
                            </a>

                            <a
                                href="{{ route('admin.ppid-documents.index') }}"
                                class="block {{ request()->routeIs('admin.ppid-documents.*') || (request()->routeIs('admin.pages.index') && request('tab') === 'documents') ? 'text-cyan-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5"
                            >
                                • Dokumen PPID
                            </a>
                        </div>
                    </div>

                    {{-- PARENT B: PERMOHONAN INFORMASI --}}
                    <div>
                        <button
                            type="button"
                            @click="toggle('ppid_permohonan_menu')"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                            :class="openMenus['ppid_permohonan_menu'] ? 'text-white font-bold' : 'text-[#adb5bd]'"
                        >
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                <span>Permohonan Informasi</span>
                            </span>

                            <svg
                                class="w-3.5 h-3.5 transition-transform duration-200"
                                :class="openMenus['ppid_permohonan_menu'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        <div
                            x-show="openMenus['ppid_permohonan_menu']"
                            x-transition
                            class="pl-7 pr-3 py-1.5 space-y-2 text-sm"
                            style="display: none;"
                        >
                            <a
                                href="{{ route('admin.ppid.information.index') }}"
                                class="block {{ request()->routeIs('admin.ppid.information.*') ? 'text-cyan-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5"
                            >
                                • Permohonan Informasi
                            </a>

                            <a
                                href="{{ route('admin.ppid.objections.index') }}"
                                class="block {{ request()->routeIs('admin.ppid.objections.*') ? 'text-cyan-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5"
                            >
                                • Pengajuan Keberatan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endcan

            {{-- 3-LEVEL DROPDOWN 3D: Pendidikan & Pelatihan (Diklat) --}}
            @can('manage_pages')
            <div>
                {{-- LEVEL 1 BUTTON: PENDIDIKAN & PELATIHAN (DIKLAT) --}}
                <button
                    type="button"
                    @click="toggle('menu_diklat')"
                    class="w-full flex items-center justify-between px-6 py-3.5 text-sm md:text-[15px] transition text-left hover:text-[#e9ecef] hover:bg-slate-800/30 cursor-pointer"
                    :class="openMenus['menu_diklat'] ? 'text-[#e9ecef] font-semibold' : ''"
                >
                    <div class="flex items-center space-x-3.5">
                        <svg class="w-5 h-5 text-[#889097]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                        </svg>
                        <span>Pendidikan & Pelatihan</span>
                    </div>

                    <svg
                        class="w-4 h-4 transition-transform duration-200"
                        :class="openMenus['menu_diklat'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                {{-- LEVEL 2 CONTAINER --}}
                <div
                    x-show="openMenus['menu_diklat']"
                    x-transition
                    class="bg-[#1b2531]/70 border-l-2 border-[#3b7ddd]/40 ml-5 pl-2 space-y-1 py-1"
                    style="display: none;"
                >
                    {{-- SUBMENU A: PENDAFTARAN DIKLAT --}}
                    <div>
                        <button
                            type="button"
                            @click="toggle('diklat_pendaftaran')"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                            :class="openMenus['diklat_pendaftaran'] ? 'text-white font-bold' : 'text-[#adb5bd]'"
                        >
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-teal-400"></span>
                                <span>Pendaftaran Diklat</span>
                            </span>

                            <svg
                                class="w-3.5 h-3.5 transition-transform duration-200"
                                :class="openMenus['diklat_pendaftaran'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        <div
                            x-show="openMenus['diklat_pendaftaran']"
                            x-transition
                            class="pl-7 pr-3 py-1.5 space-y-2 text-sm"
                            style="display: none;"
                        >
                            <a
                                href="{{ route('admin.diklat.registrations.education.index') }}"
                                class="block {{ request()->routeIs('admin.diklat.registrations.education.*') ? 'text-cyan-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5"
                            >
                                • Pendaftaran Pendidikan
                            </a>

                            <a
                                href="{{ route('admin.diklat.registrations.training.index') }}"
                                class="block {{ request()->routeIs('admin.diklat.registrations.training.*') ? 'text-cyan-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5"
                            >
                                • Pendaftaran Pelatihan
                            </a>
                        </div>
                    </div>

                    {{-- SUBMENU B: ABSENSI PELATIHAN --}}
                    <div>
                        <button
                            type="button"
                            @click="toggle('diklat_absensi')"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                            :class="openMenus['diklat_absensi'] ? 'text-white font-bold' : 'text-[#adb5bd]'"
                        >
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span>Absensi Pelatihan</span>
                            </span>

                            <svg
                                class="w-3.5 h-3.5 transition-transform duration-200"
                                :class="openMenus['diklat_absensi'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        <div
                            x-show="openMenus['diklat_absensi']"
                            x-transition
                            class="pl-7 pr-3 py-1.5 space-y-2 text-sm"
                            style="display: none;"
                        >
                            <a
                                href="{{ route('admin.diklat.attendances.index') }}"
                                class="block {{ request()->routeIs('admin.diklat.attendances.*') ? 'text-cyan-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5"
                            >
                                • Rekap Absensi Pelatihan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endcan


            <!-- Group 4: Master & Pengaturan -->
            @canany(['manage_settings', 'manage_users', 'manage_doctors'])
                <div class="px-6 pt-5 pb-2 text-xs font-bold text-[#889097] uppercase tracking-wider">
                    Master & Pengaturan
                </div>
            @endcanany

            <!-- 3-LEVEL DROPDOWN 4: Pengaturan & Sistem -->
            @canany(['manage_settings', 'manage_users', 'manage_doctors'])
            <div>
                <!-- LEVEL 1 BUTTON -->
                <button type="button" @click="toggle('pengaturan')" 
                        class="w-full flex items-center justify-between px-6 py-3.5 text-sm md:text-[15px] transition text-left hover:text-[#e9ecef] hover:bg-slate-800/30 cursor-pointer"
                        :class="openMenus['pengaturan'] ? 'text-[#e9ecef] font-semibold' : ''">
                    <div class="flex items-center space-x-3.5">
                        <svg class="w-5 h-5 text-[#889097]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Master & Sistem</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="openMenus['pengaturan'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <!-- LEVEL 2 CONTAINER -->
                <div x-show="openMenus['pengaturan']" x-transition class="bg-[#1b2531]/70 border-l-2 border-[#3b7ddd]/40 ml-5 pl-2 space-y-1 py-1" style="display: none;">
                    
                    @can('manage_settings')
                    <!-- LEVEL 2 ITEM: Modul & Navigasi -->
                    <div>
                        <button type="button" @click="toggle('modul_nav')" 
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                                :class="openMenus['modul_nav'] ? 'text-white font-bold' : 'text-[#adb5bd]'">
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                                <span>Modul & Navigasi</span>
                            </span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openMenus['modul_nav'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        <!-- LEVEL 3 ITEMS FOR MODUL & NAVIGASI -->
                        <div x-show="openMenus['modul_nav']" x-transition class="pl-7 pr-3 py-1.5 space-y-2 text-sm" style="display: none;">
                            <a href="{{ route('admin.modules.index') }}" class="block {{ request()->routeIs('admin.modules*') ? 'text-cyan-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5">• Pengelolaan Modul</a>
                            <a href="{{ route('admin.menus.index') }}" class="block {{ request()->routeIs('admin.menus*') ? 'text-cyan-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5">• Pengelolaan Menu (Navigasi)</a>
                        </div>
                    </div>
                    @endcan

                    @canany(['manage_doctors', 'manage_banners'])
                    <!-- LEVEL 2 ITEM A: Master Data RS -->
                    <div>
                        <button type="button" @click="toggle('master_medis')" 
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                                :class="openMenus['master_medis'] ? 'text-white font-bold' : 'text-[#adb5bd]'">
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                                <span>Master Data RS</span>
                            </span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openMenus['master_medis'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        <!-- LEVEL 3 ITEMS FOR MASTER DATA -->
                        <div x-show="openMenus['master_medis']" x-transition class="pl-7 pr-3 py-1.5 space-y-2 text-sm" style="display: none;">
                            @can('manage_doctors')
                                <a href="{{ route('admin.doctors.index') }}" class="block text-slate-300 font-medium hover:text-white transition py-0.5">• Dokter Spesialis & Poli</a>
                            @endcan
                            @can('manage_banners')
                                <a href="{{ route('admin.banners.index') }}" class="block text-slate-400 hover:text-white transition py-0.5">• Banner & Slider Beranda</a>
                            @endcan
                        </div>
                    </div>
                    @endcanany

                    @can('manage_settings')
                    <!-- LEVEL 2 ITEM B: Pengaturan Website & Profil -->
                    <div>
                        <button type="button" @click="toggle('sistem')" 
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                                :class="openMenus['sistem'] ? 'text-white font-bold' : 'text-[#adb5bd]'">
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                <span>Pengaturan Sistem</span>
                            </span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openMenus['sistem'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        <!-- LEVEL 3 ITEMS FOR PENGATURAN -->
                        <div x-show="openMenus['sistem']" x-transition class="pl-7 pr-3 py-1.5 space-y-2 text-sm" style="display: none;">
                            <a href="{{ route('admin.settings.index') }}" class="block text-slate-300 font-medium hover:text-white transition py-0.5">• Identitas & Profil Website</a>
                            <a href="{{ route('admin.settings.index') }}#kontak" class="block text-slate-400 hover:text-white transition py-0.5">• Kontak & Peta Lokasi RS</a>
                            <a href="{{ route('admin.settings.index') }}#sosmed" class="block text-slate-400 hover:text-white transition py-0.5">• Media Sosial Resmi</a>
                        </div>
                    </div>
                    @endcan

                    @can('manage_users')
                    <!-- LEVEL 2 ITEM C: Hak Akses & Peran (RBAC) -->
                    <div>
                        <button type="button" @click="toggle('rbac')" 
                                class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm hover:text-white transition text-left cursor-pointer"
                                :class="openMenus['rbac'] ? 'text-white font-bold' : 'text-[#adb5bd]'">
                            <span class="flex items-center space-x-2.5">
                                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                <span>Hak Akses & Role</span>
                            </span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="openMenus['rbac'] ? 'rotate-90 text-[#3b7ddd]' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        <!-- LEVEL 3 ITEMS FOR RBAC -->
                        <div x-show="openMenus['rbac']" x-transition class="pl-7 pr-3 py-1.5 space-y-2 text-sm" style="display: none;">
                            <a href="{{ route('admin.users.index') }}" class="block {{ request()->routeIs('admin.users*') ? 'text-amber-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5">• Manajemen Petugas & Admin</a>
                            <a href="{{ route('admin.roles.index') }}" class="block {{ request()->routeIs('admin.roles*') ? 'text-amber-300 font-bold' : 'text-slate-300 font-medium' }} hover:text-white transition py-0.5">• Peran & Hak Akses (RBAC)</a>
                            <a href="{{ route('admin.users.create') }}" class="block text-amber-300 font-semibold hover:text-white transition py-0.5">+ Tambah Pengguna Baru</a>
                        </div>
                    </div>
                    @endcan

                </div>
            </div>
            @endcanany

        </nav>

        <!-- Sidebar Footer Status -->
        <div class="p-4 border-t border-slate-800/80 bg-[#1e2936]/60">
            <div class="flex items-center space-x-2 text-xs text-slate-400">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="font-medium text-slate-300">Server SIMRS Online</span>
            </div>
            <div class="mt-1 text-[11px] text-slate-400">
                RBAC: <span class="text-amber-400 font-semibold">{{ auth()->user()->roles->first()->label ?? 'Super Administrator' }}</span>
            </div>
        </div>

    </div>
</aside>
