<?php

namespace App\Modules\Medical\Contracts;

use App\Modules\Common\Contracts\BaseRepositoryInterface;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

interface ServiceRepositoryInterface extends BaseRepositoryInterface
{
    public function getOrdered(): Collection;

    public function getActiveOrdered(): Collection;

    public function getByCategory(string $category = 'semua'): Collection;

    public function getRelatedServices(int $excludeId, int $limit = 3): Collection;

    public function findBySlug(string $slug): ?Service;
}
