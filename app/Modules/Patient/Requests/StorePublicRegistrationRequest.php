<?php

namespace App\Modules\Patient\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_type' => ['required', 'in:baru,lama'],
            'nik' => ['required', 'string', 'min:16', 'max:16'],
            'rm_number' => ['nullable', 'string'],
            'patient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'insurance' => ['required', 'in:bpjs,umum,asuransi'],
            'clinic' => ['required', 'string'],
            'doctor_name' => ['nullable', 'string'],
            'visit_date' => ['required', 'date', 'after_or_equal:today'],
        ];
    }
}
