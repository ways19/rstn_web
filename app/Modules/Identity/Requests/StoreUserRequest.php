<?php

namespace App\Modules\Identity\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage_users') ?? true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'roles' => ['required', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ];
    }
}
