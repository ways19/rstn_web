<x-layouts.app
    title="SK Tim PPID — RSUD R.A.A. Tjokronegoro"
    meta-description="Surat Keputusan Tim Pejabat Pengelola Informasi dan Dokumentasi RSUD R.A.A. Tjokronegoro."
>

    @php
        $driveFileId = null;

        if ($page->file_attachment) {
            preg_match('~/d/([^/]+)~', $page->file_attachment, $matches);

            $driveFileId = $matches[1] ?? null;

            if (!$driveFileId) {
                $query = parse_url($page->file_attachment, PHP_URL_QUERY);

                if ($query) {
                    parse_str($query, $params);
                    $driveFileId = $params['id'] ?? null;
                }
            }
        }
    @endphp

    {{-- Header --}}
    <x-page-header
        :title="$page->title"
        :description="$page->description"
    />

    {{-- Submenu Profil PPID --}}
    <x-submenus.ppid-profile active="team" />

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

                <span class="font-semibold text-[#007b83]">
                    {{ $page->title }}
                </span>
            </nav>
        </div>
    </div>

    {{-- Konten --}}
    <section class="bg-slate-50 pb-16 pt-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- Konten Summernote --}}
                <div class="p-6 sm:p-8">
                    {!! $page->content !!}
                </div>

                {{-- Dokumen SK --}}
                @if ($driveFileId)

                    <div class="border-t border-slate-200 px-4 pb-0 pt-6 sm:px-6">
                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                            <iframe
                                src="https://drive.google.com/file/d/{{ $driveFileId }}/preview"
                                class="h-[650px] w-full sm:h-[800px]"
                                allow="autoplay"
                                title="SK Tim PPID RSUD R.A.A. Tjokronegoro"
                            ></iframe>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 px-6 py-6 sm:px-8">
                        <div class="flex justify-center">
                            <a
                                href="{{ $page->file_attachment }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center justify-center rounded-lg bg-[#0084c9] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0075b5]"
                            >
                                Unduh Dokumen SK
                            </a>
                        </div>
                    </div>

                @else

                    <div class="border-t border-slate-200 px-6 py-16 text-center">
                        <h3 class="text-lg font-semibold text-slate-800">
                            Dokumen belum tersedia
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                            Dokumen SK Tim PPID belum ditambahkan oleh administrator.
                        </p>
                    </div>

                @endif

            </div>

        </div>
    </section>

</x-layouts.app>