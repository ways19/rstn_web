
<x-layouts.admin title="Detail Rekap Absensi">
    <div class="space-y-6">

        {{-- KARTU DETAIL ABSENSI --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            Rekap Absensi Peserta
                        </h1>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $program->name }}
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.diklat.attendances.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-gray-200 transition"
                    >
                        Kembali
                    </a>
                </div>
            </div>

            {{-- INFORMASI PROGRAM --}}
            <div class="px-6 py-5 bg-gray-50 border-b border-gray-200">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                    <div>
                        <p class="text-xs text-gray-500">Program Pelatihan</p>
                        <p class="text-sm font-semibold text-gray-800 mt-1">
                            {{ $program->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Jadwal</p>
                        <p class="text-sm font-semibold text-gray-800 mt-1">
                            {{ $program->schedule ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Total Peserta Hadir</p>
                        <p class="text-sm font-semibold text-blue-700 mt-1">
                            {{ $totalAttendances }} peserta
                        </p>
                    </div>

                </div>
            </div>

            {{-- TABEL PESERTA --}}
            @if ($attendances->count() > 0)
                <div class="pendidikan-table-wrapper">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wide">
                            <tr>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">
                                    No.
                                </th>
                                <th class="px-6 py-4 font-semibold">
                                    Nama Peserta
                                </th>
                                <th class="px-6 py-4 font-semibold">
                                    Instansi
                                </th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">
                                    Waktu Absensi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach ($attendances as $index => $attendance)
                                <tr class="hover:bg-gray-50 transition-colors">

                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $attendances->firstItem() + $index }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="font-medium text-gray-800">
                                            {{ $attendance->full_name }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $attendance->institution }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                        {{ $attendance->attended_at?->format('d/m/Y H:i') ?? '-' }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $attendances->links() }}
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
                        Belum Ada Peserta Hadir
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Data peserta yang mengisi absensi akan ditampilkan di sini.
                    </p>
                </div>
            @endif

        </div>

    </div>
</x-layouts.admin>
