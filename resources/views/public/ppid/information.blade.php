<x-layouts.app
    title="Informasi Publik — RSUD R.A.A. Tjokronegoro"
    meta-description="Informasi publik RSUD R.A.A. Tjokronegoro."
>

    {{-- Header --}}
    <x-page-header
        title="Informasi Publik"
        description="Informasi publik yang disediakan oleh RSUD R.A.A. Tjokronegoro."
    />

    {{-- Tab Informasi Publik --}}
    <section class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="overflow-x-auto">

                <nav class="flex min-w-max gap-8">

                    <a
                        href="{{ route('ppid.information.periodic') }}"
                        class="border-b-2 border-[#007b83] py-4 text-sm font-semibold text-[#007b83]"
                    >
                        Informasi Berkala
                    </a>

                    <a
                        href="{{ route('ppid.information.immediate') }}"
                        class="py-4 text-sm font-medium text-slate-500 hover:text-[#007b83]"
                    >
                        Informasi Serta Merta
                    </a>

                    <a
                        href="{{ route('ppid.information.anytime') }}"
                        class="py-4 text-sm font-medium text-slate-500 hover:text-[#007b83]"
                    >
                        Informasi Setiap Saat
                    </a>

                    <a
                        href="{{ route('ppid.information.excluded') }}"
                        class="py-4 text-sm font-medium text-slate-500 hover:text-[#007b83]"
                    >
                        Informasi Dikecualikan
                    </a>

                </nav>

            </div>
        </div>
    </section>

    {{-- Isi --}}
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">

                <span class="text-xs font-bold text-[#007b83] uppercase tracking-wider">
                    Daftar Informasi
                </span>

                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 mb-6">
                    Informasi Publik
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    <a href="#"
                       class="p-5 rounded-xl border border-slate-200 hover:border-[#007b83] hover:shadow-sm transition">
                        <h3 class="font-bold text-slate-800">
                            Informasi Berkala
                        </h3>
                        <p class="text-xs text-slate-500 mt-2">
                            Informasi yang disediakan dan diumumkan secara berkala.
                        </p>
                    </a>

                    <a href="#"
                       class="p-5 rounded-xl border border-slate-200 hover:border-[#007b83] hover:shadow-sm transition">
                        <h3 class="font-bold text-slate-800">
                            Informasi Serta Merta
                        </h3>
                        <p class="text-xs text-slate-500 mt-2">
                            Informasi yang wajib diumumkan secara serta-merta.
                        </p>
                    </a>

                    <a href="#"
                       class="p-5 rounded-xl border border-slate-200 hover:border-[#007b83] hover:shadow-sm transition">
                        <h3 class="font-bold text-slate-800">
                            Informasi Setiap Saat
                        </h3>
                        <p class="text-xs text-slate-500 mt-2">
                            Informasi yang wajib tersedia setiap saat.
                        </p>
                    </a>

                    <a href="#"
                       class="p-5 rounded-xl border border-slate-200 hover:border-[#007b83] hover:shadow-sm transition">
                        <h3 class="font-bold text-slate-800">
                            Informasi Dikecualikan
                        </h3>
                        <p class="text-xs text-slate-500 mt-2">
                            Informasi yang tidak dapat diberikan kepada publik.
                        </p>
                    </a>

                </div>

            </div>

        </div>
    </section>

</x-layouts.app>