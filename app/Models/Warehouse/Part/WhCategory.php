<?php

namespace App\Models\Warehouse\Part;

use Illuminate\Database\Eloquent\Model;

class WhCategory extends Model
{
    public function parts()
    {
        return $this->hasMany(WhPart::class, 'categorygroupid', 'categorygroupid');
    }

    public function parent()
    {
        return $this->belongsTo(WhCategory::class, 'parentid', 'categorygroupid');
    }

    public function subcategories()
    {
        return $this->hasMany(WhSubcategory::class, 'parentid', 'categorygroupid');
    }
  
}
