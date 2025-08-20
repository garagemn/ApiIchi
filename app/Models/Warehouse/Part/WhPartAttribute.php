<?php

namespace App\Models\Warehouse\Part;

use App\Models\Warehouse\Part\Attribute\WhAttribute;
use App\Models\Warehouse\Part\Attribute\WhAttributeOption;
use Illuminate\Database\Eloquent\Model;

class WhPartAttribute extends Model
{
    use \Awobaz\Compoships\Compoships;

    public function attrname()
    {
        return $this->belongsTo(WhAttribute::class, 'attrid', 'attrid');
    }

    public function attrvalue()
    {
        return $this->belongsTo(WhAttributeOption::class, ['attrvalueid', 'articleid'], ['attrvalueid', 'articleid']);
    }

    public function part()
    {
        return $this->belongsTo(WhPart::class, 'articleid', 'articleid');
    }

    

}
