<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultationSuivi extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'patient_id',
        'user_id',
        'interrogatoire',
        'commentaire',
        'date',
        
    ] ;

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
