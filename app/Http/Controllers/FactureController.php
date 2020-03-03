<?php

namespace App\Http\Controllers;

use App\Facture;
use App\FactureChambre;
use App\FactureDevi;
use Barryvdh\DomPDF\Facade as PDF;
use App\FactureConsultation;
use App\FactureClient;
use App\HistoriqueFacture;
use Illuminate\Database\Eloquent\Builder;
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
            'mode_paiement' => 'required',
            'num_cheque' => 'requiredIf:mode_paiement,chèque',
            'emetteur_cheque' => 'requiredIf:mode_paiement,chèque',
            'banque_cheque' =>  'requiredIf:mode_paiement,chèque',
            'emetteur_bpc' =>  'requiredIf:mode_paiement,bon de prise en charge',
            'reste' => 'required|numeric',
            'percu' => 'required|numeric|lte:reste',
        ]);

        $facture = FactureConsultation::findOrFail($id);
        //
        if ($request->get('mode_paiement') === "chèque") {
            $mode_paiement_info_sup = $request->get('num_cheque')." // ".$request->get('emetteur_cheque')." // ".$request->get('banque_cheque');
        } else {
            $mode_paiement_info_sup = ($request->get('mode_paiement') === "bon de prise en charge") ? $request->get('emetteur_bpc'): "" ;
        }
        
        $historiqueFacture = new HistoriqueFacture([
                    'reste' => $facture->reste - $request->get('percu'),
                    'montant' => $facture->montant,
                    'percu'   => $request->get('percu'),
                    'assurec'  => $facture->assurec,
                    'mode_paiement'  => $request->get('mode_paiement'),
                    'mode_paiement_info_sup' => $mode_paiement_info_sup,//
                ]);

        $facture->montant = $request->get('montant');
        $facture->avance += $request->get('percu');
        $facture->mode_paiement = $request->get('mode_paiement');
        $facture->mode_paiement_info_sup = $mode_paiement_info_sup;//
        $facture->assurec = FactureConsultation::calculAssurec($request->get('montant'), $facture->patient->prise_en_charge);
        $facture->assurancec = FactureConsultation::calculAssuranceC($request->get('montant'), $facture->patient->prise_en_charge);
        $facture->reste = FactureConsultation::calculReste($facture->assurec, $facture->avance);
        $facture->statut = $facture->reste == 0 ? 'Soldée' : 'Non soldée';
        $facture->save();
        $facture->historiques()->save($historiqueFacture);
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

    // public function FactureDevis()
    // {

    //     return view('admin.factures.devis', [

    //         'facture_devis' => FactureDevi::all(),
    //         'patients' => Patient::orderBy('name', 'asc')->get()
    //     ]);
    // }

    // public function FactureDevisCreate()
    // {

    //     return view('admin.factures.facture_devis_create', [
    //         'devis' => Devi::all(),
    //         'patients' => Patient::orderBy('name', 'asc')->get()
    //     ]);
    // }

    // public function FactureDevisStore(Request $request)
    // {
    //     $date = Carbon::now()->toDateString();
    //     $facture_devis = new FactureDevi();

    //     $facture_devis->user_id = Auth::id();
    //     $facture_devis->patient_id = $request->get('patient_id');
    //     $facture_devis->numero_facture = $date . '_' . time();
    //     $facture_devis->montant_devis = $request->get('montant_devis');
    //     $facture_devis->designation_devis = $request->get('designation_devis');
    //     $facture_devis->avance_devis = $request->get('avance_devis');
    //     $facture_devis->numero_assurance = $request->get('numero_assurance');
    //     $facture_devis->assurance = $request->get('assurance');
    //     $facture_devis->taux_assurance = $request->get('taux_assurance');
    //     $facture_devis->date_creation = $request->get('date_creation');

    //     if ($facture_devis->assurance) {
    //         if ($facture_devis->avance_devis) {
    //             $facture_devis->part_patient = ((int) $request->get('montant_devis') * (((int) $request->get('taux_assurance')) / 100));
    //             $facture_devis->part_assurance = ((int) $request->get('montant_devis')) - ((int) $facture_devis->part_patient);
    //             $facture_devis->reste_devis = ((int) $request->get('montant_devis')) - ($facture_devis->part_assurance + $facture_devis->avance_devis);
    //         } else {
    //             $facture_devis->reste_devis = 0;
    //             $facture_devis->avance_devis = 0;
    //             $facture_devis->part_patient = ((int) $request->get('montant_devis') * (((int) $request->get('taux_assurance')) / 100));
    //             $facture_devis->part_assurance = ((int) $request->get('montant_devis')) - ((int) $facture_devis->part_patient);
    //         }
    //     } else {
    //         if ($facture_devis->avance_devis) {
    //             $facture_devis->reste_devis = $request->get('montant_devis') - $request->get('avance_devis');
    //             $facture_devis->part_patient = $request->get('montant_devis');
    //             $facture_devis->part_assurance = 0;
    //         } else {
    //             $facture_devis->reste_devis = 0;
    //             $facture_devis->avance_devis = 0;
    //             $facture_devis->part_assurance = 0;
    //             $facture_devis->part_patient = $request->get('montant_devis');
    //         }
    //     }

    //     $facture_devis->type_paiement = $request->get('type_paiement');
    //     $facture_devis->numero_cheque = $request->get('numero_cheque');
    //     $facture_devis->tireur_cheque = $request->get('tireur_cheque');
    //     $facture_devis->banque_emission = $request->get('banque_emission');
    //     $facture_devis->date_emission = $request->get('date_emission');
    //     $facture_devis->attestation_virement = $request->get('attestation_virement');
    //     $facture_devis->numero_compte = $request->get('numero_compte');
    //     $facture_devis->montant_virement = $request->get('montant_virement');
    //     $facture_devis->banque_virement = $request->get('banque_virement');
    //     $facture_devis->date_virement = $request->get('date_virement');

    //     $facture_devis->save();

    //     return redirect()->route('facture_devis.index')->with('info', 'La facture a bien été enregistrée');
    // }

    public function export_consultation($id)
    {
        $this->authorize('update', Patient::class);
        $this->authorize('print', Patient::class);
        $facture = FactureConsultation::find($id);

        $pdf = PDF::loadView('admin.etats.consultation', ['patient' => $facture->patient, 'facture' => $facture]);

        return $pdf->stream('factures.consultation_pdf');
    }

    public function export_client($id)
    {

        $pdf = PDF::loadView('admin.etats.clientP', [
            'clients' => FactureClient::with('user')->findOrFail($id)
        ]);

        return $pdf->stream('factures.client_pdf');
    }

    // public function export_facture_devis($id)
    // {

    //     $pdf = PDF::loadView('admin.etats.facture_devis', [
    //         'facture_devis' => FactureDevi::with('user', 'patient')->findOrFail($id)
    //     ]);

    //     //        $pdf->setWatermark('admin/images/logo.jpg', $opacity = 0.6, $top = '30%', $width = '100%', $height = '100%');

    //     return $pdf->stream('facture_devis.pdf');
    // }


    public function export_bilan_consultation()
    {

        $service = \request('service') == 'Tout'? "" : \request('service');

        $factures = HistoriqueFacture::where('created_at', 'LIKE', \request('day').'%')
                    ->with('facture_consultation.patient')
                    ->whereHas('facture_consultation', function (Builder $query) use ($service) {
                        $query->where('motif', 'LIKE', '%'.$service)
                            ->where('deleted_at', '=', null);
                        })
                    ->get()->groupBy('facture_consultation_id');
        $totalPercu = 0;
        $totalMontant = 0;
        $totalReste = 0;
        $totalPartAssurance = 0;
        $totalPartPatient = 0;
        $tFactures=[];
        $modePaiement = [];
        foreach ($factures as $key => $historique_factures) {
            $tFactures[$key]['percu'] = 0;
            foreach ($historique_factures as $historique_facture) {
                $tFactures[$key]['numero'] = $historique_facture->facture_consultation->numero;
                $tFactures[$key]['name'] = $historique_facture->facture_consultation->patient->name;
                $tFactures[$key]['montant'] = $historique_facture->facture_consultation->montant;
                $tFactures[$key]['percu'] += $historique_facture->percu;
                $tFactures[$key]['reste'] = $historique_facture->reste;
                $tFactures[$key]['partAssurance'] = $historique_facture->facture_consultation->assurancec;
                $tFactures[$key]['partPatient'] = $historique_facture->facture_consultation->assurec;
                $tFactures[$key]['medecin'] = $historique_facture->facture_consultation->medecin_r;
                $tFactures[$key]['demarcheur'] = $historique_facture->facture_consultation->demarcheur;
                switch ($historique_facture->mode_paiement) {
                    case 'espèce':
                        if (array_key_exists('espece',$modePaiement))
                            $modePaiement['espece']['val'] += $historique_facture->percu;
                        else{
                            $modePaiement['espece']['val'] = $historique_facture->percu;
                            $modePaiement['espece']['name'] = 'espèce';
                        }
                        break;
                    case 'chèque':
                        if (array_key_exists('cheque',$modePaiement))
                            $modePaiement['cheque']['val'] += $historique_facture->percu;
                        else{
                            $modePaiement['cheque']['val'] = $historique_facture->percu;
                            $modePaiement['cheque']['name'] = 'chèque';
                        }
                        break;
                    case 'orange money':
                        if (array_key_exists('om',$modePaiement))
                            $modePaiement['om']['val'] += $historique_facture->percu;
                        else
                           { $modePaiement['om']['val'] = $historique_facture->percu;
                            $modePaiement['om']['name'] = 'om';
                        }
                        break;
                    case 'mtn mobile money':
                        if (array_key_exists('momo',$modePaiement))
                            $modePaiement['momo']['val'] += $historique_facture->percu;
                        else
                            {$modePaiement['momo']['val'] = $historique_facture->percu;
                            $modePaiement['momo']['name'] = 'mtn mobile money';
                        }
                        break;
                    case 'virement':
                        if (array_key_exists('virement',$modePaiement))
                            $modePaiement['virement']['val'] += $historique_facture->percu;
                        else
                            {$modePaiement['virement']['val'] = $historique_facture->percu;
                            $modePaiement['virement']['name'] = 'virement';
                        }
                        break;
                    case 'bon de prise en charge':
                        if (array_key_exists('bondepriseencharge',$modePaiement))
                            $modePaiement['bondepriseencharge']['val'] += $historique_facture->percu;
                        else
                            {$modePaiement['bondepriseencharge']['val'] = $historique_facture->percu;
                            $modePaiement['bondepriseencharge']['name'] = 'bon de prise en charge';
                        }
                        break;
                    
                    default:
                        if (array_key_exists('autre',$modePaiement))
                            $modePaiement['autre']['val'] += $historique_facture->percu;
                        else{
                            $modePaiement['autre']['val'] = $historique_facture->percu;
                            $modePaiement['autre']['name'] = 'autre';
                        }
                        break;
                }

                $totalPercu += $historique_facture->percu;
            }

            
            $totalMontant += $tFactures[$key]['montant'];
            $totalReste += $tFactures[$key]['reste'];
            $totalPartAssurance += $tFactures[$key]['partAssurance'];
            $totalPartPatient += $tFactures[$key]['partPatient'];
        }
        
        $pdf = PDF::loadView('admin.etats.bilan_consultation', [
            'mode_paiement' => $modePaiement,
            'service' => $service==""? "" : '- '.$service,
            'tFactures' => $tFactures,
            'totalPercu' => $totalPercu,
            'totalMontant' => $totalMontant,
            'totalReste' => $totalReste,
            'totalPartAssurance' => $totalPartAssurance,
            'totalPartPatient' => $totalPartPatient,
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('bilan_facture_consultation.pdf');
     }

    public function export_bilan_clientexterne()
    {


        $factures = FactureClient::with('client')->where('date_insertion', '=', \request('day'))->get();

        $totalPercu = DB::table('facture_clients')->where('date_insertion', '=', \request('day'))->sum('montant');
        $avances = DB::table('facture_clients')->where('date_insertion', '=', \request('day'))->sum('avance');
        $restes = DB::table('facture_clients')->where('date_insertion', '=', \request('day'))->sum('reste');
        $assurances = DB::table('facture_clients')->where('date_insertion', '=', \request('day'))->sum('partassurance');
        $clients = DB::table('facture_clients')->where('date_insertion', '=', \request('day'))->sum('partpatient');



        $pdf = PDF::loadView('admin.etats.bilan_clientexterne', [
            'factures' => $factures,
            'totalPercu' => $totalPercu,
            'avances' => $avances,
            'restes' => $restes,
            'assurances' => $assurances,
            'clients' => $clients,
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('bilan_facture_clientexterne.pdf');
    }
}
