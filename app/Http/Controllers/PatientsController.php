<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\ConsultationAnesthesiste;
use App\FactureConsultation;
use App\FicheConsommable;
use App\FicheIntervention;
use App\Lettre;
use App\Patient;
use App\Ordonance;
use App\Produit;
use App\SoinsInfirmier;
use App\SurveillancePostAnesthesique;
use App\User;
use App\VisitePreanesthesique;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MercurySeries\Flashy\Flashy;


class PatientsController extends Controller
{

    public function index()
    {
        $this->authorize('update', Patient::class);
        $patients = Patient::with('user')->latest()->get();
        return view('admin.patients.index', compact('patients'));

    }


    public function create(User $user)
    {
        $this->authorize('update', Patient::class);
        $users = User::where('role_id', '=', 2)->with('patients')->get();
        return view('admin.patients.create', compact('users'));
    }


    public function store(Request $request)
    {
        $this->authorize('update', Patient::class);

        $request->validate([
            'name' => 'required',
            'name' => '',
            'prenom' => '',
            'assurance' => '',
            'assurancec' => '',
            'assurec' => '',
            'motif' => '',
            'montant' => '',
            'avance' => '',
            'reste' => '',
            'reste1' => '',
            'demarcheur' => '',
            'numero_assurance' => '',
            'numero_dossier' => '',
            'prise_en_charge' => '',
            'date_insertion' => '',
        ]);

        $patient = new Patient();

        $patient->numero_dossier = mt_rand(1000000, 9999999) - 1;
        $patient->name = $request->get('name');
        $patient->prenom = $request->get('prenom');
        $patient->montant = $request->get('montant');
        $patient->assurance = $request->get('assurance');
        $patient->avance = $request->get('avance');

        $patient->numero_assurance = $request->get('numero_assurance');
        $patient->prise_en_charge = $request->get('prise_en_charge');

        $patient->assurancec = ((int)$request->get('montant')) - ((int)$patient->assurec);
        $patient->assurec = ((int)$request->get('montant') * (((int)$request->get('prise_en_charge')) / 100));
        if ($patient->assurance) {
            if ($patient->avance) {
                $patient->reste = $patient->assurancec - $patient->avance;
                $patient->assurancec = ((int)$request->get('montant')) - ((int)$patient->assurec);
            } else {
                $patient->reste = 0;
                $patient->avance = 0;
                $patient->assurec = ((int)$request->get('montant') * (((int)$request->get('prise_en_charge')) / 100));
                $patient->assurancec = ((int)$request->get('montant')) - ((int)$patient->assurec);
            }
        } else {
            if ($patient->avance) {
                $patient->reste = $request->get('montant') - $request->get('avance');
                $patient->assurec = 0;
                $patient->assurancec = 0;
            } else {
                $patient->reste = 0;
                $patient->avance = 0;
                $patient->assurancec = 0;
                $patient->assurec = $request->get('montant');
            }
        }

        $patient->demarcheur = $request->get('demarcheur');
        $patient->motif = 'CONSULTATION';
        $patient->date_insertion = $request->get('date_insertion');
        $patient->medecin_r = $request->get('medecin_r');
        $patient->user_id = Auth::id();

        $patient->save();

        return redirect()->route('patients.index')->with('success', 'Le patient a été ajouté avec succès !');
    }


    public function show(Patient $patient, Consultation $consultation)
    {
        $this->authorize('update', Patient::class);

        return view('admin.patients.show', [
            'patient' => $patient,
            'medecin' => User::where('role_id', '=', 2)->get(),
            'consultations' => Consultation::with('patient', 'user')->where('patient_id', '=', $patient->id)->latest()->first(),
            'consultation_anesthesistes' => ConsultationAnesthesiste::with('patient', 'user')->latest()->first(),
            'visite_anesthesistes' => VisitePreanesthesique::with('patient', 'user')->latest()->first(),
            'fiche_interventions' => FicheIntervention::with('patient', 'user')->get(),
            'prescriptions' => $patient->prescriptions()->get(),
            'consultation' => $consultation,
            'ordonances' => $patient->ordonances()->paginate(5),
            'dossiers' => $patient->dossiers()->latest()->first(),
            'parametres' => $patient->parametres()->latest()->first(),
            'premedications' => $patient->premedications()->latest()->get(),
            'compte_rendu_bloc_operatoires' => $patient->compte_rendu_bloc_operatoires()->latest()->first()

        ]);
    }


