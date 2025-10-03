<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Event;
use App\Http\Requests\LicenceActiveRequest;
use App\Models\Licence;
use App\Models\Patient;
use App\Models\Produit;
use App\Models\User;
use Carbon\Carbon;
use MercurySeries\Flashy\Flashy;

class AdminController extends Controller
{

    public function dashboard()
    {
        $produits = Produit::count();
        $users = User::count();

        $patients = Patient::count();
        $consultation = Consultation::with('user')->where('user_id', '=', \auth()->id())->get();
        $events = Event::where('user_id', \auth()->id())->count();
        $license = rand(1000,9999) . '-' . rand(1000,9999) . '-' . rand(1000,9999) . '-' . rand(1000,9999) . '-' . rand(1000,9999);
        
        // for ($i=0; $i < 1000000; $i++) { 
           
        // }

        return view('admin.dashboard', compact('produits', 'users', 'patients', 'events', 'consultation'));
    }

    public function ActiveLicence(LicenceActiveRequest $request)
    {

        $licence = Licence::where('client', 'cmcuapp')->first();

        $licence->update([

            'license_key' => request('license_key'),
            'expire_date' => Carbon::parse('+1 month')
        ]);



        Flashy::info('Votre licence a bien été activé');

        return back();
    }

   public function index()
    {
        return redirect()->route('admin.dashboard');
    }

   /*function phpans_license(){
        $license = rand(1000,9999) . '-' . rand(1000,9999) . '-' . rand(1000,9999) . '-' . rand(1000,9999) . '-' . rand(1000,9999);
        return $license;
    }*/

}
