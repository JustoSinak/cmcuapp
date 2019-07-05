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

            <div class="card" style="width: 50rem;">
                <div class="card-body">
                    <h5 class="card-title">Ajout d'un nouvel utilisateur</h5>
                    <small class="text-info" title="Les champs marqués par une étoile rouge sont obligatoire"><i class="fas fa-info-circle"></i></small>
                    <hr>
                    @include('partials.flash_form')
                    <form class="form-group" action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="col-md-12">

                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="name" class="col-form-label text-md-right">Nom <span class="text-danger">*</span></label>
                                    <input name="name" class="form-control" value="{{ old('name') }}" type="text" placeholder="Nom" required>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="prenom" class="col-form-label text-md-right">Prénom <span class="text-danger">*</span></label>
                                    <input name="prenom" class="form-control" value="{{ old('prenom') }}" type="text" placeholder="Prénom">
                                </div>
                            </div>

                            <label for="sexe" class="col-form-label text-md-right">Sexe <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <label class=""><input type="radio" name="sexe" value="Homme" {{ (old('sexe') == 'Homme') ? 'checked' : '' }} required>Homme</label>
                                <label class=""><input type="radio" name="sexe" value="Femme" {{ (old('sexe') == 'Femme') ? 'checked' : '' }} required>Femme</label>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="lieu_naissance" class="col-form-label text-md-right">Lieu de naissance <span class="text-danger">*</span></label>
                                    <input name="lieu_naissance" value="{{ old('lieu_naissance') }}" class="form-control" placeholder="Lieu de naissance" required>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="date_naissance" class="col-form-label text-md-right">Date de naissance <span class="text-danger">*</span></label>
                                    <input name="date_naissance" type="date" value="{{ old('date_naissance') }}" class="form-control" placeholder="Date de naissance" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="telephone" class="col-form-label text-md-right">Téléphone <span class="text-danger">*</span></label>
                                    <input name="telephone"  id="telephone" type="tel" value="{{ old('telephone') }}" class="form-control" placeholder="Téléphone" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label class="col-form-label" for="roles">ROLE <span class="text-danger">*</span></label>
                                    <select name="roles" class="form-control" id="exampleFormControlSelect1">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}"  {{ $role->id == ' ' ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-5">
                                    <label for="login" class="col-form-label">Login <span class="text-danger">*</span></label>
                                    <input name="login" class="form-control" value="{{ old('login') }}" type="text" placeholder="Login" required>
                                </div>
                            </div>

                            <label for="password" class="col-form-label text-md-right">Mot de passe et confirmation de mot de passe <span class="text-danger">*</span></label>
                            <div class="row">
                               <div class="input-group col-md-5">
                                   <input name="password" type="password" class="form-control" id="myInput" placeholder="Mot mot de passe" required>
                                   <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="show_password()"><i class="fas fa-eye-slash"></i></button>
                                </span>
                               </div>
                               <div class="input-group col-md-6">
                                   <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Mot de passe de confimation" required>
                               </div>
                           </div>

                            <br>
                            <button type="submit" class="btn btn-primary btn-lg col-md-5" title="Valider votre eregistrement">Ajouter</button>
                            <a href="{{ route('users.index') }}" class="btn btn-warning btn-lg col-md-5 offset-md-1" title="Retour à la liste des utilisateurs">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <script type="text/javascript">
        function show_password() {
            var x = document.getElementById("myInput");
            var y = document.getElementById("password-confirm");
            if (x.type === "password" | y.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
    </script>
    </body>
@stop
