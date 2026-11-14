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
            'photo_source' => ['nullable', 'in:upload,url'],
            'photo' => ['nullable', 'string'],
            'photo_url' => ['nullable', 'string'],
            'photo_file' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama lengkap & gelar',
            'speciality' => 'spesialisasi',
            'sub_speciality' => 'sub-spesialisasi',
            'poli' => 'poliklinik tujuan',
            'schedule' => 'jadwal praktik',
            'photo_file' => 'berkas foto dokter',
            'photo_url' => 'URL foto dokter',
        ];
    }
}
