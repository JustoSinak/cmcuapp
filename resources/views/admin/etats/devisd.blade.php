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
        bottom:10px;
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
{{--            <p><small><b>Doit :{{ $devis->patient->name }} {{ $devis->patient->prenom }}</b></small></p>--}}
        </div>
        <div class="col-md-4 offset-8">
            <p><small><b> Douala, {{ $date = \Carbon\Carbon::now()->toFormattedDateString() }}</b></small></p>
        </div>
    </div>
    <div class="text-center text-primary devis_numero">
{{--        <p><h4 class="devis"><u>DEVIS N°{{ \Carbon\Carbon::now()->toDateString() . '/' . substr($devis->nom, 2,5) }}</u></h4></p>--}}
    </div>
    <br>

    <div class="row">
{{--        <h5 class="text-center"><u>{{ $devis->nom }}</u></h5>--}}
    </div>
    <br>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th class="text-center">ELEMENTS</th>
            <th class="text-center" colspan="2">PRODUITS</th>
            <th class="text-center">MONTANT</th>
        </tr>
        </thead>
        <tbody>
        @if (explode('/', $devis->categorie)[0] == 'HOSPITALISATION')
            <tr>
                <td><b>{{ explode('/', $devis->categorie)[0] }}</b></td>
                <td colspan="2" class="text-center">Sous-total</td>
                <td class="text-right"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2"><small><b>{{ explode('/', $devis->produit)[0] }}</b></small></td>
                <td class="text-right">{{ explode('/', $devis->prix)[0] }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="text-right"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2"><small><b>{{ explode('/', $devis->produit)[1] }}</b></small></td>
                <td class="text-right">{{ explode('/', $devis->prix)[1] }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="text-right"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2"><small><b>{{ explode('/', $devis->produit)[2] }}</b></small></td>
                <td class="text-right">{{ explode('/', $devis->prix)[2] }}</td>
            </tr>
        @endif

        @include('admin.etats.partials.cs_anesthesie')
        @include('admin.etats.partials.kcc')
        @include('admin.etats.partials.k_amplificateur')
        @include('admin.etats.partials.k_anesthesie')
        @include('admin.etats.partials.k_bloc')
        @include('admin.etats.partials.anatomo_pathologie')
        @include('admin.etats.partials.materiel')

        </tbody>
    </table>

    Arrêté le présent devis à la somme de : {{ $lettre->Conversion($total = array_sum(explode('/', $devis->prix))) }} Fcfa
    <br>
    <br>
    <br>
    <div class="row">
        <p class="col-md-1 offset-8"><u>LA DIRECTION</u></p>
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
