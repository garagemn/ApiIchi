<?php

namespace App\Http\Requests\Ichi\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'phone' => 'required|numeric',
            'type' => 'required|in:delivery,pickup',
            'platenumber' => 'required|string',
            'ebarimt' => 'required|in:personal,corporate',
            'items.*.partid' => 'required|integer|exists:wh_inventory_branches,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
        if($this->input('type') === 'delivery') {
            $rules['city'] = 'required|integer';
            $rules['district'] = 'required|integer';
            $rules['team'] = 'required|integer';
            $rules['address'] = 'required|string';
        } elseif($this->input('type') === 'pickup') {
            $rules['pickupbranch'] = 'required|integer';
        }

        if($this->input('ebarimt') === 'corporate') {
            $rules['regnumber'] = 'required|numeric';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'phone.required' => 'Худалдан авагчийн утасны дугаарыг оруулна уу',
            'phone.integer' => 'Зөвхөн тоо байх ёстой',
            'type.required' => 'Захиалгын төрлөө сонгоно уу',
            'type.in' => 'Захиалгын төрөл delivery or pickup',
            'platenumber.required' => 'Машины улсын дугаарыг оруулна уу',
            'platenumber.string' => 'Текст төрөлтэй байх ёстой',
            'city.required' => 'Аймаг, хотоо сонгоно уу',
            'district.required' => 'Сум, Дүүрэг сонгоно уу',
            'team.required' => 'Баг, хороо сонгоно уу',
            'address.required' => 'Дэлгэрэнгийн хаягаа оруулна уу',
            'ebarimt.required' => 'И-баримт авах төрлөө сонгоно уу',
            'ebarimt.in' => 'Төрөл personal or corporate',
            'regnumber.required' => 'Байгууллагын регистерээ оруулна уу',
            'pickupbranch.required' => 'Очиж авах салбараа сонгоно уу',
            'pickupbranch.integer' => 'Зөвхөн тоо байх ёстой',
            'items.required' => 'items дата байхгүй байна',
            'items.array' => 'must be an array',
            'items.*.partid.required' => 'Сэлбэгийн дугаар байхгүй байна',
            'items.*.partid.integer' => 'Зөвхөн тоо байх ёстой',
            'items.*.quantity.required' => 'Сэлбэгийн тоо ширхэг байхгүй байна',
            'items.*.quantity.min' => 'Хамгийн багадаа 1 ш сэлбэг захиалах ёстой',
            'items.*.quantity.integer' => 'Сэлбэгийн тоо ширхэг бүхэл тоо байх ёстой',
        ];
    }
}
