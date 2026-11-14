@props(['active' => null])

@php
    $currentRoute = request()->route()?->getName() ?? '';
    $currentUrl = url()->current();

    $items = [
        [
            'key' => 'information',
            'url' => route('ppid.request.information'),
            'label' => 'Permintaan Informasi',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>',
            'isActive' => $active === 'information' || $currentRoute === 'ppid.request.information' || $currentRoute === 'ppid.request' || str_contains($currentUrl, '/ppid/permohonan/permintaan'),
        ],
        [
            'key' => 'objection',
            'url' => route('ppid.request.objection'),
            'label' => 'Pengajuan Keberatan',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
            'isActive' => $active === 'objection' || $currentRoute === 'ppid.request.objection' || str_contains($currentUrl, '/ppid/permohonan/keberatan'),
        ],
        [
            'key' => 'track',
            'url' => route('ppid.request.track'),
            'label' => 'Lacak Permohonan',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>',
            'isActive' => $active === 'track' || $currentRoute === 'ppid.request.track' || str_contains($currentUrl, '/ppid/permohonan/lacak'),
        ],
        [
            'key' => 'statistics',
            'url' => route('ppid.request.statistics'),
            'label' => 'Statistik Permohonan',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
            'isActive' => $active === 'statistics' || $currentRoute === 'ppid.request.statistics' || str_contains($currentUrl, '/ppid/permohonan/statistik'),
        ],
    ];
@endphp

<section class="border-b border-slate-200/80 bg-white py-3 sm:py-3.5 shadow-xs">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="overflow-x-auto no-scrollbar py-0.5">
            <nav class="inline-flex items-center gap-1.5 p-1.5 bg-slate-100/90 rounded-2xl border border-slate-200/80 shadow-inner" aria-label="Submenu Permohonan Informasi">
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
