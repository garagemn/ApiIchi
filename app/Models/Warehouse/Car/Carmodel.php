<?php

namespace App\Models\Warehouse\Car;

use Illuminate\Database\Eloquent\Model;

class Carmodel extends Model
{
    public function parent()
    {
        return $this->belongsTo(Carmodel::class, 'groupid');
    }
    
    public function children()
    {
        return $this->hasMany(Carmodel::class, 'groupid', 'id');
    }

    public function carbrand()
    {
        return $this->belongsTo(Carbrand::class, 'manuid', 'manuid');
    }

    public function carengines()
    {
        return $this->hasMany(Carengine::class, 'modelid', 'modelid');
    }
}
