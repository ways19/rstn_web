<x-layouts.admin title="Manajemen Dokumen PPID">
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <p class="text-xs text-slate-500">
                Kelola dokumen dan informasi publik yang ditampilkan pada halaman PPID ({{ $documents->count() }} dokumen).
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
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Dokumen</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Tahun</th>
                            <th class="px-6 py-4">Tipe</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50">
                        @forelse ($documents as $document)
                            @php
                                $typeLabels = [
                                    'page' => 'Halaman',
                                    'file' => 'File',
                                    'link' => 'Link',
                                    'video' => 'Video',
                                ];
                            @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="whitespace-nowrap px-6 py-4 text-slate-500 font-medium">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="min-w-[260px] px-6 py-4">
                                    <span class="font-bold text-slate-900 block">{{ $document->title }}</span>
                                    @if ($document->description)
                                        <span class="text-[11px] text-slate-400 block mt-0.5 max-w-xl">
                                            {{ Str::limit($document->description, 90) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                        {{ $document->category ?: 'PPID' }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 font-semibold text-teal-800">
                                    {{ $document->year }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-teal-50 text-[#007b83]">
                                        {{ $typeLabels[$document->type] ?? $document->type }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $document->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $document->is_active ? 'Aktif' : 'Non-aktif' }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right space-x-2">
                                    <a
                                        href="{{ route('admin.ppid-documents.edit', $document) }}"
                                        class="text-[#007b83] font-bold hover:underline"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.ppid-documents.destroy', $document) }}"
                                        method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="text-red-500 font-bold hover:underline cursor-pointer"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <p class="text-xs font-bold text-slate-600">Belum ada dokumen PPID</p>
                                    <p class="mt-1 text-[11px] text-slate-400">
                                        Tambahkan dokumen pertama untuk mulai mengelola informasi PPID.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
