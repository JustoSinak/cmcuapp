<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AdaptationTraitement
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $medicament_posologie_dosage
 * @property string|null $arret
 * @property string|null $poursuivre
 * @property string|null $continuer
 * @property string|null $j
 * @property string|null $j0
 * @property string|null $j1
 * @property string|null $j2
 * @property string|null $m
 * @property string|null $mi
 * @property string|null $n
 * @property string|null $s
 * @property string|null $m1
 * @property string|null $mi1
 * @property string|null $s1
 * @property string|null $n1
 * @property string $date
 * @property-read \App\Patient $patient
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereArret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereContinuer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereJ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereJ0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereJ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereJ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereM1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereMedicamentPosologieDosage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereMi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereMi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereN1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement wherePoursuivre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdaptationTraitement whereUserId($value)
 * @mixin \Eloquent
 */
class AdaptationTraitement extends Model
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
}
