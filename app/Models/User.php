<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;


class User extends Authenticatable
{
    use Notifiable;
  
    protected $fillable = [
        'name', 'prenom', 'login', 'telephone', 'sexe', 'lieu_naissance', 'date_naissance', 'password', 'specialite', 'onmc'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';


    public function roles()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }

    public function devisimage()
    {
        return $this->hasMany(DevisImage::class);
    }
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function produits()
    {
        return $this->belongsTo('App\Produit');
    }

    public function fiches()
    {
        return $this->hasMany('App\Fiche');
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function fiche_interventions()
    {
        return $this->hasMany(FicheIntervention::class);
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

    public function devis()
    {
        return $this->hasMany(Devis::class);
    }

    public function devisd()
    {
        return $this->hasMany(Devisd::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function consultation_anesthesistes()
    {
        return $this->hasMany(ConsultationAnesthesiste::class);
    }

    public function ordonances()
    {
        return $this->hasMany(Ordonance::class);
    }

    public function compte_rendu_bloc_operatoires()
    {
        return $this->hasMany(CompteRenduBlocOperatoire::class);
    }

    public function fiche_consommables()
    {
        return $this->hasMany(FicheConsommable::class);
    }

    public function observation_medicales()
    {
        return $this->hasMany(ObservationMedicale::class);
    }

    public function surveillance_post_anesthesiques()
    {
        return $this->hasMany(SurveillancePostAnesthesique::class);
    }

    public function surveillance_rapproche_parametres()
    {
        return $this->hasMany(SurveillanceRapprocheParametre::class);
    }

    public function surveillance_scores()
    {
        return $this->hasMany(SurveillanceScore::class);
    }

    public function soins_infirmiers()
    {
        return $this->hasMany(SoinsInfirmier::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function facture_devis()
    {
        return $this->hasMany(FactureDevi::class);
    }

    public function prescription_medicales()
    {
        return $this->hasMany(PrescriptionMedicale::class);
    }


    public function isAdmin()
    {
        return Auth::user()->role_id === 1;

    }
    public function isPharmacien()
    {
        return Auth::user()->role_id === 7;

    }

    public function isGestionnaire()
    {
        return Auth::user()->role_id === 3;

    }

    public function isCaisse()
    {
        return Auth::user()->role_id === 9;

    }

    public function isLogistique()
    {
        return Auth::user()->role_id === 5;

    }

    public function facture_consultations()
    {
        return $this->hasMany(FactureConsultation::class);
    }

    public function facture_clients()
    {
        return $this->hasMany(FactureClient::class);
    }

    public function consultationdesuivi()
    {
        return $this->hasMany(ConsultationSuivi::class);
    }


}
