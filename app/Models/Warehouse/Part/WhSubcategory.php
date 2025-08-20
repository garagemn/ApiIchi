<?php

namespace App\Models\Warehouse\Part;

use Illuminate\Database\Eloquent\Model;

class WhSubcategory extends Model
{
    public function parent()
    {
        return $this->belongsTo(WhCategory::class, 'parentid', 'categorygroupid');
    }

    public function parts()
    {
        return $this->hasMany(WhPart::class, 'categorygroupid', 'categorygroupid');
    }
}
