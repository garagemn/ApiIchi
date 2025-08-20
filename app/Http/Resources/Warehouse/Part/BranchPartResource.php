<?php

namespace App\Http\Resources\Warehouse\Part;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchPartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'partid' => $this->id,
            'articleno' => $this->part?->articleno ?? null,
            'category' => $this->part?->category?->name ?? $this->part?->category?->categoryname,
            'brandname' => $this->part?->brandname,
            'quantity' => $this->quantity ? 'Үлдэгдэлтэй' : 'Дууссан',
            'wholeprice' => $this->wholesaleprice,
            'price' => $this->storeprice,
            'salepercent' => $this->when($this->issale, function () {
                if($this->sale_startdate <= date('Y-m-d') && $this->sale_enddate >= date('Y-m-d')) {
                    return $this->percentsale;
                }
            }),
            'saleprice' => $this->when($this->issale, function () {
                if($this->sale_startdate <= date('Y-m-d') && $this->sale_enddate >= date('Y-m-d')) {
                    return $this->storepricesale;
                }
            }),
            'point' => $this->point
        ];
    }

    public function saleprice()
    {

    }
}
