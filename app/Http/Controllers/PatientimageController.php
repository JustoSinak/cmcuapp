<?php

namespace App\Http\Controllers;
use App\Patient;
use App\Http\Requests\ImagRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Examen;

class PatientimageController extends Controller
{

    public function store(ImagRequest $request)
    {
        $patient = Patient::findOrFail($request->get('patient_id'));
        $path = $request->file('image')->store('examens_scannes', 'public');

        $examen = new Examen([
            'nom'  => $request->get('nom'),
            'description' => $request->get('description'),
            'image'=> $path,
        ]);

        $patient->examens()->save($examen); 
           
        return redirect()->route('patients.show', $patient->id)->with('success', 'examen scanné ajouté avec succès !');
    }

    public function destroy($id, Request $request){

        $this->authorize('update', Patient::class);
        $image = Examen::findOrFail($id);
        Storage::disk('public')->delete($image->image);
        $image->delete();
        return redirect()->route('patients.show', $request->get('patient_id'))->with('success', 'examen scanné supprimé avec succès !');
    }
    
}
