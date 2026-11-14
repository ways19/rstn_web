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
            'image_360' => ['nullable', 'string', 'max:1000'],
            'image_360_file' => ['nullable', 'image', 'max:15360'],
            'order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
