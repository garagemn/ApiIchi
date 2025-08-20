<?php

namespace App\Models\Warehouse\Part;

use App\Models\Authserver\Organization;
use Illuminate\Database\Eloquent\Model;

class WhInventory extends Model
{
    public function part()
    {
        return $this->belongsTo(WhPart::class, 'articleid', 'articleid');
    }

    public function branchparts()
    {
        return $this->hasMany(WhInventoryBranch::class, 'wh_inventory_id', 'id');
    }

    public function organization()
    {
        return $this->setConnection('authdb')->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
