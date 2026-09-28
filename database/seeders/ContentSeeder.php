<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;
use App\Models\Banner;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\Post;
use App\Models\Bed;
use App\Models\Registration;
use App\Models\Complaint;
use App\Models\Page;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@rstjokronegoro.id'],
            [
                'name' => 'Administrator RSUD Tjokronegoro',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Settings (synced with rsutjokronegoro.purworejokab.go.id)
        $settings = [
            'site_name' => 'RSUD R.A.A. Tjokronegoro Purworejo',
            'site_tagline' => 'Melayani dengan Sepenuh Hati, Sigap, Akuntabel, Profesional, Amanah',
            'address' => 'Jalan Soekarno Hatta, Borokulon, Banyuurip, Kabupaten Purworejo, Jawa Tengah 54171',
            'phone' => '(0275) 2973040',
            'emergency_phone' => '(0275) 2973040',
            'whatsapp' => '08112521118',
            'email' => 'rsud.tjokronegoro@purworejokab.go.id',
            'accreditation' => 'Terakreditasi Paripurna (KARS)',
            'hospital_class' => 'Rumah Sakit Umum Daerah Kelas C',
            'director_name' => 'dr. Tolkha Amaruddin, Sp.THT-KL., M.Kes',
            'hours_clinic' => 'Senin - Kamis: 07.30 - 13.00, Jumat - Sabtu: 07.30 - 11.30 WIB',
            'hours_emergency' => 'Setiap Hari 24 Jam Non-Stop',
            'maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.6931589178357!2d110.0141463!3d-7.718872!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7aebd84620f4f9%3A0xe54d92ea4c944ea5!2sRSUD%20R.A.A.%20Tjokronegoro!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid',
        ];

        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }

        // 3. Hero Banners
        Banner::truncate();
        Banner::create([
            'title' => 'Layanan Medis Modern & Profesional',
            'subtitle' => 'Pusat Rujukan Kesehatan Terpercaya di Purworejo',
            'description' => 'Berkomitmen memberikan pelayanan kesehatan paripurna dengan sentuhan humanis, didukung dokter spesialis berpengalaman dan teknologi medis mutakhir.',
            'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1600&q=80',
            'cta_text' => 'Pendaftaran Online',
            'cta_link' => '/pendaftaran-online',
            'cta_text2' => 'Jadwal Dokter',
            'cta_link2' => '/dokter',
            'order' => 1,
            'is_active' => true,
        ]);
        Banner::create([
            'title' => 'IGD 24 Jam & Ambulans Siaga',
            'subtitle' => 'Cepat, Tepat, dan Mengutamakan Keselamatan',
            'description' => 'Tim gawat darurat terlatih siap 24 jam melayani situasi darurat medis dengan fasilitas resusitasi berstandar dan armada ambulans darurat.',
            'image' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1600&q=80',
            'cta_text' => 'Hubungi Hotline IGD',
            'cta_link' => 'tel:02752973040',
            'cta_text2' => 'Alur Gawat Darurat',
            'cta_link2' => '/layanan/igd-24-jam',
            'order' => 2,
            'is_active' => true,
        ]);
        Banner::create([
            'title' => 'Fasilitas Rawat Inap Nyaman & Higienis',
            'subtitle' => 'Pemulihan Optimal untuk Anda dan Keluarga',
            'description' => 'Dari ruang Kelas III hingga VVIP dengan standar akreditasi Paripurna KARS, mengutamakan keselamatan, ketenangan, dan kenyamanan pemulihan pasien.',
            'image' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=1600&q=80',
            'cta_text' => 'Ketersediaan Kamar',
            'cta_link' => '/informasi-publik',
            'cta_text2' => 'Profil Layanan Inap',
            'cta_link2' => '/layanan/rawat-inap',
            'order' => 3,
            'is_active' => true,
        ]);

        // 4. Services
        Service::truncate();
        $servicesData = [
            [
                'title' => 'Instalasi Gawat Darurat (IGD)',
                'slug' => 'igd-24-jam',
                'category' => 'darurat',
                'tag' => '24 Jam Standby',
                'excerpt' => 'Pelayanan medis darurat 24 jam dengan tim dokter siaga dan fasilitas triage modern.',
                'description' => 'Instalasi Gawat Darurat RSUD R.A.A. Tjokronegoro melayani kasus kegawatdaruratan medis, kecelakaan, dan bedah darurat 24 jam non-stop dengan tenaga medis bersertifikasi ACLS/ATLS.',
                'facilities' => ['Ruang Resusitasi Bedah & Non-Bedah', 'Ambulans Emergency Siaga', 'Pemeriksaan EKG & Defibrilator', 'Farmasi & Lab Darurat Terpadu'],
                'image' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=800&q=80',
                'order' => 1
            ],
            [
                'title' => 'Poliklinik Rawat Jalan',
                'slug' => 'rawat-jalan',
                'category' => 'rawat-jalan',
                'tag' => '18 Spesialisasi',
                'excerpt' => 'Layanan konsultasi spesialis lengkap dengan sistem pendaftaran antrean online terpadu.',
                'description' => 'Menyediakan pelayanan dokter spesialis penyakit dalam, anak, kebidanan & kandungan, bedah, jantung, saraf, mata, THT, gigi & mulut, serta rehabilitasi medik.',
                'facilities' => ['Poli Penyakit Dalam', 'Poli Anak', 'Poli Bedah', 'Poli Kebidanan & Kandungan', 'Poli Jantung', 'Poli Mata', 'Poli Saraf'],
                'image' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=800&q=80',
                'order' => 2
            ],
            [
                'title' => 'Instalasi Rawat Inap',
                'slug' => 'rawat-inap',
                'category' => 'rawat-inap',
                'tag' => 'VVIP s/d Kelas 3',
                'excerpt' => 'Akomodasi perawatan yang bersih, tenang, dan higienis didukung perawat profesional 24 jam.',
                'description' => 'Fasilitas rawat inap representatif yang menunjang kesembuhan pasien dengan pengawasan intensif dokter spesialis dan paramedis.',
                'facilities' => ['Ruang VVIP & VIP', 'Ruang Perawatan Anak', 'Ruang Isolasi Tekanan Negatif', 'Nurse Call di Setiap Ranjang'],
                'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=800&q=80',
                'order' => 3
            ],
            [
                'title' => 'Instalasi Bedah Sentral (IBS)',
                'slug' => 'bedah-sentral',
                'category' => 'unggulan',
                'tag' => 'Layanan Unggulan',
                'excerpt' => 'Kamar operasi berstandar internasional dengan sistem tata udara HEPA filter dan laparoskopi canggih.',
                'description' => 'Pusat tindakan pembedahan elektif maupun cito darurat didukung monitor anestesi mutakhir dan teknologi minimal invasif.',
                'facilities' => ['Kamar Operasi Modular', 'C-Arm Fluoroscopy', 'Laparoscopy Tower', 'Recovery Room Terintegrasi'],
                'image' => 'https://images.unsplash.com/photo-1551076805-e1869033e561?auto=format&fit=crop&w=800&q=80',
                'order' => 4
            ],
            [
                'title' => 'Radiologi & Imaging Digital',
                'slug' => 'radiologi',
                'category' => 'penunjang',
                'tag' => 'Penunjang Medis',
                'excerpt' => 'Pemeriksaan diagnostik presisi menggunakan USG 4D, X-Ray Digital, dan CT-Scan resolusi tinggi.',
                'description' => 'Pemeriksaan penunjang radiodiagnostik modern dengan radiasi terkalibrasi aman dan hasil cetak digital cepat.',
                'facilities' => ['CT-Scan 64 Slices', 'Digital X-Ray (DR)', 'USG 4D Doppler', 'Dental Panoramic'],
                'image' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80',
                'order' => 5
            ],
            [
                'title' => 'Laboratorium Patologi Klinik',
                'slug' => 'laboratorium',
                'category' => 'penunjang',
                'tag' => '24 Jam Cepat & Akurat',
                'excerpt' => 'Uji klinis lengkap darah, urin, kimia darah, dan imunologi dengan instrumen otomatis terkoneksi SIMRS.',
                'description' => 'Layanan laboratorium 24 jam dengan sistem kendali mutu (quality control) harian untuk akurasi diagnosis dokter.',
                'facilities' => ['Auto Hematology Analyzer', 'Automated Clinical Chemistry', 'Imunologi & Serologi', 'Bank Darah Rumah Sakit (BDRS)'],
                'image' => 'https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=800&q=80',
                'order' => 6
            ],
            [
                'title' => 'Hemodialisa (Cuci Darah)',
                'slug' => 'hemodialisa',
                'category' => 'unggulan',
                'tag' => 'Layanan Unggulan',
                'excerpt' => 'Unit dialisis modern dengan mesin steril dan tim dokter spesialis nefrologi berpengalaman.',
                'description' => 'Pelayanan cuci darah komprehensif bagi pasien gagal ginjal kronik dalam suasana yang nyaman dan ramah.',
                'facilities' => ['Mesin Hemodialisa Modern', 'Kamar Nyaman TV & AC', 'Water Treatment RO Berstandar', 'Konsultasi Nutrisi Ginjal'],
                'image' => 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=800&q=80',
                'order' => 7
            ],
            [
                'title' => 'Instalasi Farmasi 24 Jam',
                'slug' => 'farmasi',
                'category' => 'penunjang',
                'tag' => 'Layanan 24 Jam',
                'excerpt' => 'Penyediaan obat-obatan bermutu, pelayanan resep rawat jalan, rawat inap, dan konsultasi apoteker.',
                'description' => 'Pelayanan resep obat digital terkoneksi SIMRS serta edukasi informasi obat kepada pasien (PIO).',
                'facilities' => ['Pelayanan Resep Digital', 'Konseling Edukasi Obat (PIO)', 'Penyimpanan Rantai Dingin', 'Apotek 24 Jam'],
                'image' => 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?auto=format&fit=crop&w=800&q=80',
                'order' => 8
            ],
        ];

        foreach ($servicesData as $svc) {
            Service::create($svc);
        }

        // 5. Doctors
        Doctor::truncate();
        $doctorsData = [
            [
                'name' => 'dr. Hendra Setiawan, Sp.PD',
                'speciality' => 'Spesialis Penyakit Dalam',
                'sub_speciality' => 'Konsultan Gastroenterologi & Hepatologi',
                'poli' => 'Poli Penyakit Dalam',
                'schedule' => 'Senin - Kamis: 08.00 - 13.00 WIB',
                'days' => ['Senin', 'Selasa', 'Rabu', 'Kamis'],
                'experience' => '14 Tahun',
                'education' => 'Spesialis Penyakit Dalam FK UGM',
                'photo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=80',
                'order' => 1
            ],
            [
                'name' => 'dr. Anisa Rahmawati, Sp.A, M.Sc',
                'speciality' => 'Spesialis Anak',
                'sub_speciality' => 'Tumbuh Kembang & Pediatri Sosial',
                'poli' => 'Poli Anak',
                'schedule' => 'Senin - Jumat: 08.30 - 12.30 WIB',
                'days' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
                'experience' => '10 Tahun',
                'education' => 'Spesialis Anak FK UNDIP',
                'photo' => 'https://images.unsplash.com/photo-1594824813601-e2a2202611a5?auto=format&fit=crop&w=600&q=80',
                'order' => 2
            ],
            [
                'name' => 'dr. Bagus Prasetyo, Sp.OG',
                'speciality' => 'Spesialis Kebidanan & Kandungan',
                'sub_speciality' => 'Fetomaternal & USG 4D',
                'poli' => 'Poli Kebidanan & Kandungan (Obgyn)',
                'schedule' => 'Senin, Rabu, Jumat: 09.00 - 14.00 WIB',
                'days' => ['Senin', 'Rabu', 'Jumat'],
                'experience' => '12 Tahun',
                'education' => 'Spesialis Obstetri & Ginekologi FK UNAIR',
                'photo' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=600&q=80',
                'order' => 3
            ],
            [
                'name' => 'dr. Rian Hidayat, Sp.B',
                'speciality' => 'Spesialis Bedah Umum',
                'sub_speciality' => 'Bedah Digestif & Laparoskopi',
                'poli' => 'Poli Bedah',
                'schedule' => 'Selasa, Kamis, Sabtu: 08.00 - 12.00 WIB',
                'days' => ['Selasa', 'Kamis', 'Sabtu'],
                'experience' => '11 Tahun',
                'education' => 'Spesialis Bedah FK UGM',
                'photo' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=600&q=80',
                'order' => 4
            ],
            [
                'name' => 'dr. Maya Kartika, Sp.JP, FIHA',
                'speciality' => 'Spesialis Jantung & Pembuluh Darah',
                'sub_speciality' => 'Kardiologi Intervensi & Rehabilitasi',
                'poli' => 'Poli Jantung & Pembuluh Darah',
                'schedule' => 'Senin - Kamis: 10.00 - 14.00 WIB',
                'days' => ['Senin', 'Selasa', 'Rabu', 'Kamis'],
                'experience' => '9 Tahun',
                'education' => 'Spesialis Jantung FK UI',
                'photo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80',
                'order' => 5
            ],
            [
                'name' => 'dr. Dimas Wicaksono, Sp.M',
                'speciality' => 'Spesialis Mata',
                'sub_speciality' => 'Katarak & Bedah Refraktif',
                'poli' => 'Poli Mata',
                'schedule' => 'Selasa & Kamis: 09.00 - 13.00 WIB',
                'days' => ['Selasa', 'Kamis'],
                'experience' => '8 Tahun',
                'education' => 'Spesialis Mata FK UNDIP',
                'photo' => 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?auto=format&fit=crop&w=600&q=80',
                'order' => 6
            ],
        ];

        foreach ($doctorsData as $doc) {
            Doctor::create($doc);
        }

        // 6. Posts (Berita & Pengumuman)
        Post::truncate();
        $postsData = [
            [
                'title' => 'RSUD R.A.A. Tjokronegoro Luncurkan Layanan Pendaftaran Mandiri Terintegrasi',
                'slug' => 'layanan-pendaftaran-mandiri-terintegrasi',
                'category' => 'Berita RS',
                'published_at' => now()->subDays(2),
                'views' => 245,
                'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=800&q=80',
                'excerpt' => 'Guna memangkas waktu tunggu antrean di poliklinik, RSUD R.A.A. Tjokronegoro meresmikan mesin Anjungan Pendaftaran Mandiri (APM) dan aplikasi pendaftaran berbasis web.',
                'content' => 'Purworejo — Dalam rangka meningkatkan mutu pelayanan dan kenyamanan pasien, RSUD R.A.A. Tjokronegoro resmi memperluas sistem antrean online mandiri terintegrasi BPJS Kesehatan dan rekam medis elektronik. Pasien yang telah mendaftar melalui aplikasi dapat langsung melakukan check-in dan menuju ruang tunggu poli tanpa perlu mengantre panjang di loket administrasi.'
            ],
            [
                'title' => 'Tips Menjaga Kesehatan Jantung di Usia Produktif',
                'slug' => 'tips-menjaga-kesehatan-jantung-usia-produktif',
                'category' => 'Artikel Kesehatan',
                'published_at' => now()->subDays(6),
                'views' => 189,
                'image' => 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=800&q=80',
                'excerpt' => 'Penyakit kardiovaskular kian banyak menyerang usia muda. Simak penjelasan dokter spesialis jantung kami mengenai pencegahan dini dan pola hidup seimbang.',
                'content' => 'Gaya hidup sedenter dan pola makan tinggi lemak jenuh menjadi pemicu utama gangguan kardiovaskular. Melalui pemeriksaan berkala dan aktivitas fisik teratur minimal 30 menit sehari, risiko serangan jantung dapat ditekan hingga 50%.'
            ],
            [
                'title' => 'Penyuluhan Kesehatan Masyarakat Mengenai Pencegahan Demam Berdarah',
                'slug' => 'penyuluhan-kesehatan-pencegahan-dbd',
                'category' => 'Kegiatan & Edukasi',
                'published_at' => now()->subDays(10),
                'views' => 312,
                'image' => 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&w=800&q=80',
                'excerpt' => 'Tim Promosi Kesehatan Rumah Sakit (PKRS) menggelar penyuluhan 3M Plus dan pembagian bubuk abate di lingkungan sekitar wilayah kerja rumah sakit.',
                'content' => 'Sebagai wujud kepedulian promotif dan preventif, tim PKRS RSUD R.A.A. Tjokronegoro aktif mendatangi komunitas warga memberikan edukasi penanganan awal demam serta pentingnya menjaga kebersihan saluran air.'
            ],
        ];

        foreach ($postsData as $p) {
            Post::create($p);
        }

        // 7. Beds (Kamar Rawat Inap)
        Bed::truncate();
        $bedsData = [
            ['class_name' => 'VVIP', 'total' => 6, 'available' => 2, 'occupied' => 4, 'gender_room' => 'Umum', 'order' => 1],
            ['class_name' => 'VIP', 'total' => 14, 'available' => 3, 'occupied' => 11, 'gender_room' => 'Umum', 'order' => 2],
            ['class_name' => 'Kelas I', 'total' => 28, 'available' => 8, 'occupied' => 20, 'gender_room' => 'Umum', 'order' => 3],
            ['class_name' => 'Kelas II', 'total' => 36, 'available' => 9, 'occupied' => 27, 'gender_room' => 'Pria / Wanita', 'order' => 4],
            ['class_name' => 'Kelas III', 'total' => 54, 'available' => 12, 'occupied' => 42, 'gender_room' => 'Pria / Wanita', 'order' => 5],
            ['class_name' => 'ICU / ICCU', 'total' => 8, 'available' => 1, 'occupied' => 7, 'gender_room' => 'Kritis', 'order' => 6],
            ['class_name' => 'NICU / PICU', 'total' => 6, 'available' => 2, 'occupied' => 4, 'gender_room' => 'Anak / Bayi', 'order' => 7],
            ['class_name' => 'Ruang Isolasi', 'total' => 10, 'available' => 4, 'occupied' => 6, 'gender_room' => 'Tekanan Negatif', 'order' => 8],
        ];

        foreach ($bedsData as $b) {
            Bed::create($b);
        }

        // 8. Sample Registrations
        Registration::truncate();
        Registration::create([
            'queue_number' => 'A-024',
            'patient_type' => 'lama',
            'nik' => '3306012345670001',
            'rm_number' => '00-12-89',
            'patient_name' => 'Bambang Sutrisno',
            'phone' => '081234567890',
            'insurance' => 'bpjs',
            'clinic' => 'Poli Penyakit Dalam',
            'doctor_name' => 'dr. Hendra Setiawan, Sp.PD',
            'visit_date' => now()->addDay(),
            'status' => 'terdaftar',
        ]);
        Registration::create([
            'queue_number' => 'B-012',
            'patient_type' => 'baru',
            'nik' => '3306023456780002',
            'rm_number' => null,
            'patient_name' => 'Siti Nurhaliza',
            'phone' => '085712345678',
            'insurance' => 'umum',
            'clinic' => 'Poli Anak',
            'doctor_name' => 'dr. Anisa Rahmawati, Sp.A, M.Sc',
            'visit_date' => now()->addDay(),
            'status' => 'terdaftar',
        ]);

        // 9. Sample Complaints / Masukan
        Complaint::truncate();
        Complaint::create([
            'name' => 'Agus Priyono',
            'email' => 'agus.p@gmail.com',
            'phone' => '081398765432',
            'category' => 'Saran',
            'message' => 'Pelayanan di poliklinik anak sangat ramah dan dokternya komunikatif. Semoga kebersihan area bermain anak terus dijaga.',
            'status' => 'selesai',
            'reply' => 'Terima kasih Bapak Agus atas apresiasi dan masukannya. Kami berkomitmen menjaga kebersihan dan kenyamanan seluruh fasilitas rumah sakit.',
        ]);
        Complaint::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi.lestari@yahoo.com',
            'phone' => '087811223344',
            'category' => 'Pengaduan Pelayanan',
            'message' => 'Waktu tunggu di antrean farmasi rawat jalan saat jam 11 siang kemarin agak padat, mohon loket penyerahan obat ditambah.',
            'status' => 'diproses',
            'reply' => 'Terima kasih atas masukannya. Tim farmasi saat ini sedang melakukan evaluasi penambahan personel di jam puncak (peak hours).',
        ]);

        // 10. PPID Pages
        Page::truncate();
        Page::create([
            'title' => 'Informasi Publik Berkala',
            'slug' => 'informasi-berkala',
            'category' => 'PPID',
            'content' => 'Informasi berkala memuat profil rumah sakit, laporan kinerja instansi pemerintah (LKjIP), ringkasan rencana kerja dan anggaran, serta laporan keuangan tahunan RSUD R.A.A. Tjokronegoro.',
            'is_active' => true,
        ]);
        Page::create([
            'title' => 'Informasi Setiap Saat',
            'slug' => 'informasi-setiap-saat',
            'category' => 'PPID',
            'content' => 'Daftar informasi publik yang dapat diakses oleh pemohon informasi setiap saat meliputi SOP pelayanan, standar tarif pelayanan, regulasi bupati, dan struktur organisasi.',
            'is_active' => true,
        ]);
        Page::create([
            'title' => 'Informasi Serta Merta',
            'slug' => 'informasi-serta-merta',
            'category' => 'PPID',
            'content' => 'Informasi yang berkaitan dengan hajat hidup orang banyak dan ketertiban umum seperti penanganan bencana darurat, protokol kewaspadaan penyakit menular, dan panduan evakuasi gempa.',
            'is_active' => true,
        ]);
    }
}