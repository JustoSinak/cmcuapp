<?php

namespace App\Http\Controllers;

use App\ConsultationSuivi;
use Illuminate\Http\Request;
use App\Patient;
use App\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;

class ConsultationSuiviController extends Controller
{
    public function create(patient $patient)
    {

        $this->authorize('chirurgien', Patient::class);
        $consultationdesuivi = ConsultationSuivi::with('patient')->where('patient_id', $patient->id)->get();
        return view('admin.suivi_consultation.create', compact('patient','consultationdesuivi'));
    }

    public function store(Request $request)
    {
        $this->authorize('chirurgien', Patient::class);
       
        $consultationsuivi = new ConsultationSuivi ();

       
        $consultationsuivi->interrogatoire = $request->get('interrogatoire');
        $consultationsuivi->commentaire = $request->get('commentaire');
        $consultationsuivi->date_creation = $request->get('date_creation');
        
       $consultationsuivi->patient_id = $request->patient_id;
        $consultationsuivi->user_id = Auth::id();
        
        $consultationsuivi->save();

        Flashy('la nouvelle consultation de suivi  a été crée avec succès !!');
        return back();
    }

    public function show(Request $request, $id)
    {

        $consultationdesuivi = ConsultationSuivi::find( $id);

        return view('admin.suivi_consultation.show', compact('consultationdesuivi'));
    }

   
}
