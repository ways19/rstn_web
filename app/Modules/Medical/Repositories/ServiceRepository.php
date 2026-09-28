<?php

namespace App\Modules\Medical\Repositories;

use App\Models\Service;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Medical\Contracts\ServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ServiceRepository extends BaseRepository implements ServiceRepositoryInterface
{
    public function __construct(Service $model)
    {
        parent::__construct($model);
    }

    public function getOrdered(): Collection
    {
        return $this->model->orderBy('order')->get();
    }

    public function getActiveOrdered(): Collection
    {
        return $this->model->where('is_active', true)->orderBy('order')->get();
    }

    public function getByCategory(string $category = 'semua'): Collection
    {
        $query = $this->model->where('is_active', true)->orderBy('order');

        if ($category !== 'semua') {
            $query->where('category', $category);
        }

        return $query->get();
    }

    public function getRelatedServices(int $excludeId, int $limit = 3): Collection
    {
        return $this->model->where('id', '!=', $excludeId)
            ->where('is_active', true)
            ->take($limit)
            ->get();
    }

    public function findBySlug(string $slug): ?Service
    {
        return $this->model->where('slug', $slug)->first();
    }
}
