<?php

namespace App\Models\Authserver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Location extends Model
{
    protected $connection = 'authdb';
    protected $table = 'garage_sso.locations';

    public function scopeParentLocation()
    {
        $parentlocation = Redis::get('parentlocation');
        if(isset($parentlocation)) {
            return json_decode($parentlocation);
        } else {
            $parentlocation = Location::where('status', 'active')->whereNull('parent_id')->select('id', 'name', 'sort')->orderBy('sort', 'ASC')->get();
            Redis::set('parentlocation', json_encode($parentlocation));
            return $parentlocation;
        }
    }
}
