@extends('layouts.admin') @section('title', 'CMCU | Liste des produits') @section('content')

    <body>
    <div class="se-pre-con"></div>
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->

        <div class="container">
            <h1 class="text-center">LISTE DES PRODUITS</h1>
        </div>
        <hr>
            <div class="col-md-3 offset-md-8 text-center">


                <a href="" class=" btn btn-danger " style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;
                    <h2>TOTAL PRODUIT :</h2>
                    <h1><P>{{ $produitCount }}</P> </h1>
                </a>
            </div>
        <div class="container">
            <div class="row">
                <div class="col-10 col-md-10 col-lg-8">
                    <form  action="/search" method="POST" role="search" class="card card-sm">
                        {{ csrf_field() }}
                        <div class="card-body row no-gutters align-items-center">
                            <div class="col-auto">
                                <i class="fas fa-search h4 text-body"></i>
                            </div>
                            <!--end of col-->
                            <div class="col">
                                <input class="form-control form-control-lg form-control-borderless" id="myInput" onkeyup="searchFunction()" type="text" class="form-control" name="q" placeholder="Rechercher un Produit">
                            </div>
                            <!--end of col-->
                            <div class="col-auto">
                                <button action="" class="btn btn-lg btn-danger" type="">Search</button>
                            </div>
                            <!--end of col-->
                        </div>
                    </form>
                </div>
                <!--end of col-->
            </div> </br>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        @include('partials.flash')
                        <table id="myTable" class="table table-bordred table-striped">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>DESIGNATION</td>
                                <td>CATEGORIE</td>
                                <td>QUANTITE STOCK</td>
                                <td>QUANTITE ALERTE</td>
                                <td>PRIX UNITAIRE</td>
                                <td>EDITER</td>
                                <td>SUPPRIMER</td>
                            </tr>
                            <tbody>
                            @foreach($produits as $produit)
                                <tr>
                                    <td>{{$produit->id}}</td>
                                    <td>{{$produit->designation}}</td>
                                    <td>{{$produit->categorie}}</td>
                                    <td>{{$produit->qte_stock}}</td>
                                    <td>{{$produit->qte_alerte}}</td>
                                    <td>{{$produit->prix_unitaire}}</td>
                                    <td><a href="{{ route('produits.edit', $produit->id)}}" title="Enregistrer une nouvelle entré en stock" class="btn btn-primary"><i class="far fa-edit"></i></a></td>
                                    <td>
                                        <form action="{{ route('produits.destroy', $produit->id) }}" method="post">
                                            @csrf @method('DELETE')
                                            <p data-placement="top" data-toggle="tooltip" title="Supprimer le produit du stock">
                                                <button type="submit" class="btn btn-danger btn-xs"  onclick="return myFunction()"><i class="fas fa-trash-alt"></i></button>
                                            </p>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $produits->links() }}
                    </div>

                </div>
            </div> </br>
            <div class="col-md-3 offset-md-4 text-center">
                <a href="{{ route('produits.create') }}" class="btn btn-primary" title="Enregistrement en stock d'un nouveau produit">Ajouter un produit</a>
            </div>
        </div>

    </div>
    <script src="{{ asset('admin/js/main.js') }}"></script>
    </body>

@endsection
