<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Premedication
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $consigne_ide
 * @property string $preparation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Patient $patient
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Premedication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Premedication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Premedication query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Premedication whereConsigneIde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Premedication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Premedication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Premedication wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Premedication wherePreparation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Premedication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Premedication whereUserId($value)
 * @mixin \Eloquent
 */
class Premedication extends Model
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
