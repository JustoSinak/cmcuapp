<?php

namespace App\Http\Controllers;

use App\Devisd;
use App\Patient;
use App\Devis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
Use App\Http\ChiffreLettre;

class DevisdController extends Controller
{
    public function index()
    {

        return view('admin.devisd.index', [

            'devis' => Devis::all(),
            'devisd' => Devisd::with('devis')->latest()->get()
        ]);
    }

    public function create()
    {

        return view('admin.devisd.create', [

            'devis' => Devis::all(),
        ]);
    }


    public function store(Request $request)
    {

        $this->authorize('create', Patient::class);

//        $user_id = Auth::id();
//        $devis_id = $request->devis_id;
//        $categorie = $request->categorie;
//        $produit = $request->produit;
//        $prix = $request->prix;

        $devisd = new Devisd();
        $devisd->user_id = Auth::id();
        $devisd->devis_id = $request->devis_id;
        $devisd->categorie = implode('/', $request->categorie);
        $devisd->produit = implode('/', $request->produit);
        $devisd->quantite = implode('/', $request->quantite);
        $devisd->prix_unit = implode('/', $request->prix_unit);

        $devisd->prix = ((int)explode('/', $request->prix_unit)) * dd(((int)explode('/', $request->quantite)));

//        for($count = 0; $count < count($categorie); $count++)
//        {
//            $data = array(
//                'user_id' => $user_id,
//                'devis_id' => $devis_id,
//                'categorie' => $categorie[$count],
//                'produit'  => $produit[$count],
//                'prix'  => $prix[$count],
//            );
//            $insert_data[] = $data;
//        }
//
//        Devisd::insert($insert_data);

        $devisd->save();

        return redirect()->route('devisd.index')->with('success', 'ajouté avec succès !');
    }

    public function export_devisd($id)
    {

        $this->authorize('create', Patient::class);
        $devis = Devisd::find($id);


        $pdf = \PDF::loadView('admin.etats.devisd', [

            'devis' => $devis,
            'lettre' => new ChiffreLettre(),
        ]);

        return $pdf->stream('devisd.pdf');
    }

}
