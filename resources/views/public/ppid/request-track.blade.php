<x-layouts.app
    title="Lacak Permohonan — RSUD R.A.A. Tjokronegoro"
    meta-description="Layanan pelacakan permohonan informasi publik RSUD R.A.A. Tjokronegoro."
>

    <x-page-header
        :title="$page->title"
        :description="$page->description"
    />


    {{-- =========================================================
        SUBMENU PERMOHONAN INFORMASI
    ========================================================== --}}
    <x-submenus.ppid-request active="track" />


    {{-- =========================================================
        BREADCRUMB
    ========================================================== --}}
    <div class="bg-slate-50">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

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

                <a href="{{ route('ppid.request') }}" class="font-medium text-slate-500 hover:text-[#007b83]">
                    Permohonan Informasi
                </a>

                <span class="text-slate-300">›</span>

                <span class="font-semibold text-[#007b83]">
                    {{ $page->title }}
                </span>

            </nav>

        </div>

    </div>


    {{-- =========================================================
        KONTEN
    ========================================================== --}}
    <section class="bg-slate-50 pb-16 pt-2">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


            {{-- =================================================
                CONTENT DARI CMS
            ================================================== --}}
            <div class="mb-6">

                {!! $page->content !!}

            </div>


            {{-- =================================================
                LACAK TIKET
            ================================================== --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="p-6 sm:p-8">

                    <h2 class="text-lg font-bold text-slate-900 sm:text-xl">
                        Masukkan Nomor Tiket Anda
                    </h2>


                    {{-- FORM LACAK --}}
                    <form
                        method="GET"
                        action="{{ route('ppid.request.track') }}"
                        class="mt-5"
                    >
                        <div class="flex flex-col gap-3 md:flex-row">
                            <div class="flex-1">
                                <label for="ticket" class="sr-only">
                                    Nomor Tiket
                                </label>

                                <input
                                    type="text"
                                    id="ticket"
                                    name="ticket"
                                    value="{{ request('ticket') }}"
                                    placeholder="Contoh: PPID-20261007-0001"
                                    required
                                    maxlength="100"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                                >
                            </div>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#007b83] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#006b72]"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                >
                                    <circle cx="11" cy="11" r="7"/>
                                    <path stroke-linecap="round" d="m20 20-4-4"/>
                                </svg>

                                Lacak Tiket
                            </button>
                        </div>

                        @error('ticket')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        @if ($ticket || $objection)
                            <p class="text-xs text-slate-500">Nomor Tiket Pelacakan</p>
                            <p class="mt-1 break-all font-bold text-slate-900">
                                {{ $ticket?->ticket_number ?? $objection?->ticket_number ?? '-' }}
                            </p>
                        @endif
                    </form>

                </div>

            </div>

            {{-- =================================================
                HASIL PENCARIAN TIKET
            ================================================== --}}

            @if ($ticketSearched)

                @if ($ticket || $objection)

                    {{-- =================================================
                        PANEL PERMOHONAN INFORMASI
                    ================================================== --}}
                    @if ($ticket)

                        @php
                            $statusLabels = [
                                'diajukan' => 'Diajukan',
                                'diverifikasi' => 'Diverifikasi',
                                'diproses' => 'Sedang Diproses',
                                'selesai' => 'Selesai',
                                'ditolak' => 'Ditolak',
                            ];

                            $statusClasses = [
                                'diajukan' => 'bg-blue-50 text-blue-700 ring-blue-200',
                                'diverifikasi' => 'bg-blue-50 text-blue-700 ring-blue-200',
                                'diproses' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
                                'selesai' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                'ditolak' => 'bg-red-50 text-red-700 ring-red-200',
                            ];

                            $status = strtolower($ticket->status ?? '');
                        @endphp

                        <details class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                            {{-- HEADER PERMOHONAN --}}
                            <summary class="cursor-pointer list-none border-b border-slate-200 bg-slate-50 p-6 transition hover:bg-slate-100 sm:p-8">

                                <p class="text-sm font-semibold uppercase tracking-wide text-[#007b83]">
                                    Hasil Pelacakan
                                </p>

                                <h2 class="mt-2 text-xl font-bold text-slate-900">
                                    Permohonan Informasi
                                </h2>
                                <p class="mt-2 text-sm text-slate-500">
                                    Klik untuk melihat detail permohonan informasi.
                                </p>

                                <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                    <div>
                                        <p class="text-xs text-slate-500">Nomor Tiket Permohonan</p>
                                        <p class="mt-1 break-all font-bold text-slate-900">
                                            {{ $ticket->ticket_number }}
                                        </p>
                                    </div>

                                    <span class="inline-flex w-fit items-center rounded-full px-3 py-1.5 text-sm font-semibold ring-1 ring-inset {{ $statusClasses[$status] ?? 'bg-slate-100 text-slate-700 ring-slate-200' }}">
                                        {{ $statusLabels[$status] ?? ucfirst($status ?: 'Belum tersedia') }}
                                    </span>

                                </div>
                            </summary>

                            {{-- DETAIL PERMOHONAN --}}
                            <div class="p-6 sm:p-8">

                                <h3 class="text-base font-bold text-slate-900">
                                    Data Formulir Pemohon
                                </h3>

                                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">

                                    <div>
                                        <p class="text-sm text-slate-500">Tanggal Pengajuan</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ $ticket->created_at?->format('d M Y, H:i') ?? '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-slate-500">Kategori Pemohon</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ $ticket->applicant_category ?: '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-slate-500">Nama Pemohon</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ $ticket->name ?: '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-slate-500">Nomor Telepon</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ $ticket->phone ?: '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-slate-500">Email</p>
                                        <p class="mt-1 break-words font-medium text-slate-800">
                                            {{ $ticket->email ?: '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-slate-500">NIK</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ $ticket->nik ? '••••••••' . substr($ticket->nik, -4) : '-' }}
                                        </p>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <p class="text-sm text-slate-500">Alamat</p>
                                        <p class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-800">
                                            {{ $ticket->address ?: '-' }}
                                        </p>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <p class="text-sm text-slate-500">Rincian Informasi yang Diminta</p>
                                        <div class="mt-2 rounded-xl bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                                            {{ $ticket->information_detail ?: '-' }}
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <p class="text-sm text-slate-500">Tujuan Permohonan</p>
                                        <div class="mt-2 rounded-xl bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                                            {{ $ticket->purpose ?: '-' }}
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-sm text-slate-500">Cara Memperoleh Informasi</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ $ticket->obtaining_method ?: '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-slate-500">Cara Pengiriman Informasi</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ $ticket->delivery_method ?: '-' }}
                                        </p>
                                    </div>

                                    @if ($ticket->voice_recording)
                                        <div class="sm:col-span-2">
                                            <p class="text-sm text-slate-500">Rekaman Suara Permohonan</p>
                                            <div class="mt-2 rounded-xl border border-slate-200 bg-white p-4">
                                                <audio controls preload="metadata" class="w-full">
                                                    <source src="{{ asset('storage/' . $ticket->voice_recording) }}">
                                                    Browser Anda tidak mendukung pemutaran audio.
                                                </audio>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="sm:col-span-2">
                                        <p class="text-sm font-medium text-slate-600">
                                            Tindak Lanjut Permohonan
                                        </p>
                                        <div class="mt-2 rounded-xl border border-blue-100 bg-blue-50 p-4 text-sm leading-6 text-blue-900">
                                            {{ $ticket->admin_note ?: 'Belum ada tindak lanjut dari petugas.' }}
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-8 border-t border-slate-200 pt-5">
                                    <p class="text-sm leading-6 text-slate-500">
                                        Status menunjukkan tahapan penanganan permohonan informasi berdasarkan data yang tercatat di sistem.
                                    </p>
                                </div>

                            </div>

                        </details>

                    @endif
                    {{-- AKHIR PANEL PERMOHONAN INFORMASI --}}


                    {{-- =================================================
                        PANEL PENGAJUAN KEBERATAN
                    ================================================== --}}
                    @if ($objection)

                        @php
                            $objectionStatusLabels = [
                                'diajukan' => 'Diajukan',
                                'diverifikasi' => 'Diverifikasi',
                                'diproses' => 'Sedang Diproses',
                                'selesai' => 'Selesai',
                                'ditolak' => 'Ditolak',
                            ];

                            $objectionStatusClasses = [
                                'diajukan' => 'bg-blue-50 text-blue-700 ring-blue-200',
                                'diverifikasi' => 'bg-blue-50 text-blue-700 ring-blue-200',
                                'diproses' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
                                'selesai' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                'ditolak' => 'bg-red-50 text-red-700 ring-red-200',
                            ];

                            $objectionStatus = strtolower($objection->status ?? '');
                        @endphp

                        <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                            {{-- HEADER KEBERATAN --}}
                            <div class="border-b border-slate-200 bg-slate-50 p-6 sm:p-8">

                                <p class="text-sm font-semibold uppercase tracking-wide text-[#007b83]">
                                    Hasil Pelacakan
                                </p>

                                <h2 class="mt-2 text-xl font-bold text-slate-900">
                                    Detail Pengajuan Keberatan
                                </h2>

                                <p class="mt-2 text-sm text-slate-500">
                                    Berikut data dan status penanganan pengajuan keberatan Anda.
                                </p>

                                <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                    <div>
                                        <p class="text-xs text-slate-500">Nomor Tiket Keberatan</p>
                                        <p class="mt-1 break-all font-bold text-slate-900">
                                            {{ $objection->objection_ticket_number ?: '-' }}
                                        </p>

                                        <p class="mt-3 text-xs text-slate-500">
                                            Nomor Tiket Permohonan Informasi Terkait
                                        </p>
                                        <p class="mt-1 break-all font-medium text-slate-700">
                                            {{ $objection->ticket_number ?: '-' }}
                                        </p>
                                    </div>

                                    <span class="inline-flex w-fit items-center rounded-full px-3 py-1.5 text-sm font-semibold ring-1 ring-inset {{ $objectionStatusClasses[$objectionStatus] ?? 'bg-slate-100 text-slate-700 ring-slate-200' }}">
                                        {{ $objectionStatusLabels[$objectionStatus] ?? ucfirst($objectionStatus ?: 'Belum tersedia') }}
                                    </span>

                                </div>
                            </div>

                            {{-- DETAIL KEBERATAN --}}
                            <div class="p-6 sm:p-8">

                                <h3 class="text-base font-bold text-slate-900">
                                    Data Pengajuan Keberatan
                                </h3>

                                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">

                                    <div>
                                        <p class="text-sm text-slate-500">Tanggal Pengajuan</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ $objection->created_at?->format('d M Y, H:i') ?? '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-slate-500">Nama Pemohon</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ $objection->applicant_name ?: '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-slate-500">Nomor Telepon</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ $objection->applicant_phone ?: '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-slate-500">Tujuan Pengajuan</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ $objection->information_purpose ?: '-' }}
                                        </p>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <p class="text-sm text-slate-500">Alamat Pemohon</p>
                                        <p class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-800">
                                            {{ $objection->applicant_address ?: '-' }}
                                        </p>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <p class="text-sm text-slate-500">Nama Perwakilan</p>
                                        <p class="mt-1 font-medium text-slate-800">
                                            {{ $objection->representative_name ?: '-' }}
                                        </p>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <p class="text-sm text-slate-500">Alasan Keberatan</p>
                                        <div class="mt-2 rounded-xl bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                                            {{ $objection->objection_reasons ?: '-' }}
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <p class="text-sm text-slate-500">Kronologi Keberatan</p>
                                        <div class="mt-2 rounded-xl bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                                            {{ $objection->objection_chronology ?: 'Kronologi tidak diisi dalam bentuk teks.' }}
                                        </div>
                                    </div>

                                    @if ($objection->voice_recording)
                                        <div class="sm:col-span-2">
                                            <p class="text-sm text-slate-500">Rekaman Suara Keberatan</p>
                                            <div class="mt-2 rounded-xl border border-slate-200 bg-white p-4">
                                                <audio controls preload="metadata" class="w-full">
                                                    <source src="{{ asset('storage/' . $objection->voice_recording) }}">
                                                    Browser Anda tidak mendukung pemutaran audio.
                                                </audio>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="sm:col-span-2">
                                        <p class="text-sm font-medium text-slate-600">
                                            Tindak Lanjut Keberatan
                                        </p>
                                        <div class="mt-2 rounded-xl border border-blue-100 bg-blue-50 p-4 text-sm leading-6 text-blue-900">
                                            {{ $objection->admin_note ?: 'Belum ada tindak lanjut dari petugas.' }}
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-8 border-t border-slate-200 pt-5">
                                    <p class="text-sm leading-6 text-slate-500">
                                        Status menunjukkan tahapan penanganan keberatan berdasarkan data yang tercatat di sistem.
                                    </p>
                                </div>

                            </div>
                        </div>

                    @endif
                    {{-- AKHIR PANEL PENGAJUAN KEBERATAN --}}


                @else

                    {{-- =================================================
                        TIKET TIDAK DITEMUKAN
                    ================================================== --}}
                    <div class="mt-8 rounded-2xl border border-amber-200 bg-amber-50 p-6 sm:p-8">

                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    class="h-6 w-6"
                                    aria-hidden="true"
                                >
                                    <circle cx="12" cy="12" r="9"/>
                                    <path stroke-linecap="round" d="M12 8v4m0 4h.01"/>
                                </svg>
                            </div>

                            <div>
                                <h2 class="font-bold text-amber-900">
                                    Tiket Tidak Ditemukan
                                </h2>

                                <p class="mt-2 text-sm leading-6 text-amber-800">
                                    Nomor tiket tidak ditemukan. Periksa kembali nomor tiket pada bukti pengajuan Anda, kemudian coba lacak kembali.
                                </p>
                            </div>

                        </div>
                    </div>

                @endif

            @endif

        </div>

    </section>

</x-layouts.app>