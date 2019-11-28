<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FicheIntervention
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $nom_patient
 * @property string $prenom_patient
 * @property string $sexe_patient
 * @property string $date_naiss_patient
 * @property int $portable_patient
 * @property string $type_intervention
 * @property string $dure_intervention
 * @property string $position_patient
 * @property string|null $decubitus
 * @property string|null $laterale
 * @property string|null $lombotomie
 * @property string $date_intervention
 * @property string $medecin
 * @property string $aide_op
 * @property string|null $hospitalisation
 * @property string|null $ambulatoire
 * @property string $anesthesie
 * @property string|null $recommendation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Patient $patient
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereAideOp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereAmbulatoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereAnesthesie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereDateIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereDateNaissPatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereDecubitus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereDureIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereHospitalisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereLaterale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereLombotomie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereMedecin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereNomPatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention wherePortablePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention wherePositionPatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention wherePrenomPatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereRecommendation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereSexePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereTypeIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FicheIntervention whereUserId($value)
 * @mixin \Eloquent
 */
class FicheIntervention extends Model
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
}
