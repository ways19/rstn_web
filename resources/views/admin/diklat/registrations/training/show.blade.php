
<x-layouts.admin title="Detail Pendaftaran Pelatihan">
    @php
        $status = strtolower($registration->status ?? 'diajukan');

        $statusLabels = [
            'diajukan' => 'Diajukan',
            'diverifikasi' => 'Diverifikasi',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        $statusClasses = [
            'diajukan' => 'bg-blue-50 text-blue-700',
            'diverifikasi' => 'bg-indigo-50 text-indigo-700',
            'diproses' => 'bg-amber-50 text-amber-700',
            'selesai' => 'bg-emerald-50 text-emerald-700',
            'ditolak' => 'bg-red-50 text-red-700',
        ];

        $statusLabel = $statusLabels[$status] ?? ucfirst($status);
        $statusClass = $statusClasses[$status] ?? 'bg-gray-100 text-gray-700';
    @endphp

    <div class="space-y-4 pb-4">

        {{-- HEADER --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <a href="{{ route('admin.diklat.registrations.training.index') }}"
                    class="mb-2 inline-flex items-center gap-1.5 text-xs font-medium text-gray-500 hover:text-blue-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke daftar
                </a>

                <h1 class="text-xl font-bold text-gray-900">
                    Detail Pendaftaran Pelatihan
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $registration->registration_number ?: 'Nomor pendaftaran tidak tersedia' }}
                    <span class="mx-1.5 text-gray-300">•</span>
                    {{ $registration->created_at?->format('d/m/Y H:i') ?? '-' }}
                </p>
            </div>

            <span class="inline-flex items-center rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClass }}">
                {{ $statusLabel }}
            </span>
        </div>

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-semibold">Periksa kembali data berikut:</p>
                <ul class="mt-1 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- INFORMASI PENDAFTARAN --}}
        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-3">
                <h2 class="text-sm font-bold text-gray-800">Informasi Pendaftaran</h2>
                <span class="text-xs text-gray-400">
                    Diperbarui {{ $registration->updated_at?->format('d/m/Y H:i') ?? '-' }}
                </span>
            </div>

            <div class="grid grid-cols-1 gap-x-8 gap-y-4 px-5 py-4 sm:grid-cols-2">

                {{-- INFORMASI PEMOHON --}}
                <div>
                    <p class="text-xs text-gray-500">Nomor Pendaftaran</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{ $registration->registration_number ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Nama Lengkap</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{ $registration->full_name ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Institusi</p>
                    <p class="mt-1 text-sm font-medium text-gray-800">
                        {{ $registration->institution ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Nomor Telepon</p>
                    <p class="mt-1 text-sm text-gray-800">
                        {{ $registration->phone ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Email</p>
                    <p class="mt-1 break-all text-sm text-gray-800">
                        {{ $registration->email ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Nomor STR (Tenaga Kesehatan)</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{ $registration->str_number ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">ID Plataran Sehat / SatuSehat SDMK</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{ $registration->satusehat_id ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Tanggal Pengajuan</p>
                    <p class="mt-1 text-sm text-gray-800">
                        {{ $registration->created_at?->format('d/m/Y H:i') ?? '-' }}
                    </p>
                </div>

                {{-- INFORMASI PROGRAM --}}
                <div>
                    <p class="text-xs text-gray-500">Nama Program Pelatihan</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{ $registration->program?->name ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Jenis Program</p>
                    <p class="mt-1 text-sm text-gray-800">
                        {{ $registration->program?->category ? ucfirst($registration->program->category) : '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Tanggal Mulai</p>
                    <p class="mt-1 text-sm text-gray-800">
                        {{ ($registration->practice_start_date ?? $registration->program?->start_at)?->format('d/m/Y') ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Tanggal Selesai</p>
                    <p class="mt-1 text-sm text-gray-800">
                        {{ ($registration->practice_end_date ?? $registration->program?->end_at)?->format('d/m/Y') ?? '-' }}
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-xs text-gray-500">Tujuan Pendaftaran</p>
                    <p class="mt-1 whitespace-pre-line text-sm text-gray-800">
                        {{ $registration->purpose ?: '-' }}
                    </p>
                </div>
            </div>
        </section>

        {{-- BERKAS & DOKUMEN PERSYARATAN --}}
        @php
            $program = $registration->program;
            $trainingPhotos = $registration->id_photos ?? [];

            // Evaluasi dokumen yang ditampilkan:
            // 1. Bukti Pembayaran: Tampilkan jika peserta mengunggah bukti bayar, ATAU jika program berbayar.
            $showPayment = !empty($registration->payment_proof_path) || (bool) $program?->is_paid;

            // 2. Berkas administrasi (Surat Tugas, Scan STR, Pas Foto):
            // HANYA tampilkan dokumen jika:
            // - Peserta memang mengunggahnya (ada file), ATAU
            // - Program secara spesifik mengaktifkan/memintanya di formulir pendaftaran
            $showAssignment = !empty($registration->assignment_letter_path);
            $showStr = !empty($registration->str_file_path) || (bool) $program?->requires_str_file;
            $showPhoto = !empty($trainingPhotos) || (bool) $program?->requires_id_photo;

            $hasAnyDocument = $showPayment || $showAssignment || $showStr || $showPhoto;
        @endphp

        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-5 py-3">
                <h2 class="text-sm font-bold text-gray-800">
                    Dokumen &amp; Berkas Persyaratan
                </h2>
                <p class="mt-0.5 text-xs text-gray-500">
                    Berkas kelengkapan administrasi yang diunggah oleh pendaftar pelatihan.
                </p>
            </div>

            <div class="divide-y divide-gray-100">
                {{-- Bukti Pembayaran (jika program berbayar atau pendaftar upload bukti) --}}
                @if ($showPayment)
                    <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    Bukti Pembayaran Registrasi
                                    @if ($registration->program?->fee)
                                        <span class="text-xs text-emerald-700 font-semibold">(Rp {{ number_format((int) $registration->program->fee, 0, ',', '.') }})</span>
                                    @endif
                                </p>
                                <p class="mt-0.5 text-xs text-gray-500">
                                    {{ $registration->payment_proof_path ? basename($registration->payment_proof_path) : 'Belum ada bukti pembayaran yang diunggah' }}
                                </p>
                                @if ($registration->payment_sender_name || $registration->payment_sender_account_number)
                                    <div class="mt-2 flex flex-wrap items-center gap-1.5 text-xs text-gray-700">
                                        <span class="inline-flex items-center gap-1 rounded bg-slate-100 px-2 py-0.5 font-medium">
                                            <span class="text-slate-400">Atas Nama:</span>
                                            <span class="font-semibold text-gray-900">{{ $registration->payment_sender_name ?: '-' }}</span>
                                        </span>
                                        <span class="inline-flex items-center gap-1 rounded bg-slate-100 px-2 py-0.5 font-medium">
                                            <span class="text-slate-400">No. Rek:</span>
                                            <span class="font-mono font-semibold text-gray-900">{{ $registration->payment_sender_account_number ?: '-' }}</span>
                                        </span>
                                        @if ($registration->payment_sender_bank)
                                            <span class="inline-flex items-center gap-1 rounded bg-slate-100 px-2 py-0.5 font-medium">
                                                <span class="text-slate-400">Bank:</span>
                                                <span class="font-semibold text-gray-900">{{ $registration->payment_sender_bank }}</span>
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($registration->payment_proof_path)
                            <a href="{{ route('admin.diklat.registrations.training.payment-proof', $registration) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-lg bg-emerald-50 px-3.5 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7v7m-1-6-9 9M10 5H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5" />
                                </svg>
                                Lihat Bukti Bayar
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Surat Tugas / Rekomendasi Instansi (jika diunggah) --}}
                @if ($showAssignment)
                    <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    Surat Tugas / Rekomendasi Instansi Asal
                                </p>
                                <p class="mt-0.5 text-xs text-gray-500">
                                    {{ $registration->assignment_letter_path ? basename($registration->assignment_letter_path) : 'Tidak dilampirkan' }}
                                </p>
                            </div>
                        </div>

                        @if ($registration->assignment_letter_path)
                            <a href="{{ route('admin.diklat.registrations.document', [$registration, 'surat-tugas']) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-lg bg-indigo-50 px-3.5 py-2 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7v7m-1-6-9 9M10 5H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5" />
                                </svg>
                                Lihat Surat Tugas
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Scan Berkas STR (jika diunggah atau program meminta STR) --}}
                @if ($showStr)
                    <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    Berkas Scan STR Tenaga Kesehatan
                                    @if ($registration->str_number)
                                        <span class="text-xs text-gray-500 font-normal">({{ $registration->str_number }})</span>
                                    @endif
                                </p>
                                <p class="mt-0.5 text-xs text-gray-500">
                                    {{ $registration->str_file_path ? basename($registration->str_file_path) : 'Belum diunggah' }}
                                </p>
                            </div>
                        </div>

                        @if ($registration->str_file_path)
                            <a href="{{ route('admin.diklat.registrations.document', [$registration, 'berkas-str']) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-3.5 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7v7m-1-6-9 9M10 5H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5" />
                                </svg>
                                Lihat Berkas STR
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Pas Foto Formal (jika diunggah atau program meminta pas foto) --}}
                @if ($showPhoto)
                    <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    Pas Foto Formal Terbaru (Latar Merah / Biru)
                                </p>
                                <p class="mt-0.5 text-xs text-gray-500">
                                    @if (count($trainingPhotos) > 1)
                                        {{ count($trainingPhotos) }} foto diunggah
                                    @elseif (count($trainingPhotos) === 1)
                                        {{ basename($trainingPhotos[0]) }}
                                    @else
                                        Belum diunggah
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if (count($trainingPhotos) > 1)
                            <div class="flex flex-wrap gap-2">
                                @foreach ($trainingPhotos as $idx => $photo)
                                    <a href="{{ route('admin.diklat.registrations.document', [$registration, 'pas-foto', $idx]) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-purple-50 px-3 py-1.5 text-xs font-semibold text-purple-700 transition hover:bg-purple-100">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7v7m-1-6-9 9M10 5H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5" />
                                        </svg>
                                        Foto {{ $idx + 1 }}
                                    </a>
                                @endforeach
                            </div>
                        @elseif (count($trainingPhotos) === 1)
                            <a href="{{ route('admin.diklat.registrations.document', [$registration, 'pas-foto', 0]) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-lg bg-purple-50 px-3.5 py-2 text-xs font-semibold text-purple-700 transition hover:bg-purple-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7v7m-1-6-9 9M10 5H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5" />
                                </svg>
                                Lihat Foto
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Jika sama sekali tidak ada berkas yang diunggah / diminta --}}
                @if (!$hasAnyDocument)
                    <div class="px-5 py-8 text-center text-xs text-gray-500">
                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="font-semibold text-gray-700">Tidak Ada Berkas Tambahan yang Diunggah</p>
                        <p class="text-gray-400 mt-0.5">Program pelatihan ini tidak mewajibkan berkas fisik dan pendaftar tidak melampirkan berkas tambahan.</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- FORM TINDAK LANJUT --}}
        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-5 py-3">
                <h2 class="text-sm font-bold text-gray-800">Pengelolaan Pendaftaran</h2>
                <p class="mt-0.5 text-xs text-gray-500">
                    Atur status dan catatan tindak lanjut pendaftaran.
                </p>
            </div>

            <form
                action="{{ route('admin.diklat.registrations.training.update', $registration) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4 px-5 py-4 lg:grid-cols-2">

                    {{-- STATUS --}}
                    <div class="lg:col-span-2">
                        <label for="status" class="mb-1.5 block text-xs font-semibold text-gray-700">
                            Status Pendaftaran
                        </label>

                        <select id="status" name="status" required
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="diajukan" @selected(old('status', $status) === 'diajukan')>
                                Diajukan
                            </option>
                            <option value="diverifikasi" @selected(old('status', $status) === 'diverifikasi')>
                                Diverifikasi
                            </option>
                            <option value="diproses" @selected(old('status', $status) === 'diproses')>
                                Diproses
                            </option>
                            <option value="selesai" @selected(old('status', $status) === 'selesai')>
                                Selesai
                            </option>
                            <option value="ditolak" @selected(old('status', $status) === 'ditolak')>
                                Ditolak
                            </option>
                        </select>

                        @error('status')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- CATATAN PENDAFTAR --}}
                    <div>
                        <label for="admin_notes" class="mb-1.5 block text-xs font-semibold text-gray-700">
                            Catatan untuk Pendaftar
                        </label>

                        <textarea id="admin_notes" name="admin_notes" rows="3" maxlength="5000"
                            placeholder="Catatan yang dapat dilihat pendaftar..."
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('admin_notes', $registration->admin_notes) }}</textarea>

                        @error('admin_notes')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end border-t border-gray-100 bg-gray-50 px-5 py-3">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </section>

        {{-- RIWAYAT STATUS --}}
        @if (method_exists($registration, 'histories'))
            @php
                $histories = $registration->histories()->latest()->get();
            @endphp

            <details class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <summary class="flex cursor-pointer list-none items-center justify-between gap-3 px-5 py-3.5">
                    <div>
                        <h2 class="text-sm font-bold text-gray-800">Riwayat Perubahan Status</h2>
                        <p class="mt-0.5 text-xs text-gray-500">
                            {{ $histories->count() }} riwayat tersimpan
                        </p>
                    </div>

                    <svg class="h-4 w-4 shrink-0 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </summary>

                @if ($histories->isNotEmpty())
                    <div class="divide-y divide-gray-100 border-t border-gray-100">
                        @foreach ($histories as $history)
                            <div class="grid grid-cols-1 gap-2 px-5 py-3 sm:grid-cols-[180px_1fr]">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $statusLabels[strtolower($history->new_status ?? '')] ?? ucfirst($history->new_status ?? '-') }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $history->created_at?->format('d/m/Y H:i') ?? '-' }}
                                    </p>
                                </div>

                                <div class="space-y-2 text-sm">
                                    @if ($history->public_note)
                                        <p class="whitespace-pre-line text-gray-700">
                                            <span class="font-medium text-gray-500">Catatan pemohon:</span>
                                            {{ $history->public_note }}
                                        </p>
                                    @endif

                                    @if ($history->internal_note)
                                        <p class="whitespace-pre-line text-gray-600">
                                            <span class="font-medium text-gray-500">Catatan internal:</span>
                                            {{ $history->internal_note }}
                                        </p>
                                    @endif

                                    @if (!$history->public_note && !$history->internal_note)
                                        <p class="text-xs text-gray-400">
                                            Tidak ada catatan pada perubahan ini.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="border-t border-gray-100 px-5 py-4 text-sm text-gray-500">
                        Belum ada perubahan status yang tercatat.
                    </p>
                @endif
            </details>
        @endif

    </div>
</x-layouts.admin>
