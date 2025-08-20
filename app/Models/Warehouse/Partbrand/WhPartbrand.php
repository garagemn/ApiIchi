<?php

namespace App\Models\Warehouse\Partbrand;

use App\Models\Warehouse\Part\WhPart;
use Illuminate\Database\Eloquent\Model;

class WhPartbrand extends Model
{
    public function logo()
    {
        return $this->hasOne(WhPartbrandlogo::class, 'datasupplierid', 'datasupplierid');
    }

    public function parts()
    {
        return $this->hasMany(WhPart::class, 'brandno', 'datasupplierid');
    }
}
