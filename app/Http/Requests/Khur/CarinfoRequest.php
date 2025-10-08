<?php

namespace App\Http\Requests\Khur;

use Illuminate\Foundation\Http\FormRequest;

class CarinfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'platenumber' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'platenumber.required' => 'Улсын дугаарыг оруулна уу',
            'platenumber.string' => 'String төрөлтэй байх ёстой',
        ];
    }
}
