<!-- Main Navigation Header (Public) styled like RSCM -->
<header class="sticky top-0 z-50 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md shadow-xs border-b border-slate-100 dark:border-slate-800 transition-colors duration-200">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Left: Hospital Logo & Brand Title (Clean Horizontal Layout) -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group flex-shrink-0">
                <img src="{{ asset('logo.png') }}" alt="Logo RSUD R.A.A. Tjokronegoro" class="h-10 sm:h-11 w-auto object-contain transition-transform group-hover:scale-105 flex-shrink-0" onerror="this.src='https://ui-avatars.com/api/?name=RSTN&background=0e9384&color=fff'">
                <div class="flex flex-col justify-center">
                    <span class="font-bold text-[#0e9384] dark:text-teal-400 text-[14px] sm:text-[15px] tracking-tight leading-tight whitespace-nowrap group-hover:text-teal-700 dark:group-hover:text-teal-300 transition">
                        RSUD R.A.A. Tjokronegoro
                    </span>
                    <span class="font-bold text-slate-500 dark:text-slate-400 text-[9.5px] sm:text-[10px] tracking-wider uppercase leading-tight whitespace-nowrap mt-0.5">
                        KABUPATEN PURWOREJO
                    </span>
                </div>
            </a>

            @php
                $pubNavItems = \App\Models\Menu::where('location', 'public')
                    ->whereNull('parent_id')
                    ->where('is_active', true)
                    ->with(['activeChildren'])
                    ->orderBy('order')
                    ->get();
            @endphp

            <!-- Right Group: Navigation Links, Search Capsule, Divider & CTA Button (Aligned like RSCM) -->
            <div class="hidden lg:flex items-center space-x-4 xl:space-x-5 flex-shrink-0">
                <!-- Navigation Menus -->
                <nav class="flex items-center space-x-4 xl:space-x-6 text-[13px] xl:text-sm font-medium text-slate-700 dark:text-slate-200">
                    @foreach($pubNavItems as $navItem)
                        @if($navItem->activeChildren->count() > 0)
                            <div class="relative py-2" x-data="{ open: false }" @click.away="open = false" @mouseenter="open = true" @mouseleave="open = false">
                                <button type="button" @click="open = !open"
                                        class="flex items-center space-x-1 py-1 transition cursor-pointer {{ $navItem->isActiveRoute() ? 'text-[#0e9384] dark:text-teal-400 font-semibold' : 'hover:text-[#0e9384] dark:hover:text-teal-400' }}">
                                    <span>{{ $navItem->title }}</span>
                                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180 text-[#0e9384] dark:text-teal-400' : 'text-slate-400 dark:text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-2"
                                     class="absolute left-0 mt-1 w-max min-w-56 bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-100 dark:border-slate-800 py-2 z-50 text-sm font-medium"
                                     style="display: none;">
                                    @foreach($navItem->activeChildren as $child)
                                        <a href="{{ $child->link }}" target="{{ $child->target }}" class="block whitespace-nowrap px-4 py-2 text-slate-700 dark:text-slate-200 hover:text-[#0e9384] dark:hover:text-teal-400 hover:bg-teal-50/70 dark:hover:bg-slate-800/70 transition">
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $navItem->link }}" target="{{ $navItem->target }}"
                               class="py-1 transition {{ $navItem->isActiveRoute() ? 'text-[#0e9384] dark:text-teal-400 font-semibold' : 'hover:text-[#0e9384] dark:hover:text-teal-400' }}">
                                {{ $navItem->title }}
                            </a>
                        @endif
                    @endforeach
                </nav>

                <!-- Interactive Search Trigger (Icon first, click to reveal input) -->
                <div x-data="{ searchOpen: false }" class="relative flex items-center" @click.away="searchOpen = false">
                    <form action="{{ route('news') }}" method="GET" class="flex items-center">
                        <div class="relative flex items-center">
                            <!-- Toggle Button (Magnifying Glass Icon) -->
                            <button type="button" 
                                    x-show="!searchOpen"
                                    @click="searchOpen = true; $nextTick(() => $refs.searchInput.focus())"
                                    class="p-2 rounded-lg text-slate-600 hover:text-[#0e9384] dark:text-slate-300 dark:hover:text-teal-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition cursor-pointer"
                                    title="Cari"
                                    aria-label="Buka Pencarian">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>

                            <!-- Expanding Text Input Field -->
                            <div x-show="searchOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="relative flex items-center"
                                 style="display: none;">
                                <input x-ref="searchInput"
                                       type="text" 
                                       name="q" 
                                       placeholder="Cari..." 
                                       class="w-40 xl:w-48 pl-3 pr-14 py-1.5 text-xs rounded-md bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-1 focus:ring-[#0e9384] shadow-xs transition-all"
                                       @keydown.escape="searchOpen = false">
                                
                                <div class="absolute right-1.5 flex items-center space-x-1">
                                    <button type="submit" class="p-1 text-slate-400 hover:text-[#0e9384] transition" title="Cari">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </button>
                                    <button type="button" @click="searchOpen = false" class="p-1 text-slate-400 hover:text-rose-500 transition" title="Tutup">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Vertical Divider Line -->
                <div class="h-4 w-px bg-slate-300 dark:bg-slate-700"></div>

                <!-- CTA Button: Pendaftaran Online (RSCM Solid Teal Button) -->
                <a href="{{ route('registration') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-xs font-semibold text-white bg-[#0e9384] hover:bg-[#0b7a6d] shadow-xs transition whitespace-nowrap">
                    <span>Pendaftaran Online</span>
                </a>

                <!-- Theme Toggle Button -->
                <x-theme-toggle size="sm" />
            </div>

            <!-- Mobile Actions (Theme Toggle, Daftar, Hamburger) -->
            <div class="flex items-center space-x-2 lg:hidden">
                <x-theme-toggle size="sm" />

                <a href="{{ route('registration') }}" class="px-3 py-1.5 text-xs font-semibold text-white bg-[#0e9384] rounded-lg shadow-sm">
                    Daftar
                </a>
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="p-2 rounded-lg text-slate-700 dark:text-slate-200 hover:text-[#0e9384] dark:hover:text-teal-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 cursor-pointer" aria-label="Buka Menu Navigasi">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Navigation (Alpine.js Transition) -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xl px-4 pt-3 pb-6 space-y-3"
         style="display: none;"
         @click.away="mobileMenuOpen = false">
        
        <!-- Mobile Search Bar -->
        <form action="{{ route('news') }}" method="GET" class="relative pb-2">
            <input type="text" name="q" placeholder="Cari dokter, layanan, berita..." 
                   class="w-full pl-4 pr-10 py-2.5 text-xs rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-1 focus:ring-[#0e9384]">
            <button type="submit" class="absolute right-3 top-2.5 text-slate-400 hover:text-[#0e9384]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>

        <div class="flex flex-col space-y-1 font-medium text-slate-700 dark:text-slate-200 text-sm">
            @foreach($pubNavItems as $navItem)
                @if($navItem->activeChildren->count() > 0)
                    <div x-data="{ open: false }" class="border-b border-slate-100 dark:border-slate-800 pb-1">
                        <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 text-left font-semibold">
                            <span>{{ $navItem->title }}</span>
                            <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180 text-[#0e9384] dark:text-teal-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" class="pl-4 space-y-1 py-1" style="display: none;">
                            @foreach($navItem->activeChildren as $child)
                                <a href="{{ $child->link }}" target="{{ $child->target }}" class="block px-3 py-1.5 text-xs text-slate-600 dark:text-slate-300 hover:text-[#0e9384] dark:hover:text-teal-400 transition">
                                    • {{ $child->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $navItem->link }}" target="{{ $navItem->target }}" class="px-3 py-2.5 rounded-xl {{ $navItem->isActiveRoute() ? 'bg-teal-50 dark:bg-teal-950/60 text-[#0e9384] dark:text-teal-300 font-semibold' : 'hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        {{ $navItem->title }}
                    </a>
                @endif
            @endforeach
        </div>

        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-col space-y-2">
            <a href="{{ route('registration') }}" class="w-full text-center py-3 rounded-xl font-bold text-white bg-[#0e9384] hover:bg-[#0b7a6d] shadow-sm transition text-sm">
                Pendaftaran Online Pasien
            </a>
            <a href="https://wa.me/628112521118" target="_blank" rel="noopener" class="w-full text-center py-2.5 rounded-xl font-semibold text-teal-800 dark:text-teal-300 bg-teal-50 dark:bg-teal-950/50 hover:bg-teal-100 dark:hover:bg-teal-900/50 border border-teal-200 dark:border-teal-800 transition text-xs sm:text-sm">
                WhatsApp Hotline: 0811-2521-118
            </a>
        </div>
    </div>
</header>
