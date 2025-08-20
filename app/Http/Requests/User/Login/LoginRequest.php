<?php

namespace App\Http\Requests\User\Login;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|numeric',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Утасны дугаараа оруулна уу',
            'password.required' => 'Нууц үгээ оруулна уу'
        ];
    }
}
