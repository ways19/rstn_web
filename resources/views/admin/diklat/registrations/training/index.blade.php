
<x-layouts.admin title="Pendaftaran Pelatihan">
    <div class="space-y-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Pendaftaran Pelatihan
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Kelola data pendaftar berdasarkan program pelatihan yang diselenggarakan.
            </p>
        </div>

        {{-- RINGKASAN --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <p class="text-sm text-gray-500">Total Program Pelatihan</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">
                    {{ $programs->count() }}
                </p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <p class="text-sm text-gray-500">Total Pendaftar</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">
                    {{ $programs->sum('registrations_count') }}
                </p>
            </div>
        </div>

        {{-- DAFTAR PENDAFTAR --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            {{-- FILTER --}}
            <div class="p-5 sm:p-6 border-b border-gray-200 space-y-4">

                <div>
                    <h2 class="text-lg font-bold text-gray-800">
                        Daftar Pendaftar
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Pilih program untuk melihat peserta yang mendaftar.
                    </p>
                </div>

                <form method="GET"
                    action="{{ route('admin.diklat.registrations.training.index') }}"
                    class="grid grid-cols-1 md:grid-cols-3 gap-3">

                    {{-- PILIH PROGRAM --}}
                    <div>
                        <label for="program" class="block text-sm font-medium text-gray-700 mb-1">
                            Program Pelatihan
                        </label>

                        <select
                            id="program"
                            name="program"
                            onchange="this.form.submit()"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm text-gray-700 focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Semua Program Pelatihan</option>

                            @foreach ($programs as $program)
                                <option
                                    value="{{ $program->id }}"
                                    @selected((string) $selectedProgram === (string) $program->id)
                                >
                                    {{ $program->name }}
                                    ({{ $program->registrations_count }} pendaftar)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- PENCARIAN --}}
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                            Cari Pendaftar
                        </label>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Nama, nomor pendaftaran, institusi..."
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    {{-- FILTER STATUS --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Status Pendaftaran
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Semua Status</option>
                            <option value="diajukan" @selected($selectedStatus === 'diajukan')>Diajukan</option>
                            <option value="diverifikasi" @selected($selectedStatus === 'diverifikasi')>Diverifikasi</option>
                            <option value="diproses" @selected($selectedStatus === 'diproses')>Diproses</option>
                            <option value="selesai" @selected($selectedStatus === 'selesai')>Selesai</option>
                            <option value="ditolak" @selected($selectedStatus === 'ditolak')>Ditolak</option>
                        </select>
                    </div>

                    {{-- TOMBOL FILTER --}}
                    <div class="md:col-span-3 flex flex-wrap items-center gap-2">
                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition"
                        >
                            Terapkan Filter
                        </button>

                        <a
                            href="{{ route('admin.diklat.registrations.training.index') }}"
                            class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-600 text-sm font-semibold hover:bg-gray-50 transition"
                        >
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- INFORMASI HASIL --}}
            <div class="px-5 sm:px-6 py-4 bg-gray-50 border-b border-gray-200 flex flex-wrap items-center justify-between gap-2">
                <div>
                    <p class="text-sm font-semibold text-gray-800">
                        @if ($selectedProgram)
                            {{ $programs->firstWhere('id', (int) $selectedProgram)?->name ?? 'Program Pelatihan' }}
                        @else
                            Semua Program Pelatihan
                        @endif
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        Menampilkan {{ $registrations->count() }} pendaftar
                    </p>
                </div>
            </div>

            {{-- TABEL --}}
            @if ($registrations->count() > 0)
                <div class="pendidikan-table-wrapper overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wide">
                            <tr>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">
                                    Nomor Pendaftaran
                                </th>
                                <th class="px-6 py-4 font-semibold">
                                    Pemohon
                                </th>
                                <th class="px-6 py-4 font-semibold">
                                    Program Pelatihan
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

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-medium text-gray-800">
                                            {{ $item->registration_number ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-800">
                                            {{ $item->full_name ?? '-' }}
                                        </div>
                                        <div class="text-gray-500 text-xs mt-1">
                                            {{ $item->institution ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="text-gray-700">
                                            {{ $item->program?->name ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $status = strtolower($item->status ?? 'diajukan');

                                            $statusClass = match ($status) {
                                                'diajukan' => 'bg-blue-100 text-blue-700',
                                                'diverifikasi' => 'bg-indigo-100 text-indigo-700',
                                                'diproses' => 'bg-amber-100 text-amber-700',
                                                'diterima' => 'bg-green-100 text-green-700',
                                                'ditolak' => 'bg-red-100 text-red-700',
                                                'selesai' => 'bg-emerald-50 text-emerald-700',
                                                default => 'bg-gray-100 text-gray-600',
                                            };
                                        @endphp

                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                        {{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <a
                                            href="{{ route('admin.diklat.registrations.training.show', $item) }}"
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
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                            />
                        </svg>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-700">
                        @if ($search || $selectedStatus || $selectedProgram)
                            Pendaftar Tidak Ditemukan
                        @else
                            Belum Ada Pendaftar
                        @endif
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        @if ($search || $selectedStatus || $selectedProgram)
                            Tidak ada pendaftar yang sesuai dengan filter yang dipilih.
                        @else
                            Data pendaftaran program pelatihan akan ditampilkan di sini.
                        @endif
                    </p>
                </div>
            @endif

        </div>
    </div>
</x-layouts.admin>
