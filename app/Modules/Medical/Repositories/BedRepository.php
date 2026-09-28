<?php

namespace App\Modules\Medical\Repositories;

use App\Models\Bed;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Medical\Contracts\BedRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BedRepository extends BaseRepository implements BedRepositoryInterface
{
    public function __construct(Bed $model)
    {
        parent::__construct($model);
    }

    public function getOrdered(): Collection
    {
        return $this->model->orderBy('order')->get();
    }

    public function getTotalBedsCount(): int
    {
        return (int) $this->model->sum('total');
    }

    public function getAvailableBedsCount(): int
    {
        return (int) $this->model->sum('available');
    }
}
