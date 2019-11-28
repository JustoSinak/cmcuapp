<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Facture
 *
 * @property int $id
 * @property string|null $patient
 * @property int $user_id
 * @property int $numero
 * @property int $quantite_total
 * @property int $prix_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Produit[] $produits
 * @property-read int|null $produits_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Facture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Facture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Facture query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Facture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Facture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Facture whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Facture wherePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Facture wherePrixTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Facture whereQuantiteTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Facture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Facture whereUserId($value)
 * @mixin \Eloquent
 */
class Facture extends Model
{
    protected $guarded = ['id'];

    protected $fillable = ['numero', 'prix_total', 'quantite_total', 'patient', 'user_id'];

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'facture_produit', 'facture_id','produit_id')
            ->withPivot('item', 'prix_total')
            ->withTimestamps();
    }

}
