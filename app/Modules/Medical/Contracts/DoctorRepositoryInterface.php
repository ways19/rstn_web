<?php

namespace App\Modules\Medical\Contracts;

use App\Modules\Common\Contracts\BaseRepositoryInterface;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

interface DoctorRepositoryInterface extends BaseRepositoryInterface
{
    public function getOrdered(): EloquentCollection;

    public function getActiveOrdered(): EloquentCollection;

    public function getSpecialities(): Collection;

    public function countActive(): int;
}
