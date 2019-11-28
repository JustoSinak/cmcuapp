<?php


namespace App\Http\Controllers;

use App\Dossier;
use App\Http\Requests\DossierRequest;
use App\Patient;

class DossiersController extends Controller
{

    public function create(Patient $patient)
    {
        return view('admin.dossiers.create', compact('patient'));
    }


    public function store(DossierRequest $request)
    {
        $patient = Patient::findOrFail($request->patient_id);

        Dossier::create([
            'patient_id' => $patient->id,
            'sexe'=> request('sexe'),
            'date_naissance'=> request('date_naissance'),
            'lieu_naissance'=> request('lieu_naissance'),
            'adresse'=> request('adresse'),
            'profession'=> request('profession'),
            'personne_contact'=> request('personne_contact'),
            'tel_personne_contact'=> request('tel_personne_contact'),
            'personne_confiance'=> request('personne_confiance'),
            'tel_personne_confiance'=> request('tel_personne_confiance'),
            'portable_1'=> request('portable_1'),
            'portable_2'=> request('portable_2'),
            'fax'=> request('fax'),
            'email'=> request('email'),
        ]);

        return redirect()->route('patients.index')->with('info', 'Le dossier du patient a bien été mis à jour !');
    }
}

