@extends('layouts.admin')
@section('title', 'CMCU | Renseignement du dossier patient')
@section('content')
  
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')
    <!-- Page Content Holder -->
        @include('partials.header')
        @can('chirurgien', \App\Patient::class)
        <form class="form-group col-md-6" action="{{ route('consultationsdesuivi.store') }}" method="post">
           
           <div class="form-group">
           @csrf
           <label for="interrogatoire" class="col-form-label text-md-right">Interrogatoire <span class="text-danger"></span></label>
            <textarea rows="10" cols="30" name="interrogatoire" class="form-control" value="{{ old('interrogatoire') }}" type="textarea" placeholder="interrogatoire" required>
            </textarea>
             </div>
             <div class="form-group">
           <label for="commentaire" class="col-form-label text-md-right">Commentaire <span class="text-danger"></span></label>
            <textarea rows="10" cols="30" name="commentaire" class="form-control" value="{{ old('commentaire') }}" type="textarea" placeholder="votre commentaire" required>
            </textarea>
             </div>
             <div class="form-group">
           <label for="date_creation" class="col-form-label text-md-right">Date <span class="text-danger"></span></label>
            <input name="date_creation" class="form-control" value="{{ old('date_creation') }}" type="date"  required>
           
             </div>
             <input name="patient_id" value="{{ $patient->id }}" type="hidden">
             <button type="submit" class="btn btn-primary btn-lg col-sm-4" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;Ajouter</button>
             <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-warning btn-lg col-md-5 offset-md-1" title="Retour à la liste des patients">Annuler</a>
             
        </form>
        @endcan
@stop
