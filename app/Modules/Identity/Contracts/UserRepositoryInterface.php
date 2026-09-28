<?php

namespace App\Modules\Identity\Contracts;

use App\Modules\Common\Contracts\BaseRepositoryInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateWithRoles(int $perPage = 15): LengthAwarePaginator;

    public function findByEmail(string $email): ?User;
}
