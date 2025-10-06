<?php

namespace App\Http\Resources\Warehouse\Part;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'attributename' => $this->attrname?->name ?? $this->attrname?->attrname,
            'attributevalue' => $this->attrvalue?->name ?? $this->attrvalue?->attrvalue. ' ' . $this->attrvalue?->attrunit ?? null
        ];
    }
}
