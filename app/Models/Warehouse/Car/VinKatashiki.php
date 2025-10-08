<?php

namespace App\Models\Warehouse\Car;

use Illuminate\Database\Eloquent\Model;

class VinKatashiki extends Model
{
    protected $table = 'garage_warehouse.vin_katashiki';

    public function katashikicar()
    {
        return $this->hasOne(KatashikiCar::class, 'katashiki', 'katashiki');
    }
}
