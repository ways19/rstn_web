<x-layouts.app title="RSUD R.A.A. Tjokronegoro Purworejo — Melayani dengan Sepenuh Hati" meta-description="Website Resmi RSUD R.A.A. Tjokronegoro Purworejo. Rumah Sakit Umum Daerah terakreditasi Paripurna dengan IGD 24 Jam, poliklinik spesialis lengkap, pendaftaran online, dan kamar rawat inap modern.">
<!-- Hero Carousel Section with Alpine.js -->
<section class="relative bg-slate-900 text-white overflow-hidden" 
         x-data="{ 
            currentSlide: 0, 
            slides: [
                {
                    title: 'Layanan Medis Modern & Profesional',
                    subtitle: 'Pusat Rujukan Kesehatan Terpercaya di Purworejo',
                    desc: 'Berkomitmen memberikan pelayanan kesehatan paripurna dengan sentuhan humanis, didukung dokter spesialis berpengalaman dan teknologi medis mutakhir.',
                    ctaText: 'Pendaftaran Online',
                    ctaLink: '{{ route('registration') }}',
                    ctaText2: 'Jadwal Dokter',
                    ctaLink2: '{{ route('doctors') }}',
                    bg: 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1600&q=80'
                },
                {
                    title: 'IGD 24 Jam & Ambulans Siaga',
                    subtitle: 'Cepat, Tepat, dan Mengutamakan Keselamatan',
                    desc: 'Tim gawat darurat terlatih siap 24 jam melayani situasi darurat medis dengan fasilitas resusitasi berstandar dan armada ambulans darurat.',
                    ctaText: 'Hubungi Hotline IGD',
                    ctaLink: 'tel:0275321118',
                    ctaText2: 'Alur Gawat Darurat',
                    ctaLink2: '{{ route('services.detail', 'igd-24-jam') }}',
                    bg: 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1600&q=80'
                },
                {
                    title: 'Fasilitas Rawat Inap Nyaman & Higienis',
                    subtitle: 'Pemulihan Optimal untuk Anda dan Keluarga',
                    desc: 'Dari ruang Kelas III hingga VVIP dengan standar akreditasi Paripurna KARS, mengutamakan keselamatan, ketenangan, dan kenyamanan pemulihan pasien.',
                    ctaText: 'Ketersediaan Kamar',
                    ctaLink: '{{ route('information') }}',
                    ctaText2: 'Profil Layanan Inap',
                    ctaLink2: '{{ route('services.detail', 'rawat-inap') }}',
                    bg: 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=1600&q=80'
                }
            ],
            autoplay() {
                setInterval(() => {
                    this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                }, 6000);
            }
         }" 
         x-init="autoplay()">
    
    <!-- Slides Container -->
    <div class="relative min-h-[520px] md:min-h-[580px] flex items-center">
        <template x-for="(slide, index) in slides" :key="index">
            <div x-cloak
                 x-show="currentSlide === index"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0">
                <!-- Background Image with Gradient Overlay -->
                <div class="absolute inset-0 bg-cover bg-center transition-all duration-1000 transform"
                     :style="`background-image: url('${slide.bg}');`"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/80 to-transparent"></div>

                <!-- Slide Content -->
                <div class="relative max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center py-20">
                    <div class="max-w-2xl space-y-5">
                        <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-teal-500/20 border border-teal-400/40 text-teal-300 text-xs font-semibold tracking-wide">
                            <span class="w-2 h-2 rounded-full bg-teal-400 animate-ping"></span>
                            <span x-text="slide.subtitle"></span>
                        </div>
                        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight" x-text="slide.title"></h1>
                        <p class="text-slate-300 text-sm sm:text-base md:text-lg leading-relaxed max-w-xl" x-text="slide.desc"></p>
                        
                        <div class="pt-4 flex flex-wrap gap-4">
                            <a :href="slide.ctaLink" class="inline-flex items-center space-x-2 px-6 py-3.5 rounded-xl font-bold text-sm text-white bg-[#007b83] hover:bg-[#005b64] shadow-lg shadow-teal-900/40 transition transform hover:-translate-y-0.5">
                                <span x-text="slide.ctaText"></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <a :href="slide.ctaLink2" class="inline-flex items-center space-x-2 px-6 py-3.5 rounded-xl font-semibold text-sm text-white bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 transition">
                                <span x-text="slide.ctaText2"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Carousel Indicators -->
    <div class="absolute bottom-6 left-0 right-0 z-20 flex justify-center space-x-2">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="currentSlide = index" 
                    class="h-2 rounded-full transition-all duration-300"
                    :class="currentSlide === index ? 'w-8 bg-teal-400' : 'w-2 bg-white/40 hover:bg-white/70'"
                    :aria-label="`Slide ${index + 1}`">
            </button>
        </template>
    </div>
