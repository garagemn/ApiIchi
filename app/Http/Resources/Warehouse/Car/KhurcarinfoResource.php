<?php

namespace App\Http\Resources\Warehouse\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KhurcarinfoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'platenumber' => $this->platenumber,
            'islandnumber' => $this->islandnumber,
            'manufacture' => $this->manufacture,
            'model' => $this->model,
            'buildyear' => $this->buildyear,
            'carid' => $this->carid
        ];
    }
}
