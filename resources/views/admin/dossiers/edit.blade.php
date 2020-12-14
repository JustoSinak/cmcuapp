@extends('layouts.admin')

@section('title', 'CMCU | Modifier le dossier du patient')

@section('content')

    <body>
    <div class="se-pre-con"></div>
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">MODIFIER LE DOSSIER DU PATIENT {{$patient->name}} {{$patient->prenom}}</h1>
            <hr>
                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-success float-right"
                    title="Retour à la liste des patients">
                    <i class="fas fa-arrow-left"></i> Retour au dossier patient
                </a>
            @include('partials.flash_form')
            <form class="form-row mt-4" method="POST" action="{{ route('dossiers.update', $dossier->id) }}">
            {{method_field('PATCH')}} @csrf

            <input type="hidden" value="{{ $dossier->patient_id }}" name="patient_id">
                <div class="col-md-8 pb-3">
                    <label for="exampleAccount">Sexe</label>
                    <div class="form-group small">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="sexe" id="sexe" value="Masculin"> Masculin
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="sexe" id="sexe" value="Féminin"> Féminin
                            </label>
                        </div>
                    </div>
                </div>
               
                <div class="col-sm-6 pb-3">
                    <label for="date_naissance">Date de naissance</label>
                    <input type="date" class="form-control" value="{{ $dossier->date_naissance }}" name="date_naissance" placeholder="Date de naissance">
                </div>
 
                <div class="col-sm-6 pb-3">
                    <label for="exampleLast">Profession</label>
                    <input type="text" value="{{ $dossier->profession }}" class="form-control" name="profession" placeholder="Profession du patient">
                </div>

                <div class="col-sm-6 pb-3">
                    <label for="lieu_naissance">Lieu de naissance</label>
                    <input type="text" class="form-control" value="{{ $dossier->lieu_naissance }}" name="lieu_naissance" placeholder="Lieu de naissance">
                </div>

                <div class="col-sm-6 pb-3">
                    <label for="adresse">Portable</label>
                    <input type="number" class="form-control" value="{{ $dossier->portable_1 }}" name="portable_1" placeholder="Portable">
                </div>

                <div class="col-sm-6 pb-3">
                    <label for="adresse">Portable 2</label>
                    <input type="number" class="form-control" value="{{ $dossier->portable_2 }}" name="portable_2" placeholder="Portable 2">
                </div>

                <div class="col-sm-6 pb-3">
                    <label for="adresse">Adresse</label>
                    <input type="text" class="form-control" value="{{ $dossier->adresse }}" name="adresse" placeholder="Adresse du patient">
                </div>

                <div class="col-sm-6 pb-3">
                    <label for="personne_contact">Personne à contacter</label>
                    <input type="text" class="form-control" value="{{ $dossier->personne_contact }}" name="personne_contact" placeholder="Personne à contacter">
                </div>

                <div class="col-sm-6 pb-3">
                    <label for="tel_personne_contact">Téléphone personne à contacter</label>
                    <input type="number" class="form-control" value="{{ $dossier->tel_personne_contact }}" name="tel_personne_contact" placeholder="Téléphone personne à contacter">
                </div>
                
                <div class="row col-md-12">
                    <button type="submit" class="btn btn-primary btn-lg col-sm-4" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;Modifier</button>
                </div>
            </form>
        </div>
    </div>
    </body>

@stop
