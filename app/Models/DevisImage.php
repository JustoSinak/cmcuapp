<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DevisImage
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int|null $user_id
 * @property string $devis_p
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Patient|null $patient
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DevisImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DevisImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DevisImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DevisImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DevisImage whereDevisP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DevisImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DevisImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DevisImage wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DevisImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DevisImage whereUserId($value)
 * @mixin \Eloquent
 */
class DevisImage extends Model
{
    protected $fillable = [
        
        'patient_id',
        'user_id',
        'devis_p',
        
        
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
