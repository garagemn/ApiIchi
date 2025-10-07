<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class IchiOnesellerNotification extends Model
{
    public function oneseller()
    {
        return $this->belongsTo(User::class, 'oneseller_id', 'id');
    }
}
