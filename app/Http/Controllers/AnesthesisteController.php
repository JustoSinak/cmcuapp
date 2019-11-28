<?php

namespace App\Http\Controllers;

use App\AdaptationTraitement;
use App\Patient;
use App\Premedication;
use App\SurveillancePostAnesthesique;
use App\TraitementHospitalisation;
use App\VisitePreanesthesique;
use MercurySeries\Flashy\Flashy;

class AnesthesisteController extends Controller
{

    public function Premdication_Traitement(Patient $patient)
    {
        return view('admin.consultations.premdication_tritement', [
            'patient' => $patient,
            'TraitementHospitalisations' => TraitementHospitalisation::with('patient', 'user')->where('patient_id', '=', $patient->id)->get(),
            'AdaptationTraitements' => AdaptationTraitement::with('patient', 'user')->where('patient_id', '=', $patient->id)->get(),
            'premedications' => Premedication::with('patient', 'user')->where('patient_id', '=', $patient->id)->latest()->get(),
            'medicament' => Premedication::with('patient', 'user')->where('patient_id', '=', $patient->id)->latest()->first(['medicament']),
        ]);
    }


    public function VisitePreanesthesiqueStore()
    {
        VisitePreanesthesique::create([
            'user_id' => auth()->id(),
            'patient_id' => \request('patient_id'),
            'date_visite' => \request('date_visite'),
            'element_nouveaux' => \request('element_nouveaux')
        ]);

        Flashy('Les nouveaux éléménts ont bien été pris en compte !!');

        return back();

    }


    public function PremedicationConsignePreparationStore()
    {
        Premedication::create([
            'user_id' => auth()->id(),
            'patient_id' => \request('patient_id'),
            'consigne_ide' => \request('consigne_ide'),
            'preparation' => \request('preparation'),
            'medicament' => \request('medicament')
        ]);

        Flashy('Les nouveaux éléménts ont bien été pris en compte !!');

        return back();

    }

    public function TraitementHospitalisationStore(Patient $patient)
    {
        $medicament = Premedication::with('patient', 'user')->get();

        TraitementHospitalisation::create([
            'user_id' => auth()->id(),
            'patient_id' => \request('patient_id'),
            'medicament_posologie_dosage' => $medicament->name,
            'duree' => \request('duree'),
            'j' => \request('j'),
            'j0' => \request('j0'),
            'j1' => \request('j1'),
            'j2' => \request('j2'),
            'm' => \request('m'),
            'mi' => \request('mi'),
            'n' => \request('n'),
            's' => \request('s'),
            'm1' => \request('m1'),
            'mi1' => \request('mi1'),
            's1' => \request('s1'),
            'n1' => \request('n1'),
            'date' => \request('date'),
        ]);

        Flashy('Les nouveaux éléménts ont bien été pris en compte !!');

        return back();

    }

    public function AdaptationTraitementPersoStore()
    {
        AdaptationTraitement::create([
            'user_id' => auth()->id(),
            'patient_id' => \request('patient_id'),
            'medicament_posologie_dosage' => \request('medicament_posologie_dosage'),
            'arret' => \request('arret'),
            'poursuivre' => \request('poursuivre'),
            'continuer' => \request('continuer'),
            'j' => \request('j'),
            'j0' => \request('j0'),
            'j1' => \request('j1'),
            'j2' => \request('j2'),
            'm' => \request('m'),
            'mi' => \request('mi'),
            'n' => \request('n'),
            's' => \request('s'),
            'm1' => \request('m1'),
            'mi1' => \request('mi1'),
            's1' => \request('s1'),
            'n1' => \request('n1'),
            'date' => \request('date'),
        ]);

        Flashy('Les nouveaux éléménts ont bien été pris en compte !!');

        return back();

    }

    public function IndexSurveillancePostAnesthesise(Patient $patient, SurveillancePostAnesthesique $surveillancePostAnesthesique)
    {
        return view('admin.consultations.index_surveillance_post_anesthesique', [

            'patient' => $patient,
            'surveillance_post_anesthesiques' => SurveillancePostAnesthesique::with('patient')->where('patient_id', '=', $patient->id)->get(),
//            'surveillance_post_anesthesique' => $surveillancePostAnesthesique
        ]);
    }

    public function SurveillancePostAnesthesiseStore()
    {
        SurveillancePostAnesthesique::create([

           'user_id' => auth()->id(),
           'patient_id' => request('patient_id'),
           'date_creation' => request('date_creation'),
           'surveillance' => request('surveillance'),
           'traitement' => request('traitement'),
           'examen_paraclinique' => request('examen_paraclinique'),
           'observation' => request('observation'),
           'date_sortie' => request('date_sortie'),
           'heur_sortie' => request('heur_sortie'),
        ]);

        Flashy::info('Votre enregistrement a bien été pris en compte');

        return back();
    }

}
