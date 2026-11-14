<x-layouts.admin title="Edit Induk Informasi">

    <div class="space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Edit Induk Informasi
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                @if ($pageSection->level == 1)
                    Perbarui nama dan pengaturan induk informasi.
                @else
                    Perbarui nama dan induk informasi.
                @endif
            </p>
        </div>

        {{-- Form --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <form
                action="{{ route('admin.page-sections.update', $pageSection) }}"
                method="POST"
                class="space-y-6"
            >
                @csrf
                @method('PUT')

                {{-- Data yang tetap dibutuhkan oleh sistem --}}
                <input
                    type="hidden"
                    name="page_id"
                    value="{{ $pageSection->page_id }}"
                >

                <input
                    type="hidden"
                    name="level"
                    value="{{ $pageSection->level }}"
                >

                {{-- Judul Induk Informasi --}}
                <div>
                    <label
                        for="title"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Judul Induk Informasi
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $pageSection->title) }}"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#007b83] focus:outline-none focus:ring-1 focus:ring-[#007b83]"
                    >

                    @error('title')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Induk Informasi --}}
                @if ($pageSection->level == 2)

                    <div>
                        <label
                            for="parent_id"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Induk Informasi
                        </label>

                        <select
                            id="parent_id"
                            name="parent_id"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#007b83] focus:outline-none focus:ring-1 focus:ring-[#007b83]"
                        >
                            <option value="">
                                — Pilih Induk Informasi —
                            </option>

                            @foreach ($pageSection->page->sections->where('level', 1) as $parent)

                                <option
                                    value="{{ $parent->id }}"
                                    {{ old('parent_id', $pageSection->parent_id) == $parent->id ? 'selected' : '' }}
                                >
                                    {{ $parent->title }}
                                </option>

                            @endforeach

                        </select>

                        @error('parent_id')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <p class="mt-1.5 text-xs text-slate-500">
                            Hanya induk Level 1 yang dapat dipilih.
                        </p>
                    </div>

                @endif


                {{-- Urutan --}}
                <div>
                    <label
                        for="sort_order"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Urutan
                    </label>

                    <input
                        type="number"
                        id="sort_order"
                        name="sort_order"
                        value="{{ old('sort_order', $pageSection->sort_order) }}"
                        min="0"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#007b83] focus:outline-none focus:ring-1 focus:ring-[#007b83]"
                    >

                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Status --}}
                <div class="flex items-center gap-3">

                    <input
                        type="hidden"
                        name="is_active"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        id="is_active"
                        name="is_active"
                        value="1"
                        {{ old('is_active', $pageSection->is_active) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-slate-300 text-[#007b83] focus:ring-[#007b83]"
                    >

                    <label
                        for="is_active"
                        class="text-sm font-medium text-slate-700"
                    >
                        Induk informasi aktif
                    </label>

                </div>

                {{-- Informasi di dalam Induk --}}
                <div class="space-y-3 border-t border-slate-200 pt-6">

                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-semibold text-slate-800">
                                Informasi di Dalam Induk
                            </h2>

                            <p class="mt-1 text-xs text-slate-500">
                                Daftar dokumen, halaman website, atau link yang berada di dalam induk ini.
                            </p>
                        </div>

                        <a
                            href="{{ route('admin.pages.edit', $pageSection->page_id) }}"
                            class="text-xs font-semibold text-[#007b83] hover:text-[#006b72]"
                        >
                            + Tambah Informasi
                        </a>
                    </div>

                    @if ($pageSection->placements->count())

                        <div class="divide-y divide-slate-200 rounded-lg border border-slate-200">

                            @foreach ($pageSection->placements as $placement)

                                @php
                                    $document = $placement->document;
                                @endphp

                                @if ($document)

                                    <div class="flex items-center justify-between gap-4 px-4 py-3">

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-medium text-slate-800">
                                                {{ $document->title }}
                                            </p>

                                            <div class="mt-1 flex items-center gap-2">

                                                @if ($document->type === 'file')
                                                    <span class="text-xs text-slate-500">
                                                        Dokumen PDF
                                                    </span>

                                                @elseif ($document->type === 'page')
                                                    <span class="text-xs text-slate-500">
                                                        Halaman Website
                                                    </span>

                                                @elseif ($document->type === 'link')
                                                    <span class="text-xs text-slate-500">
                                                        Link Dokumen
                                                    </span>

                                                @endif

                                            </div>

                                        </div>

                                        <div class="flex shrink-0 items-center gap-3">

                                            <a
                                                href="{{ route('admin.ppid-documents.edit', $document) }}"
                                                class="text-xs font-semibold text-[#526174] hover:text-[#172033]"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('admin.ppid-documents.destroy', $document) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus informasi ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="text-xs font-semibold text-red-500 hover:text-red-700"
                                                >
                                                    Hapus
                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                @endif

                            @endforeach

                        </div>

                    @else

                        <div class="rounded-lg border border-dashed border-slate-300 px-4 py-6 text-center">

                            <p class="text-xs text-slate-500">
                                Belum ada informasi di dalam induk ini.
                            </p>

                        </div>

                    @endif

                </div>

                {{-- Tombol --}}
                <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-5">

                    <a
                        href="{{ route('admin.pages.index') }}"
                        class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-[#007b83] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#006b72]"
                    >
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts.admin>