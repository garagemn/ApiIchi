<?php

namespace App\Models\Order;

use App\Models\Warehouse\Part\WhInventoryBranch;
use Illuminate\Database\Eloquent\Model;

class IchiOrderDetail extends Model
{
    public function order()
    {
        return $this->belongsTo(IchiOrder::class, 'ichi_order_id', 'id');
    }

    public function branchpart()
    {
        return $this->belongsTo(WhInventoryBranch::class, 'wh_inventory_branch_id', 'id');
    }
}
