<?php

namespace App\Http\Requests\User\Profile;

use Illuminate\Foundation\Http\FormRequest;

class SetfmcRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
          return [
            'fcm' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fcm.required' => 'Хэрэглэгчийн fcm token-ийг илгээнэ үү',
        ];
    }
}
