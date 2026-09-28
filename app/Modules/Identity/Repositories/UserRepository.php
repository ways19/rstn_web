<?php

namespace App\Modules\Identity\Repositories;

use App\Models\User;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Identity\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function paginateWithRoles(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with('roles')->latest()->paginate($perPage);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }
}
