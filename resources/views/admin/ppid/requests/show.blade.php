<x-layouts.admin title="Detail Permohonan PPID">

    <div class="space-y-5">

        {{-- HEADER --}}
        <div>

            <a
                href="{{ route('admin.ppid.information.index') }}"
                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700"
            >
                ← Kembali
            </a>

            <h1 class="mt-3 text-2xl font-bold text-gray-800">
                Detail Permohonan PPID
            </h1>

            <div class="mt-2 flex flex-wrap items-center gap-3">

                <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">
                    {{ $request->ticket_number }}
                </span>

                <span class="text-sm text-gray-500">
                    Diajukan pada {{ $request->created_at?->format('d F Y, H:i') }} WIB
                </span>

            </div>

        </div>


        {{-- Informasi Utama --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Data Pemohon --}}
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm">

                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-800">
                        Data Pemohon
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Informasi identitas pemohon
                    </p>
                </div>

                <div class="p-5">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Nama</p>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $request->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Kategori Pemohon</p>
                            <p class="text-sm text-gray-800">
                                {{ $request->applicant_category ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Email</p>
                            <p class="text-sm text-gray-800">
                                {{ $request->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Nomor Telepon</p>
                            <p class="text-sm text-gray-800">
                                {{ $request->phone ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">NIK</p>
                            <p class="text-sm text-gray-800">
                                {{ $request->nik ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Alamat</p>
                            <p class="text-sm text-gray-800">
                                {{ $request->address ?? '-' }}
                            </p>
                        </div>

                    </div>

                    @if($request->identity_file)

                        <div class="mt-5 pt-4 border-t border-gray-100">

                            <div class="flex items-center justify-between">

                                <div>
                                    <p class="text-xs text-gray-500">
                                        Dokumen Identitas
                                    </p>
                                    <p class="text-sm text-gray-700 mt-0.5">
                                        Dokumen identitas pemohon
                                    </p>
                                </div>
                                    <a
                                        href="{{ route('admin.ppid.requests.identity-document', $request) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-3.5 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100"
                                    >
                                        Lihat Dokumen
                                    </a>
                            </div>

                        </div>

                    @endif

                </div>

            </div>


            {{-- Status & Aksi --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">

                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-800">
                        Status & Aksi
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Kelola proses permohonan
                    </p>
                </div>

                <div class="p-5">

                    <form
                        action="{{ route('admin.ppid.requests.update', $request) }}"
                        method="POST"
                        class="space-y-4"
                    >

                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">
                                Status Permohonan
                            </label>

                            <select
                                name="status"
                                class="w-full border-gray-300 rounded-lg text-sm focus:ring-cyan-500 focus:border-cyan-500"
                            >
                                @foreach([
                                    'diajukan',
                                    'diverifikasi',
                                    'diproses',
                                    'selesai',
                                    'ditolak'
                                ] as $status)

                                    <option
                                        value="{{ $status }}"
                                        @selected($request->status === $status)
                                    >
                                        {{ ucfirst($status) }}
                                    </option>

                                @endforeach
                            </select>
                        </div>


                        <div>
                            <label
                                for="admin_note"
                                class="block text-xs font-medium text-gray-600 mb-1.5"
                            >
                                Tindak Lanjut
                            </label>

                            <textarea
                                id="admin_note"
                                name="admin_note"
                                rows="3"
                                class="w-full border-gray-300 rounded-lg text-sm focus:ring-cyan-500 focus:border-cyan-500"
                                placeholder="Tuliskan tindak lanjut penanganan permohonan..."
                            >{{ old('admin_note', $request->admin_note) }}</textarea>
                        </div>


                        <button
                            type="submit"
                            class="w-full px-4 py-2.5 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition font-medium text-sm"
                        >
                            Simpan Perubahan
                        </button>

                    </form>


                    {{-- Aksi Pengiriman --}}
                    @if($request->delivery_method === 'WhatsApp' && $request->phone)

                        @php
                            $phone = preg_replace('/[^0-9]/', '', $request->phone);

                            if (str_starts_with($phone, '0')) {
                                $phone = '62' . substr($phone, 1);
                            }

                            $message = "Yth. {$request->name},\n\n"
                                . "Permohonan informasi publik dengan nomor tiket {$request->ticket_number} "
                                . "telah selesai diproses.\n\n"
                                . "Silakan menghubungi PPID RSUD R.A.A. Tjokronegoro "
                                . "untuk memperoleh informasi yang dimohonkan.\n\n"
                                . "Terima kasih.";

                            $whatsappUrl = 'https://wa.me/' . $phone . '?text=' . urlencode($message);
                        @endphp

                        <a
                            href="{{ $whatsappUrl }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-full mt-3 inline-flex items-center justify-center px-4 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium text-sm"
                        >
                            Kirim via WhatsApp
                        </a>

                    @elseif($request->delivery_method === 'Email' && $request->email)

                        @php
                            $subject = 'Permohonan Informasi Publik - ' . $request->ticket_number;

                            $message = "Yth. {$request->name},\n\n"
                                . "Permohonan informasi publik dengan nomor tiket {$request->ticket_number} "
                                . "telah selesai diproses.\n\n"
                                . "Silakan menghubungi PPID RSUD R.A.A. Tjokronegoro "
                                . "untuk memperoleh informasi yang dimohonkan.\n\n"
                                . "Terima kasih.";

                            $emailUrl = 'mailto:' . $request->email
                                . '?subject=' . urlencode($subject)
                                . '&body=' . urlencode($message);
                        @endphp

                        <a
                            href="https://mail.google.com/mail/?view=cm&fs=1&to={{ urlencode($request->email) }}&su={{ urlencode('Permohonan Informasi Publik - ' . $request->ticket_number) }}&body={{ urlencode($message) }}"
                            target="_blank"
                            class="w-full mt-3 inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm"
                        >
                            Kirim via Email
                        </a>

                    @endif

                </div>

            </div>

        </div>


        {{-- Rekaman Suara --}}
        @if($request->voice_recording)

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 mt-5">

                <div class="flex items-center justify-between mb-3">

                    <h2 class="text-base font-semibold text-gray-800">
                        Rekaman Suara Permohonan
                    </h2>

                    <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-medium">
                        Audio
                    </span>

                </div>

                <audio controls class="w-full">
                    <source
                        src="{{ asset('storage/' . $request->voice_recording) }}"
                        type="audio/webm"
                    >

                    Browser Anda tidak mendukung pemutaran audio.
                </audio>

            </div>

        @endif


        {{-- Informasi & Tujuan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Informasi yang Diminta --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">

                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-800">
                        Informasi yang Diminta
                    </h2>
                </div>

                 <div class="px-5 pt-0 pb-4">
                    <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                        {{ $request->information_detail }}
                    </p>
                </div>

            </div>


            {{-- Tujuan Permohonan --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">

                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-800">
                        Tujuan Permohonan
                    </h2>
                </div>

                <div class="px-5 pt-0 pb-4">
                    <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                        {{ $request->purpose ?? '-' }}
                    </p>
                </div>

            </div>

        </div>


        {{-- Catatan & Metode --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- Tindak Lanjut --}}
            <div class="bg-amber-50 border border-amber-200 rounded-xl shadow-sm p-5">

                <p class="text-xs font-semibold text-amber-800 mb-2">
                    Tindak Lanjut
                </p>

                <p class="text-sm text-amber-900 whitespace-pre-line">
                    {{ $request->admin_note ?: 'Belum ada tindak lanjut.' }}
                </p>

            </div>


            {{-- Cara Memperoleh --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">

                <p class="text-xs font-medium text-gray-500 mb-2">
                    Cara Memperoleh Informasi
                </p>

                <p class="text-sm font-semibold text-gray-800">
                    {{ $request->obtaining_method ?? '-' }}
                </p>

            </div>


            {{-- Cara Mengirimkan --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">

                <p class="text-xs font-medium text-gray-500 mb-2">
                    Cara Mengirimkan Salinan
                </p>

                <div class="flex items-center gap-2">

                    @if($request->delivery_method === 'WhatsApp')
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    @elseif($request->delivery_method === 'Email')
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    @else
                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                    @endif

                    <p class="text-sm font-semibold text-gray-800">
                        {{ $request->delivery_method ?? '-' }}
                    </p>

                </div>

            </div>

        </div>


</x-layouts.admin>