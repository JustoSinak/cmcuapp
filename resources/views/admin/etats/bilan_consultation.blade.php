<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
<style>
    .cpi-titulo3 {
        font-size: 12px;
    }
    .logo{
        width: 100px;
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
    <h5 class="text-center"><u>FICHE DE SUIVI DES ENCAISSEMENTS JOURNALIERS {{ strtoupper($service)}}</u></h5>
    <div class="container-fluid">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>PATIENT</th>
                <th>MONTANT</th>
                <th>AVANCE</th>
                <th>RESTE</th>
                <th>PART PATIENT</th>
                <th>PART ASSURANCE</th>
                <th>DMH</th>
                <th>MEDECIN</th>
                <th>DATE</th>
            </tr>
            </thead>
            <tbody>
            @foreach($factures as $facture)
            <tr>
                <td>{{ $facture->numero }}</td>
                <td><small>{{ $facture->patient->name }} {{ $facture->patient->prenom }}</small></td>
                <td><small>{{ $facture->montant }}</small></td>
                <td><small>{{ $facture->avance }}</small></td>
                <td><small>{{ $facture->reste }}</small></td>
                <td><small>{{ $facture->assurec }}</small></td>
                <td><small>{{ $facture->assurancec }}</small></td>
                <td><small>{{ $facture->demarcheur }}</small></td>
                <td><small>{{ $facture->medecin_r }}</small></td>
                <td><small>{{ $facture->date_insertion }}</small></td>
            </tr>
            @endforeach
            <tr>
                <td><h4>TOTAL en Fcfa:</h4></td>
                <td></td>
                <td><h5>{{ $tautaux }}</h5></td>
                <td>{{ $avances }}</td>
                <td>{{ $restes }}</td>
                <td>{{ $patients }}</td>
                <td>{{ $assurances }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <div class="row">
            <div class="col-md-4 offset-10">
                <p><u>GESTIONNAIRE</u></p>
            </div>
            <div class="col-md-4 offset-5">
                <p><u>COMPTABLE</u></p>
            </div>
            <div class="col-md-4">
                <p><u>ASSISTANTE</u></p>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="text-center col-6 offset-2">
            <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small>
            <small>www.cmcu-cm.com</small>
        </div>
    </footer>
</div>

