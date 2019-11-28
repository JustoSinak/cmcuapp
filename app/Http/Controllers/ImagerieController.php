<?php

namespace App\Http\Controllers;
use App\Imagerie;
use Illuminate\Http\Request;
use App\Patient;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

class ImagerieController extends Controller
{
    public function create(patient $patient)
    {
        $imageries = Imagerie::with('patient')->where('patient_id', $patient->id)->get();
        return view('admin.consultations.partials.feuille_examen_imagerie', compact('patient', 'imageries'));
    }



    public function store(Request $request)
    {
       
       $imageries = [];
        $patient = Patient::findOrFail($request->patient_id);

        $imageries = new Imagerie ();

       
        $imageries->radiographie = implode(',', $request->radiographie ?? []);
        $imageries->echographie = implode(',', $request->echographie  ?? []);
        $imageries->scanner = implode(',', $request->scanner ?? []);
        $imageries->irm = implode(',', $request->irm ?? []);
        $imageries->scintigraphie = implode(',', $request->scintigraphie ?? []);
        $imageries->autre = implode(',', $request->autre ?? []);
        $imageries->patient_id = $request->patient_id;
        $imageries->user_id = Auth::id();
        
        $imageries->save();

        Flashy('La nouvelle prescription a été crée avec succès !!');

        return back();
    
    }

    public function show(Request $request, $id)
    {

        $imageries = Imagerie::find( $id);

        return view('admin.imageries.show', compact('imageries'));
    }

    public function export_imageries($id)
    {

        $imageries = Imagerie::find($id);
        $pdf = PDF::loadView('admin.etats.imageries', compact('imageries'));

        return $pdf->stream('imageries.pdf');
    }

}
