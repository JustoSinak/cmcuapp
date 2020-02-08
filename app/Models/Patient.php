<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Patient extends Model
{
    protected $fillable = [
        'numero_dossier',
        'mode_paiement',
        'assurance',
        'assurancec',
        'assurec',
        'numero_assurance',
        'prise_en_charge',
        'user_id',
        'telephone',
        'motif',
        'details_motif',
        'montant',
        'avance',
        'reste',
        'reste1',
        'prenom',
        'demarcheur',
        'date_insertion',
        'medecin_r',
        'image',

    ] ;

    public function devisimage()
    {
        return $this->hasMany(DevisImage::class);
    }
    public function facture_consultations()
    {
        return $this->hasMany(FactureConsultation::class);
    }

    public function facture_chambres()
    {
        return $this->hasMany(FactureConsultation::class);
    }

    public function devis()
    {
        return $this->hasMany(Devis::class);
    }
    public function devisd()
    {
        return $this->hasMany(Devisd::class, 'patient_id');
    }

    public function soins()
    {
        return $this->hasMany(Soin::class);
    }

    public function examens()
    {
        return $this->hasMany(Examen::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function consultation_anesthesistes()
    {
        return $this->hasMany(ConsultationAnesthesiste::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function imageries()
    {
        return $this->hasMany(Imagerie::class);
    }

    public function compte_rendu_bloc_operatoires()
    {
        return $this->hasMany(CompteRenduBlocOperatoire::class);
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }

    public function ordonances()
    {
        return $this->hasMany(Ordonance::class);
    }

    public function fiche_interventions()
    {
        return $this->hasMany(FicheIntervention::class);
    }

    public function facture_devis()
    {
        return $this->hasMany(FactureDevi::class);
    }

    public function fiche_prescription_medicale()
    {
        return $this->hasOne(FichePrescriptionMedicale::class);
    }

    public function visite_preanesthesiques()
    {
        return $this->hasMany(VisitePreanesthesique::class);
    }

    public function premedications()
    {
        return $this->hasMany(Premedication::class);
    }

    public function traitement_hospitalisations()
    {
        return $this->hasMany(TraitementHospitalisation::class);
    }
    public function adaptation_traitements()
    {
        return $this->hasMany(AdaptationTraitement::class);
    }

    public function parametres()
    {
        return $this->hasMany(Parametre::class);
    }

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }

    public function fiche_consommables()
    {
        return $this->hasMany(FicheConsommable::class);
    }

    public function observation_medicales()
    {
        return $this->hasMany(ObservationMedicale::class);
    }

    public function soins_infirmiers()
    {
        return $this->hasMany(SoinsInfirmier::class);
    }

    public function surveillance_post_anesthesiques()
    {
        return $this->hasMany(SurveillancePostAnesthesique::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function consultationdesuivi()
    {
        return $this->hasMany(ConsultationSuivi::class);
    }

    public function event()
    {
        return $this->hasMany(Event::class);
    }

    public function surveillance_rapproche_parametres()
    {
        return $this->hasMany(SurveillanceRapprocheParametre::class);
    }

    public function surveillance_scores()
    {
        return $this->hasMany(SurveillanceScore::class);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans;
    }
    public function isMedecin()
    {
        return Auth::user()->role_id === 2;

    }


}
