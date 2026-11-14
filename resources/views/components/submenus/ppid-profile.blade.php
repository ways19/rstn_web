@props(['active' => null])

@php
    $currentRoute = request()->route()?->getName() ?? '';
    $currentUrl = url()->current();

    $items = [
        [
            'key' => 'profile',
            'url' => route('ppid.profile'),
            'label' => 'Profil PPID',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
            'isActive' => $active === 'profile' || $currentRoute === 'ppid.profile' || str_ends_with($currentUrl, '/ppid/profil'),
        ],
        [
            'key' => 'team',
            'url' => route('ppid.profile.team'),
            'label' => 'SK Tim PPID',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
            'isActive' => $active === 'team' || $currentRoute === 'ppid.profile.team' || str_ends_with($currentUrl, '/ppid/profil/sk-tim'),
        ],
        [
            'key' => 'structure',
            'url' => route('ppid.profile.structure'),
            'label' => 'Struktur PPID',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
            'isActive' => $active === 'structure' || $currentRoute === 'ppid.profile.structure' || str_ends_with($currentUrl, '/ppid/profil/struktur'),
        ],
        [
            'key' => 'duties',
            'url' => route('ppid.profile.duties'),
            'label' => 'Tugas dan Fungsi',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>',
            'isActive' => $active === 'duties' || $currentRoute === 'ppid.profile.duties' || str_ends_with($currentUrl, '/ppid/profil/tugas-fungsi'),
        ],
        [
            'key' => 'statement',
            'url' => route('ppid.profile.statement'),
            'label' => 'Maklumat Pelayanan',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
            'isActive' => $active === 'statement' || $currentRoute === 'ppid.profile.statement' || str_ends_with($currentUrl, '/ppid/profil/maklumat'),
        ],
    ];
@endphp

<section class="border-b border-slate-200/80 bg-white py-3 sm:py-3.5 shadow-xs">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="overflow-x-auto no-scrollbar py-0.5">
            <nav class="inline-flex items-center gap-1.5 p-1.5 bg-slate-100/90 rounded-2xl border border-slate-200/80 shadow-inner" aria-label="Submenu Profil PPID">
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
