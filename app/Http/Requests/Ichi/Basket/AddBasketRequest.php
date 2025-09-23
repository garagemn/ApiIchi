<?php

namespace App\Http\Requests\Ichi\Basket;

use Illuminate\Foundation\Http\FormRequest;

class AddBasketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'partid' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'partid.required' => 'Худалдан авагчийн утасны дугаарыг оруулна уу',
            'partid.integer' => 'Зөвхөн тоо байх ёстой',
            'quantity.required' => 'Тоо ширхэгээ оруулна уу',
            'quantity.integer' => 'Зөвхөн тоо байх ёстой',
            'quantity.min' => 'хамгийн багадаа 1 ш сагслах боломжтой'
        ];
    }
}
