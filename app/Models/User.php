<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\User\IchiOnesellerDevice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    use NodeTrait;

    protected $table = 'garage_warehouse.ichi_onesellers';

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(User::class, 'parent_id', 'id');
    }

    public function ancestors()
    {
        return $this->belongsToMany(User::class, 'ichi_oneseller_closures', 'descendant_id', 'ancestor_id')->withPivot('depth');
    }

    public function descendants()
    {
        return $this->belongsToMany(User::class, 'ichi_oneseller_closures', 'ancestor_id', 'descendant_id')->withPivot('depth');    
    }

    public function device()
    {
        return $this->hasOne(IchiOnesellerDevice::class, 'oneseller_id', 'id');
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
