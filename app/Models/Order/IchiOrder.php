<?php

namespace App\Models\Order;

use App\Models\Authserver\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class IchiOrder extends Model
{
    public function details()
    {
        return $this->hasMany(IchiOrderDetail::class, 'ichi_order_id', 'id');
    }

    public function city()
    {
        
    }

    public function district()
    {

    }

    public function team()
    {

    }

    public function oneseller()
    {
        return $this->belongsTo(User::class, 'oneseller_id', 'id');
    }

    public function branch()
    {
        return $this->setConnection('authdb')->belongsTo(Branch::class, 'branch_id', 'id');
    }
    
}
