<!DOCTYPE html>
<html lang="en">
<head>
    <title>Facture de {{ strtolower($patient->details_motif) ?? 'consultation'}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('admin/css/bootstrap3.3.7.css') }}" rel="stylesheet" type="text/css" media="all" />

    <style>
        body { font-size: 3px }
        thead > tr > th {
            text-align: center;
            padding: 5px;
        }
        td {
            vertical-align: middle;
        }
        .container{
            border: 1px solid #000;
        }
        .logo{
            width: 40px;
            padding-top: 10px;
        }
        #inventory-invoice{
            padding: 20px;
        }
        #inventory-invoice a{text-decoration:none ! important;}
        .invoice {
            position: relative;
            background-color: #FFF;
            min-height: 480px;
            padding: 12px
        }
        .invoice header {
            padding: 10px 0;
            margin-bottom: 8px;
            border-bottom: 1px solid #3989c6
        }
        .invoice .company-details {
            text-align: right
        }
        .invoice .company-details .name {
            margin-top: 0;
            margin-bottom: 0
        }
        .invoice .contacts {
            margin-bottom: 10px;
            text-align: center
        }
        .invoice .invoice-to {
            text-align: start
        }
        .invoice .invoice-to .to {
            margin-top: 0;
            margin-bottom: 0
        }
        .invoice .invoice-details {
            text-align: right
        }
        .invoice .invoice-details .invoice-id {
            margin-top: 0;
            text-align: center;
            color: #3989c6
        }
        .invoice main {
            padding-bottom: 30px
        }
        .invoice main .thanks {
            margin-top: -50px;
            font-size: 2em;
            margin-bottom: 50px
        }
        .invoice main .notices {
            padding-start: 6px;
            border-start: 6px solid #3989c6
        }
        .invoice main .notices .notice {
            font-size: 1.2em
        }
        .invoice table {
            width: 90%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 10px
        }
        .invoice table td,.invoice table th {
            padding: 10px;
            background: #eee;
            border-bottom: 1px solid #fff
        }
        .invoice table th{
            white-space: nowrap;
            font-weight: 300;
            font-size: 14px;
            border:1px solid #fff;
        }
        .invoice table td{
            border:1px solid #fff;
        }
        .invoice table td h3 {
            margin: 0;
            font-weight: 300;
            color: #3989c6;
            font-size: 1.2em
        }
        .invoice table .tax,.invoice table .total,.invoice table .unit {
            text-align: right;
            font-size: 1.2em
        }
        .invoice table .no {
            color: #fff;
            font-size: 1.6em;
            background: #17a2b8
        }
        .invoice table .unit {
            background: #ddd
        }
        .invoice table .total {
            background: #17a2b8;
            color: #fff
        }
        .invoice table tfoot td {
            background: 0 0;
            border-bottom: none;
            white-space: nowrap;
            text-align: right;
            padding: 10px 20px;
            font-size: 1.2em;
            border-top: 1px solid #aaa
        }
        .invoice table tfoot tr:first-child td {
            border-top: none
        }
        .invoice table tfoot tr:last-child td {
            color: #3989c6;
            font-size: 1.4em;
            border-top: 1px solid #3989c6
        }
        .invoice table tfoot tr td:first-child {
            border: none
        }
        .invoice footer {
            width: 90%;
            text-align: center;
            color: #777;
            font-size: 6px;
            border-top: 1px solid #aaa;
            padding: 8px 0
        }
        @media print {
            .invoice {
                font-size: 11px!important;
                overflow: hidden!important
            }
            .invoice footer {
                position: absolute;
                bottom: 8px;
                page-break-after: always
            }
            .invoice>div:last-child {
                page-break-before: always
            }
        }

        #watermark {
                position: fixed;
                top: 1%;
                width: 100%;
                text-align: center;
                opacity: .2;
                transform: rotate(10deg);
                transform-origin: 50% 50%;
            }
        
    </style>
</head>
<body>
<div id="watermark">
            <img src="{{ asset('admin/images/watermake.JPG') }}" height="100%" width="100%" />
        </div>
<div class="container">
    <div class="row text-center">
        <img class="logo" src="{{ asset('admin/images/logo.jpg') }}" alt="">
        <h6><strong>CENTRE MEDICO-CHIRURGICAL D'UROLOGIE</strong></h6>
        <h6>VALLEE MANGA BELL DOUALA-BALI</h6>
        <h6>TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945</h6>
        <p><h6>www.cmcu-cm.com</h6></p>
    </div>

