<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
<style>
    .cpi-titulo3 {
        font-size: 12px;
    }
    .logo{
        width: 100px;
    }
    p {
        line-height: 40%;
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
        bottom:5;
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
                <p>CENTRE MEDICO-HIRURGICAL D'UROLOGIE</p>
                <p>VALLEE MANGA BELL DOUALA-BALI</p>
                <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small>
                <p><small>www.cmcu-cm.com</small></p>
            </div>
        </div>
    </div>

    <div class="row">
        <hr class="text-danger">
    </div>
    <h4 class="text-danger text-center"><b><u>Compte rendu d'hospitalisation</u></b></h4>
    <div class="row">
        <div class="col-10">
            <h4><b><u>Nom du patient:</u></b> {{ $patient->name }}</h4>
            <br>
            <h4><b><u>Médécin traitant:</u></b> {{ $patient->compte_rendu_bloc_operatoires->last()->chirurgien }}</h4>
        </div>
    </div>
    <br>
    <br>
    <br>
    <h4 class=""><u>Suite opératoire :</u></h4>
    <br>
        <p>{!! nl2br(e($patient->compte_rendu_hospitalisations->last()->suite_operatoire)) !!}</p>
    <br>
    <h4 class="text-"><u>Détails d'intervention:</u></h4>
    <div class="">
        <h5>
            {!! nl2br(e($patient->compte_rendu_bloc_operatoires->last()->detail_intervention)) !!}
        </h5>
    </div>
    <br>
    <h4 class="text-"><u>Traitement de sortie:</u></h4>
    <div class="">
        <h5>
            {!! nl2br(e($patient->compte_rendu_hospitalisations->last()->traitement_sortie)) !!}
        </h5>
    </div>
    <footer class="footer">
        <div class="text-center col-6 offset-2">
            <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small>
            <small>www.cmcu-cm.com</small>
        </div>
    </footer>
</div>
