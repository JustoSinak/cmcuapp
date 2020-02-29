<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devi extends Model
{
    protected $guarded = [];
    
    public function modifiePar()
    {
        return $this->belongsTo(User::class);
    }


    public function ligneDevis()
    {
        return $this->hasMany(LigneDevi::class);
    }
}
