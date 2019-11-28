<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\VisitePreanesthesique
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $date_visite
 * @property string $element_nouveaux
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Patient $patient
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisitePreanesthesique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisitePreanesthesique newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisitePreanesthesique query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisitePreanesthesique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisitePreanesthesique whereDateVisite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisitePreanesthesique whereElementNouveaux($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisitePreanesthesique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisitePreanesthesique wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisitePreanesthesique whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VisitePreanesthesique whereUserId($value)
 * @mixin \Eloquent
 */
class VisitePreanesthesique extends Model
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
