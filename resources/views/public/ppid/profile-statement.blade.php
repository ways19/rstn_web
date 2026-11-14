<x-layouts.app
    title="Maklumat Pelayanan Informasi — RSUD R.A.A. Tjokronegoro"
    meta-description="Maklumat Pelayanan Informasi PPID RSUD R.A.A. Tjokronegoro."
>

    @php
        $imageUrl = null;

        if ($page->file_attachment) {
            $imageUrl = $page->file_attachment;

            if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                $imageUrl = asset('storage/' . $page->file_attachment);
            }
        }
    @endphp

    {{-- Header --}}
    <x-page-header
        :title="$page->title"
        :description="$page->description"
    />

    {{-- Submenu Profil PPID --}}
    <x-submenus.ppid-profile active="statement" />

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

    {{-- Konten Dinamis dari CMS / Summernote --}}
    <section class="bg-slate-50 pb-16 pt-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">

                {{-- Banner / konten dari Summernote --}}
                {!! $page->content !!}

                {{-- Gambar Maklumat --}}
                @if ($imageUrl)
                    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <img
                            src="{{ $imageUrl }}"
                            alt="Maklumat Pelayanan Informasi RSUD R.A.A. Tjokronegoro"
                            class="mx-auto block h-auto w-full object-contain"
                        >
                    </div>
                @endif

            </div>

        </div>
    </section>

</x-layouts.app>