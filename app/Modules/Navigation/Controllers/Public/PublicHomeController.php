<?php

namespace App\Modules\Navigation\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Modules\Content\Services\BannerService;
use App\Modules\Content\Services\PostService;
use App\Modules\Medical\Services\BedService;
use App\Modules\Medical\Services\DoctorService;
use App\Modules\Medical\Services\ServiceService;

class PublicHomeController extends Controller
{
    public function __construct(
        protected BannerService $bannerService,
        protected ServiceService $serviceService,
        protected DoctorService $doctorService,
        protected PostService $postService,
        protected BedService $bedService
    ) {}

    /**
     * Beranda Publik
     */
    public function home()
    {
        $banners = $this->bannerService->getActiveOrdered();
        $services = $this->serviceService->getActiveOrdered();
        $doctors = $this->doctorService->getActiveOrdered();
        $news = $this->postService->getLatestPublished(3);

        $stats = [
            ['number' => $this->bedService->getTotalBedsCount() . '+', 'label' => 'Tempat Tidur', 'icon' => 'bed'],
            ['number' => $this->doctorService->countActive() . '+', 'label' => 'Dokter Spesialis & Umum', 'icon' => 'stethoscope'],
            ['number' => '18+', 'label' => 'Poliklinik Rawat Jalan', 'icon' => 'building-2'],
            ['number' => '24/7', 'label' => 'Layanan IGD & Ambulans', 'icon' => 'ambulance'],
        ];

        return view('public.home.index', compact('banners', 'services', 'doctors', 'news', 'stats'));
    }

    /**
     * Profil & Tentang Kami
     */
    public function about()
    {
        $directors = [
            [
                'name' => 'dr. Tolkha Amaruddin, Sp.THT-KL., M.Kes',
                'role' => 'Direktur RSUD R.A.A. Tjokronegoro',
                'photo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=80',
                'quote' => 'Melayani dengan sepenuh hati, profesional, dan mengutamakan keselamatan serta kenyamanan pasien.'
            ],
            [
                'name' => 'dr. Nurcholis, Sp.A',
                'role' => 'Kepala Bidang Pelayanan Medis',
                'photo' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=600&q=80',
                'quote' => 'Menjaga standar kualitas dan keselamatan pasien sebagai prioritas utama setiap tindakan.'
            ],
            [
                'name' => 'Sri Wahyuni, S.Kep., Ners., M.M.',
                'role' => 'Kepala Bagian Keperawatan & Penunjang',
                'photo' => 'https://images.unsplash.com/photo-1594824813601-e2a2202611a5?auto=format&fit=crop&w=600&q=80',
                'quote' => 'Sentuhan kasih dan kepedulian tulus mengiringi setiap proses pemulihan.'
            ],
        ];

        return view('public.home.about', compact('directors'));
    }

    /**
     * Dynamic SEO Sitemap XML
     */
    public function sitemap()
    {
        $services = $this->serviceService->getActiveOrdered();
        $news = $this->postService->getLatestPublished(50);
        $doctors = $this->doctorService->getActiveOrdered();

        $content = view('sitemap', compact('services', 'news', 'doctors'));
        return response($content, 200)->header('Content-Type', 'text/xml');
    }

    /**
     * Dynamic robots.txt
     */
    public function robots()
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin\nSitemap: " . url('/sitemap.xml') . "\n";
        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
