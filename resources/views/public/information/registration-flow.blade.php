<x-layouts.app title="Alur Pendaftaran — RSUD R.A.A. Tjokronegoro">

    <x-page-header
        title="Alur Pendaftaran"
        description="Informasi mengenai alur pendaftaran pasien di RSUD R.A.A. Tjokronegoro."
    />

    {{-- Breadcrumb --}}
    <div class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 py-5 text-sm" aria-label="Breadcrumb">
                <a href="{{ route('information.registration-flow') }}" class="font-medium text-slate-500 hover:text-[#007b83]">
                    Informasi
                </a>

                <span class="text-slate-300">›</span>

                <span class="font-semibold text-[#007b83]">
                    Alur Pendaftaran
                </span>
            </nav>
        </div>
    </div>

    <main class="mx-auto max-w-7xl px-6 py-8">
        {!! $page->content !!}
    </main>

</x-layouts.app>