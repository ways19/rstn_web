<x-layouts.app title="Lapor Benturan Kepentingan — RSUD R.A.A. Tjokronegoro">

    <x-page-header
        title="Lapor Benturan Kepentingan"
        description="Saluran informasi dan pelaporan dugaan benturan kepentingan dalam penyelenggaraan tugas dan pelayanan di RSUD R.A.A. Tjokronegoro."
    />

    {{-- Breadcrumb --}}
    <div class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav
                class="flex items-center gap-2 py-5 text-sm"
                aria-label="Breadcrumb"
            >
                <a href="{{ route('aduan.pengaduan.online.pasien') }}" class="font-medium text-slate-500 hover:text-[#007b83]">
                    Aduan
                </a>

                <span class="text-slate-300">›</span>

                <span class="font-semibold text-[#007b83]">
                    Lapor Benturan Kepentingan
                </span>
            </nav>
        </div>
    </div>

    {{-- Konten CMS --}}
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {!! $page->content !!}
    </main>

</x-layouts.app>