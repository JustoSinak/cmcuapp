@extends('layouts.admin')
@section('title', 'CMCU | Ajouter un utilisateur')
@section('content')

<body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
        @include('partials.side_bar')
        <!-- Page Content Holder -->
        @include('partials.header')
        <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">AJOUTER UN UTILISATEUR</h1>
            <hr>

            <div class="card" style="width: 50rem; margin-left: 150px;">
                <div class="card-body">
                    <small class="text-info" title="Les champs marqués par une étoile rouge sont obligatoire"><i class="fas fa-info-circle"></i></small>
                    @include('partials.flash_form')
                    <form class="mb-3" action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="col-md-12">

                            <div class="row">
                                <div class="mb-3 col-md-5">
                                    <label for="name" class="col-form-label text-md-end">Nom <span class="text-danger">*</span></label>
                                    <input name="name" class="form-control" value="{{ old('name') }}" type="text" placeholder="Nom" required>
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label for="prenom" class="col-form-label text-md-end">Prénom <span class="text-danger">*</span></label>
                                    <input name="prenom" class="form-control" value="{{ old('prenom') }}" type="text" placeholder="Prénom">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-5">
                                    <label for="lieu_naissance" class="col-form-label text-md-end">Lieu De Naissance <span class="text-danger">*</span></label>
                                    <input name="lieu_naissance" value="{{ old('lieu_naissance') }}" class="form-control" placeholder="Lieu de naissance" required>
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label for="date_naissance" class="col-form-label text-md-end">Date De Naissance <span class="text-danger">*</span></label>
                                    <input name="date_naissance" type="date" value="{{ old('date_naissance') }}" class="form-control" placeholder="Date de naissance" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <label for="sexe" class="col-form-label text-md-end">Sexe <span class="text-danger">*</span></label>
                                    <div class="mb-3">
                                        <label class="mx-2 bx-2"><input type="radio" name="sexe" value="Homme" {{ (old('sexe') == 'Homme') ? 'checked' : '' }} required>Homme</label>
                                        <label class="mx-2 bx-2"><input type="radio" name="sexe" value="Femme" {{ (old('sexe') == 'Femme') ? 'checked' : '' }} required>Femme</label>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label for="telephone" class="col-form-label text-md-end">Téléphone <span class="text-danger">*</span></label>
                                    <input name="telephone" id="telephone" type="tel" value="{{ old('telephone') }}" class="form-control" placeholder="Téléphone" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-5">
                                    <label class="col-form-label" for="roles">Rôle <span class="text-danger">*</span></label>
                                    <select name="roles" class="form-select" id="roles"required>
                                        <option value="1">ADMINISTRATEUR</option>
                                        <option value="2">MEDECIN</option>
                                        <option value="3">GESTIONNAIRE</option>
                                        <option value="4">INFIRMIER</option>
                                        <option value="5">LOGISTIQUE</option>
                                        <option value="6">SECRETAIRE</option>
                                        <option value="7">PHARMACIEN</option>
                                        <option value="8">QUALITE</option>
                                        <option value="9">COMPTABLE</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-5">
                                    <label for="login" class="col-form-label">Login <span class="text-danger">*</span></label>
                                    <input name="login" class="form-control" value="{{ old('login') }}" type="text" placeholder="Login" required>
                                </div>
                            </div>

                            <div class="row" id="otherFieldDiv">
                                <div class="mb-3 col-md-5">
                                    <label class="col-form-label" for="specialite">Spécialité <span class="text-danger">*</span></label>
                                    <input type="text" name="specialite" class="form-control" id="specialite">
                                </div>

                                <div class="mb-3 col-md-5">
                                    <label class="col-form-label" for="onmc" class="">Onmc <span class="text-danger">*</span></label>
                                    <input name="onmc" id="onmc" class="form-control" value="{{ old('onmc') }}" type="text" placeholder="onmc">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <label for="password" class="col-form-label text-md-end">Mot De Passe <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-5">
                                    <label for="password" class="col-form-label text-md-end">Confirmer Mot De Passe <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-5">
                                    <input name="password" type="password" class="form-control" id="password" placeholder="Mot De Passe" required>
                                </div>
                                <div class="mb-3 col-md-5">
                                    <input id="confirm_password" type="password" class="form-control" name="password_confirmation" placeholder="Confirmer Mot De Passe" required>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-default" type="button" onclick="show_password()"><i id="show_pass" class="fas fa-eye"></i></button>
                                </div>
                                <div class="col-md-1">
                                    <span id='message' class="ms-1 align-text-bottom"></span>
                                </div>
                            </div>

                            <br>
                            <input type="submit" class="btn btn-primary btn-lg col-md-5" title="Valider votre eregistrement" value="Ajouter">
                            <a href="{{ route('users.index') }}" class="btn btn-warning btn-lg col-md-5 offset-md-1" title="Retour à la liste des utilisateurs">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript">
        $('#password, #confirm_password').on('keyup', function() {
            if (($('#password').val() == $('#confirm_password').val()) && $('#password').val() ) {
                $('#message').html('<i class="fas fa-check fa-2x"></i>').css('color', 'green');
            } else
                $('#message').html('<i class="fas fa-times fa-2x"></i>').css('color', 'red');
        });

        function show_password() {
            var x = document.getElementById("password");
            var y = document.getElementById("confirm_password");
            if (x.type === "password" | y.type === "password") {
                x.type = "text";
                y.type = "text";
                $('#show_pass').removeClass('fa-eye');
                $('#show_pass').addClass('fa-eye-slash');
            } else {
                x.type = "password";
                y.type = "password";
                $('#show_pass').removeClass('fa-eye-slash');
                $('#show_pass').addClass('fa-eye');
            }
        }

        $("#roles").change(function() {
            if ($(this).val() == '2') {
                $('#otherFieldDiv').show();
                $('#specialite').attr('required', '');
                $('#onmc').attr('required', '');
            } else {
                $('#otherFieldDiv').hide();
                $('#specialite').removeAttr('required');
                $('#onmc').removeAttr('required');
            }
        });
        //$("#roles").trigger("change");
    </script>
</body>
@stop