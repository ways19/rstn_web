<?php

namespace App\Modules\Identity\Contracts;

use App\Modules\Common\Contracts\BaseRepositoryInterface;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function allWithRelations(): Collection;

    public function getAllPermissionsGrouped(): Collection;
}
