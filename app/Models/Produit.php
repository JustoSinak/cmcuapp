<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Produit
 *
 * @property int $id
 * @property string $designation
 * @property string $categorie
 * @property int $qte_stock
 * @property int $qte_alerte
 * @property int $prix_unitaire
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Facture[] $factures
 * @property-read int|null $factures_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Produit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Produit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Produit query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Produit whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Produit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Produit whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Produit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Produit wherePrixUnitaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Produit whereQteAlerte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Produit whereQteStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Produit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Produit whereUserId($value)
 * @mixin \Eloquent
 */
class Produit extends Model
{

    protected $fillable = [
        'designation',
        'categorie',
        'qte_stock',
        'qte_alerte',
        'prix_unitaire'

    ] ;


    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function factures()
    {
        return $this->belongsToMany(Facture::class)
            ->withPivot('item', 'prix_total')
            ->withTimestamps();
    }

    public function fiche_consommables()
    {
        return $this->hasMany(FicheConsommable::class);
    }
}


