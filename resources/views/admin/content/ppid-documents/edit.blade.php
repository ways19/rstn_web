<x-layouts.admin title="Edit Dokumen PPID">

    <div class="space-y-6">

        {{-- Header --}}
        <div>
            <a
                href="{{ route('admin.ppid-documents.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-[#007b83] hover:underline"
            >
                ← Kembali ke Dokumen PPID
            </a>

            <h1 class="mt-4 text-2xl font-bold text-[#1f2937]">
                Edit Dokumen PPID
            </h1>

            <p class="mt-1 text-sm text-[#6b7280]">
                Perbarui informasi dan penempatan dokumen PPID.
            </p>
        </div>

        {{-- Validation Error --}}
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                <div class="text-sm font-semibold text-red-700">
                    Ada data yang perlu diperbaiki:
                </div>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form
            action="{{ route('admin.ppid-documents.update', $ppidDocument) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            <div class="rounded-2xl border border-[#e5e7eb] bg-white p-6 shadow-sm">

                <div class="grid gap-6 md:grid-cols-2">

                    {{-- Title --}}
                    <div class="md:col-span-2">
                        <label
                            for="title"
                            class="mb-2 block text-sm font-semibold text-[#374151]"
                        >
                            Judul Dokumen
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title', $ppidDocument->title) }}"
                            class="w-full rounded-xl border border-[#dce3ea] px-4 py-3 text-sm outline-none transition focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                            required
                        >
                    </div>

                    {{-- Penempatan Dokumen --}}
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-[#374151]">
                            Penempatan Dokumen
                        </label>

                        <p class="mb-4 text-xs text-[#8a96a3]">
                            Pilih satu atau beberapa induk informasi tempat dokumen ini akan ditampilkan.
                        </p>

                        @php
                            $existingSectionIds = $ppidDocument->placements
                                ->pluck('page_section_id')
                                ->map(fn ($id) => (int) $id)
                                ->toArray();

                            $selectedSectionIds = old(
                                'page_section_ids',
                                $existingSectionIds
                            );

                            $groupedSections = $sections->groupBy('page_id');
                        @endphp

                        <div class="space-y-3">
                            @foreach ($pages as $page)
                                @php
                                    $pageSections = $groupedSections->get($page->id, collect());
                                @endphp

                                @if ($pageSections->isNotEmpty())
                                    <details class="group overflow-hidden rounded-xl border border-[#dce3ea] bg-white">

                                        {{-- Judul Halaman --}}
                                        <summary class="flex cursor-pointer list-none items-center gap-3 bg-[#fafcfc] px-4 py-3 hover:bg-[#f4fafa]">
                                            <span class="text-[#007b83] transition-transform group-open:rotate-90">
                                                ▶
                                            </span>

                                            <span class="text-sm font-semibold text-[#374151]">
                                                {{ $page->title }}
                                            </span>
                                        </summary>

                                        {{-- Isi --}}
                                        <div class="space-y-2 border-t border-[#e5e7eb] p-3">

                                            @foreach ($pageSections->whereNull('parent_id') as $section)

                                                {{-- Level 1 --}}
                                                <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-[#dce3ea] bg-[#fafcfc] px-4 py-3 hover:bg-[#f4fafa]">
                                                    <input
                                                        type="checkbox"
                                                        name="page_section_ids[]"
                                                        value="{{ $section->id }}"
                                                        @checked(in_array($section->id, $selectedSectionIds))
                                                        class="h-4 w-4 rounded border-slate-300 text-[#007b83] focus:ring-[#007b83]"
                                                    >

                                                    <span class="text-sm font-semibold text-[#374151]">
                                                        {{ $section->title }}
                                                    </span>

                                                    <span class="ml-auto text-xs text-[#9ca3af]">
                                                        Level 1
                                                    </span>
                                                </label>

                                                {{-- Level 2 --}}
                                                @foreach ($pageSections->where('parent_id', $section->id) as $child)
                                                    <label class="ml-6 flex cursor-pointer items-center gap-3 rounded-xl border border-[#e5e7eb] bg-white px-4 py-3 hover:bg-[#f8fafb]">
                                                        <input
                                                            type="checkbox"
                                                            name="page_section_ids[]"
                                                            value="{{ $child->id }}"
                                                            @checked(in_array($child->id, $selectedSectionIds))
                                                            class="h-4 w-4 rounded border-slate-300 text-[#007b83] focus:ring-[#007b83]"
                                                        >

                                                        <span class="text-sm text-[#526174]">
                                                            ↳ {{ $child->title }}
                                                        </span>

                                                        <span class="ml-auto text-xs text-[#9ca3af]">
                                                            Level 2
                                                        </span>
                                                    </label>
                                                @endforeach

                                            @endforeach

                                        </div>
                                    </details>
                                @endif
                            @endforeach
                        </div>

                        @error('page_section_ids')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        @error('page_section_ids.*')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Year --}}
                    <div>
                        <label
                            for="year"
                            class="mb-2 block text-sm font-semibold text-[#374151]"
                        >
                            Tahun
                        </label>

                        <input
                            type="number"
                            id="year"
                            name="year"
                            value="{{ old('year', $ppidDocument->year) }}"
                            min="2000"
                            max="2100"
                            class="w-full rounded-xl border border-[#dce3ea] px-4 py-3 text-sm outline-none transition focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                            required
                        >
                    </div>

                    {{-- Type --}}
                    <div>
                        <label
                            for="type"
                            class="mb-2 block text-sm font-semibold text-[#374151]"
                        >
                            Tipe Dokumen
                        </label>

                        <select
                            id="type"
                            name="type"
                            class="w-full rounded-xl border border-[#dce3ea] bg-white px-4 py-3 text-sm outline-none transition focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                            required
                        >
                            <option value="">Pilih tipe</option>

                            <option
                                value="page"
                                @selected(old('type', $ppidDocument->type) === 'page')
                            >
                                Halaman
                            </option>

                            <option
                                value="file"
                                @selected(old('type', $ppidDocument->type) === 'file')
                            >
                                File
                            </option>

                            <option
                                value="link"
                                @selected(old('type', $ppidDocument->type) === 'link')
                            >
                                Link
                            </option>

                            <option
                                value="video"
                                @selected(old('type', $ppidDocument->type) === 'video')
                            >
                                Video
                            </option>
                        </select>
                    </div>

                    {{-- Page --}}
                    <div
                        id="page-field"
                        class="hidden md:col-span-2"
                    >
                        <label
                            for="page_id"
                            class="mb-2 block text-sm font-semibold text-[#374151]"
                        >
                            Halaman Tujuan
                        </label>

                        <select
                            id="page_id"
                            name="page_id"
                            class="w-full rounded-xl border border-[#dce3ea] bg-white px-4 py-3 text-sm outline-none transition focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                        >
                            <option value="">Pilih halaman</option>

                            @foreach ($pages as $page)
                                <option
                                    value="{{ $page->id }}"
                                    @selected(old('page_id', $ppidDocument->page_id) == $page->id)
                                >
                                    {{ $page->title }}
                                </option>
                            @endforeach
                        </select>

                        <p class="mt-2 text-xs text-[#8a96a3]">
                            Dokumen akan membuka halaman yang dipilih ketika diklik.
                        </p>
                    </div>

                    {{-- File --}}
                    <div
                        id="file-field"
                        class="hidden md:col-span-2"
                    >
                        <label
                            for="file_path"
                            class="mb-2 block text-sm font-semibold text-[#374151]"
                        >
                            File Dokumen
                        </label>

                        @if ($ppidDocument->file_path)

                            <div class="mb-3 rounded-xl border border-[#dce3ea] bg-[#f8fafb] px-4 py-3">
                                <p class="text-xs text-[#8a96a3]">
                                    File saat ini:
                                </p>

                                <p class="mt-1 text-sm font-medium text-[#374151]">
                                    {{ basename($ppidDocument->file_path) }}
                                </p>
                            </div>

                        @endif

                        <input
                            type="file"
                            id="file_path"
                            name="file_path"
                            class="block w-full rounded-xl border border-[#dce3ea] bg-white px-4 py-3 text-sm text-[#526174] file:mr-4 file:rounded-lg file:border-0 file:bg-[#eef7f7] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#007b83]"
                        >

                        <p class="mt-2 text-xs text-[#8a96a3]">
                            Kosongkan jika tidak ingin mengganti file.
                            Format yang didukung: PDF, Word, Excel, JPG, PNG, dan WEBP. Maksimal 10 MB.
                        </p>
                    </div>

                    {{-- URL --}}
                    <div
                        id="url-field"
                        class="hidden md:col-span-2"
                    >
                        <label
                            for="url"
                            class="mb-2 block text-sm font-semibold text-[#374151]"
                        >
                            URL Tujuan
                        </label>

                        <input
                            type="url"
                            id="url"
                            name="url"
                            value="{{ old('url', $ppidDocument->url) }}"
                            placeholder="https://..."
                            class="w-full rounded-xl border border-[#dce3ea] px-4 py-3 text-sm outline-none transition focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                        >

                        <p class="mt-2 text-xs text-[#8a96a3]">
                            Gunakan untuk link eksternal atau video.
                        </p>
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label
                            for="description"
                            class="mb-2 block text-sm font-semibold text-[#374151]"
                        >
                            Deskripsi
                            <span class="font-normal text-[#9ca3af]">(opsional)</span>
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Tambahkan keterangan singkat mengenai dokumen..."
                            class="w-full rounded-xl border border-[#dce3ea] px-4 py-3 text-sm outline-none transition focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                        >{{ old('description', $ppidDocument->description) }}</textarea>
                    </div>

                    {{-- Sort Order --}}
                    <div>
                        <label
                            for="sort_order"
                            class="mb-2 block text-sm font-semibold text-[#374151]"
                        >
                            Urutan
                        </label>

                        <input
                            type="number"
                            id="sort_order"
                            name="sort_order"
                            value="{{ old('sort_order', $ppidDocument->sort_order) }}"
                            min="0"
                            class="w-full rounded-xl border border-[#dce3ea] px-4 py-3 text-sm outline-none transition focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                        >

                        <p class="mt-2 text-xs text-[#8a96a3]">
                            Angka lebih kecil akan tampil lebih dahulu.
                        </p>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[#374151]">
                            Status
                        </label>

                        <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-[#dce3ea] px-4 py-3">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                @checked(old('is_active', $ppidDocument->is_active))
                                class="h-4 w-4 rounded border-gray-300 text-[#007b83] focus:ring-[#007b83]"
                            >

                            <span class="text-sm text-[#526174]">
                                Tampilkan dokumen di website
                            </span>
                        </label>
                    </div>

                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">

                <a
                    href="{{ route('admin.ppid-documents.index') }}"
                    class="rounded-xl border border-[#dce3ea] bg-white px-5 py-2.5 text-sm font-semibold text-[#526174] transition hover:bg-[#f8fafb]"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-[#007b83] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#006b72]"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

    {{-- Type Switcher --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const type = document.getElementById('type');

            const pageField = document.getElementById('page-field');
            const fileField = document.getElementById('file-field');
            const urlField = document.getElementById('url-field');

            function updateFields() {
                pageField.classList.add('hidden');
                fileField.classList.add('hidden');
                urlField.classList.add('hidden');

                if (type.value === 'page') {
                    pageField.classList.remove('hidden');
                }

                if (type.value === 'file') {
                    fileField.classList.remove('hidden');
                }

                if (type.value === 'link' || type.value === 'video') {
                    urlField.classList.remove('hidden');
                }
            }

            type.addEventListener('change', updateFields);

            updateFields();
        });
    </script>

</x-layouts.admin>