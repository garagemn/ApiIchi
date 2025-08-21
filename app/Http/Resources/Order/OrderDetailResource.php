<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'partid' => $this->wh_inventory_branch_id,
            'category' => $this->branchpart?->part?->category?->name ?? $this->branchpart?->part?->category?->categoryname,
            'articleno' => $this->branchpart->part->articleno,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'totalamount' => $this->totalamount
        ];
    }
}
