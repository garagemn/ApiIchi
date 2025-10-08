<?php

namespace App\Http\Resources\Warehouse\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KhurcarinfoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'platenumber' => $this->platenumber ?? $request->get('platenumber'),
            'islandnumber' => $this->islandnumber ?? null,
            'manufacture' => $this->manufacture ?? null,
            'model' => $this->model ?? null,
            'buildyear' => $this->buildyear ?? null,
            'carid' => $this->carid ?? null
        ];
    }
}
