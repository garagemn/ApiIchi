<?php

namespace App\Models\Authserver;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $connection = 'authdb';
    protected $table = 'garage_sso.branches';
    
    public function organization()
    {
        return $this->setConnection('authdb')->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
