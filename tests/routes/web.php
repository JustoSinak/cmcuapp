<?php

Route::get('/', 'AdminController@index');

//Auth::routes();


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');



Route::group(['prefix' => 'admin', 'middleware' => ['auth'] ], function () {


    Route::get('/', 'AdminController@index');
    Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');


    Route::get('users', 'UsersController@index')->name('users.index');
    Route::get('users/create', 'UsersController@create')->name('users.create');
    Route::post('users', 'UsersController@store')->name('users.store');
    Route::get('users/{user}/edit', 'UsersController@edit')->name('users.edit');
    Route::patch('users/{user}', 'UsersController@update')->name('users.update');
    Route::get('users/{user}/profile', 'UsersController@profile')->name('users.profile');
    Route::patch('users/{user}/changePassword', 'UsersController@changePassword')->name('users.changePassword');
    Route::delete('users/{user}', 'UsersController@destroy')->name('users.destroy');


    Route::get('roles', 'RolesController@index')->name('roles.index');
    Route::get('roles/create', 'RolesController@create')->name('roles.create');
    Route::post('roles', 'RolesController@store')->name('roles.store');
    Route::get('roles/{role}/edit', 'RolesController@edit')->name('roles.edit');
    Route::patch('roles/{role}', 'RolesController@update')->name('roles.update');
    Route::delete('roles/{role}', 'RolesController@destroy')->name('roles.destroy');


    Route::get('produits', 'ProduitsController@index')->name('produits.index');
    Route::get('produits/create', 'ProduitsController@create')->name('produits.create');
    Route::post('produits', 'ProduitsController@store')->name('produits.store');
    Route::get('produits/{produit}/edit', 'ProduitsController@edit')->name('produits.edit');
    Route::patch('produits/{produit}', 'ProduitsController@update')->name('produits.update');
    Route::delete('produits/{produit}', 'ProduitsController@destroy')->name('produits.destroy');
    Route::get('pharmaceutiques', 'ProduitsController@stock_pharmaceutique')->name('produits.pharmaceutique');
    Route::get('anesthesiste', 'ProduitsController@stock_anesthesiste')->name('produits.anesthesiste');
    Route::get('materiels', 'ProduitsController@stock_materiel')->name('materiels.pharmaceutique');
    Route::get('pharmaceutiques/{id}', 'ProduitsController@add_to_cart')->name('pharmaceutique.cart');
    Route::get('facturation', 'ProduitsController@facturation')->name('pharmaceutique.facturation');

    Route::post('imprimer','ProduitsController@export_pdf')->name('pharmacie.pdf');
    Route::get('supprimer/{id}', 'ProduitsController@getRemoveItem')->name('facturation.supprimer');
    Route::get('reduire/{id}', 'ProduitsController@getReduceByOne')->name('facturation.reduire');
    Route::post('produit/save-invoice/{produit}', 'ProduitsController@saveInvoice')->name('produit.invoice');
// new route
    Route::post('patients', 'PatientsController@search')->name('search.results');
    // Route::get('events', 'EventsController@index')->name('events.index');
    //Route::get('events/create/{patient}', 'EventsController@create')->name('events.create');
    // //Route::get('events/create', 'EventsController@create')->name('event.create');
    // Route::post('events', 'EventsController@store')->name('events.store');
    // Route::get('events/medecin/{medecin_id}', 'EventsController@show')->name('events.show');// Events show page
    // Route::get('events/medecin/events/{medecin_id}', 'EventsController@show')->name('events.show');//events source for each "médecin" (ressource).
    // Route::get('events/medecin/events/{medecin_id}/', 'EventsController@show')->name('events.show');//events source for each "médecin" (ressource).
    // Route::patch('events/{event}', 'EventsController@update')->name('events.update');
    // Route::delete('events/{event}', 'EventsController@destroy')->name('events.destroy');

    Route::get('events', 'EventsController@index')->name('events.index');
    Route::put('events', 'EventsController@update')->name('events.update');
    Route::get('events/medecin/{id}', 'EventsController@medecinEvents')->name('events.medecinEvents');


    Route::get('patients', 'PatientsController@index')->name('patients.index');
    Route::get('patients/create', 'PatientsController@create')->name('patients.create');
    Route::post('patients1', 'PatientsController@store')->name('patients.store');
    Route::get('patients/{patient}', 'PatientsController@show')->name('patients.show');
    Route::patch('patients/{patient}', 'PatientsController@update')->name('patients.update');
    Route::put('patients/{patient}', 'PatientsController@motifMontantUpdate')->name('patients.motif_montant.update');
    Route::delete('patients/{patient}', 'PatientsController@destroy')->name('patients.destroy');
    Route::get('patient/{id}','PatientsController@generate_consultation')->name('consultation.pdf');
    Route::get('ordonance/{ordonance}','PatientsController@export_ordonance')->name('ordonance.pdf');
    Route::post('bilan-consultation','FactureController@export_bilan_consultation')->name('bilan_consultation.pdf');

    //Route::post('patients/upload-image/{patientId}', 'PatientController@fileStore')->name('patients.upload');
    //Route::post('patients/delete-image', 'Patient@fileDestroy')->name('patients.deleteImage');

   

    Route::get('examens/', 'PatientimageController@index')->name('examens.index');
    Route::get('examens/create/{patient}', 'PatientimageController@create')->name('examens.create');
    Route::post('examen', 'PatientimageController@store')->name('examens.store');
    Route::get('examens/show/{patient}', 'PatientimageController@show')->name('examens.show');
    Route::get('examensf/{patient}', 'PatientimageController@showall')->name('examens.showall');
    Route::delete('examens/{id}', 'PatientimageController@destroy')->name('examens.destroy');


    Route::get('lettre-de-sortie','PatientsController@index_sortie')->name('index.sortie');
    Route::get('lettre-de-sortie/{patient}','PatientsController@print_sortie')->name('print.sortie');
    Route::delete('lettre-de-sortie/{id}', 'PatientsController@destroy_sortie')->name('destroy.sortie');


    Route::get('prescriptions/create/{patient}', 'PrescriptionController@create')->name('prescriptions.create');
    Route::post('examens', 'PrescriptionController@store')->name('prescriptions.store');
    Route::get('prescription_examens/{id}','PrescriptionController@export_prescription')->name('prescription_examens.pdf');

    
    Route::get('dossiers/create', 'DossiersController@create')->name('dossiers.create');
    Route::get('dossiers/create/{patient}', 'DossiersController@create')->name('dossiers.create');
    Route::post('dossiers', 'DossiersController@store')->name('dossiers.store');
    Route::patch('dossiers/{dossier}', 'DossiersController@update')->name('dossiers.update');


    Route::get('consultations/create/{patient}', 'ConsultationsController@create')->name('consultations.create');
    Route::get('consultations/edit/{patient}', 'ConsultationsController@edit')->name('consultations.edit');
    Route::get('consultations/{patient}', 'ConsultationsController@show')->name('consultations.show');

    Route::get('detatils-consultations/{patient}', 'ConsultationsController@IndexConsultationChirurgien')->name('consultations.index');
    Route::get('consultations-anesthesique/{patient}', 'ConsultationsController@IndexConsultationAnesthesiste')->name('consultations.index_anesthesiste');

    Route::put('consultation-chirurgien/{consultation}', 'ConsultationsController@update_consultation_chirurgien')->name('consultation_chirurgien.update');
    Route::put('consultation-anesthesiste/{consultationAnesthesiste}', 'ConsultationsController@update_consultation_anesthesiste')->name('consultation_anesthesiste.update');
    Route::post('consultation-chirurgien', 'ConsultationsController@store_consultation_chirurgien')->name('consultation_chirurgien.store');
    Route::post('consultation-anesthesiste', 'ConsultationsController@store_consultation_anesthesiste')->name('consultation_anesthesiste.store');
    Route::post('consultation-anesthesiste', 'ConsultationsController@Astore')->name('consultation_anesthesiste.store');


    Route::get('consentement-eclaire/{patient}', 'ConsultationsController@Export_consentement_eclaire')->name('consentement_eclaire.pdf');
    Route::get('consultations/{id}','ConsultationsController@export')->name('consulatations.pdf');

    Route::post('fiche-intervention', 'CompteRenduBlocOperatoireController@StoreFicheIntervention')->name('fiche_intervention.store');
    Route::get('fiche-intervention-preview/{id}', 'CompteRenduBlocOperatoireController@Print_ficheIntervention')->name('fiche_intervention.pdf');

    Route::get('compte-rendu-bloc-global/{patient}', 'CompteRenduBlocOperatoireController@index')->name('compte_rendu_bloc.index');
    Route::get('compte-rendu-bloc/create/{patient}', 'CompteRenduBlocOperatoireController@create')->name('compte_rendu_bloc.create');
    Route::get('compte-rendu-bloc/edit/{patient}', 'CompteRenduBlocOperatoireController@edit')->name('compte_rendu_bloc.edit');
    Route::post('compte-rendu-bloc', 'CompteRenduBlocOperatoireController@store')->name('compte_rendu_bloc.store');
    Route::put('compte-rendu-bloc/{compteRenduBlocOperatoire}', 'CompteRenduBlocOperatoireController@update')->name('compte_rendu_bloc.update');
    Route::get('compte-rendu-bloc/{id}', 'CompteRenduBlocOperatoireController@compte_rendu_bloc_pdf')->name('compte_rendu_bloc_pdf.pdf');



    Route::post('ordonances', 'OrdonancesController@store')->name('ordonances.store');
    Route::get('ordonance-creation/create/{patient}','OrdonancesController@ordonance_create')->name('ordonance.create');


    Route::post('parametres', 'ParametresController@fiche_parametre_store')->name('fiche_parametres.store');
    Route::put('parametres/{parametre}', 'ParametresController@fiche_parametre_update')->name('fiche_parametres.update');


    Route::get('/chambres', 'ChambresController@index')->name('chambres.index');
    Route::post('/chambres', 'ChambresController@store')->name('chambres.store');
    Route::get('/chambres/create', 'ChambresController@create')->name('chambres.create');
    Route::get('/chambres/{chambre}/edit', 'ChambresController@edit')->name('chambres.edit');
    Route::patch('/chambres-update/{chambre}', 'ChambresController@update')->name('chambres.update');
    Route::patch('/chambres-attribute/{chambre}', 'ChambresController@updateStatus')->name('chambres_status.update');
    Route::patch('/chambres-liberer/{chambre}', 'ChambresController@updateMinus')->name('chambres_minus.update');
    Route::get('/chambres/{chambre}/attribute', 'ChambresController@attribute')->name('chambres.attribute');


    Route::get('factures', 'FactureController@index')->name('factures.index');
    Route::get('factures-devis', 'FactureController@FactureDevis')->name('facture_devis.index');
    Route::get('factures-devis/create', 'FactureController@FactureDevisCreate')->name('facture_devis.create');
    Route::post('factures-devis', 'FactureController@FactureDevisStore')->name('facture_devis.store');
    Route::get('factures-devis/{id}', 'FactureController@export_facture_devis')->name('facture_devis.pdf');
    Route::get('factures/{facture}', 'FactureController@show')->name('factures.show');
    Route::delete('facture', 'FactureController@destroy')->name('factures.destroy');
    Route::delete('facture/{id}', 'FactureController@destroy')->name('factures.destroy');
    Route::get('factures-consultation', 'FactureController@FactureConsultation')->name('factures.consultation');
    Route::post('factures-consultation', 'FactureController@FactureConsultation')->name('search.date');
    Route::put('factures-consultation/{id}', 'FactureController@FactureConsultationUpdate')->name('factures.consultation.update');
    Route::get('factures-chambre', 'FactureController@FactureChambre')->name('factures.chambre');
    Route::get('patient-facture/{id}','FactureController@export_consultation')->name('factures.consultation_pdf');

    Route::get('factures-client', 'FactureController@FactureClient')->name('factures.client');
    Route::get('facture/{id}','FactureController@export_client')->name('factures.client_pdf');
   


    Route::resource('/fiches', 'FichesController');
    Route::get('fiche/{id}','FichesController@export_pdf')->name('fiche.pdf');

    //Route::get('devis/create', 'DevisController@create')->name('devis.create');
    Route::post('devis/edit/{id}', 'DevisController@edit')->name('devis.edit');
    Route::post('devis', 'DevisController@store')->name('devis.store');
    Route::get('devis', 'DevisController@index')->name('devis.index');
    Route::post('devis/export/{montant}','DevisController@export_devis')->name('devis.pdf');

    // Route::get('devisimage/', 'DevisImageController@index')->name('devisimage.index');
    // Route::get('devisimage/create', 'DevisImageController@create')->name('devisimage.create');
    // Route::post('devisimage', 'DevisImageController@store')->name('devisimage.store');
    // Route::get('devisimage/show/{patient}', 'DevisImageController@show')->name('devisimage.show');
    // Route::get('devisimagef/{patient}', 'DevisImageController@showall')->name('devisimage.showall');

    // Route::get('devisd/create', 'DevisdController@create')->name('devisd.create');
    // Route::post('devisd', 'DevisdController@store')->name('devisd.store');
    // Route::get('devisd', 'DevisdController@index')->name('devisd.index');
    // Route::get('devis-print/{id}','DevisdController@export_devisd')->name('devisd.pdf');
   

    // Route::get('clients', 'ClientController@index')->name('clients.index');
    // Route::get('clients/create', 'ClientController@create')->name('clients.create');
    // Route::post('clients', 'ClientController@store')->name('clients.store');
    // Route::patch('clients/{client}', 'ClientController@update')->name('clients.update');
    // Route::delete('clients/{client}', 'ClientController@destroy')->name('clients.destroy');

    // Route::get('client/{id}','ClientController@generate_client')->name('clientP.pdf');
    // //Route::get('clients/{id}','ClientController@export_client')->name('clientP.pdf');
    // Route::post('bilan-clientexterne','FactureController@export_bilan_clientexterne')->name('bilan_clientexterne.pdf');



    Route::get('premedication-adaptation-traitement/{patient}', 'AnesthesisteController@Premdication_Traitement')->name('premedication_adaptation.index');
    Route::post('visite-pre-anesthesique', 'AnesthesisteController@VisitePreanesthesiqueStore')->name('visite_preanesthesique.store');
    Route::post('premedication-consigne-preparation', 'AnesthesisteController@PremedicationConsignePreparationStore')->name('premedication_consigne_preparation.store');
    Route::post('traitement-hospitalisation', 'AnesthesisteController@TraitementHospitalisationStore')->name('traitement_hospitalisation.store');
    Route::post('adaptation-traitement', 'AnesthesisteController@AdaptationTraitementPersoStore')->name('adaptation_traitement.store');

    Route::get('observations-medicales/{patient}', 'ChirurgienController@AbservationMedicaleCreate')->name('observations_medicales.index');
    Route::post('observations-medicales', 'ChirurgienController@AbservationMedicaleStore')->name('observations_medicales.store');
    Route::put('observations-medicales/{}', 'ChirurgienController@AbservationMedicaleUpdate')->name('observations_medicales.update');
    Route::get('observations-medicales/edit/{}', 'ChirurgienController@AbservationMedicaleEdit')->name('observations_medicales.edit');

    Route::get('fiches-consommables/{patient}', 'PatientsController@FcheConsommableCreate')->name('fiche_consommable.index');
    Route::post('fiches-consommables', 'PatientsController@FcheConsommableStore')->name('fiche_consommable.store');
    Route::get('autocomplete', 'PatientsController@Autocomplete')->name('autocomplete');
    Route::get('surveillance-rapproche/{patient}', 'ParametresController@SurveillanceRapprocheParametre')->name('surveillance_rapproche.index');
    Route::get('surveillance-rapproche-details/{patient}', 'ParametresController@IndexSurveillanceRapprocheParametre')->name('surveillance_rapproche');
    Route::get('parametres-patients/{patient}', 'ParametresController@IndexParametrePatient')->name('fiche_parametre.index');

    Route::get('fiche-prescriptions-medicales/patient/{patient}', 'FichePrescriptionMedicaleController@Index')->name('fiche.prescription_medicale.index');
    Route::post('fiche-prescriptions-medicales/patient/{patient}', 'FichePrescriptionMedicaleController@Store')->name('fiche.prescription_medicale.store');
    Route::post('prescriptions-medicales/fiche/{fiche}', 'FichePrescriptionMedicaleController@PrescriptionMedicaleStore')->name('prescription_medicale.store');
    Route::post('prescriptions-medicales/{id}/Admin-PM', 'FichePrescriptionMedicaleController@AdminPMStore')->name('admin.prescription_medicale.store');


    Route::get('surveillance-details/{patient}', 'ParametresController@IndexSurveillanceScore')->name('surveillance_score.index');
    Route::post('surveillance-score', 'ParametresController@SurveillanceScoreStore')->name('surveillance_score.store');

    Route::post('surveillance-rapproche-parametres', 'ParametresController@SurveillanceRapprocheStore')->name('surveillance_rapproche_param');

    Route::get('surveillance-post-anesthesique/{patient}', 'AnesthesisteController@IndexSurveillancePostAnesthesise')->name('surveillance_post_anesthesise.index');
    Route::post('surveillance-post-anesthesique', 'AnesthesisteController@SurveillancePostAnesthesiseStore')->name('surveillance_post_anesthesise.store');
    Route::put('surveillance-post-anesthesique/{surveillancePostAnesthesique}', 'AnesthesisteController@SurveillancePostAnesthesiseUpdate')->name('surveillance_post_anesthesise.update');


    Route::post('soins-infirmier', 'PatientsController@SoinsInfirmierStore')->name('soins_infirmiers.store');

    Route::get('imagerie/create/{patient}', 'ImagerieController@create')->name('imageries.create');
    Route::post('imagerie', 'ImagerieController@store')->name('imageries.store');
    Route::get('imagerie_examens/{id}','ImagerieController@export_imageries')->name('imageries_examens.pdf');

    Route::post('active-licence', 'AdminController@ActiveLicence')->name('active_licence_key');

    Route::get('consultationsdesuivi/create/{patient}', 'ConsultationSuiviController@create')->name('consultationsdesuivi.create');
    Route::get('consultationsdesuivi/edit/{patient}', 'ConsultationSuiviController@edit')->name('consultationsdesuivi.edit');
    Route::get('consultationsdesuivi/{patient}', 'ConsultationSuiviController@show')->name('consultationsdesuivi.show');
    Route::post('consultationsdesuivi', 'ConsultationSuiviController@store')->name('consultationsdesuivi.store');
});
