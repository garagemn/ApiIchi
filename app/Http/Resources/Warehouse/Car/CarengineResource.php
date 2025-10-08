<?php

namespace App\Http\Resources\Warehouse\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarengineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'carid' => $this->carid,
            'carname' => $this->carname,
            'manuid' => $this->manuid,
            'manuname' => $this->carbrand?->manuname ?? null,
            'modelid' => $this->modelid,
            'modelname' => $this->carmodel?->modelname ?? null,
            'motorcode' => $this->carinfo?->motorcode ?? null,
            'motortype' => $this->carinfo?->motortype ?? null,
            'cylinder' => $this->carinfo?->cylinder ?? null,
            'platenumber' => null,
            'islandnumber' => null,
            'buildyear' => null,
        ];
    }
}
