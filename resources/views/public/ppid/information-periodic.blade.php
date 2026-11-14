<x-layouts.app
    title="Informasi Berkala — RSUD R.A.A. Tjokronegoro"
    meta-description="Informasi Publik Berkala RSUD R.A.A. Tjokronegoro."
>

    {{-- Header --}}
    <x-page-header
        :title="$page->title"
        :description="$page->description"
    />

    {{-- Submenu Informasi Publik --}}
    <x-submenus.ppid-information active="periodic" />


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
                <div class="prose max-w-none">
                    {!! $page->content !!}
                </div>

                    {{-- ========================================================= --}}
                    {{-- SECTION DARI CMS --}}
                    {{-- ========================================================= --}}

                    @forelse($sections->where('level', 1) as $section)

                    {{-- ========================================================= --}}
                    {{-- LEVEL 1 --}}
                    {{-- ========================================================= --}}

                    <div class="pt-2">

                        <div class="mb-3 flex items-center gap-3">

                            <span class="h-6 w-1 shrink-0 rounded-full bg-[#007b83]"></span>

                            <h2 class="text-base font-bold uppercase tracking-wide text-[#172033] sm:text-lg">
                                {{ $section->title }}
                            </h2>

                        </div>


                        {{-- DOKUMEN LEVEL 1 --}}
                        @if ($section->placements->count())

                            <div class="divide-y divide-slate-100 rounded-xl border border-slate-200 bg-white shadow-sm">

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

                                                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-[#e5f6f4] text-[#00a99d] transition group-hover:bg-[#d5f0ed]">

                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                                        />

                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M14 3v6h6M9 13h6M9 17h6"
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

                        @endif


                        {{-- ========================================================= --}}
                        {{-- LEVEL 2 --}}
                        {{-- ========================================================= --}}

                        @foreach($section->children as $child)

                            <div class="mt-5 pl-3 sm:pl-5">

                                <div class="mb-2 flex items-center gap-2">

                                    <span class="text-lg font-bold text-[#007b83]">
                                        ›
                                    </span>

                                    <h3 class="text-sm font-bold uppercase text-[#007b83] sm:text-[15px]">
                                        {{ $child->title }}
                                    </h3>

                                </div>


                                {{-- DOKUMEN LEVEL 2 --}}
                                @if ($child->placements->count())

                                    <div class="ml-3 divide-y divide-slate-100 border-l-2 border-[#007b83] bg-white sm:ml-5">

                                        @foreach($child->placements->sortBy('sort_order') as $placement)

                                            @php
                                                $document = $placement->document;
                                            @endphp

                                            @if ($document)

                                                <a
                                                    href="{{ route('ppid.document.detail', $document) }}"
                                                    class="group flex items-center justify-between gap-4 px-4 py-3.5 transition hover:bg-[#f7fbfb] sm:px-5"
                                                >

                                                    <div class="flex min-w-0 items-center gap-3">

                                                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-[#e5f6f4] text-[#00a99d]">

                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4"
                                                                fill="none"
                                                                viewBox="0 0 24 24"
                                                                stroke="currentColor"
                                                                stroke-width="1.8"
                                                            >
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                                                />

                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    d="M14 3v6h6M9 13h6M9 17h6"
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

                                    <div class="ml-3 border-l-2 border-[#007b83] py-2 pl-4 text-sm text-slate-500 sm:ml-5">
                                        Belum ada dokumen pada section ini.
                                    </div>

                                @endif

                            </div>

                        @endforeach

                    </div>

                @empty

                    <div class="rounded-2xl border border-slate-200 bg-white px-6 py-10 text-center shadow-sm">

                        <p class="text-sm text-slate-500">
                            Belum ada informasi yang tersedia.
                        </p>

                    </div>

                @endforelse
                
                {{-- ========================================================= --}}
                {{-- CATATAN --}}
                {{-- ========================================================= --}}

                <div class="rounded-2xl border border-[#cfe9e7] bg-[#f7fbfb] px-6 py-5 sm:px-8">

                    <div class="flex items-start gap-3">

                        <div class="mt-0.5 text-[#007b83]">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"
                                />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-800">
                                Informasi Dokumen
                            </h3>

                            <p class="mt-1 text-sm leading-6 text-slate-500">
                                Dokumen yang tercantum pada halaman ini merupakan informasi publik
                                yang disediakan oleh PPID RSUD R.A.A. Tjokronegoro dan diperbarui
                                sesuai dengan periode penyediaannya.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

</x-layouts.app>