<?php

namespace App\Modules\Identity\Services;

use App\Models\Role;
use App\Modules\Identity\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class RoleService
{
    public function __construct(
        protected RoleRepositoryInterface $roleRepository
    ) {}

    public function getAllRoles(): Collection
    {
        return $this->roleRepository->allWithRelations();
    }

    public function getAllPermissionsGrouped(): Collection
    {
        return $this->roleRepository->getAllPermissionsGrouped();
    }

    public function createRole(array $data): Role
    {
        /** @var Role $role */
        $role = $this->roleRepository->create([
            'name' => Str::slug($data['label'], '_'),
            'label' => $data['label'],
            'description' => $data['description'] ?? null,
        ]);

        if (! empty($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }

        return $role;
    }

    public function updateRole(Role $role, array $data): Role
    {
        $role->update([
            'label' => $data['label'],
            'description' => $data['description'] ?? null,
        ]);

        if (isset($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }

        return $role;
    }

    public function deleteRole(Role $role): bool
    {
        if ($role->name === 'superadmin') {
            return false;
        }

        return $this->roleRepository->delete($role->id);
    }
}
