<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    
    protected $fillable = [

    //orchidectomie bilaterale
            
            'patient_id',
            'user_id',
            'nom',
            'qte1',
            'qte2',
            'qte3',
            'qte4',
            'qte5',
            'qte6',
            'qte7',
            'qte8',
            'qte9',
            'qte10',
            'qte11',
            'prix_u',
            'prix_u1',
            'prix_u2',
            'prix_u3',
            'prix_u4',
            'prix_u5',
            'prix_u6',
            'prix_u7',
            'prix_u8',
            'prix_u9',
            'prix_u10',
            'prix_u11',
            'montant',
            'montant1',
            'montant2',
            'montant3',
            'montant4',
            'montant5',
            'montant6',
            'montant7',
            'montant8',
            'montant9',
            'montant10',
            'montant11',
            'elements',
            'elements1',
            'elements2',
            'elements3',
            'elements4',
            'elements5',
            'elements6',
            'elements7',
            'elements8',
            'elements9',
            'elements10',
            'arreter',
            'total1',
            'total2',
            'total3',



    ] ;





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
}
