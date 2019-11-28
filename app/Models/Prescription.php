<?php

namespace App;

use Illuminate\Database\eloquent\model;

/**
 * App\Prescription
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $patient_id
 * @property string|null $hematologie
 * @property string|null $hemostase
 * @property string|null $biochimie
 * @property string|null $hormonologie
 * @property string|null $marqueurs
 * @property string|null $bacteriologie
 * @property string|null $spermiologie
 * @property string|null $urines
 * @property string|null $serologie
 * @property string|null $examen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Patient|null $patient
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereBacteriologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereBiochimie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereExamen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereHematologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereHemostase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereHormonologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereMarqueurs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereSerologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereSpermiologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereUrines($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prescription whereUserId($value)
 * @mixin \Eloquent
 */
class Prescription extends model
{
    protected $fillable = [
        'patient_id',
        'user_id',
        'hematologie' ,
        'hemostase',
        'biochimie',
        'hormonologie',
        'marqueurs',
        'bacteriologie',
        'spermiologie',
        'urines',
        'serologie',
        'examen',
       
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
