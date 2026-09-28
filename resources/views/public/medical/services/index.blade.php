<x-layouts.app title="Layanan Medis &amp; Fasilitas — RSUD R.A.A. Tjokronegoro" meta-description="Daftar layanan medis lengkap RSUD R.A.A. Tjokronegoro Purworejo: IGD 24 Jam, Rawat Jalan Spesialis, Rawat Inap, Hemodialisa, Radiologi Digital, Bedah Sentral, dan Laboratorium.">
<!-- Header Banner -->
<section class="bg-gradient-to-r from-slate-900 to-[#005b64] text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="text-xs font-bold text-teal-300 uppercase tracking-widest bg-teal-500/20 px-3 py-1 rounded-full border border-teal-400/30">Pelayanan Kesehatan</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mt-3 leading-tight">Layanan Medis & Fasilitas</h1>
            <p class="text-slate-300 text-sm sm:text-base mt-3 leading-relaxed">
                Kami menyediakan ragam fasilitas diagnostik, kuratif, dan rehabilitatif berteknologi modern untuk menjamin keselamatan dan kenyamanan setiap pasien.
            </p>
        </div>
    </div>
</section>

<!-- Filter Tabs & Service List -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Category Filter Tabs -->
        <div class="flex overflow-x-auto pb-4 gap-2 mb-10 border-b border-slate-200">
            <a href="{{ route('services', ['kategori' => 'semua']) }}" 
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition whitespace-nowrap {{ $category === 'semua' ? 'bg-[#007b83] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                Semua Layanan
            </a>
            <a href="{{ route('services', ['kategori' => 'darurat']) }}" 
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition whitespace-nowrap {{ $category === 'darurat' ? 'bg-[#007b83] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                Gawat Darurat (24 Jam)
            </a>
            <a href="{{ route('services', ['kategori' => 'rawat-jalan']) }}" 
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition whitespace-nowrap {{ $category === 'rawat-jalan' ? 'bg-[#007b83] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                Rawat Jalan
            </a>
            <a href="{{ route('services', ['kategori' => 'rawat-inap']) }}" 
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition whitespace-nowrap {{ $category === 'rawat-inap' ? 'bg-[#007b83] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                Rawat Inap
            </a>
            <a href="{{ route('services', ['kategori' => 'unggulan']) }}" 
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition whitespace-nowrap {{ $category === 'unggulan' ? 'bg-[#007b83] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                Layanan Unggulan
            </a>
            <a href="{{ route('services', ['kategori' => 'penunjang']) }}" 
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition whitespace-nowrap {{ $category === 'penunjang' ? 'bg-[#007b83] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                Penunjang Medis
            </a>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($services as $svc)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col group">
                    <div class="relative h-52 overflow-hidden">
                        <img src="{{ $svc['image'] }}" alt="{{ $svc['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-white/95 backdrop-blur-md text-slate-800 shadow">
                                {{ $svc['tag'] }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 group-hover:text-[#007b83] transition">
                                <a href="{{ route('services.detail', $svc['slug']) }}">
                                    {{ $svc['title'] }}
                                </a>
                            </h2>
                            <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                                {{ $svc['excerpt'] }}
                            </p>

                            <div class="mt-4 pt-3 border-t border-slate-100">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider block mb-2">Fasilitas Utama:</span>
                                <ul class="space-y-1.5 text-xs sm:text-sm text-slate-600">
                                    @foreach(array_slice($svc['facilities'] ?? [], 0, 3) as $fac)
                                        <li class="flex items-center space-x-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#007b83]"></span>
                                            <span>{{ $fac }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('services.detail', $svc['slug']) }}" class="text-sm font-semibold text-[#007b83] group-hover:underline inline-flex items-center space-x-1">
                                <span>Detail Layanan</span>
                                <span>&rarr;</span>
                            </a>
                            <a href="{{ route('registration') }}" class="text-xs font-semibold text-white bg-[#007b83] hover:bg-[#005b64] px-3 py-1.5 rounded-lg shadow-sm">
                                Pendaftaran
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-16 bg-white rounded-3xl border border-slate-200">
                    <p class="text-slate-500 text-sm">Tidak ada layanan dalam kategori ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
</x-layouts.app>
