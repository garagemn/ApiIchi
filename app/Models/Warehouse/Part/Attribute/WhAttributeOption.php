<?php

namespace App\Models\Warehouse\Part\Attribute;

use App\Models\Warehouse\Part\WhPartAttribute;
use Illuminate\Database\Eloquent\Model;

class WhAttributeOption extends Model
{
    use \Awobaz\Compoships\Compoships;

    public function attribute()
    {
        return $this->belongsTo(WhAttribute::class, 'attrid', 'attrid');
    }

    public function partattributes()
    {
        return $this->hasMany(WhPartAttribute::class, ['attrvalueid', 'articleid'], ['attrvalueid', 'articleid']);
    }
}
