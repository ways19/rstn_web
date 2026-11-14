<x-layouts.app
    title="{{ $page->title }} — RSUD R.A.A. Tjokronegoro"
    meta-description="{{ $page->description }}"
>

    {{-- Header --}}
    <x-page-header
        :title="$page->title"
        :description="$page->description"
    />
    
    {{-- =========================================================
        SUBMENU PERMOHONAN INFORMASI
    ========================================================== --}}
    <x-submenus.ppid-request active="information" />


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
        KONTEN UTAMA
        CMS + FORM DIBUNGKUS DALAM SATU CONTAINER
    ========================================================== --}}
    <section class="bg-slate-50 pb-16 pt-2">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- SATU CARD BESAR --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">


                {{-- =================================================
                    KONTEN DARI CMS / SUMMERNOTE
                    Semua informasi yang sifatnya bisa berubah
                    dikelola dari CMS.
                ================================================== --}}
                <div class="p-6 sm:p-8">

                    {!! $page->content !!}

                </div>


                {{-- =================================================
                    FORM PERMOHONAN INFORMASI
                    Bagian ini tetap di Blade karena fungsional.
                ================================================== --}}
                <div class="border-t border-slate-200 bg-slate-50 px-4 py-6 sm:px-6 sm:py-8">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Permohonan belum dapat dikirim.</strong>

                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                            <p>Field yang gagal divalidasi:</p>
                            <ul>
                                @foreach ($errors->keys() as $field)
                                    <li>{{ $field }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                            <p class="text-sm font-semibold text-emerald-700">
                                {{ session('success') }}
                            </p>
                        </div>
                    @endif

                        <form
                            method="POST"
                            action="{{ route('ppid.request.information.submit') }}"
                            enctype="multipart/form-data"
                            class="w-full space-y-5"
                        >

                        @csrf


                        {{-- =========================================
                            SECTION 1 — IDENTITAS PEMOHON
                        ========================================== --}}
                        <section
                            class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm"
                        >

                            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                                <div class="flex items-start gap-3">

                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#effaf9] text-sm font-bold text-[#007b83]"
                                    >
                                        1
                                    </div>

                                    <div>

                                        <h2 class="text-sm font-bold text-slate-800 sm:text-base">
                                            Identitas Pemohon
                                        </h2>

                                        <p class="mt-0.5 text-[11px] text-slate-400">
                                            Lengkapi data diri resmi Anda sesuai identitas kependudukan.
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="space-y-4 px-5 py-5 sm:px-6">

                                {{-- Kategori + NIK --}}
                                <div class="grid gap-4 sm:grid-cols-2">

                                    <div>

                                        <label
                                            for="kategori_pemohon"
                                            class="mb-1.5 block text-[11px] font-semibold text-slate-600"
                                        >
                                            Kategori Pemohon
                                            <span class="text-red-500">*</span>
                                        </label>

                                        <select
                                            id="kategori_pemohon"
                                            name="kategori_pemohon"
                                            required
                                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-xs text-slate-500 outline-none transition focus:border-[#16a39a] focus:ring-2 focus:ring-[#16a39a]/10"
                                        >
                                            <option value="">
                                                Pilih Kategori Pemohon
                                            </option>

                                            <option value="Perorangan">
                                                Perorangan
                                            </option>

                                            <option value="Badan Hukum">
                                                Badan Hukum
                                            </option>

                                            <option value="Organisasi">
                                                Organisasi
                                            </option>

                                            <option value="Kelompok Masyarakat">
                                                Kelompok Masyarakat
                                            </option>

                                            <option value="Lainnya">
                                                Lainnya
                                            </option>

                                        </select>

                                    </div>


                                    <div>

                                        <label
                                            for="nik"
                                            class="mb-1.5 block text-[11px] font-semibold text-slate-600"
                                        >
                                            Nomor Induk Kependudukan (NIK)
                                            <span class="text-red-500">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            id="nik"
                                            name="nik"
                                            value="{{ old('nik') }}"
                                            placeholder="Masukkan 16 digit NIK"
                                            maxlength="16"
                                            inputmode="numeric"
                                            pattern="[0-9]{16}"
                                            autocomplete="off"
                                            required
                                            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-xs outline-none placeholder:text-slate-300 focus:border-[#16a39a] focus:ring-2 focus:ring-[#16a39a]/10"
                                        >

                                        <p
                                            id="nikFeedback"
                                            class="mt-1.5 text-[11px]"
                                            aria-live="polite"
                                        >
                                            <span class="text-slate-400">
                                                NIK harus terdiri dari 16 digit angka.
                                            </span>
                                        </p>

                                    </div>

                                </div>


                               
                                {{-- Nama + WhatsApp --}}
                                <div class="grid gap-4 sm:grid-cols-2">

                                    <div>
                                        <label
                                            for="applicant_name"
                                            class="mb-1.5 block text-[11px] font-semibold text-slate-600"
                                        >
                                            Nama Lengkap Pemohon
                                            <span class="text-red-500">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            id="applicant_name"
                                            name="applicant_name"
                                            value="{{ old('applicant_name') }}"
                                            placeholder="Nama lengkap sesuai KTP"
                                            required
                                            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-xs outline-none placeholder:text-slate-300 focus:border-[#16a39a] focus:ring-2 focus:ring-[#16a39a]/10"
                                        >
                                    </div>

                                    <div>
                                        <label
                                            for="applicant_phone"
                                            class="mb-1.5 block text-[11px] font-semibold text-slate-600"
                                        >
                                            Nomor WhatsApp / Telepon
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

                                </div>

                                {{-- Alamat --}}
                                <div>
                                    <label
                                        for="applicant_address"
                                        class="mb-1.5 block text-[11px] font-semibold text-slate-600"
                                    >
                                        Alamat Lengkap Pemohon
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <textarea
                                        id="applicant_address"
                                        name="applicant_address"
                                        rows="3"
                                        required
                                        placeholder="Tuliskan alamat domisili lengkap beserta RT/RW, Kelurahan/Desa, dan Kecamatan."
                                        class="w-full resize-none rounded-lg border border-slate-200 px-3 py-2.5 text-xs outline-none placeholder:text-slate-300 focus:border-[#16a39a] focus:ring-2 focus:ring-[#16a39a]/10"
                                    >{{ old('applicant_address') }}</textarea>
                                </div>


                                {{-- Email --}}
                                <div>

                                    <label
                                        for="email"
                                        class="mb-1.5 block text-[11px] font-semibold text-slate-600"
                                    >
                                        Email Aktif
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        required
                                        placeholder="Contoh: email@anda.com"
                                        class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-xs outline-none placeholder:text-slate-300 focus:border-[#16a39a] focus:ring-2 focus:ring-[#16a39a]/10"
                                    >

                                </div>


                               {{-- =========================================================
                                    UPLOAD IDENTITAS
                                ========================================================= --}}
                                <div>

                                    <label
                                        for="identity_file"
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                    >
                                        Unggah Scan KTP / SIM / Tanda Pengenal
                                        <span class="text-red-500">*</span>
                                    </label>


                                    <label
                                        for="identity_file"
                                        id="upload-area"
                                        class="group flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-8 text-center transition hover:border-[#007b83] hover:bg-[#f5fbfb]"
                                    >

                                        {{-- =================================================
                                            TAMPILAN AWAL
                                        ================================================== --}}
                                        <div id="upload-placeholder">

                                            {{-- ICON UPLOAD --}}
                                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#effaf9] text-[#007b83]">

                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="h-6 w-6"
                                                >
                                                    <path d="M12 16V4"/>
                                                    <path d="m7 9 5-5 5 5"/>
                                                    <path d="M5 20h14"/>
                                                </svg>

                                            </div>


                                            <p class="mt-3 text-sm font-semibold text-slate-700">
                                                Klik untuk unggah berkas identitas atau tarik ke sini
                                            </p>


                                            <p class="mt-1 text-xs text-slate-400">
                                                Format yang didukung: JPG, PNG, PDF (Maksimal 5MB)
                                            </p>

                                        </div>


                                        {{-- =================================================
                                            TAMPILAN SETELAH FILE DIPILIH
                                        ================================================== --}}
                                        <div
                                            id="file-preview"
                                            class="hidden w-full"
                                        >

                                            <div class="mx-auto flex max-w-md items-center gap-4 rounded-xl border border-slate-200 bg-white p-4 text-left shadow-sm">

                                                {{-- ICON DOKUMEN --}}
                                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-[#effaf9] text-[#007b83]">

                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="h-6 w-6"
                                                    >
                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                        <path d="M14 2v6h6"/>
                                                        <path d="M8 13h8"/>
                                                        <path d="M8 17h6"/>
                                                    </svg>

                                                </div>


                                                {{-- INFORMASI FILE --}}
                                                <div class="min-w-0 flex-1">

                                                    <p
                                                        id="file-name"
                                                        class="truncate text-sm font-semibold text-slate-800"
                                                    >
                                                        Nama file
                                                    </p>

                                                    <p
                                                        id="file-info"
                                                        class="mt-1 text-xs text-slate-400"
                                                    >
                                                        PDF • 0 KB
                                                    </p>

                                                </div>


                                                {{-- STATUS BERHASIL --}}
                                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">

                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="h-5 w-5"
                                                    >
                                                        <path d="m5 12 4 4L19 6"/>
                                                    </svg>

                                                </div>

                                            </div>


                                            <p class="mt-3 text-xs text-slate-400">
                                                Klik untuk mengganti berkas
                                            </p>

                                        </div>


                                        {{-- INPUT FILE --}}
                                        <input
                                            type="file"
                                            id="identity_file"
                                            name="identity_file"
                                            accept=".jpg,.jpeg,.png,.pdf"
                                            class="hidden"
                                        >
                                        <p id="identityFileError" class="hidden mt-2 text-xs text-red-600" aria-live="polite">
                                            Berkas identitas wajib diunggah.
                                        </p>

                                    </label>

                                </div>

                        {{-- =========================================
                            SECTION 2 — RINCIAN PERMINTAAN
                        ========================================== --}}
                        <section
                            class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm"
                        >

                            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                                <div class="flex items-start gap-3">

                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#effaf9] text-sm font-bold text-[#007b83]"
                                    >
                                        2
                                    </div>

                                    <div>

                                        <h2 class="text-sm font-bold text-slate-800 sm:text-base">
                                            Rincian Permintaan Informasi
                                        </h2>

                                        <p class="mt-0.5 text-[11px] text-slate-400">
                                            Deskripsikan data publik yang ingin diperoleh dan tujuan penggunaannya.
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="space-y-4 px-5 py-5 sm:px-6">


                               {{-- Layanan Suara --}}
                                <div
                                    class="rounded-lg border border-[#f2dca9] bg-[#fffaf0] px-4 py-3"
                                >

                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                        <div class="flex items-start gap-3">

                                            <div
                                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#fff0d2] text-[#b66a00]"
                                            >
                                                🎙
                                            </div>

                                            <div>

                                                <div class="flex flex-wrap items-center gap-2">

                                                    <p class="text-xs font-bold text-slate-700">
                                                        Layanan Suara Permohonan
                                                    </p>

                                                    <span
                                                        class="rounded-full bg-[#f6d99b] px-2 py-0.5 text-[9px] font-bold text-[#9a5b00]"
                                                    >
                                                        Aksesibilitas
                                                    </span>

                                                </div>

                                                <p class="mt-1 text-[10px] leading-4 text-slate-500">
                                                    Penyandang disabilitas netra/fisik atau pemohon yang
                                                    kesulitan mengetik dapat merekam suaranya langsung.
                                                </p>

                                            </div>

                                        </div>


                                        {{-- Area kontrol rekaman --}}
                                        <div class="flex shrink-0 flex-col items-end gap-2">

                                            {{-- Tombol mulai --}}
                                            <button
                                                type="button"
                                                id="startRecordingBtn"
                                                class="inline-flex items-center justify-center rounded-lg bg-[#a95108] px-3 py-2 text-[10px] font-semibold text-white transition hover:bg-[#914708]"
                                            >
                                                🎙 Mulai Rekam Suara
                                            </button>


                                            {{-- Status rekaman --}}
                                            <div
                                                id="recordingStatus"
                                                class="hidden text-[10px] font-medium text-red-600"
                                            >
                                                🔴 Sedang merekam...
                                                <span id="recordingTimer">00:00</span>
                                            </div>


                                            {{-- Tombol berhenti --}}
                                            <button
                                                type="button"
                                                id="stopRecordingBtn"
                                                class="hidden inline-flex items-center justify-center rounded-lg bg-red-600 px-3 py-2 text-[10px] font-semibold text-white transition hover:bg-red-700"
                                            >
                                                ■ Berhenti Merekam
                                            </button>

                                        </div>

                                    </div>


                                    {{-- Hasil rekaman --}}
                                    <div
                                        id="recordingResult"
                                        class="hidden mt-3 border-t border-[#f2dca9] pt-3"
                                    >

                                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                            <div>
                                                <p class="text-[10px] font-semibold text-slate-700">
                                                    ✓ Rekaman siap
                                                </p>

                                                <p class="text-[9px] text-slate-500">
                                                    Dengarkan rekaman sebelum mengirim permohonan.
                                                </p>
                                            </div>

                                            <audio
                                                id="audioPreview"
                                                controls
                                                class="h-8 w-full sm:w-64"
                                            ></audio>

                                        </div>


                                        <button
                                            type="button"
                                            id="retakeRecordingBtn"
                                            class="mt-2 text-[10px] font-semibold text-[#a95108] hover:underline"
                                        >
                                            ↻ Rekam Ulang
                                        </button>

                                    </div>


                                    {{-- File audio hasil rekaman --}}
                                    <input
                                        type="file"
                                        id="voiceRecordingInput"
                                        name="voice_recording"
                                        accept="audio/*"
                                        class="hidden"
                                    >

                                </div>


                                <script>
                                document.addEventListener('DOMContentLoaded', function () {

                                    const startBtn = document.getElementById('startRecordingBtn');
                                    const stopBtn = document.getElementById('stopRecordingBtn');
                                    const retakeBtn = document.getElementById('retakeRecordingBtn');

                                    const status = document.getElementById('recordingStatus');
                                    const timer = document.getElementById('recordingTimer');

                                    const result = document.getElementById('recordingResult');
                                    const audioPreview = document.getElementById('audioPreview');
                                    const voiceInput = document.getElementById('voiceRecordingInput');

                                    let mediaRecorder = null;
                                    let audioChunks = [];
                                    let audioStream = null;
                                    let timerInterval = null;
                                    let recordingSeconds = 0;

                                    const rincianInput = document.getElementById('rincian_informasi');
                                    const tujuanInput = document.getElementById('tujuan');

                                    const rincianRequiredMark = document.getElementById('rincianRequiredMark');
                                    const tujuanRequiredMark = document.getElementById('tujuanRequiredMark');

                                    function updateVoiceRequiredFields() {
                                        const hasRecording = voiceInput.files.length > 0;

                                        rincianInput.required = !hasRecording;
                                        tujuanInput.required = !hasRecording;

                                        if (rincianRequiredMark) {
                                            rincianRequiredMark.classList.toggle('hidden', hasRecording);
                                        }

                                        if (tujuanRequiredMark) {
                                            tujuanRequiredMark.classList.toggle('hidden', hasRecording);
                                        }
                                    }

                                    updateVoiceRequiredFields();


                                    // Mulai rekaman
                                    startBtn.addEventListener('click', async function () {

                                        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                                            alert('Browser Anda tidak mendukung fitur rekam suara.');
                                            return;
                                        }

                                        if (!window.MediaRecorder) {
                                            alert('Browser Anda tidak mendukung perekaman suara.');
                                            return;
                                        }

                                        try {

                                            audioStream = await navigator.mediaDevices.getUserMedia({
                                                audio: true
                                            });

                                            audioChunks = [];

                                            mediaRecorder = new MediaRecorder(audioStream);

                                            mediaRecorder.ondataavailable = function (event) {

                                                if (event.data.size > 0) {
                                                    audioChunks.push(event.data);
                                                }

                                            };

                                            mediaRecorder.onstop = function () {

                                                const audioBlob = new Blob(
                                                    audioChunks,
                                                    {
                                                        type: mediaRecorder.mimeType || 'audio/webm'
                                                    }
                                                );

                                                const audioUrl = URL.createObjectURL(audioBlob);

                                                audioPreview.src = audioUrl;

                                                /*
                                                * Masukkan hasil rekaman ke input file
                                                * agar nantinya ikut terkirim bersama form.
                                                */
                                                const file = new File(
                                                    [audioBlob],
                                                    'rekaman-permohonan.webm',
                                                    {
                                                        type: audioBlob.type
                                                    }
                                                );

                                                const dataTransfer = new DataTransfer();

                                                dataTransfer.items.add(file);

                                                voiceInput.files = dataTransfer.files;

                                                // Perbarui status wajib isi setelah rekaman tersedia
                                                updateVoiceRequiredFields();

                                                result.classList.remove('hidden');

                                            };

                                            mediaRecorder.start();

                                            startBtn.classList.add('hidden');
                                            stopBtn.classList.remove('hidden');

                                            status.classList.remove('hidden');

                                            recordingSeconds = 0;
                                            timer.textContent = '00:00';


                                            timerInterval = setInterval(function () {

                                                recordingSeconds++;

                                                const minutes = Math.floor(recordingSeconds / 60)
                                                    .toString()
                                                    .padStart(2, '0');

                                                const seconds = (recordingSeconds % 60)
                                                    .toString()
                                                    .padStart(2, '0');

                                                timer.textContent = `${minutes}:${seconds}`;

                                            }, 1000);


                                        } catch (error) {

                                            console.error(error);

                                            if (error.name === 'NotAllowedError') {

                                                alert(
                                                    'Akses mikrofon ditolak. Silakan izinkan penggunaan mikrofon pada browser.'
                                                );

                                            } else {

                                                alert(
                                                    'Mikrofon tidak dapat digunakan. Pastikan perangkat memiliki mikrofon.'
                                                );

                                            }

                                        }

                                    });


                                    // Berhenti rekaman
                                    stopBtn.addEventListener('click', function () {

                                        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                                            mediaRecorder.stop();
                                        }

                                        if (audioStream) {

                                            audioStream.getTracks().forEach(function (track) {
                                                track.stop();
                                            });

                                        }

                                        clearInterval(timerInterval);

                                        stopBtn.classList.add('hidden');
                                        status.classList.add('hidden');

                                        startBtn.classList.remove('hidden');

                                    });


                                    // Rekam ulang
                                    retakeBtn.addEventListener('click', function () {

                                        audioPreview.pause();

                                        audioPreview.removeAttribute('src');

                                        voiceInput.value = '';

                                        updateVoiceRequiredFields();

                                        result.classList.add('hidden');

                                        startBtn.classList.remove('hidden');

                                        recordingSeconds = 0;
                                        timer.textContent = '00:00';

                                    });

                                });
                                </script>


                                {{-- Rincian Informasi --}}
                                <div>

                                    <label
                                        for="rincian_informasi"
                                        class="mb-1.5 block text-[11px] font-semibold text-slate-600"
                                    >
                                        Rincian Informasi Yang Dibutuhkan
                                        <span id="rincianRequiredMark" class="text-red-500">*</span>
                                    </label>

                                    <textarea
                                        id="rincian_informasi"
                                        name="rincian_informasi"
                                        rows="4"
                                        placeholder="Tuliskan secara jelas, spesifik dan mendetail data atau dokumen informasi publik apa saja yang Anda butuhkan dari RSUD R.A.A. Tjokronegoro..."
                                        class="w-full resize-none rounded-lg border border-slate-200 px-3 py-2.5 text-xs outline-none placeholder:text-slate-300 focus:border-[#16a39a] focus:ring-2 focus:ring-[#16a39a]/10"
                                    ></textarea>

                                </div>


                                {{-- Tujuan --}}
                                <div>

                                    <label
                                        for="tujuan"
                                        class="mb-1.5 block text-[11px] font-semibold text-slate-600"
                                    >
                                        Tujuan Penggunaan Informasi
                                         <span id="tujuanRequiredMark" class="text-red-500">*</span>
                                    </label>

                                        <textarea
                                            id="tujuan"
                                            name="tujuan"
                                            rows="3"
                                            placeholder="Jelaskan secara singkat tujuan penggunaan informasi yang diminta (contoh: penelitian skripsi akademik, kajian kebijakan publik, referensi tesis, dsb.)."
                                            class="w-full resize-none rounded-lg border border-slate-200 px-3 py-2.5 text-xs outline-none placeholder:text-slate-300 focus:border-[#16a39a] focus:ring-2 focus:ring-[#16a39a]/10"
                                        ></textarea>

                                </div>


                                {{-- Cara Memperoleh + Pengiriman --}}
                                <div class="grid gap-4 sm:grid-cols-2">

                                    <div>

                                        <label
                                            for="cara_memperoleh"
                                            class="mb-1.5 block text-[11px] font-semibold text-slate-600"
                                        >
                                            Cara Memperoleh Informasi
                                            <span class="font-normal text-slate-400">(Opsional)</span>
                                        </label>

                                            <select
                                                id="cara_memperoleh"
                                                name="cara_memperoleh"
                                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-xs text-slate-500 outline-none focus:border-[#16a39a] focus:ring-2 focus:ring-[#16a39a]/10"
                                            >
                                                <option value="">Pilih Cara Memperoleh</option>
                                                <option value="Melihat / membaca">Melihat / membaca</option>
                                                <option value="Mendengarkan">Mendengarkan</option>
                                                <option value="Salinan dokumen">Salinan dokumen</option>
                                            </select>

                                    </div>


                                    <div>

                                        <label
                                            for="cara_pengiriman"
                                            class="mb-1.5 block text-[11px] font-semibold text-slate-600"
                                        >
                                            Cara Mengirimkan Salinan Informasi
                                            <span class="text-red-500">*</span>
                                        </label>

                                        <select
                                            id="cara_pengiriman"
                                            name="cara_pengiriman"
                                            required
                                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-xs text-slate-500 outline-none focus:border-[#16a39a] focus:ring-2 focus:ring-[#16a39a]/10"
                                        >

                                            <option value="">
                                                Pilih Cara Pengiriman Salinan
                                            </option>

                                            <option value="Email">
                                                Email
                                            </option>

                                            <option value="WhatsApp">
                                                WhatsApp
                                            </option>

                                            <option value="Diambil langsung">
                                                Diambil langsung
                                            </option>

                                        </select>

                                    </div>

                                </div>

                            </div>


                            {{-- Confirmation --}}
                            <div class="border-t border-slate-100 bg-slate-50 px-5 py-5 sm:px-6">

                                <label class="flex cursor-pointer items-start gap-3">

                                    <input
                                        type="checkbox"
                                        name="persetujuan"
                                        value="1"
                                        required
                                        class="mt-0.5 h-4 w-4 rounded border-slate-300 text-[#007b83] focus:ring-[#16a39a]"
                                    >

                                    <span class="text-[11px] leading-5 text-slate-500">
                                        Saya menyatakan bahwa seluruh data dan informasi yang saya sampaikan
                                        adalah benar dan dapat dipertanggungjawabkan sesuai hukum yang berlaku
                                        di Republik Indonesia.
                                    </span>

                                </label>


                                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                    <p class="text-[10px] text-slate-400">
                                        🔒 Data pribadi dijamin kerahasiaannya oleh PPID RSUD.
                                    </p>

                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#007b83] px-5 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-[#006b72]"
                                    >
                                        ▶
                                        Kirim Permohonan Informasi
                                    </button>

                                </div>

                            </div>

                        </section>

                    </form>

                </div>


                {{-- =================================================
                    DISCLAIMER
                    Bisa juga dipindahkan ke CMS kalau nantinya
                    ingin mudah diubah.
                ================================================== --}}
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

            const input = document.getElementById('identity_file');
            const uploadArea = document.getElementById('upload-area');
            const uploadPlaceholder = document.getElementById('upload-placeholder');
            const filePreview = document.getElementById('file-preview');
            const fileName = document.getElementById('file-name');
            const fileInfo = document.getElementById('file-info');

            if (!input || !uploadArea) {
                return;
            }


            // =========================================================
            // TAMPILKAN FILE
            // =========================================================
            function showFile(file) {

                // Validasi format
                const allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'application/pdf'
                ];

                if (!allowedTypes.includes(file.type)) {

                    alert('Format file tidak didukung. Silakan pilih JPG, PNG, atau PDF.');

                    input.value = '';

                    return;
                }


                // Validasi ukuran maksimal 5 MB
                if (file.size > 5 * 1024 * 1024) {

                    alert('Ukuran file maksimal 5MB.');

                    input.value = '';

                    return;
                }


                // Nama file
                fileName.textContent = file.name;


                // Format file
                const extension = file.name
                    .split('.')
                    .pop()
                    .toUpperCase();


                // Ukuran file
                const sizeKB = Math.round(file.size / 1024);

                let sizeText;

                if (sizeKB >= 1024) {

                    sizeText = (sizeKB / 1024).toFixed(1) + ' MB';

                } else {

                    sizeText = sizeKB + ' KB';

                }


                fileInfo.textContent = extension + ' • ' + sizeText;


                // Sembunyikan tampilan awal
                uploadPlaceholder.classList.add('hidden');


                // Tampilkan file
                filePreview.classList.remove('hidden');


                // Ubah tampilan kotak
                uploadArea.classList.remove(
                    'border-slate-300',
                    'bg-slate-50'
                );

                uploadArea.classList.add(
                    'border-[#007b83]',
                    'bg-[#f5fbfb]'
                );

            }


            // =========================================================
            // PILIH FILE DARI FILE EXPLORER
            // =========================================================
            input.addEventListener('change', function () {

                if (this.files && this.files.length > 0) {

                    showFile(this.files[0]);

                }

            });


            // =========================================================
            // DRAG & DROP
            // =========================================================
            uploadArea.addEventListener('dragover', function (event) {

                event.preventDefault();

                uploadArea.classList.remove(
                    'border-slate-300',
                    'bg-slate-50'
                );

                uploadArea.classList.add(
                    'border-[#007b83]',
                    'bg-[#f5fbfb]'
                );

            });


            uploadArea.addEventListener('dragleave', function () {

                uploadArea.classList.remove(
                    'border-[#007b83]',
                    'bg-[#f5fbfb]'
                );

                uploadArea.classList.add(
                    'border-slate-300',
                    'bg-slate-50'
                );

            });


            uploadArea.addEventListener('drop', function (event) {

                event.preventDefault();

                const files = event.dataTransfer.files;

                if (!files || !files.length) {
                    return;
                }


                const file = files[0];


                // Validasi format
                const allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'application/pdf'
                ];

                if (!allowedTypes.includes(file.type)) {

                    alert('Format file tidak didukung. Silakan pilih JPG, PNG, atau PDF.');

                    return;
                }


                // Validasi ukuran
                if (file.size > 5 * 1024 * 1024) {

                    alert('Ukuran file maksimal 5MB.');

                    return;
                }


                // Masukkan file hasil drag & drop ke input
                const dataTransfer = new DataTransfer();

                dataTransfer.items.add(file);

                input.files = dataTransfer.files;


                // Tampilkan preview
                showFile(file);

            });

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nikInput = document.getElementById('nik');
            const nikFeedback = document.getElementById('nikFeedback');

            if (!nikInput || !nikFeedback) {
                return;
            }

            function validateNik() {
                // Hanya mempertahankan angka
                const originalValue = nikInput.value;
                const numericValue = originalValue.replace(/\D/g, '').slice(0, 16);

                if (originalValue !== numericValue) {
                    nikInput.value = numericValue;
                }

                const nik = nikInput.value;

                nikInput.classList.remove(
                    'border-red-500',
                    'border-emerald-500'
                );

                if (nik.length === 0) {
                    nikFeedback.innerHTML = `
                        <span class="text-slate-400">
                            NIK harus terdiri dari 16 digit angka.
                        </span>
                    `;
                    return;
                }

                if (nik.length < 16) {
                    nikInput.classList.add('border-red-500');

                    nikFeedback.innerHTML = `
                        <span class="text-red-600">
                            NIK belum lengkap. Masukkan ${16 - nik.length} digit lagi.
                        </span>
                    `;
                    return;
                }

                nikInput.classList.add('border-emerald-500');

                nikFeedback.innerHTML = `
                    <span class="font-medium text-emerald-600">
                        ✓ Format NIK sudah sesuai (16 digit).
                    </span>
                `;
            }

            nikInput.addEventListener('input', validateNik);

            // Validasi juga ketika halaman dimuat ulang dengan old input
            validateNik();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const phoneInput = document.getElementById('applicant_phone');
            const phoneFeedback = document.getElementById('phoneFeedback');

            if (!phoneInput || !phoneFeedback) return;

            function validatePhone() {
                const originalValue = phoneInput.value;
                const numericValue = originalValue.replace(/\D/g, '');

                if (originalValue !== numericValue) {
                    phoneInput.value = numericValue;
                }

                phoneInput.classList.remove('border-red-500', 'border-emerald-500');

                if (numericValue.length === 0) {
                    phoneFeedback.innerHTML =
                        '<span class="text-slate-400">Masukkan nomor telepon menggunakan angka saja.</span>';
                    return;
                }

                phoneInput.classList.add('border-emerald-500');
                phoneFeedback.innerHTML =
                    '<span class="font-medium text-emerald-600">✓ Nomor hanya berisi angka.</span>';
            }

            phoneInput.addEventListener('input', validatePhone);
            validatePhone();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const identityInput = document.getElementById('identity_file');
            const identityError = document.getElementById('identityFileError');

            if (!identityInput || !identityError) return;

            const form = identityInput.closest('form');

            if (!form) return;

            form.addEventListener('submit', function (event) {
                if (!identityInput.files || identityInput.files.length === 0) {
                    event.preventDefault();

                    identityError.classList.remove('hidden');

                    const uploadSection = identityInput.closest('.upload-area')
                        || identityInput.parentElement;

                    uploadSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                } else {
                    identityError.classList.add('hidden');
                }
            });

            identityInput.addEventListener('change', function () {
                if (identityInput.files.length > 0) {
                    identityError.classList.add('hidden');
                }
            });
        });
    </script>

</x-layouts.app>