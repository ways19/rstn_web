<?php

namespace App\Modules\Patient\Contracts;

use App\Modules\Common\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ComplaintRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateLatest(int $perPage = 15): LengthAwarePaginator;

    public function getLatest(int $limit = 5): Collection;

    public function countTotal(): int;

    public function countNew(): int;
}
