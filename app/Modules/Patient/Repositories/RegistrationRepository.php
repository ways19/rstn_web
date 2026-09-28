<?php

namespace App\Modules\Patient\Repositories;

use App\Models\Registration;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Patient\Contracts\RegistrationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RegistrationRepository extends BaseRepository implements RegistrationRepositoryInterface
{
    public function __construct(Registration $model)
    {
        parent::__construct($model);
    }

    public function paginateWithFilter(?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->latest();
        if ($status) {
            $query->where('status', $status);
        }
        return $query->paginate($perPage);
    }

    public function getLatest(int $limit = 5): Collection
    {
        return $this->model->latest()->take($limit)->get();
    }

    public function countTotal(): int
    {
        return $this->model->count();
    }

    public function countPending(): int
    {
        return $this->model->where('status', 'terdaftar')->count();
    }
}
