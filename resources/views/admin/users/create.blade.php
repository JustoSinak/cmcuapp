@extends('layouts.admin')

@section('title', 'CMCU | Ajouter un utilisateur')

@section('content')

    <body>
    <div class="se-pre-con"></div>
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">AJOUTER UN UTILISATEUR</h1>
            <hr>
            <form class="form-group col-md-6" action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name" class="col-form-label text-md-right">{{ __('Nom') }}</label>
                        <input name="name" class="form-control" value="{{ old('name') }}" type="text" placeholder="Nom">
                    </div>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! $errors->first('name', '<span class="text-danger">:message</span>') !!}
                    </div>

                    <div class="form-group">
                        <label for="prenom" class="col-form-label text-md-right">{{ __('Prenom') }}</label>
                        <input name="prenom" class="form-control" value="{{ old('prenom') }}" type="text" placeholder="Prénom">
                    </div>
                    <div class="form-group {{ $errors->has('prenom') ? 'has-error' : '' }}">
                        {!! $errors->first('prenom', '<span class="text-danger">:message</span>') !!}
                    </div>

                    <div class="form-group">
                        <label for="login" class="col-form-label text-md-right">{{ __('Login') }}</label>
                        <input name="login" class="form-control" value="{{ old('login') }}" type="text" placeholder="Login">
                    </div>
                    <div class="form-group {{ $errors->has('login') ? 'has-error' : '' }}">
                        {!! $errors->first('login', '<span class="text-danger">:message</span>') !!}
                    </div>

                    <div class="form-group">
                        <label for="sexe" class="col-form-label text-md-right">{{ __('Sexe') }}</label>
                        <br>
                        <input type="radio" id="sexe" class="form-check-inline" name="sexe" value="Homme" required> Homme
                        <br>
                        <input type="radio" id="sexe" class="form-check-inline" name="sexe" value="Femme" required> Femme
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="sexe" class="col-form-label text-md-right">{{ __('Lieu de naissance') }}</label>
                        <input name="lieu_naissance" rows="2" value="{{ old('lieu_naissance') }}" class="form-control" placeholder="LIEU DE NAISSANCE">
                    </div>
                    <div class="form-group">
                        <label for="sexe" class="col-form-label text-md-right">{{ __('Telephone') }}</label>
                        <input name="telephone" type="tel" rows="2" value="{{ old('telephone') }}" class="form-control" placeholder="TELEPHONE">
                    </div>

                    <div class="form-group">
                        <label for="sexe" class="col-form-label text-md-right">{{ __('Date de naissance') }}</label>
                        <input name="date_naissance" type="date" rows="2" value="{{ old('date_naissance') }}" class="form-control" placeholder="DATE DE NAISSANCE">
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-form-label text-md-right">{{ __('Mot de passe') }}</label>
                        <input name="password" type="password" rows="2" class="form-control" id="myInput" placeholder="Mot mot de passe">
                        <input type="checkbox" onclick="myFunction()">Voire le mot de passe
                    </div>
                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        {!! $errors->first('password', '<span class="text-danger">:message</span>') !!}
                    </div>

                    <div class="form-group">
                    <label for="exampleFormControlSelect1">ROLE</label>
                    <select name="roles" class="form-control" id="exampleFormControlSelect1">
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}"  {{ $role->id == ' ' ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                    </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg col-md-5" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;Ajouter</button>
                    <a href="{{ route('users.index') }}" class="btn btn-warning btn-lg col-md-5 offset-md-1" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;Annulé</a>
                </div>
            </form>
        </div>
        <hr>
    </div>
    <script type="text/javascript">
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
    </body>

@stop
