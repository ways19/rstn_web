<?php

namespace App\Modules\Content\Services;

use App\Models\DiklatRegistration;
use FPDF;

class DiklatRegistrationPdfService
{
    /**
     * Generate PDF byte string for Diklat Registration Proof
     */
    public function generate(DiklatRegistration $registration): string
    {
        $registration->loadMissing('program');

        $pdf = new class('P', 'mm', 'A4') extends FPDF {
            public function Header()
            {
                // Logo RSUD
                $logo = public_path('logo.png');
                if (file_exists($logo)) {
                    $this->Image($logo, 15, 12, 22);
                }

                // Kop Surat
                $this->SetFont('Arial', 'B', 11);
                $this->SetTextColor(30, 41, 59);
                $this->SetX(42);
                $this->Cell(0, 5, 'PEMERINTAH KABUPATEN PURWOREJO', 0, 1, 'L');

                $this->SetFont('Arial', 'B', 13);
                $this->SetTextColor(0, 123, 131); // Brand teal #007b83
                $this->SetX(42);
                $this->Cell(0, 6, 'RSUD R.A.A. TJOKRONEGORO', 0, 1, 'L');

                $this->SetFont('Arial', '', 8.5);
                $this->SetTextColor(100, 116, 139);
                $this->SetX(42);
                $this->Cell(0, 4.5, 'Instalasi Pendidikan, Pelatihan & Penelitian (Komkordik / Diklat)', 0, 1, 'L');
                $this->SetX(42);
                $this->Cell(0, 4.5, 'Jl. Pahlawan No. 1, Purworejo, Jawa Tengah | Telp: (0275) 2973040', 0, 1, 'L');

                // Garis Pembatas Kop
                $this->Ln(4);
                $this->SetDrawColor(0, 123, 131);
                $this->SetLineWidth(0.8);
                $this->Line(15, $this->GetY(), 195, $this->GetY());
                $this->SetDrawColor(203, 213, 225);
                $this->SetLineWidth(0.3);
                $this->Line(15, $this->GetY() + 1.2, 195, $this->GetY() + 1.2);
                $this->Ln(6);
            }

            public function Footer()
            {
                $this->SetY(-18);
                $this->SetDrawColor(226, 232, 240);
                $this->Line(15, $this->GetY(), 195, $this->GetY());
                $this->Ln(2);
                $this->SetFont('Arial', 'I', 7.5);
                $this->SetTextColor(148, 163, 184);
                $this->Cell(95, 4, 'Dicetak otomatis via Sistem Informasi Resmi RSUD R.A.A. Tjokronegoro', 0, 0, 'L');
                $this->Cell(85, 4, 'Halaman ' . $this->PageNo(), 0, 1, 'R');
            }
        };

        $pdf->SetMargins(15, 12, 15);
        $pdf->SetAutoPageBreak(true, 22);
        $pdf->AddPage();

        // Judul Dokumen
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(15, 23, 42);
        $pdf->Cell(0, 7, 'TANDA TERIMA BUKTI PENDAFTARAN DIKLAT', 0, 1, 'C');

        $pdf->SetFont('Arial', '', 8.5);
        $pdf->SetTextColor(100, 116, 139);
        $pdf->Cell(0, 4.5, 'Dokumen resmi bukti registrasi - Simpan berkas ini untuk pelacakan status pengajuan', 0, 1, 'C');
        $pdf->Ln(4);

        // Box Nomor Tiket / Pendaftaran
        $pdf->SetFillColor(240, 253, 250); // teal-50
        $pdf->SetDrawColor(153, 246, 228); // teal-200
        $curY = $pdf->GetY();
        $pdf->Rect(15, $curY, 180, 21, 'DF');

        $pdf->SetXY(20, $curY + 3);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(100, 116, 139);
        $pdf->Cell(80, 4, 'NOMOR PENDAFTARAN (KODE TIKET):', 0, 0, 'L');
        $pdf->Cell(80, 4, 'TANGGAL & WAKTU DAFTAR:', 0, 1, 'R');

        $pdf->SetXY(20, $curY + 8);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(0, 123, 131);
        $pdf->Cell(80, 7, $registration->registration_number, 0, 0, 'L');

        $pdf->SetFont('Arial', 'B', 9.5);
        $pdf->SetTextColor(30, 41, 59);
        $createdAt = $registration->created_at ? $registration->created_at->translatedFormat('d F Y, H:i') . ' WIB' : '-';
        $pdf->Cell(80, 7, $createdAt, 0, 1, 'R');

        $pdf->SetY($curY + 25);

        // Section 1: Informasi Peserta
        $pdf->SetFont('Arial', 'B', 9.5);
        $pdf->SetTextColor(0, 123, 131);
        $pdf->Cell(0, 6, 'A. DATA IDENTITAS PENDAFTAR', 0, 1, 'L');
        $pdf->SetDrawColor(226, 232, 240);
        $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
        $pdf->Ln(2);

        $category = strtolower(trim($registration->program?->category ?? ''));
        $isEducation = !in_array($category, ['pelatihan', 'orientasi']);

        if ($isEducation) {
            $fields = [
                ['Nama Lengkap', $registration->full_name],
                ['Instansi Asal', $registration->institution],
                ['Program Studi / Jurusan', $registration->study_program ?: '-'],
                ['Jenjang Pendidikan', $registration->education_level ?: '-'],
                ['Nomor HP / WhatsApp', $registration->phone],
                ['Alamat Email', $registration->email],
            ];
        } else {
            $fields = [
                ['Nama Lengkap', $registration->full_name],
                ['Instansi Asal', $registration->institution],
                ['Nomor HP / WhatsApp', $registration->phone],
                ['Alamat Email', $registration->email],
            ];

            if (!empty($registration->str_number)) {
                $fields[] = ['Nomor STR', $registration->str_number];
            }

            if (!empty($registration->satusehat_id)) {
                $fields[] = ['ID SatuSehat SDMK', $registration->satusehat_id];
            }
        }

        if (!empty($registration->purpose)) {
            $fields[] = ['Tujuan Program', $registration->purpose];
        }

        foreach ($fields as $f) {
            $pdf->SetFont('Arial', '', 8.5);
            $pdf->SetTextColor(100, 116, 139);
            $pdf->Cell(45, 5.2, $f[0], 0, 0, 'L');
            $pdf->Cell(4, 5.2, ':', 0, 0, 'C');

            $val = $this->cleanText($f[1]);
            if ($f[0] === 'Tujuan Program') {
                $pdf->SetFont('Arial', '', 8.5);
                $pdf->SetTextColor(30, 41, 59);
                if (strlen($val) > 70) {
                    $pdf->MultiCell(0, 4.5, $val, 0, 'L');
                } else {
                    $pdf->Cell(0, 5.2, $val, 0, 1, 'L');
                }
            } else {
                $pdf->SetFont('Arial', 'B', 8.5);
                $pdf->SetTextColor(30, 41, 59);
                $pdf->Cell(0, 5.2, $val, 0, 1, 'L');
            }
        }
        $pdf->Ln(3);

        // Section 2: Informasi Program
        $pdf->SetFont('Arial', 'B', 9.5);
        $pdf->SetTextColor(0, 123, 131);
        $pdf->Cell(0, 6, 'B. DATA PROGRAM YANG DIPILIH', 0, 1, 'L');
        $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
        $pdf->Ln(2);

        $period = '-';
        if ($registration->practice_start_date && $registration->practice_end_date) {
            $period = $registration->practice_start_date->translatedFormat('d M Y') . ' s/d ' . $registration->practice_end_date->translatedFormat('d M Y');
        } elseif ($registration->program?->start_at) {
            $period = $registration->program->start_at->translatedFormat('d M Y');
            if ($registration->program?->end_at) {
                $period .= ' s/d ' . $registration->program->end_at->translatedFormat('d M Y');
            }
        }

        $programName = $registration->program?->title ?? $registration->program?->name ?? 'Program Diklat';
        $programCategory = ucfirst($registration->program?->category ?? 'Pendidikan');

        $programFields = [
            ['Nama Program', $programName],
            ['Kategori Program', $programCategory],
            ['Periode Pelaksanaan', $period],
            ['Lokasi Pelaksanaan', $registration->program?->location ?: 'RSUD R.A.A. Tjokronegoro'],
            ['Status Registrasi Awal', strtoupper($registration->status ?? 'DIAJUKAN')],
        ];

        foreach ($programFields as $f) {
            $pdf->SetFont('Arial', '', 8.5);
            $pdf->SetTextColor(100, 116, 139);
            $pdf->Cell(45, 5.2, $f[0], 0, 0, 'L');
            $pdf->Cell(4, 5.2, ':', 0, 0, 'C');
            $pdf->SetFont('Arial', 'B', 8.5);
            $pdf->SetTextColor(30, 41, 59);
            $pdf->Cell(0, 5.2, $this->cleanText($f[1]), 0, 1, 'L');
        }
        $pdf->Ln(4);

        // Section 3: Informasi Pelacakan Tiket
        $pdf->SetFillColor(248, 250, 252); // slate-50
        $pdf->SetDrawColor(226, 232, 240);
        $boxY = $pdf->GetY();
        $pdf->Rect(15, $boxY, 180, 29, 'DF');

        $pdf->SetXY(18, $boxY + 3);
        $pdf->SetFont('Arial', 'B', 8.5);
        $pdf->SetTextColor(15, 23, 42);
        $pdf->Cell(0, 4.5, 'PETUNJUK PELACAKAN STATUS PENGAJUAN:', 0, 1, 'L');

        $trackUrl = url('/informasi/diklat/lacak');
        $pdf->SetX(18);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(71, 85, 105);
        $pdf->MultiCell(174, 4, "1. Simpan lembar tanda terima ini atau catat Nomor Pendaftaran di atas.\n2. Lacak perkembangan seleksi berkas & administrasi melalui menu Lacak Pendaftaran di website resmi RSUD:\n   " . $trackUrl . "\n3. Masukkan Nomor Pendaftaran untuk memantau status Verifikasi Administrasi dan Hasil Akhir.", 0, 'L');

        $pdf->SetY($boxY + 34);

        // Tanda Tangan & Legalisasi Digital
        $curY = $pdf->GetY();
        $pdf->SetXY(120, $curY);
        $pdf->SetFont('Arial', '', 8.5);
        $pdf->SetTextColor(71, 85, 105);
        $pdf->Cell(70, 4.5, 'Purworejo, ' . now()->translatedFormat('d F Y'), 0, 1, 'C');
        $pdf->SetX(120);
        $pdf->Cell(70, 4.5, 'Instalasi Diklat & Komkordik', 0, 1, 'C');
        $pdf->SetX(120);
        $pdf->Cell(70, 4.5, 'RSUD R.A.A. Tjokronegoro', 0, 1, 'C');

        $pdf->Ln(14);
        $pdf->SetX(120);
        $pdf->SetFont('Arial', 'B', 8.5);
        $pdf->SetTextColor(15, 23, 42);
        $pdf->Cell(70, 4.5, 'Panitia Penerimaan Diklat', 0, 1, 'C');
        $pdf->SetX(120);
        $pdf->SetFont('Arial', '', 7.5);
        $pdf->SetTextColor(148, 163, 184);
        $pdf->Cell(70, 3.5, 'Dokumen Digital Terverifikasi Sistem', 0, 1, 'C');

        return $pdf->Output('S');
    }

    /**
     * Clean text to ensure compatibility with FPDF ISO-8859-1 encoding.
     */
    private function cleanText(?string $text): string
    {
        if ($text === null) {
            return '';
        }

        // Convert UTF-8 to ISO-8859-1 / Windows-1252 safely
        $converted = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $text);
        return $converted !== false ? $converted : utf8_decode($text);
    }
}
