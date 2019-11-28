<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Consultation
 *
 * @property int $id
 * @property int $patient_id
 * @property int $user_id
 * @property string $diagnostic
 * @property string $interrogatoire
 * @property string|null $antecedent_m
 * @property string|null $antecedent_c
 * @property string $medecin_r
 * @property string|null $allergie
 * @property string|null $groupe
 * @property string $proposition_therapeutique
 * @property string $proposition
 * @property string|null $examen_p
 * @property string|null $examen_c
 * @property string|null $motif_c
 * @property string|null $date_intervention
 * @property string|null $date_consultation
 * @property string|null $date_consultation_anesthesiste
 * @property string|null $acte
 * @property string|null $devis_p
 * @property string|null $type_intervention
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Chambre $chambres
 * @property-read \App\Devis $devis
 * @property-read \App\Patient $patient
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereActe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereAllergie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereAntecedentC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereAntecedentM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereDateConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereDateConsultationAnesthesiste($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereDateIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereDevisP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereDiagnostic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereExamenC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereExamenP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereGroupe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereInterrogatoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereMedecinR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereMotifC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereProposition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation wherePropositionTherapeutique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereTypeIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultation whereUserId($value)
 * @mixin \Eloquent
 */
class Consultation extends Model
{

	protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function chambres()
    {
        return $this->belongsTo(Chambre::class);
    }

    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }


}
