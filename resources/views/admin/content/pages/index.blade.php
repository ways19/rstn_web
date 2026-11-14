@php
    $currentTab = in_array(request('tab'), ['pages', 'sections', 'documents'])
        ? request('tab')
        : 'pages';

    $pageTitle = match ($currentTab) {
        'sections' => 'Section Halaman Informasi Publik',
        'documents' => 'Manajemen Dokumen PPID',
        default => 'Manajemen Halaman (Pages)',
    };
@endphp

<x-layouts.admin :title="$pageTitle">
    <div class="space-y-6">

        {{-- HALAMAN 1: DAFTAR HALAMAN (PAGES) --}}
        @if ($currentTab === 'pages')
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p id="pageSearchResult" class="min-w-0 flex-1 text-xs text-slate-500">
                    Kelola seluruh konten halaman statis, informasi publik, diklat, PPID, dan aduan ({{ $pages->count() }} halaman).
                </p>

                <div class="flex shrink-0 flex-nowrap items-center gap-2">
                    <div class="relative">
                        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400">
                            🔍
                        </span>
                        <input
                            id="pageSearch"
                            type="text"
                            placeholder="Cari judul atau slug..."
                            class="h-9 w-44 xl:w-52 rounded-xl border border-slate-200 bg-white pl-8 pr-3 text-xs text-slate-700 shadow-xs outline-none transition focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                        >
                    </div>

                    <select
                        id="pageCategory"
                        class="h-9 shrink-0 rounded-xl border border-slate-200 bg-white px-3 text-xs text-slate-700 shadow-xs outline-none transition focus:border-[#007b83] focus:ring-2 focus:ring-[#007b83]/10"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach($pages->pluck('category')->filter()->unique()->sort() as $category)
                            <option value="{{ strtolower(trim($category)) }}">
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>

                    <button
                        id="clearPageSearch"
                        type="button"
                        class="hidden shrink-0 whitespace-nowrap text-xs font-bold text-[#007b83] hover:underline cursor-pointer"
                    >
                        Reset
                    </button>

                    <a
                        href="{{ route('admin.pages.create') }}"
                        class="inline-flex h-9 shrink-0 items-center whitespace-nowrap rounded-xl bg-[#007b83] px-3.5 text-xs font-bold text-white shadow transition hover:bg-[#005b64]"
                    >
                        + Tambah Halaman
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Judul Halaman</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="pageTableBody" class="divide-y divide-slate-50">
                            @forelse($pages as $page)
                                <tr
                                    class="page-row hover:bg-slate-50 transition"
                                    data-title="{{ strtolower($page->title) }}"
                                    data-slug="{{ strtolower($page->slug) }}"
                                    data-category="{{ strtolower(trim($page->category)) }}"
                                >
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-900 block">{{ $page->title }}</span>
                                        <span class="text-[11px] text-slate-400">/{{ $page->slug }}</span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                            {{ $page->category ?: 'Umum' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $page->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $page->is_active ? 'Aktif' : 'Non-aktif' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a
                                            href="{{ route('admin.pages.edit', $page) }}"
                                            class="text-[#007b83] font-bold hover:underline"
                                        >
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-xs text-slate-500">
                                        Belum ada halaman.
                                    </td>
                                </tr>
                            @endforelse

                            <tr id="pageNoResult" class="hidden">
                                <td colspan="4" class="px-6 py-10 text-center">
                                    <p class="text-xs font-bold text-slate-600">Halaman tidak ditemukan</p>
                                    <p class="mt-1 text-[11px] text-slate-400">Coba gunakan kata kunci atau kategori lain.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const searchInput = document.getElementById('pageSearch');
                    const categorySelect = document.getElementById('pageCategory');
                    const rows = document.querySelectorAll('.page-row');
                    const resultText = document.getElementById('pageSearchResult');
                    const clearButton = document.getElementById('clearPageSearch');
                    const noResult = document.getElementById('pageNoResult');

                    function filterPages() {
                        const keyword = searchInput.value.trim().toLowerCase();
                        const selectedCategory = categorySelect.value.trim().toLowerCase();
                        let visibleCount = 0;

                        rows.forEach(function (row) {
                            const title = (row.dataset.title || '').trim().toLowerCase();
                            const slug = (row.dataset.slug || '').trim().toLowerCase();
                            const category = (row.dataset.category || '').trim().toLowerCase();

                            const matchKeyword = keyword === '' || title.includes(keyword) || slug.includes(keyword);
                            const matchCategory = selectedCategory === '' || category === selectedCategory;
                            const shouldShow = matchKeyword && matchCategory;

                            row.classList.toggle('hidden', !shouldShow);
                            if (shouldShow) {
                                visibleCount++;
                            }
                        });

                        noResult.classList.toggle('hidden', visibleCount !== 0);
                        resultText.textContent = `Menampilkan ${visibleCount} dari ${rows.length} halaman`;

                        const hasFilter = keyword !== '' || selectedCategory !== '';
                        clearButton.classList.toggle('hidden', !hasFilter);
                    }

                    searchInput.addEventListener('input', filterPages);
                    categorySelect.addEventListener('change', filterPages);
                    clearButton.addEventListener('click', function () {
                        searchInput.value = '';
                        categorySelect.value = '';
                        filterPages();
                        searchInput.focus();
                    });
                });
            </script>
        @endif

        {{-- HALAMAN 2: SECTION HALAMAN --}}
        @if ($currentTab === 'sections')
            <div class="flex justify-between items-center">
                <p class="text-xs text-slate-500">
                    Kelola judul dan bagian konten (section) pada setiap halaman informasi & PPID.
                </p>
                <a
                    href="{{ route('admin.page-sections.create') }}"
                    class="px-4 py-2 bg-[#007b83] hover:bg-[#005b64] text-white text-xs font-bold rounded-xl shadow transition"
                >
                    + Tambah Section
                </a>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Halaman Induk</th>
                                <th class="px-6 py-4">Judul Section</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-50">
                            @forelse($sections as $section)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-teal-50 text-teal-800">
                                            {{ $section->page->title ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-900 block">{{ $section->title }}</span>
                                        @if($section->description)
                                            <span class="text-[11px] text-slate-400 block mt-0.5">
                                                {{ Str::limit($section->description, 80) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $section->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $section->is_active ? 'Aktif' : 'Non-aktif' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a
                                            href="{{ route('admin.page-sections.edit', $section) }}"
                                            class="text-[#007b83] font-bold hover:underline"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.page-sections.destroy', $section) }}"
                                            method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Hapus section ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 font-bold hover:underline cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-xs text-slate-500">
                                        Belum ada section halaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- HALAMAN 3: DOKUMEN PPID --}}
        @if ($currentTab === 'documents')
            <div class="flex justify-between items-center">
                <p class="text-xs text-slate-500">
                    Kelola dokumen publik yang dapat ditempatkan pada berbagai menu informasi PPID.
                </p>
                <a
                    href="{{ route('admin.ppid-documents.create') }}"
                    class="px-4 py-2 bg-[#007b83] hover:bg-[#005b64] text-white text-xs font-bold rounded-xl shadow transition"
                >
                    + Tambah Dokumen
                </a>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Judul Dokumen</th>
                                <th class="px-6 py-4">Tahun</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-50">
                            @forelse($documents as $document)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-900 block">{{ $document->title }}</span>
                                        <span class="text-[11px] text-slate-400">{{ ucfirst($document->type) }}</span>
                                    </td>

                                    <td class="px-6 py-4 font-semibold text-teal-800">
                                        {{ $document->year }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $document->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $document->is_active ? 'Aktif' : 'Non-aktif' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a
                                            href="{{ route('admin.ppid-documents.edit', $document) }}"
                                            class="text-[#007b83] font-bold hover:underline"
                                        >
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-xs text-slate-500">
                                        Belum ada dokumen PPID.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</x-layouts.admin>
