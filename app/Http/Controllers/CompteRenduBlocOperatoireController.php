<?php

namespace App\Http\Controllers;

use App\CompteRenduBlocOperatoire;
use App\FicheIntervention;
use App\Http\Requests\CompteRenduBlocOperatoireRequest;
use App\Patient;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;

class CompteRenduBlocOperatoireController extends Controller
{

    public function index(CompteRenduBlocOperatoire $compteRenduBlocOperatoire, Patient $patient)
    {

        return view('admin.consultations.chirurgiens.index_compte_rendu_operatoire', [
            'patient' => $patient,
            'compteRenduBlocOperatoires' => CompteRenduBlocOperatoire::with('patient')->get(),
        ]);
    }


    public function create(CompteRenduBlocOperatoire $compteRenduBlocOperatoire, Patient $patient)
    {

        return view('admin.consultations.create_compte_rendu_operatoire', [

            'compteRenduBlocOperatoire' => $compteRenduBlocOperatoire,
            'patient' => $patient,
            'users' => User::where('role_id', '=', 2)->get(),
            'anesthesistes' => User::whereIn('users.name', ['TENKE', 'SANDJON'])->get(),
            'infirmierAnesthesistes' => User::where('role_id', '=', 4)->get()
        ]);
    }

    public function edit(Patient $patient)
    {
        return view('admin.consultations.edit_compte_rendu_operatoire', [

            'compteRenduBlocOperatoire' => CompteRenduBlocOperatoire::with('user')->where('patient_id', $patient->id)->latest()->first(),
            'patient' => $patient,
            'users' => User::where('role_id', '=', 2)->get(),
            'anesthesistes' => User::whereIn('users.name', ['TENKE', 'SANDJON'])->get(),
            'infirmierAnesthesistes' => User::where('role_id', '=', 4)->get()
        ]);
    }


    public function store(CompteRenduBlocOperatoireRequest $request, Patient $patient)
    {
        $patient = Patient::findOrFail($request->patient_id);

        CompteRenduBlocOperatoire::create([
            'patient_id' => $patient->id,
            'anesthesiste' => \request('anesthesiste'),
            'aide_op' => \request('aide_op'),
            'chirurgien' => \request('chirurgien'),
            'infirmier_anesthesiste' => \request('infirmier_anesthesiste'),
            'compte_rendu_o' => \request('compte_rendu_o'),
            'indication_operatoire' => \request('indication_operatoire'),
            'resultat_histo' => \request('resultat_histo'),
            'suite_operatoire' => \request('suite_operatoire'),
            'traitement_propose' => \request('traitement_propose'),
            'soins' => \request('soins'),
            'conclusion' => \request('conclusion'),
            'dure_intervention' => \request('dure_intervention'),
            'date_intervention' => \request('date_intervention'),
            'titre_intervention' => \request('titre_intervention'),
            'type_intervention' => \request('type_intervention'),
            'proposition_suivi' => \request('proposition_suivi'),
            'date_e'=> request('date_e'),
            'date_s'=> request('date_s'),
            'type_e'=> request('type_e'),
            'type_s'=> request('type_s'),
        ]);

        Flashy('Le compte rendu du bloc opérqtoire a été ajouté avec succes');

        return back();
    }

    public function update(CompteRenduBlocOperatoireRequest $request, CompteRenduBlocOperatoire $compteRenduBlocOperatoire, Patient $patient)
    {
        $compteRenduBlocOperatoire->update($request->all());

        Flashy('Le compte rendu du bloc opérqtoire a été mis à jour');

        return back();
    }

    public function StoreFicheIntervention(Request $request, Patient $patient)
    {
        $patient = Patient::findOrFail($request->patient_id);

        FicheIntervention::create([
            'user_id' => auth()->user()->id,
            'patient_id' => $patient->id,
            'nom_patient' => \request('nom_patient'),
            'prenom_patient' => \request('prenom_patient'),
            'sexe_patient' => \request('sexe_patient'),
            'date_naiss_patient' => \request('date_naiss_patient'),
            'portable_patient' => \request('portable_patient'),
            'type_intervention' => \request('type_intervention'),
            'dure_intervention' => \request('dure_intervention'),
            'position_patient' => implode(",", $request->position_patient ?? []),
            'decubitus' => implode(",", $request->decubitus ?? []),
            'laterale' => implode(",", $request->laterale ?? []),
            'lombotomie' => implode(",", $request->lombotomie ?? []),
            'date_intervention' => \request('date_intervention'),
            'medecin' => \request('medecin'),
            'aide_op' => implode(",", $request->aide_op ?? []),
            'hospitalisation' => \request('hospitalisation'),
            'ambulatoire' => \request('ambulatoire'),
            'anesthesie' => implode(",", $request->anesthesie ?? []),
            'recommendation' => \request('recommendation'),
        ]);

        Flashy('La fiche d\'inteventtion a bien été');

        return back();
    }


    public function compte_rendu_bloc_pdf($id)
    {

        $patient = Patient::with('compte_rendu_bloc_operatoires', 'consultations')->findOrFail($id);

        $pdf = PDF::loadView('admin.etats.crbo', compact('patient'));

        return $pdf->stream('crbo.pdf');
    }

    public function Print_ficheIntervention($id)
    {

        $fiche_intervention = FicheIntervention::findOrFail($id);

        $pdf = PDF::loadView('admin.etats.fiche_intervention', compact('fiche_intervention'));

        return $pdf->stream('fiche_intervention.pdf');
    }
}
