<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
<style>
    .cpi-titulo3 {
        font-size: 12px;
    }
    .logo{
        width: 100px;
    }
    p {
        line-height: 100%;
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
    bottom:5px;
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
            <p><b>Dr. {{ $ordonance->user->prenom }} {{ $ordonance->user->name }}</b></p>
            <p><small><b>{{ $ordonance->user->specialite }}</b></small></p>
            <p class="mt-2"><b>Onmc: <small>{{ $ordonance->user->onmc }}</small></b></p>
        </div>
        <div class="col-5 offset-6">
            <p><small><b> {{ $ordonance->created_at->toRfc2822String() }}</b></small></p>
            <br>
            <br>
            <br>
            <p>{{ $ordonance->patient->name }} {{ $ordonance->patient->prenom }}</p>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <h5 class="text-center"><u>ORDONNANCE</u></h5>
    </div>
    <br>
    <br>
    <br>

    <div class="row">
        <div class="col-md-5">
            @foreach(explode(",", $ordonance->medicament) as $medicament)
                <ul>
                    <p>{{ $compteur++ }} -   <u>{{ $medicament }}</u></p>
                </ul>
            @endforeach
        </div>
        <div class="col-md-3 offset-4">
            @foreach(explode(",", $ordonance->quantite) as $quantite)
                <ul>
                    <p>
                        {{ $quantite }}
                    </p>
                </ul>
            @endforeach
        </div>
        <div class="col-md-4 offset-6">
            @foreach(explode(",", $ordonance->description) as $description)
                <ul>
                    <p>
                        {{ $description }}
                    </p>
                </ul>
            @endforeach
        </div>
    </div>

    <footer class="footer">
        <div class="text-center col-6 offset-2">
            <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small>
            <small>www.cmcu-cm.com</small>
        </div>
    </footer>
</div>
