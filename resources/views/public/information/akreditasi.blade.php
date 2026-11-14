<x-layouts.app title="Akreditasi — RSUD R.A.A. Tjokronegoro">

    <x-page-header
        title="Akreditasi"
        description="Informasi mengenai akreditasi pendidikan dan pelatihan di RSUD R.A.A. Tjokronegoro."
    />

    {{-- Submenu Pendidikan & Pelatihan --}}
    <x-submenus.diklat active="accreditation" />

    {{-- Breadcrumb --}}
    <div class="bg-slate-50">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <nav
                class="flex items-center gap-2 py-5 text-sm"
                aria-label="Breadcrumb"
            >

                <a href="{{ url('/informasi/diklat') }}" class="font-medium text-slate-500 hover:text-[#007b83]">
                    Informasi
                </a>

                <span class="text-slate-300">
                    ›
                </span>

                <span class="font-semibold text-[#007b83]">
                    Akreditasi
                </span>

            </nav>

        </div>

    </div>


    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-3 pb-8">

        {{-- Konten utama dari CMS --}}
        {!! $page->content !!}

        
{{-- DAFTAR SERTIFIKAT AKREDITASI --}}
@php
    $certificates = $page->accreditationCertificates
        ->where('is_active', true)
        ->sortByDesc(function ($certificate) {
            return (
                $certificate->certificate_date
                ?? $certificate->created_at
            )?->timestamp ?? 0;
        })
        ->values();


        $certificateItems = $certificates->map(function ($certificate) {
            $externalUrl = $certificate->external_url;
            $filePath = $certificate->file_path;

            $isExternal = !empty($externalUrl);
            $url = $isExternal
                ? $externalUrl
                : ($filePath ? asset('storage/' . $filePath) : null);

            $extension = $isExternal
                ? 'pdf'
                : strtolower(pathinfo($filePath ?? '', PATHINFO_EXTENSION));

            // Ubah tautan Google Drive menjadi URL preview
            $previewUrl = $url;

            if ($isExternal && $externalUrl) {
                if (preg_match(
                    '~drive\.google\.com/file/d/([^/]+)~',
                    $externalUrl,
                    $matches
                )) {
                    $previewUrl = 'https://drive.google.com/file/d/'
                        . $matches[1] . '/preview';
                }
            }

            return [
                'id' => $certificate->id,
                'title' => $certificate->title,
                'description' => $certificate->description ?? '',
                'date' => $certificate->certificate_date
                    ? $certificate->certificate_date->format('d/m/Y')
                    : null,
                'year' => (
                    $certificate->certificate_date
                    ?? $certificate->created_at
                )?->format('Y'),
                'uploadedAt' => $certificate->created_at
                    ? $certificate->created_at
                        ->timezone('Asia/Jakarta')
                        ->format('d M Y, H:i')
                    : null,
                'url' => $url,
                'previewUrl' => $previewUrl,
                'extension' => $extension,
                'isImage' => !$isExternal && in_array(
                    $extension,
                    ['jpg', 'jpeg', 'png', 'webp']
                ),
                'isPdf' => $isExternal || $extension === 'pdf',
            ];
        })->values();
@endphp

@if ($certificateItems->isNotEmpty())
    <section
        class="pt-2 pb-10 sm:pt-3 sm:pb-12"
        x-data="{
            certificates: {{ Illuminate\Support\Js::from($certificateItems) }},
            selectedId: {{ Illuminate\Support\Js::from($certificateItems->first()['id']) }},
            query: '',
            historyStart: 0,

            get selectedCertificate() {
                return this.certificates.find(
                    certificate => certificate.id === this.selectedId
                ) || null;
            },

            get filteredCertificates() {
                const keyword = this.query.trim().toLowerCase();

                if (!keyword) return this.certificates;

                return this.certificates.filter(certificate =>
                    certificate.title.toLowerCase().includes(keyword) ||
                    certificate.description.toLowerCase().includes(keyword) ||
                    String(certificate.year || '').includes(keyword)
                );
            }
        }"
    >

       
{{-- PRATINJAU SERTIFIKAT UTAMA --}}
<div class="space-y-1">

    {{-- SERTIFIKAT TERPILIH --}}
    <section
    data-sertifikat-utama
    class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm"
