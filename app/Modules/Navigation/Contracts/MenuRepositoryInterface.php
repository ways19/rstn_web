<?php

namespace App\Modules\Navigation\Contracts;

use App\Modules\Common\Contracts\BaseRepositoryInterface;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

interface MenuRepositoryInterface extends BaseRepositoryInterface
{
    public function getTreeByLocation(string $location = 'public'): Collection;

    public function getParentsByLocation(string $location = 'public', ?int $excludeId = null): Collection;

    public function getStats(): array;
}
