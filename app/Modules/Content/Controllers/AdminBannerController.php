<?php

namespace App\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Modules\Content\Requests\BannerRequest;
use App\Modules\Content\Services\BannerService;

class AdminBannerController extends Controller
{
    public function __construct(
        protected BannerService $bannerService
    ) {}

    public function index()
    {
        $banners = $this->bannerService->getAllOrdered();
        return view('admin.content.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.content.banners.create');
    }

    public function store(BannerRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        $this->bannerService->createBanner($data);

        return redirect()->route('admin.banners.index')->with('success', 'Hero banner berhasil ditambahkan.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.content.banners.edit', compact('banner'));
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $this->bannerService->updateBanner($banner, $data);

        return redirect()->route('admin.banners.index')->with('success', 'Hero banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner)
    {
        $this->bannerService->deleteBanner($banner);
        return redirect()->route('admin.banners.index')->with('success', 'Hero banner berhasil dihapus.');
    }
}
