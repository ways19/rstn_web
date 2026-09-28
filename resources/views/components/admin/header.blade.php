<!-- AdminKit Top Header Component -->
<header class="h-20 bg-white dark:bg-slate-900 border-b border-slate-200/80 dark:border-slate-800 px-6 flex items-center justify-between sticky top-0 z-30 shadow-[0_2px_12px_rgba(0,0,0,0.04)] transition-colors duration-200">
    <!-- Left: Hamburger, Badge CMS Topbar, & Search Box -->
    <div class="flex items-center space-x-3 sm:space-x-4">
        <button type="button" @click="toggleSidebar()" class="p-2.5 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition focus:outline-none cursor-pointer" aria-label="Toggle Sidebar" title="Sembunyikan / Tampilkan Sidebar">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        
        <!-- Badge CMS di Topbar -->
        <div class="inline-flex items-center space-x-2 px-3 py-1.5 bg-blue-50 dark:bg-blue-950/50 border border-blue-200/70 dark:border-blue-800/60 rounded-full shadow-xs">
            <span class="w-2 h-2 rounded-full bg-[#3b7ddd] animate-pulse"></span>
            <span class="text-xs font-extrabold text-[#3b7ddd] tracking-wider uppercase">CMS Panel</span>
        </div>

        <div class="relative hidden md:block">
            <input type="text" placeholder="Cari modul, layanan, atau data..." class="bg-[#f5f7fb] dark:bg-slate-800 text-sm text-slate-700 dark:text-slate-200 rounded-full pl-10 pr-4 py-2 border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/30 w-56 lg:w-72 transition">
            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>

    <!-- Right: Theme Switcher, Notifications, Web Link, User Profile -->
    <div class="flex items-center space-x-3 sm:space-x-4">
        <!-- Theme Toggle Button -->
        <x-theme-toggle size="md" />

        <!-- Link Web Publik -->
        <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center space-x-2 text-sm font-semibold text-[#3b7ddd] hover:text-[#2b65b6] px-3.5 py-2 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-950/40 transition border border-blue-100 dark:border-blue-900/60">
            <span>Lihat Web Publik</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
        </a>

        <!-- Notification Bell -->
        <div class="relative">
            <button type="button" class="p-2.5 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition relative cursor-pointer" aria-label="Notifikasi">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-emerald-500 rounded-full ring-2 ring-white dark:ring-slate-900"></span>
            </button>
        </div>

        <!-- User Dropdown (AdminKit Avatar & Name) -->
        <div class="relative" @click.away="userDropdownOpen = false">
            <button type="button" @click="userDropdownOpen = !userDropdownOpen" class="flex items-center space-x-3 p-1 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 focus:outline-none cursor-pointer transition">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#3b7ddd] to-[#1cbb8c] text-white flex items-center justify-center font-bold text-sm uppercase shadow-sm">
                    {{ substr(auth()->user()->name ?? 'A', 0, 2) }}
                </div>
                <div class="hidden md:block text-left">
                    <span class="text-sm font-bold text-slate-800 dark:text-white block leading-tight">{{ auth()->user()->name ?? 'Administrator' }}</span>
                    <span class="text-xs text-[#3b7ddd] font-semibold block">{{ auth()->user()->roles->first()->label ?? 'Petugas' }}</span>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="userDropdownOpen" x-transition class="absolute right-0 mt-2 w-64 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800 py-2.5 z-50 text-sm text-slate-700 dark:text-slate-200" style="display: none;">
                <div class="px-5 py-3 border-b border-slate-100 dark:border-slate-800">
                    <p class="font-bold text-slate-900 dark:text-white text-sm">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ auth()->user()->email ?? 'admin@rstjokronegoro.id' }}</p>
                    <div class="mt-2">
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-950/60 text-[#3b7ddd] border border-blue-100 dark:border-blue-900/60">
                            {{ auth()->user()->roles->first()->label ?? 'Superadmin' }}
                        </span>
                    </div>
                </div>

                @can('manage_users')
                    <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-5 py-2.5 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 transition font-medium">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span>Manajemen Petugas</span>
                    </a>
                    <a href="{{ route('admin.roles.index') }}" class="flex items-center space-x-3 px-5 py-2.5 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 transition font-medium">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span>Hak Akses & Role (RBAC)</span>
                    </a>
                @endcan

                <div class="border-t border-slate-100 dark:border-slate-800 my-1"></div>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-5 py-2.5 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition text-left font-semibold cursor-pointer">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Keluar (Logout)</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
