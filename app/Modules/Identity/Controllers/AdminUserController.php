<?php

namespace App\Modules\Identity\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Modules\Identity\Requests\StoreUserRequest;
use App\Modules\Identity\Requests\UpdateUserRequest;
use App\Modules\Identity\Services\UserService;

class AdminUserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index()
    {
        $users = $this->userService->getPaginatedUsers(15);
        return view('admin.identity.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.identity.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());
        return redirect()->route('admin.users.index')->with('success', "Akun petugas {$user->name} berhasil ditambahkan.");
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoleIds = $user->roles->pluck('id')->toArray();
        return view('admin.identity.users.edit', compact('user', 'roles', 'userRoleIds'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->updateUser($user, $request->validated());
        return redirect()->route('admin.users.index')->with('success', "Data akun {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        $deleted = $this->userService->deleteUser($user, auth()->id());

        if (! $deleted) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        return redirect()->route('admin.users.index')->with('success', 'Akun petugas berhasil dihapus.');
    }
}
