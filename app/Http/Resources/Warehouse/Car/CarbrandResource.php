<?php

namespace App\Http\Resources\Warehouse\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarbrandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'manuid' => $this->manuid,
            'name' => $this->manuname,
            'imgurl' => $this->imgurl
        ];
    }
}
