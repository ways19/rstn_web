
<x-layouts.admin title="Detail Pengajuan Keberatan">

    <div class="space-y-5">

        {{-- HEADER --}}
        <div>
            <a
                href="{{ route('admin.ppid.objections.index') }}"
                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700"
            >
                ← Kembali
            </a>

            <div class="mt-3">
                <h1 class="text-xl font-bold text-gray-800">
                    Detail Pengajuan Keberatan
                </h1>

                <div class="mt-1.5 flex flex-wrap items-center gap-2 text-xs text-gray-500">
                    <span class="font-semibold text-gray-700">
                        {{ $objection->ticket_number ?? '-' }}
                    </span>
                    <span>•</span>
                    <span>
                        Diajukan pada
                        {{ $objection->created_at?->translatedFormat('d F Y, H:i') ?? '-' }} WIB
                    </span>
                </div>
            </div>
        </div>

        {{-- DATA PEMOHON --}}
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-100 px-5 py-3.5">
                <h2 class="text-sm font-semibold text-gray-800">
                    Data Pemohon
                </h2>
                <p class="mt-0.5 text-xs text-gray-500">
                    Informasi identitas pemohon dan kuasa/wakil
                </p>
            </div>

            <div class="grid grid-cols-1 gap-x-8 gap-y-4 px-5 py-4 sm:grid-cols-2 lg:grid-cols-3">

                <div>
                    <p class="text-xs text-gray-500">Nama Lengkap</p>
                    <p class="mt-1 text-sm font-medium text-gray-800">
                        {{ $objection->applicant_name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Nomor Telepon</p>
                    <p class="mt-1 text-sm text-gray-700">
                        {{ $objection->applicant_phone ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Alamat</p>
                    <p class="mt-1 text-sm text-gray-700">
                        {{ $objection->applicant_address ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Nama Kuasa / Wakil</p>
                    <p class="mt-1 text-sm text-gray-700">
                        {{ $objection->representative_name ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Telepon Kuasa / Wakil</p>
                    <p class="mt-1 text-sm text-gray-700">
                        {{ $objection->representative_phone ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Alamat Kuasa / Wakil</p>
                    <p class="mt-1 text-sm text-gray-700">
                        {{ $objection->representative_address ?: '-' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- INFORMASI KEBERATAN --}}
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-100 px-5 py-3.5">
                <h2 class="text-sm font-semibold text-gray-800">
                    Informasi Keberatan
                </h2>
                <p class="mt-0.5 text-xs text-gray-500">
                    Rincian alasan dan kronologi pengajuan keberatan
                </p>
            </div>

            <div class="space-y-4 px-5 py-4">

                <div>
                    <p class="text-xs text-gray-500">
                        Tujuan Penggunaan Informasi
                    </p>
                    <p class="mt-1 text-sm leading-relaxed text-gray-700 whitespace-pre-line">
                        {{ $objection->information_purpose ?: '-' }}
                    </p>
                </div>

                @php
                    $reasonLabels = [
                        'ditolak' => 'Permohonan informasi ditolak',
                        'berkala' => 'Informasi berkala tidak disediakan',
                        'tidak_ditanggapi' => 'Permohonan tidak ditanggapi',
                        'tidak_sesuai' => 'Informasi yang diberikan tidak sesuai',
                        'tidak_dipenuhi' => 'Permohonan tidak dipenuhi',
                        'biaya' => 'Pengenaan biaya tidak wajar',
                        'melewati_batas_waktu' => 'Penyampaian informasi melewati batas waktu',
                    ];

                    $reasons = is_array($objection->objection_reasons)
                        ? $objection->objection_reasons
                        : array_filter(explode(',', $objection->objection_reasons ?? ''));
                @endphp

                <div>
                    <p class="text-xs text-gray-500">
                        Alasan Keberatan
                    </p>

                    @if(count($reasons))
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach($reasons as $reason)
                                <span class="rounded-md bg-blue-50 px-2.5 py-1.5 text-xs font-medium text-blue-700">
                                    {{ $reasonLabels[trim($reason)] ?? ucfirst(str_replace('_', ' ', trim($reason))) }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-700">-</p>
                    @endif
                </div>

                <div>
                    <p class="text-xs text-gray-500">
                        Kronologi Keberatan
                    </p>
                    <p class="mt-1 rounded-lg bg-gray-50 p-3 text-sm leading-relaxed text-gray-700 whitespace-pre-line">
                        {{ $objection->objection_chronology ?: '-' }}
                    </p>
                </div>

                @if($objection->voice_recording)
                    <div>
                        <p class="mb-2 text-xs text-gray-500">
                            Rekaman Suara
                        </p>

                        <audio controls class="w-full">
                            <source
                                src="{{ asset('storage/' . $objection->voice_recording) }}"
                                type="audio/webm"
                            >
                            Browser tidak mendukung pemutar audio.
                        </audio>
                    </div>
                @endif

            </div>
        </div>

        {{-- STATUS & AKSI --}}
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-100 px-5 py-3.5">
                <h2 class="text-sm font-semibold text-gray-800">
                    Status & Aksi
                </h2>
                <p class="mt-0.5 text-xs text-gray-500">
                    Kelola proses penanganan pengajuan keberatan
                </p>
            </div>

            <form
                method="POST"
                action="{{ route('admin.ppid.objections.update', $objection) }}"
                class="space-y-4 px-5 py-4"
            >
                @csrf
                @method('PATCH')

                <div>
                    <label
                        for="status"
                        class="mb-1.5 block text-xs font-medium text-gray-600"
                    >
                        Status Pengajuan
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                    >
                        @foreach([
                            'diajukan' => 'Diajukan',
                            'diverifikasi' => 'Diverifikasi',
                            'diproses' => 'Diproses',
                            'selesai' => 'Selesai',
                            'ditolak' => 'Ditolak',
                        ] as $value => $label)
                            <option
                                value="{{ $value }}"
                                @selected(old('status', $objection->status) === $value)
                            >
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('status')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label
                        for="admin_note"
                        class="mb-1.5 block text-xs font-medium text-gray-600"
                    >
                        Catatan Admin
                    </label>

                    <textarea
                        id="admin_note"
                        name="admin_note"
                        rows="3"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        placeholder="Tuliskan catatan atau tindak lanjut penanganan keberatan..."
                    >{{ old('admin_note', $objection->admin_note) }}</textarea>

                    @error('admin_note')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end border-t border-gray-100 pt-4">
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-lg bg-cyan-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-700"
                    >
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>

</x-layouts.admin>
