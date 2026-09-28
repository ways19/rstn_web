<?php

namespace App\Modules\Content\Services;

use App\Models\Banner;
use App\Modules\Content\Contracts\BannerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BannerService
{
    public function __construct(
        protected BannerRepositoryInterface $bannerRepository
    ) {}

    public function getAllOrdered(): Collection
    {
        return $this->bannerRepository->getOrdered();
    }

    public function getActiveOrdered(): Collection
    {
        return $this->bannerRepository->getActiveOrdered();
    }

    public function createBanner(array $data): Banner
    {
        /** @var Banner $banner */
        $banner = $this->bannerRepository->create([
            'title' => $data['title'],
            'subtitle' => $data['subtitle'] ?? null,
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?: 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1600&q=80',
            'cta_text' => $data['cta_text'] ?? null,
            'cta_link' => $data['cta_link'] ?? null,
            'cta_text2' => $data['cta_text2'] ?? null,
            'cta_link2' => $data['cta_link2'] ?? null,
            'order' => $data['order'] ?? 0,
            'is_active' => $data['is_active'] ?? true,
        ]);

        return $banner;
    }

    public function updateBanner(Banner $banner, array $data): Banner
    {
        $banner->update([
            'title' => $data['title'],
            'subtitle' => $data['subtitle'] ?? null,
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?: $banner->image,
            'cta_text' => $data['cta_text'] ?? null,
            'cta_link' => $data['cta_link'] ?? null,
            'cta_text2' => $data['cta_text2'] ?? null,
            'cta_link2' => $data['cta_link2'] ?? null,
            'order' => $data['order'] ?? 0,
            'is_active' => $data['is_active'] ?? false,
        ]);

        return $banner;
    }

    public function deleteBanner(Banner $banner): bool
    {
        return $this->bannerRepository->delete($banner->id);
    }
}
