<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\EventRequest;
use App\Patient;
use App\User;
use Calendar;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class EventsController extends Controller
{

    public function index(Request $request)
    {
        $events = Event::with('patients')->get();
        $patients = Patient::latest()->get(['id','name','prenom']);
        $ressources = User::where('role_id', 2)->get(['id', 'name', 'prenom']);
        return view('admin.events.index', ['events' =>$events, 'ressources' => $ressources, 'patients' => $patients]);
    }

    public function medecinEvents(Request $request, $id_medecin)
    {
        // $events = Event::with('patients')->where('resourceId', '=', $id_medecin)->get();
        $events = Event::with('patients')->where('user_id', '=', $id_medecin)->get();
        //var_dump(json_encode(compact('events')));
        return view('admin.events.show', compact('events'));
    }

    public function update(Request $request)
    {
        $this->authorize('create', Event::class);
        if ($request->ajax()) {

            $events = json_decode($request->get('events'));
            $result = "";
            foreach ($events as $event) {
                switch ($event->state) {
                    case 'cre':
                        $eventToBeSaved = Event::create([
                            'title' => $event->title,//
                            'start' => Carbon::createFromFormat('Y-m-d\TH:i:s.uP', $event->start),//
                            'end' => Carbon::createFromFormat('Y-m-d\TH:i:s.uP', $event->end),//
                            'user_id' => $event->resourceId,//
                            'description' => $event->description,//
                            'objet' => $event->objet,
                            'statut' => $event->statut,//
                            'state' => 'aucun', //$event->state,//
                            'patient_id' => $event->patient->id,//
                        ]);
                        $eventToBeSaved->save();
                        $eventToBeSaved->fresh();
                        $result = $result."Rendez-vous ".$eventToBeSaved->id.' créé ! ';
                        break;
                    case 'mod':
                        $eventToBeUpdated = Event::findOrFail($event->id);
                        $eventToBeUpdated->update([
                            'id' => $event->id,
                            'title' => $event->title,
                            'start' => Carbon::createFromFormat('Y-m-d\TH:i:s.uP', $event->start),
                            'end' => Carbon::createFromFormat('Y-m-d\TH:i:s.uP', $event->end),
                            'user_id' => $event->resourceId,
                            'description' => $event->description,
                            'objet' => $event->objet,
                            'statut' => $event->statut,
                            'state' => 'aucun', //$event->state,
                            //'patient_id' => $event->patient->id,
                        ]);
                        $result = $result."Rendez-vous ".$event->id.' modifié ! ';

                        break;
                    case 'sup':
                        Event::destroy($event->id);
                        $result = $result.'Rendez-vous '.$event->id.' supprimé ! ';
                        break;
                    default:
                        # code...
                        break;
                }
            }
            return response()->json(['info' => $result]);
        }
        abort(404);
    }
}
