@extends('layouts.admin') @section('title', 'CMCU | Nouvelle fiche') @section('content')

<body>
{{--<div class="se-pre-con"></div>--}}
<div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card bg-light card-body mb-3 card bg-faded p-1 mb-3">
                    <div class="row">
                        <div class="col-md-6 col-lg-8">
                            <p> <i class="glyphicon glyphicon-envelope"></i>{{ $fiche->nom }}</p><br>
                            <p> <i class="glyphicon glyphicon-envelope"></i>{{ $fiche->prenom }}</p><br>
                            <p> <i class="glyphicon glyphicon-envelope"></i>{{ $fiche->chambre_numero }}</p><br>
                            <p> <i class="glyphicon glyphicon-envelope"></i>{{ $fiche->age }}</p><br>
                            <p> <i class="glyphicon glyphicon-envelope"></i>{{ $fiche->service }}</p><br>
                            <p> <i class="glyphicon glyphicon-envelope"></i>{{ $fiche->infirmier_charge }}</p><br>
                            <p> <i class="glyphicon glyphicon-envelope"></i>{{ $fiche->accueil }}</p><br>
                            <p> <i class="glyphicon glyphicon-envelope"></i>{{ $fiche->restauration }}</p><br>
                            <p> <i class="glyphicon glyphicon-envelope"></i>{{ $fiche->chambre }}</p><br>
                            <p> <i class="glyphicon glyphicon-envelope"></i>{{ $fiche->soins }}</p><br>
                            <p> <i class="glyphicon glyphicon-envelope"></i>{{ $fiche->notes }}</p><br>
                            <p> <i class="glyphicon glyphicon-envelope"></i>{{ $fiche->quizz }}</p><br>
                            <p> <i class="glyphicon glyphicon-envelope"></i>{{ $fiche->remarque_suggestion }}</p><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-primary" >
        <a href="{{ route('fiches.index') }}">Retour</a>
    </button>
</div>
</body>

@stop
