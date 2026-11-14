<x-layouts.app :title="'Pendaftaran Diklat — RSUD R.A.A. Tjokronegoro'">

    @push('styles')
        @vite(['resources/css/pages/diklat-registration.css'])
    @endpush

    <x-page-header
        title="Pendaftaran Program Diklat"
        description="Ikuti tahapan pendaftaran sampai pengajuan berhasil dikirim."
    />

    @php
        $category = strtolower(trim($program->category ?? ''));
        $isEducation = !in_array($category, ['pelatihan', 'orientasi']);
    @endphp

    <main
        id="registration-content"
        class="diklat-registration mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8"
    >
        {{-- TOMBOL KEMBALI KE DETAIL --}}
        <div class="mb-5">
            <a
                href="{{ route('information.diklat.detail', $program->id) }}"
                class="diklat-registration__back inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-teal-700 transition"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Detail Program
            </a>
        </div>

        {{-- PROGRAM HERO CARD --}}
        <section class="diklat-program-hero">
            <div class="diklat-program-hero__badges">
                <span class="diklat-badge-pill diklat-badge-pill--teal">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>{{ $isEducation ? 'Pendidikan Klinis & Magang' : ucfirst($program->category) }}</span>
                </span>

                @if (!$isEducation)
                    @if ($program->is_paid)
                        <span class="diklat-badge-pill diklat-badge-pill--amber">
                            <span>Biaya: Rp {{ number_format((int) $program->fee, 0, ',', '.') }}</span>
                        </span>
                    @else
                        <span class="diklat-badge-pill diklat-badge-pill--green">
                            <span>Gratis / Tanpa Biaya</span>
                        </span>
                    @endif
                @endif

                <span class="diklat-badge-pill diklat-badge-pill--teal">
                    <span>Status: {{ ucfirst($program->status ?? 'Dibuka') }}</span>
                </span>
            </div>

            <h1>{{ $program->name }}</h1>
            <p>{{ $program->target_description ?: ($program->target ?: 'Program pengembangan kompetensi dan pendidikan resmi Instalasi Diklat RSUD R.A.A. Tjokronegoro.') }}</p>

            <div class="diklat-program-hero__meta">
                @if ($program->start_at)
                    <div class="diklat-hero-meta-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>
                            {{ $program->start_at->translatedFormat('d M Y') }}
                            @if ($program->end_at && $program->end_at->ne($program->start_at))
                                – {{ $program->end_at->translatedFormat('d M Y') }}
                            @endif
                        </span>
                    </div>
                @endif

                <div class="diklat-hero-meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>{{ $program->location ?: 'RSUD R.A.A. Tjokronegoro, Purworejo' }}</span>
                </div>

                @if (!$isEducation && $program->quota)
                    <div class="diklat-hero-meta-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Sisa Kuota: <strong>{{ $program->remaining_quota ?? $program->quota }}</strong> dari {{ $program->quota }} kursi</span>
                    </div>
                @endif
            </div>
        </section>

        {{-- ALERT ERROR --}}
        @if ($errors->any())
            <div class="diklat-registration__alert mb-6" role="alert">
                <div class="flex items-center gap-2 font-bold text-sm">
                    <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Terdapat data yang belum lengkap atau tidak sesuai:</span>
                </div>
                <ul class="mt-2 list-disc pl-5 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- INDIKATOR TIGA TAHAPAN --}}
        <nav class="diklat-status-progress mb-8" aria-label="Tahapan pendaftaran">
            @foreach ([
                'Formulir Pendaftaran',
                'Resume Pendaftaran',
                'Status & Hasil Konfirmasi',
            ] as $index => $label)
                @php
                    $stepNumber = $index + 1;
                    $isComplete = $stepNumber < 1;
                    $isCurrentStep = $stepNumber === 1;
                @endphp

                <div
                    class="diklat-status-progress__step
                        {{ $isComplete ? 'is-complete' : '' }}
                        {{ $isCurrentStep ? 'is-current' : '' }}"
                    data-progress="{{ $stepNumber }}"
                >
                    <span class="diklat-status-progress__number">
                        {{ $stepNumber }}
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
                    <div class="diklat-status-progress__arrow" aria-hidden="true" data-arrow-after="{{ $stepNumber }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                @endif
            @endforeach
        </nav>

        {{-- FORM UTAMA --}}
        <form
            id="diklatRegistrationForm"
            action="{{ route('information.diklat.registration.store', $program->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            {{-- TAHAP 1: FORMULIR --}}
            <section
                class="wizard-panel space-y-6"
                data-stage="1"
            >
                {{-- BAGIAN 1: IDENTITAS PEMOHON --}}
                <div class="diklat-reg-card">
                    <div class="diklat-reg-card__header">
                        <div class="diklat-reg-card__icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="diklat-reg-card__titles">
                            <h3 class="diklat-reg-card__title">1. Data Identitas Pemohon</h3>
                            <p class="diklat-reg-card__desc">Data diri pemohon atau perwakilan institusi pengusul.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        {{-- Nama Lengkap --}}
                        <div class="diklat-form-group">
                            <label class="diklat-form-label" for="full_name">
                                <span>Nama Lengkap</span> <span class="req">*</span>
                            </label>
                            <input
                                type="text"
                                id="full_name"
                                name="full_name"
                                class="diklat-form-input"
                                value="{{ old('full_name') }}"
                                maxlength="255"
                                autocomplete="name"
                                placeholder="Masukkan nama lengkap beserta gelar jika ada"
                                required
                            >
                            @error('full_name')
                                <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Instansi Asal --}}
                        <div class="diklat-form-group">
                            <label class="diklat-form-label" for="institution">
                                <span>Instansi / Universitas Asal</span> <span class="req">*</span>
                            </label>
                            <input
                                type="text"
                                id="institution"
                                name="institution"
                                class="diklat-form-input"
                                value="{{ old('institution') }}"
                                maxlength="255"
                                placeholder="Contoh: Universitas Gadjah Mada / RSUD Tidar"
                                required
                            >
                            @error('institution')
                                <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Nomor HP / WhatsApp --}}
                        <div class="diklat-form-group">
                            <label class="diklat-form-label" for="phone">
                                <span>Nomor HP / WhatsApp</span> <span class="req">*</span>
                            </label>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                class="diklat-form-input"
                                value="{{ old('phone') }}"
                                maxlength="25"
                                autocomplete="tel"
                                placeholder="Contoh: 081234567890"
                                required
                            >
                            <span class="diklat-form-hint">Pastikan nomor aktif WhatsApp untuk konfirmasi panitia.</span>
                            @error('phone')
                                <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="diklat-form-group">
                            <label class="diklat-form-label" for="email">
                                <span>Alamat Email Aktif</span> <span class="req">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="diklat-form-input"
                                value="{{ old('email') }}"
                                maxlength="255"
                                autocomplete="email"
                                placeholder="nama@email.com"
                                required
                            >
                            <span class="diklat-form-hint">Bukti tanda terima dan hasil seleksi dikirimkan ke email ini.</span>
                            @error('email')
                                <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- BAGIAN 2: INFORMASI AKADEMIK / PROFESI --}}
                @if ($isEducation)
                    <div class="diklat-reg-card">
                        <div class="diklat-reg-card__header">
                            <div class="diklat-reg-card__icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                            <div class="diklat-reg-card__titles">
                                <h3 class="diklat-reg-card__title">2. Informasi Akademik &amp; Periode Praktik</h3>
                                <p class="diklat-reg-card__desc">Rincian program studi, jenjang pendidikan, serta rencana waktu stase mahasiswa.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            {{-- Jurusan / Program Studi --}}
                            <div class="diklat-form-group">
                                <label class="diklat-form-label" for="study_program">
                                    <span>Jurusan / Program Studi</span> <span class="req">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="study_program"
                                    name="study_program"
                                    class="diklat-form-input"
                                    value="{{ old('study_program') }}"
                                    maxlength="255"
                                    placeholder="Contoh: S1 Keperawatan / Profesi Dokter"
                                    required
                                >
                                @error('study_program')
                                    <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Jenjang Pendidikan --}}
                            <div class="diklat-form-group">
                                <label class="diklat-form-label" for="education_level">
                                    <span>Jenjang Pendidikan</span> <span class="req">*</span>
                                </label>
                                <select
                                    id="education_level"
                                    name="education_level"
                                    class="diklat-form-select"
                                    required
                                >
                                    <option value="">Pilih jenjang pendidikan</option>
                                    @foreach (['SMA/SMK', 'Akademi/Diploma', 'Diploma IV/Strata I'] as $level)
                                        <option
                                            value="{{ $level }}"
                                            {{ old('education_level') == $level ? 'selected' : '' }}
                                        >
                                            {{ $level }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('education_level')
                                    <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tanggal Mulai Praktik --}}
                            <div class="diklat-form-group">
                                <label class="diklat-form-label" for="practice_start_date">
                                    <span>Tanggal Mulai Praktik</span> <span class="req">*</span>
                                </label>
                                <input
                                    type="date"
                                    id="practice_start_date"
                                    name="practice_start_date"
                                    class="diklat-form-input"
                                    value="{{ old('practice_start_date') }}"
                                    required
                                >
                                @error('practice_start_date')
                                    <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tanggal Selesai Praktik --}}
                            <div class="diklat-form-group">
                                <label class="diklat-form-label" for="practice_end_date">
                                    <span>Tanggal Selesai Praktik</span> <span class="req">*</span>
                                </label>
                                <input
                                    type="date"
                                    id="practice_end_date"
                                    name="practice_end_date"
                                    class="diklat-form-input"
                                    value="{{ old('practice_end_date') }}"
                                    required
                                >
                                @error('practice_end_date')
                                    <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif

                {{-- BAGIAN 2 (PELATIHAN) / BAGIAN 3 (PENDIDIKAN): UNGGAH BERKAS PERSYARATAN LENGKAP --}}
                <div class="diklat-reg-card">
                    <div class="diklat-reg-card__header">
                        <div class="diklat-reg-card__icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                        <div class="diklat-reg-card__titles">
                            <h3 class="diklat-reg-card__title">{{ $isEducation ? '3.' : '2.' }} Unggah Berkas &amp; Dokumen Persyaratan</h3>
                            <p class="diklat-reg-card__desc">Unggah dokumen kelengkapan administrasi sesuai persyaratan resmi program ini (maks. 5 MB/berkas).</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @if ($isEducation)
                            {{-- 1. Surat Permohonan --}}
                            <div class="diklat-form-group">
                                <div class="diklat-upload-card" data-dropzone="application_letter">
                                    <input
                                        type="file"
                                        id="application_letter"
                                        name="application_letter"
                                        accept=".pdf,application/pdf"
                                        required
                                    >
                                    <div class="diklat-upload-card__content">
                                        <div class="diklat-upload-card__left">
                                            <div class="diklat-upload-card__icon-badge diklat-upload-card__icon-badge--pdf">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div class="diklat-upload-card__text">
                                                <span class="diklat-upload-card__title">Surat Permohonan / Rekomendasi Resmi Dekan/Institusi <strong class="req">*</strong></span>
                                                <span class="diklat-upload-card__subtitle">Format PDF resmi ber-kop institusi &bull; Maksimal 5 MB</span>
                                                <div class="diklat-upload-card__selected-file">
                                                    <span>✓ Berkas terpilih:</span>
                                                    <span class="file-name">—</span>
                                                    <span class="file-size text-slate-500 font-normal">(—)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="diklat-upload-card__btn">
                                            <span>Pilih Berkas</span>
                                        </div>
                                    </div>
                                </div>
                                @error('application_letter')
                                    <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- 2. Daftar Nama Calon Mahasiswa & NIM --}}
                            <div class="diklat-form-group">
                                <div class="diklat-upload-card" data-dropzone="participant_list">
                                    <input
                                        type="file"
                                        id="participant_list"
                                        name="participant_list"
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                        required
                                    >
                                    <div class="diklat-upload-card__content">
                                        <div class="diklat-upload-card__left">
                                            <div class="diklat-upload-card__icon-badge diklat-upload-card__icon-badge--sheet">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <div class="diklat-upload-card__text">
                                                <span class="diklat-upload-card__title">Daftar Nama Calon Mahasiswa Peserta Stase &amp; NIM <strong class="req">*</strong></span>
                                                <span class="diklat-upload-card__subtitle">Format PDF, Excel (.xls/.xlsx), atau Word (.doc/.docx) &bull; Maks. 5 MB</span>
                                                <div class="diklat-upload-card__selected-file">
                                                    <span>✓ Berkas terpilih:</span>
                                                    <span class="file-name">—</span>
                                                    <span class="file-size text-slate-500 font-normal">(—)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="diklat-upload-card__btn">
                                            <span>Pilih Berkas</span>
                                        </div>
                                    </div>
                                </div>
                                @error('participant_list')
                                    <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- 3. Pas Foto Formal Almamater --}}
                            <div class="diklat-form-group">
                                <div class="diklat-upload-card" data-dropzone="id_photo">
                                    <input
                                        type="file"
                                        id="id_photo"
                                        name="id_photo[]"
                                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                        multiple
                                        required
                                    >
                                    <div class="diklat-upload-card__content">
                                        <div class="diklat-upload-card__left">
                                            <div class="diklat-upload-card__icon-badge diklat-upload-card__icon-badge--photo">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="diklat-upload-card__text">
                                                <span class="diklat-upload-card__title">Pas Foto Almamater (Bisa pilih lebih dari 1 foto) <strong class="req">*</strong></span>
                                                <span class="diklat-upload-card__subtitle">Dapat memilih satu atau banyak foto seluruh peserta &bull; Foto formal latar warna (JPG, PNG maks. 5 MB/foto)</span>
                                                <div class="diklat-upload-card__selected-file">
                                                    <span>✓ Berkas terpilih:</span>
                                                    <span class="file-name">—</span>
                                                    <span class="file-size text-slate-500 font-normal">(—)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="diklat-upload-card__btn">
                                            <span>Pilih Foto</span>
                                        </div>
                                    </div>
                                </div>
                                @error('id_photo')
                                    <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                @enderror
                                @error('id_photo.*')
                                    <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                        @else
                            {{-- BERKAS KHUSUS PELATIHAN (DINAMIS SESUAI PENGATURAN PROGRAM) --}}
                            @php
                                $hasAnyPelatihanFile = $program->requires_assignment_letter || $program->requires_str_file || $program->requires_id_photo;
                            @endphp

                            @if (!$hasAnyPelatihanFile)
                                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 flex items-center gap-3">
                                    <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Program pelatihan ini tidak mewajibkan pengunggahan berkas administrasi tambahan. Anda dapat langsung melanjutkan ke tahap berikutnya.</span>
                                </div>
                            @else
                                {{-- 1. Surat Tugas / Rekomendasi Instansi --}}
                                @if ($program->requires_assignment_letter)
                                    <div class="diklat-form-group">
                                        <div class="diklat-upload-card" data-dropzone="assignment_letter">
                                            <input
                                                type="file"
                                                id="assignment_letter"
                                                name="assignment_letter"
                                                accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png"
                                            >
                                            <div class="diklat-upload-card__content">
                                                <div class="diklat-upload-card__left">
                                                    <div class="diklat-upload-card__icon-badge diklat-upload-card__icon-badge--pdf">
                                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                    </div>
                                                    <div class="diklat-upload-card__text">
                                                        <span class="diklat-upload-card__title">Surat Tugas / Rekomendasi Instansi Asal <span class="opt">(Opsional)</span></span>
                                                        <span class="diklat-upload-card__subtitle">Diperlukan jika dikirim oleh instansi/faskes (PDF, JPG, PNG &bull; Maks. 5 MB). <em>Kosongkan jika mendaftar mandiri/perorangan.</em></span>
                                                        <div class="diklat-upload-card__selected-file">
                                                            <span>✓ Berkas terpilih:</span>
                                                            <span class="file-name">—</span>
                                                            <span class="file-size text-slate-500 font-normal">(—)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="diklat-upload-card__btn">
                                                    <span>Pilih Berkas</span>
                                                </div>
                                            </div>
                                        </div>
                                        @error('assignment_letter')
                                            <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endif

                                @if ($program->requires_str_file || $program->requires_id_photo)
                                    <div class="grid grid-cols-1 gap-4 {{ $program->requires_str_file && $program->requires_id_photo ? 'sm:grid-cols-2' : '' }}">
                                        {{-- 2. Scan Berkas STR --}}
                                        @if ($program->requires_str_file)
                                            <div class="diklat-form-group">
                                                <div class="diklat-upload-card" data-dropzone="str_file">
                                                    <input
                                                        type="file"
                                                        id="str_file"
                                                        name="str_file"
                                                        accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png"
                                                    >
                                                    <div class="diklat-upload-card__content">
                                                        <div class="diklat-upload-card__left">
                                                            <div class="diklat-upload-card__icon-badge diklat-upload-card__icon-badge--shield">
                                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                                                </svg>
                                                            </div>
                                                            <div class="diklat-upload-card__text">
                                                                <span class="diklat-upload-card__title">Berkas Scan STR</span>
                                                                <span class="diklat-upload-card__subtitle">STR aktif (PDF/Foto maks. 5 MB)</span>
                                                                <div class="diklat-upload-card__selected-file">
                                                                    <span>✓ Berkas terpilih:</span>
                                                                    <span class="file-name">—</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="diklat-upload-card__btn">
                                                            <span>Pilih Berkas</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('str_file')
                                                    <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        @endif

                                        {{-- 3. Pas Foto Formal --}}
                                        @if ($program->requires_id_photo)
                                            <div class="diklat-form-group">
                                                <div class="diklat-upload-card" data-dropzone="id_photo">
                                                    <input
                                                        type="file"
                                                        id="id_photo"
                                                        name="id_photo[]"
                                                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                                        multiple
                                                    >
                                                    <div class="diklat-upload-card__content">
                                                        <div class="diklat-upload-card__left">
                                                            <div class="diklat-upload-card__icon-badge diklat-upload-card__icon-badge--photo">
                                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                            </div>
                                                            <div class="diklat-upload-card__text">
                                                                <span class="diklat-upload-card__title">Pas Foto Formal <span class="opt">(Dapat pilih banyak)</span></span>
                                                                <span class="diklat-upload-card__subtitle">Latar merah/biru (JPG, PNG maks. 5 MB)</span>
                                                                <div class="diklat-upload-card__selected-file">
                                                                    <span>✓ Foto terpilih:</span>
                                                                    <span class="file-name">—</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="diklat-upload-card__btn">
                                                            <span>Pilih Foto</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('id_photo')
                                                    <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                                @enderror
                                                @error('id_photo.*')
                                                    <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>

                {{-- BAGIAN 4: PEMBAYARAN (JIKA PELATIHAN BERBAYAR) --}}
                @if (!$isEducation && $program->is_paid)
                    <div class="diklat-reg-card border-amber-200 bg-amber-50/30">
                        <div class="diklat-reg-card__header">
                            <div class="diklat-reg-card__icon bg-amber-100 text-amber-800 border-amber-200">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="diklat-reg-card__titles">
                                <h3 class="diklat-reg-card__title text-amber-950">3. Informasi Rekening &amp; Bukti Pembayaran</h3>
                                <p class="diklat-reg-card__desc text-amber-800">Silakan lakukan transfer sesuai nominal biaya registrasi ke rekening resmi RSUD berikut.</p>
                            </div>
                        </div>

                        <div class="mb-5 rounded-2xl border border-amber-200 bg-white p-5 shadow-xs">
                            <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-amber-100">
                                <div>
                                    <span class="text-xs text-slate-500 block">Total Biaya Pelatihan:</span>
                                    <strong class="text-xl sm:text-2xl font-black text-amber-700">
                                        Rp {{ number_format((int) $program->fee, 0, ',', '.') }}
                                    </strong>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-200">
                                    Rekening Resmi RSUD
                                </span>
                            </div>

                            @if ($program->payment_account_number)
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 text-xs">
                                    <div>
                                        <span class="text-slate-500 block">Nama Bank:</span>
                                        <strong class="text-slate-900 text-sm font-bold">{{ $program->payment_bank_name ?: 'Bank Jateng' }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block">Nomor Rekening:</span>
                                        <strong class="text-slate-900 font-mono text-base font-black tracking-wide">{{ $program->payment_account_number }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block">Atas Nama Penerima:</span>
                                        <strong class="text-slate-900 text-sm font-bold">{{ $program->payment_account_name ?: 'RSUD RAA Tjokronegoro' }}</strong>
                                    </div>
                                </div>
                            @else
                                <p class="text-xs text-slate-600 mt-2">
                                    Informasi nomor rekening resmi akan dikirimkan panitia saat konfirmasi pendaftaran.
                                </p>
                            @endif
                        </div>

                        {{-- Data Rekening Pengirim --}}
                        <div class="mb-5 rounded-2xl border border-slate-200 bg-slate-50/70 p-4 sm:p-5">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Data Rekening Pengirim Transfer
                            </h4>
                            <p class="text-xs text-slate-500 mb-4">
                                Masukkan rincian rekening yang Anda gunakan untuk mentransfer biaya registrasi guna mempermudah verifikasi panitia.
                            </p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                {{-- Nama Pemilik Rekening --}}
                                <div class="diklat-form-group mb-0">
                                    <label class="diklat-form-label" for="payment_sender_name">
                                        <span>Nama Pemilik Rekening (Atas Nama)</span> <span class="req">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="payment_sender_name"
                                        name="payment_sender_name"
                                        class="diklat-form-input bg-white"
                                        value="{{ old('payment_sender_name') }}"
                                        maxlength="255"
                                        placeholder="Contoh: Budi Santoso"
                                        required
                                    >
                                    <span class="diklat-form-hint">Sesuai nama yang tertera di rekening / struk transfer.</span>
                                    @error('payment_sender_name')
                                        <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Nomor Rekening Pengirim --}}
                                <div class="diklat-form-group mb-0">
                                    <label class="diklat-form-label" for="payment_sender_account_number">
                                        <span>Nomor Rekening Pengirim</span> <span class="req">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="payment_sender_account_number"
                                        name="payment_sender_account_number"
                                        class="diklat-form-input bg-white font-mono"
                                        value="{{ old('payment_sender_account_number') }}"
                                        maxlength="100"
                                        placeholder="Contoh: 1234567890"
                                        required
                                    >
                                    <span class="diklat-form-hint">Nomor rekening atau nomor virtual account / nomor ponsel e-wallet.</span>
                                    @error('payment_sender_account_number')
                                        <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Bank / E-Wallet Pengirim (Opsional) --}}
                                <div class="diklat-form-group mb-0 sm:col-span-2">
                                    <label class="diklat-form-label" for="payment_sender_bank">
                                        <span>Bank / Penyedia Pembayaran Pengirim</span> <span class="opt">(Opsional)</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="payment_sender_bank"
                                        name="payment_sender_bank"
                                        class="diklat-form-input bg-white"
                                        value="{{ old('payment_sender_bank') }}"
                                        maxlength="100"
                                        placeholder="Contoh: Bank Jateng / BCA / Mandiri / BRI / BNI / QRIS / GoPay / Dana"
                                    >
                                    @error('payment_sender_bank')
                                        <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Unggah Bukti Bayar --}}
                        <div class="diklat-form-group">
                            <div class="diklat-upload-card" data-dropzone="payment_proof">
                                <input
                                    type="file"
                                    id="payment_proof"
                                    name="payment_proof"
                                    accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf"
                                    required
                                >
                                <div class="diklat-upload-card__content">
                                    <div class="diklat-upload-card__left">
                                        <div class="diklat-upload-card__icon-badge diklat-upload-card__icon-badge--payment">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                        </div>
                                        <div class="diklat-upload-card__text">
                                            <span class="diklat-upload-card__title">Bukti Pembayaran / Transfer <strong class="req">*</strong></span>
                                            <span class="diklat-upload-card__subtitle">Foto struk transfer atau tangkapan layar m-banking (JPG, PNG, atau PDF maks. 5 MB)</span>
                                            <div class="diklat-upload-card__selected-file">
                                                <span>✓ Berkas terpilih:</span>
                                                <span class="file-name">—</span>
                                                <span class="file-size text-slate-500 font-normal">(—)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="diklat-upload-card__btn">
                                        <span>Pilih Bukti Bayar</span>
                                    </div>
                                </div>
                            </div>
                            @error('payment_proof')
                                <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                @endif

                {{-- BAGIAN 5: TUJUAN MENGIKUTI PROGRAM --}}
                <div class="diklat-reg-card">
                    <div class="diklat-reg-card__header">
                        <div class="diklat-reg-card__icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="diklat-reg-card__titles">
                            <h3 class="diklat-reg-card__title">{{ $isEducation ? '4. Tujuan & Harapan Mengikuti Praktik' : ($program->is_paid ? '4. Tujuan Mengikuti Program' : '3. Tujuan Mengikuti Program') }}</h3>
                            <p class="diklat-reg-card__desc">Tuliskan tujuan atau keterampilan khusus yang ingin diperoleh (opsional).</p>
                        </div>
                    </div>

                    <div class="diklat-form-group">
                        <textarea
                            id="purpose"
                            name="purpose"
                            class="diklat-form-textarea"
                            maxlength="3000"
                            rows="3"
                            placeholder="Tuliskan tujuan, harapan, atau unit stase yang diminati (opsional)..."
                        >{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <small class="text-xs text-red-600 mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- INFORMASI NOTICE --}}
                <div class="diklat-registration__notice">
                    <span class="diklat-registration__notice-icon">i</span>
                    <p>
                        Data dan berkas Anda akan dirangkum pada tahapan berikutnya (Resume). Anda dapat meninjau kembali seluruh isian sebelum mengirimkan pendaftaran secara resmi.
                    </p>
                </div>

                {{-- TOMBOL NAVIGASI WIZARD STAGE 1 --}}
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-6 border-t border-slate-200">
                    <a
                        href="{{ route('information.diklat.detail', $program->id) }}"
                        class="diklat-btn-modern-secondary w-full sm:w-auto"
                    >
                        ← Kembali ke Detail Program
                    </a>

                    <button
                        type="button"
                        class="diklat-btn-modern-primary w-full sm:w-auto"
                        data-next="2"
                    >
                        Periksa Resume Pendaftaran →
                    </button>
                </div>
            </section>

            {{-- TAHAP 2: RESUME --}}
            <section
                class="wizard-panel space-y-6"
                data-stage="2"
                hidden
            >
                <div class="diklat-resume-card">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-teal-700">Tahap 2 Dari 3</span>
                            <h2 class="text-xl font-black text-slate-900 mt-0.5">Resume Pendaftaran</h2>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-teal-50 text-[#007b83] border border-teal-200">
                            {{ $isEducation ? 'Pendidikan & Magang' : ucfirst($program->category) }}
                        </span>
                    </div>

                    {{-- Section Rincian Program --}}
                    <div class="diklat-resume-section">
                        <div class="diklat-resume-section__title">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Program Yang Dipilih</span>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/80">
                            <h4 class="text-base font-black text-slate-900">{{ $program->name }}</h4>
                            <div class="flex flex-wrap gap-x-6 gap-y-2 text-xs text-slate-600 mt-2">
                                <span>Kategori: <strong>{{ ucfirst($program->category) }}</strong></span>
                                @if (!$isEducation && $program->is_paid)
                                    <span>Biaya: <strong class="text-amber-700">Rp {{ number_format((int) $program->fee, 0, ',', '.') }}</strong></span>
                                @else
                                    <span>Biaya: <strong class="text-emerald-700">Gratis</strong></span>
                                @endif
                                <span>Lokasi: <strong>{{ $program->location ?: 'RSUD R.A.A. Tjokronegoro' }}</strong></span>
                            </div>
                        </div>
                    </div>

                    {{-- Section Data Diri --}}
                    <div class="diklat-resume-section">
                        <div class="diklat-resume-section__title">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Data Identitas Pemohon</span>
                        </div>
                        <dl class="diklat-resume-grid">
                            <div class="diklat-resume-item">
                                <dt>Nama Lengkap</dt>
                                <dd data-resume="full_name">—</dd>
                            </div>
                            <div class="diklat-resume-item">
                                <dt>Instansi Asal</dt>
                                <dd data-resume="institution">—</dd>
                            </div>
                            <div class="diklat-resume-item">
                                <dt>Nomor HP / WhatsApp</dt>
                                <dd data-resume="phone">—</dd>
                            </div>
                            <div class="diklat-resume-item">
                                <dt>Alamat Email</dt>
                                <dd data-resume="email">—</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Section Info Akademik / Profesi --}}
                    @if ($isEducation)
                        <div class="diklat-resume-section">
                            <div class="diklat-resume-section__title">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                </svg>
                                <span>Informasi Akademik &amp; Jadwal Praktik</span>
                            </div>
                            <dl class="diklat-resume-grid">
                                <div class="diklat-resume-item">
                                    <dt>Program Studi / Jurusan</dt>
                                    <dd data-resume="study_program">—</dd>
                                </div>
                                <div class="diklat-resume-item">
                                    <dt>Jenjang Pendidikan</dt>
                                    <dd data-resume="education_level">—</dd>
                                </div>
                                <div class="diklat-resume-item sm:col-span-2">
                                    <dt>Rencana Periode Praktik</dt>
                                    <dd data-resume="practice_period">—</dd>
                                </div>
                            </dl>
                        </div>
                    @endif

                    {{-- Section Berkas Terlampir --}}
                    <div class="diklat-resume-section">
                        <div class="diklat-resume-section__title">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Dokumen &amp; Berkas Persyaratan Terpilih</span>
                        </div>

                        <div class="space-y-3">
                            @if ($isEducation)
                                <div class="flex flex-wrap items-center justify-between gap-2 p-3 rounded-xl bg-slate-50 border border-slate-200">
                                    <div>
                                        <strong class="text-xs text-slate-800 block">Surat Permohonan / Rekomendasi Resmi:</strong>
                                        <span id="resume_application_letter_text" class="text-xs text-slate-500">Belum dipilih</span>
                                    </div>
                                    <a href="#" id="resume_application_letter_link" target="_blank" class="diklat-resume-file-chip" hidden>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        <span>Lihat Dokumen</span>
                                    </a>
                                </div>

                                <div class="flex flex-wrap items-center justify-between gap-2 p-3 rounded-xl bg-slate-50 border border-slate-200">
                                    <div>
                                        <strong class="text-xs text-slate-800 block">Daftar Mahasiswa &amp; NIM:</strong>
                                        <span id="resume_participant_list_text" class="text-xs text-slate-500">Belum dipilih</span>
                                    </div>
                                    <a href="#" id="resume_participant_list_link" target="_blank" class="diklat-resume-file-chip" hidden>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        <span>Buka Berkas</span>
                                    </a>
                                </div>

                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <div>
                                            <strong class="text-xs text-slate-800 block">Pas Foto Formal Almamater:</strong>
                                            <span id="resume_id_photo_text" class="text-xs text-slate-500">Belum dipilih</span>
                                        </div>
                                        <a href="#" id="resume_id_photo_link" target="_blank" class="diklat-resume-file-chip" hidden>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            <span>Lihat Foto</span>
                                        </a>
                                    </div>
                                    <div id="resume_id_photo_multi_chips" class="flex flex-wrap gap-2 mt-2 pt-2 border-t border-slate-200" hidden></div>
                                </div>
                            @else
                                @if ($program->requires_assignment_letter)
                                    <div class="flex flex-wrap items-center justify-between gap-2 p-3 rounded-xl bg-slate-50 border border-slate-200">
                                        <div>
                                            <strong class="text-xs text-slate-800 block">Surat Tugas / Rekomendasi Instansi:</strong>
                                            <span id="resume_assignment_letter_text" class="text-xs text-slate-500">Tidak dilampirkan (Pendaftar mandiri/perorangan)</span>
                                        </div>
                                        <a href="#" id="resume_assignment_letter_link" target="_blank" class="diklat-resume-file-chip" hidden>
                                            <span>Lihat Berkas</span>
                                        </a>
                                    </div>
                                @endif

                                @if ($program->requires_str_file)
                                    <div class="flex flex-wrap items-center justify-between gap-2 p-3 rounded-xl bg-slate-50 border border-slate-200">
                                        <div>
                                            <strong class="text-xs text-slate-800 block">Berkas Scan STR:</strong>
                                            <span id="resume_str_file_text" class="text-xs text-slate-500">Tidak dilampirkan</span>
                                        </div>
                                        <a href="#" id="resume_str_file_link" target="_blank" class="diklat-resume-file-chip" hidden>
                                            <span>Lihat STR</span>
                                        </a>
                                    </div>
                                @endif

                                @if ($program->requires_id_photo)
                                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                                        <div class="flex flex-wrap items-center justify-between gap-2">
                                            <div>
                                                <strong class="text-xs text-slate-800 block">Pas Foto Formal:</strong>
                                                <span id="resume_id_photo_text" class="text-xs text-slate-500">Tidak dilampirkan</span>
                                            </div>
                                            <a href="#" id="resume_id_photo_link" target="_blank" class="diklat-resume-file-chip" hidden>
                                                <span>Lihat Foto</span>
                                            </a>
                                        </div>
                                        <div id="resume_id_photo_multi_chips_training" class="flex flex-wrap gap-2 mt-2 pt-2 border-t border-slate-200" hidden></div>
                                    </div>
                                @endif

                                @if ($program->is_paid)
                                    <div class="space-y-2 p-3 rounded-xl bg-amber-50/70 border border-amber-200">
                                        <div class="flex flex-wrap items-center justify-between gap-2">
                                            <div>
                                                <strong class="text-xs text-amber-900 block">Bukti Pembayaran Registrasi:</strong>
                                                <span id="resume_payment_proof_text" class="text-xs text-amber-700">Belum dipilih</span>
                                            </div>
                                            <a href="#" id="resume_payment_proof_link" target="_blank" class="diklat-resume-file-chip" hidden>
                                                <span>Lihat Bukti Bayar</span>
                                            </a>
                                        </div>
                                        <div class="pt-2 border-t border-amber-200/60 text-xs text-amber-950 flex flex-wrap gap-x-4 gap-y-1">
                                            <span>Atas Nama: <strong data-resume="payment_sender_name">—</strong></span>
                                            <span>No. Rekening: <strong data-resume="payment_sender_account_number" class="font-mono">—</strong></span>
                                            <span>Bank: <strong data-resume="payment_sender_bank">—</strong></span>
                                        </div>
                                    </div>
                                @endif

                                @if (!$program->requires_assignment_letter && !$program->requires_str_file && !$program->requires_id_photo && !$program->is_paid)
                                    <p class="text-xs text-slate-500 italic p-3 rounded-xl bg-slate-50 border border-slate-200">
                                        Tidak ada berkas fisik yang perlu dilampirkan untuk program ini.
                                    </p>
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- Section Tujuan Program --}}
                    <div class="diklat-resume-section">
                        <div class="diklat-resume-section__title">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            <span>Tujuan / Catatan Khusus</span>
                        </div>
                        <p class="text-xs text-slate-700 whitespace-pre-line leading-relaxed" data-resume="purpose">—</p>
                    </div>
                </div>

                {{-- KOTAK PERNYATAAN / KONFIRMASI --}}
                <div class="rounded-2xl border border-teal-200 bg-teal-50/80 p-5 flex items-start gap-3.5">
                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-teal-600 text-white font-bold text-xs mt-0.5">
                        i
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-teal-900">Konfirmasi Pengajuan</h4>
                        <p class="text-xs text-teal-800 mt-1 leading-relaxed">
                            Dengan menekan tombol <strong>Kirim Pendaftaran Sekarang</strong>, Anda menyatakan bahwa seluruh data dan dokumen yang dilampirkan adalah benar dan sah. Pengajuan Anda akan masuk ke tahap verifikasi berkas oleh pengelola Instalasi Diklat RSUD R.A.A. Tjokronegoro.
                        </p>
                    </div>
                </div>

                {{-- TOMBOL AKSI TAHAP 2 --}}
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-6 border-t border-slate-200">
                    <button
                        type="button"
                        class="diklat-btn-modern-secondary w-full sm:w-auto"
                        data-back="1"
                    >
                        ← Kembali dan Ubah Formulir
                    </button>

                    <button
                        type="submit"
                        id="submitRegistrationBtn"
                        class="diklat-btn-modern-primary w-full sm:w-auto text-sm py-3.5 px-8"
                    >
                        <span>Kirim Pendaftaran Sekarang ✓</span>
                    </button>
                </div>
            </section>
        </form>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('diklatRegistrationForm');
                const content = document.getElementById('registration-content');
                const panels = [...document.querySelectorAll('.wizard-panel')];
                const progressSteps = [
                    ...document.querySelectorAll(
                        '#registration-content .diklat-status-progress [data-progress]'
                    )
                ];
                const progressArrows = [
                    ...document.querySelectorAll(
                        '#registration-content .diklat-status-progress [data-arrow-after]'
                    )
                ];

                if (!form || !content || panels.length === 0) return;

                let currentStage = 1;

                function formatFileSize(bytes) {
                    if (!bytes || bytes === 0) return '0 B';
                    const k = 1024;
                    const sizes = ['B', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
                }

                // Setup modern upload cards
                document.querySelectorAll('.diklat-upload-card').forEach(function (card) {
                    const input = card.querySelector('input[type="file"]');
                    const fileNameEl = card.querySelector('.file-name');
                    const fileSizeEl = card.querySelector('.file-size');
                    const btnSpan = card.querySelector('.diklat-upload-card__btn span');

                    if (!input) return;

                    function handleFileChange() {
                        if (input.files && input.files.length > 1) {
                            card.classList.add('has-file');
                            let totalBytes = 0;
                            for (let i = 0; i < input.files.length; i++) {
                                totalBytes += input.files[i].size;
                            }
                            if (fileNameEl) fileNameEl.textContent = input.files.length + ' foto dipilih';
                            if (fileSizeEl) fileSizeEl.textContent = '(Total ' + formatFileSize(totalBytes) + ')';
                            if (btnSpan) btnSpan.textContent = 'Ganti Foto';
                        } else if (input.files && input.files[0]) {
                            const file = input.files[0];
                            card.classList.add('has-file');
                            if (fileNameEl) fileNameEl.textContent = file.name;
                            if (fileSizeEl) fileSizeEl.textContent = '(' + formatFileSize(file.size) + ')';
                            if (btnSpan) btnSpan.textContent = input.hasAttribute('multiple') ? 'Ganti Foto' : 'Ganti Berkas';
                        } else {
                            card.classList.remove('has-file');
                            if (fileNameEl) fileNameEl.textContent = '—';
                            if (fileSizeEl) fileSizeEl.textContent = '—';
                            if (btnSpan) btnSpan.textContent = input.hasAttribute('multiple') ? 'Pilih Foto' : 'Pilih Berkas';
                        }
                    }

                    input.addEventListener('change', handleFileChange);

                    // Drag & Drop visual state
                    ['dragenter', 'dragover'].forEach(eventName => {
                        card.addEventListener(eventName, function (e) {
                            e.preventDefault();
                            card.classList.add('is-dragover');
                        }, false);
                    });

                    ['dragleave', 'drop'].forEach(eventName => {
                        card.addEventListener(eventName, function (e) {
                            e.preventDefault();
                            card.classList.remove('is-dragover');
                        }, false);
                    });

                    // Check if file already chosen on page load
                    handleFileChange();
                });

                function scrollToContent() {
                    const top = content.getBoundingClientRect().top + window.scrollY - 16;
                    window.scrollTo({
                        top: Math.max(0, top),
                        behavior: 'smooth'
                    });
                }

                function updateResume() {
                    // Update plain text inputs
                    [
                        'full_name',
                        'institution',
                        'phone',
                        'email',
                        'purpose',
                        'study_program',
                        'education_level',
                        'str_number',
                        'satusehat_id',
                        'payment_sender_name',
                        'payment_sender_account_number',
                        'payment_sender_bank'
                    ].forEach(function (name) {
                        const input = form.elements[name];
                        const output = document.querySelector('[data-resume="' + name + '"]');

                        if (input && output) {
                            output.textContent = input.value.trim() || '—';
                        }
                    });

                    // Update practice period
                    const startDate = form.elements['practice_start_date'];
                    const endDate = form.elements['practice_end_date'];
                    const periodOutput = document.querySelector('[data-resume="practice_period"]');

                    if (startDate && endDate && periodOutput) {
                        const formatDate = function (value) {
                            if (!value) return '';
                            return new Date(value + 'T00:00:00').toLocaleDateString(
                                'id-ID',
                                {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                }
                            );
                        };

                        const start = formatDate(startDate.value);
                        const end = formatDate(endDate.value);

                        periodOutput.textContent = start && end
                            ? start + ' s/d ' + end
                            : '—';
                    }

                    // Update file resume links and labels
                    const fileFields = [
                        'application_letter',
                        'participant_list',
                        'id_photo',
                        'assignment_letter',
                        'str_file',
                        'payment_proof'
                    ];

                    fileFields.forEach(function (fieldName) {
                        const input = document.getElementById(fieldName) || form.elements[fieldName] || form.elements[fieldName + '[]'];
                        const link = document.getElementById('resume_' + fieldName + '_link');
                        const text = document.getElementById('resume_' + fieldName + '_text');
                        const multiChipsContainer = document.getElementById('resume_' + fieldName + '_multi_chips') ||
                            document.getElementById('resume_' + fieldName + '_multi_chips_training');

                        if (!input || !text) return;

                        if (input.files && input.files.length > 1) {
                            let totalSize = 0;
                            for (let i = 0; i < input.files.length; i++) {
                                totalSize += input.files[i].size;
                            }
                            text.innerHTML = '<strong class="text-teal-900">' + input.files.length + ' Foto Terpilih</strong> (' + formatFileSize(totalSize) + ')';
                            if (link) {
                                link.hidden = true;
                            }
                            if (multiChipsContainer) {
                                multiChipsContainer.innerHTML = '';
                                for (let i = 0; i < input.files.length; i++) {
                                    const f = input.files[i];
                                    const a = document.createElement('a');
                                    a.className = 'diklat-resume-file-chip';
                                    a.target = '_blank';
                                    try {
                                        a.href = URL.createObjectURL(f);
                                    } catch (e) {
                                        a.href = '#';
                                    }
                                    a.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg><span>Foto ' + (i + 1) + ' (' + f.name + ')</span>';
                                    multiChipsContainer.appendChild(a);
                                }
                                multiChipsContainer.hidden = false;
                            }
                        } else if (input.files && input.files[0]) {
                            const file = input.files[0];
                            text.innerHTML = '<strong class="text-teal-900">' + file.name + '</strong> (' + formatFileSize(file.size) + ')';
                            if (multiChipsContainer) {
                                multiChipsContainer.hidden = true;
                                multiChipsContainer.innerHTML = '';
                            }
                            if (link) {
                                try {
                                    const fileUrl = URL.createObjectURL(file);
                                    link.href = fileUrl;
                                    link.hidden = false;
                                } catch (e) {
                                    link.hidden = true;
                                }
                            }
                        } else {
                            if (link) {
                                link.removeAttribute('href');
                                link.hidden = true;
                            }
                            if (multiChipsContainer) {
                                multiChipsContainer.hidden = true;
                                multiChipsContainer.innerHTML = '';
                            }
                            text.textContent = input.hasAttribute('required') ? 'Belum dipilih' : 'Tidak dilampirkan';
                        }
                    });
                }

                const stepLabels = [
                    'Formulir Pendaftaran',
                    'Resume Pendaftaran',
                    'Status & Hasil Konfirmasi'
                ];

                function showStage(stage, shouldScroll = true) {
                    currentStage = stage;

                    panels.forEach(function (panel) {
                        panel.hidden = Number(panel.dataset.stage) !== stage;
                    });

                    progressSteps.forEach(function (step) {
                        const number = Number(step.dataset.progress);
                        const isComplete = number < stage;
                        const isCurrent = number === stage;

                        step.classList.toggle('is-complete', isComplete);
                        step.classList.toggle('is-current', isCurrent);

                        const numberElement = step.querySelector('.diklat-status-progress__number');
                        const labelElement = step.querySelector('strong');
                        const statusElement = step.querySelector('small');

                        if (numberElement) {
                            numberElement.textContent = isComplete ? '✓' : number;
                        }

                        if (labelElement && stepLabels[number - 1]) {
                            labelElement.textContent = number + '. ' + stepLabels[number - 1];
                        }

                        if (statusElement) {
                            statusElement.textContent = isComplete
                                ? 'Telah selesai'
                                : isCurrent
                                    ? 'Sedang berlangsung'
                                    : 'Belum dimulai';
                        }
                    });

                    progressArrows.forEach(function (arrow) {
                        const arrowAfter = Number(arrow.dataset.arrowAfter);
                        arrow.classList.toggle('is-passed', arrowAfter < stage);
                    });

                    if (stage === 2) updateResume();

                    if (shouldScroll) {
                        requestAnimationFrame(scrollToContent);
                    }
                }

                document.querySelectorAll('[data-next]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        const nextStage = Number(button.dataset.next);

                        if (currentStage === 1) {
                            const fields = form.querySelectorAll(
                                '[data-stage="1"] input, [data-stage="1"] textarea, [data-stage="1"] select'
                            );

                            for (const field of fields) {
                                if (!field.checkValidity()) {
                                    field.reportValidity();
                                    field.focus();
                                    return;
                                }
                            }
                        }

                        showStage(nextStage);
                    });
                });

                document.querySelectorAll('[data-back]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        showStage(Number(button.dataset.back));
                    });
                });

                // Prevent double submission
                form.addEventListener('submit', function () {
                    const submitBtn = document.getElementById('submitRegistrationBtn');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span>Mengirim Pendaftaran...</span>';
                    }
                });

                // Tampilkan tahap 1
                showStage(currentStage, false);

                // Buka halaman langsung pada bagian konten
                requestAnimationFrame(function () {
                    scrollToContent();
                });
            });
        </script>
    @endpush

</x-layouts.app>
