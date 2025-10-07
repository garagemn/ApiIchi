<?php

namespace App\Http\Resources\Oneseller;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeekSaleAmountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'weeksaleamount' => $this->weeksaleamount
        ];
    }
}