</section>

<!-- Quick Action Service Cards (Overlap Bar) -->
<section class="relative z-30 max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 sm:-mt-14">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Pendaftaran Online -->
        <a href="{{ route('registration') }}" class="group bg-white rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-slate-100 flex items-start space-x-4 transform hover:-translate-y-1">
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-[#007b83] flex items-center justify-center shrink-0 group-hover:bg-[#007b83] group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-800 group-hover:text-[#007b83] transition">Pendaftaran Online</h2>
                <p class="text-sm text-slate-600 mt-1 leading-relaxed">Daftar rawat jalan via SAPA RSTN & Mobile JKN mandiri tanpa antre.</p>
                <span class="inline-flex items-center text-sm font-semibold text-[#007b83] mt-2 group-hover:underline">
                    Daftar Sekarang &rarr;
                </span>
            </div>
        </a>

        <!-- Card 2: Jadwal Dokter -->
        <a href="{{ route('doctors') }}" class="group bg-white rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-slate-100 flex items-start space-x-4 transform hover:-translate-y-1">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-800 group-hover:text-blue-600 transition">Jadwal Dokter</h2>
                <p class="text-sm text-slate-600 mt-1 leading-relaxed">Cek jadwal praktik dokter spesialis dan ketersediaan poliklinik.</p>
                <span class="inline-flex items-center text-sm font-semibold text-blue-600 mt-2 group-hover:underline">
                    Lihat Jadwal &rarr;
                </span>
            </div>
        </a>

        <!-- Card 3: Ketersediaan Kamar -->
        <a href="{{ route('information') }}" class="group bg-white rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 border border-slate-100 flex items-start space-x-4 transform hover:-translate-y-1">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 group-hover:bg-amber-600 group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-800 group-hover:text-amber-600 transition">Informasi Kamar</h2>
                <p class="text-sm text-slate-600 mt-1 leading-relaxed">Ketersediaan bed rawat inap VVIP, VIP, Kelas 1, 2, 3, dan ICU.</p>
                <span class="inline-flex items-center text-sm font-semibold text-amber-600 mt-2 group-hover:underline">
                    Cek Ketersediaan &rarr;
                </span>
            </div>
        </a>

        <!-- Card 4: IGD 24 Jam -->
        <a href="tel:0275321118" class="group bg-gradient-to-br from-red-600 to-rose-700 text-white rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 flex items-start space-x-4 transform hover:-translate-y-1">
            <div class="w-12 h-12 rounded-xl bg-white/20 text-white flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
            <div>
                <h2 class="text-base font-bold text-white">IGD 24 Jam</h2>
                <p class="text-sm text-red-100 mt-1 leading-relaxed">Layanan kegawatdaruratan dan armada ambulans siaga 24/7.</p>
                <span class="inline-flex items-center text-sm font-bold text-amber-300 mt-2">
                    (0275) 321118 &rarr;
                </span>
            </div>
        </a>
    </div>
</section>

<!-- Profile Summary & Nilai SAPA -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left: Hospital Image Banner -->
            <div class="lg:col-span-5 relative">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=800&q=80" alt="Gedung RSUD R.A.A. Tjokronegoro" class="w-full h-[400px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <span class="text-xs uppercase tracking-widest text-teal-300 font-bold block">Akreditasi Paripurna</span>
                        <h3 class="text-xl font-bold">RSUD R.A.A. Tjokronegoro</h3>
                        <p class="text-xs text-slate-300 mt-1">Jl. Jend. Sudirman No. 60 Purworejo, Jawa Tengah</p>
                    </div>
                </div>
                <!-- Small Experience Card -->
                <div class="absolute -bottom-6 -right-4 bg-teal-800 text-white p-4 rounded-2xl shadow-xl hidden sm:flex items-center space-x-3 border-2 border-white">
                    <div class="text-3xl font-black">24<span class="text-sm font-normal">/7</span></div>
                    <div class="text-xs leading-tight">
                        <span class="font-bold block">Siaga Medis</span>
                        <span class="text-teal-200">Non-Stop Setiap Hari</span>
                    </div>
                </div>
            </div>

            <!-- Right: Content & Core Values -->
            <div class="lg:col-span-7 space-y-6">
                <div>
                    <span class="text-xs font-bold text-[#007b83] uppercase tracking-wider bg-teal-50 px-3 py-1 rounded-full border border-teal-200">Profil Rumah Sakit</span>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 mt-3 leading-tight">
                        Pusat Pelayanan Kesehatan Unggul, Ramah, dan Terpercaya
                    </h2>
                </div>

                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    RSUD R.A.A. Tjokronegoro hadir sebagai wujud nyata komitmen Pemerintah Kabupaten Purworejo dalam memberikan layanan kesehatan yang prima, modern, dan mudah diakses oleh seluruh lapisan masyarakat.
                </p>

                <!-- Core Values (SAPA) -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-center">
                        <span class="text-2xl font-black text-[#007b83]">S</span>
                        <h4 class="text-xs font-bold text-slate-800 mt-1">Sigap</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Cepat & tanggap melayani</p>
                    </div>
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-center">
                        <span class="text-2xl font-black text-blue-600">A</span>
                        <h4 class="text-xs font-bold text-slate-800 mt-1">Akuntabel</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Transparan & bertanggung jawab</p>
                    </div>
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-center">
                        <span class="text-2xl font-black text-emerald-600">P</span>
                        <h4 class="text-xs font-bold text-slate-800 mt-1">Profesional</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Sesuai standar medis tertinggi</p>
                    </div>
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-center">
                        <span class="text-2xl font-black text-amber-500">A</span>
                        <h4 class="text-xs font-bold text-slate-800 mt-1">Amanah</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Tulus & berintegritas</p>
                    </div>
                </div>

                <div class="pt-2 flex flex-wrap items-center gap-4">
                    <a href="{{ route('about') }}" class="inline-flex items-center space-x-2 text-sm font-bold text-[#007b83] hover:text-[#005b64] group">
                        <span>Pelajari Profil & Visi Misi Selengkapnya</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Key Stats Counter -->
<section class="py-12 bg-gradient-to-r from-[#005b64] to-[#007b83] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            @foreach($stats as $stat)
                <div class="p-4">
                    <div class="text-3xl sm:text-4xl md:text-5xl font-black text-teal-200 tracking-tight">{{ $stat['number'] }}</div>
                    <div class="text-xs sm:text-sm font-medium text-teal-100 mt-2">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Layanan Unggulan & Spesialis -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-xs font-bold text-[#007b83] uppercase tracking-wider bg-teal-100/60 px-3 py-1 rounded-full">Fasilitas & Pelayanan</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 mt-2">Layanan Medis Unggulan</h2>
                <p class="text-slate-600 text-sm max-w-xl mt-2">Didukung sarana prasarana canggih dan dokter spesialis kompeten di setiap bidang penanganan.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('services') }}" class="inline-flex items-center space-x-2 text-sm font-bold text-[#007b83] hover:text-[#005b64] group">
                    <span>Lihat Semua Layanan</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services->take(6) as $svc)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $svc['image'] }}" alt="{{ $svc['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-white/90 backdrop-blur-md text-slate-800 shadow">
                                {{ $svc['tag'] }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 group-hover:text-[#007b83] transition">
                                <a href="{{ route('services.detail', $svc['slug']) }}">
                                    {{ $svc['title'] }}
                                </a>
                            </h3>
                            <p class="text-sm text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                                {{ $svc['excerpt'] }}
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('services.detail', $svc['slug']) }}" class="text-sm font-semibold text-[#007b83] group-hover:underline inline-flex items-center space-x-1">
                                <span>Informasi Layanan</span>
                                <span>&rarr;</span>
                            </a>
                            <span class="text-xs text-slate-400">RSUD Tjokronegoro</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Dokter Spesialis & Jadwal Praktik (Interactive Filter via Alpine.js) -->
<section class="py-20 bg-white" x-data="{ 
    selectedSpeciality: 'semua',
    searchQuery: '',
    doctors: {{ Js::from($doctors) }},
    get filteredDoctors() {
        return this.doctors.filter(doc => {
            const matchSpec = this.selectedSpeciality === 'semua' || doc.speciality === this.selectedSpeciality;
            const matchSearch = doc.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                doc.speciality.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                doc.poli.toLowerCase().includes(this.searchQuery.toLowerCase());
            return matchSpec && matchSearch;
        });
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold text-[#007b83] uppercase tracking-wider bg-teal-50 px-3 py-1 rounded-full border border-teal-200">Tenaga Medis</span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 mt-2">Temukan Dokter Spesialis Kami</h2>
            <p class="text-slate-600 text-sm mt-2">Pilih poliklinik atau cari nama dokter untuk melihat jadwal praktik terkini.</p>
        </div>

        <!-- Search & Filter Controls -->
        <div class="max-w-3xl mx-auto mb-10 space-y-4">
            <div class="relative">
                <input type="text" 
                       x-model="searchQuery" 
                       placeholder="Cari nama dokter atau poliklinik (misal: penyakit dalam, dr. Anisa)..." 
                       class="w-full px-5 py-3.5 pl-12 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-teal-600 shadow-sm text-sm">
                <svg class="w-5 h-5 text-slate-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <!-- Category Pills -->
            <div class="flex flex-wrap justify-center gap-2">
                <button @click="selectedSpeciality = 'semua'" 
                        :class="selectedSpeciality === 'semua' ? 'bg-[#007b83] text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-4 py-1.5 rounded-full text-xs font-semibold transition">
                    Semua Spesialis
                </button>
                <template x-for="spec in [...new Set(doctors.map(d => d.speciality))]" :key="spec">
                    <button @click="selectedSpeciality = spec" 
                            :class="selectedSpeciality === spec ? 'bg-[#007b83] text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="px-4 py-1.5 rounded-full text-xs font-semibold transition"
                            x-text="spec">
                    </button>
                </template>
            </div>
        </div>

        <!-- Doctors Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="doctor in filteredDoctors" :key="doctor.id">
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex items-start space-x-4">
                    <img :src="doctor.photo" :alt="doctor.name" class="w-20 h-24 rounded-xl object-cover shrink-0 bg-slate-100 shadow-sm">
                    <div class="flex-grow">
                        <span class="text-xs font-semibold text-teal-700 bg-teal-50 px-2.5 py-0.5 rounded-full inline-block mb-1" x-text="doctor.poli"></span>
                        <h3 class="text-base font-bold text-slate-900 leading-snug" x-text="doctor.name"></h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5" x-text="doctor.sub"></p>
                        
                        <div class="mt-3 pt-2 border-t border-slate-100 text-xs text-slate-600">
                            <span class="font-semibold text-slate-700 block">Jadwal:</span>
                            <span class="text-xs text-teal-800 font-medium" x-text="doctor.schedule"></span>
                        </div>

                        <div class="mt-3 flex items-center justify-between">
                            <a :href="`{{ url('/dokter') }}/${doctor.id}`" class="text-sm font-semibold text-[#007b83] hover:underline">
                                Profil Lengkap &rarr;
                            </a>
                            <a href="{{ route('registration') }}" class="text-xs font-semibold text-white bg-[#007b83] hover:bg-[#005b64] px-3 py-1.5 rounded-lg shadow-sm">
                                Booking Poli
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div x-show="filteredDoctors.length === 0" class="text-center py-12 text-slate-500 text-sm">
            Tidak ditemukan dokter untuk kriteria pencarian tersebut.
        </div>
    </div>
</section>

<!-- Berita & Informasi PKRS -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-xs font-bold text-[#007b83] uppercase tracking-wider bg-teal-100/60 px-3 py-1 rounded-full">Kabar & Publikasi</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 mt-2">Berita & Edukasi Kesehatan</h2>
                <p class="text-slate-600 text-sm max-w-xl mt-2">Dapatkan informasi terkini seputar kegiatan rumah sakit dan panduan hidup sehat dari dokter ahli.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('news') }}" class="inline-flex items-center space-x-2 text-sm font-bold text-[#007b83] hover:text-[#005b64] group">
                    <span>Lihat Semua Berita</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($news as $item)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition border border-slate-100 flex flex-col group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-4 left-4 px-2.5 py-1 text-xs font-bold rounded-full bg-[#007b83] text-white shadow">
                            {{ $item['category'] }}
                        </span>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xs text-slate-400 font-medium">{{ $item['date'] }}</span>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 mt-2 leading-snug group-hover:text-[#007b83] transition">
                                <a href="{{ route('news.detail', $item['slug']) }}">
                                    {{ $item['title'] }}
                                </a>
                            </h3>
                            <p class="text-sm text-slate-600 mt-2.5 line-clamp-3 leading-relaxed">
                                {{ $item['excerpt'] }}
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-slate-100">
                            <a href="{{ route('news.detail', $item['slug']) }}" class="text-sm font-semibold text-[#007b83] group-hover:underline inline-flex items-center space-x-1">
                                <span>Baca Selengkapnya</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action Banner: Pendaftaran Online & Layanan SAPA RSTN -->
<section class="py-16 bg-[#005b64] text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8 space-y-3">
                <span class="text-xs font-bold text-teal-300 uppercase tracking-widest">Pendaftaran Pasien Tanpa Antre</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold leading-tight">
                    Daftar Rawat Jalan Mudah dari Rumah Melalui SAPA RSTN
                </h2>
                <p class="text-teal-100 text-sm sm:text-base max-w-2xl leading-relaxed">
                    Kini Anda dapat memilih poliklinik, menentukan dokter spesialis, serta mendapatkan nomor antrean online terintegrasi langsung dengan BPJS Kesehatan (Mobile JKN).
                </p>
            </div>
            <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-3 justify-end">
                <a href="{{ route('registration') }}" class="text-center px-6 py-3.5 rounded-xl font-bold text-sm bg-white text-[#005b64] hover:bg-teal-50 shadow-lg transition transform hover:-translate-y-0.5">
                    Mulai Pendaftaran Online
                </a>
                <a href="https://wa.me/628112521118" target="_blank" rel="noopener" class="text-center px-6 py-3.5 rounded-xl font-semibold text-sm bg-teal-700/60 hover:bg-teal-700 text-white border border-teal-400/30 backdrop-blur transition">
                    Tanya Layanan via WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>
</x-layouts.app>
