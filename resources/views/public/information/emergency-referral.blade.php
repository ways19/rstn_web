<x-layouts.app title="Rujukan Gawat Darurat — RSUD R.A.A. Tjokronegoro">

    <x-page-header
        title="Rujukan Gawat Darurat"
        description="Informasi mengenai layanan dan prosedur rujukan gawat darurat RSUD R.A.A. Tjokronegoro."
    />

    {{-- Breadcrumb --}}
    <div class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 py-5 text-sm" aria-label="Breadcrumb">
                <a href="{{ route('information.emergency-referral') }}" class="font-medium text-slate-500 hover:text-[#007b83]">
                    Informasi
                </a>

                <span class="text-slate-300">›</span>

                <span class="font-semibold text-[#007b83]">
                    Rujukan Gawat Darurat
                </span>
            </nav>
        </div>
    </div>

    <main class="mx-auto max-w-7xl px-6 py-8">
        {!! $page->content !!}
    </main>

</x-layouts.app>