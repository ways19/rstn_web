<x-layouts.app title="Pendaftaran Online Pasien Rawat Jalan — RSUD R.A.A. Tjokronegoro" meta-description="Layanan pendaftaran dan booking antrean online rawat jalan RSUD R.A.A. Tjokronegoro Purworejo. Bebas antre, mudah, dan terintegrasi BPJS Kesehatan.">
<!-- Header Banner -->
<section class="bg-gradient-to-r from-slate-900 to-[#005b64] text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="text-xs font-bold text-teal-300 uppercase tracking-widest bg-teal-500/20 px-3 py-1 rounded-full border border-teal-400/30">Layanan Antrean Mandiri</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mt-3 leading-tight">Pendaftaran Rawat Jalan Online</h1>
            <p class="text-slate-300 text-sm sm:text-base mt-3 leading-relaxed">
                Ambil nomor antrean poliklinik dari rumah. Praktis, cepat, dan terhubung langsung dengan sistem rekam medis elektronik rumah sakit.
            </p>
        </div>
    </div>
</section>

<!-- Main Registration Section with Alpine.js -->
<section class="py-16 bg-slate-50" x-data="{
    step: 1,
    patientType: 'lama', // 'baru' | 'lama'
    insurance: 'bpjs', // 'bpjs' | 'umum' | 'asuransi'
    nik: '',
    rm: '',
    nama: '',
    phone: '',
    tglKunjungan: '',
    poli: '',
    dokter: '',
    nomorAntrean: 'A-024',
    isSubmitted: false,
    
    submitRegistration() {
        if(!this.nama || !this.poli || !this.tglKunjungan) {
            alert('Mohon lengkapi data Nama, Poliklinik, dan Tanggal Kunjungan.');
            return;
        }
        this.nomorAntrean = (this.poli.includes('Anak') ? 'B-' : 'A-') + Math.floor(10 + Math.random() * 89);
        this.isSubmitted = true;
        this.step = 3;
    },
    resetForm() {
        this.step = 1;
        this.isSubmitted = false;
        this.nama = '';
        this.nik = '';
        this.rm = '';
        this.phone = '';
        this.poli = '';
        this.dokter = '';
    }
}">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Alur Booking Steps Indicator -->
        <div class="mb-10 bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between text-xs font-bold">
                <div class="flex items-center space-x-2" :class="step >= 1 ? 'text-[#007b83]' : 'text-slate-400'">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center border-2" 
                          :class="step >= 1 ? 'border-[#007b83] bg-teal-50 text-[#007b83]' : 'border-slate-300 text-slate-400'">1</span>
                    <span class="hidden sm:inline">Identitas Pasien</span>
                </div>
                <div class="h-0.5 flex-grow mx-4" :class="step >= 2 ? 'bg-[#007b83]' : 'bg-slate-200'"></div>
                <div class="flex items-center space-x-2" :class="step >= 2 ? 'text-[#007b83]' : 'text-slate-400'">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center border-2"
                          :class="step >= 2 ? 'border-[#007b83] bg-teal-50 text-[#007b83]' : 'border-slate-300 text-slate-400'">2</span>
                    <span class="hidden sm:inline">Poli & Tanggal</span>
                </div>
                <div class="h-0.5 flex-grow mx-4" :class="step >= 3 ? 'bg-[#007b83]' : 'bg-slate-200'"></div>
                <div class="flex items-center space-x-2" :class="step >= 3 ? 'text-[#007b83]' : 'text-slate-400'">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center border-2"
                          :class="step >= 3 ? 'border-[#007b83] bg-teal-50 text-[#007b83]' : 'border-slate-300 text-slate-400'">3</span>
                    <span class="hidden sm:inline">Bukti Antrean</span>
                </div>
            </div>
        </div>

        <!-- Step 1: Identitas Pasien -->
        <div x-show="step === 1" class="bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-slate-200 space-y-6">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Langkah 1: Kategori & Identitas Pasien</h2>
                <p class="text-xs text-slate-500 mt-1">Pilih status pasien dan masukkan data identitas kependudukan.</p>
            </div>

            <!-- Patient Type Selector -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Pasien:</label>
                <div class="grid grid-cols-2 gap-4">
                    <button type="button" @click="patientType = 'lama'" 
                            :class="patientType === 'lama' ? 'border-[#007b83] bg-teal-50/50 text-[#007b83] font-bold shadow-sm' : 'border-slate-200 text-slate-600'"
                            class="p-4 rounded-2xl border-2 text-left transition flex items-center space-x-3">
                        <span class="w-4 h-4 rounded-full border-2 flex items-center justify-center shrink-0" :class="patientType === 'lama' ? 'border-[#007b83] bg-[#007b83]' : 'border-slate-300'"></span>
                        <div>
                            <span class="text-sm block">Pasien Lama</span>
                            <span class="text-[11px] text-slate-500 font-normal">Sudah memiliki No. Rekam Medis (RM)</span>
                        </div>
                    </button>
                    <button type="button" @click="patientType = 'baru'" 
                            :class="patientType === 'baru' ? 'border-[#007b83] bg-teal-50/50 text-[#007b83] font-bold shadow-sm' : 'border-slate-200 text-slate-600'"
                            class="p-4 rounded-2xl border-2 text-left transition flex items-center space-x-3">
                        <span class="w-4 h-4 rounded-full border-2 flex items-center justify-center shrink-0" :class="patientType === 'baru' ? 'border-[#007b83] bg-[#007b83]' : 'border-slate-300'"></span>
                        <div>
                            <span class="text-sm block">Pasien Baru</span>
                            <span class="text-[11px] text-slate-500 font-normal">Belum pernah berobat di RSTN</span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Input Fields -->
            <div class="space-y-4">
                <div x-show="patientType === 'lama'">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor Rekam Medis (RM):</label>
                    <input type="text" x-model="rm" placeholder="Contoh: 00-12-34" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor Induk Kependudukan (NIK KTP / KK):</label>
                    <input type="number" x-model="nik" placeholder="16 digit NIK" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap Pasien:</label>
                    <input type="text" x-model="nama" placeholder="Sesuai kartu identitas KTP" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor WhatsApp Aktif:</label>
                    <input type="tel" x-model="phone" placeholder="Contoh: 081234567890 (untuk pengiriman bukti tiket)" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-600">
                </div>

                <!-- Penjamin -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Penjamin Pembayaran:</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="p-3 rounded-xl border flex items-center space-x-2 text-xs font-semibold cursor-pointer"
                               :class="insurance === 'bpjs' ? 'border-[#007b83] bg-teal-50 text-[#007b83]' : 'border-slate-200'">
                            <input type="radio" name="insurance" value="bpjs" x-model="insurance" class="text-teal-600 focus:ring-teal-600">
                            <span>BPJS Kesehatan</span>
                        </label>
                        <label class="p-3 rounded-xl border flex items-center space-x-2 text-xs font-semibold cursor-pointer"
                               :class="insurance === 'umum' ? 'border-[#007b83] bg-teal-50 text-[#007b83]' : 'border-slate-200'">
                            <input type="radio" name="insurance" value="umum" x-model="insurance" class="text-teal-600 focus:ring-teal-600">
                            <span>Pasien Umum / Bayar</span>
                        </label>
                        <label class="p-3 rounded-xl border flex items-center space-x-2 text-xs font-semibold cursor-pointer"
                               :class="insurance === 'asuransi' ? 'border-[#007b83] bg-teal-50 text-[#007b83]' : 'border-slate-200'">
                            <input type="radio" name="insurance" value="asuransi" x-model="insurance" class="text-teal-600 focus:ring-teal-600">
                            <span>Asuransi Swasta</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="button" @click="step = 2" class="px-8 py-3 rounded-xl font-bold text-sm text-white bg-[#007b83] hover:bg-[#005b64] shadow-md transition">
                    Lanjutkan ke Pilihan Poli &rarr;
                </button>
            </div>
        </div>

        <!-- Step 2: Poli & Jadwal Kunjungan -->
        <div x-show="step === 2" class="bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-slate-200 space-y-6" style="display:none;">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Langkah 2: Pilih Poliklinik & Tanggal Kunjungan</h2>
                <p class="text-xs text-slate-500 mt-1">Pilih poliklinik tujuan dan jadwal konsultasi dokter.</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tanggal Rencana Berobat:</label>
                    <input type="date" x-model="tglKunjungan" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-600">
                    <span class="text-[11px] text-slate-400 mt-1 block">* Pendaftaran online dibuka maksimal H-1 sampai dengan H-7 sebelum hari kunjungan.</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tujuan Poliklinik:</label>
                    <select x-model="poli" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-600">
                        <option value="">-- Pilih Poliklinik Spesialis --</option>
                        <option value="Poli Penyakit Dalam">Poli Penyakit Dalam</option>
                        <option value="Poli Anak">Poli Anak (Pediatri)</option>
                        <option value="Poli Kebidanan & Kandungan (Obgyn)">Poli Kebidanan & Kandungan (Obgyn)</option>
                        <option value="Poli Bedah">Poli Bedah Umum</option>
                        <option value="Poli Jantung & Pembuluh Darah">Poli Jantung & Pembuluh Darah</option>
                        <option value="Poli Mata">Poli Mata</option>
                        <option value="Poli Saraf">Poli Saraf</option>
                        <option value="Poli THT-KL">Poli THT-KL</option>
                        <option value="Poli Gigi & Mulut">Poli Gigi & Mulut</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Dokter Spesialis:</label>
                    <select x-model="dokter" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-600">
                        <option value="">-- Pilih Dokter Spesialis --</option>
                        <option value="dr. Hendra Setiawan, Sp.PD">dr. Hendra Setiawan, Sp.PD</option>
                        <option value="dr. Anisa Rahmawati, Sp.A, M.Sc">dr. Anisa Rahmawati, Sp.A, M.Sc</option>
                        <option value="dr. Bagus Prasetyo, Sp.OG">dr. Bagus Prasetyo, Sp.OG</option>
                        <option value="dr. Rian Hidayat, Sp.B">dr. Rian Hidayat, Sp.B</option>
                        <option value="dr. Maya Kartika, Sp.JP, FIHA">dr. Maya Kartika, Sp.JP, FIHA</option>
                        <option value="dr. Dimas Wicaksono, Sp.M">dr. Dimas Wicaksono, Sp.M</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 flex justify-between">
                <button type="button" @click="step = 1" class="px-6 py-3 rounded-xl font-bold text-xs text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    &larr; Kembali
                </button>
                <button type="button" @click="submitRegistration()" class="px-8 py-3 rounded-xl font-bold text-sm text-white bg-[#007b83] hover:bg-[#005b64] shadow-md transition">
                    Konfirmasi & Ambil Antrean &rarr;
                </button>
            </div>
        </div>

        <!-- Step 3: Bukti Antrean / Pendaftaran Berhasil -->
        <div x-show="step === 3" class="bg-white p-8 sm:p-10 rounded-3xl shadow-xl border-2 border-teal-500/30 text-center space-y-6" style="display:none;">
            <div class="w-16 h-16 bg-teal-100 text-[#007b83] rounded-full flex items-center justify-center mx-auto">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>

            <div>
                <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full">Pendaftaran Berhasil Terkirim</span>
                <h2 class="text-2xl font-black text-slate-900 mt-2">Tiket Antrean Mandiri</h2>
                <p class="text-xs text-slate-500 mt-1">Harap simpan atau tangkap layar (screenshot) bukti pendaftaran berikut.</p>
            </div>

            <!-- Ticket Mockup -->
            <div class="max-w-md mx-auto bg-slate-50 border-2 border-dashed border-teal-400 p-6 rounded-2xl text-left space-y-3">
                <div class="text-center pb-3 border-b border-slate-200">
                    <span class="text-[11px] text-slate-500 font-bold uppercase">Nomor Antrean Anda</span>
                    <div class="text-4xl font-black text-[#007b83] tracking-wider my-1" x-text="nomorAntrean"></div>
                    <span class="text-xs text-slate-600 font-medium" x-text="poli"></span>
                </div>

                <div class="text-xs space-y-1.5 text-slate-700">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nama Pasien:</span>
                        <strong x-text="nama"></strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tanggal Kunjungan:</span>
                        <strong x-text="tglKunjungan"></strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Dokter:</span>
                        <strong x-text="dokter || 'Dokter Jaga Poli'"></strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Penjamin:</span>
                        <strong class="uppercase text-teal-700" x-text="insurance"></strong>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200 text-center">
                    <span class="text-[11px] text-slate-400 block mb-1">Barcode Check-in APM</span>
                    <div class="h-10 bg-slate-200 rounded flex items-center justify-center font-mono text-xs tracking-widest text-slate-600">
                        ||| | |||| | ||||| || | ||
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button type="button" onclick="window.print()" class="px-6 py-2.5 rounded-xl font-bold text-xs bg-slate-800 text-white hover:bg-slate-900 transition">
                    Cetak / Simpan PDF
                </button>
                <button type="button" @click="resetForm()" class="px-6 py-2.5 rounded-xl font-bold text-xs bg-teal-50 text-[#007b83] hover:bg-teal-100 transition border border-teal-200">
                    Daftar Pasien Lain
                </button>
            </div>
        </div>

    </div>
</section>
</x-layouts.app>
