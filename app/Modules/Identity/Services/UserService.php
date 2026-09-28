<?php

namespace App\Modules\Identity\Services;

use App\Models\User;
use App\Modules\Identity\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function getPaginatedUsers(int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->paginateWithRoles($perPage);
    }

    public function createUser(array $data): User
    {
        /** @var User $user */
        $user = $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (! empty($data['roles'])) {
            $user->roles()->sync($data['roles']);
        }

        return $user;
    }

    public function updateUser(User $user, array $data): User
    {
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (! empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        if (isset($data['roles'])) {
            $user->roles()->sync($data['roles']);
        }

        return $user;
    }

    public function deleteUser(User $user, int $currentUserId): bool
    {
        if ($user->id === $currentUserId) {
            return false;
        }

        return $this->userRepository->delete($user->id);
    }
}
