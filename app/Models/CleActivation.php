<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CleActivation extends Model
{
    public $timestamps = false;

    public function licence()
    {
        $this->belongsTo(Licence::class);
    }
}
