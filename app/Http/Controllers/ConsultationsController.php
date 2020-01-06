<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\ConsultationAnesthesiste;
use App\Parametre;
use Barryvdh\DomPDF\Facade as PDF;
use App\Devis;
use App\Http\Requests\ConsultationRequest;
use App\Patient;
use App\User;

use Illuminate\Http\Request;


class ConsultationsController extends Controller
{

    public function IndexConsultationChirurgien(Consultation $consultations, Patient $patient)
    {

        return view('admin.consultations.chirurgiens.index_consultation_chirurgien', [
            'patient' => $patient,
            'consultations' => Consultation::with('patient', 'user')->where('patient_id', '=', $patient->id)->get(),
        ]);
    }

    public function IndexConsultationAnesthesiste(ConsultationAnesthesiste $consultationAnesthesiste, Patient $patient)
    {

        return view('admin.consultations.anesthesistes.index_consultation_anesthesiste', [
            'patient' => $patient,
            'consultationAnesthesistes' => ConsultationAnesthesiste::with('patient', 'user')->where('patient_id', '=', $patient->id)->get(),
        ]);
    }


    public function create(Patient $patient, Consultation $consultation,ConsultationAnesthesiste $consultation_anesthesiste, Parametre $parametre)
    {

        return view('admin.consultations.create', [
            'patient' => $patient,
            'devis' => Devis::all(),
            'users' => User::where('role_id', '=', 2)->with('patients')->get(),
            'consultation' => $consultation,
            'parametre' => $parametre,
            'consultation_anesthesiste' => $consultation_anesthesiste
        ]);
    }


    public function edit(Consultation $consultation, Patient $patient)
    {

        return view('admin.consultations.edit', [
            'patient' => $patient,
            'devis' => Devis::all(),
            'users' => User::where('role_id', '=', 2)->with('patients')->get(),
            'consultation' => Consultation::where('patient_id', $patient->id)->latest()->first(),
            'consultation_anesthesiste' => ConsultationAnesthesiste::where('patient_id', $patient->id)->latest()->first(),
            'parametre' => Parametre::where('patient_id', $patient->id)->latest()->first()
        ]);
    }

    public function store_consultation_chirurgien(ConsultationRequest $request)
    {

        $patient = Patient::findOrFail($request->patient_id);


        Consultation::create([
            'user_id' => auth()->id(),
            'patient_id' => $patient->id,
            'diagnostic'=> request('diagnostic'),
            'interrogatoire'=> request('interrogatoire'),
            'antecedent_m'=> request('antecedent_m'),
            'antecedent_c'=> request('antecedent_c'),
            'allergie'=> request('allergie'),
            'groupe'=> request('groupe'),
            'proposition'=> implode(",", $request->proposition),
            'examen_c'=> request('examen_c'),
            'examen_p'=> request('examen_p'),
            'devis_id'=> request('devis_id'),
            'motif_c'=> request('motif_c'),
            'acte'=> implode(",", $request->acte ?? []),
            'type_intervention' => request('type_intervention'),
            'date_intervention' => request('date_intervention'),
            'date_consultation' => request('date_consultation'),
            'date_consultation_anesthesiste' => request('date_consultation_anesthesiste'),
            'medecin_r'=> request('medecin_r'),
            'proposition_therapeutique'=> request('proposition_therapeutique'),

        ]);

        Flashy('La nouvelle consultation a été créée avec succès !!');

        return back();
    }

    public function update_consultation_chirurgien(Consultation $consultation, Request $request)
    {

        $consultation->diagnostic = request('diagnostic');
        $consultation->interrogatoire = request('interrogatoire');
        $consultation->antecedent_m = request('antecedent_m');
        $consultation->antecedent_c = request('antecedent_c');
        $consultation->allergie = request('allergie');
        $consultation->groupe = request('groupe');
        $consultation->examen_c = request('examen_c');
        $consultation->examen_p = request('examen_p');
        $consultation->devis_id = request('devis_id');
        $consultation->motif_c = request('motif_c');
        $consultation->type_intervention = request('type_intervention');
        $consultation->date_intervention = request('date_intervention');
        $consultation->date_consultation = request('date_consultation');
        $consultation->date_consultation_anesthesiste = request('date_consultation_anesthesiste');
        $consultation->medecin_r = request('medecin_r');
        $consultation->proposition_therapeutique = request('proposition_therapeutique');
        $consultation->proposition = implode(",", $request->proposition ?? []);
        $consultation->acte = implode(",", $request->acte ?? []);

        $consultation->update();

        Flashy('La mise à jour a été effectuée');
        return back();
    }

