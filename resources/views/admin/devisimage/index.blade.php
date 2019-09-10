@extends('layouts.admin')

@section('title', 'CMCU | Liste des examens')

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
            <h1 class="text-center">LISTE DES EXAMENS</h1>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        @include('partials.flash')
                        <table id="myTable" class="table table-bordred table-striped">
                            <thead>
                            @can('print', \App\Patient::class)
                           
                            <th>DEVIS</th>
                            <th>CONSULTER</th>
                            <th>AJOUTER</th>
                            @endcan
                            </thead>
                            <tbody>
                            
                             @foreach($devisimages as $devisimage)
                                 <tr>
                                 
                                 <td>{{ $devisimage->devis_p }}</td>
                                         
                                                @can('consulter', \App\Patient::class)
                                                        <td style="display: inline-flex;">
                                                            <a href="{{ route('devisimage.show', $devisimage->id) }}" title="consulter les devis du patient" class="btn btn-primary btn-xs mr-1"><i class="fas fa-eye"></i></a>
                                                        </td>
                                                @endcan
                                                    @can('consulter', \App\Patient::class)
                                                        <td>
                                                            <a href="{{ route('devisimage.create') }}" title="ajouter un devis" class="btn btn-info btn-xs mr-1"><i class="far fa-calendar-plus"></i></a>
                                                        </td>
                                                @endcan
                                               
                                    </tr>
                            
                             @endforeach 
                                 
           
                            </tbody>
                        </table>
                        <br>
                        <div class="col-md-12 text-center">

                        <a href="{{ route('devisimage.index') }}" class="btn btn-success float-right"><i class="fas fa-arrow-left"></i>  Retour à la liste des devis</a>
</div>
                        <div class="clearfix"></div>
                        {{--{{ $patients->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
        @can('print', \App\Patient::class)
            <div class="col-md-12 text-center">

                <a href="{{ route('devisimage.create') }}" class="btn btn-primary" title="Vous allez jouter un nouveau devis">Ajouter un devis</a>

            </div>
        @endcan
        </div>
    </div>
    @endcan
    <script>
        function myFunction() {
            if(!confirm("Veuillez confirmer la suppréssion "))
                event.preventDefault();
        }
    </script>
    </body>
@stop
