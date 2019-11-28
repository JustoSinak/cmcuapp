@extends('layouts.admin')

@section('title', 'CMCU | Rensegner un dossier patient')

@section('content')

    <body>
    <div class="se-pre-con"></div>
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">RENSEIGNER LE DOSSIER DU PATIENT</h1>
            <hr>
            @include('partials.flash_form')
            <form class="form-row mt-4" method="post" action="{{ route('dossiers.store') }}">
                @csrf

                <div class="col-md-6 pb-3">
                    <label for="exampleAccount"><b>Sexe :</b></label>
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

                <div class="col-sm-4 pb-3">
                    <label for=""><b></b></label>
                    <input class="form-control" type="hidden" name="patient_id" value="{{ $patient->id }}">
                </div>

                <div class="col-sm-4 pb-3">
                    <label for="date_naissance"><b>Date de naissance :</b></label>
                    <input type="date" class="form-control" value="{{ old('date_naissance') }}" name="date_naissance" placeholder="Date de naissance">
                </div>

                <div class="col-sm-6 pb-3">
                    <label for="lieu_naissance"><b>Lieu de naissance :</b></label>
                    <input type="text" class="form-control" value="{{ old('lieu_naissance') }}" name="lieu_naissance" placeholder="Lieu de naissance">
                </div>

                <div class="col-sm-4 pb-3">
                    <label for="portable_1"><b>Portable :</b></label>
                    <input type="number" value="{{ old('portable_1') }}" class="form-control" name="portable_1" placeholder="Portable">
                </div>
                <div class="col-sm-4 offset-2 pb-3">
                    <label for="portable_2"><b>Portable :</b></label>
                    <input type="number" value="{{ old('portable_2') }}" class="form-control" name="portable_2" placeholder="Portable 2">
                </div>

                <div class="col-sm-4 pb-3">
                    <label for="fax"><b>Fax :</b></label>
                    <input type="text" value="{{ old('fax') }}" class="form-control" name="fax" placeholder="Fax">
                </div>

                <div class="col-sm-4 offset-2 pb-3">
                    <label for="email"><b>Email :</b></label>
                    <input type="email" value="{{ old('email') }}" class="form-control" name="email" placeholder="Adresse email du patient">
                </div>

                <div class="col-sm-6 pb-3">
                    <label for="exampleLast"><b>Profession :</b></label>
                    <input type="text" value="{{ old('profession') }}" class="form-control" name="profession" placeholder="Profession du patient">
                </div>

                <div class="col-sm-4 pb-3">
                    <label for="adresse"><b>Adresse :</b></label>
                    <input type="text" class="form-control" value="{{ old('adresse') }}" name="adresse" placeholder="Adresse du patient">
                </div>

                <div class="col-sm-6 pb-3">
                    <label for="personne_confiance"><b>Personne de confiance :</b></label>
                    <input type="text" class="form-control" value="{{ old('personne_confiance') }}" name="personne_confiance" placeholder="Personne de confiance">
                </div>

                <div class="col-sm-4 pb-3">
                    <label for="tel_personne_confiance"><b>Téléphone personne de confiance :</b></label>
                    <input type="number" class="form-control" value="{{ old('tel_personne_confiance') }}" name="tel_personne_confiance" placeholder="Téléphone personne de confiance">
                </div>

                <div class="col-sm-6 pb-3">
                    <label for="personne_contact"><b>Personne à contacter :</b></label>
                    <input type="text" class="form-control" value="{{ old('personne_contact') }}" name="personne_contact" placeholder="Personne à contacter">
                </div>

                <div class="col-sm-4 pb-3">
                    <label for="tel_personne_contact"><b>Téléphone personne à contacter :</b></label>
                    <input type="number" class="form-control" value="{{ old('tel_personne_contact') }}" name="tel_personne_contact" placeholder="Téléphone personne à contacter">
                </div>

                <div class="row col-md-10">
                    <button type="submit" class="btn btn-primary btn-md col-sm-4" style="width: 50%;"><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
    </body>

@stop
