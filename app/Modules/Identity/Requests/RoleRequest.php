<?php

namespace App\Modules\Identity\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage_users') ?? true;
    }

    public function rules(): array
    {
        return [
            'label' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ];
    }
}