    public function update(Request $request, $id)
    {
        $this->authorize('update', Patient::class);
        $request->validate([
            'name' => '',
            'prenom' => '',
            'assurance' => '',
            'assurancec' => '',
            'assurec' => '',
            'numero_assurance' => '',
            'numero_dossier' => '',
            'montant' => '',
            'motif' => '',
            'avance' => '',
            'reste' => '',
            'reste1' => '',
            'demarcheur' => '',
            'prise_en_charge' => '',
            'date_insertion' => 'date_insertion',
            'medecin_r' => '',
        ]);


        $patient = Patient::findOrFail($id);

        $patient->assurance = $request->get('assurance');
        $patient->numero_assurance = $request->get('numero_assurance');
        $patient->name = $request->get('name');
        $patient->montant = $request->get('montant');
        $patient->avance = $request->get('avance');
        $patient->reste = $request->get('reste');
        $patient->reste1 = $request->get('reste1');
        $patient->assurancec = $request->get('assurancec');
        $patient->assurec = $request->get('assurec');
        $patient->demarcheur = $request->get('demarcheur');
        $patient->prise_en_charge = $request->get('prise_en_charge');
        $patient->motif = $request->get('motif');
        $patient->date_insertion = $request->get('date_insertion');
        $patient->prenom = $request->get('prenom');
        $patient->medecin_r = $request->get('medecin_r');
        $patient->user_id = Auth::id();
        $patient->save();

        return redirect()->route('patients.show', $patient->id)->with('success', 'Les informations du patient ont été mis à jour avec succès !');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Courier de sortie du patient
     */

    public function index_sortie()
    {
        $lettres = Lettre::all();
        return view('admin.lettres.index', compact('lettres'));
    }


    public function print_sortie(Patient $patient)
    {

        $pdf = PDF::loadView('admin.etats.lettre', [
            'patient' => $patient,
            'consultations' => Consultation::latest()->first()
        ]);

        return $pdf->stream('lettre-sortie.pdf');
    }


    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', "Le dossier du patient a bien été supprimé");
    }


    public function generate_consultation(Request $request, $id)
    {
        $this->authorize('update', Patient::class);
        $this->authorize('print', Patient::class);
        $patient = Patient::find($id);

        $factureConsultations = FactureConsultation::where('numero', '=', $patient->numero_dossier)->first();

        if ($factureConsultations) {
            return back()->with('error', 'La facture existe déja');
        } else {
            FactureConsultation::create([
                'numero' => $patient->numero_dossier,
                'patient_id' => $patient->id,
                'assurance' => $patient->assurance,
                'assurancec' => $patient->assurancec,
                'assurec' => $patient->assurec,
                'motif' => $patient->motif,
                'montant' => $patient->montant,
                'demarcheur' => $patient->demarcheur,
                'avance' => $patient->avance,
                'reste' => $patient->reste,
                'prenom' => $patient->prenom,
                'medecin_r' => $patient->medecin_r,
                'date_insertion' => $patient->date_insertion,
                'user_id' => auth()->user()->id,
            ]);
        }


        return redirect()->route('factures.consultation')->with('success', 'La facture a bien été généré veuillez consulter votre liste des factures');
    }

    public function FcheConsommableCreate(FicheConsommable $consommable, Patient $patient)
    {

        return view('admin.patients.fiche_consommable', [
            'produits' => Produit::all(),
            'consommable' => $consommable,
            'consommables' => FicheConsommable::with('patient')->where('patient_id', '=', $patient->id)->get(),
            'patient' => $patient,
            'user_id' => auth()->user()->id
        ]);
    }

    public function Autocomplete(Request $request)
    {

        $datas = Produit::select('designation')->where('designation', 'LIKE', "%{$request->input('query')}%")->get();

        $results = [];
        foreach ($datas as $data)
        {
            $results[] = $data->designation;
        }
        return response()->json($results);
    }

    public function FcheConsommableStore(Request $request)
    {

        FicheConsommable::create([
            'user_id' => \request('user_id'),
            'patient_id' => \request('patient_id'),
            'consommable' => \request('consommable'),
            'jour' => \request('jour'),
            'nuit' => \request('nuit'),
            'date' => \request('date'),
        ]);

        $produits = Produit::where('designation', '=', request('consommable'))->get();

        foreach ($produits as $produit){

            if (!empty(\request('jour'))){

                $produit->qte_stock = $produit->qte_stock - \request('jour');
                $produit->save();
            }
            if (!empty(\request('nuit'))){
                $produit->qte_stock = $produit->qte_stock - \request('nuit');
                $produit->save();
            }
        }

        \Flashy::info('La liste des consommables a été mis à jour');
        return back();
    }

    public function SoinsInfirmierStore()
    {
        SoinsInfirmier::create([

            "user_id" => \auth()->id(),
            "patient_id" => \request('patient_id'),
            "date" => \request('date'),
            "observation" => \request('observation'),
            "patient_externe" => \request('patient_externe'),
        ]);

        Flashy::info('Votre enregistrement a bien été pris en compte');

        return back();
    }

    public function export_ordonance($id)
    {
        //$this->authorize('print', Patient::class);
        $ordonance = Ordonance::with('patient', 'user')->find($id);

        $compteur = 1;

        $pdf = PDF::loadView('admin.etats.ordonance', compact('ordonance', 'compteur'));

        return $pdf->stream('ordonance.pdf');
    }


}
