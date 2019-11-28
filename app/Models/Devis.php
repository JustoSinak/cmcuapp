<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    
    protected $guarded = [];


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultations()
    {
        return $this->hasOne(Consultation::class);
    }

    public function devisd()
    {
        return $this->hasMany(Devisd::class, 'devis_id');
    }

    public function isLogistique()
    {
        return Auth::user()->role_id === 5;

    }
}
