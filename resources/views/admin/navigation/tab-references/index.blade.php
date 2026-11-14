<x-layouts.admin title="Tab & Referensi Menu">

    @php
        $allPages = \App\Models\Page::where('is_active', true)
            ->orderBy('title')
            ->get();
    @endphp

    <div
        x-data="{
            selectedGroup: {{ $groups->first()?->id ?? 'null' }},
            selectedChild: {{ $groups->first()?->children->first()?->id ?? 'null' }},
            search: '',

            pageSelections: @js(
                $groups->flatMap(
                    fn($group) => $group->children->mapWithKeys(
                        fn($child) => [$child->id => $child->page_id]
                    )
                )->toArray()
            ),

            pages: @js(
                $allPages->map(fn($page) => [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'description' => $page->description,
                    'content' => $page->content,
                    'is_active' => (bool) $page->is_active,
                ])->values()
            ),

            selectGroup(groupId, firstChildId) {
                this.selectedGroup = groupId;
                this.selectedChild = firstChildId;
            },

            selectChild(childId) {
                this.selectedChild = childId;
            },

            selectedPageFor(childId) {
                const pageId = this.pageSelections[childId] ?? null;

                return this.pages.find(
                    page => Number(page.id) === Number(pageId)
                ) ?? null;
            },

            matchesSearch(title, pageTitle = '') {
                const keyword = this.search.toLowerCase().trim();

                if (!keyword) {
                    return true;
                }

                return (
                    title.toLowerCase().includes(keyword) ||
                    pageTitle.toLowerCase().includes(keyword)
                );
            }
        }"
        class="space-y-6"
    >

        {{-- HEADER --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-xs text-slate-500">
                Atur struktur kelompok tab navigasi dan hubungkan langsung ke <span class="font-semibold text-slate-700">Halaman (Pages)</span> atau tautan custom.
            </p>

            <div class="flex shrink-0 flex-wrap items-center gap-2">
                <a
                    href="{{ route('admin.pages.index') }}"
                    class="px-4 py-2 bg-[#007b83] hover:bg-[#005b64] text-white text-xs font-bold rounded-xl shadow transition"
                >
                    ↗ Kelola Isi Halaman (Pages)
                </a>
            </div>
        </div>


        {{-- ERROR MESSAGE --}}

        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-[13px] text-red-700">

                <div class="font-semibold">
                    Data belum dapat disimpan.
                </div>

                <ul class="mt-1 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif


        {{-- SEARCH --}}

        <div class="mb-5">

            <div class="relative">

                <svg
                    class="pointer-events-none absolute left-4 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-[#9aa7b5]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"
                    />
                </svg>

                <input
                    x-model="search"
                    type="text"
                    placeholder="Cari menu, submenu, atau halaman..."
                    class="h-[48px] w-full rounded-xl border border-[#dce3ea] bg-white pl-11 pr-4 text-[13px] text-[#263246] shadow-sm outline-none placeholder:text-[#a0aaba] focus:border-[#73cfd7] focus:ring-2 focus:ring-[#73cfd7]/10"
                >

            </div>

        </div>


        {{-- GROUP SELECTOR --}}

        <div class="mb-6">

            <div class="flex flex-wrap items-center gap-2.5">

                <span class="mr-1 text-[11px] font-semibold uppercase tracking-[0.04em] text-[#8794a5]">
                    Kelompok:
                </span>

                @foreach ($groups as $group)

                    <button
                        type="button"
                        @click="selectGroup(
                            {{ $group->id }},
                            {{ $group->children->first()?->id ?? 'null' }}
                        )"
                        :class="selectedGroup === {{ $group->id }}
                            ? 'border-[#172033] bg-[#172033] text-white shadow-sm'
                            : 'border-[#dce3ea] bg-white text-[#526174] hover:border-[#aeb9c6]'"
                        class="flex items-center gap-2 rounded-full border px-4 py-2 text-[13px] font-semibold transition"
                    >

                        {{ $group->title }}

                        <span
                            :class="selectedGroup === {{ $group->id }}
                                ? 'bg-white/15 text-white'
                                : 'bg-[#eef2f6] text-[#748195]'"
                            class="min-w-[22px] rounded-full px-1.5 py-0.5 text-center text-[10px]"
                        >
                            {{ $group->children->count() }}
                        </span>

                    </button>

                @endforeach

            </div>

        </div>


        {{-- MAIN WORKSPACE --}}

        <div class="grid grid-cols-1 items-start gap-5 xl:grid-cols-[350px_minmax(0,1fr)]">


            {{-- LEFT --}}

            <div class="overflow-hidden rounded-[20px] border border-[#dce3ea] bg-white shadow-sm">

                @foreach ($groups as $group)

                    <div
                        x-show="selectedGroup === {{ $group->id }}"
                        x-cloak
                    >

                        <div class="border-b border-[#edf0f3] px-5 py-5">

                            <div class="flex items-start justify-between gap-3">

                                <div>

                                    <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-[#8c99a9] dark:text-white">
                                        Kelompok Aktif
                                    </div>

                                    <h2 class="mt-1 text-[17px] font-semibold text-[#172033] dark:text-white">
                                        {{ $group->title }}
                                    </h2>

                                </div>

                                <span class="rounded-full bg-[#f0f7f8] px-3 py-1.5 text-[11px] font-semibold text-[#4b8490]">
                                    {{ $group->children->count() }} Sub-Tab
                                </span>

                            </div>

                        </div>


                        <div class="space-y-2 p-4">

                            @foreach ($group->children as $child)

                                <button
                                    type="button"
                                    x-show="matchesSearch(
                                        @js($child->title),
                                        @js($child->page?->title ?? '')
                                    )"
                                    @click="selectChild({{ $child->id }})"
                                    :class="selectedChild === {{ $child->id }}
                                        ? 'border-[#77deda] bg-[#effcfa] shadow-sm'
                                        : 'border-[#d8e0e7] bg-white hover:border-[#aebac7]'"
                                    class="w-full rounded-[15px] border px-4 py-3 text-left transition"
                                >

                                    <div class="flex items-center justify-between gap-3">

                                        <div class="min-w-0">

                                            <div class="flex items-center gap-2">

                                                <span class="h-[7px] w-[7px] shrink-0 rounded-full bg-[#12b7a6]"></span>

                                                <span class="truncate text-[13px] font-semibold text-[#263246]">
                                                    {{ $child->title }}
                                                </span>

                                            </div>

                                            <div class="mt-1.5 pl-[15px]">

                                                @if ($child->page)

                                                    <span class="text-[11px] font-medium text-[#16a39a]">
                                                        📄 Page: {{ $child->page->title }}
                                                    </span>

                                                @else

                                                    <span class="text-[11px] text-[#e99b28]">
                                                        ⚠ Belum ada tautan
                                                    </span>

                                                @endif

                                            </div>

                                        </div>

                                        <span class="shrink-0 rounded-md bg-[#f0f3f6] px-2 py-1 text-[10px] font-semibold text-[#7a8797]">
                                            #{{ $child->order }}
                                        </span>

                                    </div>

                                </button>

                            @endforeach

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- ===================================================== --}}
            {{-- RIGHT --}}
            {{-- ===================================================== --}}
            <div class="overflow-hidden rounded-[20px] border border-[#dce3ea] bg-white shadow-sm">

                @foreach ($groups as $group)
                    @foreach ($group->children as $child)

                        <div
                            x-show="selectedChild === {{ $child->id }}"
                            x-cloak
                        >

                            {{-- ================================================= --}}
                            {{-- FORM SIMPAN TAB --}}
                            {{-- ================================================= --}}

                            <form
                                method="POST"
                                action="{{ route('admin.tab-references.update', $child) }}"
                            >
                                @csrf
                                @method('PUT')

                                {{-- ================================================= --}}
                                {{-- RIGHT HEADER --}}
                                {{-- ================================================= --}}

                                <div class="border-b border-[#edf0f3] px-7 py-5">

                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                        <div>
                                            <div class="text-[10px] font-bold uppercase tracking-[0.07em] text-[#657387] dark:text-white">
                                                Konfigurasi Tab Menu
                                            </div>

                                            <h2 class="mt-1 text-[21px] font-semibold tracking-[-0.015em] text-[#172033] dark:text-white">
                                                {{ $child->title }}
                                            </h2>
                                        </div>

                                        <div class="text-left text-[11px] text-[#9aa6b5] sm:text-right">
                                            Terakhir diperbarui:
                                            {{ $child->updated_at?->format('d M Y, H:i') }}
                                        </div>

                                    </div>

                                </div>


                                {{-- ================================================= --}}
                                {{-- RIGHT BODY --}}
                                {{-- ================================================= --}}

                                <div class="space-y-6 p-7">


                                    {{-- ================================================= --}}
                                    {{-- BASIC CONFIG --}}
                                    {{-- ================================================= --}}

                                    <div class="grid grid-cols-1 gap-5 lg:grid-cols-[1.3fr_0.6fr_1fr]">

                                        {{-- NAMA --}}

                                        <div>

                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]">
                                                Nama Tab Menu *
                                            </label>

                                            <input
                                                type="text"
                                                name="title"
                                                value="{{ $child->title }}"
                                                class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                            >

                                        </div>


                                        {{-- URUTAN --}}

                                        <div>

                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]">
                                                Urutan Tampil *
                                            </label>

                                            <input
                                                type="number"
                                                name="order"
                                                value="{{ $child->order }}"
                                                class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                            >

                                        </div>


                                        {{-- SLUG --}}

                                        <div>

                                            <div class="mb-2 flex items-center justify-between gap-2">

                                                <label class="text-[11px] font-bold uppercase tracking-[0.04em] text-[#526174]">
                                                    Slug URL
                                                    <span class="normal-case">
                                                        (Pengenal Unik) *
                                                    </span>
                                                </label>

                                                <button
                                                    type="button"
                                                    class="text-[10px] font-medium text-[#557084] hover:text-[#079fb7]"
                                                >
                                                    ↻ Sinkronkan dari Nama
                                                </button>

                                            </div>

                                            <input
                                                type="text"
                                                name="slug"
                                                value="{{ trim(parse_url($child->url, PHP_URL_PATH) ?? '', '/') }}"
                                                class="h-[46px] w-full rounded-xl border border-[#dce3ea] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                            >

                                        </div>

                                    </div>


                                    {{-- ================================================= --}}
                                    {{-- PAGE REFERENCE --}}
                                    {{-- ================================================= --}}

                                    <div class="rounded-[18px] border border-[#abdedd] bg-[#f2fcfb] p-5">

                                        <div class="flex items-start gap-3">

                                            {{-- ICON --}}

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#0ca69c] shadow-sm">

                                                <svg
                                                    class="h-5 w-5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M7 3h7l4 4v14H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M14 3v5h5M9 13h6M9 17h6"
                                                    />
                                                </svg>

                                            </div>


                                            {{-- TEXT + EDIT BUTTON --}}

                                            <div class="min-w-0 flex-1">

                                                <div class="flex items-start justify-between gap-4">

                                                    <div>

                                                        <h3 class="text-[13px] font-bold text-[#263246]">
                                                            Tautkan Konten Halaman (Pages)
                                                        </h3>

                                                        <p class="mt-1 text-[11px] leading-5 text-[#7b8999]">
                                                            Pilih dokumen halaman yang isinya akan ditampilkan saat tab ini diklik.
                                                        </p>

                                                    </div>


                                                    {{-- EDIT PAGE --}}

                                                    <template x-if="selectedPageFor({{ $child->id }})">

                                                        <a
                                                            :href="`{{ url('/admin/pages') }}/${selectedPageFor({{ $child->id }}).id}/edit`"
                                                            class="inline-flex shrink-0 items-center gap-2 rounded-lg border border-[#8edbd5] bg-white px-3.5 py-2 text-[12px] font-semibold text-[#078f99] transition hover:bg-[#ecfbfa]"
                                                        >
                                                            ✏️ Edit Konten Halaman
                                                        </a>

                                                    </template>

                                                </div>

                                            </div>

                                        </div>


                                        {{-- ================================================= --}}
                                        {{-- PAGE SELECT --}}
                                        {{-- ================================================= --}}

                                        <div class="mt-5">

                                            <label class="mb-2 block text-[11px] font-bold text-[#526174]">
                                                Pilih Halaman Terhubung
                                            </label>

                                            <select
                                                name="page_id"
                                                x-model="pageSelections[{{ $child->id }}]"
                                                class="h-[46px] w-full rounded-xl border border-[#d5e2e3] bg-white px-4 text-[13px] font-medium text-[#263246] outline-none focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                            >

                                                <option value="">
                                                    -- Tidak Terhubung ke Halaman (Gunakan Link Eksternal / Kosong) --
                                                </option>

                                                @foreach ($allPages as $page)

                                                    <option value="{{ $page->id }}">
                                                        {{ $page->title }}
                                                        (/{{ $page->slug }})
                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>


                                        {{-- ================================================= --}}
                                        {{-- CUSTOM URL --}}
                                        {{-- ================================================= --}}

                                        <div class="mt-5">

                                            <label class="mb-2 block text-[11px] font-bold text-[#526174]">
                                                Atau Tautan URL Kustom
                                                <span class="font-normal text-[#8996a5]">
                                                    (Opsional)
                                                </span>
                                            </label>

                                            <input
                                                type="text"
                                                name="url"
                                                x-model="customUrls[{{ $child->id }}]"
                                                placeholder="https://... atau /rute-khusus"
                                                class="h-[46px] w-full rounded-xl border border-[#d5e2e3] bg-white px-4 text-[13px] text-[#263246] outline-none placeholder:text-[#a4aeba] focus:border-[#70ccd3] focus:ring-2 focus:ring-[#70ccd3]/10"
                                            >

                                            <p class="mt-2 text-[10px] text-[#8c99a8]">
                                                Gunakan field ini hanya jika tab diarahkan ke halaman eksternal atau link spesifik.
                                            </p>

                                        </div>

                                    </div>


                                    {{-- ================================================= --}}
                                    {{-- PREVIEW --}}
                                    {{-- ================================================= --}}

                                    <template x-if="selectedPageFor({{ $child->id }})">

                                        <div class="rounded-[18px] border border-[#e1e7ec] bg-[#fbfcfd] p-5">

                                            <div class="mb-4 flex items-center justify-between gap-3">

                                                <div class="text-[11px] font-bold uppercase tracking-[0.04em] text-[#68778a]">
                                                    Preview Isi Halaman Terhubung:
                                                </div>


                                                <template
                                                    x-if="selectedPageFor({{ $child->id }}).is_active"
                                                >

                                                    <span class="rounded-full bg-[#dff8ed] px-3 py-1 text-[10px] font-semibold text-[#15966e]">
                                                        Status: Aktif
                                                    </span>

                                                </template>


                                                <template
                                                    x-if="!selectedPageFor({{ $child->id }}).is_active"
                                                >

                                                    <span class="rounded-full bg-[#f1f3f5] px-3 py-1 text-[10px] font-semibold text-[#7b8795]">
                                                        Status: Nonaktif
                                                    </span>

                                                </template>

                                            </div>


                                            <div class="max-h-[360px] overflow-y-auto rounded-xl bg-white p-5">

                                                <h3
                                                    class="text-[20px] font-semibold text-[#172033] dark:text-white"
                                                    x-text="selectedPageFor({{ $child->id }}).title"
                                                ></h3>


                                                <template
                                                    x-if="selectedPageFor({{ $child->id }}).description"
                                                >

                                                    <p
                                                        class="mt-2 text-[12px] leading-6 text-[#718096] dark:text-white"
                                                        x-text="selectedPageFor({{ $child->id }}).description"
                                                    ></p>

                                                </template>


                                                <template
                                                    x-if="selectedPageFor({{ $child->id }}).content"
                                                >

                                                    <div
                                                        class="prose mt-5 max-w-none text-[13px] leading-6 text-[#526174]"
                                                        x-html="selectedPageFor({{ $child->id }}).content"
                                                    ></div>

                                                </template>


                                                <template
                                                    x-if="!selectedPageFor({{ $child->id }}).content"
                                                >

                                                    <p class="mt-5 text-[12px] italic text-[#9aa6b5]">
                                                        Belum ada isi halaman.
                                                    </p>

                                                </template>

                                            </div>

                                        </div>

                                    </template>


                                    {{-- ================================================= --}}
                                    {{-- NO PAGE --}}
                                    {{-- ================================================= --}}

                                    <template x-if="!selectedPageFor({{ $child->id }})">

                                        <div class="rounded-[18px] border border-dashed border-[#d9e0e7] bg-[#fafbfc] p-6 text-center">

                                            <div class="text-[12px] font-medium text-[#8a97a6]">
                                                Tab ini belum terhubung ke halaman.
                                            </div>

                                            <div class="mt-1 text-[11px] text-[#a0aab7]">
                                                Pilih halaman di atas untuk melihat preview dan tombol edit.
                                            </div>

                                        </div>

                                    </template>


                                    {{-- ================================================= --}}
                                    {{-- STATUS + SAVE --}}
                                    {{-- ================================================= --}}

                                    <div class="flex flex-col gap-4 border-t border-[#edf0f3] pt-5 sm:flex-row sm:items-center sm:justify-between">

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
                                                {{ $child->is_active ? 'checked' : '' }}
                                                class="h-4 w-4 rounded border-[#cbd5df] text-[#08b4a1] focus:ring-[#08b4a1]"
                                            >

                                            <span class="text-[12px] font-medium text-[#526174]">
                                                Aktifkan Tab Ini di Tampilan Publik
                                            </span>

                                        </label>


                                        <button
                                            type="submit"
                                            class="rounded-xl bg-[#08b4a1] px-5 py-2.5 text-[12px] font-semibold text-white shadow-sm transition hover:bg-[#079e8e]"
                                        >
                                            Simpan Tautan Tab
                                        </button>

                                    </div>

                                </div>

                            </form>

                        </div>

                    @endforeach
                @endforeach

            </div>

        </div>

    </div>


    {{-- STYLE --}}

    <style>

        [x-cloak] {
            display: none !important;
        }

        .prose p {
            margin-top: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .prose h1,
        .prose h2,
        .prose h3,
        .prose h4 {
            color: #172033;
            font-weight: 600;
            margin-top: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .prose ul {
            list-style: disc;
            padding-left: 1.5rem;
            margin-top: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .prose ol {
            list-style: decimal;
            padding-left: 1.5rem;
            margin-top: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .prose li {
            margin-top: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .prose strong {
            color: #172033;
            font-weight: 700;
        }

    </style>

</x-layouts.admin>