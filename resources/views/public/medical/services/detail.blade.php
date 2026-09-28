<x-layouts.app :title="$service['title'] . ' — RSUD R.A.A. Tjokronegoro'" :meta-description="$service['excerpt']">
<!-- Header Banner -->
<section class="bg-gradient-to-r from-slate-900 to-[#005b64] text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-xs text-teal-200 mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <a href="{{ route('services') }}" class="hover:text-white">Layanan RS</a>
            <span>/</span>
            <span class="text-white font-medium">{{ $service['title'] }}</span>
        </nav>
        <span class="text-xs font-bold text-teal-300 uppercase tracking-widest bg-teal-500/20 px-3 py-1 rounded-full border border-teal-400/30">{{ $service['tag'] }}</span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mt-3 leading-tight">{{ $service['title'] }}</h1>
    </div>
</section>

<!-- Detail Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Main Content (8 cols) -->
            <div class="lg:col-span-8 space-y-8">
                <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-100">
                    <img src="{{ $service['image'] }}" alt="{{ $service['title'] }}" class="w-full h-[400px] object-cover">
                </div>

                <div class="prose max-w-none text-slate-700 space-y-4 text-sm sm:text-base leading-relaxed">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Deskripsi Layanan</h2>
                    <p>{{ $service['excerpt'] }}</p>
                    <p>
                        Unit ini didukung oleh tenaga medis, dokter spesialis, serta paramedis berpengalaman yang siap memberikan pelayanan paripurna sesuai standar keselamatan pasien internasional. Tata kelola ruang pemeriksaan dan peralatan dirancang untuk menciptakan kenyamanan serta privasi maksimal bagi setiap pasien dan keluarga pendamping.
                    </p>

                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 pt-4">Fasilitas & Kapabilitas</h2>
                    <ul class="space-y-2 list-none pl-0">
                        @foreach($service['facilities'] as $fac)
                            <li class="flex items-center space-x-3 bg-slate-50 p-3 rounded-xl border border-slate-100 text-xs sm:text-sm">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>{{ $fac }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 pt-4">Alur dan Prosedur Pelayanan</h2>
                    <ol class="space-y-3 list-decimal pl-5 text-xs sm:text-sm">
                        <li>Pasien melakukan pendaftaran mandiri secara online melalui aplikasi <strong>SAPA RSTN</strong> atau loket pendaftaran di rumah sakit.</li>
                        <li>Melakukan verifikasi berkas administrasi (BPJS Kesehatan, Asuransi Lain, atau Pasien Umum).</li>
                        <li>Pemeriksaan tanda-tanda vital oleh perawat poliklinik atau triase darurat.</li>
                        <li>Konsultasi, pemeriksaan fisik, atau tindakan medis oleh Dokter Penanggung Jawab Pelayanan (DPJP).</li>
                        <li>Pelayanan resep obat di Instalasi Farmasi dan penyelesaian administrasi kepulangan / tindak lanjut rujukan.</li>
                    </ol>
                </div>
            </div>

            <!-- Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Registration / Action Card -->
                <div class="bg-gradient-to-br from-teal-50 to-slate-50 p-6 rounded-3xl border border-teal-200 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-slate-900">Perlu Bantuan atau Pendaftaran?</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Manfaatkan layanan pendaftaran antrean rawat jalan online untuk kemudahan kunjungan Anda tanpa harus mengantre lama.
                    </p>
                    <a href="{{ route('registration') }}" class="block w-full text-center py-3 rounded-xl font-bold text-sm text-white bg-[#007b83] hover:bg-[#005b64] shadow-md transition">
                        Daftar Antrean Online
                    </a>
                    <a href="tel:0275321118" class="block w-full text-center py-2.5 rounded-xl font-semibold text-xs text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 transition">
                        Hubungi Hotline (0275) 321118
                    </a>
                </div>

                <!-- Related Services -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-b pb-2">Layanan Terkait</h4>
                    <div class="space-y-4">
                        @foreach($relatedServices as $rel)
                            <a href="{{ route('services.detail', $rel['slug']) }}" class="flex items-center space-x-3 group">
                                <img src="{{ $rel['image'] }}" alt="{{ $rel['title'] }}" class="w-14 h-14 rounded-xl object-cover shrink-0">
                                <div>
                                    <span class="text-xs font-bold text-slate-800 group-hover:text-[#007b83] transition block leading-snug">{{ $rel['title'] }}</span>
                                    <span class="text-[11px] text-teal-600">{{ $rel['tag'] }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</x-layouts.app>
