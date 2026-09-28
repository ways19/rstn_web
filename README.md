# Sistem Informasi Web Profil & CMS RSUD R.A.A. Tjokronegoro

Aplikasi Web Profil Resmi dan Panel Administrator (CMS) RSUD R.A.A. Tjokronegoro Kabupaten Purworejo yang dibangun menggunakan **Laravel 12**, **Tailwind CSS v4**, **Alpine.js**, dan **Arsitektur Modular**.

---

## 🚀 Fitur Utama

- **Web Profil Publik**:
  - Halaman Beranda interaktif dengan Hero Slider Banner dinamis.
  - Informasi Layanan Medis, Poliklinik, dan Fasilitas Unggulan.
  - Direktori Dokter Spesialis beserta Jadwal Praktik Poliklinik.
  - Berita, Pengumuman, dan Edukasi Kesehatan PKRS.
  - Pendaftaran Pasien & Antrean Online.
  - Layanan Kontak & Aduan Masyarakat Terintegrasi.
  - Dukungan Mode Gelap / Terang (*Dark/Light Mode Theme Toggle*).
  - Dynamic SEO (*sitemap.xml* & *robots.txt*).

- **Panel Administrator (AdminKit CMS)**:
  - Otentikasi aman dengan **GD Visual Captcha** (6 karakter kombinasi angka, huruf besar & kecil, refresh AJAX).
  - Manajemen Akun Petugas & Role-Based Access Control (RBAC).
  - Verifikasi Status Pendaftaran Pasien Online.
  - Tindak Lanjut & Balasan Aduan/Saran Pengunjung.
  - Manajemen Ketersediaan Bed Kamar Inap (Total, Terisi, Kosong).
  - Manajemen Modul Sistem & Pengaturan Menu Navigasi Dinamis.

---

## 🏗️ Struktur Arsitektur Modular

Aplikasi ini menggunakan pola **Modular Clean Architecture**:

```text
app/Modules/
├── Common/          # Shared Traits, Utilities, Base Classes
├── Content/         # Berita/Artikel PKRS, Banner Slider
├── Dashboard/       # Dashboard Utama CMS Admin
├── Identity/        # Auth, Captcha Service, RBAC (Users & Roles)
├── Medical/         # Layanan RS, Dokter, Jadwal, Bed/Kamar Inap
├── Navigation/      # Beranda, Profil RS, Menu Dinamis, Settings
└── Patient/         # Pendaftaran Online & Aduan Masyarakat
```

Setiap modul memiliki:
- `routes.php` (Auto-discovered oleh `routes/web.php`)
- `Controllers/` (Terpisah antara `Public/` dan `Admin/`)
- `Models/`, `Services/`, `Requests/`

---

## 💻 Panduan Instalasi untuk Anggota Tim

Ikuti langkah-langkah berikut setelah melakukan clone repository:

### 1. Clone Repository
```bash
git clone https://github.com/USERNAME/REPO_NAME.git
cd REPO_NAME
```

### 2. Install Dependensi PHP & JavaScript
```bash
composer install
npm install
```

### 3. Salin Konfigurasi Environment
```bash
cp .env.example .env
# Jika di Windows PowerShell:
copy .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Setup Database & Seeder
Secara default project menggunakan database SQLite yang praktis:
```bash
# Pastikan file database/database.sqlite tersedia (buat jika belum ada)
# Windows PowerShell:
if (!(Test-Path "database/database.sqlite")) { New-Item "database/database.sqlite" -ItemType File }

# Jalankan migrasi dan seeder awal
php artisan migrate --seed
```

### 6. Jalankan Server Pengembangan
Buka 2 tab terminal:

**Terminal 1 (Backend Laravel):**
```bash
php artisan serve
```

**Terminal 2 (Vite Frontend):**
```bash
npm run dev
```

Aplikasi dapat diakses di: `http://localhost:8000` (atau `http://rstn_profile.test` jika menggunakan Laragon).

---

## 🔑 Akun Default Administrator

- **URL Login Admin**: `/admin/login` atau `/login`
- **Email**: `admin@rstjokronegoro.id`
- **Password**: `password`
- **Captcha**: Masukkan 6 karakter kode keamanan yang tampil pada layar.

---

## 🛠️ Stack Teknologi

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade Templating, Tailwind CSS v4, Alpine.js, Lucide Icons
- **Database**: SQLite (Development) / MySQL 8+ (Production)
- **Styling UI**: AdminKit & Modern Clean Medical Design
