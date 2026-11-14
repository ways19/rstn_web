
<x-layouts.app
    title="Statistik Permohonan Informasi — RSUD R.A.A. Tjokronegoro"
    meta-description="Statistik permohonan informasi dan pengajuan keberatan PPID RSUD R.A.A. Tjokronegoro."
>
    <x-page-header
        :title="$page->title"
        :description="$page->description"
    />

    {{-- SUBMENU PPID --}}
    <x-submenus.ppid-request active="statistics" />

    {{-- BREADCRUMB --}}
    <div class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 py-5 text-sm"
                 aria-label="Breadcrumb">
                <a href="{{ route('ppid.profile') }}"
                   class="font-medium text-slate-500 hover:text-[#007b83]">
                    PPID
                </a>
                <span class="text-slate-300">›</span>
                <a href="{{ route('ppid.request') }}" class="font-medium text-slate-500 hover:text-[#007b83]">
                    Permohonan Informasi
                </a>
                <span class="text-slate-300">›</span>
                <span class="font-semibold text-[#007b83]">
                    {{ $page->title }}
                </span>
            </nav>
        </div>
    </div>

    <section class="bg-slate-50 pb-16 pt-2">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- KONTEN CMS --}}
            @if (filled(strip_tags($page->content ?? '')))
                <div class="rounded-2xl border border-slate-200 bg-white p-5 text-sm leading-7 text-slate-600 sm:p-6">
                    {!! $page->content !!}
                </div>
            @endif


