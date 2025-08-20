<?php

namespace App\Models\Warehouse\Part;

use App\Models\Authserver\Branch;
use App\Models\Authserver\Organization;
use App\Models\Order\IchiOrderDetail;
use Illuminate\Database\Eloquent\Model;

class WhInventoryBranch extends Model
{
    public function inventory()
    {
        return $this->belongsTo(WhInventory::class, 'wh_inventory_id', 'id');
    }

    public function branch()
    {
        return $this->setConnection('authdb')->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function part()
    {
        return $this->belongsTo(WhPart::class, 'articleid', 'articleid');
    }

    public function orderpart()
    {
        return $this->belongsTo(IchiOrderDetail::class, 'id', 'wh_inventory_branch_id');
    }

    public function organization()
    {
        return $this->setConnection('authdb')->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
