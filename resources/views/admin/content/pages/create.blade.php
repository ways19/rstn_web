<x-layouts.admin title="Tambah Halaman">

    <div class="space-y-6">

        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}
        <div class="flex items-start justify-between gap-4">

            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-[26px] font-semibold tracking-[-0.02em] text-[#172033] dark:text-white">
                        Tambah Halaman
                    </h1>

                    <span class="rounded-full bg-[#e7f8fb] px-3 py-1 text-[11px] font-semibold text-[#079fbb]">
                        Halaman
                    </span>
                </div>

                <p class="mt-2 max-w-3xl text-[14px] leading-6 text-[#748195]">
                    Tambahkan halaman baru yang akan digunakan pada website publik.
                </p>
            </div>

            {{-- HEADER ACTION --}}
            <div class="flex shrink-0 flex-nowrap items-center gap-2.5">

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
                action="{{ route('admin.pages.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

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
                                Tentukan identitas halaman yang akan digunakan pada website.
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
                                value="{{ old('title') }}"
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
                                value="{{ old('category') }}"
                                required
                                class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none transition focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                placeholder="Contoh: PPID, Profil, Informasi"
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
                                value="{{ old('slug') }}"
                                required
                                class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none transition focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                placeholder="contoh: profil-ppid"
                            >

                            @error('slug')
                                <p class="mt-1.5 text-[11px] text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                            <p class="mt-1.5 text-[11px] text-[#8b97a5]">
                                Digunakan sebagai alamat halaman pada website.
                            </p>

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
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <p class="mt-1.5 text-[11px] text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- CONTENT EDITOR --}}
                    {{-- ================================================= --}}
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
                        >{{ old('content') }}</textarea>

                        @error('content')
                            <p class="mt-1.5 text-[11px] text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


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
                                    Tentukan apakah halaman ini langsung ditampilkan pada website publik.
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
                                    @checked(old('is_active', true))
                                    class="h-4 w-4 rounded border-[#cbd5df] text-[#08b4a1] focus:ring-[#08b4a1]"
                                >

                                <span class="text-[12px] font-medium text-[#526174]">
                                    Aktifkan halaman ini di website publik
                                </span>

                            </label>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- FOOTER --}}
                {{-- ================================================= --}}
                <div class="flex flex-col gap-3 border-t border-[#edf0f3] bg-[#fbfcfd] px-7 py-5 sm:flex-row sm:items-center sm:justify-end">

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
                        Simpan Halaman
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

        .note-editor .note-editable h2:first-child {
            margin: 0;
            padding: 24px 24px 30px;
            border-radius: 16px 16px 0 0;
            background: linear-gradient(to right, #007b83, #16a39c);
            color: white;
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.3;
        }

        .note-editor .note-editable h3 {
            margin-top: 32px;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #d8eeee;
            color: #007b83;
            font-size: 18px;
            font-weight: 700;
        }

        .note-editor .note-editable h4 {
            margin-top: 20px;
            margin-bottom: 0;
            padding: 12px 16px;
            border: 1px solid #dce7e7;
            border-radius: 12px 12px 0 0;
            background: #f0f8f7;
            color: #007b83;
            font-size: 14px;
            font-weight: 700;
        }

        .note-editor .note-editable p {
            margin-bottom: 16px;
            line-height: 1.75;
        }

        .note-editor .note-editable ul {
            margin-bottom: 20px;
            padding-left: 24px;
        }

        .note-editor .note-editable li {
            margin-bottom: 6px;
        }
    </style>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // =========================================================
            // SUMMERNOTE
            // =========================================================

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


            // // Pastikan isi Summernote masuk ke textarea
            // $('#content').closest('form').on('submit', function () {
            //     $('#content').val($('#content').summernote('code'));
            // });


            // =========================================================
            // SINKRONKAN SLUG DARI JUDUL
            // =========================================================

            document.getElementById('syncSlug').addEventListener('click', function () {

                const title = document.getElementById('title').value;

                const slug = title
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');

                document.getElementById('slug').value = slug;

            });

        });
    </script>

</x-layouts.admin>