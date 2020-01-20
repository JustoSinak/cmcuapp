<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
<?php setlocale(LC_TIME, 'French') ?>
<style>
    body {
        background: #FFF;
        ;
    }

    span {
        font-size: 15px;
    }

    .text {
        margin: 20px 0px;
    }

    .fa {
        color: #4183D7;
    }

    .cpi-titulo3 {
        font-size: 12px;
    }

    .logo {
        width: 100px;
    }

    p {
        line-height: 43%;
    }

    hr {
        display: block;
        height: 1px;
        border: 0;
        border-top: 1px solid red;
        margin: 1em 0;
        padding: 0;
    }

    .footer {
        padding-top: 1px;
        padding-bottom: 15px;
        position: fixed;
        bottom: 100;
        width: 100%;
    }

    background: #eee;
    }

    span {
        font-size: 15px;
    }

    a {
        text-decoration: none;
        color: #0062cc;
        border-bottom: 2px solid #0062cc;
    }

    .box {
        padding: 30px 0px;
    }

    .box-part {
        background: #FFF;
        border-radius: 0;
        padding: 20px 6px;
        margin: 10px 0px;

    }

    .box-a {
        background: #FFF;
        border-radius: 0;
        padding: 20px 6px;
        margin: 10px 0px;
        float: right;
    }

    .text {
        margin: 5px 0px;
    }

    .fa {
        color: #4183D7;
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
                <p class="mt-2"><small>ONMC : N° 5531 007/10/D/ONMC</small></p>
                <p><small> Arrêté N° 3203/A/MINSANTE/SG/DOSTS/SDOS/SFSP </small></p>
                <p>VALLEE MANGA BELL DOUALA-BALI</p>
                <p><small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small></p>
                <p>Consultation sur RDV </p>
                <p>Email : <small> info@cmcu-cm.com</small></p>
                <p><small>www.cmcu-cm.com</small></p>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <hr class="text-danger">
    </div>
    <br>
    <div class="row">
        <div class="col-4 pl-0">
            <span>Dr <small>{{ $prescriptions->user->name.' '.$prescriptions->user->prenom }}</small></span><br>
            <span><small>{{ $prescriptions->user->specialite }}</small></span><br>
            <span>Onmc: <small>{{ $prescriptions->user->onmc }}</small></span>
        </div>
        <div class="col-6 offset-6">
            {{-- <p><small><u>Date:</u><b> {{ $prescriptions->created_at->formatLocalized('%d %B %Y') }}</b></small></p>--}}
            <p>Douala, le {{ \Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}</p>
        </div>
    </div>

    <br>
    <div class="row">
        <div>

            <div class="box-part ">
                <div class="title">
                    <p> <u>PATIENT</u>: <small>{{ $prescriptions->patient->name}}{{ $prescriptions->patient->prenom}}</small></p>

                </div>

            </div>

        </div>
        <div class="box-a">



        </div>
    </div>
    <br>
    <br>
    <div class="text-center">
        <h3><u>BULLETIN EXAMEN(S)</u> </h3>
    </div>
    <br>
    <div class="row">
        <div>

            <div class="title">
                @if($prescriptions->hematologie)
                <h5><u>HEMATOLOGIE</u></h5>
                {{$prescriptions->hematologie}}
                @else
                @endif

            </div><br>
            <div class="title">
                @if($prescriptions->hemostase)
                <h5><u> HEMOSTASE</u></h5>
                {{$prescriptions->hemostase}}
                @else
                @endif
            </div> <br>
            <div class="title">
                @if($prescriptions->biochimie)
                <h5><u>BIOCHIMIE</u></h5>
                {{$prescriptions->biochimie}}
                @else
                @endif
            </div><br>
            <div class="title">
                @if($prescriptions->serologie)
                <h5><u>SEROLOGIE</u></h5>
                {{$prescriptions->serologie}}
                @else
                @endif
            </div><br>
            <div class="title">
                @if($prescriptions->hormonologie)
                <h5><u>HORMONOLOGIE</u></h5>
                {{$prescriptions->hormonologie}}
                @else
                @endif
            </div><br>
            <div class="title">
                @if($prescriptions->marqueurs)
                <h5><u>MARQUEURS</u></h5>
                {{$prescriptions->marqueurs}}
                @else
                @endif
            </div><br>
            <div class="title">
                @if($prescriptions->bacteriologie)
                <h5><u>BACTERIOLOGIE</u></h5>
                {{$prescriptions->bacteriologie}}
                @else
                @endif
            </div><br>
            <div class="title">
                @if($prescriptions->spermiologie)
                <h5> <u>SPERMIOLOGIE</u></h5>
                {{$prescriptions->spermiologie}}
                @else
                @endif
            </div><br>
            <div class="title">
                @if($prescriptions->urines)
                <h5> <u>URINES</u></h5>
                {{$prescriptions->urines}}
                @else
                @endif
            </div>

        </div>
    </div>
    <div class=" footer">
        <p class="offset-8"><b>Dr {{ auth()->user()->name }}</b></p>
        <div class="text-center col-6 offset-2 pt-5">
            <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small>
            <small>www.cmcu-cm.com</small>
        </div>
    </div>

</div>