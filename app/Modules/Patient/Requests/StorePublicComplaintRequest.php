<?php

namespace App\Modules\Patient\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:25'],
            'category' => ['required', 'string'],
            'message' => ['required', 'string'],
        ];
    }
}
