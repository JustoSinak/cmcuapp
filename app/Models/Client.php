<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Client
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $nom
 * @property string|null $prenom
 * @property string|null $motif
 * @property int|null $montant
 * @property int|null $avance
 * @property int|null $reste
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\FactureClient[] $facture_client
 * @property-read int|null $facture_client_count
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereAvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereReste($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereUserId($value)
 * @mixin \Eloquent
 */
class Client extends Model
{
    protected $fillable = [
       
       
        'user_id',
        'nom',
        'prenom',
        'motif',
        'montant',
        'avance',
        'reste',
        'partassurance',
        'partpatient',
        'assurance',
        'numero_assurance',
        'prise_en_charge',
        'demarcheur',
        'medecin_r',
        'date_insertion',

    ] ;

   

    public function facture_clients()
    {
        return $this->hasMany(FactureClient::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }


}
