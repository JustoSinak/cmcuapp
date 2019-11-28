<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\Chambre
 *
 * @property int $id
 * @property int $user_id
 * @property string $numero
 * @property string $categorie
 * @property string|null $patient
 * @property int|null $prix
 * @property int|null $jour
 * @property string $statut
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Consultation $consultations
 * @property-read \App\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chambre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chambre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chambre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chambre whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chambre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chambre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chambre whereJour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chambre whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chambre wherePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chambre wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chambre whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chambre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chambre whereUserId($value)
 * @mixin \Eloquent
 */
class Chambre extends Model
{

    protected $fillable = [

        'numero',
        'categorie',
        'prix',
        'statut',
        'patient',
        'jour'
    ];

    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function consultations()
    {
        return $this->belongsTo(Consultation::class);
    }
}
