<x-layouts.app :title="$program->name . ' — RSUD R.A.A. Tjokronegoro'" :meta-description="'Informasi detail program, jadwal, kuota, persyaratan dan pengajuan: ' . $program->name">

    {{-- Header Banner Komponen Standar --}}
    <x-page-header
        title="Pendidikan & Pelatihan"
        description="Informasi komprehensif program pendidikan klinis, magang, dan pelatihan pengembangan kompetensi di RSUD R.A.A. Tjokronegoro."
    />

    {{-- Submenu Diklat --}}
    <x-submenus.diklat active="education" />

    {{-- Breadcrumb Navigasi --}}
    <div class="bg-slate-50 border-b border-slate-200/70">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 py-4 text-xs sm:text-sm text-slate-500 overflow-x-auto no-scrollbar" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-[#007b83] transition">Beranda</a>
                <span class="text-slate-300">›</span>
                <a href="{{ url('/informasi/diklat') }}" class="hover:text-[#007b83] transition">Diklat</a>
                <span class="text-slate-300">›</span>
                <a href="{{ route('information.education') }}" class="hover:text-[#007b83] transition">Pendidikan & Pelatihan</a>
                <span class="text-slate-300">›</span>
                <span class="font-semibold text-[#007b83] truncate max-w-xs sm:max-w-md">{{ $program->name }}</span>
            </nav>
        </div>
    </div>

    @php
        $category = strtolower(trim($program->category ?? 'pelatihan'));
        $isEducation = !in_array($category, ['pelatihan', 'orientasi']);
        $status = strtolower(trim($program->status ?? 'dibuka'));
        $now = now();

        $remaining = (int) ($program->remaining_quota ?? 0);
        $quota = (int) ($program->quota ?? 0);
        $filled = max(0, $quota - $remaining);
        $percentage = $quota > 0 ? min(100, max(0, round(($filled / $quota) * 100))) : 0;

        $isAvailable = $isEducation
            ? true
            : (
                $program->requires_registration
                    ? (in_array($status, ['dibuka', 'terbatas']) && $remaining > 0)
                    : true
            );

        if ($isEducation) {
            $statusLabel = 'Menerima Pengajuan';
            $statusColor = 'bg-emerald-50 text-emerald-700 border-emerald-200';
        } elseif (!$program->requires_registration) {
            $statusLabel = 'Terbuka / Tanpa Pendaftaran';
            $statusColor = 'bg-teal-50 text-teal-700 border-teal-200';
        } else {
            $statusLabels = [
                'dibuka' => 'Masih Dibuka',
                'terbatas' => 'Kuota Terbatas',
                'penuh' => 'Kuota Penuh',
                'ditutup' => 'Pendaftaran Ditutup',
            ];
            $statusLabel = ($remaining <= 0 && $program->requires_registration)
                ? 'Kuota Penuh'
                : ($statusLabels[$status] ?? 'Informasi Program');

            $statusColor = match($statusLabel) {
                'Masih Dibuka' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'Kuota Terbatas' => 'bg-amber-50 text-amber-700 border-amber-200',
                'Kuota Penuh' => 'bg-rose-50 text-rose-700 border-rose-200',
                default => 'bg-slate-100 text-slate-700 border-slate-200',
            };
        }

        // Normalisasi format jadwal & durasi
        $scheduleVal = trim((string) ($program->schedule ?? ''));
        if ($scheduleVal === '-' || $scheduleVal === '') {
            $scheduleVal = null;
        }

        $durationVal = trim((string) ($program->duration ?? ''));
        if ($durationVal === '-' || $durationVal === '') {
            $durationVal = null;
        }

        if ($isEducation) {
            $scheduleDisplay = $scheduleVal ?: 'Sesuai pengajuan dan persetujuan rumah sakit';
            $durationDisplay = $durationVal ?: 'Sesuai ketentuan program dan institusi mitra';
        } else {
            // Penentuan Jadwal Pelaksanaan
            if ($program->start_at) {
                if ($program->end_at && !$program->end_at->isSameDay($program->start_at)) {
                    if ($program->start_at->format('Y-m') === $program->end_at->format('Y-m')) {
                        $dateFormatted = $program->start_at->translatedFormat('d') . '–' . $program->end_at->translatedFormat('d F Y');
                    } else {
                        $dateFormatted = $program->start_at->translatedFormat('d F Y') . ' - ' . $program->end_at->translatedFormat('d F Y');
                    }
                } else {
                    $dateFormatted = $program->start_at->translatedFormat('d F Y');
                }

                // Jika ada teks jadwal/keterangan jam tambahan di CMS
                if ($scheduleVal) {
                    if (!str_contains(strtolower($scheduleVal), strtolower($program->start_at->translatedFormat('F')))
                        && !str_contains(strtolower($scheduleVal), strtolower($dateFormatted))) {
                        $scheduleDisplay = $dateFormatted . ' (' . $scheduleVal . ')';
                    } else {
                        $scheduleDisplay = $scheduleVal;
                    }
                } else {
                    $scheduleDisplay = $dateFormatted;
                }
            } elseif ($scheduleVal) {
                $scheduleDisplay = $scheduleVal;
            } else {
                $scheduleDisplay = 'Sesuai Jadwal Pelaksanaan';
            }

            // Penentuan Durasi / Periode: utamakan durasi manual dari CMS jika ada
            if ($durationVal) {
                $durationDisplay = $durationVal;
            } elseif ($program->start_at && $program->end_at) {
                if ($program->start_at->isSameDay($program->end_at)) {
                    $durationDisplay = '1 Hari Pelaksanaan';
                } else {
                    $diffDays = (int) round($program->start_at->copy()->startOfDay()->diffInDays($program->end_at->copy()->startOfDay()));
                    $totalDays = max(1, $diffDays + 1);
                    $durationDisplay = $totalDays . ' Hari Pelaksanaan';
                }
            } else {
                $durationDisplay = !$program->requires_registration ? '1 Sesi Pelaksanaan' : '24 Jam Pelajaran (JPL)';
            }
        }

        // Attendance state for programs without registration
        $attendanceOpen = !$isEducation && !$program->requires_registration
            && $program->start_at
            && $program->end_at
            && $now->greaterThanOrEqualTo($program->start_at)
            && $now->lessThan($program->end_at);

        $attendanceNotStarted = !$isEducation && !$program->requires_registration
            && $program->start_at
            && $now->lessThan($program->start_at);

        $attendanceEnded = !$isEducation && !$program->requires_registration
            && $program->end_at
            && $now->greaterThanOrEqualTo($program->end_at);

        // Penentuan berkas brosur / pamflet gambar untuk ditampilkan di detail (hanya jika brosur diunggah)
        $displayBrochureImage = null;
        $isBrochurePdf = false;
        $hasUploadedBrochure = false;

        if ($program->flyer_image) {
            if (str_ends_with(strtolower($program->flyer_image), '.pdf')) {
                $isBrochurePdf = true;
                $hasUploadedBrochure = true;
            } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($program->flyer_image)) {
                $displayBrochureImage = \Illuminate\Support\Facades\Storage::disk('public')->url($program->flyer_image);
                $hasUploadedBrochure = true;
            }
        }
    @endphp

    <main class="bg-slate-50/60 py-8 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Tombol Navigasi Kembali --}}
            <div class="mb-6">
                <a
                    href="{{ route('information.education') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#007b83] hover:text-[#005b64] transition group"
                >
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke Pendidikan &amp; Pelatihan</span>
                </a>
            </div>

            {{-- HEADER UTAMA PROGRAM --}}
            <section class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-xs mb-8">
                <div class="flex flex-wrap items-center gap-2.5 mb-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-50 text-[#007b83] border border-teal-200/70">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        {{ $isEducation ? 'Program Pendidikan Klinis' : (!$program->requires_registration ? 'Sosialisasi / Kegiatan Internal' : ucfirst($program->category ?? 'Pelatihan')) }}
                    </span>

                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $statusColor }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ in_array($statusLabel, ['Masih Dibuka', 'Menerima Pengajuan', 'Terbuka / Tanpa Pendaftaran']) ? 'bg-emerald-500 animate-pulse' : ($statusLabel === 'Kuota Terbatas' ? 'bg-amber-500' : 'bg-slate-400') }}"></span>
                        {{ $statusLabel }}
                    </span>

                    @if ($isEducation)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                            ★ Kerjasama Institusi (MoU)
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-200">
                            Praktik &amp; Magang Klinis
                        </span>
                    @else
                        @if ($program->skp_points)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                ★ {{ $program->skp_points }}
                            </span>
                        @elseif ($program->requires_registration)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                ★ SKP Kemenkes RI
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                ★ Kegiatan Internal RSUD
                            </span>
                        @endif

                        @if ($program->requires_registration && $program->is_paid)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                Berbayar
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Gratis / Tanpa Biaya
                            </span>
                        @endif

                    @endif

                    @if ($program->flyer_image)
                        <button
                            type="button"
                            onclick="openDiklatBrochureModal('{{ route('information.diklat.brochure', $program->id) }}', '{{ addslashes($program->name) }}')"
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-800 border border-teal-300 hover:bg-teal-100 transition shadow-xs cursor-pointer"
                            title="Lihat Brosur Program (PDF)"
                        >
                            <svg class="w-3.5 h-3.5 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Brosur Program (PDF)</span>
                        </button>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $program->name }}
                </h1>

                @if ($program->target_description || $program->target)
                    <p class="mt-3 text-sm sm:text-base text-slate-600 font-medium">
                        <strong class="text-slate-800">Sasaran:</strong> {{ $program->target_description ?: $program->target }}
                    </p>
                @endif

                @if ($scheduleVal && $program->start_at && !str_contains(strtolower($scheduleVal), strtolower($program->start_at->translatedFormat('F'))))
                    <div class="mt-3 inline-flex items-center gap-2 rounded-xl bg-amber-50/80 border border-amber-200/80 px-3.5 py-1.5 text-xs text-amber-900 font-medium">
                        <span class="font-bold text-amber-800">📌 Keterangan / Catatan:</span>
                        <span>{{ $scheduleVal }}</span>
                    </div>
                @endif

                {{-- Quick Meta Grid --}}
                <div class="mt-8 grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-6 border-t border-slate-100">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#007b83] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-medium block">Jadwal Pelaksanaan</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-800">
                                {{ $scheduleDisplay }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#007b83] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-medium block">Durasi / Periode</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-800">
                                {{ $durationDisplay }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#007b83] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-medium block">Metode Pembelajaran</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-800">
                                {{ $program->method ?: ($isEducation ? 'Luring' : 'Luring (Tatap Muka)') }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#007b83] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-medium block">Tempat / Lokasi</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-800">
                                {{ $program->location ?: ($isEducation ? 'RSUD R.A.A Tjokronegoro' : 'Instalasi Diklat & Unit Pelayanan RSUD') }}
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            {{-- GRID DUA KOLOM: KONTEN LENGKAP & STICKY SIDEBAR REGISTRASI --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                {{-- KOLOM KIRI: DETAIL KONTEN LENGKAP (8 Cols) --}}
                <div class="lg:col-span-8 space-y-8">

                    {{-- BANNER / GAMBAR BROSUR RESMI PROGRAM --}}
                    @if ($displayBrochureImage || $isBrochurePdf)
                        <section class="overflow-hidden rounded-3xl border border-slate-200/90 bg-white shadow-xs transition hover:shadow-md">
                            {{-- Header Bar Brosur --}}
                            <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/80 px-5 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-teal-50 text-[#007b83]">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs sm:text-sm font-bold text-slate-800 block">
                                            {{ $hasUploadedBrochure ? 'Brosur & Pamflet Resmi Program' : 'Brosur Resmi Program' }}
                                        </span>
                                        <span class="text-[11px] text-slate-500 block">
                                            RSUD R.A.A. Tjokronegoro Purworejo
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        onclick="openDiklatBrochureModal('{{ route('information.diklat.brochure', $program->id) }}', '{{ addslashes($program->name) }}')"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 hover:text-[#007b83] border border-slate-200 shadow-2xs hover:bg-slate-50 transition cursor-pointer"
                                        title="Buka pratinjau brosur resolusi penuh"
                                    >
                                        <svg class="h-3.5 w-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                        </svg>
                                        <span class="hidden sm:inline">Perbesar</span>
                                        <span class="sm:hidden">Lihat</span>
                                    </button>

                                    <a
                                        href="{{ route('information.diklat.brochure', $program->id) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-teal-50 px-2.5 py-1.5 text-xs font-semibold text-[#007b83] hover:bg-teal-100 border border-teal-200 transition"
                                        title="Buka brosur dokumen di tab baru"
                                    >
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        <span>Tab Baru</span>
                                    </a>
                                </div>
                            </div>

                            {{-- Isi Visual Brosur --}}
                            @if ($displayBrochureImage)
                                <div
                                    class="relative group bg-slate-900/5 flex items-center justify-center overflow-hidden p-2.5 sm:p-4 cursor-pointer"
                                    onclick="openDiklatBrochureModal('{{ route('information.diklat.brochure', $program->id) }}', '{{ addslashes($program->name) }}')"
                                    title="Klik untuk melihat brosur resolusi penuh"
                                >
                                    <img
                                        src="{{ $displayBrochureImage }}"
                                        alt="Brosur {{ $program->name }}"
                                        class="w-full h-auto max-h-[500px] sm:max-h-[580px] object-contain rounded-2xl shadow-xs transition-transform duration-300 group-hover:scale-[1.01]"
                                        loading="lazy"
                                    >

                                    {{-- Hover Overlay Pill --}}
                                    <div class="absolute inset-0 bg-slate-950/0 group-hover:bg-slate-950/15 transition-colors flex items-center justify-center rounded-2xl pointer-events-none">
                                        <span class="opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0 duration-200 bg-slate-900/85 backdrop-blur-xs text-white text-xs font-semibold px-4 py-2 rounded-full flex items-center gap-2 shadow-xl border border-white/20">
                                            <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                            </svg>
                                            Klik untuk Membuka / Memperbesar Brosur
                                        </span>
                                    </div>
                                </div>
                            @elseif ($isBrochurePdf)
                                <div class="p-6 sm:p-8 bg-gradient-to-br from-teal-50/70 via-white to-slate-50 flex flex-col sm:flex-row items-center justify-between gap-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-14 rounded-2xl bg-teal-100/80 text-[#007b83] flex items-center justify-center shrink-0 shadow-inner">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center gap-1 rounded-full bg-teal-100 px-2.5 py-0.5 text-[11px] font-bold text-[#007b83] mb-1">
                                                Dokumen Brosur Resmi (PDF)
                                            </span>
                                            <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-snug">
                                                Brosur Lengkap {{ $program->name }}
                                            </h3>
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                Tersedia dokumen brosur resmi berformat PDF untuk dilihat atau diunduh.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2.5 shrink-0 w-full sm:w-auto">
                                        <button
                                            type="button"
                                            onclick="openDiklatBrochureModal('{{ route('information.diklat.brochure', $program->id) }}', '{{ addslashes($program->name) }}')"
                                            class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 rounded-xl bg-[#007b83] hover:bg-[#006066] px-4 py-2.5 text-xs sm:text-sm font-bold text-white shadow-sm transition active:scale-95 cursor-pointer"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <span>Buka Brosur PDF</span>
                                        </button>

                                        <a
                                            href="{{ route('information.diklat.brochure', $program->id) }}"
                                            download
                                            class="inline-flex items-center justify-center p-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 transition shadow-xs"
                                            title="Unduh berkas PDF"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </section>
                    @endif

                    {{-- 1. DESKRIPSI & LATAR BELAKANG --}}
                    <section class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs">
                        <div class="flex items-center gap-3 pb-4 mb-4 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 text-[#007b83] flex items-center justify-center font-bold text-sm">
                                01
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900">
                                {{ $isEducation ? 'Deskripsi & Gambaran Program Pendidikan' : (!$program->requires_registration ? 'Deskripsi & Gambaran Kegiatan' : 'Deskripsi & Latar Belakang') }}
                            </h2>
                        </div>

                        <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed text-sm sm:text-base whitespace-pre-line">
                            @if ($program->description)
                                {{ $program->description }}
                            @elseif ($isEducation)
                                Program pendidikan dan praktik kerja lapangan/klinis di RSUD R.A.A. Tjokronegoro Purworejo diselenggarakan bagi mahasiswa institusi pendidikan mitra. Mahasiswa akan mendapatkan pengalaman pembelajaran klinis secara langsung dan komprehensif, dibimbing oleh Clinical Instructor (CI) profesional guna mengasah keterampilan teknis, etika profesi, serta kepatuhan pada standar patient safety.
                            @elseif (!$program->requires_registration)
                                Kegiatan sosialisasi ini diselenggarakan oleh RSUD R.A.A. Tjokronegoro Purworejo untuk memberikan penguatan pemahaman, penyamaan persepsi, dan sosialisasi kebijakan serta prosedur operasional standar kepada seluruh jajaran tenaga kesehatan dan petugas rumah sakit terkait.
                            @else
                                Program pelatihan ini diselenggarakan oleh Instalasi Pendidikan dan Pelatihan RSUD R.A.A. Tjokronegoro Purworejo untuk memberikan penguatan kompetensi, wawasan teoritis, serta keterampilan klinis terapan yang esensial. Seluruh materi disusun secara komprehensif berstandar Kementerian Kesehatan Republik Indonesia guna menunjang profesionalisme tenaga kesehatan dalam memberikan pelayanan bermutu dan berorientasi pada keselamatan pasien (patient safety).
                            @endif
                        </div>
                    </section>

                    {{-- 2. TUJUAN PELATIHAN / PEMBELAJARAN --}}
                    <section class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs">
                        <div class="flex items-center gap-3 pb-4 mb-4 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 text-[#007b83] flex items-center justify-center font-bold text-sm">
                                02
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900">
                                {{ $isEducation ? 'Tujuan & Capaian Kompetensi Pembelajaran' : (!$program->requires_registration ? 'Tujuan Kegiatan & Capaian Pemahaman' : 'Tujuan Pelatihan & Kompetensi') }}
                            </h2>
                        </div>

                        <div class="space-y-3">
                            @php
                                $objectivesText = $program->formatted_objectives;
                                $objectiveLines = array_filter(array_map('trim', explode("\n", $objectivesText)));
                            @endphp

                            @foreach ($objectiveLines as $line)
                                @php
                                    $cleanLine = ltrim($line, "•*-1234567890. \t");
                                @endphp
                                <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50/80 border border-slate-100">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <p class="text-xs sm:text-sm font-medium text-slate-700 leading-relaxed">
                                        {{ $cleanLine }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    {{-- 3. KURIKULUM & MATERI / RUANG LINGKUP STASE --}}
                    <section class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs">
                        <div class="flex items-center gap-3 pb-4 mb-4 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 text-[#007b83] flex items-center justify-center font-bold text-sm">
                                03
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900">
                                {{ $isEducation ? 'Ruang Lingkup Stase & Pembelajaran Klinis' : (!$program->requires_registration ? 'Materi & Pokok Bahasan Kegiatan' : 'Kurikulum & Materi Pembelajaran') }}
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            @php
                                $materialsText = $program->formatted_materials;
                                $materialLines = array_filter(array_map('trim', explode("\n", $materialsText)));
                            @endphp

                            @foreach ($materialLines as $idx => $line)
                                @php
                                    $cleanLine = ltrim($line, "•*-1234567890. \t");
                                @endphp
                                <div class="p-4 rounded-2xl bg-teal-50/40 border border-teal-100/70 hover:border-teal-300 transition">
                                    <span class="inline-block text-[11px] font-bold text-[#007b83] bg-teal-100/70 px-2 py-0.5 rounded-md mb-2">
                                        {{ $isEducation ? 'Stase / Modul ' . ($idx + 1) : (!$program->requires_registration ? 'Materi ' . ($idx + 1) : 'Modul ' . ($idx + 1)) }}
                                    </span>
                                    <p class="text-xs sm:text-sm font-semibold text-slate-800 leading-snug">
                                        {{ $cleanLine }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    {{-- 4. SASARAN & PERSYARATAN LENGKAP --}}
                    <section class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs">
                        <div class="flex items-center gap-3 pb-4 mb-4 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 text-[#007b83] flex items-center justify-center font-bold text-sm">
                                04
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900">
                                {{ $isEducation ? 'Persyaratan Mahasiswa & Berkas Institusi' : (!$program->requires_registration ? 'Ketentuan & Persyaratan Peserta' : 'Persyaratan Peserta & Berkas Administrasi') }}
                            </h2>
                        </div>

                        @if (!$program->requires_registration && !$isEducation)
                            <div class="mb-4 p-4 rounded-2xl bg-teal-50/80 border border-teal-200/80 text-xs sm:text-sm text-teal-900 flex items-start gap-3">
                                <svg class="w-5 h-5 text-teal-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <strong class="font-bold">Informasi Pelaksanaan:</strong>
                                    Kegiatan ini diselenggarakan secara terbuka/internal tanpa proses pendaftaran online dan tanpa pengunggahan berkas administrasi. Peserta yang memenuhi sasaran dapat langsung hadir di lokasi dan mengisi absensi/presensi kehadiran kegiatan.
                                </div>
                            </div>
                        @else
                            <div class="mb-4 p-4 rounded-2xl bg-amber-50/70 border border-amber-200/70 text-xs sm:text-sm text-amber-900 flex items-start gap-3">
                                <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <strong class="font-bold">Penting:</strong> 
                                    @if ($isEducation)
                                        Surat permohonan resmi dari institusi pendidikan/kampus wajib diunggah dalam format PDF saat melakukan pengisian formulir pendaftaran online.
                                    @else
                                        Seluruh berkas persyaratan diunggah saat pengisian formulir pendaftaran online dalam format PDF atau foto yang terbaca jelas.
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="space-y-3">
                            @php
                                $reqLines = $program->final_requirements_list;
                            @endphp

                            @foreach ($reqLines as $line)
                                @php
                                    $cleanLine = ltrim($line, "•*-1234567890. \t");
                                @endphp
                                <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                                    <div class="w-5 h-5 rounded-lg bg-slate-200 text-slate-700 flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">
                                        ✓
                                    </div>
                                    <p class="text-xs sm:text-sm font-medium text-slate-700 leading-relaxed">
                                        {{ $cleanLine }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    {{-- 5. FASILITAS & KEUNTUNGAN --}}
                    <section class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs">
                        <div class="flex items-center gap-3 pb-4 mb-4 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 text-[#007b83] flex items-center justify-center font-bold text-sm">
                                05
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900">
                                {{ $isEducation ? 'Fasilitas & Pembimbingan Klinis' : (!$program->requires_registration ? 'Fasilitas & Manfaat Kegiatan' : 'Fasilitas & Keuntungan Peserta') }}
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            @php
                                $facilitiesText = $program->formatted_facilities;
                                $facLines = array_filter(array_map('trim', explode("\n", $facilitiesText)));
                            @endphp

                            @foreach ($facLines as $line)
                                @php
                                    $cleanLine = ltrim($line, "•*-1234567890. \t");
                                @endphp
                                <div class="flex items-start gap-3 p-4 rounded-2xl bg-indigo-50/40 border border-indigo-100">
                                    <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs sm:text-sm font-semibold text-slate-800 leading-snug">
                                        {{ $cleanLine }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    {{-- 6. ALUR TAHAPAN PENDAFTARAN / KEIKUTSERTAAN --}}
                    <section class="bg-gradient-to-br from-slate-900 to-[#005b64] rounded-3xl p-6 sm:p-8 text-white shadow-md">
                        <h2 class="text-lg sm:text-xl font-bold mb-2">
                            @if ($isEducation)
                                Alur Pengajuan Praktik Klinis / Pendidikan
                            @elseif (!$program->requires_registration)
                                Alur &amp; Prosedur Keikutsertaan Kegiatan
                            @else
                                Alur Pendaftaran Pelatihan
                            @endif
                        </h2>
                        <p class="text-teal-100/90 text-xs sm:text-sm mb-6">
                            @if ($isEducation)
                                Pengajuan dilakukan secara mandiri melalui portal resmi Diklat RSUD R.A.A. Tjokronegoro dengan 3 tahapan ringkas:
                            @elseif (!$program->requires_registration)
                                Kegiatan sosialisasi ini tidak memerlukan pendaftaran online. Cukup ikuti 3 tahapan ringkas berikut:
                            @else
                                Pengajuan dilakukan secara mandiri melalui portal resmi Diklat RSUD R.A.A. Tjokronegoro dengan 3 tahapan ringkas:
                            @endif
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="bg-white/10 backdrop-blur-sm p-4 rounded-2xl border border-white/10">
                                <span class="w-7 h-7 rounded-full bg-[#007b83] text-white flex items-center justify-center font-bold text-xs mb-3 ring-2 ring-teal-300/40">1</span>
                                <h3 class="font-bold text-sm text-white mb-1">
                                    {{ $isEducation ? 'Formulir Pengajuan' : (!$program->requires_registration ? 'Cek Jadwal & Undangan' : 'Formulir Pengajuan') }}
                                </h3>
                                <p class="text-xs text-slate-200 leading-relaxed">
                                    @if ($isEducation)
                                        Isi data diri, asal kampus, program studi, jenjang, periode praktik, dan unggah Surat Permohonan institusi.
                                    @elseif (!$program->requires_registration)
                                        Periksa jadwal dan lokasi pelaksanaan kegiatan di aula/ruangan, serta koordinasikan penugasan dengan kepala unit kerja terkait.
                                    @else
                                        Isi identitas diri, profesi, instansi asal, dan unggah dokumen persyaratan yang diminta.
                                    @endif
                                </p>
                            </div>

                            <div class="bg-white/10 backdrop-blur-sm p-4 rounded-2xl border border-white/10">
                                <span class="w-7 h-7 rounded-full bg-[#007b83] text-white flex items-center justify-center font-bold text-xs mb-3 ring-2 ring-teal-300/40">2</span>
                                <h3 class="font-bold text-sm text-white mb-1">
                                    {{ $isEducation ? 'Resume & Konfirmasi' : (!$program->requires_registration ? 'Hadir di Lokasi' : 'Resume & Konfirmasi') }}
                                </h3>
                                <p class="text-xs text-slate-200 leading-relaxed">
                                    @if (!$program->requires_registration)
                                        Hadir tepat waktu di lokasi kegiatan (Aula RSUD R.A.A. Tjokronegoro) dan ikuti pemaparan sosialisasi secara aktif.
                                    @else
                                        Cek kembali kebenaran seluruh isian data dan konfirmasi pengiriman pengajuan.
                                    @endif
                                </p>
                            </div>

                            <div class="bg-white/10 backdrop-blur-sm p-4 rounded-2xl border border-white/10">
                                <span class="w-7 h-7 rounded-full bg-[#007b83] text-white flex items-center justify-center font-bold text-xs mb-3 ring-2 ring-teal-300/40">3</span>
                                <h3 class="font-bold text-sm text-white mb-1">
                                    {{ $isEducation ? 'Tanda Terima & Tiket' : (!$program->requires_registration ? 'Presensi / Absensi' : 'Tanda Terima & Tiket') }}
                                </h3>
                                <p class="text-xs text-slate-200 leading-relaxed">
                                    @if (!$program->requires_registration)
                                        Lakukan pengisian daftar hadir / absensi kehadiran kegiatan melalui portal Diklat saat sesi dibuka atau melalui daftar hadir panitia.
                                    @else
                                        Dapatkan bukti pengajuan resmi (PDF), nomor registrasi tiket, dan pantau status koordinasi Diklat.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </section>

                </div>

                {{-- KOLOM KANAN: STICKY SIDEBAR REGISTRASI & KONTAK (4 Cols) --}}
                <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">

                    {{-- CARD INVESTASI / MEKANISME & AKSI PENDAFTARAN --}}
                    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-md">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">
                            {{ $isEducation ? 'Mekanisme Pengajuan' : (!$program->requires_registration ? 'Mekanisme & Biaya' : 'Biaya Investasi Pelatihan') }}
                        </span>

                        <div class="mb-5">
                            @if ($isEducation)
                                <div class="text-xl sm:text-2xl font-black text-[#007b83]">
                                    Kerjasama Institusi
                                    <span class="text-xs font-normal text-slate-500 block mt-0.5">MoU / Pengajuan Kampus</span>
                                </div>
                            @elseif (!$program->requires_registration)
                                <div class="text-2xl sm:text-3xl font-black text-emerald-600">
                                    GRATIS
                                    <span class="text-xs font-normal text-slate-500 block mt-0.5 font-medium">Tanpa Biaya / Bebas Pendaftaran</span>
                                </div>
                            @elseif ($program->is_paid)
                                <div class="text-2xl sm:text-3xl font-black text-[#007b83]">
                                    Rp{{ number_format($program->fee ?? 0, 0, ',', '.') }}
                                    <span class="text-xs font-normal text-slate-500">/ peserta</span>
                                </div>
                            @else
                                <div class="text-2xl sm:text-3xl font-black text-emerald-600">
                                    GRATIS
                                    <span class="text-xs font-normal text-slate-500">/ Tanpa Biaya</span>
                                </div>
                            @endif
                        </div>

                        {{-- STATUS PENERIMAAN / KUOTA PESERTA --}}
                        @if ($isEducation)
                            <div class="p-4 rounded-2xl bg-teal-50/50 border border-teal-100/80 mb-6 space-y-1.5 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-600">Status Penerimaan:</span>
                                    <span class="font-bold text-emerald-700">Menerima Pengajuan</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-600">Kapasitas Stase:</span>
                                    <span class="font-medium text-slate-700">Sesuai Kuota Ruangan</span>
                                </div>
                                <p class="text-[11px] text-slate-500 pt-1 border-t border-teal-100">
                                    *Pengajuan diverifikasi oleh Tim Kordik Diklat RSUD.
                                </p>
                            </div>
                        @elseif ($program->requires_registration)
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 mb-6 space-y-2">
                                <div class="flex items-center justify-between text-xs font-semibold">
                                    <span class="text-slate-600">Status Ketersediaan Kuota:</span>
                                    <span class="text-[#007b83]">Sisa {{ $remaining }} dari {{ $quota }}</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-[#007b83] h-2.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%;"></div>
                                </div>
                                <div class="flex items-center justify-between text-[11px] text-slate-400">
                                    <span>Terisi {{ $filled }} orang ({{ $percentage }}%)</span>
                                    <span>Total kuota: {{ $quota }}</span>
                                </div>
                            </div>
                        @else
                            <div class="p-4 rounded-2xl bg-teal-50/60 border border-teal-100 mb-6 space-y-2 text-xs">
                                <div class="flex items-center justify-between font-semibold">
                                    <span class="text-slate-600">Sifat Kegiatan:</span>
                                    <span class="text-teal-800">Sosialisasi / Terbuka</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-600">Pendaftaran Online:</span>
                                    <span class="font-bold text-emerald-700">Tidak Diperlukan</span>
                                </div>
                                <p class="text-[11px] text-slate-500 pt-1 border-t border-teal-100">
                                    *Peserta hadir langsung di lokasi dan mengisi absensi kehadiran saat acara berlangsung.
                                </p>
                            </div>
                        @endif

                        {{-- TOMBOL AKSI UTAMA --}}
                        <div class="space-y-3">
                            @if ($isEducation)
                                <a
                                    href="{{ route('information.diklat.registration.create', $program->id) }}"
                                    class="w-full py-4 px-6 rounded-2xl font-bold text-sm sm:text-base text-white bg-[#007b83] hover:bg-[#005b64] shadow-lg shadow-teal-950/20 active:scale-[0.99] transition-all text-center flex items-center justify-center gap-2"
                                >
                                    <span>Daftar Sekarang</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            @elseif ($program->requires_registration)
                                @if ($isAvailable)
                                    <a
                                        href="{{ route('information.diklat.registration.create', $program->id) }}"
                                        class="w-full py-4 px-6 rounded-2xl font-bold text-sm sm:text-base text-white bg-[#007b83] hover:bg-[#005b64] shadow-lg shadow-teal-950/20 active:scale-[0.99] transition-all text-center flex items-center justify-center gap-2"
                                    >
                                        <span>Daftar Sekarang</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                @elseif ($status === 'penuh' || $remaining <= 0)
                                    <button
                                        type="button"
                                        disabled
                                        class="w-full py-3.5 px-6 rounded-2xl font-bold text-sm text-slate-400 bg-slate-100 border border-slate-200 cursor-not-allowed text-center"
                                    >
                                        Kuota Penuh (Pendaftaran Ditutup)
                                    </button>
                                @else
                                    <button
                                        type="button"
                                        disabled
                                        class="w-full py-3.5 px-6 rounded-2xl font-bold text-sm text-slate-400 bg-slate-100 border border-slate-200 cursor-not-allowed text-center"
                                    >
                                        Pendaftaran Ditutup
                                    </button>
                                @endif
                            @else
                                {{-- Program Pelatihan Tanpa Pendaftaran (Absensi) --}}
                                @if ($attendanceOpen)
                                    <a
                                        href="{{ route('information.diklat.attendance.create', $program->id) }}"
                                        class="w-full py-4 px-6 rounded-2xl font-bold text-sm sm:text-base text-white bg-emerald-600 hover:bg-emerald-700 shadow-md transition text-center flex items-center justify-center gap-2"
                                    >
                                        <span>Isi Kehadiran / Absensi Sekarang</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                @elseif ($attendanceNotStarted)
                                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 text-center">
                                        Absensi dimulai: {{ $program->start_at->translatedFormat('d F Y, H:i') }}
                                    </div>
                                @elseif ($attendanceEnded)
                                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-500 text-center">
                                        Periode absensi telah berakhir.
                                    </div>
                                @else
                                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 text-center font-medium">
                                        Program terbuka tanpa registrasi khusus.
                                    </div>
                                @endif
                            @endif

                            @if ($isEducation || $program->requires_registration)
                                <a
                                    href="{{ route('information.diklat.track') }}"
                                    class="w-full py-3 px-4 rounded-2xl font-semibold text-xs sm:text-sm text-slate-600 bg-slate-100 hover:bg-slate-200 transition text-center flex items-center justify-center gap-2"
                                >
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                    </svg>
                                    <span>Lacak Status Tiket Pengajuan</span>
                                </a>
                            @endif
                        </div>

                        {{-- INFORMASI REKENING PEMBAYARAN JIKA BERBAYAR (PELATIHAN) --}}
                        @if (!$isEducation && $program->is_paid && ($program->payment_bank_name || $program->payment_account_number))
                            <div class="mt-6 pt-5 border-t border-slate-100 space-y-3">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-600 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                    Rekening Pembayaran Resmi:
                                </h3>
                                <div class="p-3.5 rounded-2xl bg-teal-50/50 border border-teal-100 text-xs space-y-1.5">
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Bank Tujuan:</span>
                                        <span class="font-bold text-slate-800">{{ $program->payment_bank_name ?: 'Bank Jateng' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Nomor Rekening:</span>
                                        <span class="font-mono font-bold text-[#007b83] text-sm">{{ $program->payment_account_number }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Atas Nama:</span>
                                        <span class="font-medium text-slate-800">{{ $program->payment_account_name ?: 'RSUD RAA Tjokronegoro' }}</span>
                                    </div>
                                </div>
                                <p class="text-[11px] text-slate-400 leading-tight">
                                    *Simpan bukti transfer untuk diunggah saat pengisian formulir registrasi.
                                </p>
                            </div>
                        @elseif ($isEducation)
                            <div class="mt-6 pt-5 border-t border-slate-100 space-y-2 text-[11px] text-slate-500 leading-relaxed">
                                <strong class="font-bold text-slate-700 block text-xs">Catatan Pengajuan Institusi:</strong>
                                Pengajuan praktik mahasiswa disesuaikan dengan kuota kapasitas stase dan ketersediaan Clinical Instructor (CI) di setiap ruangan pelayanan RSUD R.A.A. Tjokronegoro.
                            </div>
                        @endif
                    </div>

                    {{-- CARD NARAHUBUNG / HELPDESK --}}
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#007b83] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">{{ $isEducation ? 'Narahubung Komkordik / Diklat' : 'Narahubung & Bantuan Diklat' }}</h3>
                                <p class="text-xs text-slate-500">RSUD R.A.A. Tjokronegoro</p>
                            </div>
                        </div>

                        <p class="text-xs text-slate-600 leading-relaxed">
                            @if ($isEducation)
                                Memerlukan konfirmasi jadwal praktik, koordinasi MoU institusi, atau ketersediaan stase ruangan?
                            @elseif (!$program->requires_registration)
                                Membutuhkan informasi teknis pelaksanaan sosialisasi, materi kegiatan, atau koordinasi kehadiran unit kerja?
                            @else
                                Membutuhkan informasi teknis terkait pelatihan, persyaratan khusus, atau permohonan rombongan instansi?
                            @endif
                        </p>

                        <div class="space-y-2 text-xs">
                            <div class="flex items-center gap-2.5 text-slate-600">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span>WhatsApp: <strong>{{ $program->contact_person ?: '0811-2856-214' }}</strong></span>
                            </div>

                            <div class="flex items-center gap-2.5 text-slate-600">
                                <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span>Email: <strong>diklat@rsudtjokronegoro.purworejokab.go.id</strong></span>
                            </div>

                            <div class="flex items-center gap-2.5 text-slate-600">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Layanan: Senin - Jumat (08.00 - 15.00 WIB)</span>
                            </div>
                        </div>

                        @php
                            $phoneClean = preg_replace('/[^0-9]/', '', (string) ($program->contact_person ?: '08112856214'));
                            if (str_starts_with($phoneClean, '0')) {
                                $waNumber = '62' . substr($phoneClean, 1);
                            } else {
                                $waNumber = $phoneClean;
                            }
                            $waMessage = rawurlencode(
                                $isEducation
                                    ? 'Halo Admin Diklat RSUD R.A.A. Tjokronegoro, saya ingin menanyakan informasi pengajuan ' . $program->name
                                    : (!$program->requires_registration
                                        ? 'Halo Admin Diklat RSUD R.A.A. Tjokronegoro, saya ingin menanyakan informasi kegiatan sosialisasi ' . $program->name
                                        : 'Halo Admin Diklat RSUD R.A.A. Tjokronegoro, saya ingin menanyakan informasi pendaftaran ' . $program->name)
                            );
                        @endphp

                        <a
                            href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-full py-2.5 px-4 rounded-xl font-bold text-xs text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition text-center flex items-center justify-center gap-2"
                        >
                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.173.086.275.071.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/>
                            </svg>
                            <span>Chat via WhatsApp</span>
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </main>

    {{-- MODAL PDF VIEWER BROSUR PELATIHAN --}}
    @include('public.information.partials.diklat-brochure-modal')

</x-layouts.app>
