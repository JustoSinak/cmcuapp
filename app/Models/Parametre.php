<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Parametre
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property float $poids
 * @property float $taille
 * @property string $bras_gauche
 * @property string $bras_droit
 * @property string $inc_bmi
 * @property string $date_naissance
 * @property int $age
 * @property string $temperature
 * @property string|null $fr
 * @property string|null $fc
 * @property string|null $spo2
 * @property string|null $glycemie
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereBrasDroit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereBrasGauche($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereDateNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereFc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereGlycemie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereIncBmi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre wherePoids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereSpo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereTaille($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parametre whereUserId($value)
 * @mixin \Eloquent
 */
class Parametre extends Model
{
    protected $fillable = [
        'user_id', 'patient_id', 'poids', 'temperature', 'fc', 'fr', 'spo2', 'glycemie', 'bras_gauche', 'bras_droit', 'date_naissance', 'age', 'inc_bmi', 'taille'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
