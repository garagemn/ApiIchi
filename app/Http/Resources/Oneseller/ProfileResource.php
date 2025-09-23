<?php

namespace App\Http\Resources\Oneseller;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'onesellerid' => $this->id,
            'lastname' => $this->lastname,
            'name' => $this->name,
            'phone' => $this->phone,
            'level' => $this->level ?? null,
            'points' => $this->points_sum_point ?? 0,
            'organization' => $this->organization?->name ?? null,
            'branch' => $this->branch?->name ?? null,
            'childs' => $this->children_count ?? 0,
        ];
    }
}
