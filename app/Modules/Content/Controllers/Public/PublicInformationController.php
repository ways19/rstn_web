<?php

namespace App\Modules\Content\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\DiklatDocumentation;
use App\Models\DiklatProgram;
use App\Models\DiklatGuideline;
use Illuminate\Support\Facades\Storage;

class PublicInformationController extends Controller
{
    /**
     * Rujukan Gawat Darurat
     */
    public function emergencyReferral()
    {
        $page = Page::with(['sections' => function ($query) {
            $query->where('is_active', true);
        }])
            ->where('slug', 'rujukan-gawat-darurat')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.information.emergency-referral', compact('page'));
    }

    /**
     * Alur Pendaftaran
     */
    public function registrationFlow()
    {
        $page = \App\Models\Page::where('slug', 'alur-pendaftaran')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.information.registration-flow', compact('page'));
    }

    /**
     * Tata Tertib Jam Berkunjung
     */
    public function visitingRules()
    {
        $page = \App\Models\Page::where(
            'slug',
            'tata-tertib-jam-berkunjung'
        )->where('is_active', true)->firstOrFail();

        return view('public.information.visiting-rules', compact('page'));
    }

    /**
     * FAQ
     */
    public function faq()
    {
        $page = \App\Models\Page::where('slug', 'faq')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.information.faq', compact('page'));
    }

    /**
     * Pendidikan & Pelatihan (Diklat)
     */
    public function training()
    {
        $page = \App\Models\Page::where('slug', 'diklat')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.information.diklat', compact('page'));
    }
    
    /**
     * Detail Program Diklat (Pendidikan, Pelatihan, maupun Orientasi).
     */
    public function trainingDetail(DiklatProgram $program)
    {
        // Pastikan program masih aktif.
        abort_unless($program->is_active, 404);

        return view(
            'public.information.diklat-program-detail',
            compact('program')
        );
    }

