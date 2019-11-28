@extends('layouts.admin')
@section('title', 'CMCU | Ajouter un devis')
@section('content')
    <body>
    <div class="se-pre-con"></div>
    <div class="wrapper">
    @include('partials.side_bar')
    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">IMPORTER UN DEVIS </h1>
            <hr>
            @include('partials.flash_form')
            <div class="card" style="width: 40rem;">
                <div class="card-body">
                    <h5 class="card-title">Ajouter un devis</h5>
                    <small class="text-info" title="Les champs marqués par une étoile rouge sont obligatoire"><i class="fas fa-info-circle"></i></small>
                    <hr>
                    
                    <form class="form-group col-md-10" method="post" action="{{ route('devisimage.store') }}" enctype="multipart/form-data">
                        <div class="form-group">
                            @csrf
                         <table class="table table-user-information ">
                           <tbody>
                                <tr>
                                <td><b>Devis prévisionnel :</b></td>
                                        <td>
                                            <select class="form-control" name="devis_p">
                                                <option> Sélectionner un devis</option>
                                                @foreach ($devis as $devi)
                                                    <option
                                                        value="{{ $devi->nom }} &nbsp; ({{ $devi->total3 }} FCFA)" {{old("devis_p") ?: '' ? "selected": ""}}>{{ $devi->nom }} &nbsp;({{ $devi->total3 }} FCFA )
                                                    </option>
                                                @endforeach
                                            </select>

                                        </td>
                                </tr>
                            </tbody>
                          </table>
                       
                        </div>
                        <label for="image">Image  <span class="text-danger"></span></label>
                        <input type="file" class="form-control" class="custum-file-input" name="image" value="{{ old('image') }}"  required/>
                        
                </br>
                <button type="submit" class="btn btn-primary btn-lg col-sm-4" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;Ajouter</button>
                <a href="{{ route('devisimage.index') }}" class="btn btn-warning btn-lg col-md-5 offset-md-1" title="Retour à la liste des devis">Annuler</a>
                </form>
           
        </div>
    </div>
    </div>
    </div>
    </body>
@stop