{{-- FILTER TAHUN --}}
<form method="GET"
      action="{{ route('ppid.request.statistics') }}"
      class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
    <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-teal-700">
                Informasi Publik
            </p>
            <h2 class="mt-2 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                Statistik Permohonan Informasi
            </h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                Ringkasan permohonan informasi dan pengajuan keberatan PPID
                RSUD R.A.A. Tjokronegoro.
            </p>
        </div>

        <div class="flex flex-wrap items-end gap-3">
            <div>
                <label for="tahun" class="mb-1.5 block text-xs font-semibold text-slate-600">
                    Periode statistik
                </label>
                <select id="tahun"
                        name="tahun"
                        class="min-w-32 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-teal-600 focus:ring-4 focus:ring-teal-50">
                    @foreach ($years as $availableYear)
                        <option value="{{ $availableYear }}"
                            @selected((int) $year === (int) $availableYear)>
                            {{ $availableYear }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    class="rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-100">
                Tampilkan
            </button>
        </div>
    </div>
</form>

{{-- KARTU RINGKASAN --}}
@php
    $summaryCards = [
        [
            'label' => 'Permohonan Informasi',
            'value' => $informationTotal,
            'description' => 'Total permohonan masuk',
            'icon' => 'document',
            'color' => 'teal',
        ],
        [
            'label' => 'Permohonan Selesai',
            'value' => $informationCompleted,
            'description' => 'Berstatus selesai',
            'icon' => 'check',
            'color' => 'green',
        ],
        [
            'label' => 'Permohonan Ditolak',
            'value' => $informationRejected,
            'description' => 'Berstatus ditolak',
            'icon' => 'close',
            'color' => 'red',
        ],
        [
            'label' => 'Dalam Proses',
            'value' => $informationProcessing,
            'description' => 'Belum selesai diproses',
            'icon' => 'clock',
            'color' => 'blue',
        ],
        [
            'label' => 'Pengajuan Keberatan',
            'value' => $objectionTotal,
            'description' => 'Total keberatan masuk',
            'icon' => 'flag',
            'color' => 'orange',
        ],
    ];
@endphp

<div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
    @foreach ($summaryCards as $card)
        <div class="group rounded-xl border border-slate-200 bg-white p-3 shadow-sm transition duration-200 hover:shadow-md sm:p-4">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="min-h-8 text-xs font-medium leading-4 text-slate-500 sm:text-sm">
                        {{ $card['label'] }}
                    </p>
                    <p class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        {{ number_format($card['value'], 0, ',', '.') }}
                    </p>
                </div>

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg
                    {{ $card['color'] === 'teal' ? 'bg-teal-50 text-teal-700' : '' }}
                    {{ $card['color'] === 'green' ? 'bg-emerald-50 text-emerald-700' : '' }}
                    {{ $card['color'] === 'red' ? 'bg-rose-50 text-rose-700' : '' }}
                    {{ $card['color'] === 'blue' ? 'bg-blue-50 text-blue-700' : '' }}
                    {{ $card['color'] === 'orange' ? 'bg-amber-50 text-amber-700' : '' }}">

                    @if ($card['icon'] === 'document')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M9 12h6m-6 4h6M7 3h7l5 5v11a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/>
                        </svg>
                    @elseif ($card['icon'] === 'check')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m5 12 4 4L19 6"/>
                        </svg>
                    @elseif ($card['icon'] === 'close')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m7 7 10 10M17 7 7 17"/>
                        </svg>
                    @elseif ($card['icon'] === 'clock')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" stroke-width="1.8"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M12 7v5l3 2"/>
                        </svg>
                    @else
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M12 3v18m-5-5 5 5 5-5M5 7h14"/>
                        </svg>
                    @endif
                </div>
            </div>

            <p class="mt-2 border-t border-slate-100 pt-2 text-[10px] leading-4 text-slate-400 sm:text-xs">
                {{ $card['description'] }} · {{ $year }}
            </p>
        </div>
    @endforeach
</div>

{{-- GRAFIK TREN BULANAN --}}
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 px-5 py-5 sm:px-7">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900 sm:text-xl">
                    Tren Layanan PPID
                </h2>
                <p class="mt-1 text-sm leading-6 text-slate-500">
                    Perbandingan jumlah permohonan informasi dan keberatan
                    berdasarkan bulan pada tahun {{ $year }}.
                </p>
            </div>
            <span class="w-fit rounded-full bg-teal-50 px-3 py-1.5 text-xs font-bold text-teal-800">
                Tahun {{ $year }}
            </span>
        </div>

        <div class="mt-5 flex flex-wrap gap-x-5 gap-y-2 text-xs font-medium text-slate-600">
            <span class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-sm bg-teal-700"></span>
                Permohonan informasi
            </span>
            <span class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-sm bg-emerald-500"></span>
                Pengajuan keberatan
            </span>
        </div>
    </div>

    @php
        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];

        $maxMonthlyValue = max(
            1,
            (int) collect($monthlyStats)->max(
                fn ($stat) => max(
                    (int) ($stat['information'] ?? 0),
                    (int) ($stat['objection'] ?? 0)
                )
            )
        );
    @endphp

    <div class="p-4 sm:p-7">
        <div class="grid grid-cols-6 gap-x-2 gap-y-5 sm:grid-cols-12 sm:gap-x-3">
            @foreach ($monthlyStats as $stat)
                @php
                    $informationCount = (int) ($stat['information'] ?? 0);
                    $objectionCount = (int) ($stat['objection'] ?? 0);

                    $informationHeight = $informationCount > 0
                        ? max(4, ($informationCount / $maxMonthlyValue) * 100)
                        : 0;

                    $objectionHeight = $objectionCount > 0
                        ? max(4, ($objectionCount / $maxMonthlyValue) * 100)
                        : 0;
                @endphp

                <div class="flex min-w-0 flex-col items-center">
                    <div class="flex h-44 w-full items-end justify-center gap-1 border-b border-slate-200 px-0.5 sm:h-56 sm:gap-1.5">
                        <div class="flex h-full w-1/2 items-end justify-center"
                             title="Permohonan informasi: {{ $informationCount }}">
                            <div class="w-full max-w-6 rounded-t-md bg-teal-700 transition hover:bg-teal-800"
                                 style="height: {{ $informationHeight }}%">
                            </div>
                        </div>

                        <div class="flex h-full w-1/2 items-end justify-center"
                             title="Pengajuan keberatan: {{ $objectionCount }}">
                            <div class="w-full max-w-6 rounded-t-md bg-emerald-500 transition hover:bg-emerald-600"
                                 style="height: {{ $objectionHeight }}%">
                            </div>
                        </div>
                    </div>

                    <span class="mt-2 text-xs font-semibold text-slate-600">
                        {{ $monthNames[(int) $stat['month']] ?? $stat['month'] }}
                    </span>
                    <span class="mt-1 text-[10px] text-slate-400">
                        {{ $informationCount }} / {{ $objectionCount }}
                    </span>
                </div>
            @endforeach
        </div>

        <p class="mt-5 text-xs leading-5 text-slate-400">
            Keterangan angka per bulan: permohonan informasi / pengajuan keberatan.
            Bulan tanpa pengajuan ditampilkan dengan nilai nol.
        </p>
    </div>
