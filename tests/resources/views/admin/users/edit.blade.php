@extends('layouts.admin') @section('title', 'CMCU | Modifier un utilisateur') @section('content')

<body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
        @include('partials.side_bar')

        <!-- Page Content Holder -->
        @include('partials.header')
        <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">MODIFIER UN UTILISATEUR</h1>
            <hr>

            <div class="card" style="width: 50rem; margin-left: 150px;">
                <div class="card-body">
                    <small class="text-info" title="Les champs marqués par une étoile rouge sont obligatoire"><i class="fas fa-info-circle"></i></small>
                    @include('partials.flash_form')
                    <form class="form-group" action="{{ route('users.update', $user->id) }}" method="POST">
                        {{method_field('PATCH')}} {{csrf_field()}}
                        <div class="col-md-12">

                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="name" class="col-form-label text-md-right">Nom <span class="text-danger">*</span></label>
                                    <input name="name" class="form-control" value="{{ $user->name }}" type="text" placeholder="Nom" required>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="prenom" class="col-form-label text-md-right">Prénom <span class="text-danger">*</span></label>
                                    <input name="prenom" class="form-control" value="{{ $user->prenom }}" type="text" placeholder="Prénom">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="sexe" class="col-form-label text-md-right">Sexe <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <label class="mx-2 bx-2"><input type="radio" name="sexe" value="Homme"  @if($user->sexe == 'Homme') checked @endif required>Homme</label>
                                        <label class="mx-2 bx-2"><input type="radio" name="sexe" value="Femme"  @if($user->sexe == 'Femme') checked @endif required>Femme</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="telephone" class="col-form-label text-md-right">Téléphone <span class="text-danger">*</span></label>
                                    <input name="telephone" id="telephone" type="tel" value="{{ $user->telephone }}" class="form-control" placeholder="Téléphone" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="lieu_naissance" class="col-form-label text-md-right">Lieu De Naissance <span class="text-danger">*</span></label>
                                    <input name="lieu_naissance" value="{{ $user->lieu_naissance }}" class="form-control" placeholder="Lieu de naissance" required>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="date_naissance" class="col-form-label text-md-right">Date De Naissance <span class="text-danger">*</span></label>
                                    <input name="date_naissance" type="date" value="{{ $user->date_naissance }}" class="form-control" placeholder="Date de naissance" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label class="col-form-label" for="roles">Rôle <span class="text-danger">*</span></label>
                                    <select name="roles" class="form-control" id="exampleFormControlSelect1">
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-5">
                                    <label for="login" class="col-form-label">Login <span class="text-danger">*</span></label>
                                    <input name="login" class="form-control" value="{{ $user->login }}" type="text" placeholder="Login" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <label for="password" class="col-form-label text-md-right">Nouveau Mot De Passe <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-5">
                                    <label for="password" class="col-form-label text-md-right">Confirmer Mot De Passe <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <input name="password" type="password" class="form-control" id="password" placeholder="Nouveau Mot De Passe" required>
                                </div>
                                <div class="form-group col-md-5">
                                    <input id="confirm_password" type="password" class="form-control" name="password_confirmation" placeholder="Confirmer Mot De Passe" required>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-default" type="button" onclick="show_password()"><i id="show_pass" class="fas fa-eye"></i></button>
                                </div>
                                <div class="col-md-1">
                                    <span id='message' class="ml-1 align-text-bottom"></span>
                                </div>
                            </div>


                            <br>
                            <button type="submit" class="btn btn-primary btn-lg col-md-5" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;Modifier</button>
                            <a href="{{ route('users.index') }}" class="btn btn-warning btn-lg col-md-5 offset-md-1" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;Annuler</a>
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
            if (($('#password').val() == $('#confirm_password').val()) && $('#password').val()) {
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