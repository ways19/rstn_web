@props(['active' => null])

@php
    $currentRoute = request()->route()?->getName() ?? '';
    $currentUrl = url()->current();

    $items = [
        [
            'key' => 'profile',
            'url' => route('information.training'),
            'label' => 'Profil',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
            'isActive' => $active === 'profile' || $currentRoute === 'information.training' || str_ends_with($currentUrl, '/diklat') || str_ends_with($currentUrl, '/informasi/diklat'),
        ],
        [
            'key' => 'education',
            'url' => route('information.education'),
            'label' => 'Pendidikan & Pelatihan',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7"/></svg>',
            'isActive' => $active === 'education' || in_array($currentRoute, ['education', 'information.education']) || str_contains($currentUrl, '/pendidikan-pelatihan'),
        ],
        [
            'key' => 'facilities',
            'url' => route('information.facilities'),
            'label' => 'Fasilitas',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>',
            'isActive' => $active === 'facilities' || in_array($currentRoute, ['facilities', 'information.facilities']) || str_contains($currentUrl, '/fasilitas'),
        ],
        [
            'key' => 'accreditation',
            'url' => route('information.accreditation'),
            'label' => 'Akreditasi',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>',
            'isActive' => $active === 'accreditation' || in_array($currentRoute, ['accreditation', 'information.accreditation']) || str_contains($currentUrl, '/akreditasi'),
        ],
        [
            'key' => 'documentation',
            'url' => route('information.documentation'),
            'label' => 'Dokumentasi',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
            'isActive' => $active === 'documentation' || in_array($currentRoute, ['documentation', 'information.documentation']) || str_contains($currentUrl, '/dokumentasi'),
        ],
        [
            'key' => 'track',
            'url' => route('information.diklat.track'),
            'label' => 'Lacak Pendaftaran',
            'icon' => '<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>',
            'isActive' => $active === 'track' || $currentRoute === 'information.diklat.track' || str_contains($currentUrl, '/diklat/lacak'),
        ],
    ];
@endphp

<section class="border-b border-slate-200/80 bg-white py-3 sm:py-3.5 shadow-xs">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="overflow-x-auto no-scrollbar py-0.5">
            <nav class="inline-flex items-center gap-1.5 p-1.5 bg-slate-100/90 rounded-2xl border border-slate-200/80 shadow-inner" aria-label="Submenu Pendidikan & Pelatihan">
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
