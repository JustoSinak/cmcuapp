<?php


namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Http\Requests\DossierRequest;
use App\Models\Patient;

class DossiersController extends Controller
{
    
    public function create(Patient $patient)
    {
        $dossier = Dossier::where('patient_id', $patient->id)->first();
        if (isset($dossier)) {
            
            return view('admin.dossiers.edit', ['patient'=>$patient, 'dossier'=>Dossier::where('patient_id', $patient->id)->latest()->first()]);
        }
        $dossier = "";
            return view('admin.dossiers.create',['patient'=>$patient]);
        
    }


    public function store(DossierRequest $request)
    {
        $user = Auth()->user();

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
        // Redirection pour le médecin
        if ($user->role_id == 2) {
            return redirect()->route('patients.show', ['patient'=> $patient])->with('info', 'Le dossier du patient a bien été mis à jour !');
        }
        // Redirection pour l'infirmier
        if ($user->role_id == 4) {
            return redirect()->route('consultations.create', ['patient'=> $patient]);
        }
        
        return redirect()->route('patients.index')->with('info', 'Le dossier du patient a bien été mis à jour !');
    }

    public function update( Dossier $dossier, DossierRequest $request)
    {
        $patient = Patient::findOrFail($request->patient_id);
       
        $dossier->patient_id = $patient->id;
        $dossier->sexe = request('sexe');
        $dossier->date_naissance = request('date_naissance');
        $dossier->lieu_naissance = request('lieu_naissance');
        $dossier->adresse = request('adresse');
        $dossier->portable_1 = request('portable_1');
        $dossier->portable_2 = request('portable_2');
        $dossier->profession = request('profession');
        $dossier->personne_contact = request('personne_contact');
        $dossier->tel_personne_contact = request('tel_personne_contact');

        $dossier->update();
        
        return redirect()->route('patients.show', ['patient'=> $patient])->with('info', 'Le dossier du patient a bien été mis à jour !');
    }

}

