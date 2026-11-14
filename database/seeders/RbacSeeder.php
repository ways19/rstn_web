<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class RbacSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Permissions
        $permissions = [
            // Pendaftaran & Pasien
            ['name' => 'manage_registrations', 'label' => 'Kelola Pendaftaran Online', 'group' => 'Pendaftaran & Pasien'],
            ['name' => 'manage_complaints', 'label' => 'Kelola Aduan & Saran', 'group' => 'Pendaftaran & Pasien'],

            // Pelayanan & Rawat Inap
            ['name' => 'manage_beds', 'label' => 'Kelola Ketersediaan Bed Kamar', 'group' => 'Pelayanan Medis'],
            ['name' => 'manage_services', 'label' => 'Kelola Layanan RS & Poliklinik', 'group' => 'Pelayanan Medis'],
            ['name' => 'manage_doctors', 'label' => 'Kelola Dokter & Jadwal Praktik', 'group' => 'Pelayanan Medis'],

            // Humas & Konten
            ['name' => 'manage_posts', 'label' => 'Kelola Berita & Edukasi PKRS', 'group' => 'Konten Website'],
            ['name' => 'manage_banners', 'label' => 'Kelola Hero Slider Beranda', 'group' => 'Konten Website'],
            ['name' => 'manage_pages', 'label' => 'Kelola Halaman & Konten PPID', 'group' => 'Konten Website'],
            [
                'name' => 'manage_diklat_registrations',
                'label' => 'Kelola Pendaftaran Diklat',
                'group' => 'Pendidikan & Pelatihan',
            ],


            // Sistem & User
            ['name' => 'manage_settings', 'label' => 'Kelola Pengaturan Profil RS', 'group' => 'Sistem & Konfigurasi'],
            ['name' => 'manage_users', 'label' => 'Kelola Akun Petugas & Hak Akses RBAC', 'group' => 'Sistem & Konfigurasi'],
        ];

        foreach ($permissions as $p) {
            Permission::updateOrCreate(['name' => $p['name']], $p);
        }

        // 2. Create Roles
        $superadmin = Role::updateOrCreate(
            ['name' => 'superadmin'],
            ['label' => 'Super Administrator', 'description' => 'Akses penuh ke seluruh modul, sistem, dan manajemen user.']
        );
        $superadmin->permissions()->sync(Permission::all());

        $petugasAntrean = Role::updateOrCreate(
            ['name' => 'petugas_antrean'],
            ['label' => 'Petugas Loket Antrean', 'description' => 'Mengelola antrean pendaftaran online pasien rawat jalan.']
        );
        $petugasAntrean->permissions()->sync(
            Permission::whereIn('name', ['manage_registrations'])->pluck('id')
        );

        $petugasAdmisi = Role::updateOrCreate(
            ['name' => 'petugas_admisi'],
            ['label' => 'Petugas Admisi & Rawat Inap', 'description' => 'Mengelola ketersediaan tempat tidur dan kamar rawat inap.']
        );
        $petugasAdmisi->permissions()->sync(
            Permission::whereIn('name', ['manage_beds'])->pluck('id')
        );

        $petugasHumas = Role::updateOrCreate(
            ['name' => 'petugas_humas'],
            ['label' => 'Humas & PKRS', 'description' => 'Mengelola publikasi berita kegiatan, edukasi kesehatan, banner, dan tanggapan aduan.']
        );
        $petugasHumas->permissions()->sync(
            Permission::whereIn('name', [
                'manage_posts',
                'manage_complaints',
                'manage_banners',
                'manage_pages',
            ])->pluck('id')
        );

        $petugasPelayanan = Role::updateOrCreate(
            ['name' => 'petugas_pelayanan'],
            ['label' => 'Bidang Pelayanan Medis', 'description' => 'Mengelola master layanan rumah sakit, spesialisasi, dan jadwal praktik dokter.']
        );
        $petugasPelayanan->permissions()->sync(
            Permission::whereIn('name', ['manage_services', 'manage_doctors'])->pluck('id')
        );

        // 3. Assign Roles to Users
        $admin = User::where('email', 'admin@rstjokronegoro.id')->first();
        if ($admin) {
            $admin->assignRole('superadmin');
        }

        // Demo User 1: Loket Antrean
        $uAntrean = User::updateOrCreate(
            ['email' => 'antrean@rstjokronegoro.id'],
            ['name' => 'Petugas Antrean', 'password' => Hash::make('password')]
        );
        $uAntrean->roles()->sync([$petugasAntrean->id]);

        // Demo User 2: Petugas Admisi Bed
        $uAdmisi = User::updateOrCreate(
            ['email' => 'admisi@rstjokronegoro.id'],
            ['name' => 'Petugas Admisi Bed', 'password' => Hash::make('password')]
        );
        $uAdmisi->roles()->sync([$petugasAdmisi->id]);

        // Demo User 3: Tim Humas
        $uHumas = User::updateOrCreate(
            ['email' => 'humas@rstjokronegoro.id'],
            ['name' => 'Tim Humas PKRS', 'password' => Hash::make('password')]
        );
        $uHumas->roles()->sync([$petugasHumas->id]);
    }
}