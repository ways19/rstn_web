<?php

namespace App\Modules\Navigation\Repositories;

use App\Models\AppModule;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Navigation\Contracts\ModuleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ModuleRepository extends BaseRepository implements ModuleRepositoryInterface
{
    public function __construct(AppModule $model)
    {
        parent::__construct($model);
    }

    public function getOrdered(): Collection
    {
        return $this->model->orderBy('order')->get();
    }
}
