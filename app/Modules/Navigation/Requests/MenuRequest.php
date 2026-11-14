<?php

namespace App\Modules\Navigation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location' => ['required', 'in:public,admin'],
            'parent_id' => ['nullable', 'exists:menus,id'],
            'title' => ['required', 'string', 'max:255'],
            'page_id' => ['nullable', 'exists:pages,id'],
            'url' => ['nullable', 'string', 'max:255'],
            'route_name' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:50'],
            'target' => ['required', 'in:_self,_blank'],
            'permission_name' => ['nullable', 'string', 'max:100'],
            'order' => ['required', 'integer'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
