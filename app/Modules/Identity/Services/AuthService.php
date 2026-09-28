<?php

namespace App\Modules\Identity\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function attemptLogin(array $credentials, bool $remember = false): bool
    {
        return Auth::attempt($credentials, $remember);
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
