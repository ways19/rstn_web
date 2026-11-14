<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiklatProgram extends Model
{
    protected $fillable = [
        'category',
        'name',
        'target',
        'target_description',
        'description',
        'objectives',
        'materials',
        'requirements',
        'facilities',
        'skp_points',
        'contact_person',
        'flyer_image',
        'image',
        'organizer',
        'method',
        'location',
        'schedule',
        'duration',
        'quota',
        'remaining_quota',
        'status',
        'is_active',
        'sort_order',
        'requires_registration',
        'requires_assignment_letter',
        'requires_str_file',
        'requires_id_photo',
        'is_paid',
        'fee',
        'payment_bank_name',
        'payment_account_number',
        'payment_account_name',
        'participant_target',
        'start_at',
        'end_at',
    ];

    protected function casts(): array
    {
        return [
            'quota' => 'integer',
            'remaining_quota' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'requires_registration' => 'boolean',
            'requires_assignment_letter' => 'boolean',
            'requires_str_file' => 'boolean',
            'requires_id_photo' => 'boolean',
            'is_paid' => 'boolean',
            'fee' => 'integer',
            'start_at' => 'datetime',
            'end_at' => 'datetime',
        ];
    }
    
    public function registrations(): HasMany
    {
        return $this->hasMany(
            DiklatRegistration::class,
            'diklat_program_id'
        );
    }

    /**
     * Hitung ulang sisa kuota dan status pendaftaran secara otomatis
     * berdasarkan kuota total dikurangi pendaftar aktif (status bukan 'ditolak').
     */
    public function recalculateRemainingQuota(): void
    {
        if (!$this->requires_registration || strtolower(trim($this->category ?? '')) !== 'pelatihan') {
            return;
        }

        $registeredCount = $this->registrations()
            ->where('status', '!=', 'ditolak')
            ->count();

        $newRemaining = max(0, (int) $this->quota - $registeredCount);
        $this->remaining_quota = $newRemaining;

        if ($newRemaining === 0 && in_array($this->status, ['dibuka', 'terbatas'])) {
            $this->status = 'penuh';
        } elseif ($newRemaining > 0 && $this->status === 'penuh') {
            $this->status = 'dibuka';
        }

        $this->saveQuietly();
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(
            DiklatAttendance::class,
            'diklat_program_id'
        );
    }

    /**
     * Deskripsi program (fallback jika belum diisi di database)
     */
    public function getFormattedDescriptionAttribute(): string
    {
        if (!empty($this->description)) {
            return $this->description;
        }

        $category = strtolower(trim($this->category ?? ''));
        $isEducation = !in_array($category, ['pelatihan', 'orientasi']);

        if ($isEducation) {
            return "Program pendidikan dan praktik kerja lapangan/klinis di RSUD R.A.A. Tjokronegoro Purworejo diselenggarakan bagi mahasiswa institusi pendidikan mitra. Mahasiswa akan mendapatkan pengalaman pembelajaran klinis secara langsung dan komprehensif, dibimbing oleh Clinical Instructor (CI) profesional guna mengasah keterampilan teknis, etika profesi, serta kepatuhan pada standar patient safety.";
        }

        return "Program pelatihan ini diselenggarakan oleh Instalasi Pendidikan dan Pelatihan RSUD R.A.A. Tjokronegoro Purworejo untuk memberikan penguatan kompetensi, wawasan teoritis, serta keterampilan klinis terapan yang esensial. Seluruh materi disusun secara komprehensif berstandar Kementerian Kesehatan Republik Indonesia guna menunjang profesionalisme tenaga kesehatan dalam memberikan pelayanan bermutu dan berorientasi pada keselamatan pasien (patient safety).";
    }

    /**
     * Tujuan program (fallback jika belum diisi di database)
     */
    public function getFormattedObjectivesAttribute(): string
    {
        if (!empty($this->objectives)) {
            return $this->objectives;
        }

        $category = strtolower(trim($this->category ?? ''));
        $isEducation = !in_array($category, ['pelatihan', 'orientasi']);

        if ($isEducation) {
            return "• Memberikan pengalaman praktik klinis langsung dan terstruktur di lingkungan rumah sakit terakreditasi paripurna.\n• Mengaplikasikan ilmu teori akademik dan keterampilan teknis asuhan medis, keperawatan, kebidanan, atau kefarmasian sesuai standar operasional prosedur (SOP).\n• Membangun etika profesionalisme, komunikasi terapeutik, dan kepatuhan tinggi terhadap keselamatan pasien (patient safety).\n• Memenuhi target pencapaian kompetensi dan logbook stase klinis yang ditetapkan institusi pendidikan mitra.";
        }

        if (!$this->requires_registration) {
            return "• Meningkatkan pemahaman, wawasan, dan kepatuhan seluruh tenaga kesehatan serta petugas rumah sakit terhadap standar prosedur operasional terkini.\n• Memahami regulasi, kebijakan pencegahan risiko, serta prosedur keselamatan kerja dan keselamatan pasien (patient safety) di lingkungan rumah sakit.\n• Mampu mengaplikasikan protokol teknis dan pedoman pencegahan risiko secara konsisten di setiap unit pelayanan maupun operasional rumah sakit.\n• Mendorong terwujudnya budaya mutu pelayanan prima, kepatuhan klinis, dan keselamatan kerja yang terintegrasi di RSUD R.A.A. Tjokronegoro.";
        }

        return "• Meningkatkan kompetensi, pengetahuan, dan keterampilan teknis peserta sesuai dengan standar pelayanan terkini.\n• Memahami regulasi, kebijakan Kementerian Kesehatan RI, serta prosedur keselamatan kerja dan keselamatan pasien (patient safety).\n• Mampu mengaplikasikan protokol klinis, teknis aseptis, dan penanganan kasus secara profesional di fasilitas pelayanan kesehatan masing-masing.\n• Menjamin tersedianya tenaga kesehatan yang terampil, tersertifikasi, dan siap memenuhi standar akreditasi rumah sakit.";
    }

    /**
     * Materi kurikulum / ruang lingkup (fallback jika belum diisi di database)
     */
    public function getFormattedMaterialsAttribute(): string
    {
        if (!empty($this->materials)) {
            return $this->materials;
        }

        $category = strtolower(trim($this->category ?? ''));
        $isEducation = !in_array($category, ['pelatihan', 'orientasi']);

        if ($isEducation) {
            return "1. Orientasi Rumah Sakit: Pencegahan & Pengendalian Infeksi (PPI), K3RS, Keselamatan Pasien, dan Bantuan Hidup Dasar (BHD)\n2. Rotasi Stase Klinis: Rawat Inap, Rawat Jalan, Instalasi Gawat Darurat (IGD), dan Unit Perawatan Khusus\n3. Bimbingan Kasus, Bedside Teaching, dan Ronde Klinis bersama Clinical Instructor (CI) / Dokter Pendidik Klinis (DPK)\n4. Pengenalan Dokumentasi Rekam Medis Elektronik (RME) Rumah Sakit\n5. Evaluasi Akhir Stase, Ujian Keterampilan Klinis (DOPS/Mini-CEX), dan Presentasi Refleksi Kasus";
        }

        if (!$this->requires_registration) {
            return "1. Kebijakan, Regulasi Rumah Sakit, dan Standar Keselamatan Pelayanan\n2. Konsep Dasar, Pedoman Teknis, dan Prosedur Operasional Standar (SOP)\n3. Penerapan di Lingkungan Kerja, Manajemen Risiko, dan Kepatuhan Prosedur\n4. Diskusi Interaktif, Tanya Jawab Kasus Lapangan, dan Arahan Narasumber\n5. Evaluasi Pemahaman Materi dan Pengisian Presensi Kehadiran";
        }

        return "1. Kebijakan dan Regulasi Kementerian Kesehatan RI Terkait Layanan\n2. Konsep Dasar, Aspek Farmakologi / Klinis & Prosedur Operasional Standar (SOP)\n3. Prinsip Keselamatan Kerja, Manajemen Risiko, dan Penjaminan Mutu\n4. Praktik Hands-On, Studi Kasus, dan Simulasi Prosedural di Lingkungan Rumah Sakit\n5. Evaluasi Kompetensi, Ujian Pre-test & Post-test";
    }

    /**
     * Daftar persyaratan final lengkap, menggabungkan kualifikasi umum
     * dan persyaratan berkas yang diaktifkan secara dinamis di CMS.
     */
    public function getFinalRequirementsListAttribute(): array
    {
        $category = strtolower(trim($this->category ?? ''));
        $isEducation = !in_array($category, ['pelatihan', 'orientasi']);

        $lines = [];

        if (!empty($this->requirements)) {
            $rawLines = array_filter(array_map('trim', explode("\n", $this->requirements)));
            foreach ($rawLines as $l) {
                $cleaned = ltrim($l, "•*-1234567890. \t");
                if ($cleaned !== '') {
                    // Selaraskan teks sasaran di daftar persyaratan dengan isi Deskripsi Sasaran jika tersedia
                    if (preg_match('/^sasaran\s*:\s*/i', $cleaned) && !empty($this->target_description)) {
                        $cleaned = 'Sasaran: ' . trim($this->target_description);
                    }

                    if (!$isEducation) {
                        // Jika fitur upload berkas dinonaktifkan di CMS, saring agar tidak muncul di web
                        if (!$this->requires_str_file && (stripos($cleaned, 'Surat Tanda Registrasi') !== false || stripos($cleaned, 'scan STR') !== false)) {
                            continue;
                        }
                        if (!$this->requires_id_photo && stripos($cleaned, 'Pas foto') !== false) {
                            continue;
                        }
                        if (!$this->requires_assignment_letter && (stripos($cleaned, 'Surat Tugas') !== false || stripos($cleaned, 'Surat Rekomendasi') !== false)) {
                            continue;
                        }
                    }
                    $lines[] = $cleaned;
                }
            }
        } else {
            $targetProf = $this->target_description ?: ($this->target ?: ($isEducation ? 'Mahasiswa aktif dari institusi pendidikan mitra' : 'Tenaga Medis dan Tenaga Kesehatan Terkait'));
            if ($isEducation) {
                $lines = [
                    "Sasaran: " . $targetProf,
                    "Mahasiswa aktif dari institusi pendidikan yang telah memiliki Perjanjian Kerjasama (MoU) aktif dengan RSUD",
                    "Melampirkan Surat Permohonan / Rekomendasi Resmi dari Dekan / Pimpinan Institusi Pendidikan asal",
                    "Melampirkan daftar nama calon mahasiswa peserta stase beserta NIM dan Program Studi",
                    "Pas foto formal terbaru berlatar belakang warna dengan seragam almamater resmi",
                ];
            } elseif (!$this->requires_registration) {
                $lines = [
                    "Sasaran Peserta: " . $targetProf,
                    "Terdaftar sebagai pegawai / staf internal RSUD R.A.A. Tjokronegoro atau unit kerja terkait yang ditugaskan",
                    "Hadir tepat waktu di lokasi kegiatan sesuai jadwal pelaksanaan yang telah ditentukan",
                    "Melakukan pengisian presensi / daftar hadir kegiatan (digital melalui portal Diklat atau presensi panitia di lokasi)",
                    "Mengikuti seluruh rangkaian pemaparan materi serta mematuhi tata tertib kegiatan hingga selesai",
                ];
            } else {
                $lines = [
                    "Sasaran: " . $targetProf,
                ];
            }
        }

        // Pastikan Sasaran selalu hadir di posisi teratas daftar persyaratan sesuai Deskripsi Sasaran
        $targetVal = trim($this->target_description ?: ($this->target ?: ''));
        if ($targetVal !== '') {
            $hasTargetLine = false;
            foreach ($lines as $item) {
                if (preg_match('/^sasaran\s*:\s*/i', $item)) {
                    $hasTargetLine = true;
                    break;
                }
            }
            if (!$hasTargetLine) {
                array_unshift($lines, 'Sasaran: ' . $targetVal);
            }
        }

        // Khusus pelatihan dengan registrasi: sertakan otomatis persyaratan berkas yang dicentang di CMS
        if (!$isEducation && $this->requires_registration) {
            if ($this->requires_assignment_letter) {
                $hasAssignment = false;
                foreach ($lines as $item) {
                    if (stripos($item, 'Surat Tugas') !== false || stripos($item, 'Surat Rekomendasi') !== false) {
                        $hasAssignment = true;
                        break;
                    }
                }
                if (!$hasAssignment) {
                    $lines[] = "Melampirkan Surat Tugas atau Rekomendasi dari Pimpinan Instansi / Rumah Sakit asal (Opsional bagi peserta mandiri)";
                }
            }

            if ($this->requires_str_file) {
                $hasStr = false;
                foreach ($lines as $item) {
                    if (stripos($item, 'Surat Tanda Registrasi') !== false || stripos($item, 'scan STR') !== false) {
                        $hasStr = true;
                        break;
                    }
                }
                if (!$hasStr) {
                    $lines[] = "Memiliki dan mengunggah berkas scan Surat Tanda Registrasi (STR) aktif";
                }
            }

            if ($this->requires_id_photo) {
                $hasPhoto = false;
                foreach ($lines as $item) {
                    if (stripos($item, 'Pas foto') !== false) {
                        $hasPhoto = true;
                        break;
                    }
                }
                if (!$hasPhoto) {
                    $lines[] = "Mengunggah pas foto formal terbaru berlatar belakang merah atau biru";
                }
            }

            if ($this->is_paid) {
                $hasPayment = false;
                foreach ($lines as $item) {
                    if (stripos($item, 'pembayaran') !== false) {
                        $hasPayment = true;
                        break;
                    }
                }
                if (!$hasPayment) {
                    $lines[] = "Melampirkan bukti konfirmasi transfer pembayaran registrasi pelatihan";
                }
            }
        }

        return $lines;
    }

    /**
     * Persyaratan peserta dalam format teks baris bernomor
     */
    public function getFormattedRequirementsAttribute(): string
    {
        $items = $this->final_requirements_list;
        $formatted = [];
        foreach ($items as $idx => $line) {
            $formatted[] = ($idx + 1) . ". " . $line;
        }
        return implode("\n", $formatted);
    }

    /**
     * Fasilitas peserta (fallback jika belum diisi di database)
     */
    public function getFormattedFacilitiesAttribute(): string
    {
        if (!empty($this->facilities)) {
            return $this->facilities;
        }

        $category = strtolower(trim($this->category ?? ''));
        $isEducation = !in_array($category, ['pelatihan', 'orientasi']);

        if ($isEducation) {
            return "• Pembimbingan intensif oleh Clinical Instructor (CI) dan Dokter Pendidik Klinis (DPK) tersertifikasi\n• Akses ruang diskusi, perpustakaan, dan fasilitas penunjang pembelajaran di Instalasi Diklat\n• Pembekalan orientasi keselamatan kerja dan perlindungan K3RS selama stase klinis\n• Verifikasi logbook kompetensi dan Surat Keterangan / Sertifikat Selesai Praktik Resmi dari RSUD";
        }

        if (!$this->requires_registration) {
            return "• Materi & Bahan Paparan Sosialisasi Lengkap (Softcopy / Handout Narasumber)\n• Sesi Diskusi, Tanya-Jawab, dan Konsultasi Interaktif langsung bersama Narasumber Ahli\n• Rekapitulasi Presensi & Kehadiran Resmi Kegiatan di Lingkungan Rumah Sakit\n• Fasilitas Ruang Pertemuan / Aula yang representatif dengan sarana presentasi interaktif\n• Sertifikat / Bukti Partisipasi Kegiatan (apabila dialokasikan oleh penyelenggara)";
        }

        return "• Sertifikat Resmi Kementerian Kesehatan RI dengan Satuan Kredit Profesi (SKP)\n• Modul & Bahan Ajar Lengkap (Hardcopy / Softcopy) serta Seminar Kit Eksklusif\n• Fasilitas Praktik Klinis / Hands-on Laboratorium di RSUD R.A.A. Tjokronegoro\n• Konsumsi (Snack dan Makan Siang) selama masa pelatihan tatap muka\n• Bimbingan interaktif langsung oleh Fasilitator Ahli dan Dokter Spesialis";
    }

    /**
     * URL Foto / Gambar Card Program (hanya jika berkas berupa gambar, bukan PDF)
     */
    public function getImageUrlAttribute(): ?string
    {
        foreach ([$this->image ?? null, $this->flyer_image ?? null] as $path) {
            if ($path && !str_ends_with(strtolower($path), '.pdf') && \Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                return \Illuminate\Support\Facades\Storage::disk('public')->url($path);
            }
        }

        return null;
    }
}
