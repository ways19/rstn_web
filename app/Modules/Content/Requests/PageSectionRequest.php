<?php

namespace App\Modules\Content\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page_id' => [
                'required',
                'integer',
                'exists:pages,id',
            ],

            'level' => [
                'required',
                'integer',
                'in:1,2',
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:page_sections,id',
                Rule::requiredIf(fn () => (int) $this->input('level') === 2),
                Rule::prohibitedIf(fn () => (int) $this->input('level') === 1),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'parent_id.required' => 'Induk section wajib dipilih untuk level 2.',
            'parent_id.prohibited' => 'Induk section tidak boleh diisi untuk level 1.',
        ];
    }
}
