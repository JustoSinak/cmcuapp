<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
<style>
    .cpi-titulo3 {
        font-size: 10px;
    }
    .logo{
        width: 100px;
    }
    p {
        line-height: 100%;
        font-family: 'Crimson Text', sans-serif !important;
    }
    hr {
        display: block; height: 1px;
        border: 0; border-top: 1px solid red;
        margin: 1em 0; padding: 0;
    }
    .h4 {
        text-align: center;
    }
    .force{
        margin-top: -10px !important;
        margin-right: 50px !important;
    }
    .type_interve {
        margin-top: -50px !important;
    }
    .footer {
        padding-top: 1px;
        padding-bottom: 80px;
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

    <p class="force"><h4 class="h4"><u>COMPTE-RENDU OPERATOIRE</u></h4></p>

    <div class="row col-md-5 offset-3">
        <div class="row">
            <p>CONCERNANT LE PATIENT : <b>{{ $patient->name }} {{ $patient->prenom }}</b></p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <span><small><b>CHIRURGIEN :</b> Dr. {{ $patient->compte_rendu_bloc_operatoires->last()->chirurgien }}</small></span><br>
            <span><small><b>AIDE OPERATOIRE:</b> Dr. {{ $patient->compte_rendu_bloc_operatoires->last()->aide_op }}</small></span><br>
            <span><small><b>ANESTHESISTE :</b> Dr. {{ $patient->compte_rendu_bloc_operatoires->last()->anesthesiste }}</small></span><br>
            <span><small><b>INFIRMIER ANESTHESISTE:</b> {{ $patient->compte_rendu_bloc_operatoires->last()->infirmier_anesthesiste }}</small></span>
        </div>
        <div class="col-md-2 offset-7">
            <span><small><b>DATE D'ENTREE :</b> {{ $patient->compte_rendu_bloc_operatoires->last()->date_e }}</small></span><br>
            <span><small><b>TYPE D'ENTREE :</b> {{ $patient->compte_rendu_bloc_operatoires->last()->type_e }}</small></span><br>
            <span><small><b>DATE DE SORTIE :</b> {{ $patient->compte_rendu_bloc_operatoires->last()->date_s }}</small></span><br>
            <span><small><b>TYPE DE SORTIE :</b> {{ $patient->compte_rendu_bloc_operatoires->last()->type_s }}</small></span><br>
        </div>
    </div>

    <h6 class="type_interve"><u>TYPE D'INTERVENTION :</u></h6>
    <div class="">
        <p>
            <b>{!! nl2br(e($patient->consultations->last()->type_intervention)) !!}</b>
        </p>
    </div>
    <h6 class="text-"><u>DATE D'INTERVENTION :</u> {{ $patient->compte_rendu_bloc_operatoires->last()->date_intervention }}</h6>
    <h6 class="text-"><u>INDICATIONS OPERATOIRES :</u></h6>
    <div class="">
        <p>
            {!! nl2br(e($patient->compte_rendu_bloc_operatoires->last()->indication_operatoire)) !!}
        </p>
    </div>
    <h6 class="text-"><u>COMPTE-RENDU OPERATOIRE :</u></h6>
    <div class="">
        <p>
            {!! nl2br(e($patient->compte_rendu_bloc_operatoires->last()->compte_rendu_o)) !!}
        </p>
    </div>
    <h6 class="text-"><u>SUITES OPERATOIRES :</u></h6>
    <div class="">
        <p>
            {!! nl2br(e($patient->compte_rendu_bloc_operatoires->last()->suite_operatoire)) !!}
        </p>
    </div>
    <h6 class="text-"><u>CONCLUSIONS :</u></h6>
    <div class="">
        <p>
            {!! nl2br(e($patient->compte_rendu_bloc_operatoires->last()->conclusion)) !!}
        </p>
    </div>
    <h6 class="text-"><u>PROPOSITION DE SUIVI :</u></h6>
    <div class="">
        <p>
            {!! nl2br(e($patient->compte_rendu_bloc_operatoires->last()->proposition_suivi)) !!}
        </p>
    </div>
    <footer class="footer">
        <p class="offset-8"><b>Dr {{ auth()->user()->name }}</b></p>
        <div class="text-center col-6 offset-2">
            <!-- <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small> -->
            <!-- <small>www.cmcu-cm.com</small> -->
        </div>
    </footer>
</div>
