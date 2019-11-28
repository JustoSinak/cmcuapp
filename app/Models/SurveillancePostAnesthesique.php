<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveillancePostAnesthesique extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
