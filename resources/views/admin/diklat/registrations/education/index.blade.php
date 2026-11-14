<x-layouts.admin title="Pendaftaran Pendidikan">
    <div class="space-y-6">

        {{-- KARTU DAFTAR PENDAFTAR --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-5 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">
                    Pendaftaran Pendidikan
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Kelola data pendaftar program pendidikan yang masuk.
                </p>
            </div>

            {{-- TABEL PENDAFTAR --}}
            @if ($registrations->count() > 0)
                <div class="pendidikan-table-wrapper">
                    <table class="w-full text-sm text-left pendidikan-table">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wide">
                            <tr>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">
                                    Nomor Pendaftaran
                                </th>
                                <th class="px-6 py-4 font-semibold">
                                    Pemohon
                                </th>
                                <th class="px-6 py-4 font-semibold">
                                    Program Pendidikan
                                </th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">
                                    Status
                                </th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">
                                    Tanggal
                                </th>
                                <th class="px-6 py-4 font-semibold text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach ($registrations as $item)
                                <tr class="hover:bg-gray-50 transition-colors">

                                    {{-- NOMOR PENDAFTARAN --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-medium text-gray-800">
                                            {{ $item->registration_number ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- PEMOHON --}}
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-800">
                                            {{ $item->full_name ?? '-' }}
                                        </div>
                                        <div class="text-gray-500 text-xs mt-1">
                                            {{ $item->institution ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- PROGRAM --}}
                                    <td class="px-6 py-4">
                                        <span class="text-gray-700">
                                            {{ $item->program?->name ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $status = strtolower($item->status ?? 'diajukan');

                                            $statusClass = match ($status) {
                                                'diajukan' => 'bg-blue-100 text-blue-700',
                                                'diverifikasi' => 'bg-indigo-100 text-indigo-700',
                                                'diproses' => 'bg-amber-100 text-amber-700',
                                                'diterima' => 'bg-green-100 text-green-700',
                                                'ditolak' => 'bg-red-100 text-red-700',
                                                'selesai' => 'bg-gray-100 text-gray-700',
                                                default => 'bg-gray-100 text-gray-600',
                                            };
                                        @endphp

                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>

                                    {{-- TANGGAL --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                        {{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}
                                    </td>
                                    {{-- AKSI --}}
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <a href="{{ route('admin.diklat.registrations.education.show', $item) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg
                                                bg-blue-50 text-blue-600 text-xs font-semibold
                                                hover:bg-blue-100 transition-colors">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                {{-- KONDISI KOSONG --}}
                <div class="px-6 py-12 text-center">
                    <div class="text-gray-400 mb-2">
                        <svg
                            class="w-10 h-10 mx-auto"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                            />
                        </svg>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-700">
                        Belum Ada Pendaftar
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Data pendaftaran program pendidikan akan ditampilkan di sini.
                    </p>
                </div>
            @endif

        </div>

    </div>
</x-layouts.admin>