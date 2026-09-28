<?php

namespace App\Modules\Content\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Modules\Content\Services\PostService;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    /**
     * Berita, Pengumuman & Edukasi Kesehatan
     */
    public function news(Request $request)
    {
        $category = $request->query('kategori', 'semua');
        $newsList = $this->postService->getFilteredNews($category);
        $popularNews = $this->postService->getPopularNews(3);

        return view('public.content.news.index', compact('newsList', 'category', 'popularNews'));
    }

    /**
     * Detail Berita & Edukasi PKRS
     */
    public function newsDetail(string $slug)
    {
        $data = $this->postService->getNewsDetailWithRelated($slug, 3);
        return view('public.content.news.detail', $data);
    }
}
