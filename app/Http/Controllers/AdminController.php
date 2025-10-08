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
        // Cache dashboard data for 5 minutes to improve performance
        $dashboardData = \Cache::remember('dashboard_data_' . auth()->id(), 300, function () {
            return [
                'produits' => Produit::count(),
                'users' => User::count(),
                'patients' => Patient::count(),
                'events' => Event::where('user_id', auth()->id())->count(),
                'consultation' => Consultation::select(['id', 'patient_id', 'user_id', 'created_at'])
                    ->with(['user:id,name', 'patient:id,nom,prenom'])
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->limit(10) // Limit to recent consultations for performance
                    ->get(),
            ];
        });

        return view('admin.dashboard', $dashboardData);
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
