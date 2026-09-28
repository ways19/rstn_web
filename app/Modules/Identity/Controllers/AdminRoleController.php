<?php

namespace App\Modules\Identity\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Modules\Identity\Requests\RoleRequest;
use App\Modules\Identity\Services\RoleService;

class AdminRoleController extends Controller
{
    public function __construct(
        protected RoleService $roleService
    ) {}

    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        return view('admin.identity.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->roleService->getAllPermissionsGrouped();
        return view('admin.identity.roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $role = $this->roleService->createRole($request->validated());
        return redirect()->route('admin.roles.index')->with('success', "Role {$role->label} berhasil dibuat.");
    }

    public function edit(Role $role)
    {
        $permissions = $this->roleService->getAllPermissionsGrouped();
        $rolePermissionIds = $role->permissions->pluck('id')->toArray();
        return view('admin.identity.roles.edit', compact('role', 'permissions', 'rolePermissionIds'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $this->roleService->updateRole($role, $request->validated());
        return redirect()->route('admin.roles.index')->with('success', "Hak akses role {$role->label} berhasil diperbarui.");
    }

    public function destroy(Role $role)
    {
        $deleted = $this->roleService->deleteRole($role);

        if (! $deleted) {
            return back()->with('error', 'Role Superadmin tidak dapat dihapus.');
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dihapus.');
    }
}
