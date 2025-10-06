<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Authserver\Branch;
use App\Models\Authserver\Organization;
use App\Models\Order\IchiOrder;
use App\Models\User\IchiOnesellerClosure;
use App\Models\User\IchiOnesellerDevice;
use App\Models\User\IchiOnesellerPoint;
use App\Models\User\IchiOnesellerRank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'garage_warehouse.ichi_onesellers';
    
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    public function orders()
    {
        return $this->hasMany(IchiOrder::class, 'oneseller_id', 'id');
    }

    // Бүх дээд эцгүүд
    public function ancestors()
    {
        return $this->hasManyThrough(User::class, IchiOnesellerClosure::class, 'descendant_id', 'id', 'id', 'ancestor_id')->where('ichi_oneseller_closures.depth', '>', 0);
    }

    // Шууд parent
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }

    // Шууд хүүхдүүд
    public function children()
    {
        return $this->hasManyThrough(User::class, IchiOnesellerClosure::class, 'ancestor_id', 'id', 'id', 'descendant_id')->where('ichi_oneseller_closures.depth', 1);
    }

    // Бүх удам
    public function descendants()
    {
        return $this->hasManyThrough(User::class, IchiOnesellerClosure::class, 'ancestor_id', 'id', 'id', 'descendant_id')->where('ichi_oneseller_closures.depth', '>', 0);
    }

    public function rank()
    {
        return $this->belongsTo(IchiOnesellerRank::class, 'ichi_onseller_rank_id', 'id');
    }

    public function points()
    {
        return $this->hasMany(IchiOnesellerPoint::class, 'oneseller_id', 'id');
    }

    public function device()
    {
        return $this->hasOne(IchiOnesellerDevice::class, 'oneseller_id', 'id');
    }

    public function organization()
    {
        return $this->setConnection('authdb')->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function branch()
    {
        return $this->setConnection('authdb')->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    
}
