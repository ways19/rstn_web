<?php

namespace App\Modules\Navigation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'group' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
            'route_name' => ['nullable', 'string', 'max:100'],
            'is_active' => ['required', 'boolean'],
            'order' => ['required', 'integer'],
        ];
    }
}
