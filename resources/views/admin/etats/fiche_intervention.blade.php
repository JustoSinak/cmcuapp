<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" /><style>
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
        bottom:5px;
        width:100%;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-2">
            <img class="logo img-responsive float-start" src="{{ asset('admin/images/logo.jpg') }}">
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
    <div class="container-fluid">
        <div class="col-md-12  toppad">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <h6 class="text-primary"><strong>PATIENT</strong></h6>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Nom du patient :</b></td>
                            <td>
                                {{ $fiche_intervention->nom_patient }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Prénom du patient :</b></td>
                            <td>
                                {{ $fiche_intervention->prenom_patient }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Sexe :</b></td>
                            <td>
                                {{ $fiche_intervention->sexe_patient }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Date de naissance :</b></td>
                            <td>
                                {{ $fiche_intervention->date_naiss_patient }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Téléphone :</b></td>
                            <td>
                                {{ $fiche_intervention->portable_patient }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h6 class="text-primary"><strong>INTERVENTION</strong></h6>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Chirurgien :</b> <span class="text-danger">*</span></td>
                            <td>
                                {{ $fiche_intervention->medecin }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Aide opératoire :</b> </td>
                            <td>
                                {{ $fiche_intervention->aide_op }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Type :</b> </td>
                            <td>
                                {{ $fiche_intervention->type_intervention }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Durée :</b> </td>
                            <td>
                                {{ $fiche_intervention->dure_intervention }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Position du patient :</b></td>
                            <td>
                                {{ $fiche_intervention->position_patient }}
                                @if(!empty($fiche_intervention->decubitus))
                                    {{ $fiche_intervention->decubitus }}
                                @endif
                                @if(!empty($fiche_intervention->laterale))
                                    {{ $fiche_intervention->laterale }}
                                @endif
                                @if(!empty($fiche_intervention->lombotomie))
                                    {{ $fiche_intervention->lombotomie }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><b>Date intervention :</b> </td>
                            <td>
                                {{ $fiche_intervention->date_intervention }}
                            </td>
                        </tr>
                        @if(!empty($fiche_intervention->hospitalisation))
                        <tr>
                            <td><b>Hospitalisation :</b> </td>
                            <td>
                                {{ $fiche_intervention->hospitalisation }}
                            </td>
                        </tr>
                        @endif
                        @if(!empty($fiche_intervention->ambulatoire))
                        <tr>
                            <td><b>Ambulatoire :</b> </td>
                            <td>
                                {{ $fiche_intervention->ambulatoire }}
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td><b>Anesthésie :</b> <span class="text-danger">*</span></td>
                            <td>
                                {{ $fiche_intervention->anesthesie }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>RECOMMENDATION(S) :</b></td>
                            <td>
                                {{ $fiche_intervention->recommendation }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <p class="offset-8"><b>Dr {{ auth()->user()->name }}</b></p>
        <div class="text-center col-6 offset-2">
            <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small>
            <small>www.cmcu-cm.com</small>
        </div>
    </footer>
</div>
