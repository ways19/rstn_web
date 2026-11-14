<x-layouts.app :title="'Tahap 3 • Status & Hasil Konfirmasi — RSUD R.A.A. Tjokronegoro'">

    @push('styles')
        @vite(['resources/css/pages/diklat-registration.css'])
    @endpush

    <x-page-header
        title="Pendaftaran Program Diklat"
        description="Ikuti tahapan pendaftaran sampai pengajuan berhasil dikirim."
    />

    <main
        id="registration-content"
        class="diklat-registration mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8"
    >
        <div class="mb-6">
            <a
                href="{{ url('/informasi/pendidikan-pelatihan') }}"
                class="diklat-registration__back"
            >
                ← Kembali ke Pendidikan &amp; Pelatihan
            </a>
        </div>

        @if (session('info'))
            <div class="mb-6 rounded-2xl border border-sky-200 bg-sky-50 p-4 text-xs text-sky-800">
                <strong>Informasi:</strong> {{ session('info') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-xs text-emerald-800">
                <strong>Sukses:</strong> {{ session('success') }}
            </div>
        @endif

        {{-- INDIKATOR TIGA TAHAPAN (TAHAP 3 SEDANG BERLANGSUNG/SELESAI) --}}
        <nav class="diklat-status-progress mb-8" aria-label="Tahapan pendaftaran">
            @foreach ([
                'Formulir Pendaftaran',
                'Resume Pendaftaran',
                'Status & Hasil Konfirmasi',
            ] as $index => $label)
                @php
                    $stepNumber = $index + 1;
                    $isComplete = $stepNumber < 3;
                    $isCurrentStep = $stepNumber === 3;
                @endphp

                <div
                    class="diklat-status-progress__step
                        {{ $isComplete ? 'is-complete' : '' }}
                        {{ $isCurrentStep ? 'is-current' : '' }}"
                    data-progress="{{ $stepNumber }}"
                >
                    <span class="diklat-status-progress__number">
                        {{ $isComplete ? '✓' : $stepNumber }}
                    </span>

                    <div class="diklat-status-progress__step-body">
                        <strong>{{ $stepNumber }}. {{ $label }}</strong>
                        <small>
                            @if ($isComplete)
                                Telah selesai
                            @elseif ($isCurrentStep)
                                Sedang berlangsung
                            @else
                                Belum dimulai
                            @endif
                        </small>
                    </div>
                </div>

                @if (!$loop->last)
                    <div class="diklat-status-progress__arrow {{ $stepNumber < 3 ? 'is-passed' : '' }}" aria-hidden="true" data-arrow-after="{{ $stepNumber }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                @endif
            @endforeach
        </nav>

        {{-- TAHAP 3: KARTU KONFIRMASI & TANDA TERIMA --}}
        <section class="diklat-registration__card">
            {{-- INFORMASI PROGRAM --}}
            <div class="diklat-registration__program">
                <span class="diklat-registration__program-label">
                    TAHAP 4 • HASIL &amp; BUKTI PENDAFTARAN
                </span>

                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mt-1">
                    {{ $registration->program?->title ?? $registration->program?->name ?? 'Program Diklat' }}
                </h2>

                <p class="text-xs text-slate-500 mt-1">
                    Kategori: <strong>{{ ucfirst($registration->program?->category ?? 'Pendidikan') }}</strong>
                </p>
            </div>

            {{-- NOTIFIKASI BERHASIL --}}
            <div class="rounded-2xl bg-teal-50 border border-teal-200 p-4.5 my-6 flex items-start gap-3.5">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-teal-600 text-white font-bold text-sm shadow-sm">
                    ✓
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-teal-900">Pendaftaran Berhasil Dikirim!</h3>
                    <p class="text-xs text-teal-800 mt-0.5 leading-relaxed">
                        Data pendaftaran Anda telah tersimpan di sistem Instalasi Diklat RSUD R.A.A. Tjokronegoro. Silakan simpan nomor pendaftaran berikut atau unduh berkas bukti resmi dalam bentuk PDF.
                    </p>
                </div>
            </div>

            {{-- HIGHLIGHT NOMOR PENDAFTARAN / KODE TIKET --}}
            <div class="my-6 rounded-2xl border-2 border-dashed border-teal-300 bg-teal-50/70 p-6 text-center">
                <span class="text-xs font-bold uppercase tracking-wider text-teal-800">
                    Nomor Pendaftaran / Kode Tiket Anda
                </span>
                <div class="my-3 flex flex-wrap items-center justify-center gap-3">
                    <span id="reg-number" class="font-mono text-2xl sm:text-3xl font-black tracking-wide text-slate-900 bg-white px-5 py-2.5 rounded-xl border border-teal-200 shadow-sm">
                        {{ $registration->registration_number }}
                    </span>
                    <button
                        type="button"
                        id="btn-copy-ticket"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-teal-700 px-4 py-2.5 text-xs font-bold text-white shadow hover:bg-teal-800 transition active:scale-95"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span id="btn-copy-text">Salin Nomor</span>
                    </button>
                </div>
                <p class="text-xs text-slate-600 mt-2">
                    Simpan nomor pendaftaran ini. Anda dapat menggunakannya kapan saja untuk melacak verifikasi berkas pada menu <strong>Lacak Pendaftaran</strong>.
                </p>
            </div>

            {{-- TOMBOL BESAR BUAT UNDUH BUKTI PENDAFTARAN PDF --}}
            <div class="text-center my-8">
                <a
                    href="{{ route('information.diklat.registration.proof', $registration->registration_number) }}"
                    download="Bukti-Pendaftaran-{{ $registration->registration_number }}.pdf"
                    class="inline-flex w-full sm:w-auto items-center justify-center gap-3 rounded-2xl bg-[#007b83] px-8 py-4.5 text-base sm:text-lg font-bold text-white shadow-xl shadow-teal-700/25 transition hover:bg-[#005b64] hover:shadow-2xl active:scale-98"
                >
                    <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Unduh Bukti Pendaftaran (PDF)</span>
                </a>
                <p class="mt-2 text-xs text-slate-500">
                    Dokumen resmi tanda terima registrasi ber-kop RSUD R.A.A. Tjokronegoro dan bertanda tangan digital panitia.
                </p>
            </div>

            {{-- RINGKASAN DATA PENDAFTARAN --}}
            @php
                $category = strtolower(trim($registration->program?->category ?? ''));
                $isEducation = !in_array($category, ['pelatihan', 'orientasi']);
            @endphp
            <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-5 my-6 space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 pb-2 border-b border-slate-200">
                    Ringkasan Data Formulir
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <div>
                        <span class="text-slate-500 block">Nama Lengkap:</span>
                        <strong class="text-slate-900 text-sm font-bold">{{ $registration->full_name }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Instansi Asal:</span>
                        <strong class="text-slate-900 font-semibold">{{ $registration->institution }}</strong>
                    </div>
                    @if ($isEducation)
                        <div>
                            <span class="text-slate-500 block">Jurusan / Program Studi:</span>
                            <span class="text-slate-900">{{ $registration->study_program ?: '-' }} ({{ $registration->education_level ?: '-' }})</span>
                        </div>
                    @endif
                    <div>
                        <span class="text-slate-500 block">Kontak (HP / Email):</span>
                        <span class="text-slate-900">{{ $registration->phone }} / {{ $registration->email }}</span>
                    </div>
                    @if ($registration->purpose)
                        <div class="{{ $isEducation ? 'sm:col-span-2' : '' }}">
                            <span class="text-slate-500 block">Tujuan Mengikuti:</span>
                            <span class="text-slate-900">{{ $registration->purpose }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="text-slate-500 block">Waktu Registrasi:</span>
                        <span class="text-slate-900">{{ $registration->created_at?->translatedFormat('d F Y, H:i') ?? '-' }} WIB</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Status Registrasi:</span>
                        <span class="inline-block px-2 py-0.5 rounded font-bold uppercase text-[10px] bg-amber-100 text-amber-800">
                            {{ $registration->status ?? 'Diajukan' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- TOMBOL AKSI BAWAH: ARAHKAN KE MENU LACAK & DAFTAR KEMBALI --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-6 border-t border-slate-200">
                <a
                    href="{{ route('information.diklat.track', ['nomor' => $registration->registration_number]) }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs sm:text-sm font-bold shadow transition"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Lacak Status di Menu Lacak Pendaftaran →</span>
                </a>

                <a
                    href="{{ route('information.diklat.registration.create', $registration->diklat_program_id) }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition"
                >
                    <span>Daftar Kembali / Program Lain</span>
                </a>
            </div>
        </section>
    </main>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Otomatis bersihkan penguncian formulir lokal untuk program ini
        const programId = {{ (int) $registration->diklat_program_id }};
        if (programId) {
            try {
                localStorage.removeItem(`diklat_registration_token_program_${programId}`);
            } catch (e) {
                console.warn('Gagal membersihkan cache token program:', e);
            }
        }

        // Simpan tiket ke riwayat pendaftaran lokal jika ada
        try {
            const ticketNumber = @json($registration->registration_number);
            const historyKey = 'diklat_registration_tickets';
            let tickets = JSON.parse(localStorage.getItem(historyKey) || '[]');
            if (Array.isArray(tickets) && !tickets.includes(ticketNumber)) {
                tickets.unshift(ticketNumber);
                if (tickets.length > 20) tickets = tickets.slice(0, 20);
                localStorage.setItem(historyKey, JSON.stringify(tickets));
            }
        } catch (e) {}

        // Tombol Salin Nomor Pendaftaran
        const btnCopy = document.getElementById('btn-copy-ticket');
        const btnText = document.getElementById('btn-copy-text');
        const regNumberEl = document.getElementById('reg-number');

        if (btnCopy && regNumberEl) {
            btnCopy.addEventListener('click', function () {
                const text = regNumberEl.innerText.trim();
                navigator.clipboard.writeText(text).then(function () {
                    btnText.innerText = 'Tersalin!';
                    btnCopy.classList.remove('bg-teal-700', 'hover:bg-teal-800');
                    btnCopy.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
                    setTimeout(function () {
                        btnText.innerText = 'Salin Nomor';
                        btnCopy.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
                        btnCopy.classList.add('bg-teal-700', 'hover:bg-teal-800');
                    }, 2500);
                }).catch(function () {
                    alert('Nomor pendaftaran: ' + text);
                });
            });
        }
    });
    </script>
    @endpush

</x-layouts.app>
