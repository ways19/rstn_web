<x-layouts.admin title="Edit Konten Halaman">

    <div class="space-y-6">

        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}
        <div class="flex items-start justify-between gap-4">

            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-[26px] font-semibold tracking-[-0.02em] text-[#172033] dark:text-white">
                        Edit Konten Halaman
                    </h1>

                    <span class="rounded-full bg-[#e7f8fb] px-3 py-1 text-[11px] font-semibold text-[#079fbb]">
                        PPID
                    </span>
                </div>

                <p class="mt-2 max-w-3xl text-[14px] leading-6 text-[#748195]">
                    Perbarui isi halaman PPID yang akan ditampilkan pada website publik.
                </p>
            </div>

            {{-- HEADER ACTIONS --}}
            <div class="flex shrink-0 flex-nowrap items-center gap-2.5">

                @if ($page->slug)
                    <a
                        href="{{ url('/ppid/' . $page->slug) }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 rounded-xl border border-[#7bd9dc] bg-white px-4 py-3 text-[13px] font-semibold text-[#078f99] transition hover:bg-[#f0fdfd]"
                    >
                        ↗ Lihat di Web
                    </a>
                @endif

                <a
                    href="{{ route('admin.pages.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[#dce3ea] bg-white px-4 py-3 text-[13px] font-semibold text-[#526174] shadow-sm transition hover:border-[#b9c6d4] hover:bg-[#fbfcfd]"
                >
                    ← Kembali ke Daftar
                </a>

            </div>
        </div>


        {{-- ===================================================== --}}
        {{-- FORM --}}
        {{-- ===================================================== --}}
        <div class="overflow-hidden rounded-[20px] border border-[#dce3ea] bg-white shadow-sm">

                <form
                    id="formEditHalaman"
                    action="{{ route('admin.pages.update', $page) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

                <div class="space-y-7 p-7">

                    {{-- ================================================= --}}
                    {{-- INFORMASI DASAR --}}
                    {{-- ================================================= --}}
                    <div>

                        <div class="mb-5">
                            <h2 class="text-[16px] font-semibold text-[#172033] dark:text-white">
                                Informasi Halaman
                            </h2>

                            <p class="mt-1 text-[12px] text-[#7b8999]">
                                Atur identitas halaman PPID yang akan digunakan pada website.
                            </p>
                        </div>


                        {{-- JUDUL --}}
                        <div>
                            <label
                                for="title"
                                class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                            >
                                Judul Halaman <span class="text-[#e25555]">*</span>
                            </label>

                            <input
                                id="title"
                                type="text"
                                name="title"
                                value="{{ old('title', $page->title) }}"
                                required
                                class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none transition focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                placeholder="Masukkan judul halaman"
                            >

                            @error('title')
                                <p class="mt-1.5 text-[11px] text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- CATEGORY --}}
                        <div class="mt-5">

                            <label
                                for="category"
                                class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                            >
                                Kategori <span class="text-[#e25555]">*</span>
                            </label>

                            <input
                                id="category"
                                type="text"
                                name="category"
                                value="{{ old('category', $page->category) }}"
                                required
                                class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none transition focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                            >

                            @error('category')
                                <p class="mt-1.5 text-[11px] text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- SLUG --}}
                        <div class="mt-5">

                            <div class="mb-2 flex items-center justify-between gap-3">

                                <label
                                    for="slug"
                                    class="text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                                >
                                    Slug URL
                                    <span class="normal-case">
                                        (Pengenal Unik) <span class="text-[#e25555]">*</span>
                                    </span>
                                </label>

                                <button
                                    type="button"
                                    id="syncSlug"
                                    class="text-[10px] font-semibold text-[#557084] transition hover:text-[#079fb7]"
                                >
                                    ↻ Sinkronkan dari Judul
                                </button>

                            </div>

                            <input
                                id="slug"
                                type="text"
                                name="slug"
                                value="{{ old('slug', $page->slug) }}"
                                required
                                class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none transition focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                            >

                            @error('slug')
                                <p class="mt-1.5 text-[11px] text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- DESCRIPTION --}}
                        <div class="mt-5">

                            <label
                                for="description"
                                class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                            >
                                Deskripsi Halaman
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="3"
                                class="w-full rounded-xl border border-[#dce3ea] bg-white px-4 py-3 text-[13px] leading-6 text-[#263246] outline-none transition focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                placeholder="Masukkan deskripsi singkat halaman..."
                            >{{ old('description', $page->description) }}</textarea>

                            @error('description')
                                <p class="mt-1.5 text-[11px] text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>
  
                    {{-- CONTENT EDITOR --}}
                    <div class="border-t border-[#edf0f3] pt-7">
                        <div class="mb-4">
                            <h2 class="text-[16px] font-semibold text-[#172033] dark:text-white">
                                Isi Konten Halaman
                            </h2>

                            <p class="mt-1 text-[12px] text-[#7b8999]">
                                Tulis dan format isi halaman menggunakan editor visual.
                            </p>
                        </div>

                        <textarea
                            id="content"
                            name="content"
                            required
                        >{{ old('content', $page->content) }}</textarea>

                        @error('content')
                            <p class="mt-1.5 text-[11px] text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- ================================================= --}}
                    {{-- DOKUMEN SK --}}
                    {{-- ================================================= --}}
                    @if ($page->slug === 'sk-tim-ppid')

                        <div class="border-t border-[#edf0f3] pt-7">

                            <div class="mb-4">
                                <h2 class="text-[16px] font-semibold text-[#172033] dark:text-white">
                                    Dokumen Pendukung
                                </h2>

                                <p class="mt-1 text-[12px] text-[#7b8999]">
                                    Tambahkan dokumen SK Tim PPID melalui link atau upload file langsung.
                                </p>
                            </div>

                            {{-- Pilihan metode --}}
                            <div
                                x-data="{ method: '{{ old('file_method', 'link') }}' }"
                                class="space-y-4"
                            >

                                {{-- Hidden input untuk menyimpan pilihan --}}
                                <input
                                    type="hidden"
                                    name="file_method"
                                    :value="method"
                                >

                                {{-- Pilihan metode --}}
                                <div class="flex items-center gap-2">

                                    <button
                                        type="button"
                                        @click="method = 'link'"
                                        :class="method === 'link'
                                            ? 'bg-[#007b83] text-white shadow-sm'
                                            : 'border border-[#dce3ea] bg-white text-[#526174] hover:border-[#70ccd3] hover:text-[#007b83]'"
                                        class="rounded-lg px-4 py-2 text-[12px] font-semibold transition"
                                    >
                                        Link Dokumen
                                    </button>

                                    <button
                                        type="button"
                                        @click="method = 'upload'"
                                        :class="method === 'upload'
                                            ? 'bg-[#007b83] text-white shadow-sm'
                                            : 'border border-[#dce3ea] bg-white text-[#526174] hover:border-[#70ccd3] hover:text-[#007b83]'"
                                        class="rounded-lg px-4 py-2 text-[12px] font-semibold transition"
                                    >
                                        Upload Dokumen
                                    </button>

                                </div>

                                {{-- Input Link --}}
                                <div x-show="method === 'link'" x-transition>

                                    <label
                                        for="file_link"
                                        class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                                    >
                                        Link Dokumen
                                    </label>

                                    <input
                                        id="file_link"
                                        type="url"
                                        name="file_link"
                                        value="{{ old('file_link', $page->file_attachment && filter_var($page->file_attachment, FILTER_VALIDATE_URL) ? $page->file_attachment : '') }}"
                                        placeholder="https://drive.google.com/..."
                                        class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] text-[#263246] outline-none transition focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                    >

                                    @error('file_link')
                                        <p class="mt-1.5 text-[11px] text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                                {{-- Input Upload --}}
                                <div x-show="method === 'upload'" x-transition>

                                    <label
                                        for="file_attachment"
                                        class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                                    >
                                        Upload Dokumen
                                    </label>

                                    <input
                                        id="file_attachment"
                                        type="file"
                                        name="file_attachment"
                                        accept=".pdf,.doc,.docx,.xls,.xlsx"
                                        class="block w-full cursor-pointer rounded-xl border border-[#dce3ea] bg-white text-[13px] text-[#526174] file:mr-4 file:border-0 file:bg-[#eefafa] file:px-4 file:py-3 file:text-[12px] file:font-semibold file:text-[#007b83] hover:file:bg-[#e1f7f7]"
                                    >

                                    <p class="mt-2 text-[11px] text-[#8b97a5]">
                                        Format: PDF, DOC, DOCX, XLS, XLSX. Maksimal 10 MB.
                                    </p>

                                    @error('file_attachment')
                                        <p class="mt-1.5 text-[11px] text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                            </div>

                        </div>

                    @endif

                    {{-- ================================================= --}}
                    {{-- GAMBAR MAKLUMAT PELAYANAN INFORMASI --}}
                    {{-- ================================================= --}}
                    @if ($page->slug === 'maklumat-pelayanan-informasi')

                        <div class="border-t border-[#edf0f3] pt-7">

                            <div class="mb-4">
                                <h2 class="text-[16px] font-semibold text-[#172033] dark:text-white">
                                    Gambar Maklumat Pelayanan Informasi
                                </h2>

                                <p class="mt-1 text-[12px] text-[#7b8999]">
                                    Tambahkan gambar Maklumat Pelayanan Informasi yang akan ditampilkan di bawah banner halaman.
                                </p>
                            </div>

                            <div class="space-y-4">

                                {{-- Preview gambar yang sudah tersimpan --}}
                                @if ($page->file_attachment)
                                    @php
                                        $imageUrl = $page->file_attachment;

                                        if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                                            $imageUrl = asset('storage/' . $imageUrl);
                                        }
                                    @endphp

                                    <div class="overflow-hidden rounded-xl border border-[#dce3ea] bg-[#f8fafb]">
                                        <div class="border-b border-[#dce3ea] px-4 py-3">
                                            <p class="text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]">
                                                Gambar Saat Ini
                                            </p>
                                        </div>

                                        <div class="flex justify-center p-4">
                                            <img
                                                src="{{ $imageUrl }}"
                                                alt="Maklumat Pelayanan Informasi"
                                                class="max-h-[500px] w-auto max-w-full rounded-lg object-contain"
                                            >
                                        </div>
                                    </div>
                                @endif

                                {{-- Upload gambar baru --}}
                                <div>
                                    <label
                                        for="file_attachment"
                                        class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                                    >
                                        Upload Gambar
                                    </label>

                                    <input
                                        id="file_attachment"
                                        type="file"
                                        name="file_attachment"
                                        accept=".jpg,.jpeg,.png,.webp"
                                        class="block w-full cursor-pointer rounded-xl border border-[#dce3ea] bg-white text-[13px] text-[#526174] file:mr-4 file:border-0 file:bg-[#eefafa] file:px-4 file:py-3 file:text-[12px] file:font-semibold file:text-[#007b83] hover:file:bg-[#e1f7f7]"
                                    >

                                    <p class="mt-2 text-[11px] text-[#8b97a5]">
                                        Format: JPG, JPEG, PNG, WEBP. Maksimal 5 MB.
                                    </p>

                                    @error('file_attachment')
                                        <p class="mt-1.5 text-[11px] text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                            </div>
                        </div>

                    @endif
                    
                 
                    {{-- ================================================= --}}
                    {{-- STRUKTUR INFORMASI PPID --}}
                    {{-- ================================================= --}}

                   @if (in_array($page->slug, [
                        'informasi-berkala',
                        'informasi-serta-merta',
                        'informasi-setiap-saat',
                        'informasi-dikecualikan',
                    ], true))

                        <div
                                class="border-t border-[#edf0f3] pt-7"
                                x-data="{ strukturTerbuka: false, formStrukturAktif: '' }"
                            >

                            <div class="mb-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <button
                                            type="button"
                                            @click="strukturTerbuka = !strukturTerbuka"
                                            class="flex items-center gap-3 text-left"
                                            :aria-expanded="strukturTerbuka.toString()"
                                        >
                                            <span
                                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#f0f5f8] text-[#526174]"
                                            >
                                                <svg
                                                    class="h-4 w-4 transition-transform duration-200"
                                                    :class="{ 'rotate-180': strukturTerbuka }"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="m19 9-7 7-7-7"
                                                    />
                                                </svg>
                                            </span>

                                            <span>
                                                <span class="block text-[16px] font-semibold text-[#172033] dark:text-white">
                                                    Struktur Informasi PPID
                                                </span>

                                                <span class="mt-1 mb-2 block text-[12px] text-[#7b8999]">
                                                    Atur kelompok informasi dan hubungan induk informasi pada halaman ini.
                                                </span>
                                            </span>
                                        </button>
                                    </div>
                                        <div class="flex items-center gap-2">
                                            <button
                                                type="button"
                                                @click="strukturTerbuka = true; formStrukturAktif = 'induk'"
                                                onclick="
                                                    document.getElementById('formTambahInduk').classList.remove('hidden');
                                                    document.getElementById('formTambahInformasi').classList.add('hidden');
                                                "
                                                :class="formStrukturAktif === 'induk'
                                                    ? 'bg-[#172033] text-white shadow-sm'
                                                    : 'border border-[#dce3ea] bg-white text-[#263246] hover:bg-[#f7f9fb]'"
                                                class="inline-flex h-[40px] items-center rounded-xl px-4 text-[12px] font-semibold transition"
                                            >
                                                + Tambah Induk Informasi
                                            </button>

                                                {{-- Tambah Informasi --}}

                                            <button
                                                type="button"
                                                @click="strukturTerbuka = true; formStrukturAktif = 'informasi'"
                                                onclick="
                                                    document.getElementById('formTambahInformasi').classList.remove('hidden');
                                                    document.getElementById('formTambahInduk').classList.add('hidden');
                                                "
                                                :class="formStrukturAktif === 'informasi'
                                                    ? 'bg-[#172033] text-white shadow-sm'
                                                    : 'border border-[#dce3ea] bg-white text-[#263246] hover:bg-[#f7f9fb]'"
                                                class="inline-flex h-[40px] items-center rounded-xl px-4 text-[12px] font-semibold transition"
                                            >
                                                + Tambah Informasi
                                            </button>
                                    </div>
                            </div>


                            {{-- ================================================= --}}
                            {{-- FORM TAMBAH INDUK INFORMASI --}}
                            {{-- ================================================= --}}
                            <div
                                id="formTambahInduk"
                                class="mb-5 hidden rounded-xl border border-[#dce3ea] bg-[#fbfcfd] p-5">
                                <div class="mb-4">
                                    <h3 class="text-[13px] font-semibold text-[#263246]">
                                        Tambah Induk Informasi
                                    </h3>

                                    <p class="mt-1 text-[11px] text-[#8b97a5]">
                                        Tambahkan judul informasi Level 1 atau Level 2.
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                                    {{-- JUDUL --}}
                                    <div class="md:col-span-2">
                                        <label
                                            class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                                        >
                                            Judul Informasi
                                        </label>

                                        <input
                                            type="text"
                                            name="section_title"
                                            placeholder="Contoh: INFORMASI TENTANG PROFIL RSUD R.A.A TJOKRONEGORO"
                                            class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none transition focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                        >
                                    </div>

                                    {{-- INDUK --}}
                                    <div class="md:col-span-2">
                                        <label
                                            class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                                        >
                                            Induk Informasi
                                        </label>

                                        <select
                                            name="parent_id"
                                            class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none transition focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                        >
                                            <option value="">
                                                — Tidak memiliki induk (Level 1) —
                                            </option>

                                            @foreach ($sections as $parent)
                                                @if ((int) $parent->level === 1)
                                                    <option value="{{ $parent->id }}">
                                                        {{ $parent->title }} (Level 1)
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>

                                        <p class="mt-1.5 text-[11px] text-[#8b97a5]">
                                            Kosongkan untuk membuat Level 1.
                                            Pilih induk Level 1 untuk membuat Level 2.
                                        </p>
                                    </div>

                                </div>

                                {{-- ACTION --}}
                                <div class="mt-5 flex justify-end gap-2">

                                    <button
                                        type="button"
                                        onclick="document.getElementById('formTambahInduk').classList.add('hidden')"
                                        class="h-[40px] rounded-xl border border-[#dce3ea] bg-white px-4 text-[12px] font-semibold text-[#526174]"
                                    >
                                        Batal
                                    </button>

                                    <button
                                        type="submit"
                                        formaction="{{ route('admin.pages.sections.store', $page) }}"
                                        formmethod="POST"
                                        class="h-[40px] rounded-xl bg-[#70ccd3] px-4 text-[12px] font-semibold text-white"
                                    >
                                        Simpan Induk
                                    </button>

                                </div>
                            </div>

                            {{-- ================================================= --}}
                            {{-- FORM TAMBAH INFORMASI / DOKUMEN --}}
                            {{-- ================================================= --}}
                            <div
                                id="formTambahInformasi"
                                class="mb-5 hidden rounded-xl border border-[#dce3ea] bg-[#fbfcfd] p-5"
                            >
                                <div class="mb-4">
                                    <h3 class="text-[13px] font-semibold text-[#263246]">
                                        Tambah Informasi
                                    </h3>

                                    <p class="mt-1 text-[11px] text-[#8b97a5]">
                                        Tambahkan dokumen atau informasi ke dalam induk yang sudah tersedia.
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                                    {{-- JUDUL INFORMASI --}}
                                    <div class="md:col-span-2">
                                        <label
                                            class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                                        >
                                            Judul Informasi
                                        </label>

                                        <input
                                            type="text"
                                            name="new_information[title]"
                                            placeholder="Contoh: Visi dan Misi"
                                            class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none transition focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                        >
                                    </div>

                                    {{-- INDUK INFORMASI --}}
                                    <div>
                                        <label
                                            class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                                        >
                                            Induk Informasi
                                        </label>

                                        <select
                                            name="new_information[section_id]"
                                            class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none transition focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                        >
                                            <option value="">
                                                — Pilih Induk Informasi —
                                            </option>
                                                @foreach ($sections->where('level', 1) as $section)
                                                    <option value="{{ $section->id }}">
                                                        {{ $section->title }} (Level 1)
                                                    </option>

                                                    @foreach ($section->children as $child)
                                                        <option value="{{ $child->id }}">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;↳ {{ $child->title }} (Level 2)
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                        </select>
                                    </div>

                                    {{-- JENIS INFORMASI --}}
                                    <div>
                                        <label
                                            class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                                        >
                                            Jenis Informasi
                                        </label>

                                        <select
                                            id="new_information_type"
                                            name="new_information[type]"
                                            onchange="toggleInformationType()"
                                            class="mt-1 w-full rounded-lg border border-[#dce3ea] bg-white px-3 py-2.5 text-[12px] text-[#263246] outline-none focus:border-[#2f80ed]"
                                        >
                                            <option value="file">Dokumen PDF</option>
                                            <option value="page">Halaman Website</option>
                                            <option value="link">Link Dokumen</option>
                                        </select>
                                    </div>

                                </div>

                                {{-- FILE DOKUMEN --}}
                                <div id="informationTypeFile" class="mt-5">
                                    <label
                                        class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                                    >
                                        File Dokumen
                                    </label>

                                    <input
                                        type="file"
                                        name="new_information[file]"
                                        accept=".pdf,.doc,.docx"
                                        class="block w-full rounded-xl border border-[#dce3ea] bg-white px-4 py-3 text-[12px] text-[#526174]"
                                    >

                                    <p class="mt-1.5 text-[11px] text-[#8b97a5]">
                                        Format yang didukung: PDF, DOC, DOCX.
                                    </p>
                                </div>

                                {{-- HALAMAN WEBSITE --}}
                                <div id="informationTypePage" class="mt-5 hidden">
                                    <label
                                        class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                                    >
                                        Halaman Website
                                    </label>

                                    <select
                                        name="new_information[page_id]"
                                        class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none"
                                    >
                                        <option value="">
                                            — Pilih Halaman Website —
                                        </option>

                                        @foreach ($pages ?? [] as $websitePage)
                                            <option value="{{ $websitePage->id }}">
                                                {{ $websitePage->title }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <p class="mt-1.5 text-[11px] text-[#8b97a5]">
                                        Pilih halaman yang sudah tersedia di website.
                                    </p>
                                </div>


                                {{-- LINK DOKUMEN --}}
                                <div id="informationTypeLink" class="mt-5 hidden">
                                    <label
                                        class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]"
                                    >
                                        Link Dokumen
                                    </label>

                                    <input
                                        type="url"
                                        name="new_information[url]"
                                        placeholder="https://drive.google.com/..."
                                        class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none transition focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                    >
                                </div>

                                {{-- ACTION --}}
                                <div class="mt-5 flex justify-end gap-2">

                                    <button
                                        type="button"
                                        onclick="document.getElementById('formTambahInformasi').classList.add('hidden')"
                                        class="h-[40px] rounded-xl border border-[#dce3ea] bg-white px-4 text-[12px] font-semibold text-[#526174]"
                                    >
                                        Batal
                                    </button>

                                    <button
                                        type="submit"
                                        formaction="{{ route('admin.pages.information.store', $page) }}"
                                        formmethod="POST"
                                        class="h-[40px] rounded-xl bg-[#172033] px-4 text-[12px] font-semibold text-white"
                                    >
                                        Simpan Informasi
                                    </button>

                                </div>
                            </div>
                            
                            {{-- KONTEN STRUKTUR YANG BISA DILIPAT --}}
                            <div x-show="strukturTerbuka" x-cloak>

                            {{-- ================================================= --}}
                            {{-- DAFTAR STRUKTUR --}}
                            {{-- ================================================= --}}

                            <div
                                id="section-list"
                                class="rounded-xl border border-[#dce3ea] bg-white"
                                data-page-id="{{ $page->id }}"
                            >

                                @forelse ($sections->where('level', 1) as $section)

                                    <div
                                        class="section-item border-b border-[#edf0f3] last:border-b-0"
                                        data-section-id="{{ $section->id }}"
                                    >

                                        {{-- LEVEL 1 --}}
                                        <div class="flex items-center justify-between gap-4 px-5 py-4">

                                            <div class="flex min-w-0 items-center gap-3">

                                                {{-- DRAG HANDLE --}}
                                                <button
                                                    type="button"
                                                    class="drag-handle cursor-grab text-[#9aa5b2] hover:text-[#526174] active:cursor-grabbing"
                                                    title="Geser untuk mengubah urutan"
                                                >
                                                    ☰
                                                </button>

                                                <div class="min-w-0">

                                                    <p class="text-[13px] font-semibold text-[#263246]">
                                                        {{ $section->title }}
                                                    </p>

                                                    <p class="mt-1 text-[11px] text-[#8b97a5]">
                                                        Informasi utama
                                                    </p>

                                                </div>

                                            </div>

                                            <a
                                                href="{{ route('admin.page-sections.edit', $section) }}"
                                                class="shrink-0 text-[11px] font-semibold text-[#526174] hover:text-[#172033]"
                                            >
                                                Edit
                                            </a>

                                        </div>


                                        {{-- LEVEL 2 --}}
                                        @if ($section->children->count())

                                            <div class="border-t border-[#edf0f3] bg-[#fbfcfd] px-5">

                                                @foreach ($section->children as $child)

                                                    <div class="flex items-center justify-between gap-4 border-b border-[#edf0f3] py-3 last:border-b-0">

                                                        <div class="flex items-center gap-3 pl-5">

                                                            <span class="text-[#9aa5b2]">
                                                                ↳
                                                            </span>

                                                            <p class="text-[12px] font-medium text-[#526174]">
                                                                {{ $child->title }}
                                                            </p>

                                                        </div>

                                                        <a
                                                            href="{{ route('admin.page-sections.edit', $child) }}"
                                                            class="shrink-0 text-[11px] font-semibold text-[#526174] hover:text-[#172033]"
                                                        >
                                                            Edit
                                                        </a>

                                                    </div>

                                                @endforeach

                                            </div>

                                        @endif

                                    </div>

                                                                @empty
                                    <div class="px-5 py-8 text-center">
                                        <p class="text-[12px] text-[#7b8999]">
                                            Belum ada informasi.
                                        </p>
                                    </div>
                                @endforelse

                            </div>
                            </div>
                        </div>
                    @endif

                    {{-- ================================================= --}}
                    {{-- STATUS --}}
                    {{-- ================================================= --}}
                    <div class="border-t border-[#edf0f3] pt-7">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                <h2 class="text-[14px] font-semibold text-[#263246]">
                                    Status Publikasi
                                </h2>

                                <p class="mt-1 text-[11px] text-[#7b8999]">
                                    Tentukan apakah halaman ini dapat ditampilkan pada website publik.
                                </p>

                            </div>


                            <label class="flex cursor-pointer items-center gap-2.5">

                                <input
                                    type="hidden"
                                    name="is_active"
                                    value="0"
                                >

                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    @checked(old('is_active', $page->is_active))
                                    class="h-4 w-4 rounded border-[#cbd5df] text-[#08b4a1] focus:ring-[#08b4a1]"
                                >

                                <span class="text-[12px] font-medium text-[#526174]">
                                    Aktifkan halaman ini di website publik
                                </span>

                            </label>

                        </div>

                    </div>

                </div>
             </form>

            </div>


                    {{-- SERTIFIKAT AKREDITASI DIKLAT --}}
                    @if ($page->slug === 'akreditasi')
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <div class="mb-2">
                                <h2 class="text-[16px] font-semibold text-[#172033] dark:text-white">
                                    Sertifikat Akreditasi Diklat
                                </h2>
                            </div>

                            <form
                                action="{{ route('admin.pages.accreditation-certificates.store', $page) }}"
                                method="POST"
                                enctype="multipart/form-data"
                                class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900"
                            >
                                @csrf

                                <div class="mb-4">
                                    <label for="certificate_title" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                        Nama Sertifikat *
                                    </label>

                                    <input
                                        id="certificate_title"
                                        type="text"
                                        name="title"
                                        value="{{ old('title') }}"
                                        required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                        placeholder="Contoh: Sertifikat Akreditasi Pelatihan"
                                    >

                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Pilihan sumber sertifikat + Preview Foto --}}
                                <div
                                    class="mb-4"
                                    x-data="{
                                        sourceType: '{{ old('source_type', 'upload') }}',
                                        previewFile: null,
                                        handleFileChange(event) {
                                            const file = event.target.files?.[0];
                                            if (this.previewFile?.url) {
                                                URL.revokeObjectURL(this.previewFile.url);
                                            }
                                            if (!file) {
                                                this.previewFile = null;
                                                return;
                                            }
                                            const isImage = file.type.startsWith('image/') || /\.(jpg|jpeg|png|webp)$/i.test(file.name);
                                            this.previewFile = {
                                                name: file.name,
                                                isImage: isImage,
                                                url: isImage ? URL.createObjectURL(file) : null
                                            };
                                        },
                                        removeSelectedFile() {
                                            if (this.previewFile?.url) {
                                                URL.revokeObjectURL(this.previewFile.url);
                                            }
                                            this.previewFile = null;
                                            if (this.$refs.certFileInput) {
                                                this.$refs.certFileInput.value = '';
                                            }
                                        }
                                    }"
                                >
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                        File Sertifikat
                                    </label>

                                    <div class="mb-3 flex flex-wrap gap-4">
                                        <label class="flex cursor-pointer items-center gap-2">
                                            <input
                                                type="radio"
                                                name="source_type"
                                                value="upload"
                                                x-model="sourceType"
                                                {{ old('source_type', 'upload') === 'upload' ? 'checked' : '' }}
                                            >
                                            <span class="text-sm text-gray-700 dark:text-gray-300">Upload File</span>
                                        </label>

                                        <label class="flex cursor-pointer items-center gap-2">
                                            <input
                                                type="radio"
                                                name="source_type"
                                                value="link"
                                                x-model="sourceType"
                                                {{ old('source_type') === 'link' ? 'checked' : '' }}
                                            >
                                            <span class="text-sm text-gray-700 dark:text-gray-300">Gunakan Link</span>
                                        </label>
                                    </div>

                                    {{-- Input upload file --}}
                                    <div x-show="sourceType === 'upload'">
                                        <input
                                            type="file"
                                            name="file"
                                            id="file"
                                            x-ref="certFileInput"
                                            @change="handleFileChange($event)"
                                            accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx"
                                            class="block w-full rounded-lg border border-gray-300 p-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                        >

                                        <p class="mt-1 text-xs text-gray-500">
                                            Format JPG, PNG, WEBP, PDF, DOC, atau DOCX. Maksimal 10 MB.
                                        </p>

                                        {{-- PREVIEW FOTO / FILE TERPILIH --}}
                                        <div
                                            x-show="previewFile"
                                            x-cloak
                                            class="mt-4"
                                        >
                                            <div class="mb-2 flex items-center justify-between">
                                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                                    Preview Foto Terpilih
                                                </p>
                                                <span class="text-xs text-gray-500">1 file dipilih</span>
                                            </div>

                                            <div class="flex gap-3 overflow-x-auto pb-2">
                                                <div class="relative w-36 shrink-0 overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                                    <template x-if="previewFile?.isImage">
                                                        <img
                                                            :src="previewFile.url"
                                                            :alt="previewFile.name"
                                                            class="h-28 w-full object-cover"
                                                        >
                                                    </template>

                                                    <template x-if="previewFile && !previewFile.isImage">
                                                        <div class="flex h-28 w-full flex-col items-center justify-center gap-1 bg-slate-50 p-2 text-slate-500 dark:bg-gray-700 dark:text-gray-300">
                                                            <svg class="h-9 w-9 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M7 3.75h7l5 5v11.5a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-13.5a2 2 0 0 1 2-2Z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 3.75v5h5M8 14h8M8 17h5" />
                                                            </svg>
                                                            <span class="text-[10px] font-semibold uppercase">Dokumen</span>
                                                        </div>
                                                    </template>

                                                    {{-- TOMBOL HAPUS PREVIEW --}}
                                                    <button
                                                        type="button"
                                                        @click="removeSelectedFile()"
                                                        class="absolute right-2 top-2 flex h-7 w-7 items-center justify-center rounded-full bg-red-600 text-lg font-bold text-white shadow transition hover:bg-red-700"
                                                        title="Hapus file"
                                                        aria-label="Hapus file"
                                                    >
                                                        &times;
                                                    </button>

                                                    <div class="p-2">
                                                        <p
                                                            x-text="previewFile?.name"
                                                            class="truncate text-xs text-gray-600 dark:text-gray-300"
                                                            :title="previewFile?.name"
                                                        ></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @error('file')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Input link sertifikat --}}
                                    <div x-show="sourceType === 'link'" x-cloak>
                                        <input
                                            type="url"
                                            name="external_url"
                                            id="external_url"
                                            value="{{ old('external_url') }}"
                                            placeholder="https://contoh.com/sertifikat.pdf"
                                            class="block w-full rounded-lg border border-gray-300 p-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                        >

                                        <p class="mt-1 text-xs text-gray-500">
                                            Masukkan URL langsung menuju file sertifikat.
                                        </p>

                                        @error('external_url')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    @error('source_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="certificate_description" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                        Keterangan (opsional)
                                    </label>

                                    <textarea
                                        id="certificate_description"
                                        name="description"
                                        rows="3"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                        placeholder="Keterangan singkat sertifikat"
                                    >{{ old('description') }}</textarea>

                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                        <input
                                            type="checkbox"
                                            name="is_active"
                                            value="1"
                                            @checked(old('is_active', '1') == '1')
                                            class="rounded border-gray-300"
                                        >
                                        Tampilkan di halaman publik
                                    </label>
                                </div>

                                <button
                                    type="submit"
                                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                                >
                                    Upload Sertifikat
                                </button>
                            </form>


                            {{-- RIWAYAT SERTIFIKAT --}}
                            <div
                                class="mt-7"
                                x-data="{ sertifikatTerbuka: true }"
                            >
                                <div class="mb-3 flex items-center justify-between">
                                    <h3 class="font-semibold text-gray-800 dark:text-white">
                                        Riwayat Sertifikat
                                    </h3>

                                    <span class="text-sm text-gray-500">
                                        {{ $page->accreditationCertificates->count() }} sertifikat
                                    </span>
                                </div>

                                <div class="space-y-3">
                                    <section class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                                        {{-- JUDUL KATEGORI / PEMBUNGKUS --}}
                                        <button
                                            type="button"
                                            @click="sertifikatTerbuka = !sertifikatTerbuka"
                                            class="flex w-full items-center justify-between gap-3 px-4 py-3 text-left transition hover:bg-gray-50 dark:hover:bg-gray-800"
                                        >
                                            <span class="text-sm font-semibold text-gray-800 dark:text-white">
                                                Daftar Sertifikat Akreditasi
                                            </span>

                                            <span class="flex shrink-0 items-center gap-3">
                                                <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs text-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                                    {{ $page->accreditationCertificates->count() }}
                                                </span>

                                                <svg
                                                    class="h-4 w-4 text-gray-500 transition-transform"
                                                    :class="sertifikatTerbuka ? 'rotate-180' : ''"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.22 7.22a.75.75 0 011.06 0L10 10.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 8.28a.75.75 0 010-1.06z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </span>
                                        </button>

                                        {{-- ISI RIWAYAT SERTIFIKAT --}}
                                        <div
                                            x-cloak
                                            x-show="sertifikatTerbuka"
                                            x-transition
                                            class="border-t border-gray-200 p-3 dark:border-gray-700"
                                        >
                                            <div class="max-h-[340px] space-y-3 overflow-y-auto pr-1">

                                                @forelse (
                                                    $page->accreditationCertificates->sortByDesc('created_at')
                                                    as $certificate
                                                )
                                                    @php
                                                        $certUrl = $certificate->external_url ?: ($certificate->file_path ? asset('storage/' . $certificate->file_path) : '');
                                                        $isImageCert = $certificate->file_path && preg_match('/\.(jpg|jpeg|png|webp)$/i', $certificate->file_path);
                                                        $initialSourceType = $certificate->external_url ? 'link' : 'upload';
                                                    @endphp

                                                    <section
                                                        x-data="{
                                                            openEdit: false,
                                                            sourceType: {{ Js::from($initialSourceType) }},
                                                            existingUrl: {{ Js::from($certUrl) }},
                                                            existingName: {{ Js::from($certificate->file_path ? basename($certificate->file_path) : ($certificate->external_url ?? '')) }},
                                                            existingIsImage: {{ Js::from((bool) $isImageCert) }},
                                                            newPreview: null,
                                                            handleEditFile(event) {
                                                                const file = event.target.files?.[0];
                                                                if (this.newPreview?.url) {
                                                                    URL.revokeObjectURL(this.newPreview.url);
                                                                }
                                                                if (!file) {
                                                                    this.newPreview = null;
                                                                    return;
                                                                }
                                                                const isImg = file.type.startsWith('image/') || /\.(jpg|jpeg|png|webp)$/i.test(file.name);
                                                                this.newPreview = {
                                                                    name: file.name,
                                                                    isImage: isImg,
                                                                    url: isImg ? URL.createObjectURL(file) : null
                                                                };
                                                            },
                                                            clearNewFile() {
                                                                if (this.newPreview?.url) {
                                                                    URL.revokeObjectURL(this.newPreview.url);
                                                                }
                                                                this.newPreview = null;
                                                                if (this.$refs.editFileInput) {
                                                                    this.$refs.editFileInput.value = '';
                                                                }
                                                            }
                                                        }"
                                                        class="rounded-lg border border-gray-200 p-3 dark:border-gray-700"
                                                    >
                                                        <div class="flex flex-col gap-3 sm:flex-row">

                                                            {{-- THUMBNAIL SERTIFIKAT --}}
                                                            @if ($isImageCert)
                                                                <img
                                                                    src="{{ $certUrl }}"
                                                                    alt="{{ $certificate->title }}"
                                                                    class="h-28 w-full shrink-0 rounded-lg object-cover sm:w-36"
                                                                >
                                                            @else
                                                                <div class="flex h-28 w-full shrink-0 flex-col items-center justify-center gap-1 rounded-lg bg-gray-100 text-xs text-gray-500 sm:w-36 dark:bg-gray-800">
                                                                    <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M7 3.75h7l5 5v11.5a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-13.5a2 2 0 0 1 2-2Z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 3.75v5h5M8 14h8M8 17h5" />
                                                                    </svg>
                                                                    <span>Dokumen / Link</span>
                                                                </div>
                                                            @endif

                                                            {{-- Informasi sertifikat --}}
                                                            <div class="flex min-w-0 flex-1 items-start justify-between gap-3">
                                                                <div class="min-w-0 flex-1">
                                                                    <div class="flex flex-wrap items-center gap-2">
                                                                        <h4 class="break-words text-sm font-semibold text-gray-800 dark:text-white">
                                                                            {{ $certificate->title }}
                                                                        </h4>

                                                                        <span class="rounded-full px-2.5 py-0.5 text-xs
                                                                            {{ $certificate->is_active
                                                                                ? 'bg-green-100 text-green-700'
                                                                                : 'bg-gray-100 text-gray-600' }}">
                                                                            {{ $certificate->is_active ? 'Aktif' : 'Nonaktif' }}
                                                                        </span>
                                                                    </div>

                                                                    <p class="mt-1 text-xs text-gray-500">
                                                                        Diunggah:
                                                                        {{ $certificate->created_at->format('d/m/Y H:i') }}

                                                                        @if ($certificate->certificate_date)
                                                                            <span class="mx-1">•</span>
                                                                            Tanggal sertifikat:
                                                                            {{ $certificate->certificate_date->format('d/m/Y') }}
                                                                        @endif
                                                                    </p>

                                                                    @if ($certificate->description)
                                                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                                                            {{ $certificate->description }}
                                                                        </p>
                                                                    @endif
                                                                </div>

                                                                <div class="flex shrink-0 items-center gap-2">
                                                                    <button
                                                                        type="button"
                                                                        @click="openEdit = true"
                                                                        class="rounded-lg border border-blue-200 px-3 py-1.5 text-xs font-medium text-blue-600 transition hover:bg-blue-50"
                                                                    >
                                                                        Edit
                                                                    </button>

                                                                    <form
                                                                        action="{{ route('admin.pages.accreditation-certificates.destroy', [$page, $certificate]) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Yakin ingin menghapus sertifikat ini?')"
                                                                    >
                                                                        @csrf
                                                                        @method('DELETE')

                                                                        <button
                                                                            type="submit"
                                                                            class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50"
                                                                        >
                                                                            Hapus
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- POPUP EDIT SERTIFIKAT --}}
                                                        <div
                                                            x-cloak
                                                            x-show="openEdit"
                                                            x-transition.opacity
                                                            @keydown.escape.window="openEdit = false"
                                                            @click.self="openEdit = false"
                                                            class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-black/50 p-4"
                                                        >
                                                            <div
                                                                x-show="openEdit"
                                                                x-transition
                                                                class="relative my-auto flex max-h-[90vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl dark:bg-gray-900"
                                                                role="dialog"
                                                                aria-modal="true"
                                                                aria-label="Edit sertifikat akreditasi"
                                                                @click.stop
                                                            >
                                                                {{-- HEADER POPUP --}}
                                                                <div class="flex shrink-0 items-center justify-between gap-3 border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                                                                    <div>
                                                                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                            Edit Sertifikat Akreditasi
                                                                        </h2>
                                                                        <p class="mt-1 text-sm text-gray-500">
                                                                            Perbarui informasi dan file sertifikat akreditasi.
                                                                        </p>
                                                                    </div>

                                                                    <button
                                                                        type="button"
                                                                        @click="openEdit = false"
                                                                        class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800"
                                                                        aria-label="Tutup popup"
                                                                    >
                                                                        <span class="text-xl">&times;</span>
                                                                    </button>
                                                                </div>

                                                                {{-- FORM EDIT SERTIFIKAT --}}
                                                                <form
                                                                    action="{{ route('admin.pages.accreditation-certificates.update', [$page, $certificate]) }}"
                                                                    method="POST"
                                                                    enctype="multipart/form-data"
                                                                    class="min-h-0 flex-1 space-y-5 overflow-y-auto p-5"
                                                                >
                                                                    @csrf
                                                                    @method('PUT')

                                                                    {{-- PREVIEW SERTIFIKAT UTAMA --}}
                                                                    <div>
                                                                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                                            Preview Sertifikat
                                                                        </label>

                                                                        <div class="relative flex h-52 items-center justify-center overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800">
                                                                            <template x-if="newPreview ? newPreview.isImage : existingIsImage">
                                                                                <img
                                                                                    :src="newPreview ? newPreview.url : existingUrl"
                                                                                    alt="Preview sertifikat"
                                                                                    class="h-full w-full object-contain"
                                                                                >
                                                                            </template>

                                                                            <template x-if="!(newPreview ? newPreview.isImage : existingIsImage)">
                                                                                <div class="flex flex-col items-center justify-center gap-2 p-4 text-center">
                                                                                    <svg class="h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M7 3.75h7l5 5v11.5a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-13.5a2 2 0 0 1 2-2Z" />
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 3.75v5h5M8 14h8M8 17h5" />
                                                                                    </svg>
                                                                                    <p class="max-w-md break-all text-xs font-medium text-gray-600 dark:text-gray-300" x-text="newPreview ? newPreview.name : (existingName || 'Belum ada file')"></p>
                                                                                </div>
                                                                            </template>
                                                                        </div>
                                                                    </div>

                                                                    {{-- NAMA SERTIFIKAT --}}
                                                                    <div>
                                                                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                                            Nama Sertifikat *
                                                                        </label>
                                                                        <input
                                                                            type="text"
                                                                            name="title"
                                                                            value="{{ $certificate->title }}"
                                                                            required
                                                                            maxlength="255"
                                                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                        >
                                                                    </div>

                                                                    {{-- PILIHAN SUMBER FILE --}}
                                                                    <div>
                                                                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                                            File Sertifikat
                                                                        </label>

                                                                        <div class="mb-3 flex flex-wrap gap-4">
                                                                            <label class="flex cursor-pointer items-center gap-2">
                                                                                <input
                                                                                    type="radio"
                                                                                    name="source_type"
                                                                                    value="upload"
                                                                                    x-model="sourceType"
                                                                                >
                                                                                <span class="text-sm text-gray-700 dark:text-gray-300">Upload File</span>
                                                                            </label>

                                                                            <label class="flex cursor-pointer items-center gap-2">
                                                                                <input
                                                                                    type="radio"
                                                                                    name="source_type"
                                                                                    value="link"
                                                                                    x-model="sourceType"
                                                                                >
                                                                                <span class="text-sm text-gray-700 dark:text-gray-300">Gunakan Link</span>
                                                                            </label>
                                                                        </div>

                                                                        {{-- UPLOAD FILE BARU --}}
                                                                        <div x-show="sourceType === 'upload'">
                                                                            <input
                                                                                type="file"
                                                                                name="file"
                                                                                x-ref="editFileInput"
                                                                                @change="handleEditFile($event)"
                                                                                accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx"
                                                                                class="block w-full rounded-lg border border-gray-300 p-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                            >

                                                                            <p class="mt-1 text-xs text-gray-500">
                                                                                Kosongkan jika tidak ingin mengganti file. Format JPG, PNG, WEBP, PDF, DOC, atau DOCX. Maksimal 10 MB.
                                                                            </p>

                                                                            {{-- PREVIEW FILE BARU TERPILIH --}}
                                                                            <div
                                                                                x-show="newPreview"
                                                                                x-cloak
                                                                                class="mt-3"
                                                                            >
                                                                                <p class="mb-2 text-xs font-semibold text-gray-700 dark:text-gray-200">
                                                                                    File Baru Terpilih:
                                                                                </p>
                                                                                <div class="relative w-36 overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                                                                    <template x-if="newPreview?.isImage">
                                                                                        <img
                                                                                            :src="newPreview.url"
                                                                                            :alt="newPreview.name"
                                                                                            class="h-28 w-full object-cover"
                                                                                        >
                                                                                    </template>
                                                                                    <template x-if="newPreview && !newPreview.isImage">
                                                                                        <div class="flex h-28 w-full flex-col items-center justify-center gap-1 bg-slate-50 p-2 text-slate-500 dark:bg-gray-700 dark:text-gray-300">
                                                                                            <svg class="h-9 w-9 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M7 3.75h7l5 5v11.5a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-13.5a2 2 0 0 1 2-2Z" />
                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M14 3.75v5h5M8 14h8M8 17h5" />
                                                                                            </svg>
                                                                                            <span class="text-[10px] font-semibold uppercase">Dokumen</span>
                                                                                        </div>
                                                                                    </template>

                                                                                    <button
                                                                                        type="button"
                                                                                        @click="clearNewFile()"
                                                                                        class="absolute right-2 top-2 flex h-7 w-7 items-center justify-center rounded-full bg-red-600 text-lg font-bold text-white shadow transition hover:bg-red-700"
                                                                                        title="Batalkan file baru"
                                                                                        aria-label="Batalkan file baru"
                                                                                    >
                                                                                        &times;
                                                                                    </button>

                                                                                    <div class="p-2">
                                                                                        <p
                                                                                            x-text="newPreview?.name"
                                                                                            class="truncate text-xs text-gray-600 dark:text-gray-300"
                                                                                            :title="newPreview?.name"
                                                                                        ></p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        {{-- GUNAKAN LINK --}}
                                                                        <div x-show="sourceType === 'link'" x-cloak>
                                                                            <input
                                                                                type="url"
                                                                                name="external_url"
                                                                                value="{{ $certificate->external_url }}"
                                                                                placeholder="https://contoh.com/sertifikat.pdf"
                                                                                class="block w-full rounded-lg border border-gray-300 p-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                            >
                                                                            <p class="mt-1 text-xs text-gray-500">
                                                                                Masukkan URL langsung menuju file sertifikat.
                                                                            </p>
                                                                        </div>
                                                                    </div>

                                                                    {{-- KETERANGAN --}}
                                                                    <div>
                                                                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                                            Keterangan (opsional)
                                                                        </label>
                                                                        <textarea
                                                                            name="description"
                                                                            rows="3"
                                                                            maxlength="1000"
                                                                            placeholder="Keterangan singkat sertifikat"
                                                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                        >{{ $certificate->description }}</textarea>
                                                                    </div>

                                                                    {{-- STATUS --}}
                                                                    <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                                                        <input
                                                                            type="checkbox"
                                                                            name="is_active"
                                                                            value="1"
                                                                            @checked($certificate->is_active)
                                                                            class="rounded"
                                                                        >
                                                                        Tampilkan di halaman publik
                                                                    </label>

                                                                    {{-- FOOTER POPUP --}}
                                                                    <div class="flex flex-wrap justify-end gap-2 border-t border-gray-200 pt-4 dark:border-gray-700">
                                                                        <button
                                                                            type="button"
                                                                            @click="openEdit = false"
                                                                            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800"
                                                                        >
                                                                            Batal
                                                                        </button>

                                                                        <button
                                                                            type="submit"
                                                                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                                                                        >
                                                                            Simpan Perubahan
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </section>
                                                @empty
                                                    <p class="rounded-lg bg-gray-50 p-4 text-sm text-gray-500 dark:bg-gray-800">
                                                        Belum ada sertifikat yang diunggah.
                                                    </p>
                                                @endforelse

                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>

                        </div>
                    @endif
                    
                    {{-- KELOLA KONTEN PENDIDIKAN & PELATIHAN (TAB SWITCHER) --}}
                    @if ($page->slug === 'pendidikan-pelatihan')
                        <div
                            x-data="{
                                activeTab: '{{ $isEditingDiklat ? 'program' : (request('tab') === 'guidelines' ? 'guidelines' : 'program') }}'
                            }"
                            class="mt-8 border-t border-gray-200 pt-6"
                        >
                            {{-- DUA TOMBOL BESAR KANAN KIRI --}}
                            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                {{-- TOMBOL KIRI: PROGRAM DIKLAT --}}
                                <button
                                    type="button"
                                    @click="activeTab = 'program'"
                                    class="group relative flex flex-col justify-between rounded-2xl border-2 p-5 text-left transition-all duration-200 focus:outline-none"
                                    :class="activeTab === 'program'
                                        ? 'border-blue-600 bg-blue-50/70 shadow-md ring-2 ring-blue-600/20 dark:border-blue-500 dark:bg-blue-950/40'
                                        : 'border-gray-200 bg-white hover:border-gray-300 hover:bg-gray-50/80 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-750'"
                                >
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl transition"
                                                :class="activeTab === 'program'
                                                    ? 'bg-blue-600 text-white shadow-sm'
                                                    : 'bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300'"
                                            >
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3
                                                    class="text-base font-bold transition"
                                                    :class="activeTab === 'program' ? 'text-blue-950 dark:text-blue-100' : 'text-gray-900 dark:text-white'"
                                                >
                                                    Kelola Program Diklat
                                                </h3>
                                                <span
                                                    class="mt-0.5 inline-block rounded-full px-2.5 py-0.5 text-xs font-semibold"
                                                    :class="activeTab === 'program'
                                                        ? 'bg-blue-600 text-white'
                                                        : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'"
                                                >
                                                    {{ $diklatPrograms->count() }} Program Tersimpan
                                                </span>
                                            </div>
                                        </div>

                                        {{-- INDICATOR AKTIF --}}
                                        <span
                                            x-show="activeTab === 'program'"
                                            class="inline-flex items-center gap-1 rounded-full bg-blue-600 px-2.5 py-1 text-[11px] font-bold text-white shadow-sm"
                                        >
                                            <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                                            Aktif
                                        </span>
                                    </div>

                                    <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                        Kelola program pendidikan/pelatihan, kuota pendaftaran, biaya, dan riwayat program.
                                    </p>
                                </button>

                                {{-- TOMBOL KANAN: UNDUH BERKAS & PEDOMAN --}}
                                <button
                                    type="button"
                                    @click="activeTab = 'guidelines'"
                                    class="group relative flex flex-col justify-between rounded-2xl border-2 p-5 text-left transition-all duration-200 focus:outline-none"
                                    :class="activeTab === 'guidelines'
                                        ? 'border-blue-600 bg-blue-50/70 shadow-md ring-2 ring-blue-600/20 dark:border-blue-500 dark:bg-blue-950/40'
                                        : 'border-gray-200 bg-white hover:border-gray-300 hover:bg-gray-50/80 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-750'"
                                >
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl transition"
                                                :class="activeTab === 'guidelines'
                                                    ? 'bg-blue-600 text-white shadow-sm'
                                                    : 'bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300'"
                                            >
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3
                                                    class="text-base font-bold transition"
                                                    :class="activeTab === 'guidelines' ? 'text-blue-950 dark:text-blue-100' : 'text-gray-900 dark:text-white'"
                                                >
                                                    Unduh Berkas &amp; Pedoman Diklat
                                                </h3>
                                                <span
                                                    class="mt-0.5 inline-block rounded-full px-2.5 py-0.5 text-xs font-semibold"
                                                    :class="activeTab === 'guidelines'
                                                        ? 'bg-blue-600 text-white'
                                                        : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'"
                                                >
                                                    {{ $page->diklatGuidelines->count() }} Dokumen Tersimpan
                                                </span>
                                            </div>
                                        </div>

                                        {{-- INDICATOR AKTIF --}}
                                        <span
                                            x-show="activeTab === 'guidelines'"
                                            class="inline-flex items-center gap-1 rounded-full bg-blue-600 px-2.5 py-1 text-[11px] font-bold text-white shadow-sm"
                                        >
                                            <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                                            Aktif
                                        </span>
                                    </div>

                                    <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                        Kelola dokumen panduan, formulir permohonan praktik, dan kalender diklat.
                                    </p>
                                </button>
                            </div>

                            {{-- KONTEN BAGIAN 1: PROGRAM DIKLAT --}}
                            <div x-show="activeTab === 'program'" x-transition:enter.duration.200ms>
                                <section
                                    id="diklat-program"
                                    x-data="diklatProgramManager(
                                        @js(route('admin.pages.diklat-programs.store', ['page' => $page->id])),
                                        @js(route('admin.pages.diklat-programs.update', [
                                            'page' => $page->id,
                                            'program' => '__PROGRAM_ID__'
                                        ])),
                                        @js($diklatPrograms->keyBy('id')->values())
                                    )"
                                >
                            {{-- HEADER --}}
                            <div class="mb-4">
                                <h2 class="text-lg font-semibold text-[#172033] dark:text-white">
                                    Kelola Program Diklat
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan dan kelola informasi program pendidikan maupun pelatihan.
                                </p>
                            </div>

                            {{-- FORM TAMBAH / EDIT PROGRAM DIKLAT (SISTEM TAB MODERN) --}}
                            <form
                                x-data="{
                                    activeTab: 1,
                                    isEditing: @js((bool)$isEditingDiklat),
                                    category: @js(old('category', $diklatForm->category ?? 'Pendidikan')),
                                    method: @js(old('method', $diklatForm->method ?? 'Luring')),
                                    location: @js(old('location', $diklatForm->location ?? 'RSUD R.A.A. Tjokronegoro')),
                                    isPaid: @js((string) (int) old('is_paid', $diklatForm?->is_paid ?? 0)),
                                    requiresRegistration: @js((string) old('requires_registration', $diklatForm?->requires_registration ?? 1)),
                                    quotaVal: {{ (int) old('quota', $diklatForm->quota ?? 0) }},
                                    dateMode: @js(
                                        old('date_mode')
                                            ? old('date_mode')
                                            : (isset($diklatForm?->start_at, $diklatForm?->end_at) && \Carbon\Carbon::parse($diklatForm->start_at)->isSameDay(\Carbon\Carbon::parse($diklatForm->end_at))
                                                ? 'single'
                                                : 'range')
                                    ),
                                    
                                    // Validasi & Navigasi Langkah Wizard
                                    canProceed(fromTab) {
                                        if (fromTab === 1) {
                                            const nameInput = document.getElementById('program_name');
                                            if (nameInput && !nameInput.value.trim()) {
                                                nameInput.focus();
                                                nameInput.reportValidity();
                                                return false;
                                            }
                                        }
                                        if (fromTab === 2) {
                                            if (this.category === 'Pelatihan' && this.requiresRegistration === '1') {
                                                const quotaInput = this.$el.querySelector('input[name=\'quota\']');
                                                if (quotaInput && (!quotaInput.value || parseInt(quotaInput.value) <= 0)) {
                                                    quotaInput.focus();
                                                    quotaInput.reportValidity();
                                                    return false;
                                                }
                                            }
                                            if (this.isPaid === '1') {
                                                const feeInput = this.$el.querySelector('input[name=\'fee\']');
                                                if (feeInput && !feeInput.value.trim()) {
                                                    feeInput.focus();
                                                    feeInput.reportValidity();
                                                    return false;
                                                }
                                            }
                                        }
                                        return true;
                                    },
                                    goToTab(targetTab) {
                                        if (targetTab === this.activeTab) return;
                                        if (this.isEditing || targetTab < this.activeTab) {
                                            this.activeTab = targetTab;
                                            this.$nextTick(() => { window.initIndonesianDatePickers && window.initIndonesianDatePickers(document.body); });
                                            return;
                                        }
                                        if (this.activeTab === 1 && !this.canProceed(1)) return;
                                        if (targetTab > 2 && !this.canProceed(2)) {
                                            this.activeTab = 2;
                                            this.$nextTick(() => { window.initIndonesianDatePickers && window.initIndonesianDatePickers(document.body); });
                                            return;
                                        }
                                        this.activeTab = targetTab;
                                        this.$nextTick(() => { window.initIndonesianDatePickers && window.initIndonesianDatePickers(document.body); });
                                    },
                                    nextTab() {
                                        if (this.canProceed(this.activeTab)) {
                                            if (this.activeTab < 3) {
                                                this.activeTab++;
                                            }
                                        }
                                    },
                                    prevTab() {
                                        if (this.activeTab > 1) {
                                            this.activeTab--;
                                        }
                                    },
                                    
                                    // Detail konten 01 s/d 05
                                    targetDescriptionVal: @js(old('target_description', $diklatForm->target_description ?? ($diklatForm->target ?? ''))),
                                    descriptionVal: @js(old('description', $diklatForm->description ?? '')),
                                    objectivesVal: @js(old('objectives', $diklatForm->objectives ?? '')),
                                    materialsVal: @js(old('materials', $diklatForm->materials ?? '')),
                                    requirementsVal: @js(old('requirements', $diklatForm->requirements ?? '')),
                                    facilitiesVal: @js(old('facilities', $diklatForm->facilities ?? '')),

                                    // Upload Card Image
                                    imagePreview: @js($diklatForm?->image ? asset('storage/' . $diklatForm->image) : null),
                                    deleteImage: false,
                                    handleFileChange(event) {
                                        const file = event.target.files?.[0];
                                        if (file) {
                                            if (file.size > 5 * 1024 * 1024) {
                                                alert('Ukuran gambar kartu terlalu besar (' + (file.size / (1024 * 1024)).toFixed(1) + ' MB). Maksimal ukuran file adalah 5 MB.');
                                                event.target.value = '';
                                                this.removeImage();
                                                return;
                                            }
                                            this.imagePreview = URL.createObjectURL(file);
                                            this.deleteImage = false;
                                        }
                                    },
                                    removeImage() {
                                        this.imagePreview = null;
                                        this.deleteImage = true;
                                        if (this.$refs.fileInput) {
                                            this.$refs.fileInput.value = '';
                                        }
                                    },

                                    // Upload Brosur
                                    @php
                                        $formFlyer = $diklatForm?->flyer_image;
                                        $isFormFlyerPdf = $formFlyer && str_ends_with(strtolower($formFlyer), '.pdf');
                                    @endphp
                                    flyerName: @js($formFlyer ? basename($formFlyer) : null),
                                    isFlyerPdf: @js($isFormFlyerPdf),
                                    flyerPreview: @js($formFlyer && !$isFormFlyerPdf ? asset('storage/' . $formFlyer) : null),
                                    deleteFlyer: false,
                                    handleFlyerChange(event) {
                                        const file = event.target.files?.[0];
                                        if (file) {
                                            if (file.size > 5 * 1024 * 1024) {
                                                alert('Ukuran berkas brosur/flyer terlalu besar (' + (file.size / (1024 * 1024)).toFixed(1) + ' MB). Maksimal ukuran berkas adalah 5 MB.');
                                                event.target.value = '';
                                                this.removeFlyer();
                                                return;
                                            }
                                            this.flyerName = file.name;
                                            this.isFlyerPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');
                                            if (!this.isFlyerPdf && file.type.startsWith('image/')) {
                                                this.flyerPreview = URL.createObjectURL(file);
                                            } else {
                                                this.flyerPreview = null;
                                            }
                                            this.deleteFlyer = false;
                                        }
                                    },
                                    removeFlyer() {
                                        this.flyerPreview = null;
                                        this.flyerName = null;
                                        this.isFlyerPdf = false;
                                        this.deleteFlyer = true;
                                        if (this.$refs.flyerFileInput) {
                                            this.$refs.flyerFileInput.value = '';
                                        }
                                    },

                                    // Helper Template Default Standar RSUD
                                    fillDefault(field) {
                                        const isEdu = this.category === 'Pendidikan';
                                        if (field === 'description') {
                                            this.descriptionVal = isEdu 
                                                ? 'Program pendidikan dan praktik kerja lapangan/klinis di RSUD R.A.A. Tjokronegoro Purworejo diselenggarakan bagi mahasiswa institusi pendidikan mitra. Mahasiswa akan mendapatkan pengalaman pembelajaran klinis secara langsung dan komprehensif, dibimbing oleh Clinical Instructor (CI) profesional guna mengasah keterampilan teknis, etika profesi, serta kepatuhan pada standar patient safety.'
                                                : 'Program pelatihan ini diselenggarakan oleh Instalasi Pendidikan dan Pelatihan RSUD R.A.A. Tjokronegoro Purworejo untuk memberikan penguatan kompetensi, wawasan teoritis, serta keterampilan klinis terapan yang esensial. Seluruh materi disusun secara komprehensif berstandar Kementerian Kesehatan Republik Indonesia guna menunjang profesionalisme tenaga kesehatan dalam memberikan pelayanan bermutu dan berorientasi pada keselamatan pasien (patient safety).';
                                        } else if (field === 'objectives') {
                                            this.objectivesVal = isEdu
                                                ? 'Memberikan pengalaman praktik klinis langsung dan terstruktur di lingkungan rumah sakit terakreditasi paripurna.\nMengaplikasikan ilmu teori akademik dan keterampilan teknis asuhan medis, keperawatan, kebidanan, atau kefarmasian sesuai standar operasional prosedur (SOP).\nMembangun etika profesionalisme, komunikasi terapeutik, dan kepatuhan tinggi terhadap keselamatan pasien (patient safety).\nMemenuhi target pencapaian kompetensi dan logbook stase klinis yang ditetapkan institusi pendidikan mitra.'
                                                : 'Meningkatkan kompetensi, pengetahuan, dan keterampilan teknis peserta sesuai dengan standar pelayanan terkini.\nMemahami regulasi, kebijakan Kementerian Kesehatan RI, serta prosedur keselamatan kerja dan keselamatan pasien (patient safety).\nMampu mengaplikasikan protokol klinis, teknis aseptis, dan penanganan kasus secara profesional di fasilitas pelayanan kesehatan masing-masing.\nMenjamin tersedianya tenaga kesehatan yang terampil, tersertifikasi, dan siap memenuhi standar akreditasi rumah sakit.';
                                        } else if (field === 'materials') {
                                            this.materialsVal = isEdu
                                                ? 'Orientasi Rumah Sakit: Pencegahan & Pengendalian Infeksi (PPI), K3RS, Keselamatan Pasien, dan Bantuan Hidup Dasar (BHD)\nRotasi Stase Klinis: Rawat Inap, Rawat Jalan, Instalasi Gawat Darurat (IGD), dan Unit Perawatan Khusus\nBimbingan Kasus, Bedside Teaching, dan Ronde Klinis bersama Clinical Instructor (CI) / Dokter Pendidik Klinis (DPK)\nPengenalan Dokumentasi Rekam Medis Elektronik (RME) Rumah Sakit\nEvaluasi Akhir Stase, Ujian Keterampilan Klinis (DOPS/Mini-CEX), dan Presentasi Refleksi Kasus'
                                                : 'Kebijakan dan Regulasi Kementerian Kesehatan RI Terkait Layanan\nKonsep Dasar, Aspek Farmakologi / Klinis & Prosedur Operasional Standar (SOP)\nPrinsip Keselamatan Kerja, Manajemen Risiko, dan Penjaminan Mutu\nPraktik Hands-On, Studi Kasus, dan Simulasi Prosedural di Lingkungan Rumah Sakit\nEvaluasi Kompetensi, Ujian Pre-test & Post-test';
                                        } else if (field === 'requirements') {
                                            const targetText = (this.targetDescriptionVal && this.targetDescriptionVal.trim())
                                                ? this.targetDescriptionVal.trim()
                                                : (isEdu ? 'Siswa SMA/SMK dan mahasiswa hingga jenjang S1 dari berbagai bidang institusi mitra.' : 'Tenaga Medis, Apoteker, Perawat, atau Tenaga Kesehatan Terkait');

                                            this.requirementsVal = isEdu
                                                ? ('Sasaran: ' + targetText + '\nMahasiswa aktif dari institusi pendidikan yang telah memiliki Perjanjian Kerjasama (MoU) aktif dengan RSUD\nMelampirkan Surat Permohonan / Rekomendasi Resmi dari Dekan / Pimpinan Institusi Pendidikan asal\nMelampirkan daftar nama calon mahasiswa peserta stase beserta NIM dan Program Studi\nPas foto formal terbaru berlatar belakang warna dengan seragam almamater resmi')
                                                : ('Sasaran: ' + targetText + '\nMembawa/mengunggah Surat Tugas atau Rekomendasi dari Pimpinan Instansi / Rumah Sakit asal (Opsional jika mandiri)');
                                        } else if (field === 'facilities') {
                                            this.facilitiesVal = isEdu
                                                ? 'Pembimbingan intensif oleh Clinical Instructor (CI) dan Dokter Pendidik Klinis (DPK) tersertifikasi\nAkses ruang diskusi, perpustakaan, dan fasilitas penunjang pembelajaran di Instalasi Diklat\nPembekalan orientasi keselamatan kerja dan perlindungan K3RS selama stase klinis\nVerifikasi logbook kompetensi dan Surat Keterangan / Sertifikat Selesai Praktik Resmi dari RSUD'
                                                : 'Sertifikat Resmi Kementerian Kesehatan RI dengan Satuan Kredit Profesi (SKP)\nModul & Bahan Ajar Lengkap (Hardcopy / Softcopy) serta Seminar Kit Eksklusif\nFasilitas Praktik Klinis / Hands-on Laboratorium di RSUD R.A.A. Tjokronegoro\nKonsumsi (Snack dan Makan Siang) selama masa pelatihan tatap muka\nBimbingan interaktif langsung oleh Fasilitator Ahli dan Dokter Spesialis';
                                        }
                                    }
                                }"
                                action="{{ $isEditingDiklat
                                    ? route('admin.pages.diklat-programs.update', ['page' => $page->id, 'program' => $diklatForm->id])
                                    : route('admin.pages.diklat-programs.store', ['page' => $page->id]) }}"
                                method="POST"
                                enctype="multipart/form-data"
                                id="diklat-program-form"
                                @keydown.enter="if (!isEditing && activeTab < 3 && $event.target.tagName !== 'TEXTAREA') { $event.preventDefault(); nextTab(); }"
                                class="space-y-6 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-xs"
                            >
                                @csrf

                                @if ($isEditingDiklat)
                                    @method('PUT')
                                @endif

                                {{-- HEADER & JUDUL FORM --}}
                                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 pb-4">
                                    <div>
                                        <h3 class="text-base font-bold text-slate-900">
                                            {{ $isEditingDiklat ? 'Edit Program Diklat' : 'Tambah Program Diklat' }}
                                        </h3>
                                        <p class="mt-0.5 text-xs text-slate-500">
                                            Kelola informasi dasar, pelaksanaan, hingga rincian materi &amp; persyaratan secara terstruktur.
                                        </p>
                                    </div>

                                    @if ($isEditingDiklat)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-teal-50 px-3 py-1 text-xs font-semibold text-[#007b83] border border-teal-200">
                                            Mode Edit Program ID: #{{ $diklatForm->id }}
                                        </span>
                                    @endif
                                </div>

                                {{-- NAVIGASI TAB WIZARD --}}
                                <div class="border-b border-gray-200">
                                    <nav class="-mb-px flex space-x-1 sm:space-x-3 overflow-x-auto pb-1" aria-label="Tabs Program Diklat">
                                        <button
                                            type="button"
                                            @click="goToTab(1)"
                                            :class="activeTab === 1
                                                ? 'border-[#007b83] text-[#007b83] bg-teal-50/60 font-bold'
                                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                                            class="flex items-center gap-2 whitespace-nowrap border-b-2 px-3 py-2.5 text-xs sm:text-sm rounded-t-xl transition cursor-pointer"
                                        >
                                            <span class="flex h-5 w-5 items-center justify-center rounded-full text-xs font-bold"
                                                  :class="activeTab === 1 ? 'bg-[#007b83] text-white' : 'bg-gray-200 text-gray-700'">1</span>
                                            <span>Informasi Dasar &amp; Media</span>
                                        </button>

                                        <button
                                            type="button"
                                            @click="goToTab(2)"
                                            :class="activeTab === 2
                                                ? 'border-[#007b83] text-[#007b83] bg-teal-50/60 font-bold'
                                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                                            class="flex items-center gap-2 whitespace-nowrap border-b-2 px-3 py-2.5 text-xs sm:text-sm rounded-t-xl transition cursor-pointer"
                                        >
                                            <span class="flex h-5 w-5 items-center justify-center rounded-full text-xs font-bold"
                                                  :class="activeTab === 2 ? 'bg-[#007b83] text-white' : 'bg-gray-200 text-gray-700'">2</span>
                                            <span>Pelaksanaan &amp; Pendaftaran</span>
                                        </button>

                                        <button
                                            type="button"
                                            @click="goToTab(3)"
                                            :class="activeTab === 3
                                                ? 'border-[#007b83] text-[#007b83] bg-teal-50/60 font-bold'
                                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                                            class="flex items-center gap-2 whitespace-nowrap border-b-2 px-3 py-2.5 text-xs sm:text-sm rounded-t-xl transition cursor-pointer"
                                        >
                                            <span class="flex h-5 w-5 items-center justify-center rounded-full text-xs font-bold"
                                                  :class="activeTab === 3 ? 'bg-[#007b83] text-white' : 'bg-gray-200 text-gray-700'">3</span>
                                            <span x-text="category === 'Pendidikan' ? 'Rincian Stase &amp; Syarat (01-05)' : 'Rincian Materi &amp; Syarat (01-05)'">Rincian Materi &amp; Syarat (01-05)</span>
                                        </button>
                                    </nav>
                                </div>

                                {{-- ================================================== --}}
                                {{-- TAB 1: INFORMASI DASAR --}}
                                {{-- ================================================== --}}
                                <div x-show="activeTab === 1" class="space-y-4">
                                    <div class="rounded-xl bg-slate-50 p-3.5 border border-slate-200/80 text-xs text-slate-600">
                                        💡 <strong>Petunjuk:</strong> Pilih kategori program dan tentukan nama serta sasaran peserta yang dituju.
                                    </div>

                                    {{-- KATEGORI DAN NAMA --}}
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label for="program_category" class="mb-1 block text-sm font-semibold text-slate-700">
                                                Kategori *
                                            </label>
                                            <select
                                                id="program_category"
                                                name="category"
                                                required
                                                x-model="category"
                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                            >
                                                <option value="Pendidikan" @selected(old('category', $diklatForm->category ?? 'Pendidikan') === 'Pendidikan')>Pendidikan</option>
                                                <option value="Pelatihan" @selected(old('category', $diklatForm->category ?? '') === 'Pelatihan')>Pelatihan</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="program_name" class="mb-1 block text-sm font-semibold text-slate-700">
                                                Nama Program *
                                            </label>
                                            <input
                                                id="program_name"
                                                name="name"
                                                type="text"
                                                required
                                                maxlength="255"
                                                value="{{ old('name', $diklatForm->name ?? '') }}"
                                                placeholder="Contoh: Praktik Kerja Lapangan (PKL) dan Magang"
                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                            >
                                        </div>
                                    </div>

                                    {{-- SATU KOLOM SAJA: DESKRIPSI SASARAN --}}
                                    <div>
                                        <label for="target_description" class="mb-1 block text-sm font-semibold text-slate-700">
                                            Deskripsi Sasaran
                                        </label>
                                        <textarea
                                            id="target_description"
                                            name="target_description"
                                            x-model="targetDescriptionVal"
                                            rows="2"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                            placeholder="Contoh: Siswa SMA/SMK dan mahasiswa hingga jenjang S1 dari berbagai bidang."
                                        >{{ old('target_description', $diklatForm->target_description ?? ($diklatForm->target ?? '')) }}</textarea>
                                        <input type="hidden" name="target" :value="targetDescriptionVal">
                                        <p class="mt-1 text-xs text-slate-500">
                                            Teks sasaran ini akan ditampilkan di bawah judul program dan otomatis menjadi isi butir sasaran pada format standar persyaratan (poin 04).
                                        </p>
                                    </div>

                                    {{-- FOTO CARD & BROSUR FLYER --}}
                                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 pt-2">
                                        {{-- 1. FOTO CARD --}}
                                        <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50/70 p-4">
                                            <div class="flex items-center justify-between mb-2.5">
                                                <label class="block text-sm font-semibold text-gray-800">
                                                    Foto / Gambar Card Program
                                                </label>
                                                <span class="text-[11px] font-medium text-teal-700">Maks 1 MB &bull; Otomatis WebP</span>
                                            </div>

                                            <div class="relative mb-2.5 flex h-36 w-full items-center justify-center overflow-hidden rounded-xl border border-gray-200 bg-white">
                                                <template x-if="imagePreview">
                                                    <div class="relative h-full w-full">
                                                        <img :src="imagePreview" alt="Preview Gambar Card" class="h-full w-full object-cover">
                                                        <button
                                                            type="button"
                                                            @click="removeImage()"
                                                            class="absolute top-2 right-2 rounded-full bg-red-600/90 p-1 text-white shadow hover:bg-red-700 transition"
                                                            title="Hapus foto"
                                                        >
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </template>
                                                <template x-if="!imagePreview">
                                                    <div class="flex flex-col items-center justify-center text-center p-3 text-gray-400">
                                                        <span class="text-xs font-medium">Belum ada gambar kartu</span>
                                                        <span class="text-[10px] text-gray-400">Gunakan rasio 16:9 (JPG, PNG, WEBP)</span>
                                                    </div>
                                                </template>
                                            </div>

                                            <input type="hidden" name="delete_image" :value="deleteImage ? '1' : '0'">
                                            <input
                                                type="file"
                                                name="image"
                                                x-ref="fileInput"
                                                accept=".jpg,.jpeg,.png,.webp"
                                                @change="handleFileChange($event)"
                                                class="block w-full text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-teal-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-[#007b83] hover:file:bg-teal-100"
                                            >
                                        </div>

                                        {{-- 2. BROSUR FLYER --}}
                                        <div class="rounded-xl border border-dashed border-teal-300 bg-teal-50/40 p-4">
                                            <div class="flex items-center justify-between mb-2.5">
                                                <label class="block text-sm font-semibold text-slate-800">
                                                    Brosur / Flyer Program <span class="text-xs font-normal text-slate-500">(Opsional)</span>
                                                </label>
                                                <span class="text-[11px] font-medium text-teal-700">Maks 5 MB &bull; PDF / WebP</span>
                                            </div>

                                            <div class="relative mb-2.5 flex h-36 w-full items-center justify-center overflow-hidden rounded-xl border border-teal-200/80 bg-white p-2">
                                                <template x-if="flyerPreview && !isFlyerPdf">
                                                    <div class="relative flex h-full w-full items-center justify-center">
                                                        <img :src="flyerPreview" alt="Preview Brosur" class="h-full w-full object-contain">
                                                        <button
                                                            type="button"
                                                            @click="removeFlyer()"
                                                            class="absolute top-1 right-1 rounded-full bg-red-600/90 p-1 text-white shadow hover:bg-red-700 transition"
                                                            title="Hapus brosur"
                                                        >
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </template>

                                                <template x-if="isFlyerPdf">
                                                    <div class="flex w-full items-center justify-between gap-2 p-2 rounded-lg bg-teal-50 text-xs text-teal-900">
                                                        <div class="flex items-center gap-2 truncate">
                                                            <span class="font-bold text-teal-800">📄 PDF:</span>
                                                            <span x-text="flyerName || 'Dokumen-Brosur.pdf'" class="truncate font-medium"></span>
                                                        </div>
                                                        <button
                                                            type="button"
                                                            @click="removeFlyer()"
                                                            class="rounded bg-red-100 px-2 py-1 text-[11px] font-bold text-red-700 hover:bg-red-200"
                                                        >
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </template>

                                                <template x-if="!flyerPreview && !isFlyerPdf">
                                                    <div class="flex flex-col items-center justify-center text-center p-3 text-gray-400">
                                                        <span class="text-xs font-medium">Belum ada berkas brosur</span>
                                                        <span class="text-[10px] text-gray-400">Format: PDF, JPG, PNG (Otomatis konversi ke PDF Viewer)</span>
                                                    </div>
                                                </template>
                                            </div>

                                            <input type="hidden" name="remove_flyer_image" :value="deleteFlyer ? '1' : '0'">
                                            <input
                                                type="file"
                                                name="flyer_image"
                                                x-ref="flyerFileInput"
                                                accept=".pdf,.jpg,.jpeg,.png,.webp"
                                                @change="handleFlyerChange($event)"
                                                class="block w-full text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-teal-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-[#007b83] hover:file:bg-teal-200"
                                            >
                                        </div>
                                    </div>
                                </div>

                                {{-- ================================================== --}}
                                {{-- TAB 2: PELAKSANAAN & PESERTA --}}
                                {{-- ================================================== --}}
                                <div x-show="activeTab === 2" class="space-y-4">
                                    {{-- METODE DAN LOKASI --}}
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                Metode Pelaksanaan
                                            </label>
                                            <select
                                                name="method"
                                                x-model="method"
                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                            >
                                                <option value="">Pilih metode pelaksanaan</option>
                                                <option value="Luring">Luring (Tatap Muka)</option>
                                                <option value="Daring">Daring (Online)</option>
                                                <option value="Hybrid">Hybrid</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                Lokasi Pelaksanaan
                                            </label>
                                            <input
                                                type="text"
                                                name="location"
                                                x-model="location"
                                                maxlength="255"
                                                placeholder="Contoh: RSUD R.A.A. Tjokronegoro / Aula Gedung B"
                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                            >
                                        </div>
                                    </div>

                                    {{-- WAKTU & JADWAL KHUSUS PENDIDIKAN --}}
                                    <template x-if="category === 'Pendidikan'">
                                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 rounded-xl bg-blue-50/50 border border-blue-200/60 p-4">
                                            <div>
                                                <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                    Jadwal Pelaksanaan
                                                </label>
                                                <input
                                                    type="text"
                                                    name="schedule"
                                                    value="{{ old('schedule', $diklatForm->schedule ?? 'Sesuai pengajuan dan persetujuan rumah sakit') }}"
                                                    placeholder="Sesuai pengajuan dan persetujuan rumah sakit"
                                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm"
                                                >
                                                <span class="text-[11px] text-gray-500 mt-1 block">Tampil pada kotak meta jadwal halaman publik.</span>
                                            </div>

                                            <div>
                                                <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                    Durasi / Periode Praktik
                                                </label>
                                                <input
                                                    type="text"
                                                    name="duration"
                                                    value="{{ old('duration', $diklatForm->duration ?? 'Sesuai ketentuan program dan institusi mitra') }}"
                                                    placeholder="Sesuai ketentuan program dan institusi mitra"
                                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm"
                                                >
                                                <span class="text-[11px] text-gray-500 mt-1 block">Tampil pada kotak meta durasi halaman publik.</span>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- WAKTU & JADWAL KHUSUS PELATIHAN --}}
                                    <template x-if="category === 'Pelatihan'">
                                        <div
                                            x-init="$nextTick(() => { window.initIndonesianDatePickers && window.initIndonesianDatePickers($el); })"
                                            class="space-y-4 rounded-xl bg-amber-50/40 border border-amber-200/60 p-4"
                                        >
                                            {{-- PILIHAN MODE DURASI TANGGAL --}}
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-amber-200/70">
                                                <div>
                                                    <label class="block text-sm font-bold text-slate-800">
                                                        Durasi Waktu Pelaksanaan Pelatihan
                                                    </label>
                                                    <span class="text-[11px] text-slate-500">Pilih apakah kegiatan hanya 1 hari (misal sosialisasi) atau berdurasi beberapa hari.</span>
                                                </div>
                                                <div class="inline-flex rounded-lg bg-white p-0.5 border border-amber-300 shadow-2xs text-xs self-start sm:self-auto">
                                                    <button
                                                        type="button"
                                                        @click="dateMode = 'single'; window.setDiklatDateMode($el, 'single');"
                                                        :class="dateMode === 'single' ? 'bg-[#007b83] text-white shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                                                        class="rounded-md px-3 py-1.5 transition cursor-pointer flex items-center gap-1.5"
                                                    >
                                                        <span>🗓️ Cukup 1 Hari Saja</span>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        @click="dateMode = 'range'; window.setDiklatDateMode($el, 'range');"
                                                        :class="dateMode === 'range' ? 'bg-[#007b83] text-white shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                                                        class="rounded-md px-3 py-1.5 transition cursor-pointer flex items-center gap-1.5"
                                                    >
                                                        <span>📅 Berdurasi (Rentang Hari)</span>
                                                    </button>
                                                </div>
                                                <input type="hidden" name="date_mode" :value="dateMode">
                                            </div>

                                            <div class="grid grid-cols-1 gap-4" :class="dateMode === 'range' ? 'sm:grid-cols-2' : ''">
                                                {{-- TANGGAL PELAKSANAAN / MULAI --}}
                                                <div>
                                                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                        <span x-text="dateMode === 'single' ? 'Tanggal Pelaksanaan Pelatihan (1 Hari) *' : 'Tanggal Mulai Pelatihan *'"></span>
                                                    </label>
                                                    <input
                                                        type="date"
                                                        name="start_at"
                                                        x-ref="createStartInput"
                                                        value="{{ old('start_at', isset($diklatForm?->start_at) ? \Carbon\Carbon::parse($diklatForm->start_at)->format('Y-m-d') : '') }}"
                                                        :placeholder="dateMode === 'single' ? 'Pilih tanggal pelaksanaan' : 'Pilih tanggal mulai'"
                                                        class="datetime-picker-id w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm"
                                                        @input="window.handleDiklatDateChange($el)"
                                                        @change="window.handleDiklatDateChange($el)"
                                                    >
                                                    <p x-show="dateMode === 'single'" class="text-[11px] text-teal-700 mt-1 flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                                        Kegiatan 1 hari. Pada kartu dan halaman web otomatis tampil satu tanggal tunggal (tanpa pengulangan tanggal).
                                                    </p>
                                                </div>

                                                {{-- TANGGAL SELESAI (HANYA DITAMPILKAN JIKA BERDURASI) --}}
                                                <div x-show="dateMode === 'range'">
                                                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                        Tanggal Selesai Pelatihan *
                                                    </label>
                                                    <input
                                                        type="date"
                                                        name="end_at"
                                                        x-ref="createEndInput"
                                                        value="{{ old('end_at', isset($diklatForm?->end_at) ? \Carbon\Carbon::parse($diklatForm->end_at)->format('Y-m-d') : '') }}"
                                                        placeholder="Pilih tanggal selesai"
                                                        class="datetime-picker-id w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm"
                                                        @input="window.handleDiklatDateChange($el)"
                                                        @change="window.handleDiklatDateChange($el)"
                                                    >
                                                </div>
                                            </div>

                                            <div>
                                                <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                    Durasi / Periode Pelatihan (Opsional)
                                                </label>
                                                <input
                                                    type="text"
                                                    name="duration"
                                                    x-ref="createDurationInput"
                                                    value="{{ old('duration', $diklatForm->duration ?? '') }}"
                                                    placeholder="Contoh: 3 Hari / 24 JPL (Kosongkan jika otomatis)"
                                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm"
                                                >
                                                <span class="text-[11px] text-gray-500 mt-1 block">Tampil pada kotak meta "Durasi / Periode". Jika dikosongkan, durasi dihitung otomatis dari tanggal pelaksanaan.</span>
                                            </div>

                                            <div>
                                                <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                    Keterangan (Opsional)
                                                </label>
                                                <textarea
                                                    name="schedule"
                                                    rows="3"
                                                    placeholder="Contoh: Pukul 08.00 - 15.30 WIB, membawa laptop pribadi, atau catatan penting lainnya..."
                                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm leading-relaxed"
                                                >{{ old('schedule', $diklatForm->schedule ?? '') }}</textarea>
                                                <span class="text-[11px] text-gray-500 mt-1 block">Dapat diisi jam acara, perlengkapan yang perlu dibawa, waktu sesi, atau catatan penting lainnya bagi peserta.</span>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- PENGATURAN PESERTA & PENDAFTARAN --}}
                                    <template x-if="category === 'Pendidikan'">
                                        <div class="hidden">
                                            <input type="hidden" name="requires_registration" value="1">
                                            <input type="hidden" name="is_paid" value="0">
                                        </div>
                                    </template>

                                    <template x-if="category === 'Pelatihan'">
                                        <div class="space-y-4 pt-2">
                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                                <div>
                                                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                        Sasaran Peserta
                                                    </label>
                                                    <select
                                                        name="participant_target"
                                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                    >
                                                        <option value="publik" @selected(old('participant_target', $diklatForm->participant_target ?? 'publik') === 'publik')>Publik / Umum</option>
                                                        <option value="internal" @selected(old('participant_target', $diklatForm->participant_target ?? 'publik') === 'internal')>Internal RSUD</option>
                                                        <option value="keduanya" @selected(old('participant_target', $diklatForm->participant_target ?? 'publik') === 'keduanya')>Publik dan Internal RSUD</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                        Pendaftaran Online Peserta *
                                                    </label>
                                                    <select
                                                        name="requires_registration"
                                                        x-model="requiresRegistration"
                                                        @change="if (requiresRegistration === '0') { isPaid = '0'; }"
                                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                    >
                                                        <option value="1">Perlu pendaftaran online</option>
                                                        <option value="0">Tidak perlu pendaftaran (Sosialisasi/Hadir langsung)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- KUOTA & STATUS PENDAFTARAN (UNTUK PELATIHAN REGISTRASI) --}}
                                            <div x-show="requiresRegistration === '1'" class="space-y-4 rounded-xl bg-slate-50 p-4 border border-slate-200">
                                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                                    <div>
                                                        <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                            Kuota Total Peserta *
                                                        </label>
                                                        <input
                                                            name="quota"
                                                            type="number"
                                                            min="0"
                                                            x-model.number="quotaVal"
                                                            value="{{ old('quota', $diklatForm->quota ?? 30) }}"
                                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                        >
                                                    </div>

                                                    <div>
                                                        <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                            Sisa Kuota
                                                        </label>
                                                        <input
                                                            type="number"
                                                            readonly
                                                            :value="Math.max(0, quotaVal || 0)"
                                                            class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-500 cursor-not-allowed"
                                                        >
                                                        <span class="text-[10px] text-gray-400 mt-1 block">Otomatis sinkron dengan pendaftar aktif.</span>
                                                    </div>

                                                    <div>
                                                        <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                            Status Pendaftaran *
                                                        </label>
                                                        <select
                                                            name="status"
                                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                        >
                                                            @foreach (['dibuka' => 'Dibuka', 'terbatas' => 'Kuota terbatas', 'penuh' => 'Kuota penuh', 'ditutup' => 'Ditutup'] as $value => $label)
                                                                <option value="{{ $value }}" @selected(old('status', $diklatForm->status ?? 'dibuka') === $value)>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- BIAYA KEGIATAN & REKENING --}}
                                            <template x-if="requiresRegistration === '0'">
                                                <input type="hidden" name="is_paid" value="0">
                                            </template>

                                            <div x-show="requiresRegistration === '1'" class="rounded-xl border border-gray-200 p-4 space-y-4">
                                                <div>
                                                    <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                        Biaya Partisipasi Kegiatan
                                                    </label>
                                                    <select
                                                        name="is_paid"
                                                        x-model="isPaid"
                                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                    >
                                                        <option value="0">Gratis / Tanpa Biaya</option>
                                                        <option value="1">Berbayar</option>
                                                    </select>
                                                </div>

                                                <div x-show="isPaid === '1'" class="space-y-4 border-t border-gray-100 pt-3">
                                                    <div>
                                                        <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                            Nominal Biaya (Rp) *
                                                        </label>
                                                        <input
                                                            name="fee"
                                                            type="text"
                                                            inputmode="numeric"
                                                            value="{{ old('fee', $diklatForm->fee ?? '') }}"
                                                            placeholder="Contoh: 150000"
                                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"
                                                        >
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 rounded-xl border border-teal-200 bg-teal-50/50 p-4">
                                                        <div>
                                                            <label class="mb-1 block text-xs font-semibold text-slate-700">Nama Bank *</label>
                                                            <input name="payment_bank_name" type="text" maxlength="100"
                                                                value="{{ old('payment_bank_name', $diklatForm->payment_bank_name ?? '') }}"
                                                                placeholder="Contoh: Bank BRI"
                                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs bg-white">
                                                        </div>
                                                        <div>
                                                            <label class="mb-1 block text-xs font-semibold text-slate-700">Nomor Rekening *</label>
                                                            <input name="payment_account_number" type="text" maxlength="50"
                                                                value="{{ old('payment_account_number', $diklatForm->payment_account_number ?? '') }}"
                                                                placeholder="Contoh: 1234-01-000123-45-6"
                                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs bg-white">
                                                        </div>
                                                        <div>
                                                            <label class="mb-1 block text-xs font-semibold text-slate-700">Nama Pemilik Rekening *</label>
                                                            <input name="payment_account_name" type="text" maxlength="255"
                                                                value="{{ old('payment_account_name', $diklatForm->payment_account_name ?? '') }}"
                                                                placeholder="Contoh: RSUD R.A.A. Tjokronegoro"
                                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs bg-white">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                {{-- ================================================== --}}
                                {{-- TAB 3: RINCIAN MATERI, SYARAT & FASILITAS (01 - 05) --}}
                                {{-- ================================================== --}}
                                <div x-show="activeTab === 3" class="space-y-5">
                                    <div class="rounded-xl bg-teal-50/70 p-4 border border-teal-200 text-xs text-teal-900">
                                        <div class="flex items-center gap-1.5 font-bold text-teal-800 mb-1">
                                            <svg class="w-4 h-4 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>Panduan Rincian Materi, Syarat &amp; Fasilitas (01 - 05):</span>
                                        </div>
                                        <p class="text-teal-800/90 leading-relaxed">
                                            Bagian ini ditampilkan pada nomor <strong>01 sampai 05</strong> di halaman detail publik. Anda dapat menggunakan tombol <em>"✨ Gunakan Contoh Standar"</em> di setiap bagian untuk draf cepat. Pastikan seluruh rincian terisi lengkap untuk memberikan informasi yang jelas kepada calon peserta. Anda dapat menggunakan tombol <em>"✨ Gunakan Contoh Standar"</em> di setiap bagian untuk mengisi draf acuan resmi secara cepat.
                                        </p>
                                    </div>

                                    {{-- 01. DESKRIPSI & GAMBARAN UMUM --}}
                                    <div class="space-y-1.5 rounded-xl border border-gray-200 p-4">
                                        <div class="flex items-center justify-between gap-2">
                                            <label class="text-sm font-bold text-slate-800" x-text="category === 'Pendidikan' ? '01. Deskripsi & Gambaran Program Pendidikan' : '01. Deskripsi & Latar Belakang Pelatihan'">
                                                01. Deskripsi &amp; Gambaran Program
                                            </label>
                                            <button
                                                type="button"
                                                @click="fillDefault('description')"
                                                class="inline-flex items-center gap-1 rounded-md bg-teal-50 px-2.5 py-1 text-xs font-semibold text-[#007b83] hover:bg-teal-100 border border-teal-200 transition"
                                            >
                                                ✨ Gunakan Contoh Standar
                                            </button>
                                        </div>
                                        <p class="text-xs text-slate-500">Paragraf pengantar yang menjelaskan maksud dan ruang lingkup program.</p>
                                        <textarea
                                            name="description"
                                            x-model="descriptionVal"
                                            rows="3"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                            placeholder="Tuliskan deskripsi lengkap program..."
                                        ></textarea>
                                    </div>

                                    {{-- 02. TUJUAN & CAPAIAN KOMPETENSI --}}
                                    <div class="space-y-1.5 rounded-xl border border-gray-200 p-4">
                                        <div class="flex items-center justify-between gap-2">
                                            <label class="text-sm font-bold text-slate-800" x-text="category === 'Pendidikan' ? '02. Tujuan & Capaian Kompetensi Pembelajaran' : '02. Tujuan Pelatihan & Kompetensi'">
                                                02. Tujuan &amp; Capaian Kompetensi
                                            </label>
                                            <button
                                                type="button"
                                                @click="fillDefault('objectives')"
                                                class="inline-flex items-center gap-1 rounded-md bg-teal-50 px-2.5 py-1 text-xs font-semibold text-[#007b83] hover:bg-teal-100 border border-teal-200 transition"
                                            >
                                                ✨ Gunakan Contoh Standar
                                            </button>
                                        </div>
                                        <p class="text-xs text-slate-500">Pisahkan setiap target capaian dengan <strong>Enter (baris baru)</strong>. Otomatis tampil sebagai poin checklist di web publik.</p>
                                        <textarea
                                            name="objectives"
                                            x-model="objectivesVal"
                                            rows="4"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white font-mono text-xs leading-relaxed"
                                            placeholder="Tuliskan tujuan (1 poin per baris)..."
                                        ></textarea>
                                    </div>

                                    {{-- 03. RUANG LINGKUP STASE / KURIKULUM MATERI --}}
                                    <div class="space-y-1.5 rounded-xl border border-gray-200 p-4">
                                        <div class="flex items-center justify-between gap-2">
                                            <label class="text-sm font-bold text-slate-800" x-text="category === 'Pendidikan' ? '03. Ruang Lingkup Stase & Pembelajaran Klinis' : '03. Kurikulum & Materi Pelatihan'">
                                                03. Ruang Lingkup Stase / Materi Modul
                                            </label>
                                            <button
                                                type="button"
                                                @click="fillDefault('materials')"
                                                class="inline-flex items-center gap-1 rounded-md bg-teal-50 px-2.5 py-1 text-xs font-semibold text-[#007b83] hover:bg-teal-100 border border-teal-200 transition"
                                            >
                                                ✨ Gunakan Contoh Standar
                                            </button>
                                        </div>
                                        <p class="text-xs text-slate-500">Pisahkan setiap modul/stase dengan <strong>Enter (baris baru)</strong>. Otomatis tampil sebagai kartu stase/modul di web publik.</p>
                                        <textarea
                                            name="materials"
                                            x-model="materialsVal"
                                            rows="4"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white font-mono text-xs leading-relaxed"
                                            placeholder="Tuliskan modul / stase (1 poin per baris)..."
                                        ></textarea>
                                    </div>

                                    {{-- 04 & 05: PERSYARATAN & FASILITAS --}}
                                    {{-- PENGATURAN BERKAS PERSYARATAN (KHUSUS PELATIHAN) --}}
                                    <template x-if="category === 'Pelatihan' && requiresRegistration === '1'">
                                        <div class="rounded-xl border border-teal-200 bg-teal-50/50 p-4 space-y-3">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-[#007b83]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <h4 class="text-xs font-bold uppercase tracking-wider text-teal-900">
                                                    Pengaturan Kolom Unggah Berkas &amp; Persyaratan Otomatis
                                                </h4>
                                            </div>
                                            <p class="text-xs text-slate-600">
                                                Centang berkas yang ingin diaktifkan. Jika dicentang, <strong>kolom upload otomatis muncul di form pendaftaran</strong> dan <strong>poin persyaratan otomatis tampil di halaman detail web</strong>.
                                            </p>
                                            <div class="grid grid-cols-1 gap-2.5 sm:grid-cols-3 pt-1">
                                                <label class="flex items-start gap-2.5 rounded-lg border border-teal-200/80 bg-white p-3 cursor-pointer hover:border-teal-400 transition shadow-xs">
                                                    <input
                                                        type="checkbox"
                                                        name="requires_assignment_letter"
                                                        value="1"
                                                        class="rounded border-gray-300 text-[#007b83] focus:ring-[#007b83] mt-0.5"
                                                        @checked(old('requires_assignment_letter', $diklatForm->requires_assignment_letter ?? true))
                                                    >
                                                    <div class="text-xs">
                                                        <strong class="text-slate-800 block">Surat Tugas Instansi</strong>
                                                        <span class="text-slate-500">Opsional bagi utusan instansi / faskes</span>
                                                    </div>
                                                </label>

                                                <label class="flex items-start gap-2.5 rounded-lg border border-teal-200/80 bg-white p-3 cursor-pointer hover:border-teal-400 transition shadow-xs">
                                                    <input
                                                        type="checkbox"
                                                        name="requires_str_file"
                                                        value="1"
                                                        class="rounded border-gray-300 text-[#007b83] focus:ring-[#007b83] mt-0.5"
                                                        @checked(old('requires_str_file', $diklatForm->requires_str_file ?? false))
                                                    >
                                                    <div class="text-xs">
                                                        <strong class="text-slate-800 block">Berkas Scan STR</strong>
                                                        <span class="text-slate-500">Scan STR aktif tenaga kesehatan</span>
                                                    </div>
                                                </label>

                                                <label class="flex items-start gap-2.5 rounded-lg border border-teal-200/80 bg-white p-3 cursor-pointer hover:border-teal-400 transition shadow-xs">
                                                    <input
                                                        type="checkbox"
                                                        name="requires_id_photo"
                                                        value="1"
                                                        class="rounded border-gray-300 text-[#007b83] focus:ring-[#007b83] mt-0.5"
                                                        @checked(old('requires_id_photo', $diklatForm->requires_id_photo ?? false))
                                                    >
                                                    <div class="text-xs">
                                                        <strong class="text-slate-800 block">Pas Foto Formal</strong>
                                                        <span class="text-slate-500">Foto peserta latar merah/biru</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- 04. PERSYARATAN --}}
                                    <div class="space-y-1.5 rounded-xl border border-gray-200 p-4">
                                        <div class="flex items-center justify-between gap-2">
                                            <label class="text-sm font-bold text-slate-800" x-text="category === 'Pendidikan' ? '04. Persyaratan Mahasiswa & Berkas Institusi (MoU)' : '04. Persyaratan Peserta & Berkas Administrasi'">
                                                04. Persyaratan Peserta &amp; Berkas
                                            </label>
                                            <button
                                                type="button"
                                                @click="fillDefault('requirements')"
                                                class="inline-flex items-center gap-1 rounded-md bg-teal-50 px-2.5 py-1 text-xs font-semibold text-[#007b83] hover:bg-teal-100 border border-teal-200 transition"
                                            >
                                                ✨ Gunakan Contoh Standar
                                            </button>
                                        </div>
                                        <p class="text-xs text-slate-500">Pisahkan setiap syarat dengan <strong>Enter (baris baru)</strong>. Otomatis tampil sebagai poin checklist verifikasi.</p>
                                        <textarea
                                            name="requirements"
                                            x-model="requirementsVal"
                                            rows="4"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white font-mono text-xs leading-relaxed"
                                            placeholder="Tuliskan syarat berkas / kualifikasi (1 syarat per baris)..."
                                        ></textarea>
                                    </div>

                                    {{-- 05. FASILITAS --}}
                                    <div class="space-y-1.5 rounded-xl border border-gray-200 p-4">
                                        <div class="flex items-center justify-between gap-2">
                                            <label class="text-sm font-bold text-slate-800" x-text="category === 'Pendidikan' ? '05. Fasilitas & Pembimbingan Klinis' : '05. Fasilitas & Keuntungan Peserta'">
                                                05. Fasilitas &amp; Pembimbingan Klinis
                                            </label>
                                            <button
                                                type="button"
                                                @click="fillDefault('facilities')"
                                                class="inline-flex items-center gap-1 rounded-md bg-teal-50 px-2.5 py-1 text-xs font-semibold text-[#007b83] hover:bg-teal-100 border border-teal-200 transition"
                                            >
                                                ✨ Gunakan Contoh Standar
                                            </button>
                                        </div>
                                        <p class="text-xs text-slate-500">Pisahkan setiap fasilitas dengan <strong>Enter (baris baru)</strong>.</p>
                                        <textarea
                                            name="facilities"
                                            x-model="facilitiesVal"
                                            rows="4"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white font-mono text-xs leading-relaxed"
                                            placeholder="Tuliskan fasilitas yang didapat (1 fasilitas per baris)..."
                                        ></textarea>
                                    </div>

                                    {{-- SKP & NARAHUBUNG --}}
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 pt-2">
                                        <div>
                                            <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                Akreditasi / Bobot SKP (Opsional)
                                            </label>
                                            <input
                                                type="text"
                                                name="skp_points"
                                                value="{{ old('skp_points', $diklatForm->skp_points ?? '') }}"
                                                placeholder="Contoh: 25 SKP Kemenkes RI"
                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                            >
                                        </div>

                                        <div>
                                            <label class="mb-1 block text-sm font-semibold text-slate-700">
                                                Narahubung / Kontak WhatsApp (Opsional)
                                            </label>
                                            <input
                                                type="text"
                                                name="contact_person"
                                                value="{{ old('contact_person', $diklatForm->contact_person ?? '') }}"
                                                placeholder="Contoh: 0811-2856-214"
                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                            >
                                        </div>
                                    </div>

                                    {{-- STATUS PUBLIKASI --}}
                                    <div class="border-t border-gray-200 pt-4">
                                        <div>
                                            <input type="hidden" name="is_active" value="0">
                                            <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-800 cursor-pointer">
                                                <input
                                                    type="checkbox"
                                                    name="is_active"
                                                    value="1"
                                                    class="rounded text-[#007b83] focus:ring-[#007b83]"
                                                    @checked(old('is_active', $diklatForm->is_active ?? true))
                                                >
                                                <span>Aktifkan program (Tampilkan di web publik)</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- FOOTER TOMBOL NAVIGASI & SIMPAN --}}
                                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-200 pt-5 mt-6">
                                    <div>
                                        <button
                                            type="button"
                                            x-show="activeTab > 1"
                                            @click="prevTab()"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3.5 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 shadow-xs transition cursor-pointer"
                                        >
                                            ← Kembali
                                        </button>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-2">
                                        {{-- Tombol Lanjut ke Tab Berikutnya --}}
                                        <button
                                            type="button"
                                            x-show="activeTab < 3"
                                            @click="nextTab()"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-teal-50 border border-teal-200 px-4 py-2 text-xs font-semibold text-[#007b83] hover:bg-teal-100 transition cursor-pointer"
                                        >
                                            <span x-text="activeTab === 1 ? 'Lanjut ke Pelaksanaan &amp; Pendaftaran →' : 'Lanjut ke Rincian Materi (01-05) →'">
                                                Lanjut →
                                            </span>
                                        </button>

                                        {{-- Tombol Simpan Form Utama --}}
                                        <button
                                            type="submit"
                                            x-show="isEditing || activeTab === 3"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-[#007b83] px-5 py-2 text-xs sm:text-sm font-semibold text-white hover:bg-[#005b64] shadow-xs transition cursor-pointer"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>{{ $isEditingDiklat ? 'Simpan Perubahan' : 'Simpan & Terbitkan Program Diklat' }}</span>
                                        </button>

                                        @if ($isEditingDiklat)
                                            <a
                                                href="{{ route('admin.pages.edit', $page) }}#diklat-program"
                                                class="rounded-lg border border-slate-300 px-3.5 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition"
                                            >
                                                Batal Edit
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>

                            {{-- ================================================== --}}
                            {{-- DAFTAR & RIWAYAT PROGRAM DIKLAT (MODERN CARD & TABLE) --}}
                            {{-- ================================================== --}}
                            <div
                                class="mt-8 rounded-2xl border border-slate-200 bg-white p-5 sm:p-6 shadow-xs"
                                x-data="{
                                    editingProgramId: null,
                                    activeCategory: 'all',
                                    searchQuery: '',
                                    matchesFilter(cat) {
                                        if (this.activeCategory === 'all') return true;
                                        return (cat || '').toLowerCase() === this.activeCategory.toLowerCase();
                                    },
                                    matchesSearch(name, desc, target) {
                                        if (!this.searchQuery.trim()) return true;
                                        const q = this.searchQuery.toLowerCase();
                                        return (name || '').toLowerCase().includes(q) 
                                            || (desc || '').toLowerCase().includes(q)
                                            || (target || '').toLowerCase().includes(q);
                                    }
                                }"
                            >
                                {{-- HEADER & SEARCH --}}
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-4">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-base font-bold text-slate-900">
                                                Daftar Program Diklat
                                            </h3>
                                            <span class="inline-flex items-center rounded-full bg-teal-50 px-2.5 py-0.5 text-xs font-bold text-[#007b83] border border-teal-200">
                                                {{ $diklatPrograms->count() }} Program
                                            </span>
                                        </div>
                                        <p class="mt-0.5 text-xs text-slate-500">
                                            Kelola seluruh program pendidikan klinis, PKL, dan pelatihan yang terdaftar.
                                        </p>
                                    </div>

                                    {{-- INPUT PENCARIAN LIVE --}}
                                    <div class="relative w-full sm:w-72">
                                        <input
                                            type="text"
                                            x-model="searchQuery"
                                            placeholder="Cari nama / sasaran program..."
                                            class="w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-9 pr-8 py-2 text-xs focus:bg-white focus:border-[#007b83] focus:ring-1 focus:ring-[#007b83] transition"
                                        >
                                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        <button
                                            type="button"
                                            x-show="searchQuery.length > 0"
                                            @click="searchQuery = ''"
                                            class="absolute right-2.5 top-2 text-slate-400 hover:text-slate-600 text-xs font-bold cursor-pointer"
                                        >
                                            ✕
                                        </button>
                                    </div>
                                </div>

                                {{-- PILLS FILTER KATEGORI --}}
                                @php
                                    $eduCount = $diklatPrograms->filter(fn($p) => strtolower(trim($p->category ?? '')) === 'pendidikan')->count();
                                    $trainCount = $diklatPrograms->filter(fn($p) => strtolower(trim($p->category ?? '')) === 'pelatihan')->count();
                                @endphp
                                <div class="flex flex-wrap items-center gap-2 pt-3">
                                    <button
                                        type="button"
                                        @click="activeCategory = 'all'"
                                        :class="activeCategory === 'all'
                                            ? 'bg-[#007b83] text-white shadow-xs'
                                            : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-bold transition cursor-pointer"
                                    >
                                        <span>Semua Program</span>
                                        <span class="rounded-full bg-black/15 px-1.5 py-0.2 text-[10px]">{{ $diklatPrograms->count() }}</span>
                                    </button>

                                    <button
                                        type="button"
                                        @click="activeCategory = 'Pendidikan'"
                                        :class="activeCategory === 'Pendidikan'
                                            ? 'bg-blue-600 text-white shadow-xs'
                                            : 'bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200/60'"
                                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-bold transition cursor-pointer"
                                    >
                                        <span>📘 Pendidikan</span>
                                        <span class="rounded-full bg-black/15 px-1.5 py-0.2 text-[10px]">{{ $eduCount }}</span>
                                    </button>

                                    <button
                                        type="button"
                                        @click="activeCategory = 'Pelatihan'"
                                        :class="activeCategory === 'Pelatihan'
                                            ? 'bg-[#007b83] text-white shadow-xs'
                                            : 'bg-teal-50 text-[#007b83] hover:bg-teal-100 border border-teal-200/60'"
                                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-bold transition cursor-pointer"
                                    >
                                        <span>🎓 Pelatihan</span>
                                        <span class="rounded-full bg-black/15 px-1.5 py-0.2 text-[10px]">{{ $trainCount }}</span>
                                    </button>
                                </div>

                                {{-- TABEL MODERN DENGAN VERTICAL SCROLL & NO HORIZONTAL SCROLL --}}
                                <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-2xs">
                                    <div class="overflow-y-auto overflow-x-hidden max-h-[520px]">
                                        <table class="w-full table-fixed divide-y divide-slate-200 text-left text-xs">
                                            <thead class="sticky top-0 z-10 bg-slate-50 border-b border-slate-200 text-slate-700 shadow-2xs">
                                                <tr>
                                                    <th scope="col" class="w-[36%] px-3.5 py-3 font-bold uppercase tracking-wider text-[11px]">Program &amp; Informasi</th>
                                                    <th scope="col" class="w-[18%] px-3 py-3 font-bold uppercase tracking-wider text-[11px]">Kategori &amp; Jalur</th>
                                                    <th scope="col" class="w-[24%] px-3 py-3 font-bold uppercase tracking-wider text-[11px]">Jadwal &amp; Kuota</th>
                                                    <th scope="col" class="w-[10%] px-2 py-3 font-bold uppercase tracking-wider text-center text-[11px]">Status</th>
                                                    <th scope="col" class="w-[12%] px-2 py-3 font-bold uppercase tracking-wider text-center text-[11px]">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100">
                                                @forelse ($diklatPrograms as $program)
                                                    @php
                                                        $isEducation = strtolower(trim($program->category ?? '')) === 'pendidikan';
                                                        $registeredCount = $program->registrations ? $program->registrations->where('status', '!=', 'ditolak')->count() : 0;
                                                    @endphp

                                                    {{-- BARIS DATA PROGRAM --}}
                                                    <tr
                                                        class="align-top hover:bg-slate-50/80 transition-colors"
                                                        x-show="matchesFilter('{{ $program->category }}') && matchesSearch('{{ addslashes($program->name) }}', '{{ addslashes($program->description ?? '') }}', '{{ addslashes($program->target ?? '') }}')"
                                                        x-transition
                                                    >
                                                        {{-- 1. PROGRAM & INFORMASI --}}
                                                        <td class="px-3.5 py-3">
                                                            <div class="flex items-start gap-2.5">
                                                                <div class="relative h-10 w-10 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center">
                                                                    @if ($program->image_url)
                                                                        <img src="{{ $program->image_url }}" alt="{{ $program->name }}" class="h-full w-full object-cover">
                                                                    @elseif ($isEducation)
                                                                        <span class="text-base">📘</span>
                                                                    @else
                                                                        <span class="text-base">🎓</span>
                                                                    @endif
                                                                </div>

                                                                <div class="min-w-0 flex-1">
                                                                    <div class="font-bold text-slate-900 text-xs sm:text-sm hover:text-[#007b83] transition leading-snug line-clamp-2 break-words" title="{{ $program->name }}">
                                                                        {{ $program->name }}
                                                                    </div>

                                                                    @if ($program->target || $program->description)
                                                                        <p class="mt-0.5 text-[11px] text-slate-500 line-clamp-1 break-words" title="{{ $program->target ?: $program->description }}">
                                                                            {{ $program->target ?: $program->description }}
                                                                        </p>
                                                                    @endif

                                                                    {{-- CHIPS METADATA --}}
                                                                    <div class="mt-1 flex flex-wrap items-center gap-1 text-[10px]">
                                                                        @if ($program->flyer_image)
                                                                            <span class="inline-flex items-center gap-1 rounded bg-teal-50 px-1.5 py-0.2 font-bold text-[#007b83] border border-teal-200">
                                                                                📄 Brosur
                                                                            </span>
                                                                        @endif

                                                                        @if ($program->skp_points)
                                                                            <span class="inline-flex items-center gap-1 rounded bg-indigo-50 px-1.5 py-0.2 font-bold text-indigo-700 border border-indigo-200">
                                                                                ★ {{ $program->skp_points }}
                                                                            </span>
                                                                        @endif

                                                                        @if ($program->requires_registration && $program->is_paid)
                                                                            <span class="inline-flex items-center rounded bg-amber-50 px-1.5 py-0.2 font-bold text-amber-800 border border-amber-200">
                                                                                Rp {{ number_format($program->fee, 0, ',', '.') }}
                                                                            </span>
                                                                        @else
                                                                            <span class="inline-flex items-center rounded bg-emerald-50 px-1.5 py-0.2 font-bold text-emerald-800 border border-emerald-200">
                                                                                Gratis
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        {{-- 2. KATEGORI & JALUR --}}
                                                        <td class="px-3 py-3">
                                                            <div class="space-y-1">
                                                                @if ($isEducation)
                                                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-0.5 text-[11px] font-bold text-blue-700 border border-blue-200">
                                                                        Pendidikan
                                                                    </span>
                                                                @else
                                                                    <span class="inline-flex items-center gap-1 rounded-full bg-teal-50 px-2 py-0.5 text-[11px] font-bold text-[#007b83] border border-teal-200">
                                                                        Pelatihan
                                                                    </span>
                                                                @endif

                                                                <div class="text-[11px] text-slate-500 break-words">
                                                                    @if ($program->requires_registration)
                                                                        <span class="text-slate-700 font-semibold">Online Reg</span>
                                                                    @else
                                                                        <span class="text-slate-400">Tanpa Reg</span>
                                                                    @endif
                                                                    • {{ $program->method ?: 'Luring' }}
                                                                </div>
                                                            </div>
                                                        </td>

                                                        {{-- 3. JADWAL & KUOTA --}}
                                                        <td class="px-3 py-3">
                                                            <div class="space-y-1">
                                                                @php
                                                                    if (!$isEducation && $program->start_at) {
                                                                        $rowScheduleText = $program->start_at->translatedFormat('d M Y');
                                                                        if ($program->end_at && !$program->end_at->isSameDay($program->start_at)) {
                                                                            $rowScheduleText .= ' - ' . $program->end_at->translatedFormat('d M Y');
                                                                        }
                                                                    } else {
                                                                        $rowScheduleText = trim((string) ($program->schedule ?? ''));
                                                                        if ($rowScheduleText === '-' || $rowScheduleText === '') {
                                                                            $rowScheduleText = null;
                                                                        }
                                                                        if (!$rowScheduleText) {
                                                                            $rowScheduleText = $isEducation ? 'Sesuai pengajuan dan persetujuan rumah sakit' : '-';
                                                                        }
                                                                    }
                                                                @endphp
                                                                <div class="text-xs font-semibold text-slate-800 break-words line-clamp-2 leading-snug" title="{{ $rowScheduleText }}">
                                                                    {{ $rowScheduleText }}
                                                                </div>

                                                                @if ($isEducation)
                                                                    <div class="text-[11px] text-slate-500 break-words line-clamp-1" title="{{ $program->duration ?: 'Ketentuan institusi' }}">
                                                                        Durasi: {{ $program->duration ?: 'Ketentuan institusi' }}
                                                                    </div>
                                                                @else
                                                                    @if ($program->schedule && trim($program->schedule) !== '-' && trim($program->schedule) !== '')
                                                                        <div class="text-[11px] text-slate-500 break-words line-clamp-1" title="{{ $program->schedule }}">
                                                                            Ket: {{ $program->schedule }}
                                                                        </div>
                                                                    @endif
                                                                    @if ($program->requires_registration)
                                                                        <div class="text-[11px] text-slate-600 font-medium break-words">
                                                                            Sisa: <strong class="text-[#007b83]">{{ $program->remaining_quota }}</strong>/{{ $program->quota }}
                                                                            <span class="text-slate-400">({{ $registeredCount }} pendaftar)</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="text-[11px] text-slate-400">Hadir langsung di lokasi</div>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </td>

                                                        {{-- 4. STATUS --}}
                                                        @php
                                                            $hasStarted = $program->start_at && \Carbon\Carbon::parse($program->start_at)->lte(today());
                                                            $isExpired = ($program->end_at && \Carbon\Carbon::parse($program->end_at)->lt(today()))
                                                                || (!$program->end_at && $program->start_at && \Carbon\Carbon::parse($program->start_at)->lt(today()));
                                                            $isHiddenFromPublic = $hasStarted || $isExpired;
                                                        @endphp
                                                        <td class="px-2 py-3 text-center">
                                                            <div class="inline-flex flex-col items-center gap-1">
                                                                @if (!$program->is_active)
                                                                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-bold text-slate-600 border border-slate-200">
                                                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                                                        Draft
                                                                    </span>
                                                                @elseif ($isExpired)
                                                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-bold text-amber-800 border border-amber-200" title="Tanggal pelaksanaan sudah lewat — otomatis tidak tampil di web publik">
                                                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                                        Berakhir
                                                                    </span>
                                                                    <span class="text-[10px] font-semibold text-slate-400 leading-tight">
                                                                        Lewat jadwal
                                                                    </span>
                                                                @elseif ($hasStarted)
                                                                    <span class="inline-flex items-center gap-1 rounded-full bg-sky-50 px-2 py-0.5 text-[11px] font-bold text-sky-800 border border-sky-200" title="Tanggal mulai sudah tiba — otomatis tidak tampil di web publik">
                                                                        <span class="h-1.5 w-1.5 rounded-full bg-sky-500"></span>
                                                                        Berlangsung
                                                                    </span>
                                                                    <span class="text-[10px] font-semibold text-slate-400 leading-tight">
                                                                        Tersembunyi di publik
                                                                    </span>
                                                                @else
                                                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-bold text-emerald-700 border border-emerald-200">
                                                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                                        Aktif
                                                                    </span>
                                                                @endif

                                                                @if (!$isEducation && $program->requires_registration && !$isHiddenFromPublic)
                                                                    <span class="text-[10px] uppercase font-bold text-slate-500">
                                                                        {{ $program->status }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </td>

                                                        {{-- 5. AKSI --}}
                                                        <td class="px-2 py-3 text-center">
                                                            <div class="inline-flex items-center justify-center gap-1 flex-wrap">
                                                                {{-- Tombol Lihat di Web --}}
                                                                <a
                                                                    href="{{ route('information.diklat.detail', $program->id) }}"
                                                                    target="_blank"
                                                                    class="inline-flex items-center justify-center rounded-lg p-1.5 text-slate-500 hover:text-[#007b83] hover:bg-teal-50 border border-slate-200 transition"
                                                                    title="Lihat di Web"
                                                                >
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                                    </svg>
                                                                </a>

                                                                {{-- Tombol Edit --}}
                                                                <button
                                                                    type="button"
                                                                    @click="editingProgramId = {{ $program->id }}; $nextTick(() => { window.initIndonesianDatePickers && window.initIndonesianDatePickers(document.body); });"
                                                                    class="inline-flex items-center gap-1 rounded-lg bg-slate-100 hover:bg-slate-200 px-2 py-1.5 text-xs font-semibold text-slate-700 border border-slate-200 transition cursor-pointer"
                                                                    title="Edit Program"
                                                                >
                                                                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                    </svg>
                                                                    <span>Edit</span>
                                                                </button>

                                                                {{-- Tombol Hapus --}}
                                                                <form
                                                                    action="{{ route('admin.pages.diklat-programs.destroy', [
                                                                        'page' => $page->id,
                                                                        'program' => $program->id,
                                                                    ]) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Yakin ingin menghapus program {{ addslashes($program->name) }}?')"
                                                                    class="inline-block"
                                                                >
                                                                    @csrf
                                                                    @method('DELETE')

                                                                    <button
                                                                        type="submit"
                                                                        class="inline-flex items-center justify-center rounded-lg p-1.5 text-red-600 hover:text-red-800 hover:bg-red-50 border border-red-200 transition cursor-pointer"
                                                                        title="Hapus Program"
                                                                    >
                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    {{-- ================================================== --}}
                                                    {{-- POPUP EDIT PROGRAM --}}
                                                    {{-- ================================================== --}}
                                                    <tr>
                                                        <td colspan="5" class="border-0 p-0">
                                                            <div
                                                                x-cloak
                                                                x-show="editingProgramId === {{ $program->id }}"
                                                                x-transition.opacity
                                                                @keydown.escape.window="editingProgramId = null"
                                                                @click.self="editingProgramId = null"
                                                                class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-black/50 p-4"
                                                            >
                                                                <div
                                                                    x-show="editingProgramId === {{ $program->id }}"
                                                                    x-transition
                                                                    class="relative my-auto flex max-h-[90vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl dark:bg-gray-900"
                                                                    role="dialog"
                                                                    aria-modal="true"
                                                                    aria-label="Edit program diklat"
                                                                >
                                                                    {{-- HEADER POPUP --}}
                                                                    <div class="flex shrink-0 items-center justify-between gap-3 border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                                                                        <div>
                                                                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                                Edit Program Diklat
                                                                            </h2>
                                                                            <p class="mt-1 text-sm text-gray-500">
                                                                                Perbarui informasi program yang dipilih.
                                                                            </p>
                                                                        </div>

                                                                        <button
                                                                            type="button"
                                                                            @click="editingProgramId = null"
                                                                            class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800"
                                                                            aria-label="Tutup popup"
                                                                        >
                                                                            <span class="text-xl">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    {{-- FORM EDIT DENGAN SISTEM TAB MODERN --}}
                                                                    <form
                                                                        action="{{ route('admin.pages.diklat-programs.update', [
                                                                            'page' => $page->id,
                                                                            'program' => $program->id,
                                                                        ]) }}"
                                                                        method="POST"
                                                                        enctype="multipart/form-data"
                                                                        x-data="{
                                                                            activeTab: 1,
                                                                            category: @js($program->category),
                                                                            method: @js($program->method ?: 'Luring'),
                                                                            location: @js($program->location ?: 'RSUD R.A.A. Tjokronegoro'),
                                                                            isPaid: @js((string) (int) $program->is_paid),
                                                                            requiresRegistration: @js((string) (int) $program->requires_registration),
                                                                            quotaVal: {{ (int) ($program->quota ?? 0) }},
                                                                            registeredTotal: {{ (int) ($registeredCount ?? 0) }},
                                                                            dateMode: @js(
                                                                                ($program->start_at && $program->end_at && \Carbon\Carbon::parse($program->start_at)->isSameDay(\Carbon\Carbon::parse($program->end_at)))
                                                                                || ($program->start_at && !$program->end_at)
                                                                                ? 'single'
                                                                                : 'range'
                                                                            ),

                                                                            // Detail Konten
                                                                            targetDescriptionVal: @js($program->target_description ?: ($program->target ?: '')),
                                                                            descriptionVal: @js($program->formatted_description),
                                                                            objectivesVal: @js($program->formatted_objectives),
                                                                            materialsVal: @js($program->formatted_materials),
                                                                            requirementsVal: @js($program->formatted_requirements),
                                                                            facilitiesVal: @js($program->formatted_facilities),

                                                                            // Upload Brosur
                                                                            @php
                                                                                $flyerFile = $program->flyer_image;
                                                                                $isFlyerPdf = $flyerFile && str_ends_with(strtolower($flyerFile), '.pdf');
                                                                            @endphp
                                                                            isPdf: @js($isFlyerPdf),
                                                                            imagePreview: @js($flyerFile && !$isFlyerPdf ? asset('storage/' . $flyerFile) : null),
                                                                            fileName: @js($flyerFile ? basename($flyerFile) : null),
                                                                            deleteImage: false,
                                                                            handleFileChange(event) {
                                                                                const file = event.target.files?.[0];
                                                                                if (file) {
                                                                                    if (file.size > 5 * 1024 * 1024) {
                                                                                        alert('Ukuran berkas brosur/flyer terlalu besar (' + (file.size / (1024 * 1024)).toFixed(1) + ' MB). Maksimal ukuran berkas adalah 5 MB.');
                                                                                        event.target.value = '';
                                                                                        this.removeImage();
                                                                                        return;
                                                                                    }
                                                                                    this.fileName = file.name;
                                                                                    this.isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');
                                                                                    if (!this.isPdf && file.type.startsWith('image/')) {
                                                                                        this.imagePreview = URL.createObjectURL(file);
                                                                                    } else {
                                                                                        this.imagePreview = null;
                                                                                    }
                                                                                    this.deleteImage = false;
                                                                                }
                                                                            },
                                                                            removeImage() {
                                                                                this.imagePreview = null;
                                                                                this.fileName = null;
                                                                                this.isPdf = false;
                                                                                this.deleteImage = true;
                                                                                if (this.$refs.modalFileInput) {
                                                                                    this.$refs.modalFileInput.value = '';
                                                                                }
                                                                            },

                                                                            // Upload Card Banner
                                                                            @php
                                                                                $cardFile = $program->image;
                                                                            @endphp
                                                                            cardPreview: @js($cardFile ? asset('storage/' . $cardFile) : null),
                                                                            deleteCard: false,
                                                                            handleCardChange(event) {
                                                                                const file = event.target.files?.[0];
                                                                                if (file) {
                                                                                    if (file.size > 5 * 1024 * 1024) {
                                                                                        alert('Ukuran gambar kartu terlalu besar (' + (file.size / (1024 * 1024)).toFixed(1) + ' MB). Maksimal ukuran file adalah 5 MB.');
                                                                                        event.target.value = '';
                                                                                        this.removeCard();
                                                                                        return;
                                                                                    }
                                                                                    this.cardPreview = URL.createObjectURL(file);
                                                                                    this.deleteCard = false;
                                                                                }
                                                                            },
                                                                            removeCard() {
                                                                                this.cardPreview = null;
                                                                                this.deleteCard = true;
                                                                                if (this.$refs.modalCardInput) {
                                                                                    this.$refs.modalCardInput.value = '';
                                                                                }
                                                                            },

                                                                            // Helper Template Default
                                                                            fillDefault(field) {
                                                                                const isEdu = this.category === 'Pendidikan';
                                                                                if (field === 'description') {
                                                                                    this.descriptionVal = isEdu 
                                                                                        ? 'Program pendidikan dan praktik kerja lapangan/klinis di RSUD R.A.A. Tjokronegoro Purworejo diselenggarakan bagi mahasiswa institusi pendidikan mitra. Mahasiswa akan mendapatkan pengalaman pembelajaran klinis secara langsung dan komprehensif, dibimbing oleh Clinical Instructor (CI) profesional guna mengasah keterampilan teknis, etika profesi, serta kepatuhan pada standar patient safety.'
                                                                                        : 'Program pelatihan ini diselenggarakan oleh Instalasi Pendidikan dan Pelatihan RSUD R.A.A. Tjokronegoro Purworejo untuk memberikan penguatan kompetensi, wawasan teoritis, serta keterampilan klinis terapan yang esensial. Seluruh materi disusun secara komprehensif berstandar Kementerian Kesehatan Republik Indonesia guna menunjang profesionalisme tenaga kesehatan dalam memberikan pelayanan bermutu dan berorientasi pada keselamatan pasien (patient safety).';
                                                                                } else if (field === 'objectives') {
                                                                                    this.objectivesVal = isEdu
                                                                                        ? 'Memberikan pengalaman praktik klinis langsung dan terstruktur di lingkungan rumah sakit terakreditasi paripurna.\nMengaplikasikan ilmu teori akademik dan keterampilan teknis asuhan medis, keperawatan, kebidanan, atau kefarmasian sesuai standar operasional prosedur (SOP).\nMembangun etika profesionalisme, komunikasi terapeutik, dan kepatuhan tinggi terhadap keselamatan pasien (patient safety).\nMemenuhi target pencapaian kompetensi dan logbook stase klinis yang ditetapkan institusi pendidikan mitra.'
                                                                                        : 'Meningkatkan kompetensi, pengetahuan, dan keterampilan teknis peserta sesuai dengan standar pelayanan terkini.\nMemahami regulasi, kebijakan Kementerian Kesehatan RI, serta prosedur keselamatan kerja dan keselamatan pasien (patient safety).\nMampu mengaplikasikan protokol klinis, teknis aseptis, dan penanganan kasus secara profesional di fasilitas pelayanan kesehatan masing-masing.\nMenjamin tersedianya tenaga kesehatan yang terampil, tersertifikasi, dan siap memenuhi standar akreditasi rumah sakit.';
                                                                                } else if (field === 'materials') {
                                                                                    this.materialsVal = isEdu
                                                                                        ? 'Orientasi Rumah Sakit: Pencegahan & Pengendalian Infeksi (PPI), K3RS, Keselamatan Pasien, dan Bantuan Hidup Dasar (BHD)\nRotasi Stase Klinis: Rawat Inap, Rawat Jalan, Instalasi Gawat Darurat (IGD), dan Unit Perawatan Khusus\nBimbingan Kasus, Bedside Teaching, dan Ronde Klinis bersama Clinical Instructor (CI) / Dokter Pendidik Klinis (DPK)\nPengenalan Dokumentasi Rekam Medis Elektronik (RME) Rumah Sakit\nEvaluasi Akhir Stase, Ujian Keterampilan Klinis (DOPS/Mini-CEX), dan Presentasi Refleksi Kasus'
                                                                                        : 'Kebijakan dan Regulasi Kementerian Kesehatan RI Terkait Layanan\nKonsep Dasar, Aspek Farmakologi / Klinis & Prosedur Operasional Standar (SOP)\nPrinsip Keselamatan Kerja, Manajemen Risiko, dan Penjaminan Mutu\nPraktik Hands-On, Studi Kasus, dan Simulasi Prosedural di Lingkungan Rumah Sakit\nEvaluasi Kompetensi, Ujian Pre-test & Post-test';
                                                                                } else if (field === 'requirements') {
                                                                                    const targetText = (this.targetDescriptionVal && this.targetDescriptionVal.trim())
                                                                                        ? this.targetDescriptionVal.trim()
                                                                                        : (isEdu ? 'Siswa SMA/SMK dan mahasiswa hingga jenjang S1 dari berbagai bidang institusi mitra.' : 'Tenaga Medis, Apoteker, Perawat, atau Tenaga Kesehatan Terkait');

                                                                                    this.requirementsVal = isEdu
                                                                                        ? ('Sasaran: ' + targetText + '\nMahasiswa aktif dari institusi pendidikan yang telah memiliki Perjanjian Kerjasama (MoU) aktif dengan RSUD\nMelampirkan Surat Permohonan / Rekomendasi Resmi dari Dekan / Pimpinan Institusi Pendidikan asal\nMelampirkan daftar nama calon mahasiswa peserta stase beserta NIM dan Program Studi\nPas foto formal terbaru berlatar belakang warna dengan seragam almamater resmi')
                                                                                        : ('Sasaran: ' + targetText + '\nMembawa/mengunggah Surat Tugas atau Rekomendasi dari Pimpinan Instansi / Rumah Sakit asal (Opsional jika mandiri)');
                                                                                } else if (field === 'facilities') {
                                                                                    this.facilitiesVal = isEdu
                                                                                        ? 'Pembimbingan intensif oleh Clinical Instructor (CI) dan Dokter Pendidik Klinis (DPK) tersertifikasi\nAkses ruang diskusi, perpustakaan, dan fasilitas penunjang pembelajaran di Instalasi Diklat\nPembekalan orientasi keselamatan kerja dan perlindungan K3RS selama stase klinis\nVerifikasi logbook kompetensi dan Surat Keterangan / Sertifikat Selesai Praktik Resmi dari RSUD'
                                                                                        : 'Sertifikat Resmi Kementerian Kesehatan RI dengan Satuan Kredit Profesi (SKP)\nModul & Bahan Ajar Lengkap (Hardcopy / Softcopy) serta Seminar Kit Eksklusif\nFasilitas Praktik Klinis / Hands-on Laboratorium di RSUD R.A.A. Tjokronegoro\nKonsumsi (Snack dan Makan Siang) selama masa pelatihan tatap muka\nBimbingan interaktif langsung oleh Fasilitator Ahli dan Dokter Spesialis';
                                                                                }
                                                                            }
                                                                        }"
                                                                        class="flex min-h-0 flex-1 flex-col"
                                                                    >
                                                                        @csrf
                                                                        @method('PUT')

                                                                        {{-- TAB HEADER NAVIGASI MODAL --}}
                                                                        <div class="border-b border-gray-200 px-5 pt-3 bg-slate-50/50">
                                                                            <nav class="-mb-px flex space-x-1 sm:space-x-3 overflow-x-auto pb-1" aria-label="Tabs Modal">
                                                                                <button
                                                                                    type="button"
                                                                                    @click="activeTab = 1"
                                                                                    :class="activeTab === 1
                                                                                        ? 'border-[#007b83] text-[#007b83] bg-teal-50/80 font-bold'
                                                                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                                                                                    class="flex items-center gap-1.5 whitespace-nowrap border-b-2 px-3 py-2 text-xs rounded-t-lg transition cursor-pointer"
                                                                                >
                                                                                    <span class="flex h-4 w-4 items-center justify-center rounded-full text-[10px] font-bold"
                                                                                          :class="activeTab === 1 ? 'bg-[#007b83] text-white' : 'bg-gray-200 text-gray-700'">1</span>
                                                                                    <span>Informasi Dasar &amp; Media</span>
                                                                                </button>

                                                                                <button
                                                                                    type="button"
                                                                                    @click="activeTab = 2; $nextTick(() => { window.initIndonesianDatePickers && window.initIndonesianDatePickers($el.closest('[role=\'dialog\']') || document.body); });"
                                                                                    :class="activeTab === 2
                                                                                        ? 'border-[#007b83] text-[#007b83] bg-teal-50/80 font-bold'
                                                                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                                                                                    class="flex items-center gap-1.5 whitespace-nowrap border-b-2 px-3 py-2 text-xs rounded-t-lg transition cursor-pointer"
                                                                                >
                                                                                    <span class="flex h-4 w-4 items-center justify-center rounded-full text-[10px] font-bold"
                                                                                          :class="activeTab === 2 ? 'bg-[#007b83] text-white' : 'bg-gray-200 text-gray-700'">2</span>
                                                                                    <span>Pelaksanaan &amp; Pendaftaran</span>
                                                                                </button>

                                                                                <button
                                                                                    type="button"
                                                                                    @click="activeTab = 3"
                                                                                    :class="activeTab === 3
                                                                                        ? 'border-[#007b83] text-[#007b83] bg-teal-50/80 font-bold'
                                                                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                                                                                    class="flex items-center gap-1.5 whitespace-nowrap border-b-2 px-3 py-2 text-xs rounded-t-lg transition cursor-pointer"
                                                                                >
                                                                                    <span class="flex h-4 w-4 items-center justify-center rounded-full text-[10px] font-bold"
                                                                                          :class="activeTab === 3 ? 'bg-[#007b83] text-white' : 'bg-gray-200 text-gray-700'">3</span>
                                                                                    <span x-text="category === 'Pendidikan' ? 'Rincian Stase &amp; Syarat (01-05)' : 'Rincian Materi &amp; Syarat (01-05)'">Rincian (01-05)</span>
                                                                                </button>
                                                                            </nav>
                                                                        </div>

                                                                        <div class="min-h-0 flex-1 overflow-y-auto p-5">
                                                                            {{-- ================================================== --}}
                                                                            {{-- TAB 1: INFORMASI DASAR --}}
                                                                            {{-- ================================================== --}}
                                                                            <div x-show="activeTab === 1" class="space-y-4">
                                                                                {{-- KATEGORI DAN NAMA --}}
                                                                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                                                                    <div>
                                                                                        <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">
                                                                                            Kategori *
                                                                                        </label>
                                                                                        <select
                                                                                            name="category"
                                                                                            x-model="category"
                                                                                            required
                                                                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                                        >
                                                                                            <option value="Pendidikan">Pendidikan</option>
                                                                                            <option value="Pelatihan">Pelatihan</option>
                                                                                        </select>
                                                                                    </div>

                                                                                    <div>
                                                                                        <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">
                                                                                            Nama Program *
                                                                                        </label>
                                                                                        <input
                                                                                            type="text"
                                                                                            name="name"
                                                                                            value="{{ $program->name }}"
                                                                                            required
                                                                                            maxlength="255"
                                                                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                                        >
                                                                                    </div>
                                                                                </div>

                                                                                {{-- SATU KOLOM SAJA: DESKRIPSI SASARAN --}}
                                                                                <div>
                                                                                    <label class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">
                                                                                        Deskripsi Sasaran
                                                                                    </label>
                                                                                    <textarea
                                                                                        name="target_description"
                                                                                        x-model="targetDescriptionVal"
                                                                                        rows="2"
                                                                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                                        placeholder="Contoh: Siswa SMA/SMK dan mahasiswa hingga jenjang S1 dari berbagai bidang."
                                                                                    >{{ $program->target_description ?: $program->target }}</textarea>
                                                                                    <input type="hidden" name="target" :value="targetDescriptionVal">
                                                                                    <p class="mt-1 text-[11px] text-gray-500">
                                                                                        Teks sasaran ini akan ditampilkan di bawah judul program dan otomatis menjadi isi butir sasaran pada format standar persyaratan (poin 04).
                                                                                    </p>
                                                                                </div>

                                                                                {{-- FOTO CARD & BROSUR FLYER --}}
                                                                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 pt-1">
                                                                                    {{-- 1. FOTO CARD --}}
                                                                                    <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50/70 p-3">
                                                                                        <div class="flex items-center justify-between mb-1">
                                                                                            <label class="block text-xs font-semibold text-gray-800">Foto / Banner Card</label>
                                                                                            <span class="text-[10px] font-medium text-teal-700">Maks 1 MB &bull; Otomatis WebP</span>
                                                                                        </div>
                                                                                        <div class="relative mb-2 flex h-28 w-full items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-white">
                                                                                            <template x-if="cardPreview">
                                                                                                <div class="relative h-full w-full">
                                                                                                    <img :src="cardPreview" alt="Card" class="h-full w-full object-cover">
                                                                                                    <button type="button" @click="removeCard()" class="absolute top-1 right-1 rounded-full bg-red-600/90 p-1 text-white shadow">
                                                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </template>
                                                                                            <template x-if="!cardPreview">
                                                                                                <span class="text-[11px] text-gray-400">Belum ada foto kartu</span>
                                                                                            </template>
                                                                                        </div>
                                                                                        <input type="hidden" name="delete_image" :value="deleteCard ? '1' : '0'">
                                                                                        <input type="file" name="image" x-ref="modalCardInput" accept=".jpg,.jpeg,.png,.webp" @change="handleCardChange($event)" class="block w-full text-[11px] text-slate-500 file:mr-2 file:rounded file:border-0 file:bg-teal-50 file:px-2 file:py-1 file:text-[11px] file:font-semibold file:text-[#007b83]">
                                                                                    </div>

                                                                                    {{-- 2. BROSUR FLYER --}}
                                                                                    <div class="rounded-xl border border-dashed border-teal-300 bg-teal-50/40 p-3">
                                                                                        <div class="flex items-center justify-between mb-1">
                                                                                            <label class="block text-xs font-semibold text-teal-900">Brosur / Flyer (Opsional)</label>
                                                                                            <span class="text-[10px] font-medium text-teal-700">Maks 5 MB &bull; Otomatis WebP</span>
                                                                                        </div>
                                                                                        <div class="relative mb-2 flex h-28 w-full items-center justify-center overflow-hidden rounded-lg border border-teal-200 bg-white p-2">
                                                                                            <template x-if="imagePreview && !isPdf">
                                                                                                <div class="relative flex h-full w-full items-center justify-center">
                                                                                                    <img :src="imagePreview" alt="Brosur" class="h-full w-full object-contain">
                                                                                                    <button type="button" @click="removeImage()" class="absolute top-1 right-1 rounded-full bg-red-600/90 p-1 text-white shadow">
                                                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </template>
                                                                                            <template x-if="isPdf">
                                                                                                <div class="flex w-full items-center justify-between gap-1 p-2 bg-teal-50 rounded text-xs">
                                                                                                    <span class="truncate font-semibold text-teal-900" x-text="fileName || 'Brosur.pdf'"></span>
                                                                                                    <button type="button" @click="removeImage()" class="text-red-600 font-bold text-[10px]">Hapus</button>
                                                                                                </div>
                                                                                            </template>
                                                                                            <template x-if="!imagePreview && !isPdf">
                                                                                                <span class="text-[11px] text-gray-400">Belum ada berkas brosur</span>
                                                                                            </template>
                                                                                        </div>
                                                                                        <input type="hidden" name="remove_flyer_image" :value="deleteImage ? '1' : '0'">
                                                                                        <input type="file" name="flyer_image" x-ref="modalFileInput" accept=".pdf,.jpg,.jpeg,.png,.webp" @change="handleFileChange($event)" class="block w-full text-[11px] text-slate-500 file:mr-2 file:rounded file:border-0 file:bg-teal-100 file:px-2 file:py-1 file:text-[11px] file:font-semibold file:text-[#007b83]">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            {{-- ================================================== --}}
                                                                            {{-- TAB 2: PELAKSANAAN & PESERTA --}}
                                                                            {{-- ================================================== --}}
                                                                            <div x-show="activeTab === 2" class="space-y-4">
                                                                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                                                                    <div>
                                                                                        <label class="mb-1 block text-xs font-semibold text-gray-700">Metode Pelaksanaan</label>
                                                                                        <select name="method" x-model="method" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs">
                                                                                            <option value="">Pilih metode</option>
                                                                                            <option value="Luring" @selected($program->method === 'Luring')>Luring</option>
                                                                                            <option value="Daring" @selected($program->method === 'Daring')>Daring</option>
                                                                                            <option value="Hybrid" @selected($program->method === 'Hybrid')>Hybrid</option>
                                                                                        </select>
                                                                                    </div>

                                                                                    <div>
                                                                                        <label class="mb-1 block text-xs font-semibold text-gray-700">Lokasi</label>
                                                                                        <input type="text" name="location" x-model="location" placeholder="Contoh: RSUD R.A.A. Tjokronegoro" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs">
                                                                                    </div>
                                                                                </div>

                                                                                {{-- WAKTU PENDIDIKAN --}}
                                                                                <template x-if="category === 'Pendidikan'">
                                                                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 rounded-xl bg-blue-50/50 p-3.5 border border-blue-200">
                                                                                        <div>
                                                                                            <label class="mb-1 block text-xs font-semibold text-slate-700">Jadwal Pelaksanaan</label>
                                                                                            <input type="text" name="schedule" value="{{ $program->schedule ?: 'Sesuai pengajuan dan persetujuan rumah sakit' }}" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs">
                                                                                        </div>
                                                                                        <div>
                                                                                            <label class="mb-1 block text-xs font-semibold text-slate-700">Durasi / Periode</label>
                                                                                            <input type="text" name="duration" value="{{ $program->duration ?: 'Sesuai ketentuan program dan institusi mitra' }}" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs">
                                                                                        </div>
                                                                                    </div>
                                                                                </template>

                                                                                {{-- WAKTU PELATIHAN --}}
                                                                                <template x-if="category === 'Pelatihan'">
                                                                                    <div
                                                                                        x-init="$nextTick(() => { window.initIndonesianDatePickers && window.initIndonesianDatePickers($el); })"
                                                                                        class="space-y-3 rounded-xl bg-amber-50/50 p-3.5 border border-amber-200"
                                                                                    >
                                                                                        {{-- PILIHAN MODE DURASI TANGGAL --}}
                                                                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2.5 border-b border-amber-200/80">
                                                                                            <div>
                                                                                                <label class="block text-xs font-bold text-slate-800">
                                                                                                    Pilihan Durasi Pelaksanaan
                                                                                                </label>
                                                                                                <span class="text-[10px] text-slate-500">Pilih 1 hari (sosialisasi) atau rentang beberapa hari.</span>
                                                                                            </div>
                                                                                            <div class="inline-flex rounded-lg bg-white p-0.5 border border-amber-300 shadow-2xs text-[11px] self-start sm:self-auto">
                                                                                                <button
                                                                                                    type="button"
                                                                                                    @click="dateMode = 'single'; window.setDiklatDateMode($el, 'single');"
                                                                                                    :class="dateMode === 'single' ? 'bg-[#007b83] text-white shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                                                                                                    class="rounded-md px-2.5 py-1 transition cursor-pointer flex items-center gap-1"
                                                                                                >
                                                                                                    <span>🗓️ Cukup 1 Hari Saja</span>
                                                                                                </button>
                                                                                                <button
                                                                                                    type="button"
                                                                                                    @click="dateMode = 'range'; window.setDiklatDateMode($el, 'range');"
                                                                                                    :class="dateMode === 'range' ? 'bg-[#007b83] text-white shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                                                                                                    class="rounded-md px-2.5 py-1 transition cursor-pointer flex items-center gap-1"
                                                                                                >
                                                                                                    <span>📅 Berdurasi (Rentang Hari)</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <input type="hidden" name="date_mode" :value="dateMode">
                                                                                        </div>

                                                                                        <div class="grid grid-cols-1 gap-4" :class="dateMode === 'range' ? 'sm:grid-cols-2' : ''">
                                                                                            <div>
                                                                                                <label class="mb-1 block text-xs font-semibold text-slate-700">
                                                                                                    <span x-text="dateMode === 'single' ? 'Tanggal Pelaksanaan Pelatihan (1 Hari) *' : 'Tanggal Mulai *'"></span>
                                                                                                </label>
                                                                                                <input
                                                                                                    type="date"
                                                                                                    name="start_at"
                                                                                                    x-ref="modalStartInput"
                                                                                                    value="{{ $program->start_at ? \Carbon\Carbon::parse($program->start_at)->format('Y-m-d') : '' }}"
                                                                                                    class="datetime-picker-id w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs"
                                                                                                    @input="window.handleDiklatDateChange($el)"
                                                                                                    @change="window.handleDiklatDateChange($el)"
                                                                                                >
                                                                                                <p x-show="dateMode === 'single'" class="text-[10px] text-teal-700 mt-1 flex items-center gap-1">
                                                                                                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                                                                                    Kegiatan 1 hari. Pada kartu dan halaman web otomatis tampil satu tanggal tunggal.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div x-show="dateMode === 'range'">
                                                                                                <label class="mb-1 block text-xs font-semibold text-slate-700">Tanggal Selesai *</label>
                                                                                                <input
                                                                                                    type="date"
                                                                                                    name="end_at"
                                                                                                    x-ref="modalEndInput"
                                                                                                    value="{{ $program->end_at ? \Carbon\Carbon::parse($program->end_at)->format('Y-m-d') : '' }}"
                                                                                                    placeholder="Pilih tanggal selesai"
                                                                                                    class="datetime-picker-id w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs"
                                                                                                    @input="window.handleDiklatDateChange($el)"
                                                                                                    @change="window.handleDiklatDateChange($el)"
                                                                                                >
                                                                                            </div>
                                                                                        </div>
                                                                                        <div>
                                                                                            <label class="mb-1 block text-xs font-semibold text-slate-700">Durasi / Periode (Opsional)</label>
                                                                                            <input
                                                                                                type="text"
                                                                                                name="duration"
                                                                                                x-ref="modalDurationInput"
                                                                                                value="{{ $program->duration }}"
                                                                                                placeholder="Contoh: 3 Hari / 24 JPL"
                                                                                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs"
                                                                                            >
                                                                                            <span class="text-[10px] text-gray-400 mt-0.5 block">Jika kosong, dihitung otomatis dari tanggal.</span>
                                                                                        </div>
                                                                                        <div>
                                                                                            <label class="mb-1 block text-xs font-semibold text-slate-700">Keterangan (Opsional)</label>
                                                                                            <textarea
                                                                                                name="schedule"
                                                                                                rows="3"
                                                                                                placeholder="Contoh: Pukul 08.00 - 15.30 WIB, membawa laptop pribadi, atau catatan penting lainnya..."
                                                                                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs leading-relaxed"
                                                                                            >{{ $program->schedule }}</textarea>
                                                                                            <span class="text-[10px] text-gray-400 mt-0.5 block">Dapat diisi jam acara, perlengkapan yang perlu dibawa, waktu sesi, atau catatan penting lainnya bagi peserta.</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </template>

                                                                                {{-- REGISTRASI & PESERTA --}}
                                                                                <template x-if="category === 'Pendidikan'">
                                                                                    <div class="hidden">
                                                                                        <input type="hidden" name="requires_registration" value="1">
                                                                                        <input type="hidden" name="is_paid" value="0">
                                                                                    </div>
                                                                                </template>

                                                                                <template x-if="category === 'Pelatihan'">
                                                                                    <div class="space-y-4 pt-1">
                                                                                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                                                                            <div>
                                                                                                <label class="mb-1 block text-xs font-semibold text-gray-700">Sasaran Peserta</label>
                                                                                                <select name="participant_target" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs">
                                                                                                    <option value="publik" @selected($program->participant_target === 'publik')>Publik / Umum</option>
                                                                                                    <option value="internal" @selected($program->participant_target === 'internal')>Internal RSUD</option>
                                                                                                    <option value="keduanya" @selected($program->participant_target === 'keduanya')>Publik &amp; Internal</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div>
                                                                                                <label class="mb-1 block text-xs font-semibold text-gray-700">Pendaftaran Peserta *</label>
                                                                                                <select name="requires_registration" x-model="requiresRegistration" @change="if (requiresRegistration === '0') { isPaid = '0'; }" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs">
                                                                                                    <option value="1">Perlu pendaftaran online</option>
                                                                                                    <option value="0">Tidak perlu pendaftaran</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                        {{-- KUOTA & STATUS --}}
                                                                                        <div x-show="requiresRegistration === '1'" class="grid grid-cols-1 gap-3 sm:grid-cols-3 rounded-xl bg-slate-50 p-3.5 border border-slate-200">
                                                                                            <div>
                                                                                                <label class="mb-1 block text-xs font-semibold text-gray-700">Kuota Total *</label>
                                                                                                <input type="number" name="quota" x-model.number="quotaVal" value="{{ $program->quota }}" min="0" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs">
                                                                                            </div>
                                                                                            <div>
                                                                                                <label class="mb-1 block text-xs font-semibold text-gray-700">Sisa Kuota</label>
                                                                                                <input type="number" readonly :value="Math.max(0, (quotaVal || 0) - registeredTotal)" class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-xs text-gray-500 cursor-not-allowed">
                                                                                            </div>
                                                                                            <div>
                                                                                                <label class="mb-1 block text-xs font-semibold text-gray-700">Status Pendaftaran *</label>
                                                                                                <select name="status" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs">
                                                                                                    @foreach (['dibuka' => 'Dibuka', 'terbatas' => 'Kuota terbatas', 'penuh' => 'Kuota penuh', 'ditutup' => 'Ditutup'] as $value => $label)
                                                                                                        <option value="{{ $value }}" @selected($program->status === $value)>{{ $label }}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                        {{-- BIAYA KEGIATAN --}}
                                                                                        <template x-if="requiresRegistration === '0'">
                                                                                            <input type="hidden" name="is_paid" value="0">
                                                                                        </template>

                                                                                        <div x-show="requiresRegistration === '1'" class="rounded-xl border border-gray-200 p-3.5 space-y-3">
                                                                                            <div>
                                                                                                <label class="mb-1 block text-xs font-semibold text-gray-700">Biaya Partisipasi</label>
                                                                                                <select name="is_paid" x-model="isPaid" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs">
                                                                                                    <option value="0">Gratis / Bebas Biaya</option>
                                                                                                    <option value="1">Berbayar</option>
                                                                                                </select>
                                                                                            </div>

                                                                                            <div x-show="isPaid === '1'" class="space-y-3 border-t border-gray-100 pt-3">
                                                                                                <div>
                                                                                                    <label class="mb-1 block text-xs font-semibold text-gray-700">Nominal Biaya (Rp) *</label>
                                                                                                    <input type="text" inputmode="numeric" name="fee" value="{{ $program->fee }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs">
                                                                                                </div>

                                                                                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-3 rounded-lg border border-teal-200 bg-teal-50/50 p-3">
                                                                                                    <div>
                                                                                                        <label class="mb-1 block text-[11px] font-semibold text-gray-700">Nama Bank *</label>
                                                                                                        <input type="text" name="payment_bank_name" value="{{ $program->payment_bank_name }}" class="w-full rounded border border-gray-300 px-2 py-1.5 text-xs bg-white">
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <label class="mb-1 block text-[11px] font-semibold text-gray-700">Nomor Rekening *</label>
                                                                                                        <input type="text" name="payment_account_number" value="{{ $program->payment_account_number }}" class="w-full rounded border border-gray-300 px-2 py-1.5 text-xs bg-white">
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <label class="mb-1 block text-[11px] font-semibold text-gray-700">Nama Pemilik *</label>
                                                                                                        <input type="text" name="payment_account_name" value="{{ $program->payment_account_name }}" class="w-full rounded border border-gray-300 px-2 py-1.5 text-xs bg-white">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </template>
                                                                            </div>

                                                                            {{-- ================================================== --}}
                                                                            {{-- TAB 3: RINCIAN MATERI, SYARAT & FASILITAS (01 - 05) --}}
                                                                            {{-- ================================================== --}}
                                                                            <div x-show="activeTab === 3" class="space-y-4">
                                                                                {{-- 01. DESKRIPSI --}}
                                                                                <div class="space-y-1 rounded-xl border border-gray-200 p-3.5">
                                                                                    <div class="flex items-center justify-between gap-2">
                                                                                        <label class="text-xs font-bold text-slate-800" x-text="category === 'Pendidikan' ? '01. Deskripsi & Gambaran Program Pendidikan' : '01. Deskripsi & Latar Belakang Pelatihan'">
                                                                                            01. Deskripsi &amp; Gambaran Program
                                                                                        </label>
                                                                                        <button type="button" @click="fillDefault('description')" class="rounded bg-teal-50 px-2 py-0.5 text-[11px] font-bold text-[#007b83] hover:bg-teal-100 border border-teal-200">
                                                                                            ✨ Format Standar
                                                                                        </button>
                                                                                    </div>
                                                                                    <textarea name="description" x-model="descriptionVal" rows="3" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs"></textarea>
                                                                                </div>

                                                                                {{-- 02. TUJUAN --}}
                                                                                <div class="space-y-1 rounded-xl border border-gray-200 p-3.5">
                                                                                    <div class="flex items-center justify-between gap-2">
                                                                                        <label class="text-xs font-bold text-slate-800" x-text="category === 'Pendidikan' ? '02. Tujuan & Capaian Pembelajaran' : '02. Tujuan Pelatihan & Kompetensi'">
                                                                                            02. Tujuan &amp; Capaian Kompetensi
                                                                                        </label>
                                                                                        <button type="button" @click="fillDefault('objectives')" class="rounded bg-teal-50 px-2 py-0.5 text-[11px] font-bold text-[#007b83] hover:bg-teal-100 border border-teal-200">
                                                                                            ✨ Format Standar
                                                                                        </button>
                                                                                    </div>
                                                                                    <span class="text-[10px] text-gray-400 block">1 poin per baris (tekan Enter).</span>
                                                                                    <textarea name="objectives" x-model="objectivesVal" rows="4" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs font-mono"></textarea>
                                                                                </div>

                                                                                {{-- 03. STASE / MATERI --}}
                                                                                <div class="space-y-1 rounded-xl border border-gray-200 p-3.5">
                                                                                    <div class="flex items-center justify-between gap-2">
                                                                                        <label class="text-xs font-bold text-slate-800" x-text="category === 'Pendidikan' ? '03. Ruang Lingkup Stase & Pembelajaran Klinis' : '03. Kurikulum & Materi Pelatihan'">
                                                                                            03. Ruang Lingkup Stase / Materi
                                                                                        </label>
                                                                                        <button type="button" @click="fillDefault('materials')" class="rounded bg-teal-50 px-2 py-0.5 text-[11px] font-bold text-[#007b83] hover:bg-teal-100 border border-teal-200">
                                                                                            ✨ Format Standar
                                                                                        </button>
                                                                                    </div>
                                                                                    <span class="text-[10px] text-gray-400 block">1 modul/stase per baris (tekan Enter).</span>
                                                                                    <textarea name="materials" x-model="materialsVal" rows="4" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs font-mono"></textarea>
                                                                                </div>

                                                                                {{-- 04 & 05: PERSYARATAN & FASILITAS --}}
                                                                                {{-- PENGATURAN BERKAS PERSYARATAN (KHUSUS PELATIHAN) --}}
                                                                                <template x-if="category === 'Pelatihan' && requiresRegistration === '1'">
                                                                                    <div class="rounded-xl border border-teal-200 bg-teal-50/50 p-3 space-y-2">
                                                                                        <div class="flex items-center gap-2">
                                                                                            <svg class="w-3.5 h-3.5 text-[#007b83]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                                            </svg>
                                                                                            <h4 class="text-[11px] font-bold uppercase tracking-wider text-teal-900">
                                                                                                Pengaturan Berkas Persyaratan
                                                                                            </h4>
                                                                                        </div>
                                                                                        <p class="text-[11px] text-slate-600">
                                                                                            Centang berkas yang diperlukan. Otomatis menampilkan kolom upload di pendaftaran dan syarat di web.
                                                                                        </p>
                                                                                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-3 pt-1">
                                                                                            <label class="flex items-start gap-2 rounded-lg border border-teal-200/80 bg-white p-2.5 cursor-pointer hover:border-teal-400 transition shadow-xs">
                                                                                                <input
                                                                                                    type="checkbox"
                                                                                                    name="requires_assignment_letter"
                                                                                                    value="1"
                                                                                                    class="rounded border-gray-300 text-[#007b83] focus:ring-[#007b83] mt-0.5"
                                                                                                    @checked(old('requires_assignment_letter', $program->requires_assignment_letter ?? true))
                                                                                                >
                                                                                                <div class="text-[11px]">
                                                                                                    <strong class="text-slate-800 block">Surat Tugas</strong>
                                                                                                    <span class="text-slate-500">Utusan instansi</span>
                                                                                                </div>
                                                                                            </label>

                                                                                            <label class="flex items-start gap-2 rounded-lg border border-teal-200/80 bg-white p-2.5 cursor-pointer hover:border-teal-400 transition shadow-xs">
                                                                                                <input
                                                                                                    type="checkbox"
                                                                                                    name="requires_str_file"
                                                                                                    value="1"
                                                                                                    class="rounded border-gray-300 text-[#007b83] focus:ring-[#007b83] mt-0.5"
                                                                                                    @checked(old('requires_str_file', $program->requires_str_file ?? false))
                                                                                                >
                                                                                                <div class="text-[11px]">
                                                                                                    <strong class="text-slate-800 block">Scan STR</strong>
                                                                                                    <span class="text-slate-500">STR nakes</span>
                                                                                                </div>
                                                                                            </label>

                                                                                            <label class="flex items-start gap-2 rounded-lg border border-teal-200/80 bg-white p-2.5 cursor-pointer hover:border-teal-400 transition shadow-xs">
                                                                                                <input
                                                                                                    type="checkbox"
                                                                                                    name="requires_id_photo"
                                                                                                    value="1"
                                                                                                    class="rounded border-gray-300 text-[#007b83] focus:ring-[#007b83] mt-0.5"
                                                                                                    @checked(old('requires_id_photo', $program->requires_id_photo ?? false))
                                                                                                >
                                                                                                <div class="text-[11px]">
                                                                                                    <strong class="text-slate-800 block">Pas Foto</strong>
                                                                                                    <span class="text-slate-500">Foto formal</span>
                                                                                                </div>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </template>

                                                                                {{-- 04. PERSYARATAN --}}
                                                                                <div class="space-y-1 rounded-xl border border-gray-200 p-3.5">
                                                                                    <div class="flex items-center justify-between gap-2">
                                                                                        <label class="text-xs font-bold text-slate-800" x-text="category === 'Pendidikan' ? '04. Persyaratan Mahasiswa & Berkas Institusi (MoU)' : '04. Persyaratan Peserta & Berkas Administrasi'">
                                                                                            04. Persyaratan Peserta &amp; Berkas
                                                                                        </label>
                                                                                        <button type="button" @click="fillDefault('requirements')" class="rounded bg-teal-50 px-2 py-0.5 text-[11px] font-bold text-[#007b83] hover:bg-teal-100 border border-teal-200">
                                                                                            ✨ Format Standar
                                                                                        </button>
                                                                                    </div>
                                                                                    <span class="text-[10px] text-gray-400 block">1 syarat per baris (tekan Enter).</span>
                                                                                    <textarea name="requirements" x-model="requirementsVal" rows="4" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs font-mono"></textarea>
                                                                                </div>

                                                                                {{-- 05. FASILITAS --}}
                                                                                <div class="space-y-1 rounded-xl border border-gray-200 p-3.5">
                                                                                    <div class="flex items-center justify-between gap-2">
                                                                                        <label class="text-xs font-bold text-slate-800" x-text="category === 'Pendidikan' ? '05. Fasilitas & Pembimbingan Klinis' : '05. Fasilitas & Keuntungan Peserta'">
                                                                                            05. Fasilitas &amp; Pembimbingan Klinis
                                                                                        </label>
                                                                                        <button type="button" @click="fillDefault('facilities')" class="rounded bg-teal-50 px-2 py-0.5 text-[11px] font-bold text-[#007b83] hover:bg-teal-100 border border-teal-200">
                                                                                            ✨ Format Standar
                                                                                        </button>
                                                                                    </div>
                                                                                    <span class="text-[10px] text-gray-400 block">1 fasilitas per baris (tekan Enter).</span>
                                                                                    <textarea name="facilities" x-model="facilitiesVal" rows="4" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs font-mono"></textarea>
                                                                                </div>

                                                                                {{-- SKP & NARAHUBUNG --}}
                                                                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 pt-1">
                                                                                    <div>
                                                                                        <label class="mb-1 block text-xs font-semibold text-gray-700">Akreditasi / Bobot SKP (Opsional)</label>
                                                                                        <input type="text" name="skp_points" value="{{ $program->skp_points }}" placeholder="Contoh: 25 SKP Kemenkes RI" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs">
                                                                                    </div>
                                                                                    <div>
                                                                                        <label class="mb-1 block text-xs font-semibold text-gray-700">Narahubung / Kontak WhatsApp</label>
                                                                                        <input type="text" name="contact_person" value="{{ $program->contact_person }}" placeholder="Contoh: 0811-2856-214" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs">
                                                                                    </div>
                                                                                </div>

                                                                                {{-- STATUS PUBLIKASI --}}
                                                                                <div class="border-t border-gray-200 pt-3">
                                                                                    <label class="flex items-center gap-2 text-xs font-semibold text-gray-700 cursor-pointer">
                                                                                        <input type="checkbox" name="is_active" value="1" @checked($program->is_active) class="rounded border-gray-300 text-[#007b83] focus:ring-[#007b83]">
                                                                                        <span>Tampilkan program di halaman publik</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        {{-- FOOTER POPUP MODAL --}}
                                                                        <div class="flex shrink-0 flex-wrap items-center justify-between gap-2 border-t border-gray-200 bg-white px-5 py-3.5 dark:border-gray-700 dark:bg-gray-900">
                                                                            <div>
                                                                                <button
                                                                                    type="button"
                                                                                    x-show="activeTab > 1"
                                                                                    @click="activeTab--"
                                                                                    class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 cursor-pointer"
                                                                                >
                                                                                    ← Kembali
                                                                                </button>
                                                                            </div>

                                                                            <div class="flex items-center gap-2">
                                                                                <button
                                                                                    type="button"
                                                                                    @click="editingProgramId = null"
                                                                                    class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-600 hover:bg-gray-50 cursor-pointer"
                                                                                >
                                                                                    Batal
                                                                                </button>

                                                                                <button
                                                                                    type="button"
                                                                                    x-show="activeTab < 3"
                                                                                    @click="activeTab++"
                                                                                    class="rounded-lg bg-teal-50 border border-teal-200 px-3.5 py-1.5 text-xs font-semibold text-[#007b83] hover:bg-teal-100 cursor-pointer"
                                                                                >
                                                                                    Lanjut →
                                                                                </button>

                                                                                <button
                                                                                    type="submit"
                                                                                    class="rounded-lg bg-[#007b83] px-4 py-1.5 text-xs font-semibold text-white hover:bg-[#005b64] shadow-xs cursor-pointer"
                                                                                >
                                                                                    Simpan Perubahan
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="px-4 py-12 text-center">
                                                            <div class="flex flex-col items-center justify-center text-center p-6 text-slate-400">
                                                                <svg class="w-10 h-10 mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                                                </svg>
                                                                <span class="text-sm font-semibold text-slate-600">Belum ada program diklat yang tersimpan</span>
                                                                <span class="text-xs text-slate-400 mt-0.5">Gunakan form di atas untuk menambahkan program baru.</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    {{-- KONTEN BAGIAN 2: UNDUH BERKAS & PEDOMAN DIKLAT --}}
                    <div x-show="activeTab === 'guidelines'" x-cloak x-transition:enter.duration.200ms>
                        <section id="diklat-guidelines">
                            <div class="mb-4">
                                <h2 class="text-lg font-semibold text-[#172033] dark:text-white">
                                    Unduh Berkas &amp; Pedoman Diklat
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan dan kelola dokumen administrasi serta pedoman pendidikan maupun pelatihan.
                                </p>
                            </div>

                            {{-- FORM TAMBAH BERKAS --}}
                            <form
                                action="{{ route('admin.pages.diklat-guidelines.store', $page) }}"
                                method="POST"
                                enctype="multipart/form-data"
                                x-data="{
                                    sourceType: 'upload',
                                    filePreview: null,
                                    handleFile(event) {
                                        const file = event.target.files?.[0];
                                        if (this.filePreview?.url) {
                                            URL.revokeObjectURL(this.filePreview.url);
                                        }
                                        if (!file) {
                                            this.filePreview = null;
                                            return;
                                        }
                                        const isImg = file.type.startsWith('image/');
                                        this.filePreview = {
                                            name: file.name,
                                            isImage: isImg,
                                            url: isImg ? URL.createObjectURL(file) : null
                                        };
                                    },
                                    clearFile() {
                                        if (this.filePreview?.url) {
                                            URL.revokeObjectURL(this.filePreview.url);
                                        }
                                        this.filePreview = null;
                                        this.$refs.fileInput.value = '';
                                    }
                                }"
                                class="mb-6 space-y-4 rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900"
                            >
                                @csrf

                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    {{-- JUDUL DOKUMEN --}}
                                    <div class="md:col-span-2">
                                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                            Judul Dokumen *
                                        </label>
                                        <input
                                            type="text"
                                            name="title"
                                            required
                                            maxlength="255"
                                            placeholder="Contoh: Buku Panduan & Tata Tertib"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                        >
                                    </div>

                                    {{-- KETERANGAN --}}
                                    <div class="md:col-span-2">
                                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                            Keterangan / Subtitle
                                        </label>
                                        <input
                                            type="text"
                                            name="description"
                                            maxlength="1000"
                                            placeholder="Contoh: Pedoman program dan ketentuan peserta"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                        >
                                    </div>

                                    {{-- SUMBER FILE --}}
                                    <div class="md:col-span-2">
                                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                            Sumber Berkas / Dokumen *
                                        </label>
                                        <div class="mb-3 flex flex-wrap gap-4">
                                            <label class="flex cursor-pointer items-center gap-2">
                                                <input
                                                    type="radio"
                                                    name="source_type"
                                                    value="upload"
                                                    x-model="sourceType"
                                                >
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Upload Berkas</span>
                                            </label>

                                            <label class="flex cursor-pointer items-center gap-2">
                                                <input
                                                    type="radio"
                                                    name="source_type"
                                                    value="link"
                                                    x-model="sourceType"
                                                >
                                                <span class="text-sm text-gray-700 dark:text-gray-300">Gunakan Link (URL / Google Drive)</span>
                                            </label>
                                        </div>

                                        {{-- INPUT UPLOAD --}}
                                        <div x-show="sourceType === 'upload'">
                                            <input
                                                type="file"
                                                name="file"
                                                :disabled="sourceType !== 'upload'"
                                                x-ref="fileInput"
                                                @change="handleFile($event)"
                                                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar"
                                                class="block w-full rounded-lg border border-gray-300 p-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                            >
                                            <p class="mt-1 text-xs text-gray-500">
                                                Format didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR. Maksimal 10 MB.
                                            </p>

                                            <div x-show="filePreview" x-cloak class="mt-2 flex items-center gap-2 text-xs text-emerald-600">
                                                <span>✓ Berkas dipilih: <strong x-text="filePreview?.name"></strong></span>
                                                <button type="button" @click="clearFile()" class="text-red-500 hover:underline">Batal</button>
                                            </div>
                                        </div>

                                        {{-- INPUT LINK --}}
                                        <div x-show="sourceType === 'link'" x-cloak>
                                            <input
                                                type="text"
                                                name="external_url"
                                                :disabled="sourceType !== 'link'"
                                                placeholder="https://example.com/dokumen.pdf atau link Google Drive"
                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                            >
                                            <p class="mt-1 text-xs text-gray-500">
                                                Masukkan tautan berkas langsung atau tautan berbagi Google Drive/Cloud Storage.
                                            </p>
                                        </div>
                                    </div>

                                    {{-- TIPE/FORMAT DOKUMEN --}}
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                            Format Berkas (Label Ikon)
                                        </label>
                                        <select
                                            name="file_type"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                        >
                                            <option value="pdf">PDF</option>
                                            <option value="doc">DOC / DOCX</option>
                                            <option value="xls">XLS / XLSX</option>
                                            <option value="ppt">PPT / PPTX</option>
                                            <option value="zip">ZIP / RAR</option>
                                            <option value="link">LINK</option>
                                        </select>
                                    </div>

                                    {{-- URUTAN TAMPIL --}}
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                            Urutan Tampil
                                        </label>
                                        <input
                                            type="number"
                                            name="sort_order"
                                            value="0"
                                            min="0"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                        >
                                    </div>
                                </div>

                                {{-- CHECKBOX AKTIF --}}
                                <div class="pt-2">
                                    <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                        <input
                                            type="checkbox"
                                            name="is_active"
                                            value="1"
                                            checked
                                            class="rounded border-gray-300"
                                        >
                                        Tampilkan di halaman publik
                                    </label>
                                </div>

                                <div class="flex justify-end pt-2">
                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-[#172033] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#26344d]"
                                    >
                                        <span>+</span>
                                        <span>Tambah Berkas</span>
                                    </button>
                                </div>
                            </form>

                            {{-- DAFTAR BERKAS TERPASANG (ACCORDION) --}}
                            <div
                                x-data="{ berkasTerbuka: true }"
                                class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900"
                            >
                                <button
                                    type="button"
                                    @click="berkasTerbuka = !berkasTerbuka"
                                    class="flex w-full items-center justify-between border-b border-gray-200 bg-gray-50 px-5 py-3 text-left transition hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700/50"
                                >
                                    <div class="flex items-center gap-2">
                                        <span class="text-base">📁</span>
                                        <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                            Daftar Berkas &amp; Pedoman Diklat
                                        </span>
                                        <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-900/60 dark:text-blue-300">
                                            {{ $page->diklatGuidelines->count() }} Dokumen
                                        </span>
                                    </div>

                                    <svg
                                        class="h-4 w-4 text-gray-500 transition-transform"
                                        :class="berkasTerbuka ? 'rotate-180' : ''"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.22 7.22a.75.75 0 011.06 0L10 10.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 8.28a.75.75 0 010-1.06z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>

                                <div
                                    x-show="berkasTerbuka"
                                    x-transition
                                    class="divide-y divide-gray-100 p-3 dark:divide-gray-800"
                                >
                                    @forelse ($page->diklatGuidelines as $guideline)
                                        <div
                                            x-data="{
                                                openEdit: false,
                                                sourceType: {{ Js::from(($guideline->external_url && $guideline->external_url !== '#') ? 'link' : 'upload') }},
                                                newFile: null,
                                                handleFileChange(e) {
                                                    const f = e.target.files?.[0];
                                                    this.newFile = f ? f.name : null;
                                                }
                                            }"
                                            class="flex flex-col gap-3 rounded-lg p-3 transition hover:bg-gray-50 md:flex-row md:items-center md:justify-between dark:hover:bg-gray-800/60"
                                        >
                                            <div class="flex items-start gap-3">
                                                <span class="flex h-10 w-12 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-xs font-bold text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                                                    {{ $guideline->formatted_file_type }}
                                                </span>
                                                <div class="min-w-0">
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                            {{ $guideline->title }}
                                                        </h4>
                                                        @if ($guideline->is_active)
                                                            <span class="rounded bg-emerald-100 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                                                                Publik
                                                            </span>
                                                        @else
                                                            <span class="rounded bg-gray-100 px-2 py-0.5 text-[11px] font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                                                Draft
                                                            </span>
                                                        @endif
                                                        <span class="text-xs text-gray-400">
                                                            (Urutan: {{ $guideline->sort_order }})
                                                        </span>
                                                    </div>
                                                    @if ($guideline->description)
                                                        <p class="mt-0.5 text-xs text-gray-500">
                                                            {{ $guideline->description }}
                                                        </p>
                                                    @endif
                                                    <div class="mt-1 flex items-center gap-2 text-xs text-blue-600">
                                                        <a
                                                            href="{{ $guideline->file_path ? asset('storage/' . $guideline->file_path) : ($guideline->external_url ?? '#') }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="hover:underline inline-flex items-center gap-1"
                                                        >
                                                            <span>Cek Dokumen</span>
                                                            <span>↗</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex shrink-0 items-center gap-2 self-end md:self-center">
                                                <button
                                                    type="button"
                                                    @click="openEdit = true"
                                                    class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800"
                                                >
                                                    Edit
                                                </button>

                                                <form
                                                    action="{{ route('admin.pages.diklat-guidelines.destroy', [$page, $guideline]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Hapus berkas pedoman ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50"
                                                    >
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>

                                            {{-- POPUP EDIT BERKAS --}}
                                            <div
                                                x-cloak
                                                x-show="openEdit"
                                                x-transition.opacity
                                                @keydown.escape.window="openEdit = false"
                                                @click.self="openEdit = false"
                                                class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-black/50 p-4"
                                            >
                                                <div
                                                    x-show="openEdit"
                                                    x-transition
                                                    class="relative my-auto flex max-h-[90vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl dark:bg-gray-900"
                                                    role="dialog"
                                                    aria-modal="true"
                                                    @click.stop
                                                >
                                                    <div class="flex shrink-0 items-center justify-between border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                                                        <div>
                                                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                Edit Berkas &amp; Pedoman Diklat
                                                            </h2>
                                                            <p class="mt-1 text-sm text-gray-500">
                                                                Perbarui informasi dan dokumen.
                                                            </p>
                                                        </div>
                                                        <button
                                                            type="button"
                                                            @click="openEdit = false"
                                                            class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800"
                                                            aria-label="Tutup popup"
                                                        >
                                                            <span class="text-xl">&times;</span>
                                                        </button>
                                                    </div>

                                                    <form
                                                        action="{{ route('admin.pages.diklat-guidelines.update', [$page, $guideline]) }}"
                                                        method="POST"
                                                        enctype="multipart/form-data"
                                                        class="min-h-0 flex-1 space-y-4 overflow-y-auto p-5"
                                                    >
                                                        @csrf
                                                        @method('PUT')

                                                        <div>
                                                            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                                Judul Dokumen *
                                                            </label>
                                                            <input
                                                                type="text"
                                                                name="title"
                                                                value="{{ $guideline->title }}"
                                                                required
                                                                maxlength="255"
                                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                            >
                                                        </div>

                                                        <div>
                                                            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                                Keterangan / Subtitle
                                                            </label>
                                                            <input
                                                                type="text"
                                                                name="description"
                                                                value="{{ $guideline->description }}"
                                                                maxlength="1000"
                                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                            >
                                                        </div>

                                                        <div>
                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                                Sumber Berkas
                                                            </label>
                                                            <div class="mb-3 flex flex-wrap gap-4">
                                                                <label class="flex cursor-pointer items-center gap-2">
                                                                    <input
                                                                        type="radio"
                                                                        name="source_type"
                                                                        value="upload"
                                                                        x-model="sourceType"
                                                                    >
                                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Upload Berkas Baru</span>
                                                                </label>
                                                                <label class="flex cursor-pointer items-center gap-2">
                                                                    <input
                                                                        type="radio"
                                                                        name="source_type"
                                                                        value="link"
                                                                        x-model="sourceType"
                                                                    >
                                                                    <span class="text-sm text-gray-700 dark:text-gray-300">Gunakan Link</span>
                                                                </label>
                                                            </div>

                                                            <div x-show="sourceType === 'upload'" class="space-y-3">
                                                                {{-- TAMPILAN BERKAS SAAT INI --}}
                                                                @if ($guideline->file_path)
                                                                    <div class="rounded-xl border border-blue-200 bg-blue-50/70 p-3 dark:border-blue-900/60 dark:bg-blue-950/40">
                                                                        <p class="mb-1 text-xs font-semibold text-blue-900 dark:text-blue-200">
                                                                            Berkas Saat Ini Tersimpan:
                                                                        </p>
                                                                        <div class="flex items-center justify-between gap-3">
                                                                            <div class="flex items-center gap-2.5 min-w-0">
                                                                                <span class="flex h-8 w-10 shrink-0 items-center justify-center rounded-md bg-blue-600 text-[11px] font-bold text-white shadow-sm">
                                                                                    {{ $guideline->formatted_file_type }}
                                                                                </span>
                                                                                <div class="min-w-0">
                                                                                    <p class="truncate text-xs font-semibold text-gray-800 dark:text-gray-100" title="{{ $guideline->clean_filename }}">
                                                                                        {{ $guideline->clean_filename }}
                                                                                    </p>
                                                                                    <p class="text-[11px] text-gray-500 dark:text-gray-400">
                                                                                        Tersimpan di server ({{ strtoupper($guideline->file_type ?: 'dokumen') }})
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <a
                                                                                href="{{ $guideline->file_path ? asset('storage/' . $guideline->file_path) : ($guideline->external_url ?? '#') }}"
                                                                                target="_blank"
                                                                                rel="noopener noreferrer"
                                                                                class="shrink-0 inline-flex items-center gap-1 rounded-md bg-white px-2.5 py-1 text-xs font-medium text-blue-700 shadow-sm border border-blue-200 hover:bg-blue-50 dark:bg-gray-800 dark:border-gray-700 dark:text-blue-300"
                                                                            >
                                                                                <span>Cek</span>
                                                                                <span>↗</span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-2.5 text-xs text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                                                        Belum ada berkas fisik yang diunggah untuk dokumen ini. Silakan pilih berkas di bawah.
                                                                    </div>
                                                                @endif

                                                                {{-- INPUT BERKAS BARU --}}
                                                                <div>
                                                                    <label class="mb-1 block text-xs font-medium text-gray-700 dark:text-gray-300">
                                                                        {{ $guideline->file_path ? 'Ganti dengan Berkas Baru (Opsional)' : 'Pilih Berkas Dokumen *' }}
                                                                    </label>
                                                                    <input
                                                                        type="file"
                                                                        name="file"
                                                                        :disabled="sourceType !== 'upload'"
                                                                        @change="handleFileChange($event)"
                                                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar"
                                                                        class="block w-full rounded-lg border border-gray-300 p-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                    >
                                                                    <p class="mt-1 text-xs text-gray-500">
                                                                        {{ $guideline->file_path ? 'Kosongkan jika tetap ingin menggunakan berkas saat ini di atas.' : 'Format PDF, DOC, DOCX, XLS, XLSX, PPT, ZIP, RAR. Maksimal 10 MB.' }}
                                                                    </p>

                                                                    <div x-show="newFile" x-cloak class="mt-2 flex items-center gap-2 rounded-lg bg-emerald-50 border border-emerald-200 p-2 text-xs text-emerald-800 dark:bg-emerald-950/40 dark:border-emerald-800 dark:text-emerald-300">
                                                                        <span>✓ Berkas baru dipilih: <strong x-text="newFile"></strong></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div x-show="sourceType === 'link'" x-cloak class="space-y-1">
                                                                <label class="mb-1 block text-xs font-medium text-gray-700 dark:text-gray-300">
                                                                    Tautan Berkas (URL Langsung atau Google Drive)
                                                                </label>
                                                                <input
                                                                    type="text"
                                                                    name="external_url"
                                                                    :disabled="sourceType !== 'link'"
                                                                    value="{{ ($guideline->external_url && $guideline->external_url !== '#') ? $guideline->external_url : '' }}"
                                                                    placeholder="https://example.com/dokumen.pdf atau link Google Drive"
                                                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                >
                                                                <p class="text-xs text-gray-500">
                                                                    Masukkan tautan berkas langsung atau tautan berbagi Google Drive/Cloud Storage.
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div>
                                                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                                    Format Berkas (Label)
                                                                </label>
                                                                <select
                                                                    name="file_type"
                                                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                >
                                                                    <option value="pdf" @selected(strtolower($guideline->file_type) === 'pdf')>PDF</option>
                                                                    <option value="doc" @selected(in_array(strtolower($guideline->file_type), ['doc', 'docx']))>DOC / DOCX</option>
                                                                    <option value="xls" @selected(in_array(strtolower($guideline->file_type), ['xls', 'xlsx']))>XLS / XLSX</option>
                                                                    <option value="ppt" @selected(in_array(strtolower($guideline->file_type), ['ppt', 'pptx']))>PPT / PPTX</option>
                                                                    <option value="zip" @selected(in_array(strtolower($guideline->file_type), ['zip', 'rar']))>ZIP / RAR</option>
                                                                    <option value="link" @selected(strtolower($guideline->file_type) === 'link')>LINK</option>
                                                                </select>
                                                            </div>

                                                            <div>
                                                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                                    Urutan Tampil
                                                                </label>
                                                                <input
                                                                    type="number"
                                                                    name="sort_order"
                                                                    value="{{ $guideline->sort_order }}"
                                                                    min="0"
                                                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                >
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                                                <input
                                                                    type="checkbox"
                                                                    name="is_active"
                                                                    value="1"
                                                                    @checked($guideline->is_active)
                                                                    class="rounded"
                                                                >
                                                                Tampilkan di halaman publik
                                                            </label>
                                                        </div>

                                                        {{-- FOOTER MODAL - PASTIKAN KANAN MEFET --}}
                                                        <div class="flex w-full items-center justify-end border-t border-gray-200 pt-4 dark:border-gray-700">
                                                            <div class="ml-auto flex items-center gap-2">
                                                                <button
                                                                    type="button"
                                                                    @click="openEdit = false"
                                                                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800"
                                                                >
                                                                    Batal
                                                                </button>

                                                                <button
                                                                    type="submit"
                                                                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                                                                >
                                                                    Simpan Perubahan
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="py-6 text-center text-sm text-gray-500">
                                            Belum ada berkas atau pedoman yang ditambahkan.
                                        </p>
                                    @endforelse
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            @endif

                   
                    {{-- DOKUMENTASI PENDIDIKAN & PELATIHAN --}}
                    @if ($page->slug === 'dokumentasi')
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <div class="mb-4">
                                <h2 class="text-lg font-semibold text-[#172033] dark:text-white">
                                    Dokumentasi Pendidikan & Pelatihan
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan foto dan informasi kegiatan Diklat rumah sakit.
                                </p>
                            </div>

                            @php
                                $documentationToEdit = $diklatDocumentations->firstWhere(
                                    'id',
                                    request('edit_dokumentasi')
                                );
                            @endphp

                            {{-- FORM TAMBAH DOKUMENTASI --}}
                            <form
                                action="{{ route('admin.pages.diklat-documentations.store', $page) }}"
                                method="POST"
                                enctype="multipart/form-data"
                                x-data="{
                                    newPhotos: [],

                                    handlePhotoSelection(event) {
                                        const newFiles = Array.from(event.target.files || []);

                                        newFiles.forEach((file) => {
                                            // Hindari menambahkan file yang sama dua kali
                                            const alreadyExists = this.newPhotos.some(photo =>
                                                photo.name === file.name &&
                                                photo.file.size === file.size &&
                                                photo.file.lastModified === file.lastModified
                                            );

                                            if (!alreadyExists) {
                                                this.newPhotos.push({
                                                    id: Date.now() + '-' + Math.random(),
                                                    file: file,
                                                    name: file.name,
                                                    url: URL.createObjectURL(file)
                                                });
                                            }
                                        });

                                        // Gabungkan semua foto lama dan foto baru ke input file
                                        this.updatePhotoInput();
                                    },

                                    removePhoto(index) {
                                        const photo = this.newPhotos[index];

                                        if (photo) {
                                            URL.revokeObjectURL(photo.url);
                                        }

                                        this.newPhotos.splice(index, 1);

                                        this.updatePhotoInput();
                                    },

                                    updatePhotoInput() {
                                        const transfer = new DataTransfer();

                                        this.newPhotos.forEach(photo => {
                                            transfer.items.add(photo.file);
                                        });

                                        this.$refs.photoInput.files = transfer.files;
                                    }
                                }"
                                class="space-y-4 rounded-xl border border-gray-200 bg-white p-5"
                            >
                                @csrf
        
                                <div>
                                    <label for="diklat_title" class="mb-1 block text-sm font-medium">
                                        Nama Kegiatan
                                    </label>
                                    <input
                                        id="diklat_title"
                                        type="text"
                                        name="title"
                                        value="{{ old('title') }}"
                                        required
                                        maxlength="255"
                                        placeholder="Contoh: Pelatihan Bantuan Hidup Dasar"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2"
                                    >
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="diklat_category" class="mb-1 block text-sm font-medium">
                                        Kategori Kegiatan
                                    </label>
                                    <select
                                        id="diklat_category"
                                        name="category"
                                        required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2"
                                    >
                                        <option value="">Pilih kategori</option>
                                        <option value="orientasi" @selected(old('category') === 'orientasi')>
                                            Orientasi PPDS, Dokter Muda, dan Nakes
                                        </option>
                                        <option value="pelatihan" @selected(old('category') === 'pelatihan')>
                                            Pelatihan Keperawatan & Nakes
                                        </option>
                                        <option value="kunjungan" @selected(old('category') === 'kunjungan')>
                                            Studi Banding & Kunjungan Institusi
                                        </option>
                                    </select>
                                    @error('category')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="diklat_event_date" class="mb-1 block text-sm font-medium">
                                            Tanggal Kegiatan
                                        </label>
                                        <input
                                            id="diklat_event_date"
                                            type="date"
                                            name="event_date"
                                            value="{{ old('event_date') }}"
                                            required
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2"
                                        >
                                        @error('event_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="diklat_location" class="mb-1 block text-sm font-medium">
                                            Lokasi Kegiatan
                                        </label>
                                        <input
                                            id="diklat_location"
                                            type="text"
                                            name="location"
                                            value="{{ old('location') }}"
                                            required
                                            maxlength="255"
                                            placeholder="Contoh: Aula RSUD"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2"
                                        >
                                        @error('location')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="diklat_photos"
                                        class="block text-sm font-medium text-gray-700">
                                        Foto Kegiatan
                                    </label>

                                    <input
                                        id="diklat_photos"
                                        type="file"
                                        name="photos[]"
                                        accept=".jpg,.jpeg,.png,.webp"
                                        multiple
                                        required
                                        x-ref="photoInput"
                                        @change="handlePhotoSelection($event)"
                                        class="block w-full rounded-lg border border-gray-300 p-2 text-sm"
                                    />

                                    {{-- PREVIEW FOTO --}}
                                    <div
                                        x-show="newPhotos.length > 0"
                                        x-cloak
                                        class="mt-4"
                                    >
                                        <div class="mb-2 flex items-center justify-between">
                                            <p class="text-sm font-semibold text-gray-700">
                                                Preview Foto Terpilih
                                            </p>

                                            <span
                                                class="text-xs text-gray-500"
                                                x-text="newPhotos.length + ' foto dipilih'"
                                            ></span>
                                        </div>

                                        {{-- PREVIEW HORIZONTAL --}}
                                        <div class="flex gap-3 overflow-x-auto pb-3">
                                            <template x-for="(photo, index) in newPhotos" :key="photo.id">
                                                <div class="relative w-36 shrink-0 overflow-hidden rounded-xl border border-gray-200 bg-white">

                                                    <img
                                                        :src="photo.url"
                                                        :alt="photo.name"
                                                        class="h-28 w-full object-cover"
                                                    >

                                                    {{-- TOMBOL HAPUS --}}
                                                    <button
                                                        type="button"
                                                        @click="removePhoto(index)"
                                                        class="absolute right-2 top-2 flex h-7 w-7 items-center justify-center rounded-full bg-red-600 text-lg font-bold text-white shadow transition hover:bg-red-700"
                                                        title="Hapus foto"
                                                        aria-label="Hapus foto"
                                                    >
                                                        &times;
                                                    </button>

                                                    <div class="p-2">
                                                        <p
                                                            x-text="photo.name"
                                                            class="truncate text-xs text-gray-600"
                                                            :title="photo.name"
                                                        ></p>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                        <p class="text-xs text-gray-400">
                                            Geser ke kanan untuk melihat foto lainnya.
                                        </p>
                                    </div>
                                    @error('photos')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    @error('photos.*')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="diklat_description" class="mb-1 block text-sm font-medium">
                                        Keterangan (opsional)
                                    </label>
                                    <textarea
                                        id="diklat_description"
                                        name="description"
                                        rows="3"
                                        maxlength="2000"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2"
                                        placeholder="Keterangan singkat kegiatan"
                                    >{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                        <input
                                            type="checkbox"
                                            name="is_active"
                                            value="1"
                                            @checked(old('is_active', '1') == '1')
                                            class="rounded border-gray-300"
                                        >
                                        Tampilkan di halaman publik
                                    </label>
                                </div>

                                <button
                                    type="submit"
                                    x-data="{ mengirim: false }"
                                    @click="if (mengirim) { $event.preventDefault(); } else { mengirim = true; }"
                                    class="rounded-lg bg-[#007b83] px-4 py-2 text-sm font-semibold text-white hover:bg-[#006b72]"
                                >
                                    <span x-show="!mengirim">Tambahkan Dokumentasi</span>
                                    <span x-show="mengirim">Menyimpan...</span>
                                </button>
                            </form>

                            
                            {{-- DAFTAR DOKUMENTASI ACCORDION --}}
                            <div class="mt-6"
                                x-data="{ kategoriAktif: 'orientasi' }">

                                @php
                                    $kategoriDokumentasi = [
                                        'orientasi' => 'Orientasi PPDS, Dokter Muda, dan Nakes',
                                        'pelatihan' => 'Pelatihan Keperawatan & Nakes',
                                        'kunjungan' => 'Studi Banding & Kunjungan Institusi',
                                    ];
                                @endphp

                                <div class="mb-3 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold text-[#172033] dark:text-white">
                                        Dokumentasi Tersimpan
                                    </h3>
                                    <span class="text-xs text-gray-500">
                                        {{ $diklatDocumentations->count() }} kegiatan
                                    </span>
                                </div>

                                <div class="space-y-3">
                                    @foreach ($kategoriDokumentasi as $kategori => $judulKategori)
                                        @php
                                            $daftarKategori = $diklatDocumentations
                                                ->where('category', $kategori)
                                                ->values();
                                        @endphp

                                        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">

                                            {{-- JUDUL ACCORDION --}}
                                            <button
                                                type="button"
                                                @click="kategoriAktif = kategoriAktif === '{{ $kategori }}' ? null : '{{ $kategori }}'"
                                                class="flex w-full items-center justify-between gap-3 px-4 py-3 text-left transition hover:bg-gray-50 dark:hover:bg-gray-800"
                                            >
                                                <span class="flex min-w-0 items-center gap-2">
                                                    <span class="font-semibold text-sm text-gray-800 dark:text-white">
                                                        {{ $judulKategori }}
                                                    </span>
                                                </span>

                                                <span class="flex shrink-0 items-center gap-3">
                                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs text-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                                        {{ $daftarKategori->count() }}
                                                    </span>

                                                    <svg
                                                        class="h-4 w-4 text-gray-500 transition-transform"
                                                        :class="kategoriAktif === '{{ $kategori }}' ? 'rotate-180' : ''"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        aria-hidden="true"
                                                    >
                                                        <path fill-rule="evenodd"
                                                            d="M5.22 7.22a.75.75 0 011.06 0L10 10.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 8.28a.75.75 0 010-1.06z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </button>

                                            {{-- ISI KATEGORI --}}
                                            <div
                                                x-cloak
                                                x-show="kategoriAktif === '{{ $kategori }}'"
                                                x-transition
                                                class="border-t border-gray-200 p-3 dark:border-gray-700"
                                            >
                                                <div class="max-h-[340px] space-y-3 overflow-y-auto pr-1">
                                                    @forelse ($daftarKategori as $documentation)
                                                        <div class="flex flex-col gap-3 rounded-lg border border-gray-200 p-3 sm:flex-row dark:border-gray-700">

                                                            {{-- GAMBAR TETAP TERLIHAT --}}
                                                            <img
                                                                src="{{ asset('storage/' . $documentation->image_path) }}"
                                                                alt="{{ $documentation->title }}"
                                                                class="h-28 w-full shrink-0 rounded-lg object-cover sm:w-36"
                                                            >

                                                            <div class="flex min-w-0 flex-1 items-start justify-between gap-3">
                                                                <div class="min-w-0 flex-1">
                                                                    <div class="flex flex-wrap items-center gap-2">
                                                                        <p class="font-semibold text-sm text-gray-800 dark:text-white">
                                                                            {{ $documentation->title }}
                                                                        </p>

                                                                        <span class="rounded-full px-2.5 py-0.5 text-xs
                                                                            {{ $documentation->is_active
                                                                                ? 'bg-green-100 text-green-700'
                                                                                : 'bg-gray-100 text-gray-600' }}">
                                                                            {{ $documentation->is_active ? 'Aktif' : 'Nonaktif' }}
                                                                        </span>
                                                                    </div>

                                                                    <p class="mt-1 text-xs text-gray-500">
                                                                        {{ $documentation->event_date->format('d/m/Y') }}
                                                                        &bull;
                                                                        {{ $documentation->location }}
                                                                    </p>

                                                                    @if ($documentation->description)
                                                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                                                            {{ $documentation->description }}
                                                                        </p>
                                                                    @endif
                                                                </div>

                                                                <div class="flex shrink-0 items-center gap-2">
                                                                    <button
                                                                        type="button"
                                                                        @click="$dispatch('edit-dokumentasi', {
                                                                            id: {{ $documentation->id }},
                                                                            title: {{ Js::from($documentation->title) }},
                                                                            category: {{ Js::from($documentation->category) }},
                                                                            event_date: {{ Js::from($documentation->event_date->format('Y-m-d')) }},
                                                                            location: {{ Js::from($documentation->location) }},
                                                                            description: {{ Js::from($documentation->description ?? '') }},
                                                                            is_active: {{ Js::from((bool) $documentation->is_active) }},
                                                                            image: {{ Js::from(asset('storage/' . $documentation->image_path)) }},
                                                                            photos: {{ Js::from(
                                                                                $documentation->photos
                                                                                    ->map(fn ($photo) => [
                                                                                        'id' => $photo->id,
                                                                                        'url' => asset('storage/' . $photo->image_path),
                                                                                    ])
                                                                                    ->values()
                                                                                    ->all()
                                                                            ) }},
                                                                            update_url: {{ Js::from(route('admin.pages.diklat-documentations.update', [$page, $documentation])) }},
                                                                            delete_url: {{ Js::from(route('admin.pages.diklat-documentations.destroy', [$page, $documentation])) }}
                                                                        })"
                                                                        class="inline-flex items-center rounded-lg border border-blue-200 px-3 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-50"
                                                                    >
                                                                        Edit
                                                                    </button>

                                                                    <form
                                                                        action="{{ route('admin.pages.diklat-documentations.destroy', [$page, $documentation]) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')"
                                                                    >
                                                                        @csrf
                                                                        @method('DELETE')

                                                                        <button
                                                                            type="submit"
                                                                            class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50"
                                                                        >
                                                                            Hapus
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p class="rounded-lg bg-gray-50 p-4 text-sm text-gray-500 dark:bg-gray-800">
                                                            Belum ada dokumentasi dalam kategori ini.
                                                        </p>
                                                    @endforelse
                                                </div>  
                                            </div>
                                        </section>
                                    @endforeach
                                </div>
                            </div>

                          
                            {{-- POPUP EDIT DOKUMENTASI --}}
                            <div
                                x-data=                                
                                "{
                                    terbuka: false,
                                    item: {},
                                    fotoPreview: '',
                                    daftarFoto: [],
                                    fotoAktif: 0,
                                    fotoTambahanBaru: [],
                                    urlFotoSementara: [],
                                    fotoDihapus: [],
                                    showDeleteConfirm: false,

                                    buka(data) {
                                        this.bersihkanPreviewSementara();

                                        this.item = { ...data };
                                        this.fotoDihapus = [];

                                        const fotoUtama = data.image;

                                        this.daftarFoto = [];

                                        if (fotoUtama) {
                                            this.daftarFoto.push({
                                                src: typeof fotoUtama === 'object'
                                                    ? (fotoUtama.url || fotoUtama.src || '')
                                                    : fotoUtama,
                                                type: 'cover',
                                                id: null
                                            });
                                        }

                                        (data.photos || []).forEach(foto => {
                                            const src = typeof foto === 'object'
                                                ? (foto.url || foto.src || foto.image_url || '')
                                                : foto;

                                            if (!src) return;

                                            const id = typeof foto === 'object'
                                                ? (foto.id ?? null)
                                                : null;

                                            const sudahAda = this.daftarFoto.some(item => item.src === src);

                                            if (!sudahAda) {
                                                this.daftarFoto.push({
                                                    src,
                                                    type: 'gallery',
                                                    id
                                                });
                                            }
                                        });

                                        this.fotoTambahanBaru = [];
                                        this.fotoAktif = 0;
                                        this.fotoPreview = this.daftarFoto[0]?.src || '';
                                        this.showDeleteConfirm = false;
                                        this.terbuka = true;
                                    },

                                    pilihFoto(index) {
                                        this.fotoAktif = index;
                                        this.fotoPreview = this.daftarFoto[index]?.src || '';
                                    },

                                    pilihFotoUtama(event) {
                                        const file = event.target.files?.[0];
                                        if (!file) return;

                                        const fotoLama = this.daftarFoto.find(foto => foto.type === 'cover');

                                        if (fotoLama?.src?.startsWith('blob:')) {
                                            URL.revokeObjectURL(fotoLama.src);
                                            this.urlFotoSementara =
                                                this.urlFotoSementara.filter(url => url !== fotoLama.src);
                                        }

                                        const url = URL.createObjectURL(file);
                                        this.urlFotoSementara.push(url);

                                        if (fotoLama) {
                                            fotoLama.src = url;
                                        } else {
                                            this.daftarFoto.unshift({
                                                src: url,
                                                type: 'cover',
                                                id: null
                                            });
                                        }

                                        this.fotoAktif = this.daftarFoto.findIndex(foto => foto.type === 'cover');
                                        this.fotoPreview = url;
                                    },

                                    pilihFotoTambahan(event) {
                                        const files = Array.from(event.target.files || []);

                                        if (!files.length) return;

                                        // Ambil foto tambahan yang sudah dipilih sebelumnya.
                                        const fotoSebelumnya = [...this.fotoTambahanBaru];

                                        // Tambahkan foto baru tanpa menghapus pilihan sebelumnya.
                                        files.forEach(file => {
                                            const sudahAda = fotoSebelumnya.some(foto =>
                                                foto.name === file.name &&
                                                foto.file.size === file.size &&
                                                foto.file.lastModified === file.lastModified
                                            );

                                            if (sudahAda) return;

                                            const url = URL.createObjectURL(file);
                                            this.urlFotoSementara.push(url);

                                            fotoSebelumnya.push({
                                                file: file,
                                                url: url,
                                                name: file.name
                                            });
                                        });

                                        // Simpan semua foto tambahan.
                                        this.fotoTambahanBaru = fotoSebelumnya;

                                        // Pertahankan foto lama di preview.
                                        const fotoLama = this.daftarFoto.filter(
                                            foto => foto.type !== 'new'
                                        );

                                        // Gabungkan semua foto baru, termasuk pilihan sebelumnya.
                                        const fotoBaru = this.fotoTambahanBaru.map(foto => ({
                                            src: foto.url,
                                            type: 'new',
                                            id: null,
                                            name: foto.name
                                        }));

                                        this.daftarFoto = [...fotoLama, ...fotoBaru];

                                        // Pastikan semua file ikut terkirim saat Simpan Perubahan.
                                        const transfer = new DataTransfer();

                                        this.fotoTambahanBaru.forEach(foto => {
                                            transfer.items.add(foto.file);
                                        });

                                        this.$refs.galleryInput.files = transfer.files;

                                        // Tampilkan foto tambahan terakhir yang dipilih.
                                        if (fotoBaru.length > 0) {
                                            this.fotoAktif = this.daftarFoto.length - 1;
                                        }

                                        this.fotoPreview = this.daftarFoto[this.fotoAktif]?.src || '';
                                    },

                                    bersihkanFotoTambahanBaru() {
                                        this.fotoTambahanBaru.forEach(foto => {
                                            URL.revokeObjectURL(foto.url);
                                            this.urlFotoSementara =
                                                this.urlFotoSementara.filter(url => url !== foto.url);
                                        });

                                        this.fotoTambahanBaru = [];
                                    },

                                    hapusFotoTerpilih() {
                                        const foto = this.daftarFoto[this.fotoAktif];
                                        if (!foto) return;

                                        if (foto.type === 'gallery' && foto.id) {
                                            this.fotoDihapus.push(foto.id);
                                        }

                                        if (foto.type === 'new') {
                                            const index = this.fotoTambahanBaru.findIndex(
                                                item => item.url === foto.src
                                            );

                                            if (index !== -1) {
                                                this.fotoTambahanBaru.splice(index, 1);
                                            }

                                            URL.revokeObjectURL(foto.src);
                                            this.urlFotoSementara =
                                                this.urlFotoSementara.filter(url => url !== foto.src);

                                            const transfer = new DataTransfer();
                                            this.fotoTambahanBaru.forEach(item => {
                                                transfer.items.add(item.file);
                                            });

                                            this.$refs.galleryInput.files = transfer.files;
                                        }

                                        this.daftarFoto.splice(this.fotoAktif, 1);

                                        this.fotoAktif = Math.max(
                                            0,
                                            Math.min(this.fotoAktif, this.daftarFoto.length - 1)
                                        );

                                        this.fotoPreview = this.daftarFoto[this.fotoAktif]?.src || '';
                                        this.showDeleteConfirm = false;
                                    },

                                    bersihkanPreviewSementara() {
                                        this.urlFotoSementara.forEach(url => URL.revokeObjectURL(url));
                                        this.urlFotoSementara = [];
                                        this.fotoTambahanBaru = [];
                                    },

                                    tutup() {
                                        this.terbuka = false;
                                        this.showDeleteConfirm = false;
                                        this.bersihkanPreviewSementara();
                                    }
                                }"

                                @edit-dokumentasi.window="buka($event.detail)"
                                @keydown.escape.window="tutup()"
                            >
                                {{-- OVERLAY --}}
                                <div
                                    x-cloak
                                    x-show="terbuka"
                                    x-transition.opacity
                                    class="fixed inset-0 z-[9999] flex items-center justify-center overflow-y-auto bg-black/60 p-4"
                                    @click.self="tutup()"
                                >
                                    {{-- KOTAK MODAL --}}
                                    <div
                                        x-show="terbuka"
                                        x-transition
                                        class="my-auto max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl dark:bg-gray-900"
                                        @click.stop
                                    >
                                        {{-- HEADER --}}
                                        <div class="sticky top-0 z-20 flex items-center justify-between border-b border-gray-200 bg-white px-5 py-4 dark:border-gray-700 dark:bg-gray-900">
                                            <div>
                                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    Edit Dokumentasi
                                                </h2>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    Perbarui informasi dan foto kegiatan.
                                                </p>
                                            </div>

                                            <button
                                                type="button"
                                                @click="tutup()"
                                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800"
                                                aria-label="Tutup popup"
                                            >
                                                <span class="text-xl">&times;</span>
                                            </button>

                                        </div>

                                        {{-- FORM EDIT --}}
                                        <form
                                            :action="item.update_url"
                                            method="POST"
                                            enctype="multipart/form-data"
                                            class="space-y-5 p-5"
                                        >
                                            @csrf
                                            @method('PUT')

                                            
                                        {{-- FOTO KEGIATAN --}}
                                        <div>
                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                Foto Kegiatan
                                            </label>

                                            <div class="relative mb-3 flex h-52 items-center justify-center overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800">
                                                <template x-if="fotoPreview">
                                                    <img
                                                        :src="fotoPreview"
                                                        alt="Preview foto dokumentasi"
                                                        class="h-full w-full object-contain"
                                                    >
                                                </template>

                                                <template x-if="!fotoPreview">
                                                    <p class="text-sm text-gray-500">Belum ada foto.</p>
                                                </template>

                                                {{-- TOMBOL SILANG --}}
                                                <button
                                                    x-cloak
                                                    x-show="fotoPreview && daftarFoto[fotoAktif]?.type !== 'cover'"
                                                    type="button"
                                                    @click.stop="showDeleteConfirm = true"
                                                    class="absolute right-3 top-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-red-600 text-xl font-bold text-white shadow-lg hover:bg-red-700"
                                                    aria-label="Hapus foto"
                                                >
                                                    &times;
                                                </button>

                                                <span
                                                    x-show="fotoPreview"
                                                    class="absolute bottom-2 right-2 rounded-full bg-black/70 px-3 py-1 text-xs text-white"
                                                >
                                                    Foto <span x-text="fotoAktif + 1"></span>
                                                    dari <span x-text="daftarFoto.length"></span>
                                                </span>

                                                {{-- KONFIRMASI HAPUS DI TENGAH GAMBAR --}}
                                                <div
                                                    x-cloak
                                                    x-show="showDeleteConfirm"
                                                    x-transition.opacity
                                                    @click.self="showDeleteConfirm = false"
                                                    class="absolute inset-0 z-20 flex items-center justify-center bg-black/60 p-4"
                                                >
                                                    <div
                                                        class="w-full max-w-sm rounded-xl bg-white p-5 shadow-2xl dark:bg-gray-900"
                                                        role="alertdialog"
                                                        aria-modal="true"
                                                    >
                                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                            Hapus foto ini?
                                                        </h3>

                                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                                            Foto akan dihapus setelah kamu menekan Simpan Perubahan.
                                                        </p>

                                                        <div class="mt-5 flex justify-end gap-2">
                                                            <button
                                                                type="button"
                                                                @click="showDeleteConfirm = false"
                                                                class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 dark:border-gray-600 dark:text-gray-200"
                                                            >
                                                                Batal
                                                            </button>

                                                            <button
                                                                type="button"
                                                                @click="hapusFotoTerpilih()"
                                                                class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                                            >
                                                                Ya, Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- THUMBNAIL --}}
                                            <div
                                                x-show="daftarFoto.length > 0"
                                                class="flex gap-3 overflow-x-auto pb-3"
                                            >
                                                <template x-for="(foto, index) in daftarFoto" :key="foto.src + '-' + index">
                                                    <button
                                                        type="button"
                                                        @click="pilihFoto(index)"
                                                        class="relative shrink-0 overflow-hidden rounded-lg border-2"
                                                        :class="fotoAktif === index ? 'border-blue-600' : 'border-transparent'"
                                                        :aria-label="'Pilih foto ' + (index + 1)"
                                                    >
                                                        <img
                                                            :src="foto.src"
                                                            alt=""
                                                            class="h-20 w-28 object-cover"
                                                        >
                                                    </button>
                                                </template>
                                            </div>

                                            <template x-for="(id, index) in fotoDihapus" :key="id + '-' + index">
                                                <input type="hidden" name="delete_photos[]" :value="id">
                                            </template>
                                        </div>


                                            {{-- INPUT FOTO SEJAJAR KANAN-KIRI --}}
                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                                                {{-- GANTI FOTO UTAMA --}}
                                                <div class="min-w-0">
                                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                        Ganti Foto Utama
                                                    </label>

                                                    <input
                                                        type="file"
                                                        name="image"
                                                        accept=".jpg,.jpeg,.png,.webp"
                                                        @change="pilihFotoUtama($event)"
                                                        class="block w-full min-w-0 rounded-lg border border-gray-300 p-2 text-sm dark:border-gray-700 dark:bg-gray-800"
                                                    >

                                                    <p class="mt-2 text-xs text-gray-500">
                                                        JPG, PNG, atau WEBP, maksimal 5 MB.
                                                    </p>
                                                </div>

                                               
                                                {{-- TAMBAH FOTO DOKUMENTASI --}}
                                                <div class="min-w-0">
                                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                        Tambah Foto Dokumentasi
                                                    </label>
                                                    <input
                                                        x-ref="galleryInput"
                                                        type="file"
                                                        name="photos[]"
                                                        accept=".jpg,.jpeg,.png,.webp"
                                                        multiple
                                                        @change="pilihFotoTambahan($event)"
                                                        class="block w-full min-w-0 rounded-lg border border-gray-300 p-2 text-sm dark:border-gray-700 dark:bg-gray-800"
                                                    />
                                                    <p class="mt-2 text-xs text-gray-500">
                                                        Pilih satu atau beberapa foto tambahan. Foto akan langsung muncul di preview.
                                                        Maksimal 5 MB per foto.
                                                    </p>

                                                    @error('photos')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror

                                                    @error('photos.*')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- NAMA & KATEGORI KEGIATAN --}}
                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                                <div>
                                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                        Nama Kegiatan *
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="title"
                                                        x-model="item.title"
                                                        required
                                                        maxlength="255"
                                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                                    >
                                                </div>

                                                <div>
                                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                        Kategori Kegiatan *
                                                    </label>

                                                    <select
                                                        name="category"
                                                        x-model="item.category"
                                                        required
                                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                                    >
                                                        <option value="orientasi">Orientasi PPDS, Dokter Muda, dan Nakes</option>
                                                        <option value="pelatihan">Pelatihan Keperawatan &amp; Nakes</option>
                                                        <option value="kunjungan">Studi Banding &amp; Kunjungan Institusi</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- TANGGAL & LOKASI KEGIATAN --}}
                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                                <div>
                                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                        Tanggal Kegiatan *
                                                    </label>

                                                    <input
                                                        type="date"
                                                        name="event_date"
                                                        x-model="item.event_date"
                                                        required
                                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                                    >
                                                </div>

                                                <div>
                                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                        Lokasi Kegiatan *
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="location"
                                                        x-model="item.location"
                                                        required
                                                        maxlength="255"
                                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                                    >
                                                </div>
                                            </div>

                                            {{-- DESKRIPSI --}}
                                            <div>
                                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                    Keterangan
                                                </label>

                                                <textarea
                                                    name="description"
                                                    x-model="item.description"
                                                    rows="3"
                                                    maxlength="2000"
                                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                                ></textarea>
                                            </div>

                                            {{-- STATUS --}}
                                            <div>
                                                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                                    <input
                                                        type="checkbox"
                                                        name="is_active"
                                                        value="1"
                                                        :checked="item.is_active"
                                                        class="rounded border-gray-300"
                                                    >
                                                    Tampilkan di halaman publik
                                                </label>
                                            </div>

                                            {{-- FOOTER --}}
                                            <div class="flex w-full items-center justify-end border-t border-gray-200 pt-4 dark:border-gray-700">
                                                <div class="flex items-center gap-2 ml-auto">
                                                    <button
                                                        type="button"
                                                        @click="tutup()"
                                                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800"
                                                    >
                                                        Batal
                                                    </button>

                                                    <button
                                                        type="submit"
                                                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                                                    >
                                                        Simpan Perubahan
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        {{-- FORM HAPUS TERPISAH --}}
                                        <form
                                            id="hapus-dokumentasi-popup"
                                            :action="item.delete_url"
                                            method="POST"
                                            class="hidden"
                                        >
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    
                    {{-- FASILITAS DIKLAT --}}
                    @if ($page->slug === 'fasilitas')
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <div class="mb-5">
                                <h2 class="text-lg font-semibold text-[#172033] dark:text-white">
                                    Kelola Fasilitas Diklat
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan, ubah, atau hapus informasi fasilitas dan fotonya.
                                </p>
                            </div>

                            
                            {{-- FORM TAMBAH FASILITAS --}}
                            <form
                                action="{{ route('admin.pages.facilities.store', $page) }}"
                                method="POST"
                                enctype="multipart/form-data"
                                class="space-y-4 rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900"
                            >
                                @csrf

                                <h3 class="font-semibold text-gray-800 dark:text-white">
                                    Tambah Fasilitas
                                </h3>

                                {{-- Nama fasilitas --}}
                                <div>
                                    <label class="mb-1 block text-sm font-medium">Nama Fasilitas *</label>
                                    <input
                                        type="text"
                                        name="title"
                                        value="{{ old('title') }}"
                                        required
                                        maxlength="255"
                                        placeholder="Contoh: Studio Diklat & Multimedia"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 dark:bg-gray-800 dark:text-white"
                                    >
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Label pada gambar --}}
                                <div>
                                    <label class="mb-1 block text-sm font-medium">Label Fasilitas</label>
                                    <input
                                        type="text"
                                        name="label"
                                        value="{{ old('label') }}"
                                        maxlength="100"
                                        placeholder="Contoh: STUDIO MULTIMEDIA"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 dark:bg-gray-800 dark:text-white"
                                    >
                                    @error('label')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Keterangan singkat pada gambar --}}
                                <div>
                                    <label class="mb-1 block text-sm font-medium">Keterangan Fasilitas</label>
                                    <input
                                        type="text"
                                        name="caption"
                                        value="{{ old('caption') }}"
                                        maxlength="255"
                                        placeholder="Media pendukung pembelajaran dan dokumentasi kegiatan"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 dark:bg-gray-800 dark:text-white"
                                    >
                                    @error('caption')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Deskripsi di bawah gambar --}}
                                <div>
                                    <label class="mb-1 block text-sm font-medium">Deskripsi Fasilitas</label>
                                    <textarea
                                        name="description"
                                        rows="3"
                                        maxlength="2000"
                                        placeholder="Jelaskan fungsi dan manfaat fasilitas..."
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 dark:bg-gray-800 dark:text-white"
                                    >{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Kategori dropdown --}}
                                @php
                                    $kategoriFasilitas = [
                                        'Multimedia & Dokumentasi',
                                        'Pembelajaran & Diskusi',
                                        'Literatur & Referensi',
                                        'Fasilitas Pendukung',
                                    ];
                                @endphp

                                <div>
                                    <label class="mb-1 block text-sm font-medium">Kategori Fasilitas *</label>
                                    <select
                                        name="category"
                                        required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 dark:bg-gray-800 dark:text-white"
                                    >
                                        <option value="">Pilih kategori fasilitas</option>
                                        @foreach ($kategoriFasilitas as $kategori)
                                            <option
                                                value="{{ $kategori }}"
                                                @selected(old('category') === $kategori)
                                            >
                                                {{ $kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Foto fasilitas --}}
                                <div>
                                    <label class="mb-1 block text-sm font-medium">Foto Fasilitas</label>
                                    <input
                                        type="file"
                                        name="image"
                                        accept=".jpg,.jpeg,.png,.webp"
                                        class="block w-full rounded-lg border border-gray-300 p-2 text-sm dark:bg-gray-800"
                                    >
                                    <p class="mt-1 text-xs text-gray-500">
                                        Format JPG, PNG, atau WEBP. Maksimal 5 MB.
                                    </p>
                                    @error('image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- URL tautan --}}
                                <div>
                                    <label class="mb-1 block text-sm font-medium">URL Tautan (opsional)</label>
                                    <input
                                        type="url"
                                        name="link_url"
                                        value="{{ old('link_url') }}"
                                        placeholder="https://..."
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 dark:bg-gray-800 dark:text-white"
                                    >
                                    @error('link_url')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Teks tautan --}}
                                <div>
                                    <label class="mb-1 block text-sm font-medium">Teks Tautan (opsional)</label>
                                    <input
                                        type="text"
                                        name="link_label"
                                        value="{{ old('link_label') }}"
                                        maxlength="100"
                                        placeholder="Contoh: Lihat informasi"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 dark:bg-gray-800 dark:text-white"
                                    >
                                </div>

                                {{-- Urutan dan status --}}
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="mb-1 block text-sm font-medium">Urutan</label>
                                        <input
                                            type="number"
                                            name="sort_order"
                                            min="0"
                                            value="{{ old('sort_order', 0) }}"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 dark:bg-gray-800 dark:text-white"
                                        >
                                    </div>

                                    <label class="flex items-center gap-2 self-center text-sm">
                                        <input
                                            type="checkbox"
                                            name="is_active"
                                            value="1"
                                            @checked(old('is_active', '1') == '1')
                                            class="rounded border-gray-300"
                                        >
                                        Tampilkan di halaman publik
                                    </label>
                                </div>

                                <button
                                    type="submit"
                                    class="rounded-lg bg-[#007b83] px-4 py-2 text-sm font-semibold text-white hover:bg-[#006b72]"
                                >
                                    Tambah Fasilitas
                                </button>
                            </form>


                            {{-- DAFTAR FASILITAS --}}
                            <div
                                class="mt-7"
                                x-data="{ kategoriFasilitasAktif: 'Multimedia & Dokumentasi' }"
                            >
                                <div class="mb-3 flex items-center justify-between">
                                    <h3 class="font-semibold text-gray-800 dark:text-white">
                                        Fasilitas Tersimpan
                                    </h3>

                                    <span class="text-sm text-gray-500">
                                        {{ $facilities->count() }} fasilitas
                                    </span>
                                </div>

                                @php
                                    $kategoriFasilitas = [
                                        'Multimedia & Dokumentasi',
                                        'Pembelajaran & Diskusi',
                                        'Literatur & Referensi',
                                        'Fasilitas Pendukung',
                                    ];
                                @endphp

                                <div class="space-y-3">
                                    @foreach ($kategoriFasilitas as $kategori)
                                        @php
                                            $daftarFasilitas = $facilities
                                                ->where('category', $kategori)
                                                ->values();
                                        @endphp

                                        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">

                                            {{-- JUDUL KATEGORI --}}
                                            
                                            <button
                                                type="button"
                                                @click="kategoriFasilitasAktif = (kategoriFasilitasAktif === {{ Js::from($kategori) }} ? null : {{ Js::from($kategori) }})"
                                                class="flex w-full items-center justify-between gap-3 px-4 py-3 text-left transition hover:bg-gray-50 dark:hover:bg-gray-800"
                                            >
                                                <span class="text-sm font-semibold text-gray-800 dark:text-white">
                                                    {{ $kategori }}
                                                </span>

                                                <span class="flex shrink-0 items-center gap-3">
                                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs text-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                                        {{ $daftarFasilitas->count() }}
                                                    </span>

                                                    <svg
                                                        class="h-4 w-4 text-gray-500 transition-transform"
                                                        :class="kategoriFasilitasAktif === {{ Js::from($kategori) }} ? 'rotate-180' : ''"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        aria-hidden="true"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M5.22 7.22a.75.75 0 011.06 0L10 10.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 8.28a.75.75 0 010-1.06z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </span>
                                            </button>


                                            {{-- ISI KATEGORI --}}
                                            <div
                                                x-cloak
                                                x-show="kategoriFasilitasAktif === {{ Js::from($kategori) }}"
                                                x-transition
                                                class="border-t border-gray-200 p-3 dark:border-gray-700"
                                            >
                                                <div class="max-h-[340px] space-y-3 overflow-y-auto pr-1">

                                                    @forelse ($daftarFasilitas as $facility)
                                                        <section
                                                            x-data="{ openEdit: false }"
                                                            class="rounded-lg border border-gray-200 p-3 dark:border-gray-700"
                                                        >
                                                            {{-- INFORMASI FASILITAS --}}
                                                            <div class="flex flex-col gap-3 sm:flex-row">

                                                                @if ($facility->image_path)
                                                                    <img
                                                                        src="{{ asset('storage/' . $facility->image_path) }}"
                                                                        alt="{{ $facility->title }}"
                                                                        class="h-28 w-full shrink-0 rounded-lg object-cover sm:w-36"
                                                                    >
                                                                @else
                                                                    <div class="flex h-28 w-full shrink-0 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400 sm:w-36 dark:bg-gray-800">
                                                                        Belum ada gambar
                                                                    </div>
                                                                @endif

                                                                <div class="flex min-w-0 flex-1 items-start justify-between gap-3">
                                                                    <div class="min-w-0 flex-1">
                                                                        <div class="flex flex-wrap items-center gap-2">
                                                                            <h4 class="text-sm font-semibold text-gray-800 dark:text-white">
                                                                                {{ $facility->title }}
                                                                            </h4>

                                                                            <span class="rounded-full px-2.5 py-0.5 text-xs
                                                                                {{ $facility->is_active
                                                                                    ? 'bg-green-100 text-green-700'
                                                                                    : 'bg-gray-100 text-gray-600' }}">
                                                                                {{ $facility->is_active ? 'Aktif' : 'Nonaktif' }}
                                                                            </span>
                                                                        </div>

                                                                        @if ($facility->label)
                                                                            <p class="mt-1 text-xs text-gray-500">
                                                                                {{ $facility->label }}
                                                                            </p>
                                                                        @endif

                                                                        @if ($facility->description)
                                                                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                                                                {{ $facility->description }}
                                                                            </p>
                                                                        @endif
                                                                    </div>

                                                                    <div class="flex shrink-0 items-center gap-2">
                                                                        <button
                                                                            type="button"
                                                                            @click="openEdit = true"
                                                                            class="rounded-lg border border-blue-200 px-3 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-50"
                                                                        >
                                                                            Edit
                                                                        </button>

                                                                        <form
                                                                            action="{{ route('admin.pages.facilities.destroy', [$page, $facility]) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Yakin ingin menghapus fasilitas ini?')"
                                                                        >
                                                                            @csrf
                                                                            @method('DELETE')

                                                                            <button
                                                                                type="submit"
                                                                                class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50"
                                                                            >
                                                                                Hapus
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                                        {{-- MODAL EDIT FASILITAS --}}
                                                                        <div
                                                                            x-cloak
                                                                            x-show="openEdit"
                                                                            x-transition.opacity
                                                                            @keydown.escape.window="openEdit = false"
                                                                            @click.self="openEdit = false"
                                                                            class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-black/50 p-4"
                                                                        >
                                                                            <div
                                                                                x-show="openEdit"
                                                                                x-transition
                                                                                class="relative my-auto flex max-h-[85vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl dark:bg-gray-900"
                                                                                role="dialog"
                                                                                aria-modal="true"
                                                                                aria-label="Edit fasilitas"
                                                                            >
                                                                                <div class="flex shrink-0 items-center justify-between gap-3 border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                                                                                    <div>
                                                                                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                                            Edit Fasilitas
                                                                                        </h2>
                                                                                        <p class="mt-1 text-sm text-gray-500">
                                                                                            Perbarui informasi dan foto fasilitas.
                                                                                        </p>
                                                                                    </div>

                                                                                    <button
                                                                                        type="button"
                                                                                        @click="openEdit = false"
                                                                                        class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800"
                                                                                        aria-label="Tutup popup"
                                                                                    >
                                                                                        <span class="text-xl">&times;</span>
                                                                                    </button>
                                                                                </div>

                                                                                <div class="min-h-0 flex-1 overflow-y-auto p-5">

                                                                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                                                                    Fasilitas: <strong>{{ $facility->title }}</strong>
                                                                                </p>

                                                                                <form
                                                                                    action="{{ route('admin.pages.facilities.update', [$page, $facility]) }}"
                                                                                    method="POST"
                                                                                    enctype="multipart/form-data"
                                                                                    class="mt-5 space-y-5"
                                                                                >
                                                                                    @csrf
                                                                                    @method('PUT')

                                                                                    {{-- NAMA FASILITAS --}}
                                                                                    <div>
                                                                                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                                            Nama Fasilitas *
                                                                                        </label>
                                                                                        <input
                                                                                            type="text"
                                                                                            name="title"
                                                                                            value="{{ $facility->title }}"
                                                                                            required
                                                                                            maxlength="255"
                                                                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                                        >
                                                                                    </div>

                                                                                    {{-- LABEL FOTO --}}
                                                                                    <div>
                                                                                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                                            Label pada Foto
                                                                                        </label>
                                                                                        <input
                                                                                            type="text"
                                                                                            name="label"
                                                                                            value="{{ $facility->label }}"
                                                                                            maxlength="100"
                                                                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                                        >
                                                                                    </div>

                                                                                    {{-- DESKRIPSI --}}
                                                                                    <div>
                                                                                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                                            Deskripsi Fasilitas
                                                                                        </label>
                                                                                        <textarea
                                                                                            name="description"
                                                                                            rows="4"
                                                                                            maxlength="2000"
                                                                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                                        >{{ $facility->description }}</textarea>
                                                                                    </div>

                                                                                    {{-- KATEGORI --}}
                                                                                    <div>
                                                                                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                                            Kategori Fasilitas
                                                                                        </label>
                                                                                        <select
                                                                                            name="category"
                                                                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                                                                        >
                                                                                            <option value="">Pilih kategori</option>

                                                                                            @foreach ($kategoriFasilitas as $category)
                                                                                                <option
                                                                                                    value="{{ $category }}"
                                                                                                    @selected($facility->category === $category)
                                                                                                >
                                                                                                    {{ $category }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>

                                                                                    {{-- FOTO UTAMA DAN GALERI --}}
                                                                                    <div
                                                                                        x-data="{
                                                                                            activePhoto: 0,
                                                                                            photos: [
                                                                                                @if ($facility->image_path)
                                                                                                    {
                                                                                                        src: @js(asset('storage/' . $facility->image_path)),
                                                                                                        type: 'cover'
                                                                                                    },
                                                                                                @endif

                                                                                                @foreach ($facility->photos as $photo)
                                                                                                    {
                                                                                                        id: @js($photo->id),
                                                                                                        src: @js(asset('storage/' . $photo->image_path)),
                                                                                                        type: 'gallery'
                                                                                                    },
                                                                                                @endforeach
                                                                                            ],
                                                                                            newPhotos: [],
                                                                                            deletedPhotoIds: [],
                                                                                            showDeleteConfirm: false,

                                                                                            addPhotos(event) {
                                                                                                const files = Array.from(event.target.files || []);

                                                                                                if (!files.length) return;

                                                                                                // Pertahankan foto yang sudah dipilih sebelumnya.
                                                                                                const semuaFoto = [...this.newPhotos];

                                                                                                files.forEach(file => {
                                                                                                    const duplikat = semuaFoto.some(item =>
                                                                                                        item.name === file.name &&
                                                                                                        item.file.size === file.size &&
                                                                                                        item.file.lastModified === file.lastModified
                                                                                                    );

                                                                                                    if (duplikat) return;

                                                                                                    semuaFoto.push({
                                                                                                        file: file,
                                                                                                        name: file.name,
                                                                                                        src: URL.createObjectURL(file),
                                                                                                        type: 'new',
                                                                                                        key: Date.now() + '-' + Math.random().toString(36).slice(2)
                                                                                                    });
                                                                                                });

                                                                                                this.newPhotos = semuaFoto;

                                                                                                // Gabungkan foto lama dengan seluruh foto baru.
                                                                                                const fotoLama = this.photos.filter(
                                                                                                    photo => photo.type !== 'new'
                                                                                                );

                                                                                                this.photos = [...fotoLama, ...this.newPhotos];

                                                                                                // Pastikan seluruh foto terkirim saat Simpan Perubahan.
                                                                                                const transfer = new DataTransfer();

                                                                                                this.newPhotos.forEach(item => {
                                                                                                    transfer.items.add(item.file);
                                                                                                });

                                                                                                this.$refs.galleryInput.files = transfer.files;

                                                                                                // Tampilkan foto tambahan terakhir.
                                                                                                if (this.newPhotos.length > 0) {
                                                                                                    this.activePhoto = this.photos.length - 1;
                                                                                                }
                                                                                            },


                                                                                            confirmDeletePhoto() {
                                                                                                const photo = this.photos[this.activePhoto];

                                                                                                if (!photo) {
                                                                                                    this.showDeleteConfirm = false;
                                                                                                    return;
                                                                                                }

                                                                                                if (photo.type === 'gallery' && !this.deletedPhotoIds.includes(photo.id)) {
                                                                                                    this.deletedPhotoIds.push(photo.id);
                                                                                                }

                                                                                                if (photo.type === 'new') {
                                                                                                    const item = this.newPhotos.find(file => file.src === photo.src);

                                                                                                    if (item) {
                                                                                                        URL.revokeObjectURL(item.src);
                                                                                                        this.newPhotos = this.newPhotos.filter(file => file.src !== photo.src);

                                                                                                        const input = this.$refs.galleryInput;
                                                                                                        const transfer = new DataTransfer();

                                                                                                        this.newPhotos.forEach(file => transfer.items.add(file.file));
                                                                                                        input.files = transfer.files;
                                                                                                    }
                                                                                                }

                                                                                                this.photos.splice(this.activePhoto, 1);
                                                                                                this.activePhoto = Math.max(0, Math.min(this.activePhoto, this.photos.length - 1));
                                                                                                this.showDeleteConfirm = false;
                                                                                            }
                                                                                        }"
                                                                                        class="space-y-4"
                                                                                    >
                                                                                        <div>
                                                                                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                                                Foto Sampul dan Galeri
                                                                                            </label>

                                                                                            <div class="relative flex h-48 items-center justify-center overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800 sm:h-56">
                                                                                                <template x-if="photos.length > 0">
                                                                                                    <img
                                                                                                        :src="photos[activePhoto]?.src"
                                                                                                        alt="Pratinjau foto fasilitas"
                                                                                                        class="h-full w-full object-contain"
                                                                                                    >
                                                                                                </template>

                                                                                                <template x-if="photos.length === 0">
                                                                                                    <p class="text-sm text-gray-500">Belum ada foto.</p>
                                                                                                </template>

                                                                                                <button
                                                                                                    x-cloak
                                                                                                    x-show="photos.length > 0 && photos[activePhoto]?.type !== 'cover'"
                                                                                                    type="button"
                                                                                                    @click.stop="showDeleteConfirm = true"
                                                                                                    class="absolute right-3 top-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-red-600 text-xl font-bold text-white shadow-lg hover:bg-red-700"
                                                                                                    aria-label="Hapus foto yang dipilih"
                                                                                                >
                                                                                                    &times;
                                                                                                </button>

                                                                                                <span
                                                                                                    x-show="photos.length > 0"
                                                                                                    class="absolute bottom-3 right-3 rounded-full bg-gray-900/75 px-3 py-1 text-xs font-medium text-white"
                                                                                                >
                                                                                                    Foto <span x-text="activePhoto + 1"></span>
                                                                                                    dari <span x-text="photos.length"></span>
                                                                                                </span>

                                                                                                {{-- KONFIRMASI HAPUS FOTO --}}
                                                                                                <div
                                                                                                    x-cloak
                                                                                                    x-show="showDeleteConfirm"
                                                                                                    x-transition.opacity
                                                                                                    @click.self="showDeleteConfirm = false"
                                                                                                    @keydown.escape.stop="showDeleteConfirm = false"
                                                                                                    class="absolute inset-0 z-20 flex items-center justify-center bg-black/60 p-4"
                                                                                                >
                                                                                                    <div
                                                                                                        x-show="showDeleteConfirm"
                                                                                                        x-transition
                                                                                                        class="w-full max-w-sm rounded-xl bg-white p-5 shadow-2xl dark:bg-gray-900"
                                                                                                        role="alertdialog"
                                                                                                        aria-modal="true"
                                                                                                    >
                                                                                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                                                            Hapus foto ini?
                                                                                                        </h3>

                                                                                                        <p class="my-4 text-sm text-gray-600 dark:text-gray-300">
                                                                                                            Foto akan dihapus setelah kamu menekan Simpan Perubahan.
                                                                                                        </p>

                                                                                                        <div class="flex justify-end gap-2">
                                                                                <div class="flex justify-end gap-2">
                                                                                    <button
                                                                                        type="button"
                                                                                        @click="showDeleteConfirm = false"
                                                                                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200"
                                                                                    >
                                                                                        Batal
                                                                                    </button>
                                                                                    <button
                                                                                        type="button"
                                                                                        @click="confirmDeletePhoto()"
                                                                                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                                                                    >
                                                                                        Hapus
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- THUMBNAILS GALERI --}}
                                                                <div x-show="photos.length > 0" class="flex gap-2 overflow-x-auto pb-2">
                                                                    <template x-for="(photo, index) in photos" :key="index">
                                                                        <button
                                                                            type="button"
                                                                            @click="activePhoto = index"
                                                                            class="relative shrink-0 overflow-hidden rounded-lg border-2"
                                                                            :class="activePhoto === index ? 'border-teal-500' : 'border-transparent'"
                                                                        >
                                                                            <img :src="photo.src" class="h-16 w-20 object-cover" alt="">
                                                                        </button>
                                                                    </template>
                                                                </div>

                                                                {{-- INPUT FOTO GALERI TAMBAHAN --}}
                                                                <div>
                                                                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                        Tambah Foto Galeri
                                                                    </label>
                                                                    <input
                                                                        x-ref="galleryInput"
                                                                        type="file"
                                                                        name="photos[]"
                                                                        accept=".jpg,.jpeg,.png,.webp"
                                                                        multiple
                                                                        @change="addPhotos($event)"
                                                                        class="block w-full rounded-lg border border-gray-300 p-2 text-sm dark:bg-gray-800"
                                                                    >
                                                                    <p class="mt-1 text-xs text-gray-500">
                                                                        Bisa pilih lebih dari satu foto. Format JPG, PNG, atau WEBP.
                                                                    </p>
                                                                </div>

                                                                <template x-for="id in deletedPhotoIds" :key="id">
                                                                    <input type="hidden" name="delete_photos[]" :value="id">
                                                                </template>

                                                                {{-- FOOTER MODAL FASILITAS --}}
                                                                <div class="flex items-center justify-between border-t border-gray-200 pt-4 dark:border-gray-700">
                                                                    <label class="flex items-center gap-2 text-sm">
                                                                        <input
                                                                            type="checkbox"
                                                                            name="is_active"
                                                                            value="1"
                                                                            @checked($facility->is_active)
                                                                            class="rounded border-gray-300"
                                                                        >
                                                                        Tampilkan di halaman publik
                                                                    </label>

                                                                    <div class="flex items-center gap-2">
                                                                        <button
                                                                            type="button"
                                                                            @click="openEdit = false"
                                                                            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200"
                                                                        >
                                                                            Batal
                                                                        </button>
                                                                        <button
                                                                            type="submit"
                                                                            class="rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700"
                                                                        >
                                                                            Simpan Perubahan
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    @empty
                                        <p class="rounded-lg bg-gray-50 p-4 text-sm text-gray-500 dark:bg-gray-800">
                                            Belum ada fasilitas dalam kategori ini.
                                        </p>
                                    @endforelse
                                </div>
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- FOOTER FORM UTAMA --}}
        <div class="mt-6 flex flex-col gap-3 border-t border-[#edf0f3] bg-[#fbfcfd] px-7 py-5 sm:flex-row sm:items-center sm:justify-end">
            <a
                href="{{ route('admin.pages.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-[#dce3ea] bg-white px-5 py-2.5 text-[12px] font-semibold text-[#526174] transition hover:bg-[#f8fafb]"
            >
                Batal
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-xl bg-[#08b4a1] px-5 py-2.5 text-[12px] font-semibold text-white shadow-sm transition hover:bg-[#079e8e]"
            >
                Simpan Perubahan
            </button>
        </div>

    </form>

</div>

</div>

{{-- ========================================================= --}}
{{-- SUMMERNOTE --}}
{{-- ========================================================= --}}
<link
    href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css"
    rel="stylesheet"
>

<style>
    .note-editor .note-editable {
        color: #475569;
        font-size: 14px;
        line-height: 1.75;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if ($('#content').length) {
            $('#content').summernote({
                height: 420,
                minHeight: 320,
                maxHeight: 650,
                placeholder: 'Tulis isi halaman di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        }

        const syncSlugBtn = document.getElementById('syncSlug');
        if (syncSlugBtn) {
            syncSlugBtn.addEventListener('click', function () {
                const title = document.getElementById('title').value;
                const slug = title
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                document.getElementById('slug').value = slug;
            });
        }
    });
</script>

</x-layouts.admin>

