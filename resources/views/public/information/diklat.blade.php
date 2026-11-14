<x-layouts.app title="Pendidikan & Pelatihan (Diklat) — RSUD R.A.A. Tjokronegoro">

    <x-page-header
        title="Pendidikan & Pelatihan (Diklat)"
        description="Informasi mengenai pendidikan dan pelatihan di RSUD R.A.A. Tjokronegoro."
    />


    {{-- Submenu Pendidikan & Pelatihan --}}
    <x-submenus.diklat active="profile" />

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

    <main class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        {!! $page->content !!}

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const historySection = document.getElementById('diklat-history-section');

            if (!historySection) {
                return;
            }

            try {
                const savedTokens = JSON.parse(
                    localStorage.getItem('diklat_registration_tokens') || '[]'
                );

                const validTokens = Array.isArray(savedTokens)
                    ? savedTokens.filter(token =>
                        typeof token === 'string' &&
                        /^[a-zA-Z0-9]{64}$/.test(token)
                    )
                    : [];

                // Tampilkan bagian riwayat jika pernah ada pendaftaran
                if (validTokens.length > 0) {
                    historySection.style.display = '';
                }
            } catch (error) {
                historySection.style.display = 'none';
                console.warn('Gagal membaca riwayat pendaftaran.', error);
            }
        });
        </script>

    </main>

</x-layouts.app>