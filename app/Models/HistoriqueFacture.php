<?php

namespace App;

use App\FactureConsultation;
use Illuminate\Database\Eloquent\Model;

class HistoriqueFacture extends Model
{
    protected $guarded = [];

    public function facture()
    {
        return $this->belongsTo(FactureConsultation::class);
    }

    
}
