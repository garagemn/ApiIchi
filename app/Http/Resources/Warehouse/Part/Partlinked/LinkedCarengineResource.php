<?php

namespace App\Http\Resources\Warehouse\Part\Partlinked;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkedCarengineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'manumanu' => $this->carbrand?->manuname ?? null,
            'modelname' => $this->carmodel?->modelname ?? null,
            'name' => $this->carname,
            'fueltype' => $this->carinfo?->fueltype ?? null,
            'ccm' => $this->carinfo?->ccmtech ?? null,
            'cylinder' => $this->carinfo?->cylinder ?? null,
            'motorcode' => $this->carinfo?->motorcode ?? null,
        ];
    }
}
