<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Ordonance
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $description
 * @property string $medicament
 * @property string $quantite
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Patient $patient
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordonance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordonance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordonance query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordonance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordonance whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordonance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordonance whereMedicament($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordonance wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordonance whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordonance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordonance whereUserId($value)
 * @mixin \Eloquent
 */
class Ordonance extends Model
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
