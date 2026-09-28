<?php

namespace App\Modules\Navigation\Repositories;

use App\Models\Menu;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Navigation\Contracts\MenuRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MenuRepository extends BaseRepository implements MenuRepositoryInterface
{
    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }

    public function getTreeByLocation(string $location = 'public'): Collection
    {
        return $this->model->where('location', $location)
            ->whereNull('parent_id')
            ->with(['children.children'])
            ->orderBy('order')
            ->get();
    }

    public function getParentsByLocation(string $location = 'public', ?int $excludeId = null): Collection
    {
        $query = $this->model->where('location', $location)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->get();
    }

    public function getStats(): array
    {
        return [
            'total_public' => $this->model->where('location', 'public')->count(),
            'total_admin' => $this->model->where('location', 'admin')->count(),
            'active_public' => $this->model->where('location', 'public')->where('is_active', true)->count(),
            'active_admin' => $this->model->where('location', 'admin')->where('is_active', true)->count(),
        ];
    }
}
