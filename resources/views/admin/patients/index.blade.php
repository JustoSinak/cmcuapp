@extends('layouts.admin')

@section('title', 'CMCU | Liste des patients')

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
            <h1 class="text-center">LISTE DES PATIENTS</h1>
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
                                NUMERO
                            </th>
                            <th>NOM </th>
                            <th>PRENOM</th>
                            <th>Assurance</th>
                            <th>DATE DE CREATION</th>
                            <th>ACTION</th>
                            </thead>
                            <tbody>

                            @foreach($patients as $patient)
                                <tr>
                                    <td>CMCU - {{ $patient->numero_dossier }}</td>
                                    <td>{{ $patient->name }}</td>
                                    <td>{{ $patient->prenom }}</td>
                                    <td>{{ $patient->prise_en_charge }}</td>
                                    <td>{{ $patient->date_insertion}}</td>
                                    <td style="display: inline-flex;">
                                    @can('consulter', \App\Patient::class)
                                        <a href="{{ route('patients.show', $patient->id) }}" title="consulter le dossier du patient" class="btn btn-primary btn-xs mr-1"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('events.create', $patient->id) }}" title="Prendre un rendez-vous" class="btn btn-info btn-xs mr-1"><i class="far fa-calendar-plus"></i></a>
                                        <a href="{{ route('examens.create', $patient->id) }}" title="Ajouter examens medicaux" class="btn btn-info btn-xs mr-1"><i class="fas fa-book"></i></a>
                                    @endcan
                                    @can('print', \App\Patient::class)
                                        <p data-placement="top" data-toggle="tooltip" title="Delete">
                                            <a class="btn btn-success btn-xs mr-1" title="Générer la facture" href="{{ route('consultation.pdf', $patient->id) }}" onClick='if(this.disabled){ return false; } else { this.disabled = true; }'><i class="far fa-plus-square"></i></a>
                                        </p>
                                    @endcan
                                    @can('delete', \App\Patient::class)
                                        <form action="{{ route('patients.destroy', $patient->id) }}" method="post">
                                            @csrf @method('DELETE')
                                            <p data-placement="top" data-toggle="tooltip" title="Delete">
                                                <button type="submit" class="btn btn-danger btn-xs mr-1" title="Supprimer le dossier du patient"  onclick="return myFunction()"><i class="fas fa-trash-alt"></i></button>
                                            </p>
                                        </form>
                                    @endcan
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                        {{--{{ $patients->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
        @can('print', \App\Patient::class)
            <div class="col-md-12 text-center">

                <a href="{{ route('patients.create') }}" class="btn btn-primary" title="Vous allez jouter un nouveau patient dans le système">Ajouter un patient</a>

            </div>
        @endcan

        </div>
    </div>
    @endcan
    <script>
        function myFunction() {
            if(!confirm("Veuillez confirmer la suppréssion du dossier patient"))
                event.preventDefault();
        }
    </script>
    </body>
@stop
