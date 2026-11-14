<x-layouts.admin title="Permohonan PPID">

    <div class="space-y-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Permohonan PPID
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Daftar permohonan informasi publik yang masuk.
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            @if($requests->count())

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                    Tiket
                                </th>
                                <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                    Pemohon
                                </th>
                                <th class="px-5 py-3 text-left font-semibold text-gray-600">
                                    Informasi
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

                            @foreach($requests as $item)

                                <tr class="hover:bg-gray-50">

                                    <td class="px-5 py-4 font-medium text-gray-800">
                                        {{ $item->ticket_number }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="font-medium text-gray-800">
                                            {{ $item->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $item->email }}
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 text-gray-600 max-w-xs">
                                        {{ Str::limit($item->information_requested, 60) }}
                                    </td>

                                    <td class="px-5 py-4">
                                        @php
                                            $statusClass = match($item->status) {
                                                'diajukan' => 'bg-blue-100 text-blue-700',
                                                'diverifikasi' => 'bg-purple-100 text-purple-700',
                                                'diproses' => 'bg-yellow-100 text-yellow-700',
                                                'selesai' => 'bg-green-100 text-green-700',
                                                'ditolak' => 'bg-red-100 text-red-700',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp

                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-gray-500">
                                        {{ $item->created_at?->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="px-5 py-4 text-right">
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

                <div class="px-6 py-12 text-center text-gray-500">
                    Belum ada permohonan informasi publik.
                </div>

            @endif

        </div>

    </div>

</x-layouts.admin>