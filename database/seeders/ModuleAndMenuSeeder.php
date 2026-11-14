<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppModule;
use App\Models\Menu;
use App\Models\Permission;

class ModuleAndMenuSeeder extends Seeder
{
    public function run(): void
    {
        // Add new permissions if missing
        Permission::updateOrCreate(['name' => 'manage_menus'], [
            'name' => 'manage_menus',
            'label' => 'Kelola Menu Navigasi (Publik & Admin)',
            'group' => 'Sistem & Konfigurasi'
        ]);

        Permission::updateOrCreate(['name' => 'manage_modules'], [
            'name' => 'manage_modules',
            'label' => 'Kelola Modul & Ekosistem Sistem',
            'group' => 'Sistem & Konfigurasi'
        ]);

        // 1. Seed Modules into app_modules
        $modules = [
            [
                'slug' => 'registrations',
                'name' => 'Pendaftaran & Antrean Online',
                'group' => 'Pelayanan & Pasien',
                'description' => 'Pengelolaan antrean pendaftaran online mandiri pasien rawat jalan.',
                'icon' => 'clipboard-list',
                'route_name' => 'admin.registrations.index',
                'order' => 1,
            ],
            [
                'slug' => 'complaints',
                'name' => 'Aduan & Saran Pasien',
                'group' => 'Pelayanan & Pasien',
                'description' => 'Pengelolaan dan tanggapan kotak aspirasi, saran, dan pengaduan masyarakat.',
                'icon' => 'message-square',
                'route_name' => 'admin.complaints.index',
                'order' => 2,
            ],
            [
                'slug' => 'beds',
                'name' => 'Ketersediaan Bed Rawat Inap',
                'group' => 'Pelayanan Medis',
                'description' => 'Monitoring kapasitas tempat tidur rawat inap, ICU, VIP, dan ruang isolasi.',
                'icon' => 'bed',
                'route_name' => 'admin.beds.index',
                'order' => 3,
            ],
            [
                'slug' => 'services',
                'name' => 'Layanan RS & Poliklinik',
                'group' => 'Pelayanan Medis',
                'description' => 'Master katalog poliklinik spesialis, instalasi penunjang medis, dan IGD 24 Jam.',
                'icon' => 'activity',
                'route_name' => 'admin.services.index',
                'order' => 4,
            ],
            [
                'slug' => 'doctors',
                'name' => 'Dokter & Jadwal Praktik',
                'group' => 'Pelayanan Medis',
                'description' => 'Master data dokter spesialis, profil, SIP, dan jadwal jam praktik poliklinik.',
                'icon' => 'user-check',
                'route_name' => 'admin.doctors.index',
                'order' => 5,
            ],
            [
                'slug' => 'posts',
                'name' => 'Berita & Edukasi PKRS',
                'group' => 'Informasi & Konten',
                'description' => 'Publikasi artikel kesehatan, kegiatan rumah sakit, dan promosi kesehatan.',
                'icon' => 'newspaper',
                'route_name' => 'admin.posts.index',
                'order' => 6,
            ],
            [
                'slug' => 'banners',
                'name' => 'Hero Slider Banner',
                'group' => 'Informasi & Konten',
                'description' => 'Pengelolaan spanduk banner visual utama pada halaman beranda website.',
                'icon' => 'image',
                'route_name' => 'admin.banners.index',
                'order' => 7,
            ],
            [
                'slug' => 'settings',
                'name' => 'Profil & Identitas RS',
                'group' => 'Master & Pengaturan',
                'description' => 'Konfigurasi nama institusi, alamat, hotline darurat IGD, dan kontak resmi.',
                'icon' => 'settings',
                'route_name' => 'admin.settings.index',
                'order' => 8,
            ],
            [
                'slug' => 'rbac',
                'name' => 'Manajemen Petugas & Hak Akses',
                'group' => 'Master & Pengaturan',
                'description' => 'Pengelolaan akun staf, role wewenang, dan matriks hak akses modul (RBAC).',
                'icon' => 'shield-check',
                'route_name' => 'admin.users.index',
                'order' => 9,
            ],
            [
                'slug' => 'menus',
                'name' => 'Pengelolaan Menu Navigasi',
                'group' => 'Master & Pengaturan',
                'description' => 'Pengelolaan hierarki menu navigasi website publik dan sidebar CMS admin.',
                'icon' => 'menu',
                'route_name' => 'admin.menus.index',
                'order' => 10,
            ],
        ];

        foreach ($modules as $m) {
            AppModule::updateOrCreate(['slug' => $m['slug']], $m);
        }

        // 2. Seed Public Menus
        Menu::where('location', 'public')->delete();

        // 1. Beranda
        Menu::create([
            'location' => 'public',
            'title' => 'Beranda',
            'route_name' => 'home',
            'order' => 1,
        ]);

        // 2. Dokter & Jadwal
        Menu::create([
            'location' => 'public',
            'title' => 'Dokter & Jadwal',
            'route_name' => 'doctors',
            'order' => 2,
        ]);

        // 3. Layanan
        $mLayanan = Menu::create([
            'location' => 'public',
            'title' => 'Layanan',
            'url' => '/layanan',
            'order' => 3,
        ]);
        Menu::create(['location' => 'public', 'parent_id' => $mLayanan->id, 'title' => 'Instalasi Rawat Jalan', 'url' => '/layanan?kategori=rawat-jalan', 'order' => 1]);
        Menu::create(['location' => 'public', 'parent_id' => $mLayanan->id, 'title' => 'Instalasi Rawat Inap', 'url' => '/layanan?kategori=rawat-inap', 'order' => 2]);
        Menu::create(['location' => 'public', 'parent_id' => $mLayanan->id, 'title' => 'Instalasi Gawat Darurat (IGD 24 Jam)', 'url' => '/layanan/igd-24-jam', 'order' => 3]);
        Menu::create(['location' => 'public', 'parent_id' => $mLayanan->id, 'title' => 'Hemodialisa (Cuci Darah)', 'url' => '/layanan/hemodialisa', 'order' => 4]);
        Menu::create(['location' => 'public', 'parent_id' => $mLayanan->id, 'title' => 'Laboratorium & Radiologi', 'url' => '/layanan?kategori=penunjang', 'order' => 5]);
        Menu::create(['location' => 'public', 'parent_id' => $mLayanan->id, 'title' => 'Instalasi Bedah Sentral (IBS)', 'url' => '/layanan/bedah-sentral', 'order' => 6]);

        // 4. Informasi
        $mInformasi = Menu::create([
            'location' => 'public',
            'title' => 'Informasi',
            'url' => '/informasi-publik',
            'order' => 4,
        ]);
        Menu::create(['location' => 'public', 'parent_id' => $mInformasi->id, 'title' => 'Ketersediaan Tempat Tidur', 'url' => '/informasi-publik#bed', 'order' => 1]);
        Menu::create(['location' => 'public', 'parent_id' => $mInformasi->id, 'title' => 'Tarif Pelayanan & Kamar', 'url' => '/informasi-publik#tarif', 'order' => 2]);
        Menu::create(['location' => 'public', 'parent_id' => $mInformasi->id, 'title' => 'Tata Tertib & Jam Besuk', 'url' => '/informasi-publik#tata-tertib', 'order' => 3]);
        Menu::create(['location' => 'public', 'parent_id' => $mInformasi->id, 'title' => 'Hak & Kewajiban Pasien', 'url' => '/informasi-publik#hak', 'order' => 4]);

        // 5. PPID

        $mPpid = Menu::create([
            'location' => 'public',
            'title' => 'PPID',
            'url' => '/ppid/profil',
            'order' => 5,
        ]);

        Menu::create([
            'location' => 'public',
            'parent_id' => $mPpid->id,
            'title' => 'Profil PPID',
            'url' => '/ppid/profil',
            'order' => 1,
        ]);

        Menu::create([
            'location' => 'public',
            'parent_id' => $mPpid->id,
            'title' => 'Informasi Publik',
            'url' => '/ppid/informasi/berkala',
            'order' => 2,
        ]);

        Menu::create([
            'location' => 'public',
            'parent_id' => $mPpid->id,
            'title' => 'Permohonan Informasi',
            'url' => '/ppid/permohonan/permintaan',
            'order' => 3,
        ]);
        
        // 6. Aduan
        
        Menu::create([
            'location' => 'public',
            'parent_id' => $mAduan->id,
            'title' => 'Aduan',
            'url' => '/aduan/pengaduan-online-pasien',
            'order' => 6,
        ]);

        Menu::create([
            'location' => 'public',
            'parent_id' => $mAduan->id,
            'title' => 'Pengaduan Online Pasien',
            'url' => '/aduan/pengaduan-online-pasien',
            'order' => 1,
        ]);

        Menu::create([
            'location' => 'public',
            'parent_id' => $mAduan->id,
            'title' => 'Lapor Benturan Kepentingan',
            'url' => '/aduan/lapor-benturan-kepentingan',
            'order' => 2,
        ]);

        Menu::create([
            'location' => 'public',
            'parent_id' => $mAduan->id,
            'title' => 'Whistle Blowing System (WBS)',
            'url' => '/aduan/whistle-blowing-system-wbs',
            'order' => 3,
        ]);

        Menu::create([
            'location' => 'public',
            'parent_id' => $mAduan->id,
            'title' => 'Saluran Kontak Pengaduan',
            'url' => '/aduan/saluran-kontak-pengaduan',
            'order' => 4,
        ]);


        // 7. Media
        $mMedia = Menu::create([
            'location' => 'public',
            'title' => 'Media',
            'url' => '/berita',
            'order' => 7,
        ]);
        Menu::create(['location' => 'public', 'parent_id' => $mMedia->id, 'title' => 'Berita & Kegiatan Rumah Sakit', 'url' => '/berita', 'order' => 1]);
        Menu::create(['location' => 'public', 'parent_id' => $mMedia->id, 'title' => 'Edukasi Kesehatan PKRS', 'url' => '/berita', 'order' => 2]);
        Menu::create(['location' => 'public', 'parent_id' => $mMedia->id, 'title' => 'Galeri Foto & Video', 'url' => '/berita', 'order' => 3]);

        // 3. Seed Admin Menus
        Menu::where('location', 'admin')->delete();

        // Level 1: Dashboard
        Menu::create([
            'location' => 'admin',
            'title' => 'Dashboard',
            'route_name' => 'admin.dashboard',
            'icon' => 'layout-dashboard',
            'order' => 1,
        ]);

        // Level 1: Pelayanan RS
        $admPelayanan = Menu::create([
            'location' => 'admin',
            'title' => 'Pelayanan RS',
            'icon' => 'activity',
            'permission_name' => 'manage_services',
            'order' => 2,
        ]);
        // Level 2: Rawat Jalan
        $admRawatJalan = Menu::create([
            'location' => 'admin',
            'parent_id' => $admPelayanan->id,
            'title' => 'Rawat Jalan & Poli',
            'permission_name' => 'manage_services',
            'order' => 1,
        ]);
        Menu::create(['location' => 'admin', 'parent_id' => $admRawatJalan->id, 'title' => 'Poliklinik & Spesialis', 'route_name' => 'admin.services.index', 'order' => 1]);
        Menu::create(['location' => 'admin', 'parent_id' => $admRawatJalan->id, 'title' => 'Jadwal Praktik Dokter', 'route_name' => 'admin.doctors.index', 'order' => 2]);
        Menu::create(['location' => 'admin', 'parent_id' => $admRawatJalan->id, 'title' => '+ Tambah Layanan Baru', 'route_name' => 'admin.services.create', 'order' => 3]);

        // Level 2: Rawat Inap & Bed
        $admRawatInap = Menu::create([
            'location' => 'admin',
            'parent_id' => $admPelayanan->id,
            'title' => 'Rawat Inap & Kamar',
            'permission_name' => 'manage_beds',
            'order' => 2,
        ]);
        Menu::create(['location' => 'admin', 'parent_id' => $admRawatInap->id, 'title' => 'Ketersediaan Tempat Tidur', 'route_name' => 'admin.beds.index', 'order' => 1]);

        // Level 2: Darurat & Tindakan
        $admDarurat = Menu::create([
            'location' => 'admin',
            'parent_id' => $admPelayanan->id,
            'title' => 'Darurat & Tindakan',
            'permission_name' => 'manage_services',
            'order' => 3,
        ]);
        Menu::create(['location' => 'admin', 'parent_id' => $admDarurat->id, 'title' => 'IGD 24 Jam & Ambulans', 'route_name' => 'admin.services.index', 'order' => 1]);
        Menu::create(['location' => 'admin', 'parent_id' => $admDarurat->id, 'title' => 'Bedah Sentral (IBS)', 'route_name' => 'admin.services.index', 'order' => 2]);

        // Level 1: Pasien & Antrean
        $admPasien = Menu::create([
            'location' => 'admin',
            'title' => 'Pasien & Antrean',
            'icon' => 'users',
            'permission_name' => 'manage_registrations',
            'order' => 3,
        ]);
        $admAntrean = Menu::create([
            'location' => 'admin',
            'parent_id' => $admPasien->id,
            'title' => 'Pendaftaran Online',
            'permission_name' => 'manage_registrations',
            'order' => 1,
        ]);
        Menu::create(['location' => 'admin', 'parent_id' => $admAntrean->id, 'title' => 'Semua Pendaftar', 'route_name' => 'admin.registrations.index', 'order' => 1]);
        Menu::create(['location' => 'admin', 'parent_id' => $admAntrean->id, 'title' => 'Status: Terdaftar', 'url' => '/admin/registrations?status=terdaftar', 'order' => 2]);
        Menu::create(['location' => 'admin', 'parent_id' => $admAntrean->id, 'title' => 'Status: Dipanggil', 'url' => '/admin/registrations?status=dipanggil', 'order' => 3]);
        Menu::create(['location' => 'admin', 'parent_id' => $admAntrean->id, 'title' => 'Status: Selesai', 'url' => '/admin/registrations?status=selesai', 'order' => 4]);

        $admAduan = Menu::create([
            'location' => 'admin',
            'parent_id' => $admPasien->id,
            'title' => 'Aduan & Saran',
            'permission_name' => 'manage_complaints',
            'order' => 2,
        ]);
        Menu::create(['location' => 'admin', 'parent_id' => $admAduan->id, 'title' => 'Semua Aduan Masuk', 'route_name' => 'admin.complaints.index', 'order' => 1]);
        Menu::create(['location' => 'admin', 'parent_id' => $admAduan->id, 'title' => 'Aduan Baru (Belum Respon)', 'url' => '/admin/complaints?status=baru', 'order' => 2]);

        // Level 1: Informasi & Konten
        $admKonten = Menu::create([
            'location' => 'admin',
            'title' => 'Berita & PPID',
            'icon' => 'newspaper',
            'permission_name' => 'manage_posts',
            'order' => 4,
        ]);
        $admPublikasi = Menu::create([
            'location' => 'admin',
            'parent_id' => $admKonten->id,
            'title' => 'Berita & Edukasi',
            'permission_name' => 'manage_posts',
            'order' => 1,
        ]);
        Menu::create(['location' => 'admin', 'parent_id' => $admPublikasi->id, 'title' => 'Semua Artikel Berita', 'route_name' => 'admin.posts.index', 'order' => 1]);
        Menu::create(['location' => 'admin', 'parent_id' => $admPublikasi->id, 'title' => '+ Tulis Berita Baru', 'route_name' => 'admin.posts.create', 'order' => 2]);

        $admPpid = Menu::create([
            'location' => 'admin',
            'parent_id' => $admKonten->id,
            'title' => 'Kategori PPID',
            'permission_name' => 'manage_posts',
            'order' => 2,
        ]);
        Menu::create(['location' => 'admin', 'parent_id' => $admPpid->id, 'title' => 'Informasi Berkala', 'route_name' => 'information', 'target' => '_blank', 'order' => 1]);
        Menu::create(['location' => 'admin', 'parent_id' => $admPpid->id, 'title' => 'Informasi Setiap Saat', 'route_name' => 'information', 'target' => '_blank', 'order' => 2]);

        // Level 1: Master & Pengaturan
        $admPengaturan = Menu::create([
            'location' => 'admin',
            'title' => 'Master & Sistem',
            'icon' => 'settings',
            'permission_name' => 'manage_settings',
            'order' => 5,
        ]);

        // Level 2: Modul & Menu Manager
        $admModulMenu = Menu::create([
            'location' => 'admin',
            'parent_id' => $admPengaturan->id,
            'title' => 'Modul & Navigasi',
            'permission_name' => 'manage_settings',
            'order' => 1,
        ]);
        Menu::create(['location' => 'admin', 'parent_id' => $admModulMenu->id, 'title' => 'Pengelolaan Modul', 'route_name' => 'admin.modules.index', 'order' => 1]);
        Menu::create(['location' => 'admin', 'parent_id' => $admModulMenu->id, 'title' => 'Pengelolaan Menu (Navigasi)', 'route_name' => 'admin.menus.index', 'order' => 2]);

        // Level 2: Master Medis
        $admMasterMedis = Menu::create([
            'location' => 'admin',
            'parent_id' => $admPengaturan->id,
            'title' => 'Master Data Medis',
            'permission_name' => 'manage_doctors',
            'order' => 2,
        ]);
        Menu::create(['location' => 'admin', 'parent_id' => $admMasterMedis->id, 'title' => 'Dokter & Jadwal Praktik', 'route_name' => 'admin.doctors.index', 'order' => 1]);
        Menu::create(['location' => 'admin', 'parent_id' => $admMasterMedis->id, 'title' => 'Master Layanan RS', 'route_name' => 'admin.services.index', 'order' => 2]);
        Menu::create(['location' => 'admin', 'parent_id' => $admMasterMedis->id, 'title' => 'Hero Slider Beranda', 'route_name' => 'admin.banners.index', 'order' => 3]);

        // Level 2: Konfigurasi Web
        $admKonfigWeb = Menu::create([
            'location' => 'admin',
            'parent_id' => $admPengaturan->id,
            'title' => 'Konfigurasi Web',
            'permission_name' => 'manage_settings',
            'order' => 3,
        ]);
        Menu::create(['location' => 'admin', 'parent_id' => $admKonfigWeb->id, 'title' => 'Identitas & Profil RS', 'route_name' => 'admin.settings.index', 'order' => 1]);
        Menu::create(['location' => 'admin', 'parent_id' => $admKonfigWeb->id, 'title' => 'Peta Situs (Sitemap XML)', 'route_name' => 'sitemap', 'target' => '_blank', 'order' => 2]);

        // Level 2: Otorisasi & RBAC
        $admRbac = Menu::create([
            'location' => 'admin',
            'parent_id' => $admPengaturan->id,
            'title' => 'Otorisasi & RBAC',
            'permission_name' => 'manage_users',
            'order' => 4,
        ]);
        Menu::create(['location' => 'admin', 'parent_id' => $admRbac->id, 'title' => 'Manajemen Petugas (User)', 'route_name' => 'admin.users.index', 'order' => 1]);
        Menu::create(['location' => 'admin', 'parent_id' => $admRbac->id, 'title' => 'Hak Akses & Role (RBAC)', 'route_name' => 'admin.roles.index', 'order' => 2]);
        Menu::create(['location' => 'admin', 'parent_id' => $admRbac->id, 'title' => '+ Tambah Petugas Baru', 'route_name' => 'admin.users.create', 'order' => 3]);
    }
}
