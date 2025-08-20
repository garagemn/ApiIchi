<?php

namespace App\Models\Warehouse\Car;

use Illuminate\Database\Eloquent\Model;

class Carimage extends Model
{
    public function carengine()
    {
        return $this->belongsTo(Carengine::class, 'carid', 'carid');
    }
}