>

        {{-- Header sertifikat --}}
        <div class="flex flex-col justify-between gap-2 border-b border-slate-200 px-4 py-2.5 sm:flex-row sm:items-center sm:py-3">
            <div class="min-w-0">
                <h3
                    class="break-words text-xl font-bold text-slate-900 sm:text-2xl"
                    x-text="selectedCertificate ? selectedCertificate.title : ''"
                ></h3>

                <div class="mt-2 flex flex-wrap gap-x-4 gap-y-2 text-sm text-slate-500">
                    <span
                        x-show="selectedCertificate && selectedCertificate.uploadedAt"
                        x-text="'Diunggah pada: ' + (selectedCertificate?.uploadedAt || '')"
                    ></span>

                    <span
                        x-show="selectedCertificate && selectedCertificate.date"
                        x-text="'Tanggal sertifikat: ' + (selectedCertificate?.date || '')"
                    ></span>
                </div>
            </div>

            <a
                x-show="selectedCertificate"
                :href="selectedCertificate ? selectedCertificate.url : '#'"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg border border-[#007b83]/30 px-4 py-2.5 text-sm font-semibold text-[#007b83] transition hover:bg-[#007b83]/5"
            >
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M14 4h6v6m-11 5L20 4M18 13v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h5"/>
                </svg>
                Buka dokumen
            </a>
        </div>

        {{-- Pratinjau dokumen besar --}}
        <div class="bg-slate-100 p-2 sm:p-3">
          <div class="flex h-[520px] w-full items-center justify-center overflow-hidden rounded-lg border border-slate-200 bg-white sm:h-[650px] lg:h-[750px]">
                {{-- Pratinjau gambar --}}
                <template x-if="selectedCertificate && selectedCertificate.isImage">
                    <a
                        :href="selectedCertificate.url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex h-full w-full items-center justify-center p-1 sm:p-2"
                    >
                        <img
                            :src="selectedCertificate.url"
                            :alt="selectedCertificate.title"
                            class="max-h-full w-full object-contain"
                        >
                    </a>
                </template>

                {{-- Pratinjau PDF --}}
                <template x-if="selectedCertificate && selectedCertificate.isPdf">
                    <iframe
                        :src="selectedCertificate.previewUrl + '#toolbar=1&navpanes=0'"
                        :title="'Pratinjau ' + selectedCertificate.title"
                        class="h-full min-h-[520px] w-full bg-white sm:min-h-[650px] lg:min-h-[750px]"
                    ></iframe>
                </template>

                {{-- Format dokumen lainnya --}}
                <template x-if="selectedCertificate && !selectedCertificate.isImage && !selectedCertificate.isPdf">
                    <div class="p-8 text-center">
                        <p class="font-semibold text-slate-800">
                            Pratinjau tidak tersedia
                        </p>
                        <p class="mt-2 text-sm text-slate-500">
                            Gunakan tombol Buka dokumen untuk melihat file.
                        </p>
                    </div>
                </template>
            </div>
        </div>   
    </section>



{{-- HISTORI SERTIFIKAT --}}
<div class="mt-5">
    <div class="mb-3">
        <h3 class="text-lg font-bold text-slate-900">
            Histori Sertifikat Akreditasi
        </h3>
        <p class="mt-1 text-sm text-slate-500">
            Pilih sertifikat untuk melihat pratinjaunya.
        </p>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <template
            x-for="certificate in certificates.filter(item => item.id !== certificates[0]?.id)"
            :key="certificate.id"
        >
            <a
    :href="certificate.url"
    target="_blank"
    rel="noopener noreferrer"
    class="flex w-full flex-col gap-3 border-b border-slate-200 p-4 text-left transition last:border-b-0 hover:bg-slate-50 sm:flex-row sm:items-center sm:justify-between"
>
    <div class="flex min-w-0 items-start gap-3">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-[#007b83]">
            <svg
                class="h-6 w-6"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.6"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M14 3v5h5M9 13h6M9 17h6"
                />
            </svg>
        </div>

        <div class="min-w-0 flex-1">
            <h4
                class="break-words font-semibold text-slate-800"
                x-text="certificate.title"
            ></h4>

            <p class="mt-1 text-sm text-slate-500">
                Tahun <span x-text="certificate.year || '-'"></span>
                <span
                    x-show="certificate.date"
                    x-text="' · Tanggal sertifikat: ' + certificate.date"
                ></span>
            </p>

            <p
                x-show="certificate.description"
                class="mt-1 text-sm leading-relaxed text-slate-600"
                x-text="certificate.description"
            ></p>
        </div>
    </div>

    <span class="inline-flex shrink-0 items-center gap-2 self-start text-sm font-semibold text-[#007b83] sm:self-center">
        Lihat sertifikat
        <svg
            class="h-4 w-4"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.7"
            aria-hidden="true"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M14 4h6v6m-11 5L20 4"
            />
        </svg>
    </span>
</a>
        </template>

        <div
            x-show="certificates.length <= 1"
            class="p-5 text-center text-sm text-slate-500"
        >
            Belum ada histori sertifikat lainnya.
        </div>
    </div>
</div>
</section>




    {{-- Keterangan sertifikat --}}
    <div class="mt-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
        <h4 class="text-sm font-semibold text-[#172033]">
             Keterangan Sertifikat
        </h4>

        <p class="mt-2 text-sm leading-relaxed text-gray-600">
            Sertifikat contoh akreditasi program pendidikan dan pembelajaran
            di lingkungan rumah sakit.
        </p>     
    </div>       

  

</div>

@endif

    </main>

</x-layouts.app>