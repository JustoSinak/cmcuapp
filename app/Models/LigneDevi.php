<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LigneDevi extends Model
{
    protected $guarded = [];

    public function devi()
    {
        return $this->belongsTo(Devi::class);
    }
}
