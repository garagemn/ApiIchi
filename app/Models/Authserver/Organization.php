<?php

namespace App\Models\Authserver;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $connection = 'authdb';
    protected $table = 'garage_sso.organizations';

    public function branches()
    {
        return $this->setConnection('authdb')->hasMany(Branch::class, 'organization_id', 'id');
    }
}
