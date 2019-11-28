@extends('layouts.admin') @section('title', 'CMCU | Ajouter une fiche de stisfaction') @section('content')
<body>
{{--<div class="se-pre-con"></div>--}}
<div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <div class="container">
        <h1 class="text-center">AJOUTER UNE FICHE DE SATISFACTION</h1>
        <hr>
        @include('partials.flash')
        @include('partials.flash_form')
        <div class="col-md-6">
            <form method="post" action="{{ route('fiches.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">NOM:</label>
                    <input type="text" class="form-control" name="nom" placeholder="facultatif" />
                </div>
                <div class="form-group">
                    <label for="prenom">PRENOM :</label>
                    <input type="text" class="form-control" name="prenom" placeholder="facultatif" />
                </div>
                <div class="form-group">
                    <label for="chambre_numero">NUMERO DE CHAMBRE :</label>
                    <input type="text" class="form-control" name="chambre_numero" placeholder="facultatif" />
                </div>
                <div class="form-group">
                    <label for="age">AGE :</label>
                    <input type="text" class="form-control" name="age" placeholder="facultatif" />
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">SERVICE</label>
                    <select class="form-control" name="service" id="exampleFormControlSelect1">
                        <option>URGENCE</option>
                        <option>AMBULLATOIRE</option>
                        <option>HOSPITALISATION</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">INFIRMIER EN CHARGE :</label>
                    <input type="text" class="form-control" name="infirmier_charge" />
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">ACCUEIL</label>
                    <select class="form-control" name="accueil" id="exampleFormControlSelect1">
                        <option>EXCELLENT</option>
                        <option>TRES BIEN</option>
                        <option>BIEN</option>
                        <option>PASSABLE</option>
                        <option>MEDIOCRE</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">RESTAURANT </label>
                    <select class="form-control" name="restauration" id="exampleFormControlSelect1">
                        <option>EXCELLENT</option>
                        <option>TRES BIEN</option>
                        <option>BIEN</option>
                        <option>PASSABLE</option>
                        <option>MEDIOCRE</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">CHAMBRE </label>
                    <select class="form-control" name="chambre" id="exampleFormControlSelect1">
                        <option>EXCELLENT</option>
                        <option>TRES BIEN</option>
                        <option>BIEN</option>
                        <option>PASSABLE</option>
                        <option>MEDIOCRE</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">SOINS</label>
                    <select class="form-control" name="soins" id="exampleFormControlSelect1">
                        <option>EXCELLENT</option>
                        <option>TRES BIEN</option>
                        <option>BIEN</option>
                        <option>PASSABLE</option>
                        <option>MEDIOCRE</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">UNE NOTE :</label>
                    <input type="text" class="form-control" name="notes" placeholder="Entrer une note sur 10 " />
                </div>
                <div class="form-group">
                    <label for="bla" class="col-form-label text-md-right">Recommanderiez-vous le Centre Médico-Chirurgical d’Urologie à vos proches ? </label>
                    <br>
                    <input type="radio" id="" class="form-check-inline" name="quizz" value="Oui" required> Oui
                    <br>
                    <input type="radio" id="" class="form-check-inline" name="quizz" value="Non" required> Non
                    <br>
                </div>
                <div class="form-group">
                    <label for="quantity">REMARQUE ET SUGGESTION:</label>
                    <div >
                        <TEXTAREA name="remarque_suggestion" rows=4 cols=40>Valeur par défaut</TEXTAREA>
                    </div>
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-primary mr-2">ENREGISTRER</button>
                    <button class="btn btn-success float-left" >
                        <a href="{{ route('fiches.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Retour</a>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
@endsection
