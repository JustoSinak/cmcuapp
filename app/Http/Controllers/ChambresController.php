<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use App\Chambre;
use Illuminate\Support\Facades\Auth;

class ChambresController extends Controller
{

    public function index()
    {
        $chambres = new Chambre;

        if (\request()->has('categorie')){

            $chambres = $chambres->where('categorie', request('categorie'));
        }

        if (\request()->has('order')) {

            $chambres = $chambres->orderBy('id', \request('order'));
        }

        $chambres = $chambres->paginate(100)->appends([

            'categorie' => \request('categorie'),
            'order' => \request('order'),
        ]);

        return view('admin.chambres.index',compact('chambres'));
    }


    public function create()
    {
       return view('admin.chambres.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'numero'=>'required|integer',
            'categorie'=> 'required|string',
            'prix'=>'required|integer'
        ]);

        $chambre = new Chambre();

            $chambre->numero = $request->get('numero');
            $chambre->categorie = $request->get('categorie');
            $chambre->prix = $request->get('prix');
            $chambre->user_id = Auth::id();
            $chambre->save();
        return  redirect()->route('chambres.index')->with('success', 'chambre ajoutée avec succes');
    }


    public function attribute($id)
    {
        $chambre = Chambre::find($id);
        $patients = Patient::all();

        return view('admin.chambres.attribute', compact('chambre', 'patients'));
    }


    public function edit($id)
    {
        $chambre = Chambre::find($id);

        return view('admin.chambres.edit', compact('chambre'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'numero'=> ['required'],
            'categorie'=> ['required'],
            'prix'=> ['required', 'integer', 'numeric'],

        ]);

        $chambre = Chambre::find($id);

        $chambre->numero = $request->get('numero');
        $chambre->categorie = $request->get('categorie');
        $chambre->prix = $request->get('prix');

        $chambre->save();

        return redirect()->route('chambres.index')->with('success', 'La mise à jour a bien été éffectuer');
    }

    public function updateStatus(Request $request, Chambre $chambre)
    {
        $chambre->update($request->only(
            [
                'patient',
                'statut',
                'jour'
            ]));

        return redirect()->route('chambres.index')->with('success', 'La chambre a bien été attribué');
    }

    public function updateMinus(Request $request, Chambre $chambre, Patient $patient)
    {
        $chambre->update($request->only(
            [
                'patient',
                'statut',
                'jour'
            ]));

        return redirect()->route('chambres.index')->with('success', 'La chambre a bien été liberer');
    }

}
