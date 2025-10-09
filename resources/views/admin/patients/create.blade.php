@extends('layouts.admin')

@section('title', 'CMCU | Ajouter un dossier patient')

@section('content')

<body>
    <div class="se-pr-con"></div>
    <div class="wrapper">
        @include('partials.side_bar')

        <!-- Page Content Holder -->
        @include('partials.header')
        <!--// top-bar -->
        <div class="row mb-1">
            <div class="col-sm-12">
                <h1 class="text-center ">AJOUTER UN DOSSIER PATIENT</h1>
            </div>
        </div>
        <hr>
        <div class="container">
            @include('partials.flash_form')

            <div class="card" style="width: 40rem;">
                <div class="card-body">
                    <h5 class="card-title">Ajouter un patient</h5>
                    <small class="text-info" title="Les champs marqués par une étoile rouge sont obligatoire"><i class="fas fa-info-circle"></i></small>
                    <hr>
                    <form class="form-group col-md-10" action="{{ route('patients.store') }}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <b>Médecin :</b> <span class="text-danger">*</span>

                                <select class="form-control" name="medecin_r" id="medecin_r" required>
                                    <option value="medecin_r"> Nom du médecin</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->name }} {{ $user->prenom }}" {{(old("medecin_r") ?: '' )? "selected": ""}}>{{ $user->name }} {{ $user->prenom }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-form-label text-md-right">Nom <span class="text-danger">*</span></label>
                                <input name="name" class="form-control" value="{{ old('name') }}" type="text" placeholder="Nom" required>
                            </div>
                            <div class="form-group">
                                <label for="prenom" class="col-form-label text-md-right">Prenom <span class="text-danger">*</span></label>
                                <input name="prenom" class="form-control" value="{{ old('prenom') }}" type="text" placeholder="prenom">
                            </div>

                            <div class="form-group">
                                <label for="motif" class="col-form-label text-md-right">Motif : <span class="text-danger">*</span></label>
                                <select class="form-control" name="motif" id="motif" onchange="new_ckChange(this)">
                                    <option selected>Consultation</option>
                                    <option>Acte</option>
                                    <option>Examen</option>
                                    <option>Autres</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="details_motif" id="label_details_motif" class="col-form-label text-md-right">Détails motif</label>
                                <input name="details_motif" id="details_motif" class="form-control" value="{{ old('details_motif') ?? 'Consultation'}}" type="text" placeholder="Précisez le motif">
                            </div>

                            <div class="form-group">
                                <label for="montant" class="col-form-label text-md-right">Montant <span class="text-danger">*</span></label>
                                <input name="montant" class="form-control" value="{{ old('montant') }}" type="number" placeholder="montant">
                            </div>
                            <div class="form-group">
                                <label for="avance" class="col-form-label text-md-right">avance <span class="text-danger">*</span></label>
                                <input name="avance" class="form-control" value="{{ old('avance') }}" type="text" placeholder="avance">
                            </div>
                            <div class="form-group">
                                <label for="demarcheur"> Démarcheur : <span class="text-danger"></span></label>
                                <select class="form-control" name="demarcheur" id="demarcheur">
                                    <option></option>
                                    <option>DMH</option>
                                </select>
                            </div>
                            <div class="form-group">

                                <div class="form-group">
                                    <label for="assurance" class="col-form-label text-md-right">Assurance</label>
                                    <input name="assurance" class="form-control" value="{{ old('assurance') }}" type="text" placeholder=" nom de l'assurance si le patient est assuré">
                                </div>

                                <div class="form-group">
                                    <label for="numero_assurance" class="col-form-label text-md-right">Numéro d'assurance</label>
                                    <input name="numero_assurance" class="form-control" value="{{ old('numero_assurance') }}" type="text" placeholder="Numéro d'assurance si le patient est assuré">
                                </div>

                                <div class="form-group">
                                    <label for=" prise_en_charge" class="col-form-label text-md-right"> Taux de Prise en Charge : <span class="text-danger"></span></label>
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="prise_en_charge" id="prise_en_charge" required>
                                            @foreach(range(0, 100) as $taux)
                                            <option>{{$taux}}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"> % </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m_paiement">
                                    <label for="mode_paiement">Moyen de paiement <span class="text-danger">*</span></label>
                                    <select name="mode_paiement" id="mode_paiement" class="form-control">

                                        <optgroup label="Monaie électronique">
                                            <option value="orange money">Orange Money</option>
                                            <option value="mtn mobile money">MTN Mobile Money</option>
                                        </optgroup>
                                        <optgroup label="Autres moyens">
                                            <option selected value="espèce">Espèce</option>
                                            <option value="chèque">Chèque</option>
                                            <option value="virement">Virement</option>
                                            <option value="bon de prise en charge">Bon de prise en charge</option>
                                            <option value="autre">Autre</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="assurance" class="col-form-label text-md-right">Date Création <span class="text-danger">*</span></label>
                                    <input type="date" name="date_insertion" class="form-control" value="{{ old('date_insertion') }}" placeholder=" date de création du dossier au cmcu" required>
                                </div>

                            </div>

                            </br>

                            <button type="submit" class="btn btn-primary btn-lg col-md-5" title="En cliquant sur ce bouton vous enregistrer un nouveau patient">Ajouter</button>
                            <a href="{{ route('patients.index') }}" class="btn btn-warning btn-lg col-md-5 ms-2" title="Retour à la liste des patients">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>
@section('script')
<script>
    function new_ckChange(ckType) {

        var motif = document.getElementById('motif');
        var choix = motif[motif.selectedIndex].value;
        if (choix == 'Consultation') {
            document.getElementById("label_details_motif").innerText = 'Détail motif';
            document.getElementById("details_motif").value = "Consultation";
        } else {
            document.getElementById("details_motif").value = "";
        }
        if (choix == 'Acte' || choix == 'Examen') {
            document.getElementById("label_details_motif").innerText = 'Type ' + choix.toLowerCase();
        }
        if (choix == 'Autres') {
            document.getElementById("label_details_motif").innerText = 'Détails motif';
        }

    }
</script>

@stop