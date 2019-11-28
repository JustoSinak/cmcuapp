<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\EventRequest;
use App\Patient;
use App\User;
use Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EventsController extends Controller
{

    public function index(Patient $patient)
    {

        if(\auth()->user()->role_id === '4'){
            $events = Event::all();
        }else{

            $events = Event::with('patients', 'user')->where('user_id', '=', \auth()->user()->id)->get();
        }

        $event = [];
        if($events->count()) {
            foreach ($events as $row) {
                $event[] = Calendar::event(
                    $row->title,
//                    $row->medecin,
                    true,
                    new \DateTime( $row->date),
                    new \DateTime( $row->end_time),
                    $row->id,
                    // Add color and link on event
                    [
                        'color' => $row->color,
//                        'url' => '',
                    ]
                );
            }
        }

        $calendar = Calendar::addEvents($event)
            ->setOptions([
                'firstDay'=> 1,
                'editable'=> true,
                'navLinks'=> true,
                'selectable'  => true,
                'durationeditable' => true,
                'locale' => 'fr',
            ]);

        return view('admin.events.index', compact('calendar', 'events', 'patient'));
    }

    public function create(Patient $patient)
    {
        $users = User::with('roles')->where('role_id', '=', '2')->get(['name', 'prenom', 'id']);

        return view('admin.events.create', compact('users', 'patient'));
    }

    public function store(EventRequest $request)
    {
//
        $this->authorize('create', Event::class);

        $patient = Patient::findOrFail($request->patient_id);

        if (!empty($patient)){
            Event::create([
                'user_id' => request('user_id'),
                'patient_id' => $patient->id,
                'title' => request('title'),
                'color' => request('color'),
                'date' => request('date'),
                'start_time' => request('start_time'),
                'end_time' => request('end_time'),
            ]);
        }else {
            Event::create([
                'user_id' => \request('user_id'),
                'title' => request('title'),
                'color' => request('color'),
                'date' => request('date'),
                'start_time' => request('start_time'),
                'end_time' => request('end_time'),
            ]);
        }

        return redirect()->route('events.index')->with('success', 'Le rendez-vous a bien été pris avec le médécin');
    }

    public function edit(Request $request, Event $event)
    {
        $users = User::with('roles')->where('role_id', '=', '2')->get(['name', 'prenom']);
        return view('admin.events.edit', compact('event', 'users'));
    }

    public function update(EventRequest $request, Event $event)
    {
        $event->update($request->all());
        return redirect()->route('events.index')->with('success', 'La mise à jour du rendez-vous à bien été prise en compte');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('info', 'Le rendez-vous a bien été supprimer');
    }
}
