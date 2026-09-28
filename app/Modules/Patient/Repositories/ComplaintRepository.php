<?php

namespace App\Modules\Patient\Repositories;

use App\Models\Complaint;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Patient\Contracts\ComplaintRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ComplaintRepository extends BaseRepository implements ComplaintRepositoryInterface
{
    public function __construct(Complaint $model)
    {
        parent::__construct($model);
    }

    public function paginateLatest(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->latest()->paginate($perPage);
    }

    public function getLatest(int $limit = 5): Collection
    {
        return $this->model->latest()->take($limit)->get();
    }

    public function countTotal(): int
    {
        return $this->model->count();
    }

    public function countNew(): int
    {
        return $this->model->where('status', 'baru')->count();
    }
}
