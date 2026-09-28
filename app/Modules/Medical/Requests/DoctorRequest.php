<?php

namespace App\Modules\Medical\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'speciality' => ['required', 'string'],
            'sub_speciality' => ['nullable', 'string'],
            'poli' => ['required', 'string'],
            'schedule' => ['required', 'string'],
            'days' => ['nullable', 'array'],
            'experience' => ['nullable', 'string'],
            'education' => ['nullable', 'string'],
            'photo' => ['nullable', 'string'],
            'order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
