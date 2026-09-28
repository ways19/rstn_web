<?php

namespace App\Modules\Content\Contracts;

use App\Modules\Common\Contracts\BaseRepositoryInterface;
use App\Models\Page;

interface PageRepositoryInterface extends BaseRepositoryInterface
{
    public function findBySlug(string $slug): ?Page;
}
