<?php

namespace App\Modules\Patient\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistrationStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:terdaftar,dipanggil,selesai,batal'],
        ];
    }
}
