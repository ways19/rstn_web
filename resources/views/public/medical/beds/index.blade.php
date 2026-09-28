<x-layouts.app title="Informasi Publik &amp; Ketersediaan Tempat Tidur — RSUD R.A.A. Tjokronegoro" meta-description="Ketersediaan tempat tidur rawat inap terkini, tata tertib jam besuk, hak &amp; kewajiban pasien, dan FAQ di RSUD R.A.A. Tjokronegoro Purworejo.">
<!-- Header Banner -->
<section class="bg-gradient-to-r from-slate-900 to-[#005b64] text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="text-xs font-bold text-teal-300 uppercase tracking-widest bg-teal-500/20 px-3 py-1 rounded-full border border-teal-400/30">Transparansi Layanan</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mt-3 leading-tight">Informasi Publik & Ketersediaan Kamar</h1>
            <p class="text-slate-300 text-sm sm:text-base mt-3 leading-relaxed">
                Pantau ketersediaan bed rawat inap secara real-time, panduan tata tertib pengunjung, dan informasi hak pasien.
            </p>
        </div>
    </div>
</section>

<!-- Bed Monitoring Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8">
            <div>
                <span class="text-xs font-bold text-[#007b83] uppercase tracking-wider bg-teal-50 px-3 py-1 rounded-full">Monitoring Rawat Inap</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Ketersediaan Tempat Tidur (Bed Monitoring)</h2>
                <p class="text-slate-500 text-xs mt-1">Data diperbarui otomatis sesuai sistem informasi manajemen rumah sakit (SIMRS).</p>
            </div>
            <div class="mt-4 sm:mt-0 text-xs text-slate-400">
                Update Terakhir: <strong class="text-slate-700">{{ date('d M Y, H:i') }} WIB</strong>
            </div>
        </div>

        <!-- Bed Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($beds as $bed)
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-bold text-slate-900">{{ $bed['class'] }}</h3>
                            <span class="text-[11px] font-semibold text-slate-500 bg-white px-2 py-0.5 rounded-full border border-slate-200">{{ $bed['gender'] }}</span>
                        </div>

                        <div class="my-4 flex items-baseline justify-between">
                            <div>
                                <span class="text-xs text-slate-400 block">Kosong (Tersedia)</span>
                                <span class="text-3xl font-black {{ $bed['available'] > 0 ? 'text-[#007b83]' : 'text-red-500' }}">
                                    {{ $bed['available'] }}
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-slate-400 block">Total Kapasitas</span>
                                <span class="text-lg font-bold text-slate-700">{{ $bed['total'] }}</span>
                            </div>
                        </div>

                        <!-- Mini progress bar -->
                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                            @php
                                $percent = $bed['total'] > 0 ? round(($bed['occupied'] / $bed['total']) * 100) : 0;
                            @endphp
                            <div class="bg-teal-600 h-2 rounded-full" style="width: {{ $percent }}%;"></div>
                        </div>
                    </div>

                    <div class="pt-3 mt-3 border-t border-slate-200 flex justify-between text-[11px] text-slate-500">
                        <span>Terisi: {{ $bed['occupied'] }}</span>
                        <span>Okupansi: {{ $percent }}%</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Tata Tertib & Jam Kunjungan Besuk -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 space-y-4">
                <span class="text-xs font-bold text-[#007b83] uppercase tracking-wider bg-teal-100/60 px-3 py-1 rounded-full">Kenyamanan Pasien</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-snug">
                    Tata Tertib Jam Kunjungan Pasien Rawat Inap
                </h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Demi kesembuhan, istirahat optimal, dan keselamatan pasien dari risiko infeksi nasokomial, jam besuk diatur sebagai berikut:
                </p>

                <div class="space-y-3 pt-2">
                    <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">Sesi Siang</span>
                            <span class="text-xs text-slate-500">Senin — Minggu & Hari Libur</span>
                        </div>
                        <span class="text-sm font-bold text-[#007b83] bg-teal-50 px-3 py-1.5 rounded-xl border border-teal-200">
                            11.00 — 13.00 WIB
                        </span>
                    </div>

                    <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">Sesi Sore</span>
                            <span class="text-xs text-slate-500">Senin — Minggu & Hari Libur</span>
                        </div>
                        <span class="text-sm font-bold text-[#007b83] bg-teal-50 px-3 py-1.5 rounded-xl border border-teal-200">
                            17.00 — 19.00 WIB
                        </span>
                    </div>
                </div>

                <ul class="text-xs text-slate-500 space-y-2 pt-2">
                    <li class="flex items-center space-x-2">
                        <span class="text-red-500 font-bold">•</span>
                        <span>Anak usia di bawah 12 tahun tidak diperkenankan memasuki area ruang perawatan.</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-red-500 font-bold">•</span>
                        <span>Maksimal 2 orang penunggu per pasien dengan kartu penunggu resmi.</span>
                    </li>
                </ul>
            </div>

            <!-- FAQ Accordion with Alpine.js -->
            <div class="lg:col-span-6 bg-white p-8 rounded-3xl shadow-sm border border-slate-200" x-data="{ activeFaq: null }">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Tanya Jawab</span>
                <h3 class="text-xl font-bold text-slate-900 mt-1 mb-6">Pertanyaan yang Sering Diajukan (FAQ)</h3>

                <div class="space-y-3">
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <button @click="activeFaq = activeFaq === 1 ? null : 1" class="w-full text-left p-4 text-xs sm:text-sm font-bold text-slate-800 flex justify-between items-center bg-slate-50">
                            <span>Bagaimana cara mendaftar rawat jalan dengan BPJS Kesehatan?</span>
                            <span x-text="activeFaq === 1 ? '−' : '+'" class="text-base font-bold text-teal-700"></span>
                        </button>
                        <div x-show="activeFaq === 1" class="p-4 text-xs text-slate-600 border-t border-slate-100 bg-white leading-relaxed">
                            Pastikan Anda telah memiliki surat rujukan aktif dari Faskes Tingkat Pertama (Puskesmas/Klinik). Anda dapat mendaftar mandiri via aplikasi Mobile JKN atau sistem SAPA RSTN di web ini untuk mendapatkan nomor antrean.
                        </div>
                    </div>

                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <button @click="activeFaq = activeFaq === 2 ? null : 2" class="w-full text-left p-4 text-xs sm:text-sm font-bold text-slate-800 flex justify-between items-center bg-slate-50">
                            <span>Apakah IGD melayani rujukan dari luar kota?</span>
                            <span x-text="activeFaq === 2 ? '−' : '+'" class="text-base font-bold text-teal-700"></span>
                        </button>
                        <div x-show="activeFaq === 2" class="p-4 text-xs text-slate-600 border-t border-slate-100 bg-white leading-relaxed">
                            Ya, IGD RSUD R.A.A. Tjokronegoro melayani kasus kegawatdaruratan medis 24 jam untuk seluruh pasien umum maupun rujukan dari rumah sakit lain / puskesmas lintas wilayah.
                        </div>
                    </div>

                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <button @click="activeFaq = activeFaq === 3 ? null : 3" class="w-full text-left p-4 text-xs sm:text-sm font-bold text-slate-800 flex justify-between items-center bg-slate-50">
                            <span>Bagaimana prosedur pelayanan rawat inap?</span>
                            <span x-text="activeFaq === 3 ? '−' : '+'" class="text-base font-bold text-teal-700"></span>
                        </button>
                        <div x-show="activeFaq === 3" class="p-4 text-xs text-slate-600 border-t border-slate-100 bg-white leading-relaxed">
                            Pasien rawat inap dapat masuk melalui rujukan Poliklinik atau rujukan darurat dari IGD. Bagian admisi akan mengarahkan keluarga untuk memilih kelas kamar sesuai hak kepesertaan atau keinginan pasien.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</x-layouts.app>
