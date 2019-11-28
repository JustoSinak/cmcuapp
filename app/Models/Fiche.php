<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Fiche
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $chambre_numero
 * @property int $age
 * @property string $service
 * @property string $infirmier_charge
 * @property string $accueil
 * @property string $restauration
 * @property string $chambre
 * @property string $soins
 * @property int $notes
 * @property string $quizz
 * @property string $remarque_suggestion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \App\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereAccueil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereChambre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereChambreNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereInfirmierCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereQuizz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereRemarqueSuggestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereRestauration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereSoins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Fiche whereUserId($value)
 * @mixin \Eloquent
 */
class Fiche extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'chambre_numero',
        'age',
        'service',
        'infirmier_charge',
        'accueil',
        'restauration',
        'chambre',
        'soins',
        'notes',
        'quizz',
        'remarque_suggestion'
    ];

    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
