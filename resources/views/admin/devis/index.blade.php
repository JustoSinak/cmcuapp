@extends('layouts.admin')

@section('title', 'CMCU | Liste des devis')

@section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        @can('create', \App\Patient::class)
        <div class="container">
            <h1 class="text-center">LISTE DES DEVIS</h1>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        @include('partials.flash')
                        <table id="myTable" class="table table-bordred table-striped">
                            <thead>
                            <th>
                                NOM
                            </th>
                           
                            <th>MONTANT TOTAL</th>
                            <th>DATE DE CREATION</th>
                            <th>ACTION</th>
                            </thead>
                            <tbody>

                            @foreach($devis as $devi)
                                <tr>
                                    <td>{{ $devi->nom}}</td>
                                    <td>{{ $devi->total3}}</td>
                                   
                                    <td>{{ $devi->created_at->toFormattedDateString() }}</td>
                                    
                                    <td style="display: inline-flex;">
                                   
                                    @can('create', \App\Patient::class)
                                        <a href="{{ route('devis.edit', $devi->id) }}" class="btn btn-info mr-1" title="Attribuer le divis à un patient"><i class="far fa-edit"></i></a>
                                    @endcan
                                   
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @can('create', \App\Patient::class)
            <div class="col-md-12 text-center">

                <a href="{{ route('devis.create') }}" class="btn btn-primary" title="Vous allez jouter un nouveau devis ">Ajouter un devis</a>

            </div>
        @endcan

        </div>
    </div>
    @endcan
    
    </body>
@stop
