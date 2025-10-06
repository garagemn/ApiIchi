<?php

namespace App\Models\Warehouse\Part;

use App\Models\Warehouse\Partbrand\WhPartbrand;
use Illuminate\Database\Eloquent\Model;

class WhPart extends Model
{
    public function category()
    {
        return $this->belongsTo(WhCategory::class, 'categorygroupid', 'categorygroupid');
    }

    public function attributes()
    {
        return $this->hasMany(WhPartAttribute::class, 'articleid', 'articleid');
    }

    public function isfilterattributes()
    {
        return $this->hasMany(WhPartAttribute::class, 'articleid', 'articleid')->where(function($sql) {
            $sql->whereHas('attrname', function($query) {
                $query->where('isfilter', 'active')->where('status', 'active');
            });
        });
    }

    public function linkedcars()
    {
        return $this->hasMany(WhPartlinkedcar::class, 'articleid', 'articleid');
    }

    public function oemnumbers()
    {
        return $this->hasMany(WhPartoemnumber::class, 'articleid', 'articleid');
    }

    public function images()
    {
        return $this->hasMany(WhPartimage::class, 'articleid', 'articleid');
    }

    public function notframes()
    {
        return $this->hasMany(WhPartImage::class, 'articleid', 'articleid')->whereNull('frame')->whereNull('frametotal');
    }

    public function partbrand()
    {
        return $this->belongsTo(WhPartbrand::class, 'brandno', 'datasupplierid');
    }

    public function inventories()
    {
        return $this->hasMany(WhInventory::class, 'articleid', 'articleid');
    }

    public function branchparts()
    {
        return $this->hasMany(WhInventoryBranch::class, 'articleid', 'articleid');
    }

    public function generic()
    {
        // return $this->belongsTo(WhPartgenericarticle::class, 'genericarticleid', 'genericarticleid');
    }
}
