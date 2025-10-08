<?php

namespace App\Http\Requests\Warehouse\Part\Partlinked;

use Illuminate\Foundation\Http\FormRequest;

class CarengineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'articleid' => 'required|integer',
            'manuid' => 'required|integer',
            'modelid' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'articleid.required' => 'required articleid',
            'articleid.integer' => 'Зөвхөн тоо байх ёстой',
            'manuid.required' => 'required manuid',
            'manuid.integer' => 'Зөвхөн тоо байх ёстой',
            'modelid.required' => 'required manuid',
            'modelid.integer' => 'Зөвхөн тоо байх ёстой'
        ];
    }
}
