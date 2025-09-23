<?php

namespace App\Http\Resources\Warehouse\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'categoryid' => $this->categorygroupid,
            'name' => $this->name ?? $this->categoryname,
        ];
    }
}
