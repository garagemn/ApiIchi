<?php

namespace App\Models\Warehouse\Part;

use App\Models\Warehouse\Car\Carbrand;
use App\Models\Warehouse\Car\Carengine;
use App\Models\Warehouse\Car\Carmodel;
use Illuminate\Database\Eloquent\Model;

class WhPartlinkedcar extends Model
{
    public function part()
    {
        return $this->belongsTo(WhPart::class, 'articleid', 'articleid');
    }

    public function carengine()
    {
        return $this->belongsTo(Carengine::class, 'carid', 'carid');
    }

    public function carbrand()
    {
        return $this->belongsTo(Carbrand::class, 'manuid', 'manuid');
    }

    public function carmodel()
    {
        return $this->belongsTo(Carmodel::class, 'modelid', 'modelid');
    }
}
