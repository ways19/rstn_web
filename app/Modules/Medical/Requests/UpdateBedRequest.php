<?php

namespace App\Modules\Medical\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBedRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'beds' => ['required', 'array'],
            'beds.*.total' => ['required', 'integer', 'min:0'],
            'beds.*.occupied' => ['required', 'integer', 'min:0'],
        ];
    }
}
