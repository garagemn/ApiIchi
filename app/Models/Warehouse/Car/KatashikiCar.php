<?php

namespace App\Models\Warehouse\Car;

use Illuminate\Database\Eloquent\Model;

class KatashikiCar extends Model
{
    protected $table = 'garage_warehouse.katashiki_car';
    
    public function katashikivins()
    {
        return $this->hasMany(VinKatashiki::class, 'katashiki', 'katashiki');
    }

    public function carengine()
    {
        return $this->belongsTo(Carengine::class, 'carid', 'carid');
    }
}
