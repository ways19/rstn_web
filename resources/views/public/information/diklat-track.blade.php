<x-layouts.app
    title="Lacak Pendaftaran Diklat — RSUD R.A.A. Tjokronegoro"
    meta-description="Layanan pelacakan status pendaftaran program pendidikan dan pelatihan di RSUD R.A.A. Tjokronegoro."
>

    <x-page-header
        title="Pendidikan & Pelatihan"
        description="Informasi mengenai program pendidikan dan pelatihan di RSUD R.A.A. Tjokronegoro."
    />

    {{-- Submenu Pendidikan & Pelatihan --}}
    <x-submenus.diklat active="track" />

    {{-- Breadcrumb --}}
    <div class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 py-4 text-sm" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="font-medium text-slate-500 hover:text-[#007b83]">Beranda</a>
                <span class="text-slate-300">›</span>
                <a href="{{ url('/informasi/pendidikan-pelatihan') }}" class="font-medium text-slate-500 hover:text-[#007b83]">Diklat</a>
                <span class="text-slate-300">›</span>
                <span class="font-semibold text-[#007b83]">Lacak Pendaftaran</span>
            </nav>
        </div>
    </div>

    {{-- Konten Utama --}}
    <section class="bg-slate-50 pb-16 pt-6">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- FORM PENCARIAN TIKET --}}
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-50 text-teal-800 border border-teal-200/60 mb-2">
                        <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                        Pelacakan Status Pengajuan Diklat
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        Masukkan Nomor Pendaftaran Diklat
                    </h2>
                    <p class="mt-1.5 text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Pantau progres verifikasi berkas administrasi dan konfirmasi penerimaan peserta secara real-time.
                    </p>
                </div>

                <form method="GET" action="{{ route('information.diklat.track') }}" class="mt-6">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input
                                type="text"
                                name="nomor"
                                value="{{ request('nomor', $ticketNumber ?? '') }}"
                                placeholder="Contoh: DKL-20261111-2ISPBQ"
                                required
                                class="w-full rounded-2xl border border-slate-300 bg-white pl-11 pr-4 py-3.5 text-sm font-medium text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#007b83] focus:ring-4 focus:ring-teal-600/10 uppercase"
                            >
                        </div>
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#007b83] px-7 py-3.5 text-sm font-bold text-white shadow transition hover:bg-[#005b64] active:scale-98 shrink-0"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span>Lacak Status</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- HASIL PENCARIAN JIKA SUDAH DICARI --}}
            @if ($searched)
                @if ($registration)
                    @php
                        $status = strtolower($registration->status ?? 'diajukan');
                        $isRejected = in_array($status, ['ditolak', 'gagal']);
                        $isFinished = in_array($status, ['diterima', 'disetujui', 'selesai']);

                        $statusBadgeClass = match($status) {
                            'diajukan' => 'bg-amber-50 text-amber-800 border-amber-200 ring-1 ring-amber-500/20',
                            'diverifikasi' => 'bg-sky-50 text-sky-800 border-sky-200 ring-1 ring-sky-500/20',
                            'diproses' => 'bg-indigo-50 text-indigo-800 border-indigo-200 ring-1 ring-indigo-500/20',
                            'diterima', 'disetujui' => 'bg-emerald-50 text-emerald-800 border-emerald-200 ring-1 ring-emerald-500/20',
                            'selesai' => 'bg-teal-50 text-teal-800 border-teal-200 ring-1 ring-teal-500/20',
                            'ditolak', 'gagal' => 'bg-rose-50 text-rose-800 border-rose-200 ring-1 ring-rose-500/20',
                            default => 'bg-slate-50 text-slate-800 border-slate-200'
                        };

                        $statusLabel = match($status) {
                            'diajukan' => 'Pendaftaran Diajukan',
                            'diverifikasi' => 'Pemeriksaan Administrasi',
                            'diproses' => 'Sedang Diproses Panitia',
                            'diterima', 'disetujui' => 'Pengajuan Disetujui / Diterima',
                            'selesai' => 'Program Selesai',
                            'ditolak', 'gagal' => 'Pengajuan Ditolak',
                            default => ucfirst($status)
                        };

                        $statusExplanation = match($status) {
                            'diajukan' => 'Data Anda telah tersimpan di sistem dan menunggu antrean verifikasi administrasi oleh panitia Diklat.',
                            'diverifikasi' => 'Berkas pendaftaran Anda sedang dalam tahap pemeriksaan dokumen dan kelayakan administrasi.',
                            'diproses' => 'Pengajuan sedang dikoordinasikan dengan ruangan / pembimbing program terkait ketersediaan jadwal & kuota.',
                            'diterima', 'disetujui' => 'Selamat! Pengajuan Anda telah disetujui. Silakan periksa instruksi lanjutan atau konfirmasi ke instalasi Diklat.',
                            'selesai' => 'Seluruh tahapan program dan registrasi ini telah selesai.',
                            'ditolak', 'gagal' => 'Pengajuan pendaftaran belum dapat disetujui. Silakan periksa catatan dari petugas panitia di bawah ini.',
                            default => 'Status pengajuan Anda sedang diperbarui oleh sistem Diklat RSUD.'
                        };

                        $stageIndex = match($status) {
                            'diajukan' => 1,
                            'diverifikasi' => 2,
                            'diproses' => 3,
                            'diterima', 'disetujui', 'selesai', 'ditolak', 'gagal' => 4,
                            default => 1
                        };

                        $timelineSteps = [
                            [
                                'title' => 'Pendaftaran Diajukan',
                                'desc' => 'Data formulir dan berkas berhasil masuk ke sistem.',
                                'date' => $registration->created_at?->translatedFormat('d F Y, H:i') . ' WIB',
                                'done' => true,
                            ],
                            [
                                'title' => 'Verifikasi Administrasi',
                                'desc' => 'Pemeriksaan kelengkapan dokumen dan kualifikasi oleh petugas.',
                                'date' => $stageIndex >= 2 ? ($registration->updated_at?->translatedFormat('d F Y') ?? '-') : null,
                                'done' => $stageIndex >= 2,
                            ],
                            [
                                'title' => 'Konfirmasi Program',
                                'desc' => 'Koordinasi kuota dan persetujuan kepala instalasi/pembimbing.',
                                'date' => $stageIndex >= 3 ? ($registration->updated_at?->translatedFormat('d F Y') ?? '-') : null,
                                'done' => $stageIndex >= 3,
                            ],
                            [
                                'title' => $isRejected ? 'Hasil Akhir (Ditolak)' : 'Hasil Akhir (Selesai/Diterima)',
                                'desc' => $isRejected ? 'Pengajuan belum dapat disetujui panitia.' : 'Konfirmasi kelulusan / penerimaan peserta.',
                                'date' => $stageIndex >= 4 ? ($registration->updated_at?->translatedFormat('d F Y') ?? '-') : null,
                                'done' => $stageIndex >= 4,
                            ],
                        ];
                    @endphp

                    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-md space-y-6">
                        {{-- Card Header Status --}}
                        <div class="border-b border-slate-100 bg-slate-50/60 p-6 sm:p-8">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Nomor Registrasi</span>
                                    <div class="mt-1 flex items-center gap-2">
                                        <h3 class="font-mono text-xl sm:text-2xl font-black text-slate-900">{{ $registration->registration_number }}</h3>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">Diajukan pada {{ $registration->created_at?->translatedFormat('d F Y, H:i') ?? '-' }} WIB</p>
                                </div>

                                <div class="flex flex-col sm:items-end">
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Status Saat Ini</span>
                                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs sm:text-sm font-extrabold {{ $statusBadgeClass }}">
                                        @if ($isRejected)
                                            ✕
                                        @elseif ($isFinished)
                                            ✓
                                        @else
                                            ●
                                        @endif
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                            </div>

                            <p class="mt-4 text-xs sm:text-sm text-slate-600 bg-white p-3.5 rounded-xl border border-slate-200">
                                {{ $statusExplanation }}
                            </p>
                        </div>

                        {{-- Catatan Petugas (Jika Ada) --}}
                        @if (!empty($registration->admin_notes))
                            <div class="px-6 sm:px-8">
                                <div class="rounded-2xl border border-amber-200 bg-amber-50/80 p-4.5 sm:p-5">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 rounded-lg bg-amber-100 p-1.5 text-amber-800">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="space-y-1">
                                            <h4 class="text-xs font-bold uppercase tracking-wider text-amber-900">Catatan Petugas Diklat</h4>
                                            <p class="text-xs sm:text-sm text-amber-950 font-medium whitespace-pre-line leading-relaxed">
                                                {{ $registration->admin_notes }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- TIMELINE PENGAJUAN --}}
                        <div class="px-6 sm:px-8 space-y-4">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Perkembangan</span>
                                    <h4 class="text-base font-black text-slate-900">Timeline Tahapan Seleksi</h4>
                                </div>
                                <span class="text-xs text-slate-400">Tahap {{ $stageIndex }} dari 4</span>
                            </div>

                            <div class="relative pl-6 sm:pl-8 space-y-6 before:absolute before:left-2.5 sm:before:left-3 before:top-3 before:bottom-3 before:w-0.5 before:bg-slate-200">
                                @foreach ($timelineSteps as $index => $step)
                                    @php
                                        $stepNum = $index + 1;
                                        $isCurrent = ($stepNum === $stageIndex);
                                        $isDone = $step['done'];
                                    @endphp
                                    <div class="relative flex items-start gap-4">
                                        {{-- Marker Bulat --}}
                                        <div class="absolute -left-6 sm:-left-8 flex h-6 w-6 items-center justify-center rounded-full text-xs font-bold ring-4 ring-white
                                            {{ $isDone ? ($isRejected && $stepNum === 4 ? 'bg-rose-600 text-white' : 'bg-teal-600 text-white') : 'bg-slate-200 text-slate-500' }}">
                                            @if ($isDone)
                                                @if ($isRejected && $stepNum === 4)
                                                    ✕
                                                @else
                                                    ✓
                                                @endif
                                            @else
                                                {{ $stepNum }}
                                            @endif
                                        </div>

                                        {{-- Konten Step --}}
                                        <div class="min-w-0 flex-1 pt-0.5">
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                                                <h5 class="text-sm font-bold {{ $isDone ? 'text-slate-900' : 'text-slate-500' }}">
                                                    {{ $step['title'] }}
                                                    @if ($isCurrent)
                                                        <span class="ml-2 inline-block px-2 py-0.5 text-[10px] font-extrabold uppercase rounded bg-teal-100 text-teal-800">Tahap Aktif</span>
                                                    @endif
                                                </h5>
                                                @if ($step['date'])
                                                    <span class="text-[11px] font-medium text-slate-400">{{ $step['date'] }}</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ $step['desc'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- DETAIL PESERTA & PROGRAM --}}
                        <div class="px-6 sm:px-8 space-y-3">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-600 pb-2 border-b border-slate-100">
                                Informasi Lengkap Pendaftar & Program
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <div class="space-y-2.5 bg-slate-50/70 p-4 rounded-2xl border border-slate-200/80">
                                    <span class="block text-[11px] font-bold text-teal-800 uppercase tracking-wider">Identitas Pendaftar</span>
                                    <div>
                                        <span class="text-slate-500 block">Nama Lengkap:</span>
                                        <strong class="text-slate-900 text-sm font-bold">{{ $registration->full_name }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block">Instansi Asal:</span>
                                        <span class="text-slate-900 font-semibold">{{ $registration->institution }}</span>
                                    </div>
                                    @if ($registration->study_program)
                                        <div>
                                            <span class="text-slate-500 block">Program Studi / Jurusan:</span>
                                            <span class="text-slate-900">{{ $registration->study_program }} ({{ $registration->education_level ?: '-' }})</span>
                                        </div>
                                    @endif
                                    <div>
                                        <span class="text-slate-500 block">Kontak:</span>
                                        <span class="text-slate-900">{{ $registration->phone }} | {{ $registration->email }}</span>
                                    </div>
                                    @if ($registration->purpose)
                                        <div>
                                            <span class="text-slate-500 block">Tujuan Mengikuti:</span>
                                            <span class="text-slate-900">{{ $registration->purpose }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="space-y-2.5 bg-slate-50/70 p-4 rounded-2xl border border-slate-200/80">
                                    <span class="block text-[11px] font-bold text-teal-800 uppercase tracking-wider">Program Diklat</span>
                                    <div>
                                        <span class="text-slate-500 block">Nama Program:</span>
                                        <strong class="text-teal-700 text-sm font-bold">
                                            {{ $registration->program?->title ?? $registration->program?->name ?? 'Program Diklat' }}
                                        </strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block">Kategori:</span>
                                        <span class="text-slate-900 font-semibold">{{ ucfirst($registration->program?->category ?? 'Pendidikan') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block">Periode Pelaksanaan:</span>
                                        <span class="text-slate-900">
                                            @if ($registration->practice_start_date && $registration->practice_end_date)
                                                {{ $registration->practice_start_date->translatedFormat('d M Y') }} s/d {{ $registration->practice_end_date->translatedFormat('d M Y') }}
                                            @else
                                                Sesuai jadwal program
                                            @endif
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block">Lokasi:</span>
                                        <span class="text-slate-900">{{ $registration->program?->location ?: 'RSUD R.A.A. Tjokronegoro' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- TOMBOL AKSI: UNDUH BUKTI PENDAFTARAN (PDF) --}}
                        <div class="p-6 sm:p-8 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <a
                                href="{{ route('information.diklat.registration.proof', $registration->registration_number) }}"
                                download="Bukti-Pendaftaran-{{ $registration->registration_number }}.pdf"
                                class="inline-flex w-full sm:w-auto items-center justify-center gap-2.5 px-6 py-3.5 rounded-2xl bg-[#007b83] hover:bg-[#005b64] text-white text-xs sm:text-sm font-bold shadow transition active:scale-98"
                            >
                                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Unduh Lembar Bukti Pendaftaran (PDF)</span>
                            </a>

                            <a
                                href="{{ url('/informasi/pendidikan-pelatihan') }}"
                                class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-5 py-3 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 text-xs font-bold transition"
                            >
                                <span>Lihat Program Diklat Lainnya</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @else
                    {{-- JIKA TIKET TIDAK DITEMUKAN --}}
                    <div class="rounded-3xl border border-rose-200 bg-rose-50/70 p-8 text-center space-y-4">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-100 text-rose-700 ring-4 ring-rose-200/50">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900">Nomor Pendaftaran Tidak Ditemukan</h3>
                            <p class="mt-1 text-xs sm:text-sm text-slate-600 max-w-md mx-auto">
                                Kami tidak dapat menemukan data dengan nomor <strong>"{{ $ticketNumber }}"</strong>. Pastikan Anda memasukkan kode pendaftaran lengkap seperti pada lembar bukti tanda terima (contoh: <code>DKL-20261111-XXXXXX</code>).
                            </p>
                        </div>
                        <div class="pt-2">
                            <a href="{{ route('information.diklat.track') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition">
                                ↺ Reset Pencarian
                            </a>
                        </div>
                    </div>
                @endif
            @else
                {{-- PANDUAN PELACAKAN JIKA BELUM SEARCH --}}
                <div class="rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 space-y-6">
                    <h3 class="text-base font-bold text-slate-900 pb-2 border-b border-slate-100">
                        Panduan Pelacakan Status Diklat
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
                        <div class="space-y-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-teal-50 text-teal-800 font-black text-sm border border-teal-200">
                                1
                            </div>
                            <h4 class="font-bold text-slate-900">Periksa Nomor Registrasi</h4>
                            <p class="text-slate-500 leading-relaxed">
                                Dapatkan nomor pendaftaran Anda dari lembar bukti tanda terima pendaftaran (diawali kode <code>DKL-</code>) yang telah Anda unduh saat selesai mengisi formulir.
                            </p>
                        </div>

                        <div class="space-y-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-teal-50 text-teal-800 font-black text-sm border border-teal-200">
                                2
                            </div>
                            <h4 class="font-bold text-slate-900">Ketikkan di Kolom Pelacakan</h4>
                            <p class="text-slate-500 leading-relaxed">
                                Masukkan nomor pendaftaran ke kolom pencarian di atas, lalu klik <strong>Lacak Status</strong>.
                            </p>
                        </div>

                        <div class="space-y-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-teal-50 text-teal-800 font-black text-sm border border-teal-200">
                                3
                            </div>
                            <h4 class="font-bold text-slate-900">Pantau Hasil & Unduh Berkas</h4>
                            <p class="text-slate-500 leading-relaxed">
                                Anda dapat melihat posisi berkas pada timeline pengajuan, membaca catatan petugas, serta mengunduh kembali dokumen bukti pendaftaran kapan saja.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>

</x-layouts.app>
