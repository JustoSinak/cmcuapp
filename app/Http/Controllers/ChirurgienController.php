<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ObservationMedicale;
use App\Models\Patient;
use App\Models\SoinsInfirmier;
use App\Models\User;
use Illuminate\Http\Request;

class ChirurgienController extends Controller
{

    public function AbservationMedicaleCreate(Patient $patient)
    {

        return view('admin.consultations.observation_medicale', [

            'anesthesistes' => User::whereIn('users.name', ['TENKE', 'SANDJON'])->get(),
            'users' => User::where('role_id', '=', 2)->get(),
            'patient' => $patient,
            'patient_externes' => Client::orderBy('nom', 'asc')->get(),
            'observation_medicales' => ObservationMedicale::with('patient')->where('patient_id', '=', $patient->id)->get(),
            'soins_infirmiers' => SoinsInfirmier::with('patient')->where('patient_id', '=', $patient->id)->get()
        ]);
    }


    public function AbservationMedicaleStore(Request $request)
    {

        $observationMedicale = new ObservationMedicale();

        $observationMedicale->user_id = \request('user_id');
        $observationMedicale->patient_id = \request('patient_id');
        $observationMedicale->observation = \request('observation');
        $observationMedicale->date = \request('date');
        $observationMedicale->anesthesiste = \request('anesthesiste');

        $observationMedicale->save();

        return back()->with('success', 'Votre enregistrement a bien été pris en compte');
    }

    public function AbservationMedicaleEdit()
    {

    }

    public function AbservationMedicaleUpdate()
    {

    }
}
