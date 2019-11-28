<!DOCTYPE html>
<html lang="fr">

<head>
    <title>
        @yield('title', 'CMCU')
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);
        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
    <link rel="stylesheet" href="{{ mix('css/all.css') }}"/>
    <link rel="stylesheet" href="{{ asset('admin/datatables/css/dataTables.bootstrap4.css') }}"/>
    <link rel="shortcut icon" type="image/png" href="{{ asset('admin/images/faviconlogo.ico') }}"/>

    <link href="//fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">

    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">



</head>
<div id="myModal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('admin/images/licence_image.jpg') }}" class="offset-4">
            </div>
            <div class="modal-body">
                @include('partials.flash_form')
                <h1 class="text-center text-danger">VOTRE LICENCE A EXPIRE</h1>
                <br>
                <br>
                <form action="{{ route('active_licence_key') }}" method="POST" class="form-group">
                    @csrf
                    <label for=""><b>Veuillez saisir la clé de licence reçu par mail ici</b></label>
                    <textarea name="license_key" cols="30" rows="5" class="form-control" required></textarea>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check text-danger"></i> Valider</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
@yield('content')



<script src="{{ mix('js/all.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/typehead.js') }}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>--}}
<script src="{{ asset('admin/datatables/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('admin/datatables/js/dataTables.bootstrap4.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>




<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
{{--<script>--}}
{{--CKEDITOR.replace( 'summary-ckeditor' );--}}
{{--CKEDITOR.replace( 'summary-ckeditor1' );--}}

{{--</script>--}}

<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            scrollY: 300,
            paging: true,
            processing: true,
            info: false,
            ordering: false,
            language: {
                processing:     "Traitement en cours...",
                search:         "Rechercher&nbsp;:",
                lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
                info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                infoPostFix:    "",
                loadingRecords: "Chargement en cours...",
                zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                emptyTable:     "Aucune donnée disponible dans le tableau",
                paginate: {
                    first:      "Premier",
                    previous:   "Pr&eacute;c&eacute;dent",
                    next:       "Suivant",
                    last:       "Dernier"
                },
                aria: {
                    sortAscending:  ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                }
            }
        });
        $('.filter-select').change(function () {
            table.column( $(this).data('column'))
                .search( $(this).val())
                .draw();
        });
    } );
</script>

<script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    $('#search').typeahead({
        minLength: 1,
        hint: true,
        highlight: true,
        source:  function (query, process) {
            return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        },
    });
</script>

<script>
    $(document).ready(function () {
        $(".tbtn").click(function () {
            $(this).parents(".custom-table").find(".toggler1").removeClass("toggler1");
            $(this).parents("tbody").find(".toggler").addClass("toggler1");
            $(this).parents(".custom-table").find(".fa-minus-circle").removeClass("fa-minus-circle");
            $(this).parents("tbody").find(".fa-plus-circle").addClass("fa-minus-circle");
        });
    });
</script>

@php
    $licence = \App\Licence::where('client', 'cmcuapp')->first();
@endphp

@if ($licence->expire_date <= \Carbon\Carbon::now())
    <script type="text/javascript">
        $(window).on('load',function(){
            $('#myModal').modal('show');
        });
    </script>
@endif

@include('flashy::message')

</html>
