<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\FactureConsultation
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property int $numero
 * @property string $motif
 * @property string $montant
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $avance
 * @property int|null $reste
 * @property string|null $assurance
 * @property int|null $assurancec
 * @property int|null $assurec
 * @property string|null $demarcheur
 * @property string|null $prenom
 * @property string|null $date_insertion
 * @property-read \App\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereAssurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereAssurancec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereAssurec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereAvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereDateInsertion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereDemarcheur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereReste($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureConsultation whereUserId($value)
 * @mixin \Eloquent
 */
class FactureConsultation extends Model
{   

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = [];


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function historiques()
    {
        return $this->hasMany(HistoriqueFacture::class);
    }

    public static function calculReste($assurec, $avance){
        return $assurec - $avance;
    }

    public static function calculAssurec( $montant, $prise_en_charge){
        // $prise_en_charge est le taux de prise en charge des soins par l'assurance
        return  ((float)$montant * ((100-(float)$prise_en_charge) / 100)); // assurec => part patient
    }

    public static function calculAssurancec($montant, $prise_en_charge){
        // $prise_en_charge est le taux de prise en charge des soins par l'assurance
        return ((float)$montant * (((float)$prise_en_charge) / 100));// assurancec => part assurance}
    }
}
