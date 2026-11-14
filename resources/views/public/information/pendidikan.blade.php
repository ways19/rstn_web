<x-layouts.app title="Pendidikan — RSUD R.A.A. Tjokronegoro">

    <x-page-header
        title="Pendidikan & Pelatihan"
        description="Informasi mengenai program pendidikan dan pelatihan di RSUD R.A.A. Tjokronegoro."
    />

    {{-- Submenu Pendidikan & Pelatihan --}}
    <x-submenus.diklat active="education" />

    {{-- Breadcrumb --}}
    <div class="bg-slate-50">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <nav
                class="flex items-center gap-2 py-5 text-sm"
                aria-label="Breadcrumb"
            >

                <a href="{{ url('/informasi/diklat') }}" class="font-medium text-slate-500 hover:text-[#007b83]">
                    Informasi
                </a>

                <span class="text-slate-300">
                    ›
                </span>

                <span class="font-semibold text-[#007b83]">
                    Pendidikan & Pelatihan
                </span>

            </nav>

        </div>

    </div>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- NOTIFIKASI BERHASIL --}}
        @if (session('success'))
            <div
                class="my-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800"
                role="alert"
            >
                <svg
                    class="mt-0.5 h-5 w-5 shrink-0"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M20 6 9 17l-5-5"/>
                    <circle cx="12" cy="12" r="10"/>
                </svg>

                <div>
                    <p class="font-semibold">Berhasil!</p>
                    <p class="mt-1 text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {!! $page->content !!}

    </main>

    {{-- MODAL PDF VIEWER BROSUR PELATIHAN --}}
    @include('public.information.partials.diklat-brochure-modal')

   @push('scripts')
        {{-- Tampilkan tombol riwayat jika ada token pendaftaran --}}
        <script>
        (function () {
            const historySection = document.getElementById('diklat-history-section');

            if (!historySection) return;

            try {
                const savedTokens = JSON.parse(
                    localStorage.getItem('diklat_registration_tokens') || '[]'
                );

                const hasValidToken = Array.isArray(savedTokens) &&
                    savedTokens.some(token =>
                        typeof token === 'string' &&
                        /^[a-zA-Z0-9]{64}$/.test(token)
                    );

                historySection.style.display = hasValidToken ? '' : 'none';
            } catch (error) {
                historySection.style.display = 'none';
                console.error('Gagal membaca riwayat pendaftaran:', error);
            }
        })();
        </script>
    @endpush
</x-layouts.app>