<?php

namespace App\Modules\Patient\Contracts;

use App\Modules\Common\Contracts\BaseRepositoryInterface;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface RegistrationRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateWithFilter(?string $status = null, int $perPage = 15): LengthAwarePaginator;

    public function getLatest(int $limit = 5): Collection;

    public function countTotal(): int;

    public function countPending(): int;
}
