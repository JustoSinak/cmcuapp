@extends('layouts.admin') @section('title', 'CMCU | Ajouter une fiche une chambre') @section('content')
    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
        @include('partials.header')
        <div class="container">
            <h1 class="text-center">AJOUTER UNE CHAMBRE</h1>
            <hr>
            @include('partials.flash')
            @include('partials.flash_form')
            <div class="col-md-6">
                <form method="post" action="{{ route('chambres.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name">NUMERO:</label>
                        <input type="text" class="form-control" name="numero"  />
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1">CATEGORIE</label>
                        <select class="form-control" name="categorie" id="exampleFormControlSelect1">
                            <option value="">Veuillez choisir la catégorie</option>
                            <!-- <option value="Classique">Classique</option>
                            <option value="vip">VIP</option>
                            <option value="bloc">Bloc</option> -->
                            <option value="classique" {{ $chambre->categorie == 'classique' ? 'selected' : '' }}>classique</option>
                            <option value="mvp" {{ $chambre->categorie == 'mvp' ? 'selected' : '' }}>mvp</option>
                            <option value="vip" {{ $chambre->categorie == 'vip' ? 'selected' : '' }}>vip</option>
                        </select>
                    </div>
                    <select class="form-control" name="prix" id="exampleFormControlSelect1">
                        <option>Cout de la chambre</option>
                        <!-- <option value="2500">2500</option>
                        <option value="5000">5000</option>
                        <option value="10000">10000</option>
                        <option value="0">0</option> -->
                        <option value="2500" {{ $chambre->prix == '2500' ? 'selected' : '' }}>2500</option>
                        <option value="5000" {{ $chambre->prix == '5000' ? 'selected' : '' }}>5000</option>
                        <option value="10000" {{ $chambre->prix == '10000' ? 'selected' : '' }}>10000</option>
                        <option value="0" {{ $chambre->prix == '0' ? 'selected' : '' }}>0</option>
                    </select>
                    <br>
                    <br>
                 <button type="submit" class="btn btn-primary ">ENREGISTRER</button>
                </form>
            </div>
        </div>
    </div>
    </body>
@endsection
