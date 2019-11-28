<?php

namespace App\Http\Controllers;
use App\Http\Requests\DevisRequest;
use App\Patient;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use App\Devis;

class DevisController extends Controller
{
    public function index()
    {
       
        $devis = Devis::latest()->get();

        return view('admin.devis.index', compact('devis'));
    }

    public function edit($id)
    {
        $devi = Devis::findOrFail($id);
        $patients = Patient::orderBy('name', 'asc')->get();

        return view('admin.devis.edit', compact('devi', 'patients'));
    }


    public function store(DevisRequest $request)
    {

        $this->authorize('create', Patient::class);

        $devis = new Devis();
        $devis->nom = $request->get('nom');
        $devis->qte1 = $request->get('qte1');
        $devis->qte2 = $request->get('qte2');
        $devis->qte3 = $request->get('qte3');
        $devis->qte4 = $request->get('qte4');
        $devis->qte5= $request->get('qte5');
        $devis->qte6 = $request->get('qte6');
        $devis->qte7= $request->get('qte7');
        $devis->qte8= $request->get('qte8');
        $devis->qte9= $request->get('qte9');
        $devis->qte10= $request->get('qte10');
        $devis->qte11= $request->get('qte11');
        $devis->qte12= $request->get('qte12');
        $devis->qte13= $request->get('qte13');
        $devis->qte14= $request->get('qte14');

        $devis->prix_u = $request->get('prix_u');
        $devis->prix_u1 = $request->get('prix_u1');
        $devis->prix_u2 = $request->get('prix_u2');
        $devis->prix_u3 = $request->get('prix_u3');
        $devis->prix_u4 = $request->get('prix_u4');
        $devis->prix_u5 = $request->get('prix_u5');
        $devis->prix_u6 = $request->get('prix_u6');
        $devis->prix_u7 = $request->get('prix_u7');
        $devis->prix_u8 = $request->get('prix_u8');
        $devis->prix_u9 = $request->get('prix_u9');
        $devis->prix_u10 = $request->get('prix_u10');
        $devis->prix_u11 = $request->get('prix_u11');
        $devis->prix_u12 = $request->get('prix_u12');
        $devis->prix_u13 = $request->get('prix_u13');

        $devis->montant = ((int)$request->get('qte1') * (int)$request->get('prix_u'));
        $devis->montant1 = ((int)$request->get('qte2') * (int)$request->get('prix_u1'));
        $devis->montant2 = ((int)$request->get('qte3')  * (int)$request->get('prix_u2'));
        $devis->montant3 =( (int)$request->get('qte4') * (int)$request->get('prix_u3'));
        $devis->montant4 = ((int)$request->get('qte5') * (int)$request->get('prix_u4'));
        $devis->montant5 = ((int)$request->get('qte6') * (int)$request->get('prix_u5'));
        $devis->montant6 = ((int)$request->get('qte7') * (int)$request->get('prix_u6'));
        $devis->montant7 = ((int)$request->get('qte8') * (int)$request->get('prix_u7'));
        $devis->montant8 = ((int)$request->get('qte9') * (int)$request->get('prix_u8'));
        $devis->montant9 = ((int)$request->get('qte10') * (int)$request->get('prix_u9'));
        $devis->montant10 = ((int)$request->get('qte11') * (int)$request->get('prix_u10'));
        $devis->montant11 = ((int)$request->get('qte12') * (int)$request->get('prix_u11'));
        $devis->montant12 = ((int)$request->get('qte13') * (int)$request->get('prix_u12'));
        $devis->montant13 = ((int)$request->get('qte14') * (int)$request->get('prix_u13'));
        
        $devis->elements = $request->get('elements');
        $devis->elements1 = $request->get('elements1');
        $devis->elements2 = $request->get('elements2');
        $devis->elements3 = $request->get('elements3');
        $devis->elements4 = $request->get('elements4');
        $devis->elements5 = $request->get('elements5');
        $devis->elements6 = $request->get('elements6');
        $devis->elements7 = $request->get('elements7');
        $devis->elements8 = $request->get('elements8');
        $devis->elements9 = $request->get('elements9');
        $devis->elements10 = $request->get('elements10');
        $devis->elements11 = $request->get('elements11');
        $devis->elements12 = $request->get('elements12');
        $devis->elements13 = $request->get('elements13');
        $devis->arreter = $request->get('arreter');

        $devis->total1 = $devis->montant + $devis->montant1 + $devis->montant2 + $devis->montant3 + 
        $devis->montant4 + $devis->montant5 +  $devis->montant6 + $devis->montant7 + $devis->montant8;

        $devis->total2 =  $devis->montant9 + $devis->montant10 + $devis->montant11 + $devis->montant12 + $devis->montant13;
        $devis->total3 = $devis->total1 +  $devis->total2;

        $devis->patient_id = $request->patient_id;
        $devis->user_id = Auth::id();
         $devis->save();

        return redirect()->route('devis.index')->with('success', 'ajouté avec succès !');
    }

    public function export_devis($id)
    {
        $this->authorize('create', Patient::class);

        $devis = Devis::find($id);
        $devis->update([

            'patient_id' => \request('patient_id')
        ]);



        $pdf = PDF::loadView('admin.etats.devis', [

            'devis' => $devis,
        ]);

        return $pdf->stream('devis.pdf');
    }

    public function create()
    {
        $this->authorize('create', Patient::class);

        return view('admin.devis.create');
    }

}
