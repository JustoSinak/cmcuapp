@extends('layouts.admin')
@section('title', 'CMCU | Renseignement du dossier patient')
@section('content')
    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')
    <!-- Page Content Holder -->
        @include('partials.header')
            <div class="container_fluid">
              <h1 class="text-center">COMPTE-RENDU OPERATOIRE - {{ $patient->name }} {{ $patient->prenom }} </h1>
              <hr>
          </div>
        <div class="container">
            <div class="row">
                <div class="col-md-10  toppad ">
                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-success float-right"><i
                            class="fas fa-arrow-left"></i> Retour au dossier patient</a>
                </div>
                <br>
                <br>
                <div class="col-md-10  toppad">
                    <div class="card">
                        <div class="card-body">
                            @include('partials.flash_form')
                            <small class="text-danger"><i><strong><i class="fas fa-exclamation-triangle"></i> Attention
                                        !! espace réservé au médecin</strong></i></small>
                            <table class="table table-user-information ">
                                <tbody>
                                    @include('admin.consultations.chirurgiens.form.compte_rendu_operatoire_form')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <script type="text/javascript">--}}
{{--        let splitLines = document.getElementsByClassName("splitLines")--}}
{{--        let textarea = [];--}}
{{--        for(let x=0; x<splitLines.length; x++){--}}
{{--            textarea[x] = splitLines[x];--}}
{{--            textarea[x].onkeyup = function () {--}}
{{--                var lines = textarea[x].value.split("\n");--}}
{{--                for (var i = 0; i < lines.length; i++) {--}}
{{--                    if (lines[i].length <= 67) continue;--}}
{{--                    var j = 0;--}}
{{--                    space = 67;--}}
{{--                    while (j++ <= 67) {--}}
{{--                        if (lines[i].charAt(j) === " ") space = j;--}}
{{--                    }--}}
{{--                    lines[i + 1] = lines[i].substring(space + 1) + (lines[i + 1] || "");--}}
{{--                    lines[i] = lines[i].substring(0, space);--}}
{{--                }--}}
{{--                textarea[x].value = lines.slice(0, 69).join("\n");--}}
{{--            };--}}
{{--        }--}}
{{--    </script>--}}
    </body>
@stop
