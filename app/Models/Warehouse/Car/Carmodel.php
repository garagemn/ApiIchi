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

    public static function getActiveModel($manuid)
    {
        return Carmodel::whereNull('groupid')->where('manuid', $manuid)->with(['children' => function($sql) {
            $sql->where('status', 1);
        }])->with(['carbrand' => function ($sql) {
            $sql->select('manuid', 'imgurl');
        }])->orderBy('yearstart','ASC')->orderBy('modelname','ASC')->get();
    }
}
