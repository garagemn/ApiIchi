<?php

namespace App\Models\Warehouse\Part;

use Illuminate\Database\Eloquent\Model;

class WhPartoemnumber extends Model
{
    public function part()
    {
        return $this->belongsTo(WhPart::class, 'articleid', 'articleid');
    }
}
