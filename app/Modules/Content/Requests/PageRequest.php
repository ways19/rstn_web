<?php

namespace App\Modules\Content\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $slug = $this->input('slug') ?? $this->route('page')?->slug;

        $fileRules = [
            'nullable',
            'file',
        ];

        if ($slug === 'maklumat-pelayanan-informasi') {
            $fileRules[] = 'max:5120';
            $fileRules[] = 'mimes:jpg,jpeg,png,webp';
        } else {
            $fileRules[] = 'max:10240';
            $fileRules[] = 'mimes:pdf,doc,docx,xls,xlsx';
        }

        return [
            'title' => ['required', 'string', 'max:255'],

            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('pages', 'slug')->ignore($this->route('page')),
            ],

            'category' => ['required', 'string', 'max:255'],

            'description' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],

            'file_attachment' => $fileRules,
            

            'is_active' => ['nullable', 'boolean'],
        ];
    }
}