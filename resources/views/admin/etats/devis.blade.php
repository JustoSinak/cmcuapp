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
            <p><small><b>Doit :{{ $devis->patient->name }} {{ $devis->patient->prenom }}</b></small></p>
        </div>
        <div class="col-md-4 offset-8">
            <p><small><b> Douala, {{ $date = \Carbon\Carbon::now()->toFormattedDateString() }}</b></small></p>
        </div>
    </div>
    <div class="text-center text-primary devis_numero">
        <p><h4 class="devis"><u>DEVIS N°{{ \Carbon\Carbon::now()->toDateString() . '/' . substr($devis->nom, 2,5) }}</u></h4></p>
    </div>
    <br>

    <div class="row">
        <h5 class="text-center"><u>{{ $devis->nom }}</u></h5>
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
        @if($devis->elements)
            <tr>
                <td>{{ $devis->elements}}</td>
            @if($devis->qte1)
                <td class="text-right">{{ $devis->qte1}}</td>
                @endif

            @if($devis->prix_u)
                <td class="text-right">{{ $devis->prix_u}}</td>
                @endif
            @if($devis->montant)
                <td class="text-right"><b>{{ $devis->montant}}</b></td>
                @endif
            </tr>
        @endif

        @if($devis->elements1)
            <tr>
                <td>{{ $devis->elements1}}</td>
            @if($devis->qte2)
                <td class="text-right">{{ $devis->qte2}}</td>
                @endif
            @if($devis->prix_u1)
                <td class="text-right">{{ $devis->prix_u1}}</td>
                @endif
            @if($devis->montant1)
                <td class="text-right"><b>{{ $devis->montant1}}</b></td>
                @endif
            </tr>
        @endif

        @if($devis->elements2)
            <tr>
                <td>{{ $devis->elements2}}</td>
            @if($devis->qte3)
                <td class="text-right">{{ $devis->qte3}}</td>
                @endif
            @if($devis->prix_u2)
                <td class="text-right">{{ $devis->prix_u2}}</td>
                @endif
            @if($devis->prix_u2)
                <td class="text-right"><b>{{ $devis->montant2}}</b></td>
                @endif
            </tr>
        @endif

        @if($devis->elements3)
            <tr>
                <td>{{ $devis->elements3}}</td>
            @if($devis->qte4)
                <td class="text-right">{{ $devis->qte4}}</td>
                @endif
            @if($devis->prix_u3)
                <td class="text-right">{{ $devis->prix_u3}}</td>
                @endif
            @if($devis->montant3)
                <td class="text-right"><b>{{ $devis->montant3}}</b></td>
                @endif
            </tr>
        @endif

        @if($devis->elements4)
            <tr>
                <td>{{ $devis->elements4}}</td>
            @if($devis->qte5)
                <td class="text-right">{{ $devis->qte5}}</td>
                @endif
            @if($devis->prix_u4)
                <td class="text-right">{{ $devis->prix_u4}}</td>
            @else
                @endif
            @if($devis->montant4)
                <td class="text-right"><b>{{ $devis->montant4}}</b></td>
                @endif
            </tr>
        @endif

        @if($devis->elements5)
            <tr>
                <td>{{ $devis->elements5}}</td>
            @if($devis->qte6)
                <td class="text-right">{{ $devis->qte6}}</td>
                @endif
            @if($devis->prix_u5)
                <td class="text-right">{{ $devis->prix_u5}}</td>
                @endif
            @if($devis->montant5)
                <td class="text-right"><b>{{ $devis->montant5}}</b></td>
                @endif
            </tr>
        @endif

        @if($devis->elements6)
            <tr>
                <td>{{ $devis->elements6}}</td>
            @if($devis->qte7)
                <td class="text-right">{{ $devis->qte7}}</td>
                @endif
            @if($devis->prix_u6)
                <td class="text-right">{{ $devis->prix_u6}}</td>
                @endif
            @if($devis->montant6)
                <td class="text-right"><b>{{ $devis->montant6}}</b></td>
                @endif
            </tr>
        @endif

        @if($devis->elements7)
            <tr>
                <td>{{ $devis->elements7}})</td>
            @if($devis->qte8)
                <td class="text-right">{{ $devis->qte8}}</td>
                @endif
            @if($devis->prix_u7)
                <td class="text-right">{{ $devis->prix_u7}}</td>
                @endif
            @if($devis->montant7)
                <td class="text-right"><b>{{ $devis->montant7}}</b></td>
            @endif
            </tr>
        @endif

        @if($devis->elements8)
            <tr>
                <td>{{ $devis->elements8}}</td>
            @if($devis->qte9)
                <td>{{ $devis->qte9}}</td>
                @endif
            @if($devis->prix_u8)
                <td>{{ $devis->prix_u8}}</td>
                @endif
            @if($devis->montant8)
                <td><b>{{ $devis->montant8}}</b></td>
                @endif
            </tr>
        @endif

        <tr>
            <td class="text-center" colspan=3><b>TOTAL 1</b></td>
            <td class="text-right"><b>{{ $devis->total1}}</b></td>
        </tr>

        <tr>
            <td colspan=4><b>HOSPITALISATION 1 JOUR</b></td>
        </tr>

        @if($devis->elements9)
            <tr>
                <td>{{ $devis->elements9}}</td>
            @if($devis->qte10)
                <td class="text-right">{{ $devis->qte10}}</td>
                @endif
            @if($devis->prix_u9)
                <td class="text-right">{{ $devis->prix_u9}}</td>
                @endif
            @if($devis->montant9)
                <td class="text-right"><b>{{ $devis->montant9}}</b></td>
            @endif
            </tr>
        @endif

        @if($devis->elements10)
            <tr>
                <td>{{ $devis->elements10}}</td>
            @if($devis->qte11)
                <td class="text-right">{{ $devis->qte11}}</td>
                @endif
            @if($devis->prix_u10)
                <td class="text-right">{{ $devis->prix_u10}}</td>
                @endif
            @if($devis->montant10)
                <td class="text-right"><b>{{ $devis->montant10}}</b></td>
                @endif
            </tr>
        @endif

        @if($devis->elements11)
            <tr>
                <td>{{ $devis->elements11}}</td>
            @if($devis->qte12)
                <td class="text-right">{{ $devis->qte12}}</td>
                @endif
            @if($devis->prix_u11)
                <td class="text-right">{{ $devis->prix_u11}}</td>
                @endif
            @if($devis->montant11)
                <td class="text-right"><b>{{ $devis->montant11}}</b></td>
                @endif
            </tr>
        @endif

        @if($devis->elements12)
            <tr>
                <td>{{ $devis->elements12}}</td>
            @if($devis->qte13)
                <td class="text-right">{{ $devis->qte13}}</td>
            @endif
            @if($devis->prix_u12)
                <td class="text-right">{{ $devis->prix_u12}}</td>
            @endif
            @if($devis->montant12)
                <td class="text-right"><b>{{ $devis->montant12}}</b></td>
            @endif
        </tr>
        @endif

        @if($devis->elements13)
            <tr>
                <td>{{ $devis->elements13}}</td>
            @if($devis->qte14)
                <td class="text-right">{{ $devis->qte14}}</td>
                @endif
            @if($devis->prix_u13)
                <td class="text-right">{{ $devis->prix_u13}}</td>
                @endif
            @if($devis->montant13)
                <td class="text-right"><b>{{ $devis->montant13}}</b></td>
                @endif
            </tr>
        @endif

        <tr>
            <td class="text-center" colspan="3"><b>TOTAL 2</b></td>
            <td class="text-right"><b>{{ $devis->total2}}</b></td>
        </tr>

        <tr>
            <td class="text-center" colspan="3"><h5><b>TOTAL</b></h5></td>
            <td class="text-right"><h5><b>{{ $devis->total3}}</b></h5></td>
        </tr>


        </tbody>
    </table>

    Arrêté le présent devis à la somme de : {{ $devis->arreter}}
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
