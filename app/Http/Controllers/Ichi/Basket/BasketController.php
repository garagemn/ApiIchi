<?php

namespace App\Http\Controllers\Ichi\Basket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ichi\Basket\AddBasketRequest;
use App\Models\Warehouse\Part\WhInventoryBranch;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        
    }

    public function add(AddBasketRequest $request)
    {
        $hasBranchPart = WhInventoryBranch::with(['inventory' => function ($sql) {
            $sql->select('id', 'organization_id');
        }])->findOrFail($request->get('partid'));
        if(!$hasBranchPart->inventory->organization_id != auth()->user()->organization_id) return $this->sendError('Уучлаарай. Энэ сэлбэгийг сагслах боломжгүй', '', 200);
        if($hasBranchPart->branch_id != auth()->user()->branch_id) return $this->sendError('Уучлаарай. Өөр салбарын сэлбэгийг сагслах боломжгүй', '', 200);
        if($hasBranchPart->quantity < $request->get('quantity')) return $this->sendError('Сэлбэгийн үлдэгдэл хүрэлцэхгүй байна', '', 200);
        return $this->sendResponse([], 'Амжилттай сагсаллаа');
    }
}
