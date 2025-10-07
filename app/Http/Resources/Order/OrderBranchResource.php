<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderBranchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'branchid' => $this->id,
            'name' => $this->name,
        ];
    }
}
