<?php

namespace App\Http\Controllers;
use App\DevisImage;
use Illuminate\Http\Request;
use App\Patient;
use App\Http\Requests\ImageDevisRequest;
use Intervention\Image\Facades\Image;
use App\Devis;

class DevisImageController extends Controller
{
    public function index(Request $request)
    {
        $devis = Devis::all();
        $devisimages = DevisImage::orderBy('id', 'asc')->paginate(100);

        
        return view('admin.devisimage.index', compact('devisimages','devis'));

    }


    public function create()
    {
        $devis = Devis::all();
        return view('admin.devisimage.create', compact('devis'));
    }
    

    public function store(ImageDevisRequest $request)
    {

       $devisimages = new DevisImage();
        
       $devisimages->devis_p = $request->get('devis_p');
      
   // $patient->id = $request->get('patient_id');

            $image = $request->file('image') ;
            $filename['image'] = time() . '.' . $image->getClientOriginalExtension();
            $location = 'images/' . $filename['image'];
            Image::make($image)->resize(800, 400)->save($location);
            $devisimages->image = $filename['image'];
           
            $devisimages->save();
    
           
        return redirect()->route('devisimage.index')->with('success', 'devis ajouté avec succès !');
    }

    public function show(Request $request, $id)
    {
        
        $devisimages = DevisImage::find($id);
        return view('admin.devisimage.show', compact('devisimages'));
    }

    public function showall(Patient $patient )
    {
       
        $patients = Patient::with('devisimage')->where('id', $patient->id)->get();
        

        return view('admin.devisimage.index', compact('patients','devisimage'));
    }

}