<div id="inventory-invoice">

    {{--<div class="toolbar hidden-print">--}}
       {{--<hr>--}}
    {{--</div>--}}
    <div class="invoice overflow-auto">
        <div style="min-width: 300px">
            <main>
                <div class="row contacts">

                    <div  class="col invoice-details ">
                        <h6 class="invoice-id">RECU {{ strtoupper($facture->details_motif) ?? 'CONSULTATION'}} N°{{ $patient->numero_dossier }}</h6>
                        <br>
                    </div>
                </div>
                @if($patient->assurancec)
                <h6 class="text-center">ASSURANCE:{{ $facture->assurance }}</h6>
                @else
                @endif
                <h6 class="text-center">{{ $patient->demarcheur }}</h6>
                @if($facture->assurancec)
                  <h6>PART ASSURANCE: {{ $facture->assurancec }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PART PATIENT: {{ $patient->assurec }}</h6>
                  @else
               @endif  
                 <table border="0" cellspacing="0" cellpadding="0">
                <thead>
                        <tr>
                            <th class="text-start">NOM</th>
                            <th class="text-start">PRENOM</th>
                            <th class="text-start"> MONTANT (FCFA)</th>
                            <th class="text-start"> AVANCE </th>
                            <th class="text-start"> RESTE </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-start" ><h5> {{ $patient->name }}</h5></td>
                            <td class="text-start" ><h5> {{ $patient->prenom }}</h5></td>
                            <td class="text-start"><h4> {{ $facture->montant }}</h4></td>
                            @if($patient->avance)
                            <td class="text-start"><h4>{{ $facture->avance }}</h4></td>
                            @else
                            <td class="text-start"><h4>0</h4></td>
                            @endif
                            @if($patient->avance)
                            <td class="text-start"><h4>{{ $facture->reste }}</h4></td>
                            @else
                                <td class="text-start"><h4>0</h4></td>
                            @endif
                        </tr>
                    <tr>
                        <div class="notices">
                           <H6><div>LA CAISSE:{{ $patient->user->prenom }} {{ $patient->user->name }}</div></H6>
                           <H6><div class="notice">Douala,{{ $patient->created_at->toFormattedDateString() }}</div></H6>
                        </div>
                    </tr>
                    </tbody>
                  </table>
                </main>
            <footer>
                Centre Medico-churirgical d'urologie situé a la Vallée Douala Manga Bell Douala-Bali.
                              TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945.
                              SITE WEB: http://www.cmcu-cm.com
            </footer>
        </div>
     </div>
</div>
 <div class="row text-center">
        <img class="logo" src="{{ asset('admin/images/logo.jpg') }}" alt="">
        <h6><strong>CENTRE MEDICO-CHIRURGICAL D'UROLOGIE</strong></h6>
        <h6>VALLEE MANGA BELL DOUALA-BALI</h6>
        <h6>TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945</h6>
        <p><h6>www.cmcu-cm.com</h6></p>
    </div>
    <div id="inventory-invoice">
        <div class="invoice overflow-auto">
            <div style="min-width: 300px">
                <main>
                    <div class="row contacts">

                        <div  class="col invoice-details ">
                            <h6 class="invoice-id">RECU {{ strtoupper($facture->details_motif) ?? 'CONSULTATION'}} N°{{ $patient->numero_dossier }}</h6>
                            <br>
                        </div>
                    </div>
                    @if($facture->assurancec)
                    <h6 class="text-center">ASSURANCE:{{ $facture->assurance }}</h6>
                    @else
                    @endif
                    <h6 class="text-center">{{ $patient->demarcheur }}</h6>
                    @if($facture->assurancec)
                      <h6>PART ASSURANCE: {{ $facture->assurancec }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PART PATIENT: {{ $patient->assurec }}</h6>
                     @else
                     
                   @endif
                        <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr>
                        <th class="text-start">NOM</th>
                            <th class="text-start">PRENOM</th>
                            <th class="text-start"> MONTANT (FCFA) </th>
                            <th class="text-start"> AVANCE </th>
                            <th class="text-start"> RESTE </th>
                         </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td class="text-start" ><h5> {{ $patient->name }}</h5></td>
                            <td class="text-start" ><h5> {{ $patient->prenom }}</h5></td>
                            <td class="text-start"><h4> {{ $facture->montant }}</h4></td>
                            @if($patient->avance)
                                <td class="text-start"><h4>{{ $facture->avance }}</h4></td>
                                @else
                                <td class="text-start"><h4>0</h4></td>
                            @endif
                             @if($patient->avance)
                                <td class="text-start"><h4>{{ $facture->reste }}</h4></td>
                                @else
                                <td class="text-start"><h4>0</h4></td>
                            @endif
                         </tr>
                        <tr>
                            <div class="notices">
                                <H6><div>LA CAISSE: {{ $patient->user->prenom }} {{ $patient->user->name }}</div></H6>
                                <H6><div class="notice">Douala,{{ $patient->created_at->toFormattedDateString() }}</div></H6>
                            </div>
                        </tr>
                        </tbody>
                    </table>
                </main>
                <footer>
                    Centre Medico-churirgical d'urologie situé a la Vallée Douala Manga Bell Douala-Bali.
                    TEL: (+ 237) 233 423 389 / 674 068 988 / 698 873 945.
                    SITE WEB: http://www.cmcu-cm.com
                </footer>
            </div>
        </div>
    </div>
</div>
    </div>
</div>
</body>
</html>
