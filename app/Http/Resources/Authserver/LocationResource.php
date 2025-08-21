<?php

namespace App\Http\Resources\Authserver;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'locationid' => $this->id,
            'name' => $this->name,
        ];
    }
}
