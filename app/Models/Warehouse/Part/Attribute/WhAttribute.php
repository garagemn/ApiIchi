<?php

namespace App\Models\Warehouse\Part\Attribute;

use App\Models\Warehouse\Part\WhPartAttribute;
use Illuminate\Database\Eloquent\Model;

class WhAttribute extends Model
{
    public function options()
    {
        return $this->hasMany(WhAttributeOption::class, 'attrid', 'attrid');
    }   

    public function partattributes()
    {
        return $this->hasMany(WhPartAttribute::class, 'attrid', 'attrid');
    }
}
