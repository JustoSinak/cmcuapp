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
        @can('devis', \App\User::class)
        <div class="container">
            <h1 class="text-center">DEVIS DÉTAILLÉ</h1>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        @include('partials.flash')
                        <table id="myTable" class="table table-bordred table-striped">
                            <thead>
                            <th>DESIGNATION</th>
                            <th>MONTANT</th>
                            <th>
                                ACTION
                                <a href="{{ route('devisd.create') }}" class="btn btn-primary float-right" title="Vous allez jouter les elements d'un nouveau devis"><i class="fas fa-plus-circle"></i></a>
                            </th>
                            </thead>
                            <tbody>

                            @foreach($devisd as $devi)
                                <tr>
                                    <td>{{ $devi->devis->nom}}</td>
                                    <td>{{ $total = array_sum(explode('/', $devi->prix)) }} FCFA</td>
                                    
                                    <td style="display: inline-flex;">
                                        <p data-placement="top" data-toggle="tooltip" title="Delete">
                                            <a class="btn btn-success btn-xs mr-1" title="Imprimer le devis" href="{{ route('devisd.pdf', $devi->id) }}"><i class="fas fa-print"></i></a>
                                        </p>
                                        @can('create', \App\Patient::class)
                                            <a href="{{ route('devis.edit', $devi->id) }}" class="btn btn-info mr-1" title="Attribuer le divis à un patient"><i class="far fa-edit"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
{{--        @can('print', \App\Patient::class)--}}
{{--            <div class="col-md-12 text-center">--}}

{{--                <form class="form-group" method="post" action="{{ route('devisd.pdf') }}">--}}
{{--                    @csrf--}}
{{--                    <div class="input-group mb-3">--}}
{{--                        <select name="devis_id" class="form-control col-md-6" required>--}}
{{--                            <option value=""> Nom du devis</option>--}}
{{--                            @foreach ($devis as $devi)--}}
{{--                                <option value="{{ $devi->id }}"> {{ $devi->nom }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        <div class="input-group-append">--}}
{{--                            <button class="btn btn-primary">Imprimer</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        @endcan--}}

        </div>
    </div>
    @endcan
    
    </body>
@stop
