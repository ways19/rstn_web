<x-layouts.app :title="$item['title'] . ' — RSUD R.A.A. Tjokronegoro'" :meta-description="$item['excerpt']">
<!-- Header Banner -->
<section class="bg-gradient-to-r from-slate-900 to-[#005b64] text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-xs text-teal-200 mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <a href="{{ route('news') }}" class="hover:text-white">Berita & Artikel</a>
            <span>/</span>
            <span class="text-white font-medium">{{ $item['category'] }}</span>
        </nav>
        <span class="text-xs font-bold text-teal-300 uppercase tracking-widest bg-teal-500/20 px-3 py-1 rounded-full border border-teal-400/30">{{ $item['category'] }}</span>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold mt-3 max-w-4xl leading-tight">{{ $item['title'] }}</h1>
        <div class="text-xs text-teal-200 mt-3 flex items-center space-x-4">
            <span>Tanggal: {{ $item['date'] }}</span>
            <span>•</span>
            <span>Oleh: Promosi Kesehatan Rumah Sakit (PKRS)</span>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Article Body -->
            <div class="lg:col-span-8 space-y-8">
                <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-100">
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-[400px] object-cover">
                </div>

                <div class="prose max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
                    <p class="text-lg font-medium text-slate-800 leading-relaxed italic border-l-4 border-teal-600 pl-4 bg-slate-50 py-3 rounded-r-xl">
                        {{ $item['excerpt'] }}
                    </p>
                    <p>
                        {{ $item['content'] }}
                    </p>
                    <p>
                        RSUD R.A.A. Tjokronegoro senantiasa berupaya mendekatkan pelayanan kesehatan kepada masyarakat secara menyeluruh. Selain penanganan medis kuratif dan rehabilitatif di dalam gedung rumah sakit, kegiatan promosi kesehatan dan edukasi preventif juga terus digalakkan secara berkala.
                    </p>
                </div>

                <div class="pt-6 border-t border-slate-200 flex items-center justify-between">
                    <a href="{{ route('news') }}" class="text-xs font-bold text-[#007b83] hover:underline">
                        &larr; Kembali ke Indeks Berita
                    </a>
                    <span class="text-xs text-slate-400">Bagikan artikel ini ke media sosial</span>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-b pb-2">Berita Lainnya</h3>
                    <div class="space-y-4">
                        @foreach($relatedNews as $rel)
                            <a href="{{ route('news.detail', $rel['slug']) }}" class="flex items-center space-x-3 group">
                                <img src="{{ $rel['image'] }}" alt="{{ $rel['title'] }}" class="w-16 h-16 rounded-xl object-cover shrink-0">
                                <div>
                                    <span class="text-xs font-bold text-slate-800 group-hover:text-[#007b83] transition block leading-snug">{{ $rel['title'] }}</span>
                                    <span class="text-[11px] text-slate-400 mt-1 block">{{ $rel['date'] }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Registration Banner -->
                <div class="bg-gradient-to-br from-[#005b64] to-[#007b83] text-white p-6 rounded-3xl shadow-sm space-y-4 text-center">
                    <h4 class="text-base font-bold">Butuh Konsultasi Dokter?</h4>
                    <p class="text-xs text-teal-100">Daftarkan diri Anda secara online untuk mendapatkan jadwal konsultasi tanpa antre panjang.</p>
                    <a href="{{ route('registration') }}" class="inline-block w-full py-3 rounded-xl font-bold text-xs bg-white text-[#005b64] hover:bg-teal-50 shadow transition">
                        Daftar Antrean Online
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
</x-layouts.app>
