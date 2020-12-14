<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Dossier
 *
 * @property int $id
 * @property int $patient_id
 * @property string $sexe
 * @property string|null $personne_confiance
 * @property int|null $tel_personne_confiance
 * @property int|null $portable_1
 * @property int|null $portable_2
 * @property string|null $personne_contact
 * @property int|null $tel_personne_contact
 * @property string|null $profession
 * @property string|null $email
 * @property string|null $fax
 * @property string|null $adresse
 * @property string|null $lieu_naissance
 * @property string|null $date_naissance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Patient $patients
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier whereDateNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier whereLieuNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier wherePersonneConfiance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier wherePersonneContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier wherePortable1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier wherePortable2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier whereTelPersonneConfiance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier whereTelPersonneContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dossier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dossier extends Model
{
    protected $fillable = [
        'patient_id',
        'sexe',
        'personne_confiaance',
        'tel_personne_confiance',
        'portables_1',
        'portable_2',
        'personne_contact',
        'tel_personne_contact',
        'profession',
        'email',
        'fax',
        'adresse',
        'lieu_naissance',
        'date_naissance'
    ];

    public function patients()
    {
        return $this->belongsTo('App\Patient', 'patient_id');
    }
}
