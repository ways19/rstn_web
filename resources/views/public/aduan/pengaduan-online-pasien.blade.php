<x-layouts.app title="Pengaduan Online Pasien — RSUD R.A.A. Tjokronegoro">

    <x-page-header
        title="Pengaduan Online Pasien"
        description="Sampaikan keluhan, kritik, dan saran terkait pelayanan RSUD R.A.A. Tjokronegoro untuk mendukung peningkatan kualitas pelayanan."
    />

    {{-- Breadcrumb --}}
    <div class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav
                class="flex items-center gap-2 py-5 text-sm"
                aria-label="Breadcrumb"
            >
                <a href="{{ route('aduan.pengaduan.online.pasien') }}" class="font-medium text-slate-500 hover:text-[#007b83]">
                    Aduan
                </a>

                <span class="text-slate-300">›</span>

                <span class="font-semibold text-[#007b83]">
                    Pengaduan Online Pasien
                </span>
            </nav>
        </div>
    </div>

    <div class="patient-complaint">

        {{-- Konten CMS --}}
        <main class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            {!! $page->content !!}
        </main>
        

            {{-- Konten utama halaman Kontak & Layanan Pengaduan --}}
            <section class="contact-page">
                <div class="contact-container">

                    <div class="contact-layout">

                        {{-- KOLOM KIRI: KONTAK RESMI --}}
                        <aside class="contact-sidebar">

                            <div class="contact-emergency">
                                <span class="contact-emergency__label">
                                    LAYANAN GAWAT DARURAT
                                </span>

                                <h2>IGD & Ambulans 24 Jam</h2>

                                <p>
                                    Siap melayani kebutuhan kegawatdaruratan medis
                                    selama 24 jam setiap hari.
                                </p>

                                <a href="tel:0275321118" class="contact-emergency__button">
                                    <span aria-hidden="true">☎</span>
                                    (0275) 321118
                                </a>
                            </div>

                            <div class="contact-info-card">
                                <h3>Informasi Kontak Resmi</h3>

                                <div class="contact-info-item">
                                    <span class="contact-info-item__icon">⌖</span>
                                    <div>
                                        <h4>Alamat Rumah Sakit</h4>
                                        <p>
                                            Jl. Jenderal Sudirman No. 60,
                                            Pangenjurutengah, Kec. Purworejo,
                                            Kabupaten Purworejo, Jawa Tengah 54114
                                        </p>
                                    </div>
                                </div>

                                <div class="contact-info-item">
                                    <span class="contact-info-item__icon">◉</span>
                                    <div>
                                        <h4>WhatsApp Informasi & Pengaduan</h4>
                                        <p>
                                            <a href="https://wa.me/628112521118"
                                            target="_blank"
                                            rel="noopener noreferrer">
                                                0811-2521-118
                                            </a>
                                        </p>
                                    </div>
                                </div>

                                <div class="contact-info-item">
                                    <span class="contact-info-item__icon">✉</span>
                                    <div>
                                        <h4>Email Resmi</h4>
                                        <p>
                                            <a href="mailto:rsud.tjokronogoro@purworejokab.go.id">
                                                rsud.tjokronogoro@purworejokab.go.id
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </aside>

                        {{-- KOLOM KANAN: FORMULIR --}}
                        <div class="contact-form-card" id="form-pengaduan">

                            <div class="contact-form-heading">
                                <span class="contact-form-eyebrow">SUARA PASIEN</span>
                                <h2>Formulir Saran & Pengaduan</h2>
                                <p>
                                    Sampaikan masukan Anda untuk membantu meningkatkan
                                    kualitas pelayanan RSUD R.A.A. Tjokronegoro.
                                </p>
                            </div>

                            @if ($errors->any())
                                <div class="contact-alert contact-alert--error" role="alert">
                                    <strong>Periksa kembali formulir Anda.</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="contact-alert contact-alert--success" role="status">
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{-- GANTI ACTION DENGAN ROUTE POST YANG SUDAH ADA --}}
                            <form
                                method="POST"
                                action="{{ route('aduan.pengaduan.online.pasien') }}"
                                class="contact-form"
                            >
                                @csrf

                                <div class="contact-form-grid">
                                    <div class="contact-field">
                                        <label for="contact-name">Nama lengkap <span>*</span></label>
                                        <input
                                            id="contact-name"
                                            type="text"
                                            name="name"
                                            value="{{ old('name') }}"
                                            autocomplete="name"
                                            placeholder="Masukkan nama lengkap"
                                            required
                                        >
                                        @error('name')
                                            <small class="contact-field-error">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="contact-field">
                                        <label for="contact-phone">Nomor telepon / WhatsApp <span>*</span></label>
                                        <input
                                            id="contact-phone"
                                            type="tel"
                                            name="phone"
                                            value="{{ old('phone') }}"
                                            autocomplete="tel"
                                            placeholder="Contoh: 081234567890"
                                            required
                                        >
                                        @error('phone')
                                            <small class="contact-field-error">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="contact-field contact-field--full">
                                        <label for="contact-email">Email (opsional)</label>
                                        <input
                                            id="contact-email"
                                            type="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            autocomplete="email"
                                            placeholder="nama@email.com"
                                        >
                                        @error('email')
                                            <small class="contact-field-error">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="contact-field contact-field--full">
                                        <label for="contact-category">Kategori masukan <span>*</span></label>
                                        <select id="contact-category" name="category" required>
                                            <option value="">Pilih kategori masukan</option>
                                            <option value="Keluhan Pelayanan"
                                                @selected(old('category') === 'Keluhan Pelayanan')>
                                                Keluhan Pelayanan
                                            </option>
                                            <option value="Kritik dan Saran"
                                                @selected(old('category') === 'Kritik dan Saran')>
                                                Kritik dan Saran
                                            </option>
                                            <option value="Apresiasi Pelayanan"
                                                @selected(old('category') === 'Apresiasi Pelayanan')>
                                                Apresiasi Pelayanan
                                            </option>
                                        </select>
                                        @error('category')
                                            <small class="contact-field-error">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="contact-field contact-field--full">
                                        <label for="contact-message">Isi pesan / pengaduan <span>*</span></label>
                                        <textarea
                                            id="contact-message"
                                            name="message"
                                            rows="5"
                                            placeholder="Ceritakan pengalaman atau pengaduan Anda secara jelas..."
                                            required
                                        >{{ old('message') }}</textarea>
                                        <small class="contact-field-hint">
                                            Hindari menuliskan kata sandi atau data kesehatan
                                            orang lain yang tidak diperlukan.
                                        </small>
                                        @error('message')
                                            <small class="contact-field-error">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="contact-consent">
                                    <input
                                        id="contact-consent"
                                        type="checkbox"
                                        name="consent"
                                        value="1"
                                        required
                                        @checked(old('consent'))
                                    >
                                    <label for="contact-consent">
                                        Saya memastikan informasi yang disampaikan benar
                                        dan bersedia dihubungi jika diperlukan.
                                    </label>
                                </div>

                                <button type="submit" class="contact-submit">
                                    Kirim Saran & Pengaduan
                                    <span aria-hidden="true">→</span>
                                </button>

                                <p class="contact-form-footnote">
                                    Data Anda digunakan untuk keperluan tindak lanjut
                                    pengaduan oleh petugas yang berwenang.
                                </p>
                            </form>
                        </div>

                    </div>

                    {{-- PETA LOKASI --}}
                    <section class="contact-map-card">
                        <div class="contact-map-heading">
                            <div>
                                <span class="contact-form-eyebrow">LOKASI KAMI</span>
                                <h2>Lokasi RSUD R.A.A. Tjokronegoro</h2>
                            </div>

                            <a
                                href="https://www.google.com/maps/search/?api=1&query=RSUD+R.A.A.+Tjokronegoro+Purworejo"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="contact-map-link"
                            >
                                Buka Google Maps ↗
                            </a>
                        </div>

                        <div class="contact-map-frame">
                            <iframe
                                src="https://maps.google.com/maps?q=RSUD%20R.A.A.%20Tjokronegoro%20Purworejo&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                title="Peta lokasi RSUD R.A.A. Tjokronegoro"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen
                            ></iframe>
                        </div>
                    </section>

                </div>
            </section>
    </div>

</x-layouts.app>