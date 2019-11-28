<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TraitementHospitalisation
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $medicament_posologie_dosage
 * @property int|null $duree
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereDuree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereJ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereJ0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereJ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereJ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereM1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereMedicamentPosologieDosage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereMi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereMi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereN1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TraitementHospitalisation whereUserId($value)
 * @mixin \Eloquent
 */
class TraitementHospitalisation extends Model
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
