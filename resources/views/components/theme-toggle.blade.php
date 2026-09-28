@props([
    'size' => 'md', // sm, md, lg
    'class' => '',
])

@php
    $sizeClasses = match($size) {
        'sm' => 'w-8 h-8 text-xs',
        'lg' => 'w-11 h-11 text-base',
        default => 'w-9 h-9 text-sm',
    };
    $iconSize = match($size) {
        'sm' => 'w-4 h-4',
        'lg' => 'w-6 h-6',
        default => 'w-5 h-5',
    };
@endphp

<div x-data="{
        darkMode: document.documentElement.classList.contains('dark'),
        toggleTheme() {
            this.darkMode = !this.darkMode;
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('rstn_theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('rstn_theme', 'light');
            }
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { dark: this.darkMode } }));
        }
     }"
     @theme-changed.window="darkMode = $event.detail.dark"
     class="inline-flex items-center">
    <button type="button"
            @click="toggleTheme()"
            :aria-label="darkMode ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap'"
            :title="darkMode ? 'Mode Terang (Klik untuk aktifkan)' : 'Mode Gelap (Klik untuk aktifkan)'"
            class="relative inline-flex items-center justify-center rounded-xl transition-all duration-300 focus:outline-none cursor-pointer border shadow-xs {{ $sizeClasses }} {{ $class }}
                   bg-white hover:bg-slate-100 text-amber-500 border-slate-200/80
                   dark:bg-slate-800/90 dark:hover:bg-slate-700 dark:text-amber-400 dark:border-slate-700/80">
        
        <!-- Sun Icon (shown in dark mode to switch to light) -->
        <svg x-show="darkMode" 
             x-transition:enter="transition-all duration-300 ease-out"
             x-transition:enter-start="opacity-0 rotate-90 scale-50"
             x-transition:enter-end="opacity-100 rotate-0 scale-100"
             class="{{ $iconSize }} text-amber-400" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>

        <!-- Moon Icon (shown in light mode to switch to dark) -->
        <svg x-show="!darkMode" 
             x-transition:enter="transition-all duration-300 ease-out"
             x-transition:enter-start="opacity-0 -rotate-90 scale-50"
             x-transition:enter-end="opacity-100 rotate-0 scale-100"
             class="{{ $iconSize }} text-slate-600 hover:text-slate-900" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    </button>
</div>
