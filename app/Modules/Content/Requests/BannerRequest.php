<?php

namespace App\Modules\Content\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'cta_text' => ['nullable', 'string', 'max:100'],
            'cta_link' => ['nullable', 'string', 'max:255'],
            'cta_text2' => ['nullable', 'string', 'max:100'],
            'cta_link2' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}