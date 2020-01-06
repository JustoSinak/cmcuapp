@extends('layouts.admin') @section('title', 'CMCU | dossier patient') @section('content')

<style>
    .grid-container {
        display: grid;
        grid-gap: 30px 60px;
        grid-template-columns: auto auto auto;
        padding: 10px;
    }

    .grid-item {
        background-color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(0, 0, 0, 0.8);
        padding: 10px;
        font-size: 12px;
        margin-right: 1px;
    }

    .table-sortable tbody tr {
        cursor: move;
    }
</style>

<body>

    <div class="wrapper">
        @include('partials.side_bar')

        <!-- Page Content Holder -->
        @include('partials.header') @can('show', \App\User::class) 
        <div class="container">
            <div class="row">
                <div class="col-md-12  toppad  offset-md-0 mb-2">
                    @include('admin.patients.partials.menu')
                    <a href="{{ route('patients.index') }}" class="btn btn-success float-right" title="Retour à la liste des patients">
                        <i class="fas fa-arrow-left"></i> Retour à la liste des patients
                    </a>
                </div>
                {{-- PRESENTATION DU DOSSIER PATIENT --}} @if(auth()->user()->role_id == 6)

                <div class="col-md-12  offset-md-0  toppad">
                    @endif @if(auth()->user()->role_id == 2)
                    <div class="col-md-10  offset-md-0  toppad">
                        @endif @if(auth()->user()->role_id == 4)
                        <div class="col-md-10  offset-md-0  toppad">
                            @endif
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title text-danger text-center">DOSSIER PATIENT</h2>
                                    
                                    <table class="table table-user-information table-hover ">
                                        
                                        <div class=" row justify-content-center mb-2">
                                            <button class="btn btn-secondary mr-2" title="Cacher / Afficher les données personelles du patient" onclick="ShowDetailsPatient()"><i class="fas fa-eye"></i> Détails Personnels
                                            </button>
                                            @can('secretaire', \App\Patient::class)
                                            <a href="{{ route('dossiers.create', $patient->id) }}" class="btn btn-info mr-2"><i class="fas fa-bars"></i> Completer le dossier</a>
                                            <button class="btn btn-secondary mr-2" title="Modifier le motif et le montant" onclick="ShoweditMotif_montant()"><i class="fas fa-edit"></i> Motif &amp; Montant</button>
                                            
                                            @endcan @can('med_inf_anes', \App\Patient::class)
                                            <a class="btn btn-dark mr-2" href="{{ route('prescription_medicale.index', $patient->id) }}" title="Prescriptions médicales">
                                                <i class="fas fa-book"></i> Prescriptions Medicales
                                            </a>
                                            @endcan @can('infirmier', \App\Patient::class)
                                            <a class="btn btn-danger" href="{{ route('consultations.create', $patient->id) }}" title="Nouvelle consultation du patient pour la prise des paramètres">
                                                <i class="fas fa-book"></i> Fiche De Paramètres
                                            </a>
                                            @endcan
                                            @can('medecin_secretaire', \App\Patient::class)
                                            <button class="btn btn-secondary mr-2" title="Gerer les images scannés des examens" onclick="Showexamen_scannes()"><i class="fas fa-image"></i> Images Scannées</button>
                                            @endcan
                                        </div>
                                        @include('partials.flash')
                                        @include('admin.consultations.partials.detail_patient') @include('admin.consultations.show_consultation')
                                        @include('admin.consultations.partials.motif_et_montant')
                                    </table>
                                    @include('admin.patients.partials.examens_scannes')
                                </div>
                            </div>
                            <br>
                        </div>
                        {{-- FIN DE PRESENTATION DU DOSSIER PATIENT --}} {{-- LES BOUTTONS DE MODAL IC --}} @if(auth()->user()->role_id == 6)
                        <div class="col-md-5  offset-md-0  toppad">
                            @endif @if(auth()->user()->role_id == 2)
                            <div class="col-md-2  offset-md-0  toppad">
                                @endif @if(auth()->user()->role_id == 4)
                                <div class="col-md-2  offset-md-0  toppad">
                                    @endif @can('med_inf_anes', \App\Patient::class)
                                    <div class="card">
                                        <div class="card-header mb-2">
                                            <small>DETAILS ACTION</small>
                                        </div>
                                        <div class="card-content">
                                            <button type="button" class="btn btn-primary btn-block mb-2" title="Liste des ordonnances pour ce patient" data-toggle="modal" data-target="#ordonanceAll" data-whatever="@mdo">
                                                <i class="fas fa-eye"></i> Ordonances
                                            </button>
                                            <button type="button" class="btn btn-primary btn-block mb-2" title="Liste des examens pour ce patient" data-toggle="modal" data-target="#biologieAll" data-whatever="@mdo">
                                                <i class="fas fa-eye"></i> Examens Biologiques
                                            </button>
                                            <button type="button" class="btn btn-primary btn-block mb-2" title="Liste des examens pour ce patient" data-toggle="modal" data-target="#imagerieAll" data-whatever="@mdo">
                                                <i class="fas fa-eye"></i> Examens Imageries
                                            </button>
                                            <a href="{{ route('examens.index') }}" class="btn btn-primary btn-block mb-2" title="Détails surveillance post-aneshésiste">
                                                <i class="fas fa-eye"></i> Résultats d'Examens
                                            </a>
                                            <a href="{{ route('surveillance_post_anesthesise.index', $patient->id) }}" class="btn btn-primary btn-block mb-2" title="Détails surveillance post-aneshésiste">
                                                <i class="fas fa-eye"></i> Surveillance Post-Anesthésique
                                            </a>
                                            <button type="button" class="btn btn-primary btn-block" title="Fiches d'intervention" data-toggle="modal" data-target="#FicheInterventionAll" data-whatever="@mdo">
                                                <i class="fas fa-eye"></i>Fiche d'Intervention

                                            </button>
                                            <a href="{{ route('dossiers.create', $patient->id) }}" class="btn btn-info btn-block mb-2">Completer Le Dossier</a> @if (count($patient->consultations)) @can('medecin', \App\Patient::class)
                                            <a class="btn btn-success btn-block" title="Imprimer la lettre de sortie" href="{{ route('print.sortie', $patient->id) }}">
                                                <i class="fas fa-print"></i> Lettre De Consultation
                                            </a>
                                            <button type="button" class="btn btn-primary btn-block mb-2" title="Liste de fiches pour ce patient" data-toggle="modal" data-target="#ficheSuiviAll" data-whatever="@mdo">
                                                <i class="fas fa-eye"></i> Fiche De Suivi
                                            </button>
                                            @endcan @endif
                                        </div>
                                    </div>
                                    @endcan {{--MODIFIER LES INFOS DU PATIENT IC --}} {{--@include('admin.patients.edit')--}} {{--FIN DE MOFIFICATION DES INFOS PATIENT --}}

                                </div>
                                {{-- FIN DES BOUTONS DE MODAL --}} {{-- TOUS LES MODAL IC --}} @include('admin.modal.feuille_precription_examen') @include('admin.modal.detail_premedication_preparation') @include('admin.modal.ordonance_show') @include('admin.modal.consultation_show') @include('admin.modal.index_examen_biologie') @include('admin.modal.index_examen_imagerie') @include('admin.modal.fiche_intervention_show') @include('admin.modal.fiche_intervention') @include('admin.modal.fiche_intervention_anesthesiste') @include('admin.modal.visite_preanesthesique') @include('admin.modal.surveillance_post_a') @include('admin.modal.fichede_suivi') {{-- FIN DE TOUS LES MODAL --}}

                            </div>
                        </div>
                        @endcan
                    </div>
                    <script>
                        function ShowDetailsPatient() {
                            var x = document.getElementById("myDIV");
                            var y = document.getElementById("editMotifMontform");
                            var z = document.getElementById("examens_scannes_form");
                            if (y.style.display === "contents") {
                                y.style.display = "none";
                            }
                            if (z.style.display === "contents") {
                                z.style.display = "none";
                            }
                            if (x.style.display === "none") {
                                x.style.display = "contents";
                            } else {
                                x.style.display = "none";
                            }
                        }

                        function ShoweditMotif_montant() {
                            var x = document.getElementById("editMotifMontform");
                            var y = document.getElementById("myDIV");
                            var z = document.getElementById("examens_scannes_form");
                            if (y.style.display === "contents") {
                                y.style.display = "none";
                            }
                            if (z.style.display === "contents") {
                                z.style.display = "none";
                            }
                            if (x.style.display === "none") {
                                x.style.display = "contents";
                            } else {
                                x.style.display = "none";
                            }
                        }

                        function Showexamen_scannes() {
                            var x = document.getElementById("editMotifMontform");
                            var y = document.getElementById("myDIV");
                            var z = document.getElementById("examens_scannes_form");
                            var t = document.getElementById("show_consultation");
                            if (y.style.display === "contents") {
                                y.style.display = "none";
                            }
                            if (x.style.display === "contents") {
                                x.style.display = "none";
                            }
                            if (t.style.display === "contents") {
                                t.style.display = "none";
                            }
                            if (z.style.display === "none") {
                                z.style.display = "contents";
                            } else {
                                z.style.display = "none";
                                t.style.display = "contents";
                            }
                        }
                    </script>
                    <script>
                        // Add the following code if you want the name of the file appear on select
                        $(".custom-file-input").on("change", function() {
                            var fileName = $(this).val().split("\\").pop();
                            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                        });
                    </script>
                    <script>
                        function handleFiles(files) {
                            var imageType = /^image\//;
                            for (var i = 0; i < files.length; i++) {
                                var file = files[i];
                                if (!imageType.test(file.type)) {
                                    alert("veuillez sélectionner une image");
                                } else {

                                    let form_parent = document.getElementById('preview');
                                    let img1 = document.getElementById("img1");
                                    let clone_img = img1.cloneNode(false);
                                    clone_img.file = file;
                                    clone_img.classList.add("obj");
                                    form_parent.replaceChild(clone_img, img1);
                                    var reader = new FileReader();
                                    reader.onload = (function(aImg) {
                                        return function(e) {
                                            aImg.src = e.target.result;
                                        };
                                    })(clone_img);

                                    reader.readAsDataURL(file);
                                }

                            }
                        }
                    </script>

</body>

@stop