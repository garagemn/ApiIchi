<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'orderid' => $this->id,
            'phone' => $this->phone,
            'type' => $this->type(),
            'totalamount' => $this->details->sum('totalamount'),
            'ispaid' => $this->ispaid ? 'Төлөгдсөн' : 'Төлөгдөөгүй',
            'ebarimt' => $this->ebarimt(),
            'regnumber' => $this->regnumber,
            'details' => OrderDetailResource::collection($this->details),
            'pickupbranch' => $this->branch?->name ?? null,
        ];
    }

    public function type()
    {
        if($this->type === 'delivery') return 'Хүргэлтээр';
        elseif($this->type === 'pickup') return 'Очиж авах';
    }

    public function ebarimt()
    {
        if($this->ebarimt === 'personal') return 'Хувь хүн';
        elseif($this->ebarimt === 'corporate') return 'Байгууллага';
    }
}
