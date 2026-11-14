<x-layouts.admin title="Detail Pendaftaran Pendidikan">
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
                <a href="{{ route('admin.diklat.registrations.education.index') }}"
                    class="mb-2 inline-flex items-center gap-1.5 text-xs font-medium text-gray-500 hover:text-blue-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke daftar
                </a>

                <h1 class="text-xl font-bold text-gray-900">Detail Pendaftaran Pendidikan</h1>
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

        {{-- DATA PENDAFTAR --}}
        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-3">
                <h2 class="text-sm font-bold text-gray-800">Informasi Pendaftaran</h2>
                <span class="text-xs text-gray-400">
                    Diperbarui {{ $registration->updated_at?->format('d/m/Y H:i') ?? '-' }}
                </span>
            </div>

            <div class="grid grid-cols-1 gap-x-8 gap-y-4 px-5 py-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs text-gray-500">Nama Lengkap</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{ $registration->full_name ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Institusi / Asal Pendidikan</p>
                    <p class="mt-1 text-sm font-medium text-gray-800">
                        {{ $registration->institution ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Program Pendidikan</p>
                    <p class="mt-1 text-sm font-medium text-gray-800">
                        {{ $registration->program?->name ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Kategori Program</p>
                    <p class="mt-1 text-sm text-gray-800">
                        {{ $registration->program?->category ? ucfirst($registration->program->category) : '-' }}
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


            </div>
        </section>

        {{-- DOKUMEN PERSYARATAN PRAKTIK --}}
        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-5 py-3">
                <h2 class="text-sm font-bold text-gray-800">
                    Dokumen & Berkas Persyaratan
                </h2>
                <p class="mt-0.5 text-xs text-gray-500">
                    Berkas kelengkapan administrasi yang diunggah oleh pendaftar.
                </p>
            </div>

            <div class="divide-y divide-gray-100">
                {{-- Surat Permohonan --}}
                <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-red-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M7 3.75h7l5 5v11.5a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-13.5a2 2 0 0 1 2-2Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 3.75v5h5M8 14h8M8 17h5" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                Surat Permohonan / Rekomendasi Resmi
                            </p>
                            <p class="mt-0.5 text-xs text-gray-500">
                                {{ $registration->application_letter_path ? basename($registration->application_letter_path) : 'Belum diunggah' }}
                            </p>
                        </div>
                    </div>

                    @if ($registration->application_letter_path)
                        <a href="{{ route('admin.diklat.registrations.document', [$registration, 'surat-permohonan']) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-3.5 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7v7m-1-6-9 9M10 5H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5" />
                            </svg>
                            Lihat Dokumen
                        </a>
                    @endif
                </div>

                {{-- Daftar Calon Mahasiswa & NIM --}}
                <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                Daftar Nama Calon Mahasiswa & NIM
                            </p>
                            <p class="mt-0.5 text-xs text-gray-500">
                                {{ $registration->participant_list_path ? basename($registration->participant_list_path) : 'Belum diunggah' }}
                            </p>
                        </div>
                    </div>

                    @if ($registration->participant_list_path)
                        <a href="{{ route('admin.diklat.registrations.document', [$registration, 'daftar-peserta']) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 rounded-lg bg-emerald-50 px-3.5 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7v7m-1-6-9 9M10 5H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5" />
                            </svg>
                            Lihat / Unduh Berkas
                        </a>
                    @endif
                </div>

                {{-- Pas Foto Formal Almamater (Mendukung Banyak Foto) --}}
                @php
                    $idPhotos = $registration->id_photos;
                    $photoCount = count($idPhotos);
                @endphp
                <div class="px-5 py-4">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    Pas Foto Formal (Seragam Almamater)
                                </p>
                                <p class="mt-0.5 text-xs text-gray-500">
                                    @if ($photoCount > 0)
                                        {{ $photoCount }} berkas foto formal diunggah
                                    @else
                                        Belum ada foto yang diunggah
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if ($photoCount === 1)
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

                    @if ($photoCount > 1)
                        <div class="mt-3 flex flex-wrap items-center gap-2 pt-2 border-t border-gray-100">
                            @foreach ($idPhotos as $idx => $photoPath)
                                <a href="{{ route('admin.diklat.registrations.document', [$registration, 'pas-foto', $idx]) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-purple-50 px-3 py-1.5 text-xs font-semibold text-purple-700 transition hover:bg-purple-100">
                                    <span>Foto {{ $idx + 1 }}</span>
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Bukti Asuransi / BPJS --}}
                @if ($registration->insurance_proof_path)
                    <div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    Bukti Asuransi / BPJS Kesehatan
                                </p>
                                <p class="mt-0.5 text-xs text-gray-500">
                                    {{ basename($registration->insurance_proof_path) }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('admin.diklat.registrations.document', [$registration, 'asuransi']) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 rounded-lg bg-amber-50 px-3.5 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-100">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7v7m-1-6-9 9M10 5H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5" />
                            </svg>
                            Lihat Bukti Asuransi
                        </a>
                    </div>
                @endif
            </div>
        </section>

        {{-- PENGELOLAAN STATUS DAN CATATAN --}}
        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-5 py-3">
                <h2 class="text-sm font-bold text-gray-800">Pengelolaan Pendaftaran</h2>
                <p class="mt-0.5 text-xs text-gray-500">
                    Atur status dan catatan tindak lanjut pendaftaran.
                </p>
            </div>

            <form
                action="{{ route('admin.diklat.registrations.education.update', $registration) }}"
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
                                        {{ $statusLabels[$history->new_status] ?? ucfirst($history->new_status ?? '-') }}
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
                                        <p class="text-xs text-gray-400">Tidak ada catatan pada perubahan ini.</p>
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