</div>

{{-- DISTRIBUSI STATUS --}}
@php
    $statusLabels = [
        'diajukan' => 'Diajukan',
        'diverifikasi' => 'Diverifikasi',
        'diproses' => 'Diproses',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
    ];

    $statusColors = [
        'diajukan' => 'bg-sky-500',
        'diverifikasi' => 'bg-indigo-500',
        'diproses' => 'bg-amber-500',
        'selesai' => 'bg-emerald-500',
        'ditolak' => 'bg-rose-500',
    ];

    $statusPanels = [
        [
            'title' => 'Status Permohonan Informasi',
            'description' => 'Distribusi status permohonan informasi.',
            'total' => $informationTotal,
            'items' => $informationStatuses,
        ],
        [
            'title' => 'Status Pengajuan Keberatan',
            'description' => 'Distribusi status pengajuan keberatan.',
            'total' => $objectionTotal,
            'items' => $objectionStatuses,
        ],
    ];
@endphp

<div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
    @foreach ($statusPanels as $panel)
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900">
                    {{ $panel['title'] }}
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $panel['description'] }} Tahun {{ $year }}.
                </p>
            </div>

            <div class="mt-5 flex items-end justify-between rounded-xl bg-slate-50 p-4">
                <div>
                    <p class="text-xs font-medium text-slate-500">Total tercatat</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900">
                        {{ number_format($panel['total'], 0, ',', '.') }}
                    </p>
                </div>
                <span class="rounded-lg bg-white px-3 py-2 text-xs font-semibold text-slate-500 ring-1 ring-slate-200">
                    {{ $year }}
                </span>
            </div>

            <div class="mt-6 space-y-5">
                @foreach ($statusLabels as $statusKey => $statusLabel)
                    @php
                        $statusCount = (int) ($panel['items'][$statusKey] ?? 0);
                        $percentage = $panel['total'] > 0
                            ? ($statusCount / $panel['total']) * 100
                            : 0;
                    @endphp

                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                            <span class="font-medium text-slate-700">
                                {{ $statusLabel }}
                            </span>
                            <span class="shrink-0 font-semibold text-slate-900">
                                {{ number_format($statusCount, 0, ',', '.') }}
                                <span class="ml-1 font-normal text-slate-400">
                                    {{ number_format($percentage, 1, ',', '.') }}%
                                </span>
                            </span>
                        </div>

                        <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full {{ $statusColors[$statusKey] }}"
                                 style="width: {{ $percentage }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

{{-- CATATAN PRIVASI --}}
<div class="flex items-start gap-3 rounded-2xl border border-teal-100 bg-teal-50 p-5">
    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-teal-700 ring-1 ring-teal-100">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                  d="M12 9v3m0 4h.01M10.3 3.86 1.82 18.5A2 2 0 0 0 3.55 21h16.9a2 2 0 0 0 1.73-2.5L13.7 3.86a2 2 0 0 0-3.4 0Z"/>
        </svg>
    </div>

    <div>
        <h3 class="text-sm font-bold text-teal-900">
            Informasi Statistik
        </h3>
        <p class="mt-1 text-sm leading-6 text-teal-800">
            Statistik ditampilkan dalam bentuk data agregat untuk memberikan
            gambaran layanan PPID pada tahun {{ $year }}. Informasi pribadi
            pemohon, rincian permohonan, dan dokumen pendukung tidak ditampilkan
            pada halaman publik ini.
        </p>
    </div>
</div>


        </div>
    </section>
</x-layouts.app>
