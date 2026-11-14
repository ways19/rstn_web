
<x-layouts.admin title="Rekap Absensi Pelatihan">
    <div class="space-y-6">

        {{-- KARTU REKAP ABSENSI --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-5 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">
                    Rekap Absensi Pelatihan
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Lihat jumlah dan data kehadiran peserta setiap program pelatihan.
                </p>
            </div>

            {{-- TABEL PROGRAM --}}
            @if ($programs->count() > 0)
                <div class="pendidikan-table-wrapper max-h-[360px] overflow-y-auto overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="sticky top-0 z-10 bg-gray-50 text-gray-600 uppercase text-xs tracking-wide">
                            <tr>
                                <th class="px-6 py-4 font-semibold">
                                    Program Pelatihan
                                </th>
                                <th class="px-6 py-4 font-semibold">
                                    Jadwal
                                </th>
                                <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">
                                    Jumlah Hadir
                                </th>
                                <th class="px-6 py-4 font-semibold text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach ($programs as $program)
                                <tr class="hover:bg-gray-50 transition-colors">

                                    {{-- PROGRAM --}}
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-800">
                                            {{ $program->name }}
                                        </div>

                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $program->organizer ?? 'RSUD R.A.A. Tjokronegoro' }}
                                        </div>
                                    </td>

                                    {{-- JADWAL --}}
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $program->schedule ?: '-' }}
                                    </td>

                                    {{-- JUMLAH HADIR --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">
                                            {{ $program->attendances_count }} peserta
                                        </span>
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <a
                                            href="{{ route('admin.diklat.attendances.show', $program) }}"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-xs font-semibold hover:bg-blue-100 transition"
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
                                d="M9 5h6m-6 4h6m-6 4h6m-6 4h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"
                            />
                        </svg>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-700">
                        Belum Ada Program Pelatihan
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Program pelatihan yang tersedia akan ditampilkan di sini.
                    </p>
                </div>
            @endif

        </div>

    </div>
</x-layouts.admin>
