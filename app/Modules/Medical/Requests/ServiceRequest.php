<?php

namespace App\Modules\Medical\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'tag' => ['nullable', 'string', 'max:100'],
            'excerpt' => ['required', 'string'],
            'description' => ['required', 'string'],
            'facilities_text' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
