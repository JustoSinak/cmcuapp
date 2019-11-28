@extends('layouts.admin')

@section('title', 'CMCU | Modifier un rôle')

@section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
        @include('partials.header')

        <div class="container">
            <form action="{{ route('roles.store') }}" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        @include('partials.flash_form')
                    </div>
                </div>
                @csrf
                <h4 class="">Modification du rôle</h4>
                <small class="text-info" title="Le champs rôle est obligatoire et un rôle ne peut être enregistrer plusieurs fois"><i class="fas fa-info-circle"></i></small>
                <div class="row">
                    <div class="col-md-6">
                        <hr>
                    </div>
                </div>
                <label for="name">Nom du rôle <span class="text-danger">*</span></label>
                <br>
                <br>
                <input name="name" class="form-control col-md-6" type="text" value="{{ $role->name }}" required><br>

                <button type="submit" class="btn btn-primary btn-xs col-md-2" title="Valider votre enregistrement">Modifier</button>
                <a href="{{ route('roles.index') }}" class="btn btn-info btn-xs col-md-2" title="Annuller">Retour</a>
            </form>
        </div>

    </div>
    </div>
    </body>
@stop
