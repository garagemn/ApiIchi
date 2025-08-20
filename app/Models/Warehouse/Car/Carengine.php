<?php

namespace App\Models\Warehouse\Car;

use App\Models\Warehouse\Part\WhPartlinkedcar;
use Illuminate\Database\Eloquent\Model;

class Carengine extends Model
{
    public function carbrand()
    {
        return $this->belongsTo(Carbrand::class, 'manuid', 'manuid');
    }

    public function carmodel()
    {
        return $this->belongsTo(Carmodel::class, 'modelid', 'modelid');
    }

    public function carinfo()
    {
        return $this->hasOne(Carinfo::class, 'carid', 'carid');
    }

    public function carimage()
    {
        return $this->hasOne(Carimage::class, 'carid', 'carid');
    }

    public function linkedcars()
    {
        return $this->hasMany(WhPartlinkedcar::class, 'carid', 'carid');
    }
}
