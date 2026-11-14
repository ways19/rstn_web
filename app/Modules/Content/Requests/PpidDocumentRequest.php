<?php

namespace App\Modules\Content\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PpidDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $type = $this->input('type');

        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'year' => [
                'required',
                'integer',
                'min:2000',
                'max:2100',
            ],

            'type' => [
                'required',
                Rule::in([
                    'page',
                    'file',
                    'link',
                    'video',
                ]),
            ],

            'url' => [
                'nullable',
                'url',
                'max:2048',
                'required_if:type,link,video',
            ],

            'file_path' => [
                'nullable',
                'file',
                'max:10240',
                'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,webp',

                ...($this->isMethod('post') && $type === 'file'
                    ? ['required']
                    : []),
            ],

            'page_id' => [
                'nullable',
                'integer',
                'exists:pages,id',
                'required_if:type,page',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'page_section_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'page_section_ids.*' => [
                'integer',
                'exists:page_sections,id',
            ],

            'section_ids.*.*' => [
                'integer',
                'exists:page_sections,id',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ];
    }
}
