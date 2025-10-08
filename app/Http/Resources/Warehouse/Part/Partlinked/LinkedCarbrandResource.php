<?php

namespace App\Http\Resources\Warehouse\Part\Partlinked;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkedCarbrandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'manuid' => $this->manuid,
            'name' => $this->manuname,
        ];
    }
}
