<?php

namespace App\Modules\Patient\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:baru,diproses,selesai'],
            'reply' => ['nullable', 'string'],
        ];
    }
}
