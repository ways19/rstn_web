<x-layouts.app
    title="Pengajuan Keberatan — RSUD R.A.A. Tjokronegoro"
    meta-description="Layanan pengajuan keberatan informasi publik RSUD R.A.A. Tjokronegoro."
>

    <x-page-header
        :title="$page->title"
        :description="$page->description"
    />


    {{-- SUBMENU PERMOHONAN INFORMASI --}}
    <x-submenus.ppid-request active="objection" />


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



    {{-- CONTENT --}}
    <section class="bg-slate-50 pb-16 pt-2">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">


                {{-- ===================================================== --}}
                {{-- KONTEN CMS --}}
                {{-- ===================================================== --}}

                <div class="p-5 sm:p-8">

                    {!! $page->content !!}

                </div>


                {{-- ===================================================== --}}
                {{-- FORM PENGAJUAN KEBERATAN --}}
                {{-- ===================================================== --}}

                <div class="border-t border-slate-200 bg-slate-50 px-4 py-6 sm:px-6 sm:py-8">

               @if(session('success'))
                    <div
                        id="successModal"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 px-4"
                    >
                        <div
                            class="w-full max-w-md rounded-2xl bg-white p-6 text-center shadow-2xl sm:p-8"
                        >
                            {{-- Ikon Berhasil --}}
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-8 w-8 text-emerald-600"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                            </div>

                            {{-- Judul --}}
                            <h2 class="mt-5 text-lg font-bold text-slate-800">
                                Pengajuan Berhasil
                            </h2>

                            {{-- Pesan --}}
                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                {{ session('success') }}
                            </p>

                            {{-- Nomor Tiket Keberatan --}}
                            @if (session('objection_ticket_number'))
                                <div class="mt-5 rounded-xl border border-teal-200 bg-teal-50 p-4">
                                    <p class="text-sm font-medium text-slate-600">
                                        Nomor Tiket Keberatan
                                    </p>

                                    <p class="mt-2 break-all text-lg font-bold tracking-wide text-[#007b83]">
                                        {{ session('objection_ticket_number') }}
                                    </p>

                                    <p class="mt-2 text-xs leading-5 text-slate-500">
                                        Simpan nomor tiket ini untuk memantau perkembangan pengajuan keberatan Anda.
                                    </p>
                                </div>
                            @endif

                            {{-- Tombol --}}
                            <button
                                type="button"
                                onclick="document.getElementById('successModal').remove()"
                                class="mt-6 w-full rounded-xl bg-[#007b83] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#006b72]"
                            >
                                Tutup
                            </button>
                        </div>
                    </div>
                @endif

                    <form method="POST"
                        action="{{ route('ppid.request.objection.submit') }}"
                        enctype="multipart/form-data"
                        class="w-full space-y-6">

                        @csrf


                        {{-- ================================================= --}}
                        {{-- 1. REFERENSI PERMOHONAN --}}
                        {{-- ================================================= --}}

                        <div class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-6">

                            <div class="mb-5 flex items-center gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#effaf9] text-[#007b83]">
                                    📌
                                </div>

                                <div>

                                    <h2 class="text-base font-bold text-[#007b83] sm:text-lg">
                                        1. Referensi Permohonan Informasi
                                    </h2>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Masukkan data permohonan informasi yang menjadi dasar pengajuan keberatan.
                                    </p>

                                </div>

                            </div>


                            <div class="grid gap-5 md:grid-cols-2">


                                
                            {{-- Nomor Tiket --}}
                            <div>
                                <label for="ticket_number"
                                    class="mb-2 block text-xs font-semibold text-slate-700">
                                    Nomor Tiket Permohonan Informasi
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="ticket_number"
                                    name="ticket_number"
                                    value="{{ old('ticket_number') }}"
                                    required
                                    autocomplete="off"
                                    spellcheck="false"
                                    placeholder="Contoh: PPID-20261023-I5XSJJ"
                                    aria-describedby="ticketNumberFeedback"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                                >

                                {{-- Notifikasi validasi tiket --}}
                                <div
                                    id="ticketNumberFeedback"
                                    class="mt-2 hidden rounded-lg px-3 py-2 text-xs leading-5"
                                    role="status"
                                    aria-live="polite"
                                ></div>

                                <p class="mt-1.5 text-[10px] leading-4 text-slate-400">
                                    Masukkan nomor tiket awal yang diperoleh saat mengajukan permohonan informasi.
                                </p>
                            </div>



                                {{-- Tujuan --}}
                               <fieldset id="purposeFieldset" disabled class="min-w-0 opacity-50">

                                    {{-- Label Tujuan Penggunaan Informasi --}}
                                    <label for="information_purpose"
                                        class="mb-2 block text-xs font-semibold text-slate-700">
                                        Tujuan Penggunaan Informasi
                                        <span class="text-red-500">*</span>
                                    </label>

                                    {{-- Input Tujuan Penggunaan Informasi --}}
                                    <input
                                        type="text"
                                        id="information_purpose"
                                        name="information_purpose"
                                        value="{{ old('information_purpose') }}"
                                        required
                                        placeholder="Masukkan tujuan penggunaan informasi"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm"
                                    >

                                </fieldset>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- 2. IDENTITAS PEMOHON --}}
                        {{-- ================================================= --}}
                        <fieldset id="objectionFormFields" disabled class="space-y-6 opacity-50">

                            <div class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-6">

                                <div class="mb-5 flex items-center gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#effaf9] text-[#007b83]">
                                        👤
                                    </div>

                                    <div>

                                        <h2 class="text-base font-bold text-[#007b83] sm:text-lg">
                                            2. Identitas Pemohon Keberatan
                                        </h2>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Lengkapi identitas pemohon yang mengajukan keberatan.
                                        </p>

                                    </div>

                                </div>


                                <div class="grid gap-5 md:grid-cols-2">


                                    {{-- Nama --}}
                                    <div>

                                        <label for="applicant_name"
                                            class="mb-2 block text-xs font-semibold text-slate-700">

                                            Nama Lengkap Pemohon
                                            <span class="text-red-500">*</span>

                                        </label>

                                        <input
                                            type="text"
                                            id="applicant_name"
                                            name="applicant_name"
                                            value="{{ old('applicant_name') }}"
                                            required
                                            placeholder="Nama pemohon informasi"
                                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                                        >

                                    </div>


                                    {{-- Telepon --}}
                                    <div>

                                        <label for="applicant_phone"
                                            class="mb-2 block text-xs font-semibold text-slate-700">

                                            Nomor WhatsApp / Telepon Pemohon
                                            <span class="text-red-500">*</span>

                                        </label>

                                        <input
                                            type="tel"
                                            id="applicant_phone"
                                            name="applicant_phone"
                                            value="{{ old('applicant_phone') }}"
                                            placeholder="Masukkan nomor WhatsApp / telepon"
                                            inputmode="numeric"
                                            autocomplete="tel"
                                            required
                                            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-xs outline-none placeholder:text-slate-300 focus:border-[#16a39a] focus:ring-2 focus:ring-[#16a39a]/10"
                                        >
                                        <p id="phoneFeedback" class="mt-1.5 text-[11px]" aria-live="polite">
                                            <span class="text-slate-400">Masukkan nomor telepon menggunakan angka saja.</span>
                                        </p>

                                    </div>


                                    {{-- Alamat --}}
                                    <div class="md:col-span-2">

                                        <label for="applicant_address" class="mb-2 block text-xs font-semibold text-slate-700">

                                            Alamat Lengkap Pemohon
                                            <span class="text-red-500">*</span>

                                        </label>

                                        <textarea
                                            id="applicant_address"
                                            name="applicant_address"
                                            rows="3"
                                            required
                                            placeholder="Alamat lengkap pemohon"
                                            class="w-full resize-y rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                                        >{{ old('applicant_address') }}</textarea>

                                    </div>

                                </div>


                                {{-- KUASA --}}
                                <div class="mt-5 rounded-xl bg-slate-50 p-4 sm:p-5">

                                    <div class="mb-4">

                                        <h3 class="text-sm font-bold text-slate-700">
                                            Identitas Kuasa Pemohon
                                        </h3>

                                        <p class="mt-1 text-[11px] leading-5 text-slate-400">
                                            Kosongkan jika pengajuan keberatan dilakukan langsung oleh pemohon.
                                        </p>

                                    </div>


                                    <div class="grid gap-4 md:grid-cols-2">


                                        <div>

                                            <label for="representative_name"
                                                class="mb-2 block text-xs font-semibold text-slate-600">
                                                Nama Kuasa Pemohon
                                            </label>

                                            <input
                                                type="text"
                                                id="representative_name"
                                                name="representative_name"
                                                placeholder="Nama kuasa hukum / perwakilan"
                                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                                            >

                                        </div>


                                        <div>

                                            <label for="representative_phone"
                                                class="mb-2 block text-xs font-semibold text-slate-600">
                                                Nomor WhatsApp Kuasa
                                            </label>

                                            <input
                                                type="tel"
                                                id="representative_phone"
                                                name="representative_phone"
                                                placeholder="Nomor WhatsApp kuasa"
                                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                                            >

                                        </div>


                                        <div class="md:col-span-2">

                                            <label for="representative_address"
                                                class="mb-2 block text-xs font-semibold text-slate-600">
                                                Alamat Kuasa Pemohon
                                            </label>

                                            <textarea
                                                id="representative_address"
                                                name="representative_address"
                                                rows="2"
                                                placeholder="Alamat kuasa hukum / perwakilan"
                                                class="w-full resize-y rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                                            ></textarea>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- 3. ALASAN PENGAJUAN KEBERATAN --}}
                            {{-- ================================================= --}}

                            <div class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-6">

                                <div class="mb-5 flex items-center gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#effaf9] text-[#007b83]">
                                        ⚖
                                    </div>

                                    <div>

                                        <h2 class="text-base font-bold text-[#007b83] sm:text-lg">
                                            3. Alasan Pengajuan Keberatan
                                        </h2>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Pilih alasan yang sesuai dengan kondisi pelayanan informasi yang Anda alami.
                                        </p>

                                    </div>

                                </div>


                                <div id="objectionReasonsSection">

                                    <label class="mb-3 block text-xs font-semibold text-slate-700">

                                        Pilih Alasan Keberatan
                                        <span class="text-slate-400">
                                            (Bisa pilih lebih dari satu)
                                        </span>

                                        <span class="text-red-500">*</span>

                                    </label>


                                    <div class="space-y-3">

                                        <label class="flex cursor-pointer items-start gap-3">

                                            <input
                                                type="checkbox"
                                                name="objection_reasons[]"
                                                value="berkala"
                                                {{ in_array('berkala', old('objection_reasons', [])) ? 'checked' : '' }}
                                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-[#007b83] focus:ring-[#007b83]"
                                            >

                                            <span class="text-sm leading-5 text-slate-600">
                                                Permintaan informasi ditolak secara sepihak.
                                            </span>

                                        </label>


                                        <label class="flex cursor-pointer items-start gap-3">

                                            <input
                                                type="checkbox"
                                                name="objection_reasons[]"
                                                value="berkala"
                                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-[#007b83] focus:ring-[#007b83]"
                                            >

                                            <span class="text-sm leading-5 text-slate-600">
                                                Informasi berkala tidak disediakan atau tidak diperbarui.
                                            </span>

                                        </label>


                                        <label class="flex cursor-pointer items-start gap-3">

                                            <input
                                                type="checkbox"
                                                name="objection_reasons[]"
                                                value="tidak_ditanggapi"
                                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-[#007b83] focus:ring-[#007b83]"
                                            >

                                            <span class="text-sm leading-5 text-slate-600">
                                                Permintaan informasi tidak ditanggapi oleh petugas.
                                            </span>

                                        </label>


                                        <label class="flex cursor-pointer items-start gap-3">

                                            <input
                                                type="checkbox"
                                                name="objection_reasons[]"
                                                value="tidak_sesuai"
                                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-[#007b83] focus:ring-[#007b83]"
                                            >

                                            <span class="text-sm leading-5 text-slate-600">
                                                Informasi yang diberikan tidak sesuai dengan yang diminta.
                                            </span>

                                        </label>


                                        <label class="flex cursor-pointer items-start gap-3">

                                            <input
                                                type="checkbox"
                                                name="objection_reasons[]"
                                                value="tidak_dipenuhi"
                                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-[#007b83] focus:ring-[#007b83]"
                                            >

                                            <span class="text-sm leading-5 text-slate-600">
                                                Permintaan informasi tidak dipenuhi.
                                            </span>

                                        </label>


                                        <label class="flex cursor-pointer items-start gap-3">

                                            <input
                                                type="checkbox"
                                                name="objection_reasons[]"
                                                value="biaya"
                                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-[#007b83] focus:ring-[#007b83]"
                                            >

                                            <span class="text-sm leading-5 text-slate-600">
                                                Biaya salinan yang dibebankan tidak wajar atau melebihi ketentuan.
                                            </span>

                                        </label>


                                        <label class="flex cursor-pointer items-start gap-3">

                                            <input
                                                type="checkbox"
                                                name="objection_reasons[]"
                                                value="melewati_batas_waktu"
                                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-[#007b83] focus:ring-[#007b83]"
                                            >

                                            <span class="text-sm leading-5 text-slate-600">
                                                Penyampaian informasi melewati batas waktu pelayanan.
                                            </span>

                                        </label>

                                    </div>
                                        <p id="objectionReasonsError"
                                        class="hidden mt-3 text-xs font-medium text-red-600"
                                        role="alert">
                                            Silakan pilih minimal satu alasan pengajuan keberatan.
                                        </p>

                                        @error('objection_reasons')
                                            <p class="mt-3 text-xs font-medium text-red-600" role="alert">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                </div>


                            {{-- REKAM SUARA --}}
                                <div class="mt-6 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:p-5">

                                    <div class="flex items-start justify-between gap-4">

                                        <div>

                                            <h3 class="text-sm font-bold text-slate-700">
                                                🎙 Fitur Rekam Suara
                                                <span class="font-normal">
                                                    (Aksesibilitas Disabilitas)
                                                </span>
                                            </h3>

                                            <p class="mt-1 text-[11px] leading-5 text-slate-500">
                                                Apabila Anda penyandang disabilitas atau kesulitan mengetik,
                                                Anda dapat menggunakan fitur rekam suara untuk menjelaskan
                                                kronologi kasus keberatan.
                                            </p>

                                        </div>

                                        <span class="shrink-0 rounded-full bg-[#effaf9] px-2.5 py-1 text-[9px] font-semibold text-[#007b83]">
                                            Bantuan
                                        </span>

                                    </div>


                                    {{-- Tombol Rekam --}}
                                    <div class="mt-4 flex flex-wrap items-center gap-2">

                                        <button
                                            type="button"
                                            id="startObjectionRecordingBtn"
                                            class="inline-flex items-center gap-2 rounded-lg bg-red-500 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-red-600"
                                        >
                                            ● Mulai Rekam Suara
                                        </button>

                                        <button
                                            type="button"
                                            id="stopObjectionRecordingBtn"
                                            class="hidden inline-flex items-center gap-2 rounded-lg bg-slate-700 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-slate-800"
                                        >
                                            ■ Berhenti
                                        </button>

                                        <button
                                            type="button"
                                            id="retakeObjectionRecordingBtn"
                                            class="hidden inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50"
                                        >
                                            ↻ Rekam Ulang
                                        </button>

                                    </div>


                                    {{-- Status Rekaman --}}
                                    <div
                                        id="objectionRecordingStatus"
                                        class="mt-3 hidden text-xs text-slate-500"
                                    ></div>


                                    {{-- Preview Audio --}}
                                    <audio
                                        id="objectionAudioPreview"
                                        controls
                                        class="mt-4 hidden w-full"
                                    ></audio>


                                    {{-- File Audio --}}
                                    <input
                                        type="file"
                                        id="objectionVoiceRecordingInput"
                                        name="voice_recording"
                                        accept="audio/*"
                                        class="hidden"
                                    >

                                </div>


                                {{-- KRONOLOGI --}}
                                <div class="mt-6">

                                    <label for="objection_chronology"
                                        class="mb-2 block text-xs font-semibold text-slate-700">

                                        Kronologi Kasus Posisi Keberatan
                                        <span id="objectionChronologyRequiredMark" class="text-red-500">*</span>

                                    </label>

                                    <textarea
                                        id="objection_chronology"
                                        name="objection_chronology"
                                        rows="5"
                                        required
                                        placeholder="Uraikan secara runtut mengenai kronologi kasus dan alasan mengapa Anda mengajukan keberatan ini..."
                                        class="w-full resize-y rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                                    ></textarea>

                                </div>


                                {{-- SUBMIT --}}
                                <div class="mt-6 flex justify-end">

                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#007b83] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#006b72]"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            class="h-5 w-5"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 7h14"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m5 7-3 6h6L5 7Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19 7-3 6h6l-3-6Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 21h6"/>
                                        </svg>

                                        Kirim Keberatan PPID
                                    </button>

                                </div>

                            </div>
                        
                        </fieldset>
                        
                    </form>

                </div>


                {{-- ===================================================== --}}
                {{-- DISCLAIMER --}}
                {{-- ===================================================== --}}

                <div class="border-t border-slate-100 px-6 py-5 sm:px-8">

                    <p class="mx-auto max-w-3xl text-center text-[10px] leading-5 text-slate-400">

                        Pelayanan Keterbukaan Informasi Publik dikelola oleh
                        Tim PPID Pelaksana RSUD R.A.A. Tjokronegoro
                        Kabupaten Purworejo berdasarkan tata kelola
                        Good Hospital Governance.

                    </p>

                </div>


            </div>

        </div>

    </section>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // ==========================================
        // VALIDASI NOMOR TIKET PERMOHONAN INFORMASI
        // ==========================================

        const ticketInput = document.getElementById('ticket_number');
        const ticketFeedback = document.getElementById('ticketNumberFeedback');
        const objectionForm = ticketInput?.closest('form');
        const submitButton = objectionForm?.querySelector('button[type="submit"]');

        // Elemen formulir yang ditampilkan setelah tiket valid.
        const objectionFormFields = document.getElementById('objectionFormFields');
        const purposeFieldset = document.getElementById('purposeFieldset');

        let ticketCheckTimer = null;
        let ticketRequestController = null;
        let ticketIsValid = false;

        function showTicketFeedback(message, type) {
            if (!ticketFeedback) return;

            ticketFeedback.textContent = message;
            ticketFeedback.className =
                'mt-2 rounded-lg px-3 py-2 text-xs leading-5';

            if (type === 'success') {
                ticketFeedback.classList.add(
                    'border',
                    'border-emerald-200',
                    'bg-emerald-50',
                    'text-emerald-700'
                );
            } else if (type === 'error') {
                ticketFeedback.classList.add(
                    'border',
                    'border-red-200',
                    'bg-red-50',
                    'text-red-700'
                );
            } else {
                ticketFeedback.classList.add(
                    'border',
                    'border-slate-200',
                    'bg-slate-50',
                    'text-slate-500'
                );
            }

            ticketFeedback.classList.remove('hidden');
        }

        function updateSubmitButton() {
            if (submitButton) {
                submitButton.disabled = !ticketIsValid;
                submitButton.classList.toggle('opacity-50', !ticketIsValid);
                submitButton.classList.toggle('cursor-not-allowed', !ticketIsValid);
            }

            if (objectionFormFields) {
                objectionFormFields.disabled = !ticketIsValid;
                objectionFormFields.classList.toggle('opacity-50', !ticketIsValid);
            }

            if (purposeFieldset) {
                purposeFieldset.disabled = !ticketIsValid;
                purposeFieldset.classList.toggle('opacity-50', !ticketIsValid);
            }
        }

        async function checkTicket() {
            if (!ticketInput || !ticketFeedback) return;

            const ticketNumber = ticketInput.value.trim().toUpperCase();

            ticketIsValid = false;
            updateSubmitButton();

            if (!ticketNumber) {
                ticketFeedback.classList.add('hidden');
                return;
            }

            if (ticketRequestController) {
                ticketRequestController.abort();
            }

            ticketRequestController = new AbortController();

            showTicketFeedback(
                'Memeriksa nomor tiket...',
                'loading'
            );

            try {
                const url = new URL(
                    @json(route('ppid.objection.check-ticket')),
                    window.location.origin
                );

                url.searchParams.set('ticket_number', ticketNumber);

                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    },
                    signal: ticketRequestController.signal
                });

                if (!response.ok) {
                    throw new Error('Gagal memeriksa tiket.');
                }

                const result = await response.json();

                // Abaikan hasil jika input sudah berubah.
                if (ticketInput.value.trim().toUpperCase() !== ticketNumber) {
                    return;
                }

                ticketIsValid = result.valid === true;

                showTicketFeedback(
                    result.message,
                    ticketIsValid ? 'success' : 'error'
                );

                updateSubmitButton();

            } catch (error) {
                if (error.name === 'AbortError') {
                    return;
                }

                ticketIsValid = false;

                showTicketFeedback(
                    'Tiket belum dapat diperiksa. Coba lagi.',
                    'error'
                );

                updateSubmitButton();
            }
        }

        if (ticketInput && ticketFeedback && objectionForm) {

            ticketInput.addEventListener('input', function () {
                clearTimeout(ticketCheckTimer);

                // Input berubah, hasil verifikasi sebelumnya tidak berlaku.
                ticketIsValid = false;
                updateSubmitButton();

                const ticketNumber = ticketInput.value.trim();

                if (ticketRequestController) {
                    ticketRequestController.abort();
                }

                if (!ticketNumber) {
                    ticketFeedback.classList.add('hidden');
                    return;
                }

                showTicketFeedback(
                    'Menunggu pengecekan nomor tiket...',
                    'loading'
                );

                ticketCheckTimer = setTimeout(checkTicket, 450);
            });

            // Periksa kembali jika input terisi otomatis oleh browser.
            if (ticketInput.value.trim()) {
                checkTicket();
            } else {
                ticketFeedback.classList.add('hidden');
            }

            // Blokir pengiriman jika tiket belum terverifikasi.
            objectionForm.addEventListener('submit', function (event) {
                if (!ticketIsValid) {
                    event.preventDefault();

                    showTicketFeedback(
                        'Pastikan nomor tiket sudah terdaftar sebelum mengirim pengajuan.',
                        'error'
                    );

                    ticketInput.focus();
                }
            });

            updateSubmitButton();
        }


        // ==========================================
        // FITUR REKAM SUARA PENGAJUAN KEBERATAN
        // ==========================================

        const startBtn = document.getElementById('startObjectionRecordingBtn');
        const stopBtn = document.getElementById('stopObjectionRecordingBtn');
        const retakeBtn = document.getElementById('retakeObjectionRecordingBtn');

        const status = document.getElementById('objectionRecordingStatus');
        const audioPreview = document.getElementById('objectionAudioPreview');
        const audioInput = document.getElementById('objectionVoiceRecordingInput');
        const chronologyInput = document.getElementById('objection_chronology');
        const chronologyRequiredMark = document.getElementById('objectionChronologyRequiredMark');

        // Pastikan elemen rekam suara tersedia sebelum menjalankan fiturnya.
        if (
            startBtn &&
            stopBtn &&
            retakeBtn &&
            status &&
            audioPreview &&
            audioInput &&
            chronologyInput
        ) {

            function updateObjectionRequiredFields() {
                const hasRecording = audioInput.files.length > 0;

                chronologyInput.required = !hasRecording;

                if (chronologyRequiredMark) {
                    chronologyRequiredMark.classList.toggle(
                        'hidden',
                        hasRecording
                    );
                }
            }

            updateObjectionRequiredFields();

            let mediaRecorder = null;
            let audioChunks = [];
            let audioStream = null;
            let recordingTimer = null;
            let recordingSeconds = 0;

            function updateTimer() {
                const minutes = Math.floor(recordingSeconds / 60)
                    .toString()
                    .padStart(2, '0');

                const seconds = (recordingSeconds % 60)
                    .toString()
                    .padStart(2, '0');

                status.textContent =
                    `Sedang merekam... ${minutes}:${seconds}`;
            }

            startBtn.addEventListener('click', async function () {
                try {
                    if (
                        !navigator.mediaDevices ||
                        !navigator.mediaDevices.getUserMedia
                    ) {
                        alert(
                            'Browser Anda tidak mendukung fitur rekaman suara.'
                        );
                        return;
                    }

                    audioStream =
                        await navigator.mediaDevices.getUserMedia({
                            audio: true
                        });

                    const mimeType = MediaRecorder.isTypeSupported(
                        'audio/webm'
                    ) ? 'audio/webm' : '';

                    mediaRecorder = mimeType
                        ? new MediaRecorder(audioStream, {
                            mimeType: mimeType
                        })
                        : new MediaRecorder(audioStream);

                    audioChunks = [];

                    mediaRecorder.addEventListener(
                        'dataavailable',
                        function (event) {
                            if (event.data.size > 0) {
                                audioChunks.push(event.data);
                            }
                        }
                    );

                    mediaRecorder.addEventListener('stop', function () {
                        const audioBlob = new Blob(audioChunks, {
                            type: mediaRecorder.mimeType || 'audio/webm'
                        });

                        const audioUrl = URL.createObjectURL(audioBlob);

                        audioPreview.src = audioUrl;
                        audioPreview.classList.remove('hidden');

                        const audioFile = new File(
                            [audioBlob],
                            'rekaman-keberatan.webm',
                            {
                                type: audioBlob.type || 'audio/webm'
                            }
                        );

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(audioFile);
                        audioInput.files = dataTransfer.files;

                        updateObjectionRequiredFields();

                        if (audioStream) {
                            audioStream.getTracks().forEach(
                                function (track) {
                                    track.stop();
                                }
                            );

                            audioStream = null;
                        }

                        status.textContent =
                            'Rekaman selesai. Anda dapat memutar atau merekam ulang.';

                        retakeBtn.classList.remove('hidden');
                        startBtn.classList.add('hidden');
                        stopBtn.classList.add('hidden');
                    });

                    mediaRecorder.start();

                    recordingSeconds = 0;
                    updateTimer();

                    recordingTimer = setInterval(function () {
                        recordingSeconds++;
                        updateTimer();
                    }, 1000);

                    startBtn.classList.add('hidden');
                    stopBtn.classList.remove('hidden');
                    retakeBtn.classList.add('hidden');
                    audioPreview.classList.add('hidden');
                    status.classList.remove('hidden');

                } catch (error) {
                    console.error(error);

                    if (audioStream) {
                        audioStream.getTracks().forEach(
                            function (track) {
                                track.stop();
                            }
                        );

                        audioStream = null;
                    }

                    alert(
                        'Microphone tidak dapat digunakan. Silakan izinkan akses microphone pada browser.'
                    );
                }
            });

            stopBtn.addEventListener('click', function () {
                if (
                    mediaRecorder &&
                    mediaRecorder.state !== 'inactive'
                ) {
                    mediaRecorder.stop();
                }

                clearInterval(recordingTimer);
                stopBtn.classList.add('hidden');
            });

            retakeBtn.addEventListener('click', function () {
                audioInput.value = '';

                updateObjectionRequiredFields();

                audioPreview.pause();
                audioPreview.removeAttribute('src');
                audioPreview.load();
                audioPreview.classList.add('hidden');

                status.classList.add('hidden');
                retakeBtn.classList.add('hidden');
                startBtn.classList.remove('hidden');
            });
        }

    });
</script>

<script>
        document.addEventListener('DOMContentLoaded', function () {
        const phoneInput = document.getElementById('applicant_phone');

        if (!phoneInput) return;

        phoneInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const objectionForm = document.querySelector(
            'form[action="{{ route('ppid.request.objection.submit') }}"]'
        );

        const reasonsSection = document.getElementById(
            'objectionReasonsSection'
        );

        const errorMessage = document.getElementById(
            'objectionReasonsError'
        );

        if (!objectionForm || !reasonsSection || !errorMessage) {
            return;
        }

        const reasonCheckboxes = objectionForm.querySelectorAll(
            'input[name="objection_reasons[]"]'
        );

        function hasSelectedReason() {
            return objectionForm.querySelector(
                'input[name="objection_reasons[]"]:checked'
            ) !== null;
        }

        // Cegah form dikirim jika belum ada alasan yang dipilih.
        objectionForm.addEventListener('submit', function (event) {
            if (!hasSelectedReason()) {
                event.preventDefault();

                errorMessage.classList.remove('hidden');

                // Gulir ke bagian alasan keberatan.
                reasonsSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                return;
            }

            errorMessage.classList.add('hidden');
        }, true);

        // Hilangkan pesan ketika pengguna memilih salah satu alasan.
        reasonCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                if (hasSelectedReason()) {
                    errorMessage.classList.add('hidden');
                }
            });
        });
    });
</script>

</x-layouts.app>