<?php

namespace App\Modules\Content\Services;

use App\Models\Page;
use App\Modules\Content\Contracts\PageRepositoryInterface;

class PageService
{
    public function __construct(
        protected PageRepositoryInterface $pageRepository
    ) {}

    public function findBySlug(string $slug): ?Page
    {
        return $this->pageRepository->findBySlug($slug);
    }
}
