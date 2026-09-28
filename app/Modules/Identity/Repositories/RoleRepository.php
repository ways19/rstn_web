<?php

namespace App\Modules\Identity\Repositories;

use App\Models\Permission;
use App\Models\Role;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Identity\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function allWithRelations(): Collection
    {
        return $this->model->with('permissions', 'users')->get();
    }

    public function getAllPermissionsGrouped(): Collection
    {
        return Permission::all()->groupBy('group');
    }
}
