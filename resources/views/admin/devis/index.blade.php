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
        @can('create', \App\Patient::class)
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
                                        @can('create', \App\Patient::class)
                                        <button class="btn btn-sm btn-info ouvrir_pe mr-1" title="Attribuer le divis à un patient"><i class="fas fa-print"></i></button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-6 panneau_d_edition d-none">
                    <div class="container">
                        <button class="btn float-right fermer_pe">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                        <h2 class="mb-3">Apreçu dévis</h2>
                        <p class="text-success">Vous êtes sur le point d'imprimer un dévis pour un patient !</p>
                        <p class="text-success">Veuillez effectuer les modifications si nécessaires.</p>
                        <div >
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
                            <div class="row ligne mb-2">
                                <div class="col-sm-1 text-center  d-flex align-items-center" style="background-color:lavender;">
                                    <small></small>
                                </div>
                                <div class="col-sm-4" style="background-color:lavenderblush;">
                                    <input type="text" name="" class="form-control element">
                                </div>
                                <div class="col-sm-2" style="background-color:lavender;">
                                    <input type="number" name="" class="form-control quantite" value=0>
                                </div>
                                <div class="col-sm-2" style="background-color:lavenderblush;">
                                    <input type="number" name="" class="form-control prix_u" value=0>
                                </div>
                                <div class="col-sm-2" style="background-color:lavender;">
                                    <input type="number" name="" class="form-control prix">
                                </div>
                                <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;">
                                    <button class="btn text-danger retirer_ligne"><i class="fa fa-minus-circle"></i></button>

                                </div>
                            </div>
                            <div class="row my-2 ajouter_ligne">
                                <button class="btn text-primary">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        @can('create', \App\Patient::class)
        <div class="text-center table_link_right">

            <a href="{{ route('devis.create') }}" class="btn btn-primary" title="Vous allez jouter un nouveau devis ">Nouveau</a>

        </div>
        @endcan

    </div>
    </div>
    @endcan

</body>
@section('script')

<script src="{{ asset('admin/js/ui/1.12.1/jquery-ui.js') }}"></script>
<script>
    function numeroLigne() {
        $(".ligne").each(function(index) {
            $(this).find('div>small').text(index);
            $(this).find('div>.element').attr('name', 'ligneDevi[' + index + ']["element"]');
            $(this).find('div>.quantite').attr('name', 'ligneDevi[' + index + ']["quantite"]');
            $(this).find('div>.prix_u').attr('name', 'ligneDevi[' + index + ']["prix_u"]');
        });

    }
    $(document).ready(numeroLigne());

    $(".ajouter_ligne>button").click(function() {
        $(".ajouter_ligne").before('<div class="row ligne my-2">' +
            ' <div class="col-sm-1 text-center  d-flex align-items-center" style="background-color:lavender;">' +
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
            '<input type="number" name="" class="form-control prix">' +
            ' </div>' +
            ' <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;">' +
            '<button class="btn  retirer_ligne"><i class="fa fa-minus-circle"></i></button>' +
            '</div>' +
            '</div>');
        $(".ligne:last>div>.retirer_ligne").addClass(" text-danger ")

        numeroLigne();
    });
    $("body").on('change', ".prix_u", function() {
        let qte = $(this).parent().parent().find('.quantite').val();
        let prix_u = $(this).val();
        $(this).parent().parent().find('.prix').val(qte * prix_u);
    })
    $("body").on('change', ".quantite", function() {
        let prix_u = $(this).parent().parent().find('.prix_u').val();
        let qte = $(this).val();
        $(this).parent().parent().find('.prix').val(qte * prix_u);
    })
    $("body").on('click', '.retirer_ligne', function(e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        numeroLigne();
    })
    $("body").on('click', '.ouvrir_pe', function(e) {
        e.preventDefault();
        $('.panneau_d_affichage').switchClass("col-sm-12", "col-sm-6", 500, function() {
            $('.panneau_d_edition').removeClass("d-none");
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    })
    $("body").on('click', '.fermer_pe', function(e) {
        e.preventDefault();
        $('.panneau_d_edition').addClass("d-none");
        $('.panneau_d_affichage').switchClass("col-sm-6", "col-sm-12", 500, function() {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
        
    })
</script>
@stop