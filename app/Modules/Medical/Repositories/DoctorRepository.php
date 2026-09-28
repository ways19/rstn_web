<?php

namespace App\Modules\Medical\Repositories;

use App\Models\Doctor;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Medical\Contracts\DoctorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class DoctorRepository extends BaseRepository implements DoctorRepositoryInterface
{
    public function __construct(Doctor $model)
    {
        parent::__construct($model);
    }

    public function getOrdered(): EloquentCollection
    {
        return $this->model->orderBy('order')->get();
    }

    public function getActiveOrdered(): EloquentCollection
    {
        return $this->model->where('is_active', true)->orderBy('order')->get();
    }

    public function getSpecialities(): Collection
    {
        return $this->getActiveOrdered()->pluck('speciality')->unique()->values();
    }

    public function countActive(): int
    {
        return $this->model->where('is_active', true)->count();
    }
}
