<?php

namespace App\Models\Warehouse\Car;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Carbrand extends Model
{
    public function carmodel()
    {
        return $this->hasMany(Carmodel::class, 'manuid', 'manuid');
    }

    public function carengines()
    {
        return $this->hasMany(Carengine::class, 'manuid', 'manuid');
    }

    public static function activeCarbrands()
    {
        $carbrands = Redis::get('carbrands');
        if(isset($carbrands)) {
            return json_decode($carbrands);
        } else {
            $carbrands = Carbrand::where('status', 1)->select('manuid', 'manuname', 'imgurl')->orderBy('sort', 'DESC')->get();
            Redis::set('carbrands', json_encode($carbrands));
            return $carbrands;
        }
    }
}
