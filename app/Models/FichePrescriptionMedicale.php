<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\Patient;
//use App\PrescriptionMedicale;

class FichePrescriptionMedicale extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function prescription_medicales()
    {
        return $this->hasMany(PrescriptionMedicale::class);
    }
}
