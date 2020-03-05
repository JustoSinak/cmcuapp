<?php

namespace App\Http\Controllers;
use App\Patient;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Devi;
use App\LigneDevi;

class DevisController extends Controller
{
    public function index()
    {
       
        $devis = Devi::latest()->with('ligneDevis:id,element,quantite,prix_u,devi_id')
                    ->get(["id","code","acces","user_id","nom","nbr_chambre","nbr_visite","nbr_ami_jour","pu_chambre","pu_visite","pu_ami_jour"]);
        $patients = Patient::orderBy('name', 'ASC')->get(['id','name', 'prenom']);
        return view('admin.devis.index', compact('devis','patients'));
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('update', Devi::class);

        $request->validate([
            'code_devis' => '',
            'nbr_chambre' => 'required|numeric|min:0',
            'nbr_visite' => 'required|numeric|min:0',
            'nbr_ami_jour' => 'required|numeric|min:0',
            'pu_chambre' => 'required|numeric|min:0',
            'pu_visite' => 'required|numeric|min:0',
            'pu_ami_jour' => 'required|numeric|min:0',
            'nom_devis' => 'required',
            'acces_devis' => 'required',
            'ligneDevi' => 'array|required',
            'ligneDevi.*.element' => 'required',
            'ligneDevi.*.quantite' => 'required|numeric|min:1',
            'ligneDevi.*.prix_u' => 'required|numeric|min:1',
        ]);

        
        $devi = Devi::findOrFail($id);
        $devi->nom = $request->get('nom_devis');
        $devi->nbr_chambre = $request->get('nbr_chambre');
        $devi->nbr_visite = $request->get('nbr_visite');
        $devi->nbr_ami_jour = $request->get('nbr_ami_jour');
        $devi->pu_chambre = $request->get('pu_chambre');
        $devi->pu_visite = $request->get('pu_visite');
        $devi->pu_ami_jour = $request->get('pu_ami_jour');
        $devi->code = $request->get('code_devis') ?? \Carbon\Carbon::now()->toDateString().'/'.substr($request->get('nom_devis'),0,4);
        $devi->acces =$request->get('acces_devis');
        $lignedevis = $request->get('ligneDevi');
        $devi->save();
        LigneDevi::where('devi_id',$id)->delete();//supprime toutes les lignes
         foreach ($lignedevis as  $ligneDevi) {
             $devi->ligneDevis()->save(new LigneDevi([
                "element" => $ligneDevi["element"],
                "quantite" => $ligneDevi["quantite"],
                "prix_u" => $ligneDevi["prix_u"],
             ]));
         }

        return redirect()->route('devis.index')->with('success', 'Devis modifié avec succès !');
    }


    public function store(Request $request)
    {
        $this->authorize('create', Devi::class);

        $request->validate([
            'code_devis' => '',
            'nbr_chambre' => 'required|numeric|min:0',
            'nbr_visite' => 'required|numeric|min:0',
            'nbr_ami_jour' => 'required|numeric|min:0',
            'pu_chambre' => 'required|numeric|min:0',
            'pu_visite' => 'required|numeric|min:0',
            'pu_ami_jour' => 'required|numeric|min:0',
            'nom_devis' => 'required',
            'acces_devis' => 'required',
            'ligneDevi' => 'array|required',
            'ligneDevi.*.element' => 'required',
            'ligneDevi.*.quantite' => 'required|numeric|min:1',
            'ligneDevi.*.prix_u' => 'required|numeric|min:1',
        ]);

        $devis = Devi::create([
            'nom' => $request->get('nom_devis'),
            'nbr_chambre' => $request->get('nbr_chambre'),
            'nbr_visite' => $request->get('nbr_visite'),
            'nbr_ami_jour' => $request->get('nbr_ami_jour'),
            'pu_chambre' => $request->get('pu_chambre'),
            'pu_visite' => $request->get('pu_visite'),
            'pu_ami_jour' => $request->get('pu_ami_jour'),
            'code' => $request->get('code_devis') ?? \Carbon\Carbon::now()->toDateString().'/'.substr($request->get('nom_devis'),0,4),
            'acces' => $request->get('acces_devis'),
            'user_id' =>  Auth::id(),
        ]);
         $lignedevis = $request->get('ligneDevi');
         foreach ($lignedevis as  $ligneDevi) {
             $devis->ligneDevis()->save(new LigneDevi([
                "element" => $ligneDevi["element"],
                "quantite" => $ligneDevi["quantite"],
                "prix_u" => $ligneDevi["prix_u"],
             ]));
         }

        return redirect()->route('devis.index')->with('success', 'Devis enregistré avec succès !');
    }

    public function export_devis (Request $request, $montant_en_lettre)
    {
        $this->authorize('print', Devi::class);

        $request->validate([
            'patient' => 'required',
            'nbr_chambre' => 'required|numeric|min:0',
            'nbr_visite' => 'required|numeric|min:0',
            'nbr_ami_jour' => 'required|numeric|min:0',
            'pu_chambre' => 'required|numeric|min:0',
            'pu_visite' => 'required|numeric|min:0',
            'pu_ami_jour' => 'required|numeric|min:0',
            'nom_devis' => 'required',
            'acces_devis' => '',
            'code_devis' => '',
            'ligneDevi' => 'array|required',
            'ligneDevi.*.element' => 'required',
            'ligneDevi.*.quantite' => 'required|numeric|min:1',
            'ligneDevi.*.prix_u' => 'required|numeric|min:1',
        ]);
        
        $devis = new Devi([
            'nbr_chambre' => $request->get('nbr_chambre'),
            'nbr_visite' => $request->get('nbr_visite'),
            'nbr_ami_jour' => $request->get('nbr_ami_jour'),
            'pu_chambre' => $request->get('pu_chambre'),
            'pu_visite' => $request->get('pu_visite'),
            'pu_ami_jour' => $request->get('pu_ami_jour'),
            'nom' => $request->get('nom_devis'),
            'code' => $request->get('code_devis') ?? \Carbon\Carbon::now()->toDateString().'/'.substr($request->get('nom_devis'),0,4),
            'user_id' =>  Auth::id(),
            'total1' => 0,
        ]);
        $nomPatient =$request->get('patient');
         $ld = $request->get('ligneDevi');
         $lignedevis=[];
         $total1 = 0;
         $prix_chambre = $request->get('nbr_chambre') * $request->get('pu_chambre');
         $prix_visite = $request->get('nbr_visite') * $request->get('pu_visite');
         $prix_ami_jour = $request->get('nbr_ami_jour') * $request->get('pu_ami_jour');
         $devis->total2 = $prix_chambre + $prix_visite + $prix_ami_jour;
         foreach ($ld as  $ligneDevi) {
            $total1 += $ligneDevi["prix_u"]*$ligneDevi["quantite"];
            array_push($lignedevis, new LigneDevi([
                "element" => $ligneDevi["element"],
                "quantite" => $ligneDevi["quantite"],
                "prix_u" => $ligneDevi["prix_u"],
                "prix" => $ligneDevi["prix_u"]*$ligneDevi["quantite"],
             ]));
         }
         $devis->total1 = $total1;
         $devis->total = $montant_en_lettre;
        $pdf = PDF::loadView('admin.etats.devis', [
            'devis' => $devis,
            'ligneDevis' => $lignedevis,
            'nomPatient' => $nomPatient,
        ]);

        return $pdf->stream('devis.pdf');
    }
}
