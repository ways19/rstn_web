<x-layouts.app
    title="Permohonan Berhasil — RSUD R.A.A. Tjokronegoro"
    meta-description="Konfirmasi permohonan informasi publik RSUD R.A.A. Tjokronegoro."
>

    <x-page-header
        title="Permohonan Berhasil"
        description="Permohonan informasi publik Anda telah berhasil dikirim."
    />

    <section class="bg-slate-50 pb-16 pt-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="p-6 text-center sm:p-10">

                    {{-- Icon sukses --}}
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="h-8 w-8"
                        >
                            <path d="m5 12 4 4L19 6"/>
                        </svg>
                    </div>

                    <h1 class="mt-5 text-2xl font-bold text-slate-800">
                        Permohonan Berhasil Dikirim
                    </h1>

                    <p class="mx-auto mt-3 max-w-xl text-sm leading-6 text-slate-500">
                        Permohonan informasi Anda telah berhasil diterima oleh
                        PPID RSUD R.A.A. Tjokronegoro.
                    </p>

                    {{-- Nomor tiket --}}
                    <div class="mx-auto mt-8 max-w-md rounded-xl border border-slate-200 bg-slate-50 p-5">

                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Nomor Tiket
                        </p>

                        <p class="mt-2 text-2xl font-bold tracking-wide text-[#007b83]">
                            {{ $request->ticket_number }}
                        </p>

                        <div class="mt-4 border-t border-slate-200 pt-4">
                            <p class="text-xs text-slate-400">
                                Status Permohonan
                            </p>

                            <span class="mt-2 inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                {{ ucfirst($request->status) }}
                            </span>
                        </div>

                    </div>

                    <p class="mt-6 text-xs leading-5 text-slate-400">
                        Simpan nomor tiket ini untuk memantau proses
                        permohonan informasi Anda.
                    </p>

                    {{-- Tombol --}}
                    <div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">

                        <a
                            href="{{ route('ppid.request.track') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-[#007b83] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#006b72]"
                        >
                            Lacak Permohonan
                        </a>

                        <a
                            href="{{ route('ppid.request.information') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Kembali
                        </a>

                    </div>

                </div>

            </div>

        </div>
    </section>

</x-layouts.app>