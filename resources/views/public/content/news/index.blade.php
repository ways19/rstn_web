<x-layouts.app title="Berita, Artikel &amp; Edukasi Kesehatan — RSUD R.A.A. Tjokronegoro" meta-description="Publikasi resmi, berita kegiatan, siaran pers, dan tips kesehatan dari dokter spesialis RSUD R.A.A. Tjokronegoro Purworejo.">
<!-- Header Banner -->
<section class="bg-gradient-to-r from-slate-900 to-[#005b64] text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="text-xs font-bold text-teal-300 uppercase tracking-widest bg-teal-500/20 px-3 py-1 rounded-full border border-teal-400/30">Publikasi & Edukasi</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mt-3 leading-tight">Berita & Informasi Terkini</h1>
            <p class="text-slate-300 text-sm sm:text-base mt-3 leading-relaxed">
                Informasi aktual seputar aktivitas pelayanan rumah sakit dan wawasan hidup sehat untuk masyarakat.
            </p>
        </div>
    </div>
</section>

<!-- News Content Grid -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($newsList as $item)
                <article class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col group">
                    <div class="relative h-52 overflow-hidden">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-4 left-4 px-3 py-1 text-xs font-bold rounded-full bg-[#007b83] text-white shadow">
                            {{ $item['category'] }}
                        </span>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xs text-slate-400 font-medium">{{ $item['date'] }}</span>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 mt-2 leading-snug group-hover:text-[#007b83] transition">
                                <a href="{{ route('news.detail', $item['slug']) }}">
                                    {{ $item['title'] }}
                                </a>
                            </h2>
                            <p class="text-sm text-slate-600 mt-2.5 line-clamp-3 leading-relaxed">
                                {{ $item['excerpt'] }}
                            </p>
                        </div>
                        <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('news.detail', $item['slug']) }}" class="text-sm font-semibold text-[#007b83] group-hover:underline inline-flex items-center space-x-1">
                                <span>Baca Artikel</span>
                                <span>&rarr;</span>
                            </a>
                            <span class="text-xs text-slate-400">PKRS RSTN</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
</x-layouts.app>
