<?php

namespace App\Http\Resources\Warehouse\Partbrand;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartbrandResouce extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'brandno' => $this->datasupplierid,
            'brandname' => $this->brandname,
            'logo' => $this->logo?->imageurl200 ?? null,
        ];
    }
}
