<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompteRenduHospitalisation extends Model
{

    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
