@forelse ($diklatPrograms as $program)
    @php
        $category = strtolower(trim($program->category ?? ''));
        $status = strtolower(trim($program->status ?? ''));

        $isEducation = (isset($programType) && $programType === 'pendidikan')
            || !in_array($category, ['pelatihan', 'orientasi']);

        $isQuotaFull = !$isEducation
            && $program->requires_registration
            && (int) ($program->remaining_quota ?? 0) <= 0;

        $isAvailable = $isEducation
            ? true
            : (
                !$program->requires_registration
                    ? true
                    : in_array($status, ['dibuka', 'terbatas'])
                        && (int) ($program->remaining_quota ?? 0) > 0
            );

        if ($isEducation) {
            $statusLabel = $isAvailable
                ? 'Menerima Pengajuan'
                : 'Pengajuan Ditutup';
        } elseif (!$program->requires_registration) {
            $statusLabel = 'Tanpa Pendaftaran';
        } else {
            $statusLabels = [
                'dibuka' => 'Masih Dibuka',
                'terbatas' => 'Kuota Terbatas',
                'penuh' => 'Kuota Penuh',
                'ditutup' => 'Pendaftaran Ditutup',
            ];

            $statusLabel = $isQuotaFull
                ? 'Kuota Penuh'
                : ($statusLabels[$status] ?? 'Informasi Program');
        }

        // Teks harga pada badge banner
        if ($isEducation) {
            $priceText = 'Gratis';
        } else {
            $priceText = ($program->requires_registration && $program->is_paid && ($program->fee ?? 0) > 0)
                ? 'Rp ' . number_format($program->fee, 0, ',', '.')
                : 'Gratis';
        }

        // Gambar Card Program: utamakan foto upload, fallback ke foto ilustrasi
        $cardImage = $program->image_url;
        if (!$cardImage) {
            $cardImage = $isEducation
                ? asset('images/rsud-header.png')
                : asset('images/hospital-room-360.jpg');
        }

        // Kuota pelatihan
        $remaining = 0;
        $quota = 0;
        $filled = 0;
        $percentage = 0;

        if (!$isEducation && $program->requires_registration) {
            $remaining = (int) ($program->remaining_quota ?? 0);
            $quota = (int) ($program->quota ?? 0);
            $filled = max(0, $quota - $remaining);
            $percentage = $quota > 0
                ? min(100, max(0, round(($filled / $quota) * 100)))
                : 0;
        }

        // Tanggal / Jadwal
        $scheduleText = trim((string) ($program->schedule ?? ''));
        if ($scheduleText === '-' || $scheduleText === '') {
            $scheduleText = null;
        }
        if ($program->start_at) {
            $scheduleText = $program->start_at->translatedFormat('d M Y');
            if ($program->end_at && !$program->end_at->isSameDay($program->start_at)) {
                $scheduleText = $program->start_at->translatedFormat('d') . ' - ' . $program->end_at->translatedFormat('d M Y');
            }
        } elseif (!$scheduleText) {
            $scheduleText = $isEducation ? 'Sesuai pengajuan dan persetujuan rumah sakit' : 'Sesuai konfirmasi';
        }

        // Lokasi
        $locationText = $program->location ?: ($isEducation ? 'RSUD R.A.A Tjokronegoro' : 'Instalasi Diklat & RSUD');

        // Lingkup Peserta: Internal, Eksternal, atau Internal & Eksternal
        $targetSlug = strtolower(trim($program->participant_target ?? ''));
        if ($targetSlug === 'internal') {
            $scopeDisplay = 'Internal';
        } elseif (in_array($targetSlug, ['eksternal', 'publik'])) {
            $scopeDisplay = 'Eksternal';
        } elseif (in_array($targetSlug, ['keduanya', 'internal_eksternal', 'internal & eksternal', 'semua'])) {
            $scopeDisplay = 'Internal & Eksternal';
        } else {
            $lowerTarget = strtolower(($program->target ?? '') . ' ' . ($program->target_description ?? ''));
            if (str_contains($lowerTarget, 'internal') && (str_contains($lowerTarget, 'eksternal') || str_contains($lowerTarget, 'umum') || str_contains($lowerTarget, 'publik') || str_contains($lowerTarget, 'mitra'))) {
                $scopeDisplay = 'Internal & Eksternal';
            } elseif (str_contains($lowerTarget, 'internal')) {
                $scopeDisplay = 'Internal';
            } elseif (str_contains($lowerTarget, 'eksternal') || str_contains($lowerTarget, 'umum') || str_contains($lowerTarget, 'mahasiswa') || str_contains($lowerTarget, 'siswa')) {
                $scopeDisplay = 'Eksternal';
            } else {
                $scopeDisplay = $isEducation ? 'Eksternal' : 'Internal & Eksternal';
            }
        }
    @endphp

    <article class="diklat-item-card {{ $isEducation ? 'diklat-card-education' : 'diklat-card-training' }}">
        {{-- HEADER GAMBAR DENGAN OVERLAY BADGE --}}
        <div class="diklat-card-banner">
            <img
                src="{{ $cardImage }}"
                alt="{{ $program->name }}"
                loading="lazy"
            >

            {{-- Overlay Kiri Atas: Status --}}
            <div class="diklat-badge-overlay-status {{ !$isAvailable ? 'status-closed' : '' }}">
                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    @if ($isAvailable)
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    @else
                        <circle cx="10" cy="10" r="6" />
                    @endif
                </svg>
                <span>{{ $statusLabel }}</span>
            </div>

            {{-- Overlay Kanan Atas: Tombol Brosur (Hanya jika berkas brosur diunggah) --}}
            @if (!$isEducation && $program->flyer_image)
                <button
                    type="button"
                    class="diklat-badge-overlay-brochure"
                    onclick="openDiklatBrochureModal('{{ route('information.diklat.brochure', $program->id) }}', '{{ addslashes($program->name) }}')"
                    title="Buka brosur pelatihan (PDF Viewer)"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Brosur</span>
                </button>
            @endif

            {{-- Overlay Kanan Bawah: Biaya (Khusus Pelatihan / Non-Pendidikan) --}}
            @if (!$isEducation)
                <div class="diklat-badge-overlay-price">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12.97 2.59a1.5 1.5 0 00-1.06-.44H4.5A2.5 2.5 0 002 4.65v7.41c0 .4.16.78.44 1.06l9.5 9.5a1.5 1.5 0 002.12 0l7.41-7.41a1.5 1.5 0 000-2.12l-8.5-8.5zM6.5 8a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/>
                    </svg>
                    <span>{{ $priceText }}</span>
                </div>
            @endif
        </div>

        {{-- BODY CARD: SIMPEL & RAPAT --}}
        <div class="diklat-item-card-body">
            {{-- Kategori Pill --}}
            <span class="diklat-category-pill {{ $isEducation ? 'diklat-category-pill--education' : 'diklat-category-pill--training' }}">
                {{ $isEducation ? 'Pendidikan' : 'Pelatihan' }}
            </span>

            {{-- Judul Program --}}
            <h4 class="diklat-card-title">
                <a href="{{ route('information.diklat.detail', $program->id) }}">
                    {{ $program->name }}
                </a>
            </h4>

            {{-- Metadata Ringkas --}}
            <div class="diklat-card-meta">
                <div class="meta-row">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <span>{{ $scheduleText }}</span>
                </div>

                <div class="meta-row">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span>{{ $locationText }}</span>
                </div>

                @if (!$isEducation)
                    <div class="meta-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                        <span>Lingkup: <strong class="text-slate-700 font-semibold">{{ $scopeDisplay }}</strong></span>
                    </div>
                @endif
            </div>

            {{-- Kuota Progress (Khusus Pelatihan Pendaftaran) --}}
            @if ($program->requires_registration && !$isEducation)
                <div class="diklat-progress-wrap">
                    <div class="progress-labels">
                        <span>Terisi {{ $filled }} / {{ $quota }}</span>
                        <span class="quota-left">Sisa {{ $remaining }}</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $percentage }}%;"></div>
                    </div>
                </div>
            @endif

            <div class="diklat-card-divider"></div>

            {{-- FOOTER AKSI: TOMBOL LIHAT DETAIL DI SEBELAH KANAN --}}
            <div class="diklat-card-footer" style="display: flex !important; align-items: center !important; justify-content: flex-end !important; width: 100% !important;">
                @if (!$isEducation && $program->flyer_image)
                    <button
                        type="button"
                        onclick="openDiklatBrochureModal('{{ route('information.diklat.brochure', $program->id) }}', '{{ addslashes($program->name) }}')"
                        class="diklat-footer-brochure-btn"
                        title="Lihat Brosur (PDF)"
                        style="margin-right: auto !important;"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Brosur</span>
                    </button>
                @endif

                <a
                    href="{{ route('information.diklat.detail', $program->id) }}"
                    class="diklat-action-link"
                    style="margin-left: auto !important;"
                >
                    <span>Lihat Detail</span>
                    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </article>
@empty
    <div class="diklat-program-empty">
        <p>Belum ada program yang tersedia saat ini.</p>
    </div>
@endforelse
