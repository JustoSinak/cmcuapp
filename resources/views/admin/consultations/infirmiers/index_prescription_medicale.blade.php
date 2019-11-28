@extends('layouts.admin')

@section('title', 'CMCU | Prescriptions médicale')

@section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        @can('show', \App\User::class)
            <div class="container">
                <h1 class="text-center">PRESCRIPTIONS MEDICALES</h1>
                <hr>
            </div>
            <div class="col-md-3 offset-md-8 text-center">
            </div>
            <div class="container">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped table-bordered dt-responsive display nowrap td-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>DATE</th>
                                <th>MEDICAMENT</th>
                                <th>POSOLOGIE</th>
                                <th>H</th>
                                <th>VOIE</th>
                                <th>M</th>
                                <th>AM</th>
                                <th>S</th>
                                <th>N</th>
                                <th>PLANIFIER</th>
                                <th>IDE</th>
                            </tr>
                            <tbody>
                            @foreach ($prescription_medicales as $prescription_medicale)
                                <tr>
                                    <td>{{ $prescription_medicale->date }}</td>
                                    <td>{{ $prescription_medicale->medicament }}</td>
                                    <td>{{ $prescription_medicale->posologie }}</td>
                                    <td>{{ $prescription_medicale->heure }} H</td>
                                    <td>{{ $prescription_medicale->voie }}</td>
                                    <td>{{ $prescription_medicale->matin }}</td>
                                    <td>{{ $prescription_medicale->apre_midi }}</td>
                                    <td>{{ $prescription_medicale->soir }}</td>
                                    <td>{{ $prescription_medicale->nuit }}</td>
                                    <td>{{ $prescription_medicale->user->name }}</td>
                                    <td><button title="V" class="btn btn-primary"><i class="fas fa-eye"></i></button></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @can('infirmier', \App\Patient::class)
                    <button type="button" class="btn btn-primary"
                            data-toggle="modal" data-target="#PrescriptionMedicale"
                            data-whatever="@mdo">
                        <i class="fas fa-eye"></i>
                        Nouveau enregistrement
                    </button>
                    @endcan
                </div>
            </div>
    </div>
    </div>
    @include('admin.consultations.infirmiers.form.prescription_medicale_form')
    @endcan

    </body>

@endsection
