<?php

namespace App\Http\Resources\Warehouse\Part\Partlinked;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkedCarmodelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'modelid' => $this->modelid,
            'modelname' => $this->modelname,
            'yearstart' => $this->yearstart,
            'yearend' => $this->yearend,
        ];
    }
}
