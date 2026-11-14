<x-layouts.admin title="Tambah Section">
@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            Tambah Section
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Tambahkan bagian baru pada halaman PPID.
        </p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6">

        <form
            action="{{ route('admin.page-sections.store') }}"
            method="POST"
            class="space-y-6"
        >
            @csrf

            {{-- Halaman --}}
            <div>
                <label
                    for="page_id"
                    class="mb-2 block text-sm font-medium text-slate-700"
                >
                    Halaman
                </label>

                <select
                    id="page_id"
                    name="page_id"
                    required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#007b83] focus:outline-none focus:ring-1 focus:ring-[#007b83]"
                >
                    <option value="">Pilih halaman</option>

                    @foreach($pages as $page)
                        <option
                            value="{{ $page->id }}"
                            {{ old('page_id') == $page->id ? 'selected' : '' }}
                        >
                            {{ $page->title }}
                        </option>
                    @endforeach
                </select>

                @error('page_id')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Level --}}
            <div>
                <label
                    for="level"
                    class="mb-2 block text-sm font-medium text-slate-700"
                >
                    Level
                </label>

                <select
                    id="level"
                    name="level"
                    required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#007b83] focus:outline-none focus:ring-1 focus:ring-[#007b83]"
                >
                    <option value="1" {{ old('level', 1) == 1 ? 'selected' : '' }}>
                        Level 1
                    </option>

                    <option value="2" {{ old('level') == 2 ? 'selected' : '' }}>
                        Level 2
                    </option>
                </select>

                <p class="mt-1 text-xs text-slate-500">
                    Level 1 adalah kelompok utama. Level 2 berada di dalam Level 1.
                </p>

                @error('level')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Induk Section --}}
            <div>
                <label
                    for="parent_id"
                    class="mb-2 block text-sm font-medium text-slate-700"
                >
                    Induk Section
                </label>

                <select
                    id="parent_id"
                    name="parent_id"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#007b83] focus:outline-none focus:ring-1 focus:ring-[#007b83]"
                >
                    <option value="">Tidak memiliki induk</option>

                    @foreach($sections as $section)
                        @if($section->level == 1)
                            <option
                                value="{{ $section->id }}"
                                {{ old('parent_id') == $section->id ? 'selected' : '' }}
                            >
                                {{ $section->title }}
                            </option>
                        @endif
                    @endforeach
                </select>

                <p class="mt-1 text-xs text-slate-500">
                    Isi jika section ini merupakan Level 2.
                </p>

                @error('parent_id')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Judul --}}
            <div>
                <label
                    for="title"
                    class="mb-2 block text-sm font-medium text-slate-700"
                >
                    Judul Section
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    required
                    placeholder="Contoh: Informasi Tentang Profil RSUD"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#007b83] focus:outline-none focus:ring-1 focus:ring-[#007b83]"
                >

                @error('title')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label
                    for="description"
                    class="mb-2 block text-sm font-medium text-slate-700"
                >
                    Deskripsi
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Masukkan deskripsi section..."
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#007b83] focus:outline-none focus:ring-1 focus:ring-[#007b83]"
                >{{ old('description') }}</textarea>

                @error('description')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

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
                    value="{{ old('sort_order', 0) }}"
                    min="0"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#007b83] focus:outline-none focus:ring-1 focus:ring-[#007b83]"
                >
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
                    checked
                    class="h-4 w-4 rounded border-slate-300 text-[#007b83] focus:ring-[#007b83]"
                >

                <label
                    for="is_active"
                    class="text-sm font-medium text-slate-700"
                >
                    Section aktif
                </label>
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
                    Simpan Section
                </button>

            </div>

        </form>

    </div>

</div>
</x-layouts.admin>