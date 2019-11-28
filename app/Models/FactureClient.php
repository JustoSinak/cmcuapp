<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FactureClient
 *
 * @property int $id
 * @property int $user_id
 * @property int $client_id
 * @property string $nom
 * @property string|null $prenom
 * @property string $montant
 * @property string|null $avance
 * @property string|null $reste
 * @property string|null $motif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Client $client
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient whereAvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient whereReste($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FactureClient whereUserId($value)
 * @mixin \Eloquent
 */
class FactureClient extends Model
{
    protected $guarded = [];
  
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
}
