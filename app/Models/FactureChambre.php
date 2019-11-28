<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FactureChambre
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property int $numero
 * @property string $date_entre
 * @property string $date_sortie
 * @property int $jour
 * @property int $tarif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureChambre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureChambre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureChambre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureChambre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureChambre whereDateEntre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureChambre whereDateSortie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureChambre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureChambre whereJour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureChambre whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureChambre wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureChambre whereTarif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureChambre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureChambre whereUserId($value)
 * @mixin \Eloquent
 */
class FactureChambre extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
