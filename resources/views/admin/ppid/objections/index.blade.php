<x-layouts.admin title="Pengajuan Keberatan">

    <div class="space-y-8">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            {{-- HEADER HALAMAN --}}
            <div class="px-6 py-5 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">
                    Pengajuan Keberatan
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Daftar pengajuan keberatan informasi publik yang masuk.
                </p>
            </div>

            @if ($objections->count() > 0)

                {{-- AREA SCROLL TABEL --}}
                <div class="ppid-objections-scroll">

                    <table class="ppid-objections-table w-full text-sm">

                        <thead>
                            <tr>
                                <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                    Tiket
                                </th>

                                <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                    Pemohon
                                </th>

                                <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                    No. Permohonan
                                </th>

                                <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                    Alasan Keberatan
                                </th>

                                <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                    Status
                                </th>

                                <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                    Tanggal
                                </th>

                                <th class="px-5 py-3 text-right font-semibold text-gray-600">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach ($objections as $item)
                                <tr class="hover:bg-gray-50">

                                    {{-- TIKET KEBERATAN --}}
                                    <td class="px-5 py-4 font-medium text-gray-800 whitespace-nowrap">
                                        {{ $item->objection_ticket_number ?? '-' }}
                                    </td>

                                    {{-- PEMOHON --}}
                                    <td class="px-5 py-4">
                                        <div class="font-medium text-gray-800">
                                            {{ $item->applicant_name ?? '-' }}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            {{ $item->applicant_phone ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- NOMOR PERMOHONAN ASAL --}}
                                    <td class="px-5 py-4 text-gray-600 whitespace-nowrap">
                                        {{ $item->ticket_number ?? '-' }}
                                    </td>

                                    {{-- ALASAN KEBERATAN --}}
                                    <td class="px-5 py-4 text-gray-600 max-w-xs">
                                        {{ \Illuminate\Support\Str::limit(
                                            str_replace('_', ' ', $item->objection_reasons ?? '-'),
                                            60
                                        ) }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @php
                                            $statusClass = match ($item->status) {
                                                'diajukan' => 'bg-blue-100 text-blue-700',
                                                'diverifikasi' => 'bg-purple-100 text-purple-700',
                                                'diproses' => 'bg-yellow-100 text-yellow-700',
                                                'selesai' => 'bg-green-100 text-green-700',
                                                'ditolak' => 'bg-red-100 text-red-700',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp

                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                            {{ ucfirst($item->status ?? 'belum tersedia') }}
                                        </span>
                                    </td>

                                    {{-- TANGGAL --}}
                                    <td class="px-5 py-4 text-gray-500 whitespace-nowrap">
                                        {{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="col-action px-3 py-4 text-right">
                                        <a
                                            href="{{ route('admin.ppid.objections.show', $item) }}"
                                            class="text-cyan-600 hover:text-cyan-800 font-medium"
                                        >
                                            Detail
                                        </a>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="px-6 py-12 text-center text-gray-500">
                    Belum ada pengajuan keberatan informasi publik.
                </div>

            @endif

        </div>

    </div>

</x-layouts.admin>
