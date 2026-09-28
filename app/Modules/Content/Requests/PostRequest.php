<?php

namespace App\Modules\Content\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'excerpt' => ['required', 'string'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }
}
