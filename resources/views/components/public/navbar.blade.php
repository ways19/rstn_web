<!-- Main Navigation Header (Public) -->
<header class="sticky top-0 z-50 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md shadow-sm border-b border-slate-100 dark:border-slate-800 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Hospital Logo & Brand Title (2 Baris Ringkas & Proporsional Sesuai Gambar) -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2.5 group flex-shrink-0">
                <img src="{{ asset('logo.png') }}" alt="Logo RSUD R.A.A. Tjokronegoro" class="h-9 sm:h-10 w-auto object-contain transition-transform group-hover:scale-105 flex-shrink-0" onerror="this.src='https://ui-avatars.com/api/?name=RSTN&background=007B83&color=fff'">
                <div class="flex flex-col justify-center">
                    <span class="font-extrabold text-[#00656e] dark:text-teal-400 text-[13.5px] sm:text-[14.5px] tracking-tight leading-tight whitespace-nowrap group-hover:text-teal-700 dark:group-hover:text-teal-300 transition">
                        RSUD R.A.A. Tjokronegoro
                    </span>
                    <span class="font-bold text-slate-500 dark:text-slate-400 text-[9.5px] sm:text-[10px] tracking-wider uppercase leading-tight whitespace-nowrap">
                        KABUPATEN PURWOREJO
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Menu (Dynamic from Database Menu Management) -->
            @php
                $pubNavItems = \App\Models\Menu::where('location', 'public')
                    ->whereNull('parent_id')
                    ->where('is_active', true)
                    ->with(['activeChildren'])
                    ->orderBy('order')
                    ->get();
            @endphp
            <nav class="hidden lg:flex items-center space-x-6 font-semibold text-slate-700 dark:text-slate-200 text-sm">
                @foreach($pubNavItems as $navItem)
                    @if($navItem->activeChildren->count() > 0)
                        <div class="relative" x-data="{ open: false }" @click.away="open = false" @mouseenter="open = true" @mouseleave="open = false">
                            <button type="button" @click="open = !open"
                                    class="flex items-center space-x-1 py-2 transition {{ $navItem->isActiveRoute() ? 'text-blue-600 dark:text-blue-400 font-bold' : 'hover:text-blue-600 dark:hover:text-blue-400' }}">
                                <span>{{ $navItem->title }}</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180 text-blue-600 dark:text-blue-400' : 'text-slate-400 dark:text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-2"
                                 class="absolute left-0 mt-1 w-64 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800 py-2.5 z-50 text-sm font-medium"
                                 style="display: none;">
                                @foreach($navItem->activeChildren as $child)
                                    <a href="{{ $child->link }}" target="{{ $child->target }}" class="block px-4 py-2 text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50/70 dark:hover:bg-slate-800 transition">
                                        {{ $child->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $navItem->link }}" target="{{ $navItem->target }}"
                           class="py-2 transition {{ $navItem->isActiveRoute() ? 'text-blue-600 dark:text-blue-400 font-bold' : 'hover:text-blue-600 dark:hover:text-blue-400' }}">
                            {{ $navItem->title }}
                        </a>
                    @endif
                @endforeach
            </nav>

            <!-- Desktop Action Buttons & Theme Switcher -->
            <div class="hidden lg:flex items-center space-x-3">
                <x-theme-toggle size="md" />

                <a href="{{ route('registration') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-2xl text-sm font-semibold text-white bg-[#6b9cf4] hover:bg-[#588ce6] dark:bg-blue-600 dark:hover:bg-blue-500 shadow-md shadow-blue-400/30 hover:shadow-lg transition transform hover:-translate-y-0.5 whitespace-nowrap">
                    <span>Daftar Online</span>
                </a>
            </div>

            <!-- Mobile Actions (Theme Toggle, Daftar, Hamburger) -->
            <div class="flex items-center space-x-2 lg:hidden">
                <x-theme-toggle size="sm" />

                <a href="{{ route('registration') }}" class="px-3 py-1.5 text-xs font-semibold text-white bg-[#6b9cf4] dark:bg-blue-600 rounded-xl shadow">
                    Daftar
                </a>
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="p-2 rounded-lg text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500" aria-label="Buka Menu Navigasi">
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
        <div class="flex flex-col space-y-1 font-semibold text-slate-700 dark:text-slate-200">
            @foreach($pubNavItems as $navItem)
                @if($navItem->activeChildren->count() > 0)
                    <div x-data="{ open: false }" class="border-b border-slate-100 dark:border-slate-800 pb-1">
                        <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 text-left font-bold">
                            <span>{{ $navItem->title }}</span>
                            <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180 text-blue-600 dark:text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" class="pl-4 space-y-1 py-1" style="display: none;">
                            @foreach($navItem->activeChildren as $child)
                                <a href="{{ $child->link }}" target="{{ $child->target }}" class="block px-3 py-1.5 text-xs text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 transition">
                                    • {{ $child->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $navItem->link }}" target="{{ $navItem->target }}" class="px-3 py-2.5 rounded-xl {{ $navItem->isActiveRoute() ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300 font-bold' : 'hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        {{ $navItem->title }}
                    </a>
                @endif
            @endforeach
        </div>

        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-col space-y-2">
            <a href="{{ route('registration') }}" class="w-full text-center py-3 rounded-xl font-bold text-white bg-[#6b9cf4] dark:bg-blue-600 hover:bg-[#588ce6] shadow-md transition">
                Pendaftaran Online Pasien
            </a>
            <a href="https://wa.me/628112521118" target="_blank" rel="noopener" class="w-full text-center py-2.5 rounded-xl font-semibold text-blue-800 dark:text-blue-300 bg-blue-50 dark:bg-blue-950/50 hover:bg-blue-100 dark:hover:bg-blue-900/50 border border-blue-200 dark:border-blue-800 transition text-sm">
                WhatsApp Hotline: 0811-2521-118
            </a>
        </div>
    </div>
</header>
