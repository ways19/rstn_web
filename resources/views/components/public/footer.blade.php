<!-- Comprehensive Footer (Public) -->
<footer class="bg-[#0b1e32] text-slate-300 pt-16 pb-12 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            <!-- Col 1: About & Accreditation -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('logo.png') }}" alt="Logo RSUD R.A.A. Tjokronegoro" class="h-12 w-auto bg-white p-1 rounded-lg" onerror="this.src='https://ui-avatars.com/api/?name=RSTN&background=007B83&color=fff'">
                    <div>
                        <span class="text-white font-bold text-base sm:text-lg block leading-tight whitespace-nowrap">RSUD R.A.A. Tjokronegoro</span>
                        <span class="text-xs sm:text-sm text-teal-400 whitespace-nowrap">Kabupaten Purworejo</span>
                    </div>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Rumah Sakit Umum Daerah milik Pemerintah Kabupaten Purworejo dengan komitmen memberikan pelayanan kesehatan berkualitas, cepat, aman, dan berorientasi pada keselamatan pasien.
                </p>
                <div class="pt-2">
                    <div class="inline-flex items-center space-x-2 bg-slate-800/80 px-3 py-1.5 rounded-lg border border-teal-500/30 text-xs sm:text-sm">
                        <span class="text-teal-400 font-bold">★ TERAKREDITASI KARS</span>
                        <span class="text-slate-400">— PARIPURNA</span>
                    </div>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div>
                <h4 class="text-white font-semibold text-sm sm:text-base uppercase tracking-wider mb-4 border-b border-slate-700 pb-2">Navigasi Utama</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-teal-300 transition">Beranda</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-teal-300 transition">Profil & Visi Misi</a></li>
                    <li><a href="{{ route('services') }}" class="hover:text-teal-300 transition">Layanan Rawat Jalan & Inap</a></li>
                    <li><a href="{{ route('doctors') }}" class="hover:text-teal-300 transition">Jadwal Dokter Spesialis</a></li>
                    <li><a href="{{ route('registration') }}" class="hover:text-teal-300 transition">Alur Pendaftaran Online</a></li>
                    <li><a href="{{ route('information') }}" class="hover:text-teal-300 transition">Ketersediaan Tempat Tidur</a></li>
                    <li><a href="{{ route('news') }}" class="hover:text-teal-300 transition">Berita & Informasi PKRS</a></li>
                </ul>
            </div>

            <!-- Col 3: Layanan Unggulan -->
            <div>
                <h4 class="text-white font-semibold text-sm sm:text-base uppercase tracking-wider mb-4 border-b border-slate-700 pb-2">Layanan Unggulan</h4>
                <ul class="space-y-2.5 text-sm text-slate-400">
                    <li class="flex items-center space-x-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
                        <span>Instalasi Gawat Darurat (24 Jam)</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
                        <span>Unit Hemodialisa (Cuci Darah)</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
                        <span>Instalasi Bedah Sentral Modern</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
                        <span>Radiologi Digital & USG 4D</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
                        <span>Laboratorium Patologi 24 Jam</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
                        <span>Farmasi & Konseling Obat</span>
                    </li>
                </ul>
            </div>

            <!-- Col 4: Kontak & Alamat -->
            <div>
                <h4 class="text-white font-semibold text-sm sm:text-base uppercase tracking-wider mb-4 border-b border-slate-700 pb-2">Kontak & Lokasi</h4>
                <address class="not-italic text-sm text-slate-400 space-y-3">
                    <p class="flex items-start space-x-2">
                        <svg class="w-4 h-4 text-teal-400 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Jl. Jenderal Sudirman No. 60, Pangenjurutengah, Kec. Purworejo, Kabupaten Purworejo, Jawa Tengah 54114</span>
                    </p>
                    <p class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>Telp: (0275) 321118</span>
                    </p>
                    <p class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>rsud.tjokronegoro@purworejokab.go.id</span>
                    </p>
                </address>
            </div>
        </div>

        <!-- Bottom Copyright & Disclaimer -->
        <div class="mt-12 pt-6 border-t border-slate-800 text-center md:flex md:justify-between md:items-center text-xs sm:text-sm text-slate-400">
            <p>&copy; {{ date('Y') }} RSUD R.A.A. Tjokronegoro Purworejo. Hak Cipta Dilindungi Undang-Undang.</p>
            <div class="mt-3 md:mt-0 space-x-4">
                <a href="{{ route('sitemap') }}" class="hover:text-slate-200">Peta Situs (Sitemap)</a>
                <span>•</span>
                <a href="{{ route('robots') }}" class="hover:text-slate-200">Robots.txt</a>
                <span>•</span>
                <a href="{{ route('contact') }}" class="hover:text-slate-200">Pengaduan Masyarakat</a>
            </div>
        </div>
    </div>
</footer>

<!-- Mobile Sticky Quick Action Bar -->
<div class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 px-3 py-2 shadow-2xl flex items-center justify-around text-center text-xs">
    <a href="tel:0275321118" class="flex flex-col items-center text-red-600 font-semibold py-1">
        <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
        <span>IGD 24 Jam</span>
    </a>
    <a href="{{ route('doctors') }}" class="flex flex-col items-center text-slate-700 font-semibold py-1">
        <svg class="w-5 h-5 mb-0.5 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        <span>Jadwal Dokter</span>
    </a>
    <a href="https://wa.me/628112521118" target="_blank" rel="noopener" class="flex flex-col items-center text-emerald-600 font-semibold py-1">
        <svg class="w-5 h-5 mb-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
        <span>WhatsApp</span>
    </a>
    <a href="{{ route('registration') }}" class="flex items-center space-x-1 bg-[#007b83] text-white px-3 py-1.5 rounded-full font-bold shadow-md">
        <span>Daftar Online</span>
    </a>
</div>
