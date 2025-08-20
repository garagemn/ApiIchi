<?php

namespace App\Models\Authserver;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $connection = 'authdb';
    protected $table = 'garage_sso.locations';
}
