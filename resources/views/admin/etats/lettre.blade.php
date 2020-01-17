<html lang="fr">

<head>
    <title>LETTRE DE CONSULTATION {{ $consultations->patient->name.' '.$consultations->patient->prenom }}</title>
    <link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<?php setlocale(LC_TIME, 'French') ?>
<style>
    .cpi-titulo3 {
        font-size: 12px;
    }
    .logo{
        width: 100px;
    }
    p {
        line-height: 140%;
        text-align: justify;
    }
    hr {
        display: block; height: 1px;
        border: 0; border-top: 1px solid red;
        margin: 1em 0; padding: 0;
    }
    .footer {
        padding-top: 1px;
        padding-bottom: 15px;
        position:fixed;
        bottom:100px;
        width:100%;
    }

</style>
<div class="container-fluid">

    <div class="row">
        <div class="col-2">
            <img class="logo img-responsive float-left" src="{{ asset('admin/images/logo.jpg') }}">
        </div>
        <div class="col-7 offset-3">
            <div class="text-center">
                <p>CENTRE MEDICO-CHIRURGICAL D'UROLOGIE</p>
                <p>VALLEE MANGA BELL DOUALA-BALI</p>
                <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small>
                <p><small>www.cmcu-cm.com</small></p>
            </div>
        </div>
    </div>

    <div class="row">
        <hr class="text-danger">
    </div>

    <div class="row">
        <div class="col-4">
            <span>Dr <small>{{ $consultations->user->name.' '.$consultations->user->prenom }}</small></span><br>
            <span><small>{{ $consultations->user->specialite }}</small></span><br>
            <span>Onmc: <small>{{ $consultations->user->onmc }}</small></span>
        </div>
        <div class="col-5 offset-6">
{{--            <p><small><u>Date:</u><b> {{ $consultations->created_at->formatLocalized('%d %B %Y') }}</b></small></p>--}}
            <p>Douala, le {{ \Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}</p>
        </div>
    </div>
    <div class="row">
        Ref: {{ $patient->numero_dossier .'/'. $consultations->id }}
    </div>
    <br>
    <div class="row col-md-5 offset-3">
        <div class="row">
            <h4><u>LETTRE DE CONSULTATION</u></h4>
        </div>
    </div>
    <div class="row col-md-5 offset-3">
        <div class="row">
            <p>Concernant {{ ($dossier->sexe == 'Masculin' ? 'M. ': 'Mme ').$consultations->patient->name.' '.$consultations->patient->prenom}}</p>
        </div>
    </div>
    <br>
    <br>
    <p>Cher confrère, {{ $consultations->medecin }}</p>
    <br>
    <p>
        Je vois à la consultation d’urologie ce {{$consultations->created_at->formatLocalized('%d %B %Y') }} {{($dossier->sexe == 'Masculin' ? 'M. ': 'Mme ')}}
        <b>{{ $consultations->patient->name }} {{ $consultations->patient->prenom }}</b> née le {{ $dossier->date_naissance }}.
    </p>
    @if ($consultations->motif_c)
        <p>
            <b><u>MOTIF DE CONSULTATION</u> :</b> {{ $consultations->motif_c }}.
            Signalons également les antécédents suivant : @if($consultations->antecedent_m){{ $consultations->antecedent_m }}@endif
        </p>
    @endif
    @if ($consultations->examen_c)
        <p><b><u>EXAMEN(S) COMPLEMENTAIRE(S)</u> :</b></p>
        {!! nl2br(e($consultations->examen_c)) !!}. <br><br>
    @endif
    @if ($consultations->proposition_therapeutique)
        <p><b><u>POPOSITION THERAPEUTIQUE</u> :</b> {{ $consultations->proposition_therapeutique }}.</p>
    @endif
    @if ($consultations->diagnostic)
        <p><b><u>DIAGNOSTIC</u> :</b> {{ $consultations->diagnostic }}.</p>
    @endif
    @if ($consultations->proposition)
        @if ($consultations->proposition == 'Hospitalisation')
            Le patient sera hospitalisé pour un suivi médical.
        @endif
        @if ($consultations->proposition == 'Consultation')
            Le patient sera revu en consultation le {{ $consultations->date_consultation }}.
        @endif
        @if ($consultations->proposition == 'Consultation d\'anesthésiste')
            Le patient est programmé pour une consultation avec l'anesthésiste en date du {{ $consultations->date_consultation }}.
        @endif
        @if ($consultations->proposition == 'Intervention chirurgicale')
                Il a été clairement expliqué au patient la nécessité de recourir à un
                geste chirurgical dont les détails sont contenus dans la fiche d'intervention.
        @endif
        @if ($consultations->proposition == 'Actes à réaliser')
            <p><b><u>ACTES A REALISER</u> :</b> {{ $consultations->acte }}</p>
        @endif
    @endif
    <br>
    <br>
    <p>Je reste bien entendu à votre entiere disposition pour tout échange d'informations.</p>
    <br>
    <p>Bien Confraternellement</p>
    <footer class="footer">
        <p class="offset-8"><b>Dr {{ auth()->user()->name }}</b></p>
        <div class="text-center col-6 offset-2 pt-5">
            <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small>
            <small>www.cmcu-cm.com</small>
        </div>
    </footer>
</div>
