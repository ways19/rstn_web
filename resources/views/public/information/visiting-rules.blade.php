<x-layouts.app title="Tata Tertib Jam Berkunjung — RSUD R.A.A. Tjokronegoro">

    <x-page-header
        title="Tata Tertib Jam Berkunjung"
        description="Informasi mengenai tata tertib dan jam berkunjung pasien di RSUD R.A.A. Tjokronegoro."
    />

    {{-- Breadcrumb --}}
    <div class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 py-5 text-sm" aria-label="Breadcrumb">
                <a href="{{ route('information.visiting-rules') }}" class="font-medium text-slate-500 hover:text-[#007b83]">
                    Informasi
                </a>

                <span class="text-slate-300">›</span>

                <span class="font-semibold text-[#007b83]">
                    Tata Tertib Jam Berkunjung
                </span>
            </nav>
        </div>
    </div>

    <main class="mx-auto max-w-7xl px-6 py-8">
        {!! $page->content !!}
    </main>

</x-layouts.app>