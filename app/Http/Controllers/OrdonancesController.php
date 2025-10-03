<?php

namespace App\Http\Controllers;

use App\Models\Ordonance;
use App\Models\Patient;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class OrdonancesController extends Controller
{

    public function store(Request $request)
    {

        $patient = Patient::findOrFail($request->patient_id);
        Ordonance::create([
            'user_id' => auth()->id(),
            'patient_id' => $patient->id,
            'description'=> implode(",", $request->description),
            'medicament'=> implode(",", $request->medicament),
            'quantite'=> implode(",", $request->quantite),

        ]);

        Flashy('La nouvelle ordonance a été crée avec succès !!');

        return back();
    }

    public function export_pdf($id)
    {

        $ordonance = Ordonance::find($id);
        $pdf = PDF::loadView('admin.etats.ordonance', compact('ordonance'));

        return $pdf->download('ordonance.pdf');
    }

    public function ordonance_create(Patient $patient)
    {
        return view('admin.prescriptions.ordonance_create', compact('patient'));
    }

}
