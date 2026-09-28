<?php

namespace App\Modules\Content\Repositories;

use App\Models\Banner;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Content\Contracts\BannerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BannerRepository extends BaseRepository implements BannerRepositoryInterface
{
    public function __construct(Banner $model)
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
}
