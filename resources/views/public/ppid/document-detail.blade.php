<x-layouts.app
    title="{{ $ppidDocument->title }} — RSUD R.A.A. Tjokronegoro"
    meta-description="{{ $ppidDocument->description ?? $ppidDocument->title }}"
>
    <section class="bg-slate-50 min-h-screen py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Kembali --}}
            <a
                href="{{ route('ppid.information.periodic') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-[#007b83]"
            >
                ← Kembali ke Daftar PPID Berkala
            </a>

            {{-- Detail Dokumen --}}
            <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-6 sm:px-8">

                    {{-- Informasi halaman dari CMS --}}
                    @if($page)
                        <p class="text-sm font-semibold text-[#007b83]">
                            {{ $page->title }}
                        </p>
                    @endif

                    <div class="mt-3 flex flex-wrap items-center gap-2">

                        <span class="rounded-full bg-[#e5f6f4] px-3 py-1 text-xs font-semibold text-[#007b83]">
                            {{ $menu?->menu ?? 'Informasi Publik' }}
                        </span>

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                            Tahun {{ $ppidDocument->year }}
                        </span>

                    </div>

                    <h1 class="mt-4 whitespace-nowrap text-xl font-bold leading-tight text-slate-900 sm:text-2xl">
                        {{ $ppidDocument->title }}
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Terakhir diperbarui:
                        {{ $ppidDocument->updated_at?->format('d F Y') }}
                    </p>

                </div>
                {{-- File / Link --}}
                <div class="p-6 sm:p-8">

                   @if($ppidDocument->type === 'file' && $ppidDocument->file_path)

                    <div class="flex justify-end mb-4">
                        <a
                            href="{{ asset('storage/' . $ppidDocument->file_path) }}"
                            target="_blank"
                            class="inline-flex items-center rounded-lg bg-[#007b83] px-4 py-2 text-sm font-semibold text-white hover:bg-[#006b72]"
                        >
                            Unduh File Asli
                        </a>
                    </div>

                    @php
                        $extension = strtolower(
                            pathinfo($ppidDocument->file_path, PATHINFO_EXTENSION)
                        );
                    @endphp

                    {{-- PDF --}}
                    @if($extension === 'pdf')

                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
                            <iframe
                                src="{{ asset('storage/' . $ppidDocument->file_path) }}"
                                class="h-[700px] w-full"
                                title="{{ $ppidDocument->title }}"
                            ></iframe>
                        </div>

                    {{-- Gambar --}}
                    @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))

                        <div class="flex justify-center rounded-xl border border-slate-200 bg-slate-100 p-4">
                            <img
                                src="{{ asset('storage/' . $ppidDocument->file_path) }}"
                                alt="{{ $ppidDocument->title }}"
                                class="max-h-[700px] w-auto max-w-full rounded-lg object-contain"
                            >
                        </div>

                    {{-- File lainnya --}}
                    @else

                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-6 py-10 text-center">
                            <p class="text-sm text-slate-500">
                                File ini tidak dapat ditampilkan langsung di halaman.
                            </p>

                            <a
                                href="{{ asset('storage/' . $ppidDocument->file_path) }}"
                                target="_blank"
                                class="mt-4 inline-flex items-center rounded-lg bg-[#007b83] px-4 py-2 text-sm font-semibold text-white hover:bg-[#006b72]"
                            >
                                Buka File
                            </a>
                        </div>

                    @endif

                    @elseif($ppidDocument->url)

                        @php
                            $embedUrl = $ppidDocument->url;
                            $downloadUrl = null;

                            if (str_contains($embedUrl, 'drive.google.com/file/d/')) {
                                preg_match(
                                    '/drive\.google\.com\/file\/d\/([^\/]+)/',
                                    $embedUrl,
                                    $matches
                                );

                                if (!empty($matches[1])) {
                                    $fileId = $matches[1];

                                    $embedUrl = "https://drive.google.com/file/d/{$fileId}/preview";
                                    $downloadUrl = "https://drive.google.com/uc?export=download&id={$fileId}";
                                }
                            }
                        @endphp

                        {{-- Preview Google Drive --}}
                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
                            <iframe
                                src="{{ $embedUrl }}"
                                class="h-[450px] w-full"
                                title="{{ $ppidDocument->title }}"
                                allow="autoplay"
                            ></iframe>
                        </div>

                        {{-- Tombol --}}
                        <div class="mt-4 flex justify-center gap-3">

                            {{-- Buka di Google Drive --}}
                            <a
                                href="{{ $ppidDocument->url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center rounded-lg border border-[#007b83] bg-white px-4 py-2 text-sm font-semibold text-[#007b83] hover:bg-[#f7fbfb]"
                            >
                                Buka di Google Drive
                            </a>

                            {{-- Unduh Dokumen --}}
                            @if($downloadUrl)
                                <a
                                    href="{{ $downloadUrl }}"
                                    class="inline-flex items-center gap-2 rounded-lg bg-[#007b83] px-4 py-2 text-sm font-semibold text-white hover:bg-[#006b72]"
                                >
                                    ↓ Unduh Dokumen
                                </a>
                            @endif

                        </div>

                    @else
                    
                    <div class="py-10 text-center text-sm text-slate-500">
                        Dokumen belum memiliki file atau tautan.
                    </div>

                @endif

                </div>
            </div>

        </div>
    </section>
</x-layouts.app>