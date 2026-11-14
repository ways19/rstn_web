<x-layouts.admin title="Permohonan Informasi">

    <div class="space-y-8">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            {{-- HEADER HALAMAN --}}
            <div class="px-6 py-5 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">
                    Permohonan Informasi
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Kelola permohonan informasi publik yang masuk.
                </p>
            </div>

            @if ($requests->count() > 0)

                {{-- AREA SCROLL TABEL --}}
                <div class="ppid-requests-scroll">

                    <table class="ppid-requests-table w-full text-sm">

                        <thead>
                            <tr>
                                <th class="col-ticket px-3 py-3 text-left font-semibold text-gray-600">
                                    Nomor Permohonan
                                </th>

                                <th class="col-applicant px-3 py-3 text-left font-semibold text-gray-600">
                                    Pemohon
                                </th>

                                <th class="col-information px-3 py-3 text-left font-semibold text-gray-600">
                                    Informasi
                                </th>

                                <th class="col-status px-3 py-3 text-left font-semibold text-gray-600">
                                    Status
                                </th>

                                <th class="col-date px-3 py-3 text-left font-semibold text-gray-600">
                                    Tanggal
                                </th>

                                <th class="col-action px-3 py-3 text-right font-semibold text-gray-600">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach ($requests as $item)

                                <tr class="hover:bg-gray-50">

                                    {{-- NOMOR PERMOHONAN --}}
                                    <td class="col-ticket px-3 py-4 font-medium text-gray-800">
                                        {{ $item->ticket_number ?? '-' }}
                                    </td>

                                    {{-- DATA PEMOHON --}}
                                    <td class="col-applicant px-3 py-4">
                                        <div class="font-medium text-gray-800">
                                            {{ $item->name ?? '-' }}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            {{ $item->email ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- INFORMASI YANG DIMINTA --}}
                                    <td class="col-information px-3 py-4 text-gray-600">
                                        {{ \Illuminate\Support\Str::limit($item->information_detail ?? '-', 100) }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="col-status px-3 py-4">
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

                                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                            {{ ucfirst($item->status ?? 'belum tersedia') }}
                                        </span>
                                    </td>

                                    {{-- TANGGAL --}}
                                    <td class="col-date px-3 py-4 text-gray-500">
                                        {{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="col-action px-3 py-4 text-right">
                                        <a
                                            href="{{ route('admin.ppid.requests.show', $item) }}"
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

                <div class="px-6 py-10 text-center text-gray-500">
                    Belum ada permohonan informasi publik.
                </div>

            @endif

        </div>

    </div>

</x-layouts.admin>
