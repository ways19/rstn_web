<x-layouts.app
    title="Informasi Setiap Saat — RSUD R.A.A. Tjokronegoro"
    meta-description="{{ $page->description ?? 'Informasi setiap saat RSUD R.A.A. Tjokronegoro.' }}"
>

    <x-page-header
        :title="$page->title"
        :description="$page->description"
    />

    {{-- Submenu Informasi Publik --}}
    <x-submenus.ppid-information active="anytime" />

    {{-- Breadcrumb --}}
    <div class="bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <nav
                class="flex items-center gap-2 py-5 text-sm"
                aria-label="Breadcrumb"
            >
                <a
                    href="{{ route('ppid.profile') }}"
                    class="font-medium text-slate-500 hover:text-[#007b83]"
                >
                    PPID
                </a>

                <span class="text-slate-300">›</span>

                <a href="{{ route('ppid.information') }}" class="font-medium text-slate-500 hover:text-[#007b83]">
                    Informasi Publik
                </a>

                <span class="text-slate-300">›</span>

                <span class="font-semibold text-[#007b83]">
                    {{ $page->title }}
                </span>
            </nav>

        </div>
    </div>

    {{-- Konten --}}
    <section class="bg-slate-50 pb-16 pt-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="space-y-6">

                {{-- INTRO DARI CMS --}}
                @if($page->content)
                    <div class="prose max-w-none">
                        {!! $page->content !!}
                    </div>
                @endif

                {{-- Struktur informasi --}}
                @forelse($sections as $section)

                    <div class="{{ $section->level == 1 ? 'pt-2' : 'mt-1 pl-2 sm:pl-4' }}">

                        {{-- Level 1 --}}
                        @if ($section->level == 1)

                            <div class="mb-3 flex items-center gap-3">
                                <span class="h-6 w-1 shrink-0 rounded-full bg-[#007b83]"></span>

                                <h2 class="text-base font-bold uppercase tracking-wide text-[#172033] sm:text-lg">
                                    {{ $section->title }}
                                </h2>
                            </div>

                        {{-- Level 2 --}}
                        @else

                            <div class="mb-2 flex items-center gap-2">
                                <span class="text-lg font-bold text-[#007b83]">
                                    ›
                                </span>

                                <h3 class="text-sm font-bold uppercase text-[#007b83] sm:text-[15px]">
                                    {{ $section->title }}
                                </h3>
                            </div>

                        @endif

                        {{-- Dokumen --}}
                        @if ($section->placements->count())

                            <div
                                class="divide-y divide-slate-100 {{
                                    $section->level == 1
                                        ? 'rounded-xl border border-slate-200 bg-white shadow-sm'
                                        : 'ml-3 border-l-2 border-[#007b83] pl-3 sm:ml-5'
                                }}"
                            >

                                @foreach($section->placements->sortBy('sort_order') as $placement)

                                    @php
                                        $document = $placement->document;
                                    @endphp

                                    @if ($document)

                                        <a
                                            href="{{ route('ppid.document.detail', $document) }}"
                                            class="group flex items-center justify-between gap-4 px-4 py-3.5 transition hover:bg-[#f7fbfb] sm:px-5"
                                        >

                                            <div class="flex min-w-0 items-center gap-3">

                                                <div
                                                    class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-[#e5f6f4] text-[#00a99d] transition group-hover:bg-[#d5f0ed]"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                        class="h-4 w-4"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                                                        />
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M14 2v6h6M8 13h8M8 17h5"
                                                        />
                                                    </svg>
                                                </div>

                                                <p class="text-sm leading-6 text-slate-700 group-hover:text-[#007b83]">
                                                    {{ $document->title }}
                                                </p>

                                            </div>

                                            <span class="shrink-0 text-sm font-semibold text-[#007b83]">
                                                →
                                            </span>

                                        </a>

                                    @endif

                                @endforeach

                            </div>

                        @else

                            <div
                                class="{{
                                    $section->level == 1
                                        ? 'rounded-xl border border-slate-200 bg-white px-5 py-5 text-sm text-slate-500 shadow-sm'
                                        : 'ml-3 border-l-2 border-[#007b83] py-2 pl-4 text-sm text-slate-500 sm:ml-5'
                                }}"
                            >
                                Belum ada dokumen pada section ini.
                            </div>

                        @endif

                    </div>

                @empty

                    <div class="rounded-2xl border border-slate-200 bg-white px-6 py-10 text-center shadow-sm">
                        <p class="text-sm text-slate-500">
                            Belum ada informasi yang tersedia.
                        </p>
                    </div>

                @endforelse

                {{-- Catatan --}}
                <div class="rounded-2xl border border-[#cfe9e7] bg-[#f7fbfb] px-6 py-5 sm:px-8">
                    <p class="text-sm leading-6 text-slate-600">
                        Informasi yang tersedia setiap saat dapat diakses
                        oleh masyarakat melalui halaman ini.
                    </p>
                </div>

            </div>

        </div>
    </section>

</x-layouts.app>