<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrescriptionMedicale extends Model
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
    public function adminPrescriptionMedicales()
    {
        return $this->hasMany(AdminPrescriptionMedicale::class);
    }
}