    /**
     * Menampilkan brosur program pelatihan dalam format PDF viewer.
     * Berkas PDF asli ditampilkan langsung, sedangkan berkas gambar (JPG/PNG/WEBP)
     * dikonversi secara dinamis (on-the-fly) menjadi halaman PDF menggunakan FPDF.
     */
    public function trainingBrochure(DiklatProgram $program)
    {
        abort_unless($program->is_active, 404);

        $path = $program->flyer_image ?: ($program->image ?? null);
        $filePath = null;
        $mimeType = null;

        if ($path && Storage::disk('public')->exists($path)) {
            $filePath = Storage::disk('public')->path($path);
            $mimeType = Storage::disk('public')->mimeType($path);
        } else {
            // Gunakan gambar kartu / ilustrasi bawaan pelatihan sebagai fallback jika brosur belum diunggah khusus
            $fallbacks = [
                public_path('images/hospital-room-360.jpg'),
                public_path('images/rsud-header.png'),
            ];
            foreach ($fallbacks as $fallback) {
                if (file_exists($fallback)) {
                    $filePath = $fallback;
                    $mimeType = mime_content_type($fallback) ?: 'image/jpeg';
                    break;
                }
            }
        }

        abort_unless($filePath && file_exists($filePath), 404, 'Brosur pelatihan tidak ditemukan.');

        $slugName = \Illuminate\Support\Str::slug($program->name ?: 'pelatihan');
        $downloadFilename = 'Brosur-' . $slugName . '.pdf';

        // Jika berkas asli sudah PDF, tampilkan langsung
        if ($mimeType === 'application/pdf') {
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $downloadFilename . '"',
                'X-Content-Type-Options' => 'nosniff',
            ]);
        }

        // Konversi gambar (JPG, PNG, WEBP) menjadi PDF on-the-fly
        $tempConvertedPath = null;
        if ($mimeType === 'image/webp' && function_exists('imagecreatefromwebp')) {
            $img = @imagecreatefromwebp($filePath);
            if ($img) {
                $tempConvertedPath = tempnam(sys_get_temp_dir(), 'brosur_webp_') . '.png';
                imagepng($img, $tempConvertedPath);
                imagedestroy($img);
                $filePath = $tempConvertedPath;
            }
        }

        try {
            $imageSize = @getimagesize($filePath);
            abort_if(!$imageSize, 422, 'Dokumen gambar brosur tidak dapat diproses.');

            [$imageWidth, $imageHeight] = $imageSize;

            $isLandscape = $imageWidth > $imageHeight;
            $pageWidth = $isLandscape ? 297 : 210;
            $pageHeight = $isLandscape ? 210 : 297;

            $margin = 10;
            $maxWidth = $pageWidth - (2 * $margin);
            $maxHeight = $pageHeight - (2 * $margin);

            $ratio = min($maxWidth / $imageWidth, $maxHeight / $imageHeight);
            $renderWidth = $imageWidth * $ratio;
            $renderHeight = $imageHeight * $ratio;

            $x = ($pageWidth - $renderWidth) / 2;
            $y = ($pageHeight - $renderHeight) / 2;

            $pdf = new \FPDF($isLandscape ? 'L' : 'P', 'mm', 'A4');
            $pdf->SetTitle('Brosur ' . ($program->name ?: 'Pelatihan'), true);
            $pdf->AddPage();
            $pdf->Image($filePath, $x, $y, $renderWidth, $renderHeight);

            $pdfContent = $pdf->Output('S');

            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $downloadFilename . '"',
                'Content-Length' => strlen($pdfContent),
                'X-Content-Type-Options' => 'nosniff',
            ]);
        } finally {
            if ($tempConvertedPath && file_exists($tempConvertedPath)) {
                @unlink($tempConvertedPath);
            }
        }
    }


    public function education()
    {
        $page = Page::where('slug', 'pendidikan-pelatihan')
            ->where('is_active', true)
            ->firstOrFail();

        $diklatPrograms = DiklatProgram::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_at')
                    ->orWhereDate('start_at', '>', today());
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        // Kategori pendidikan: kategori selain pelatihan dan orientasi.
        $educationPrograms = $diklatPrograms
            ->filter(function ($program) {
                $category = strtolower(trim($program->category ?? ''));

                return !in_array($category, ['pelatihan', 'orientasi']);
            })
            ->values();

        // Kategori pelatihan dan orientasi.
        $trainingPrograms = $diklatPrograms
            ->filter(function ($program) {
                $category = strtolower(trim($program->category ?? ''));

                return in_array($category, ['pelatihan', 'orientasi']);
            })
            ->values();

            $educationCards = view(
                'public.information.partials.diklat-program-cards',
                [
                    'diklatPrograms' => $educationPrograms,
                    'programType' => 'pendidikan',
                ]
            )->render();

            $trainingCards = view(
                'public.information.partials.diklat-program-cards',
                [
                    'diklatPrograms' => $trainingPrograms,
                    'programType' => 'pelatihan',
                ]
            )->render();

        $content = $page->content ?? '';

        $content = str_replace(
            '<!-- DYNAMIC_DIKLAT_PENDIDIKAN -->',
            $educationCards,
            $content
        );

        $content = str_replace(
            '<!-- DYNAMIC_DIKLAT_PELATIHAN -->',
            $trainingCards,
            $content
        );

        $guidelines = DiklatGuideline::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $guidelinesHtml = view(
            'public.information.partials.diklat-guideline-items',
            compact('guidelines')
        )->render();

        if (str_contains($content, '<!-- DYNAMIC_DIKLAT_GUIDELINES -->')) {
            $content = str_replace(
                '<!-- DYNAMIC_DIKLAT_GUIDELINES -->',
                $guidelinesHtml,
                $content
            );
        } else {
            $startTag = '<div class="diklat-file-list">';
            $startPos = strpos($content, $startTag);
            if ($startPos !== false) {
                $endTag = '<small class="diklat-doc-note">';
                $endPos = strpos($content, $endTag, $startPos);
                if ($endPos !== false) {
                    $content = substr_replace($content, $guidelinesHtml . "\n\n            ", $startPos, $endPos - $startPos);
                }
            }
        }

        $page->content = $content;

        return view('public.information.pendidikan', compact('page'));
    }

    public function downloadGuideline(DiklatGuideline $guideline)
    {
        if ($guideline->external_url) {
            return redirect()->away($guideline->external_url);
        }

        abort_unless(
            $guideline->file_path && Storage::disk('public')->exists($guideline->file_path),
            404,
            'Berkas dokumen tidak ditemukan.'
        );

        $extension = pathinfo($guideline->file_path, PATHINFO_EXTENSION) ?: ($guideline->file_type ?: 'pdf');

        $cleanTitle = trim(preg_replace('/[\\\\\/:\*\?"<>\|]/', ' ', $guideline->title));
        $filename = $cleanTitle . '.' . $extension;

        return Storage::disk('public')->download($guideline->file_path, $filename);
    }


    public function facilities()
    {
        $page = \App\Models\Page::where('slug', 'fasilitas')
            ->where('is_active', true)
            ->firstOrFail();

        $facilities = \App\Models\Facility::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('public.information.fasilitas', compact(
            'page',
            'facilities'
        ));
    }

    public function accreditation()
    {
        $page = \App\Models\Page::with([
            'accreditationCertificates' => function ($query) {
                $query->where('is_active', true);
            },
        ])
            ->where('slug', 'akreditasi')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.information.akreditasi', compact('page'));
    }

    
    public function documentation()
    {
        $page = \App\Models\Page::where('slug', 'dokumentasi')
            ->where('is_active', true)
            ->firstOrFail();

        $documentations = DiklatDocumentation::with('photos')
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        $cards = $documentations->map(function ($item) {
            $photos = $item->photos
                ->pluck('image_path')
                ->filter()
                ->values();

            // Dokumentasi lama mungkin hanya memiliki foto utama.
            if (
                $item->image_path &&
                !$photos->contains($item->image_path)
            ) {
                $photos->prepend($item->image_path);
            }

            $imageUrl = $item->image_path
                ? asset('storage/' . $item->image_path)
                : asset('images/no-image.png');

            $title = e($item->title);

            $date = $item->event_date
                ? e($item->event_date->translatedFormat('d F Y'))
                : '';

            $categoryLabels = [
                'orientasi' => 'Orientasi PPDS, Dokter Muda, dan Nakes',
                'pelatihan' => 'Pelatihan',
                'kunjungan' => 'Studi Banding & Kunjungan Institusi',
            ];

            $category = $item->category;

            $categoryLabel = e(
                $categoryLabels[$category] ?? 'Lainnya'
            );

            return '
                <a
                    href="' . route(
                        'information.documentation.detail',
                        $item->id
                    ) . '"
                    class="diklat-dokumentasi__card"
                    data-category="' . e($category) . '"
                    aria-label="Lihat dokumentasi ' . $title . '"
                >
                    <div class="diklat-dokumentasi__image">
                        <img
                            src="' . e($imageUrl) . '"
                            alt="' . $title . '"
                            loading="lazy"
                        >
                    </div>

                    <div class="diklat-dokumentasi__caption">
                        <span class="diklat-dokumentasi__category">
                            ' . $categoryLabel . '
                        </span>

                        <h3>' . $title . '</h3>

                        ' . ($date !== '' ? '
                            <p class="diklat-dokumentasi__meta">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="15" height="15"
                                    viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="16" rx="2"/>
                                    <path d="M16 3v4M8 3v4M3 11h18"/>
                                </svg>
                                <span>' . $date . '</span>
                            </p>
                        ' : '') . '

                        <span class="diklat-dokumentasi__card-arrow"
                            aria-hidden="true">→</span>
                    </div>
                </a>
            ';
        })->implode('');

        // Satu grid berisi seluruh dokumentasi untuk difilter dan dipaginasi.
        $page->content = preg_replace(
            '/<!--\s*DOKUMENTASI_CARDS\s*-->/',
            addcslashes($cards, '\\$'),
            $page->content
        );

        return view('public.information.dokumentasi', compact('page'));
    }



    /**
     * Detail Dokumentasi Kegiatan
     */
    public function documentationDetail(DiklatDocumentation $documentation)
    {
        abort_unless($documentation->is_active, 404);

        $documentation->load('photos');

        // Ambil foto tambahan sesuai urutan.
        $photos = $documentation->photos
            ->pluck('image_path')
            ->filter()
            ->values();

        // Tambahkan foto utama jika belum masuk daftar.
        if (
            $documentation->image_path &&
            !$photos->contains($documentation->image_path)
        ) {
            $photos->prepend($documentation->image_path);
        }

        // Ubah path menjadi URL publik.
        $photoUrls = $photos
            ->map(fn ($path) => asset('storage/' . $path))
            ->values();

        return view('public.information.dokumentasi-detail', [
            'documentation' => $documentation,
            'photoUrls' => $photoUrls,
        ]);
    }

    /**
     * Informasi Publik
     */
    public function publicInformation()
    {
        $page = \App\Models\Page::where('slug', 'informasi-publik')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.information.public-information', compact('page'));
    }


    /**
     * Halaman Aduan
     */
    public function onlineComplaint()
    {
        $page = \App\Models\Page::where('slug', 'pengaduan-online-pasien')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.aduan.pengaduan-online-pasien', compact('page'));
    }

    public function conflictOfInterest()
    {
        $page = \App\Models\Page::where('slug', 'lapor-benturan-kepentingan')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.aduan.lapor-benturan-kepentingan', compact('page'));
    }

    public function whistleblowing()
    {
        $page = \App\Models\Page::where('slug', 'whistle-blowing-system')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.aduan.whistle-blowing-system', compact('page'));
    }

    public function complaintContacts()
    {
        $page = \App\Models\Page::where('slug', 'saluran-kontak-pengaduan')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.aduan.saluran-kontak-pengaduan', compact('page'));
    }

}