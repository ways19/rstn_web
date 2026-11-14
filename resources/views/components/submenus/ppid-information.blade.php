@props(['active' => null])

@php
    $currentRoute = request()->route()?->getName() ?? '';
    $currentUrl = url()->current();

    $items = [
        [
            'key' => 'periodic',
            'url' => route('ppid.information.periodic'),
            'label' => 'Informasi Berkala',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
            'isActive' => $active === 'periodic' || $currentRoute === 'ppid.information.periodic' || str_contains($currentUrl, '/ppid/informasi/berkala'),
        ],
        [
            'key' => 'immediate',
            'url' => route('ppid.information.immediate'),
            'label' => 'Informasi Serta Merta',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
            'isActive' => $active === 'immediate' || $currentRoute === 'ppid.information.immediate' || str_contains($currentUrl, '/ppid/informasi/serta-merta'),
        ],
        [
            'key' => 'anytime',
            'url' => route('ppid.information.anytime'),
            'label' => 'Informasi Setiap Saat',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/></svg>',
            'isActive' => $active === 'anytime' || $currentRoute === 'ppid.information.anytime' || str_contains($currentUrl, '/ppid/informasi/setiap-saat'),
        ],
        [
            'key' => 'excluded',
            'url' => route('ppid.information.excluded'),
            'label' => 'Informasi Dikecualikan',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>',
            'isActive' => $active === 'excluded' || $currentRoute === 'ppid.information.excluded' || str_contains($currentUrl, '/ppid/informasi/dikecualikan'),
        ],
    ];
@endphp

<section class="border-b border-slate-200/80 bg-white py-3 sm:py-3.5 shadow-xs">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="overflow-x-auto no-scrollbar py-0.5">
            <nav class="inline-flex items-center gap-1.5 p-1.5 bg-slate-100/90 rounded-2xl border border-slate-200/80 shadow-inner" aria-label="Submenu Informasi Publik">
                @foreach ($items as $item)
                    <a
                        href="{{ $item['url'] }}"
                        class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 shrink-0 select-none {{ $item['isActive'] ? 'bg-[#007b83] text-white shadow-sm shadow-teal-950/20 ring-1 ring-teal-600/30' : 'text-slate-600 hover:text-slate-900 hover:bg-white/90 hover:shadow-xs' }}"
                        @if ($item['isActive']) aria-current="page" @endif
                    >
                        {!! $item['icon'] !!}
                        <span>{{ $item['label'] }}</span>
                        @if ($item['isActive'])
                            <span class="w-1.5 h-1.5 rounded-full bg-teal-200 ml-0.5 animate-pulse"></span>
                        @endif
                    </a>
                @endforeach
            </nav>
        </div>
    </div>
</section>
