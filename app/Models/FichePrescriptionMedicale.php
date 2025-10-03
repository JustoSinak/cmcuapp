<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Patient;
//use App\PrescriptionMedicale;

class FichePrescriptionMedicale extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function prescription_medicales()
    {
        return $this->hasMany(PrescriptionMedicale::class);
    }
}
