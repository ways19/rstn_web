<x-layouts.app :title="$service['title'] . ' — RSUD R.A.A. Tjokronegoro'" :meta-description="$service['excerpt']">
<x-page-header :title="$service['title']" :description="$service['excerpt']" />

{{-- Breadcrumb --}}
<div class="bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <nav class="flex flex-wrap items-center gap-2 py-5 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('services') }}" class="font-medium text-slate-500 hover:text-[#007b83]">Layanan</a>
            <span class="text-slate-300">&rsaquo;</span>
            <span class="font-semibold text-[#007b83]">{{ $service['title'] }}</span>
            <span class="ml-2 rounded-full border border-teal-200 bg-teal-50 px-3 py-0.5 text-xs font-bold uppercase tracking-wider text-[#007b83]">{{ $service['tag'] }}</span>
        </nav>
    </div>
</div>

<!-- Detail Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Main Content (8 cols) -->
            <div class="lg:col-span-8 space-y-8">
                @php
                    $panoramaSource = ! empty($service['image']) ? $service['image'] : asset('images/hospital-room-360.jpg');
                    $isEmbed360 = (
                        str_contains($panoramaSource, 'google.com/maps/embed') ||
                        str_contains($panoramaSource, 'kuula.co') ||
                        str_contains($panoramaSource, 'matterport.com') ||
                        str_contains($panoramaSource, 'panoraven.com') ||
                        str_contains($panoramaSource, '<iframe')
                    );
                @endphp

                @push('styles')
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
                    <style>
                        .pnlm-container {
                            background: #0f172a !important;
                            font-family: inherit !important;
                        }
                        .pnlm-load-box {
                            background-color: rgba(15, 23, 42, 0.85) !important;
                            border-radius: 1rem !important;
                        }
                    </style>
                @endpush

                <div
                    x-data="{
                        viewMode: '360',
                        autoRotate: true,
                        viewer: null,
                        isFullSphere: true,
                        panDirection: 1,
                        panTimer: null,
                        isDragging: false,
                        yawLimit: 180,
                        initViewer() {
                            if ({{ $isEmbed360 ? 'true' : 'false' }}) return;
                            const src = @js($panoramaSource);

                            const bootWithDimensions = (w, h) => {
                                if (!window.pannellum || !this.$refs.panoContainer) return;
                                const ratio = (w && h) ? (w / h) : 2;
                                // Cek apakah foto Equirectangular 360 penuh (rasio ~2:1) atau Panorama HP memanjang (rasio > 2.15)
                                this.isFullSphere = (ratio >= 1.85 && ratio <= 2.18);

                                let haov = 360;
                                let vaov = 180;
                                let hfov = 95;
                                let minHfov = 50;
                                let maxHfov = 115;
                                let minPitch = -85;
                                let maxPitch = 85;
                                let minYaw = -180;
                                let maxYaw = 180;

                                if (!this.isFullSphere) {
                                    if (ratio > 2.18) {
                                        // Mode Panorama HP (Cylindrical/Wide Panorama, misal 3.6:1)
                                        vaov = 56;
                                        haov = Math.min(350, Math.round(vaov * ratio));
                                        hfov = 68;
                                        minHfov = 40;
                                        maxHfov = 78;
                                        minPitch = -14;
                                        maxPitch = 14;
                                        this.yawLimit = Math.max(20, (haov / 2) - (hfov / 2) - 4);
                                        minYaw = -(haov / 2) + 5;
                                        maxYaw = (haov / 2) - 5;
                                    } else {
                                        // Foto standar (16:9 atau 4:3)
                                        haov = 130;
                                        vaov = Math.round(haov / Math.max(1.2, ratio));
                                        hfov = 70;
                                        minHfov = 45;
                                        maxHfov = 80;
                                        minPitch = -12;
                                        maxPitch = 12;
                                        this.yawLimit = 25;
                                        minYaw = -55;
                                        maxYaw = 55;
                                    }
                                }

                                this.viewer = window.pannellum.viewer(this.$refs.panoContainer, {
                                    type: 'equirectangular',
                                    panorama: src,
                                    autoLoad: true,
                                    autoRotate: this.isFullSphere ? -2 : false,
                                    compass: false,
                                    showControls: false,
                                    mouseZoom: true,
                                    hfov: hfov,
                                    minHfov: minHfov,
                                    maxHfov: maxHfov,
                                    haov: haov,
                                    vaov: vaov,
                                    minPitch: minPitch,
                                    maxPitch: maxPitch,
                                    minYaw: minYaw,
                                    maxYaw: maxYaw,
                                });

                                if (!this.isFullSphere) {
                                    this.startPingPongPan();
                                }
                            };

                            const loadAndMeasure = () => {
                                const img = new Image();
                                img.onload = () => bootWithDimensions(img.naturalWidth, img.naturalHeight);
                                img.onerror = () => bootWithDimensions(2048, 1024);
                                img.src = src;
                            };

                            if (window.pannellum) {
                                loadAndMeasure();
                            } else {
                                const script = document.createElement('script');
                                script.src = 'https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js';
                                script.onload = loadAndMeasure;
                                document.head.appendChild(script);
                            }
                        },
                        startPingPongPan() {
                            if (this.panTimer) clearInterval(this.panTimer);
                            this.panTimer = setInterval(() => {
                                if (!this.viewer || !this.autoRotate || this.isDragging || this.viewMode !== '360') return;
                                let currentYaw = this.viewer.getYaw();
                                let nextYaw = currentYaw + (this.panDirection * 0.25);
                                if (nextYaw >= this.yawLimit) {
                                    nextYaw = this.yawLimit;
                                    this.panDirection = -1;
                                } else if (nextYaw <= -this.yawLimit) {
                                    nextYaw = -this.yawLimit;
                                    this.panDirection = 1;
                                }
                                this.viewer.setYaw(nextYaw, false);
                            }, 30);
                        },
                        toggleAutoRotate() {
                            if (!this.viewer) return;
                            if (this.autoRotate) {
                                if (this.isFullSphere) this.viewer.stopAutoRotate();
                                this.autoRotate = false;
                            } else {
                                if (this.isFullSphere) this.viewer.startAutoRotate(-2);
                                this.autoRotate = true;
                            }
                        },
                        zoomIn() {
                            if (this.viewer) this.viewer.setHfov(this.viewer.getHfov() - 8);
                        },
                        zoomOut() {
                            if (this.viewer) this.viewer.setHfov(this.viewer.getHfov() + 8);
                        },
                        resetView() {
                            if (!this.viewer) return;
                            this.viewer.setPitch(0);
                            this.viewer.setYaw(0);
                        },
                        fullscreen() {
                            if (this.viewer) this.viewer.toggleFullscreen();
                        }
                    }"
                    x-init="initViewer()"
                    @mousedown="isDragging = true"
                    @mouseup.window="isDragging = false"
                    @touchstart.passive="isDragging = true"
                    @touchend.window="isDragging = false"
                    class="relative rounded-3xl overflow-hidden shadow-lg border border-slate-200 bg-slate-900"
                >
                    {{-- Top Overlay Bar: 360 Badge & Mode Switcher --}}
                    <div class="absolute top-4 left-4 right-4 z-20 flex flex-wrap items-center justify-between gap-2 pointer-events-none">
                        <div class="pointer-events-auto inline-flex items-center gap-2 rounded-full bg-slate-900/80 backdrop-blur-md px-3.5 py-1.5 text-xs font-semibold text-white border border-white/15 shadow-lg">
                            <span class="flex h-2 w-2 rounded-full bg-teal-400 animate-pulse"></span>
                            <span>360° Virtual Tour</span>
                            <span class="hidden sm:inline text-slate-300 font-normal">&bull; Geser untuk melihat keliling ruangan</span>
                        </div>

                        <div class="pointer-events-auto inline-flex rounded-xl bg-slate-900/80 backdrop-blur-md p-1 border border-white/15 shadow-lg">
                            <button
                                type="button"
                                @click="viewMode = '360'"
                                :class="viewMode === '360' ? 'bg-[#007b83] text-white shadow' : 'text-slate-300 hover:text-white'"
                                class="px-3 py-1 rounded-lg text-xs font-bold transition cursor-pointer"
                            >
                                360° View
                            </button>
                            <button
                                type="button"
                                @click="viewMode = 'photo'"
                                :class="viewMode === 'photo' ? 'bg-[#007b83] text-white shadow' : 'text-slate-300 hover:text-white'"
                                class="px-3 py-1 rounded-lg text-xs font-bold transition cursor-pointer"
                            >
                                Foto Standar
                            </button>
                        </div>
                    </div>

                    {{-- 360° Panorama Container --}}
                    <div x-show="viewMode === '360'" class="relative w-full h-[420px] sm:h-[460px]">
                        @if($isEmbed360)
                            @if(str_contains($panoramaSource, '<iframe'))
                                <div class="w-full h-full [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-0">
                                    {!! $panoramaSource !!}
                                </div>
                            @else
                                <iframe src="{{ $panoramaSource }}" class="w-full h-full border-0" allowfullscreen loading="lazy"></iframe>
                            @endif
                        @else
                            <div x-ref="panoContainer" class="w-full h-full cursor-grab active:cursor-grabbing"></div>

                            {{-- Bottom Floating 360 Controls --}}
                            <div class="absolute bottom-4 right-4 z-20 flex items-center gap-1.5 rounded-2xl bg-slate-900/80 backdrop-blur-md p-1.5 border border-white/15 shadow-lg">
                                <button
                                    type="button"
                                    @click="toggleAutoRotate()"
                                    class="px-3 py-1.5 rounded-xl text-xs font-semibold text-white hover:bg-white/15 transition flex items-center gap-1.5 cursor-pointer"
                                    title="Putar Otomatis"
                                >
                                    <span x-text="autoRotate ? '⏸ Hentikan Putar' : '▶ Putar 360°'"></span>
                                </button>
                                <button
                                    type="button"
                                    @click="zoomIn()"
                                    class="w-8 h-8 rounded-xl text-sm font-bold text-white hover:bg-white/15 transition flex items-center justify-center cursor-pointer"
                                    title="Perbesar"
                                >
                                    +
                                </button>
                                <button
                                    type="button"
                                    @click="zoomOut()"
                                    class="w-8 h-8 rounded-xl text-sm font-bold text-white hover:bg-white/15 transition flex items-center justify-center cursor-pointer"
                                    title="Perkecil"
                                >
                                    &minus;
                                </button>
                                <button
                                    type="button"
                                    @click="resetView()"
                                    class="px-2.5 py-1.5 rounded-xl text-xs font-semibold text-slate-200 hover:bg-white/15 transition cursor-pointer"
                                    title="Reset Arah Pandang"
                                >
                                    Reset
                                </button>
                                <button
                                    type="button"
                                    @click="fullscreen()"
                                    class="px-2.5 py-1.5 rounded-xl text-xs font-semibold bg-teal-600/90 hover:bg-teal-500 text-white transition cursor-pointer"
                                    title="Layar Penuh"
                                >
                                    ⛶ Fullscreen
                                </button>
                            </div>
                        @endif
                    </div>

                    {{-- Fallback / Standard Photo View --}}
                    <div x-show="viewMode === 'photo'" x-cloak class="w-full h-[420px] sm:h-[460px]">
                        <img src="{{ $panoramaSource }}" alt="{{ $service['title'] }}" class="w-full h-full object-cover">
                    </div>
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