    public function Astore(Request $request)
    {

        $patient = Patient::findOrFail($request->patient_id);

        $ConsultationAnesthesiste = new ConsultationAnesthesiste();

        $ConsultationAnesthesiste->user_id = auth()->id();
        $ConsultationAnesthesiste->patient_id = $patient->id;
        $ConsultationAnesthesiste->specialite = \request('specialite');
        $ConsultationAnesthesiste->medecin_traitant = \request('medecin_traitant');
        $ConsultationAnesthesiste->operateur = \request('operateur');
        $ConsultationAnesthesiste->date_intervention = \request('date_intervention');
        $ConsultationAnesthesiste->motif_admission = \request('motif_admission');
        $ConsultationAnesthesiste->anesthesi_salle = implode(",", $request->anesthesi_salle ?? []);
        $ConsultationAnesthesiste->risque = \request('risque');
        $ConsultationAnesthesiste->solide = \request('solide');
        $ConsultationAnesthesiste->liquide = \request('liquide');
        $ConsultationAnesthesiste->benefice_risque = \request('benefice_risque');
        $ConsultationAnesthesiste->technique_anesthesie = implode(",", $request->technique_anesthesie ?? []);
        $ConsultationAnesthesiste->technique_anesthesie1 = \request('technique_anesthesie1');
        $ConsultationAnesthesiste->synthese_preop = \request('synthese_preop');
        $ConsultationAnesthesiste->antecedent_traitement = \request('antecedent_traitement');
        $ConsultationAnesthesiste->examen_clinique = \request('examen_clinique');
        $ConsultationAnesthesiste->traitement_en_cours = \request('traitement_en_cours');
        $ConsultationAnesthesiste->antibiotique = \request('antibiotique');
        $ConsultationAnesthesiste->autre1 = \request('autre1');
        $ConsultationAnesthesiste->memo = \request('memo');
        $ConsultationAnesthesiste->adaptation_traitement = \request('adaptation_traitement');
        $ConsultationAnesthesiste->date_hospitalisation = \request('date_hospitalisation');
        $ConsultationAnesthesiste->service = \request('service');
        $ConsultationAnesthesiste->classe_asa = \request('classe_asa');
        $ConsultationAnesthesiste->allergie = \request('allergie');
        $ConsultationAnesthesiste->examen_paraclinique = implode(",", $request->examen_paraclinique ?? []);
        $ConsultationAnesthesiste->intubation = \request('intubation');
        $ConsultationAnesthesiste->mallampati = \request('mallampati');
        $ConsultationAnesthesiste->distance_interincisive = \request('distance_interincisive');
        $ConsultationAnesthesiste->distance_thyromentoniere = \request('distance_thyromentoniere');
        $ConsultationAnesthesiste->mobilite_servicale = \request('mobilite_servicale');

        $ConsultationAnesthesiste->save();

        Flashy('La nouvelle consultation a été créée avec succès !!');

        return back();
    }

    public function update_consultation_anesthesiste(ConsultationAnesthesiste $consultationAnesthesiste, Request $request, Patient $patient)
    {
        $consultationAnesthesiste->specialite = \request('specialite');
        $consultationAnesthesiste->medecin_traitant = \request('medecin_traitant');
        $consultationAnesthesiste->operateur = \request('operateur');
        $consultationAnesthesiste->date_intervention = \request('date_intervention');
        $consultationAnesthesiste->motif_admission = \request('motif_admission');
        $consultationAnesthesiste->anesthesi_salle = implode(",", $request->anesthesi_salle ?? []);
        $consultationAnesthesiste->risque = \request('risque');
        $consultationAnesthesiste->solide = \request('solide');
        $consultationAnesthesiste->liquide = \request('liquide');
        $consultationAnesthesiste->benefice_risque = \request('benefice_risque');
        $consultationAnesthesiste->technique_anesthesie = implode(",", $request->technique_anesthesie ?? []);
        $consultationAnesthesiste->technique_anesthesie1 = \request('technique_anesthesie1');
        $consultationAnesthesiste->synthese_preop = \request('synthese_preop');
        $consultationAnesthesiste->antecedent_traitement = \request('antecedent_traitement');
        $consultationAnesthesiste->examen_clinique = \request('examen_clinique');
        $consultationAnesthesiste->traitement_en_cours = \request('traitement_en_cours');
        $consultationAnesthesiste->antibiotique = \request('antibiotique');
        $consultationAnesthesiste->autre1 = \request('autre1');
        $consultationAnesthesiste->memo = \request('memo');
        $consultationAnesthesiste->adaptation_traitement = \request('adaptation_traitement');
        $consultationAnesthesiste->date_hospitalisation = \request('date_hospitalisation');
        $consultationAnesthesiste->service = \request('service');
        $consultationAnesthesiste->classe_asa = \request('classe_asa');
        $consultationAnesthesiste->allergie = \request('allergie');
        $consultationAnesthesiste->examen_paraclinique = implode(",", $request->examen_paraclinique ?? []);
        $consultationAnesthesiste->intubation = \request('intubation');
        $consultationAnesthesiste->mallampati = \request('mallampati');
        $consultationAnesthesiste->distance_interincisive = \request('distance_interincisive');
        $consultationAnesthesiste->distance_thyromentoniere = \request('distance_thyromentoniere');
        $consultationAnesthesiste->mobilite_servicale = \request('mobilite_servicale');

        $consultationAnesthesiste->update();

        Flashy('La mise à jour a été éffectuée avec succès !!');

        return back();
    }

    
    public function show(Request $request, $id)
    {

        $consultations = Consultation::find($id);

        return view('admin.consultations.show', compact('consultations'));
    }

    public function Export_consentement_eclaire(Patient $patient)
    {

        $pdf = PDF::loadView('admin.etats.consentement_eclaire', [

            'patient' => $patient,
            'dossiers' => $patient->dossiers()->latest()->first(),
            'fiche_intervention' => $patient->fiche_interventions()->latest()->first(),
            'consultation_anesthesiste' => $patient->consultation_anesthesistes()->latest()->first()
        ]);


        return $pdf->stream('consentement_eclaire.pdf');
    }

   

}
