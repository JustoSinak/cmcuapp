@extends('layouts.admin')

@section('title', 'CMCU | Liste des devis')

@section('content')

<body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
        @include('partials.side_bar')

        <!-- Page Content Holder -->
        @include('partials.header')
        <!--// top-bar -->
        @can('create', \App\Models\Patient::class)
        <div class="container">
            <h1 class="text-center">LISTE DES DEVIS</h1>
        </div>
        <hr>
        <div class="container pt-3">
            <div class="row">
                <div class="col-sm-12 panneau_d_affichage">
                    <div class="table-responsive">
                        @include('partials.flash')
                        <table id="myTable" class="table table-bordered table-hover w-100">
                            <thead>
                                <th>NOM</th>
                                <th>ACTION</th>
                            </thead>
                            <tbody>
                                @foreach($devis as $devi)
                                <tr>
                                    <td>{{ $devi->nom}}</td>
                                    <td>
                                        @can('print', \App\Models\Devi::class)
                                        <button type="button" data-devi='@json($devi)' data-champ_patient="" data-toggle="modal" data-title="Impression devis ..." data-texte="Vous pouvez effectuez des modifications si nécessaire." data-target="#imprimer_devis" class="btn btn-sm btn-info mr-1" title="Attribuer le divis à un patient"><i class="fas fa-eye"></i></button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @can('create', \App\Models\Devi::class)
        <div class="text-center table_link_right">
            <button type="button" data-toggle="modal" data-title="Nouveau devis ..." data-texte="" data-target="#imprimer_devis" class="btn  btn-primary mr-1" title="Vous allez jouter un nouveau devis " data-champ_patient="d-none">Nouveau</button>
        </div>
        @endcan

    </div>
    <!-- The Modal -->
    <div class="modal fade" id="imprimer_devis">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>


                <!-- Modal body -->
                <div class="modal-body">
                    <div>
                        <p class="text-success description my-2"></p>
                        <form id="devis_form" action="" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4 champ_patient">
                                    <label for="patient">Nom du patient :</label>
                                    <select class="form-control" id="patient" name="patient">
                                        @foreach($patients as $patient)
                                        <option>{{ $patient->name.' '.$patient->prenom }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control d-none" id="">
                                    <br>
                                </div>
                                <div class="col-sm-4 d-flex align-items-center  ">
                                    <label class="form-check-label ml-4">
                                        <input type="checkbox" class="form-check-input" id="saisir_nom" value="">Saisir le nom
                                    </label>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="row nom_devis">
                                @can('update', \App\Models\Devi::class)
                                <div class="col-4 form-group">
                                    <label for="nom_devis">Devis de :</label>
                                    <input type="text" name="nom_devis" class="form-control" id="nom_devis" required>
                                </div>
                                <div class="col-4 form-group">
                                    <label for="code_devis">Code :</label>
                                    <input type="text" name="code_devis" class="form-control" id="code_devis" required>
                                </div>
                                <div class="col-4 form-group">
                                    <label for="acces_devis">Type :</label>
                                    <select class="form-control" id="acces_devis" name="acces_devis">
                                        <option value="acte">Acte</option>
                                        <option value="bloc">Bloc</option>
                                    </select>
                                </div>
                                @elsecan('print', \App\Models\Devi::class)
                                <div class="col-8 form-group">
                                    <label for="nom_devis">Devis de :</label>
                                    <input type="text" name="nom_devis" class="form-control" id="nom_devis" required>
                                </div>
                                <div class="col-4 form-group">
                                    <label for="code_devis">Code :</label>
                                    <input type="text" name="code_devis" class="form-control" id="code_devis" required>
                                </div>
                                @endcan
                            </div>
                            <div class="container">
                                <div class="row my-2">
                                    <div class="col-sm-1 text-center" style="background-color:lavender;">
                                        <small>#</small>
                                    </div>
                                    <div class="col-sm-4" style="background-color:lavenderblush;">
                                        <strong>Elément</strong>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <strong>Quantité</strong>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavenderblush;">
                                        <strong>Prix U.</strong>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <strong>Prix</strong>
                                    </div>
                                    <div class="col-sm-1 text-center p-0" style="background-color:lavenderblush;">
                                        <strong>Sup</strong>
                                    </div>
                                </div>
                                <div class="row my-2 ajouter_ligne">
                                    <div class="col-sm-12 text-center">
                                        <button type="button" class="btn text-primary btn-outline-info float-left">
                                            <i class="fa fa-plus-circle"></i>
                                        </button>
                                        <p class=" float-right total1 text-danger">Total 1: <strong>0</strong> FCFA</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 pl-0 mt-2">
                                        <label class="text-primary form-check-label ml-4">
                                            <input type="checkbox" class="form-check-input " id="hospitalisation" value="">Hospitalisation
                                        </label>
                                    </div>
                                </div>

                                <div class="row my-2 hospitalisation d-none">
                                    <div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;">
                                        <small>1</small>
                                    </div>
                                    <div class="col-sm-4" style="background-color:lavenderblush;">
                                        <input type="text" name="" class="form-control element" value="Chambre" readonly>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" name="nbr_chambre" id="nbr_chambre" class="form-control" value=0>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavenderblush;">
                                        <input type="number" name="pu_chambre" class="form-control" id="pu_chambre" value=30000 required>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" id="chambre" name="chambre" value=0 class="form-control ">
                                    </div>
                                    <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;">
                                       
                                    </div>
                                </div>
                                <div class="row hospitalisation d-none my-2">
                                    <div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;">
                                        <small>2</small>
                                    </div>
                                    <div class="col-sm-4" style="background-color:lavenderblush;">
                                        <input type="text" name="" class="form-control element" readonly value="Visite">
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number"id="nbr_visite"  name="nbr_visite" class="form-control" value=0>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavenderblush;">
                                        <input type="number" name="pu_visite" class="form-control" id="pu_visite" value=10000 required>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" name="visite" id="visite" value=0 class="form-control">
                                    </div>
                                    <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;">
                                       
                                    </div>
                                </div>
                                <div class="row hospitalisation d-none my-2">
                                    <div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;">
                                        <small>3</small>
                                    </div>
                                    <div class="col-sm-4" style="background-color:lavenderblush;">
                                        <input type="text" name="" class="form-control element" value="AMI-JOUR (750*12)" readonly>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" id="nbr_ami_jour"  name="nbr_ami_jour" class="form-control" value=0>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavenderblush;">
                                        <input type="number" name="pu_ami_jour" class="form-control" id="pu_ami_jour" value=9000 required>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" id="ami_jour" name="ami_jour" value=0 class="form-control">
                                    </div>
                                    <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;">
                                        
                                    </div>
                                </div>
                                <div class="row hospitalisation d-none my-2">
                                    <div class="col-sm-12 d-flex align-items-center justify-content-end">
                                        <p class=" float-right total2 text-danger">Total 2: <strong>0</strong> FCFA</p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <p class="float-right total">Total : <strong>0</strong> FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer px-0">
                    <div class="col-12">
                        @can('update', \App\Models\Devi::class)
                        <button type="submit" class="btn btn-info devis_save" data-dismiss="modal">Enregistrer</button>
                        @endcan
                        <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary float-right mx-3 devis_export" data-dismiss="modal">Exporter</button>

                    </div>

                </div>


            </div>
        </div>
    </div>
    @endcan

</body>
@section('script')
<script src="{{ asset('admin/js/devis/convert_chiffre_lettre.js') }}"></script>
<script>
    $(document).ready(function() {

        $("#imprimer_devis").on('show.bs.modal', function(e) {
            $(".ligne").remove(); //supprime les ligne chargé précédemment dans le formulaire du modal
            $('.ajouter_ligne').find('button').removeClass('d-none');
            $(this).find('.description').text($(e.relatedTarget).data('texte'));
            $(this).find('.modal-title').text($(e.relatedTarget).data('title'));
            $(this).find('.champ_patient').parent().addClass($(e.relatedTarget).data('champ_patient')); //rend le champ nom du patient visible ou pas en fonction du bouton cliqué.
            let devi = $(e.relatedTarget).data('devi'); //charge le devis à imprimer ou modifier (vide si création d'un nouveau)

            // rendre les dévis non modifiables
            let dnone = " d-none ";
            let ro = true;
            //Le gestionnaire et l'admin modifient tous les devis
            @can('update', \App\Models\Devi::class)
            dnone = "";
            ro = false;
            @endcan



            if (devi) { // modification (click sur le bouton dans la colonne "action")

                //Gestionnaire, secretaire et admin peuvent modifier les devis de type "acte"
                if (devi.acces == 'acte') {
                    dnone = "";
                    ro = false;
                }

                //Chargement des éléments du dévis selectionné dans le formulaire du modal
                devi.ligne_devis.forEach(ligneDevi => {
                    $(".ajouter_ligne").before('<div class="row ligne my-2">' +
                        ' <div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;">' +
                        '<small></small>' +
                        ' </div>' +
                        ' <div class="col-sm-4" style="background-color:lavenderblush;">' +
                        '<input type="text" name="" class="form-control element" value="' + ligneDevi.element + '"  >' +
                        '</div>' +
                        '<div class="col-sm-2" style="background-color:lavender;">' +
                        ' <input type="number" name="" class="form-control quantite" value="' + ligneDevi.quantite + '" >' +
                        '</div>' +
                        '<div class="col-sm-2" style="background-color:lavenderblush;">' +
                        '<input type="number" name="" class="form-control prix_u" value="' + ligneDevi.prix_u + '" >' +
                        '</div>' +
                        '<div class="col-sm-2" style="background-color:lavender;">' +
                        '<input type="number" name="" class="form-control prix"  value="' + ligneDevi.quantite * ligneDevi.prix_u + '">' +
                        ' </div>' +
                        ' <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;">' +
                        '<button class="btn  retirer_ligne m-auto  ' + dnone + ' text-danger"><i class="fa fa-minus-circle"></i></button>' +
                        '</div>' +
                        '</div>');
                });
                $('#hospitalisation').parent('.row').addClass(dnone);
                $('.ajouter_ligne').find('button').addClass(dnone);
                $('#nom_devis').val(devi.nom); //rempli le champ devis de...
                $('#acces_devis').val(devi.acces); //rempli le champ devis de...
                $('#code_devis').val(devi.code); //rempli le champ devis de...
                $('#nbr_chambre').val(devi.nbr_chambre); //rempli le champ devis de...
                $('#nbr_visite').val(devi.nbr_visite); //rempli le champ devis de...
                $('#nbr_ami_jour').val(devi.nbr_ami_jour); //rempli le champ devis de...
                $('#pu_chambre').val(devi.pu_chambre); //rempli le champ devis de...
                $('#pu_ami_jour').val(devi.pu_ami_jour); //rempli le champ devis de...
                $('#pu_visite').val(devi.pu_visite); //rempli le champ devis de...
                $('.hospitalisation').find('input').attr("readonly", ro);
                $(".total>strong").text(parseInt($('.total2>strong').text()) + parseInt($(".total1>strong").text())); //rempli le champ devis de...
                if (devi.nbr_chambre > 0) {
                    $('#hospitalisation').prop('checked', true);
                    $('.hospitalisation').removeClass('d-none');
                } else {
                    $('#hospitalisation').prop('checked', false);
                    $('.hospitalisation').addClass('d-none');
                }
                //$('#nbr_chambre').val(devi.nbr_chambre); //rempli le champ devis de...
                //$('#pu_chambre').val(devi.pu_chambre); //rempli le champ devis de...
                //$('#pu_ami_jour').val(devi.pu_ami_jour); //rempli le champ devis de...
                //$('#pu_visite').val(devi.pu_visite); //rempli le champ devis de...

                //calcul total 2
                $('.total2>strong').text(total2($("#nbr_chambre").val(), $("#pu_chambre").val(), $("#nbr_visite").val(), $("#pu_visite").val(), $("#nbr_ami_jour").val(), $("#pu_ami_jour").val()));
                $(".total>strong").text(parseInt($('.total2>strong').text()) + parseInt($(".total1>strong").text())); //rempli le champ devis de...
                $('#nom_devis').attr("readonly", ro); //rend ce dernier readonly ou non
                $('#code_devis').attr("readonly", ro); //rend ce dernier readonly ou non
                $('.ligne').find('input').attr("readonly", ro); // rend les champs du formulaire modifiable ou pas en fonction des droit recupérés plus haut
                $('#devis_form').attr('action', "{{asset('admin/devis/edit/')}}/" + devi.id) //affecte la route (modification) à l'attribu action du formulaire
                $('.devis_export').removeClass('d-none'); //rend le bouton imprimer devis invisible
                $('.champ_patient>select').attr('required', 'required');
                numeroLigne();
                total();
                totaux();
            } else {
                $('#nom_devis').val(''); //vide le champ nom devis si l'on a cliqué sur le bouton nouveau
                $('#devis_form').attr('action', "{{route('devis.store')}}"); //affecte la route (création) à l'attribu action du formulaire
                $('.devis_export').addClass('d-none'); //rend le bouton imprimer devis invisible
                $('#nom_devis').val(''); //reinitialise le champ devis de...
                $('#code_devis').val(''); //reinitialise le champ devis de...
                $('#nbr_visite').val(0); //reinitialise le champ devis de...
                $('#nbr_ami_jour').val(0); //reinitialise le champ devis de...
                $('#nbr_chambre').val(0); //reinitialise le champ devis de...
                $('#visite').val(0); //reinitialise le champ devis de...
                $('#ami_jour').val(0); //reinitialise le champ devis de...
                $('#chambre').val(0); //reinitialise le champ devis de...
                $('#pu_chambre').val(30000); //reinitialise le champ devis de...
                $('#pu_ami_jour').val(9000); //reinitialise le champ devis de...
                $('#pu_visite').val(10000); //reinitialise le champ devis de...
                $(".total2>strong").text('0'); //remet total2 à 0 ...
                $(".total1>strong").text('0'); //remet total1 à 0 ...
                $(".total>strong").text('0'); //remet total à 0 ...
                $('#hospitalisation').prop('checked', false);
                $('.hospitalisation').addClass('d-none');
            }

        });
        $("#imprimer_devis").on('hide.bs.modal', function(e) {
            $(this).find('.champ_patient').parent().removeClass('d-none');

        });
    });
</script>

<script src="{{ asset('admin/js/ui/1.12.1/jquery-ui.js') }}"></script>
<script>
    // numerotation des lignes de devis
    function numeroLigne() {
        $(".ligne").each(function(index) {
            $(this).find('div>small').text(index);
            $(this).find('div>.element').attr('name', 'ligneDevi[' + index + '][element]');
            $(this).find('div>.quantite').attr('name', 'ligneDevi[' + index + '][quantite]');
            $(this).find('div>.prix_u').attr('name', 'ligneDevi[' + index + '][prix_u]');
        });
    }

    //calcul du total du devis
    function total() {
        let total = 0;
        $(".ligne").each(function(index) {
            total += parseInt($(this).find('div>.prix').val());
        });
        $('#imprimer_devis').find('.total1>strong').text(total);
    }

    $(document).ready(numeroLigne());
    // ajout d'une nouvele ligne devis
    $(".ajouter_ligne>div>button").click(function() {
        $(".ajouter_ligne").before('<div class="row ligne my-2">' +
            ' <div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;">' +
            '<small>#</small>' +
            ' </div>' +
            ' <div class="col-sm-4" style="background-color:lavenderblush;">' +
            '<input type="text" name="" class="form-control element">' +
            '</div>' +
            '<div class="col-sm-2" style="background-color:lavender;">' +
            ' <input type="number" name="" class="form-control quantite" value=0>' +
            '</div>' +
            '<div class="col-sm-2" style="background-color:lavenderblush;">' +
            '<input type="number" name="" class="form-control prix_u" value=0>' +
            '</div>' +
            '<div class="col-sm-2" style="background-color:lavender;">' +
            '<input type="number" name="" value=0 class="form-control prix">' +
            ' </div>' +
            ' <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;">' +
            '<button class="btn  retirer_ligne m-auto text-danger"><i class="fa fa-minus-circle"></i></button>' +
            '</div>' +
            '</div>');

        numeroLigne();
    });
    $("body").on('change', ".prix_u", function() {
        let qte = $(this).parent().parent().find('.quantite').val();
        let prix_u = $(this).val();
        $(this).parent().parent().find('.prix').val(qte * prix_u);
        total();
        totaux()
    })
    $("body").on('change', ".quantite", function() {
        let prix_u = $(this).parent().parent().find('.prix_u').val();
        let qte = $(this).val();
        $(this).parent().parent().find('.prix').val(qte * prix_u);
        total();
        totaux()
    })
    $("body").on('click', '.retirer_ligne', function(e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        numeroLigne();
        total();
        totaux()
    });
    //permutation entre selection d'un nom et saisi d'un nouveau nom
    $('#saisir_nom').on('click', function() {
        if ($("#saisir_nom:checked").length) {
            $('.champ_patient>input').attr({
                'required': true,
                'name': 'patient'
            });
            $('.champ_patient>select').attr({
                'required': false,
                'name': ''
            });
            $('.champ_patient>input').removeClass("d-none");
            $('.champ_patient>select').addClass("d-none");
        } else {
            $('.champ_patient>input').attr({
                'required': false,
                'name': ''
            });
            $('.champ_patient>select').attr({
                'required': true,
                'name': 'patient'
            });
            $('.champ_patient>input').addClass("d-none");
            $('.champ_patient>select').removeClass("d-none");
        }
    })
    //soumission - edition
    $(".devis_save").on("click", function(e) {
        e.preventDefault();
        $('#devis_form').submit();
    });

    //soumission - impression
    $(".devis_export").on("click", function(e) {
        e.preventDefault();
        $('#devis_form').attr('action', "{{asset('admin/devis/export/')}}/" + NumberToLetter(parseInt($('.total>strong').text()))).submit();
    });
    $("body")

    //hospitalisation
    $('#hospitalisation').on('click', function() {
        if ($("#hospitalisation:checked").length) {
            $(".hospitalisation").removeClass('d-none');
        } else {
            $(".hospitalisation").addClass('d-none');
        }

    });
    $("body").on('change', "#nbr_chambre, #nbr_visite, #nbr_ami_jour, #pu_chambre , #pu_visite, #pu_ami_jour", function() {
        let nbr_chambre = $('#nbr_chambre').val();
        let nbr_visite = $('#nbr_visite').val();
        let nbr_ami_jour = $('#nbr_ami_jour').val();
        let pu_chambre = $('#pu_chambre').val();
        let pu_visite = $("#pu_visite").val();
        let pu_ami_jour = $("#pu_ami_jour").val();
        $('.total2>strong').text(total2(nbr_chambre,pu_chambre,nbr_visite,pu_visite,nbr_ami_jour,pu_ami_jour));
        totaux();
    })

    function total2(nbr_chambre, pu_chambre, nbr_visite, pu_visite, nbr_ami_jour, pu_ami_jour){
        prix_chambre= parseInt(nbr_chambre) * parseInt(pu_chambre);
        prix_visite = parseInt(nbr_visite) * parseInt(pu_visite);
        prix_ami_jour = parseInt(nbr_ami_jour) * parseInt(pu_ami_jour);
        $('#chambre').val(prix_chambre);
        $('#visite').val(prix_visite);
        $('#ami_jour').val(prix_ami_jour);
        return prix_chambre + prix_visite + prix_ami_jour;
    }

    function totaux() {
        $(".total>strong").text(parseInt($('.total2>strong').text()) + parseInt($(".total1>strong").text()));
    }
</script>
@stop