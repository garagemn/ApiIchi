<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class IchiOnesellerDevice extends Model
{
    public function oneseller()
    {
        return $this->belongsTo(User::class, 'oneseller_id', 'id');
    }
}
