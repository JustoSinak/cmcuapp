<?php

namespace App\Http\Controllers;

use App\Devis;
use App\Facture;
use App\FactureChambre;
use App\FactureDevi;
use Barryvdh\DomPDF\Facade as PDF;
use App\FactureConsultation;
use App\FactureClient;
use App\Patient;
use App\Produit;
use App\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;

class FactureController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('view', User::class);
        $factures = Facture::paginate(100);

        return view('admin.factures.index', compact('factures'));
    }

    public function destroy($id)
    {
        $this->authorize('view', User::class);
        $facture = FactureConsultation::findOrFail($id);
        $facture->delete();
        return redirect()->action('FactureController@FactureConsultation')->with('info', 'La facture n° '.$id.' à bien été supprimée');
    }

    public function show(Facture $facture, Produit $produit)
    {
        $factures = Facture::find($facture);

        return view('admin.factures.show', [
            'facture' => $facture
        ]);
    }

    public function FactureConsultation(Patient $patient, User $user)
    {
        $this->authorize('view', User::class);
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $start_date = "01-" . $month . "-" . $year;
        $start_time = strtotime($start_date);

        $end_time = strtotime("+1 month", $start_time);

        for ($i = $start_time; $i < $end_time; $i += 86400) {
            $lists[] = date('Y-m-d', $i);
        }

        $user = User::where('role_id', '=', 2)->get();
        $factureConsultations = FactureConsultation::with('patient', 'user')->latest()->get();


        return view('admin.factures.consultation', compact('factureConsultations', 'lists'));
    }

    public function FactureConsultationUpdate( Request $request, $id){
        
        $this->authorize('update', new FactureConsultation);

        $request->validate([
            'montant' => 'required',
            'avance' => 'required',
            'reste' => '',

        ]);

        $facture = FactureConsultation::findOrFail($id);
        $facture->montant = $request->get('montant');
        $facture->avance = $request->get('avance');
        $facture->assurec = FactureConsultation::calculAssurec($request->get('montant'), $facture->patient->prise_en_charge);
        $facture->assurancec = FactureConsultation::calculAssuranceC($request->get('montant'), $facture->patient->prise_en_charge);
        $facture->reste = FactureConsultation::calculReste($facture->assurec, $request->get('avance'));
        $facture->statut = $facture->reste == 0 ? 'Soldée' : 'Non soldée';
        $facture->save();
        return redirect()->action('FactureController@FactureConsultation')->with('info', 'La facture n° '.$id.' à bien été mise à jour');
    }

    public function FactureChambre(Patient $patient)
    {
        $this->authorize('view', User::class);

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $start_date = "01-" . $month . "-" . $year;
        $start_time = strtotime($start_date);

        $end_time = strtotime("+1 month", $start_time);

        for ($i = $start_time; $i < $end_time; $i += 86400) {
            $lists[] = date('Y-m-d', $i);
        }

        $factureChambres = FactureChambre::with('patient')->get();

        return view('admin.factures.chambre', compact('factureChambres', 'lists'));
    }

    public function FactureClient(Patient $patient)
    {
        $this->authorize('view', User::class);

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $start_date = "01-" . $month . "-" . $year;
        $start_time = strtotime($start_date);

        $end_time = strtotime("+1 month", $start_time);

        for ($i = $start_time; $i < $end_time; $i += 86400) {
            $lists[] = date('Y-m-d', $i);
        }

        $user = User::where('role_id', '=', 2)->get();
        $facturesClients = FactureClient::with('client')->latest()->get();

        return view('admin.factures.client', compact('facturesClients', 'lists'));
    }

    public function FactureDevis()
    {

        return view('admin.factures.devis', [

            'facture_devis' => FactureDevi::all(),
            'patients' => Patient::orderBy('name', 'asc')->get()
        ]);
    }

    public function FactureDevisCreate()
    {

        return view('admin.factures.facture_devis_create', [
            'devis' => Devis::all(),
            'patients' => Patient::orderBy('name', 'asc')->get()
        ]);
    }

    public function FactureDevisStore(Request $request)
    {
        $date = Carbon::now()->toDateString();
        $facture_devis = new FactureDevi();

        $facture_devis->user_id = Auth::id();
        $facture_devis->patient_id = $request->get('patient_id');
        $facture_devis->numero_facture = $date . '_' . time();
        $facture_devis->montant_devis = $request->get('montant_devis');
        $facture_devis->designation_devis = $request->get('designation_devis');
        $facture_devis->avance_devis = $request->get('avance_devis');
        $facture_devis->numero_assurance = $request->get('numero_assurance');
        $facture_devis->assurance = $request->get('assurance');
        $facture_devis->taux_assurance = $request->get('taux_assurance');
        $facture_devis->date_creation = $request->get('date_creation');

        if ($facture_devis->assurance) {
            if ($facture_devis->avance_devis) {
                $facture_devis->part_patient = ((int) $request->get('montant_devis') * (((int) $request->get('taux_assurance')) / 100));
                $facture_devis->part_assurance = ((int) $request->get('montant_devis')) - ((int) $facture_devis->part_patient);
                $facture_devis->reste_devis = ((int) $request->get('montant_devis')) - ($facture_devis->part_assurance + $facture_devis->avance_devis);
            } else {
                $facture_devis->reste_devis = 0;
                $facture_devis->avance_devis = 0;
                $facture_devis->part_patient = ((int) $request->get('montant_devis') * (((int) $request->get('taux_assurance')) / 100));
                $facture_devis->part_assurance = ((int) $request->get('montant_devis')) - ((int) $facture_devis->part_patient);
            }
        } else {
            if ($facture_devis->avance_devis) {
                $facture_devis->reste_devis = $request->get('montant_devis') - $request->get('avance_devis');
                $facture_devis->part_patient = $request->get('montant_devis');
                $facture_devis->part_assurance = 0;
            } else {
                $facture_devis->reste_devis = 0;
                $facture_devis->avance_devis = 0;
                $facture_devis->part_assurance = 0;
                $facture_devis->part_patient = $request->get('montant_devis');
            }
        }

        $facture_devis->type_paiement = $request->get('type_paiement');
        $facture_devis->numero_cheque = $request->get('numero_cheque');
        $facture_devis->tireur_cheque = $request->get('tireur_cheque');
        $facture_devis->banque_emission = $request->get('banque_emission');
        $facture_devis->date_emission = $request->get('date_emission');
        $facture_devis->attestation_virement = $request->get('attestation_virement');
        $facture_devis->numero_compte = $request->get('numero_compte');
        $facture_devis->montant_virement = $request->get('montant_virement');
        $facture_devis->banque_virement = $request->get('banque_virement');
        $facture_devis->date_virement = $request->get('date_virement');

        $facture_devis->save();

        return redirect()->route('facture_devis.index')->with('info', 'La facture a bien été enregistrée');
    }

    public function export_consultation($id)
    {
        $this->authorize('update', Patient::class);
        $this->authorize('print', Patient::class);
        $patient = Patient::find($id);

        $pdf = PDF::loadView('admin.etats.consultation', ['patient' => $patient]);

        return $pdf->stream('factures.consultation_pdf');
    }

    public function export_client($id)
    {

        $pdf = PDF::loadView('admin.etats.clientP', [
            'clients' => FactureClient::with('user')->findOrFail($id)
        ]);

        return $pdf->stream('factures.client_pdf');
    }

    public function export_facture_devis($id)
    {

        $pdf = PDF::loadView('admin.etats.facture_devis', [
            'facture_devis' => FactureDevi::with('user', 'patient')->findOrFail($id)
        ]);

        //        $pdf->setWatermark('admin/images/logo.jpg', $opacity = 0.6, $top = '30%', $width = '100%', $height = '100%');

        return $pdf->stream('facture_devis.pdf');
    }


    public function export_bilan_consultation()
    {

        $service = \request('service') == 'Tout'? "" : \request('service');
        $factures = FactureConsultation::with('patient')->where('motif', 'LIKE', '%'.$service)->where('date_insertion', '=', \request('day'))->get();


        $tautaux = DB::table('facture_consultations')->where('date_insertion', '=', \request('day'))->where('motif', 'LIKE', '%'.$service)->sum('montant');
        $avances = DB::table('facture_consultations')->where('date_insertion', '=', \request('day'))->where('motif', 'LIKE', '%'.$service)->sum('avance');
        $restes = DB::table('facture_consultations')->where('date_insertion', '=', \request('day'))->where('motif', 'LIKE', '%'.$service)->sum('reste');
        $assurances = DB::table('facture_consultations')->where('date_insertion', '=', \request('day'))->where('motif', 'LIKE', '%'.$service)->sum('assurancec');
        $patients = DB::table('facture_consultations')->where('date_insertion', '=', \request('day'))->where('motif', 'LIKE', '%'.$service)->sum('assurec');



        $pdf = PDF::loadView('admin.etats.bilan_consultation', [
            'service' => $service==""? "" : '- '.$service,
            'factures' => $factures,
            'tautaux' => $tautaux,
            'avances' => $avances,
            'restes' => $restes,
            'assurances' => $assurances,
            'patients' => $patients,
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('bilan_facture_consultation.pdf');
     }

    public function export_bilan_clientexterne()
    {


        $factures = FactureClient::with('client')->where('date_insertion', '=', \request('day'))->get();

        $tautaux = DB::table('facture_clients')->where('date_insertion', '=', \request('day'))->sum('montant');
        $avances = DB::table('facture_clients')->where('date_insertion', '=', \request('day'))->sum('avance');
        $restes = DB::table('facture_clients')->where('date_insertion', '=', \request('day'))->sum('reste');
        $assurances = DB::table('facture_clients')->where('date_insertion', '=', \request('day'))->sum('partassurance');
        $clients = DB::table('facture_clients')->where('date_insertion', '=', \request('day'))->sum('partpatient');



        $pdf = PDF::loadView('admin.etats.bilan_clientexterne', [
            'factures' => $factures,
            'tautaux' => $tautaux,
            'avances' => $avances,
            'restes' => $restes,
            'assurances' => $assurances,
            'clients' => $clients,
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('bilan_facture_clientexterne.pdf');
    }
}
