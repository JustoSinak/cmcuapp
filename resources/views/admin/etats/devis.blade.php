
<?php  \Carbon\Carbon::setUTF8(true); setlocale(LC_TIME, 'French') ?>
<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
<style>

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
        padding-bottom: 4px;
        position:fixed;
        bottom:70px;;
        width:100%;
    }
    td {
        height: 1px;
        padding: 2px !important;
    }
    th {
        height: 1px;
        padding: 1px !important;
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
                <p>007/10/D/ONMC</p>
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
        <div class="col-md-4">
            <p><small><b>Doit : {{ $nomPatient}}</b></small></p>
        </div>
        <div class="col-md-4 offset-8">
            <p><small><b> Douala, {!! \Carbon\Carbon::now()->formatLocalized('%d %B %Y') !!}</b></small></p>
        </div>
    </div>
    <div class="text-center text-primary devis_numero">
        <p><h4 class="devis"><u>DEVIS N°{{ $devis->code }}</u></h4></p>
    </div>
    <br>

    <div class="row">
        <h5 class="text-center"><u></u></h5>
    </div>
    <br>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th class="text-center">ELEMENTS</th>
            <th class="text-center">QTES</th>
            <th class="text-center">PRIX UNIT.</th>
            <th class="text-center">MONTANT</th>
        </tr>
        </thead>
        <tbody>
        @foreach($ligneDevis as $ligneDevi)
            <tr>
                <td >{{ $ligneDevi->element }}</td>
                <td class="text-right">{{ $ligneDevi->quantite }}</td>
                <td class="text-right">{{ $ligneDevi->prix_u }}</td>
                <td class="text-right">{{ $ligneDevi->prix }}</td>
            </tr>
        @endforeach
        <tr>
            <td class="text-center" colspan=3><b>TOTAL 1</b></td>
            <td class="text-right"><b>{{ $devis->total1}}</b></td>
        </tr>

        <tr>
            <td colspan=4><b>HOSPITALISATION {{ $devis->nbr_chambre }} JOUR(S)</b></td>
        </tr>
        <tr>
            <td>CHAMBRE</td>
            <td class="text-right">{{ $devis->nbr_chambre }}</td>
            <td class="text-right">{{ $devis->pu_chambre }}</td>
            <td class="text-right">{{ $devis->nbr_chambre * $devis->pu_chambre }}</td>
        </tr>
        <tr>
            <td>AMI-JOUR (750x12)</td>
            <td class="text-right">{{ $devis->nbr_ami_jour }}</td>
            <td class="text-right">{{ $devis->pu_ami_jour }}</td>
            <td class="text-right">{{ $devis->nbr_ami_jour * $devis->pu_ami_jour }}</td>
        </tr>
        <tr>
            <td>VISITE</td>
            <td class="text-right">{{ $devis->nbr_visite }}</td>
            <td class="text-right">{{ $devis->pu_visite  }}</td>
            <td class="text-right">{{ $devis->nbr_visite * $devis->pu_visite }}</td>
        </tr>
        <tr>
            <td class="text-center" colspan="3"><b>TOTAL 2</b></td>
            <td class="text-right"><b>{{ $devis->total2 }}</b></td>
        </tr>

        <tr>
            <td class="text-center" colspan="3"><h5><b>TOTAL</b></h5></td>
            <td class="text-right"><h5><b>{{ $devis->total1 + $devis->total2}}</b></h5></td>
        </tr>


        </tbody>
    </table>

    Arrêté le présent devis à la somme de <b id="total_en_lettre">{{ $devis->total}}</b> Francs CFA
    <br>
    <br>
    <div class="row">
        <p class="col-md-1 offset-4"><u>LE DIRECTEUR MEDICAL</u></p>
        <p class="col-md-1 offset-9"><u>LA DIRECTION</u></p>
    </div>
    <footer class="footer">
        <div class="col-md-12">
            <small>
                <b>N.B :</b> <i>Il est à noter que ceci n’est que le coût de l’intervention chirurgicale et de l’hospitalisation.
                    Nous ne sommes tenue responsable des imprévus, ni des examens de laboratoires que vous pourriez effectuer
                    éventuellement. Merci</i>
            </small>
        </div>
    </footer>
</div>
