<?php

namespace App\Http\Controllers;
use App\Patient;
use App\Http\Requests\ImagRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Request;
use App\Examen;

class PatientimageController extends Controller
{
    public function index()
    {
        $patients = Patient::with('examens')->get();
        
        return view('admin.examens.index', compact('patients'));

    }


    public function create(Patient $patient)
    {
        return view('admin.examens.create', compact('patient'));
    }


    public function store(ImagRequest $request, Patient $patient)
    {

        $patient = Patient::findOrFail($request->patient_id);

        $examens = new Examen ();

        $examens->type = $request->get('type');
        $examens->patient_id = $request->patient_id;

// dd($request->hasFile('image'));
$image = $request->file('image');
        $filename['image'] = time() . '.' . $image->getClientOriginalExtension();
        $location = 'images/';
        // Image::make($image->getRealPath())->resize(800, 400)->save($location);
        $image->move($location, $filename['image']);
        $examens->image = $filename['image'];
        $examens->save();

        // $image = $request->file('image');
        // $filename['image'] = time() . '.' . $image->getClientOriginalExtension();
        // dd($image->move('upload/images' . '.jpeg'));
        // $examens->image = $filename['image'];
        // $examens->save();
    
           
        return redirect()->route('examens.index')->with('success', 'examen ajouté avec succès !');
    }

    public function show(Request $request, $id){
        
        $examens = Examen::find($id);
        return view('admin.examens.show', compact('examens'));
    }

    public function showall(Patient $patient ){
       
        $patients = Patient::with('examens')->where('id', $patient->id)->get();
        

        return view('admin.examens.index', compact('patients','examens'));
    }
   
    
}
