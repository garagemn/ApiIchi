<?php

namespace App\Http\Resources\Warehouse\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KhurcarinfoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'carid' => $this->carid ?? null,
            'carname' => $this->carname ?? null,
            'manuid' => $this->manuid ?? null,
            'manuname' => $this->manufacture ?? null,
            'modelid' => $this->modelid ?? null,
            'modelname' => $this->model ?? null,
            'motorcode' => $this->motorcode ?? null,
            'motortype' => $this->motortype ?? null,
            'cylinder' => $this->cylinder ?? null,
            'platenumber' => $this->platenumber ?? $request->get('platenumber'),
            'islandnumber' => $this->islandnumber ?? null,
            'buildyear' => $this->buildyear ?? null,
        ];
    }
}
