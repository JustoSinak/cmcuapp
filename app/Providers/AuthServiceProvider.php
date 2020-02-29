<?php

namespace App\Providers;

use App\chambre;
use App\Event;
use App\Fiche;
use App\Patient;
use App\Policies\CaissePolicy;
use App\Policies\ChambrePolicy;
use App\Policies\EventPolicy;
use App\Policies\FactureConsultationPolicy;
use App\Policies\FichePolicy;
use App\Policies\DevisPolicy;
use App\Policies\PatientPolicy;
use App\Policies\ProduitPolicy;
use App\Policies\Stock_pharmaceutiquePolicy;
use App\Policies\UserPolicy;
use App\Produit;
use App\Devi;
use App\FactureConsultation;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Produit::class => ProduitPolicy::class,
        User::class => UserPolicy::class,
        chambre::class => ChambrePolicy::class,
        Event::class => EventPolicy::class,
        Fiche::class => FichePolicy::class,
        Devi::class => DevisPolicy::class,
        Patient::class => PatientPolicy::class,
        FactureConsultation::class => FactureConsultationPolicy::class,


       
    ];


    public function boot()
    {
        $this->registerPolicies();
        //
    }
}
