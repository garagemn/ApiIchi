<?php

namespace App\Http\Requests\Ichi\Order;

use Illuminate\Foundation\Http\FormRequest;

class EbarimtRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'regnumber' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'regnumber.required' => 'Байгууллагын регистерийг оруулна уу',
            'regnumber.numeric' => 'Зөвхөн тоо байх ёстой',
        ];
    }
}
