<!doctype html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
    <link rel="stylesheet" href="{{ mix('css/all.css') }}" />
    <script src="{{ mix('js/all.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <link href="//fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <script src="{{ asset('admin/js/modernizr.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('admin/@fullcalendar/core@4.3.1/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/@fullcalendar/list@4.3.0/main.min.css') }}">
    <style>
        /* ... */
    </style>
</head>

<body>
    <div class="wrapper">
        @include('partials.side_bar')
        <div class="col-sm-10">
            @include('partials.header')
            <div class="col-md-12  toppad  offset-md-0 ">
                        <a href="{{ route('events.index') }}" class="btn btn-success float-right">
                            <i class="fas fa-arrow-left"></i>  Retour à l'agenda
                        </a>
                    </div>
            <div class="row mb-1">
                <div class="col-sm-12">
                    <h1 class="text-center ">AGENDA  - Dr {{ $medecin->name }} {{ $medecin->prenom }}</h1>
                </div>
            </div>
            
                <hr>
            <div class="col-md-10 mx-auto">
                
                @include('partials.flash')
                <div class="row mt-3">
                    <div style="width: 100%" id="calendar">

                    </div>
                </div>
            </div>


            <!-- The Modal -->
            <div class="modal fade" id="info_RV">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Informations de ce rendez-vous</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p><span>Patient:</span> <span class="font-weight-bold" id="info_RV_patient"></span>
                                    </p>
                                    <p><span>Objet:</span> <span class="font-weight-bold" id="info_RV_objet"></span></p>
                                    <p><span>Statut:</span> <span class="font-weight-bold" id="info_RV_statut"></span></p>
                                    <p class="border border-info rounded p-3 my-3 text-nowrap"><span class="text-info align-top"><i class="fas fa-exclamation-circle"></i></span>&nbsp<i id="info_RV_description" class="text-wrap"></i></p>

                                    <p class="mt-2 mx-0 text-sm-right"><i id="info_RV_dateheure"></i></p>

                                </div>

                                <div class="col-sm-12">

                                </div>

                            </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button class="btn btn-outline-success" id="ouvrir_dossier_patient"><i class="fas fa-folder"></i> Ouvrir le dossier patient</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="{{ asset('admin/@fullcalendar/core@4.3.1/main.min.js') }}"></script>
    <script src="{{ asset('admin/@fullcalendar/timeline@4.3.0/main.min.js')}}"></script>
    <script src="{{ asset('admin/@fullcalendar/interaction@4.3.0/main.min.js')}}"></script>
    <script src="{{ asset('admin/@fullcalendar/list@4.3.0/main.min.js')}}"></script>


    <script>
        //paste this code under head tag or in a seperate js file.
        // Wait for window load
        $(window).load(function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");;
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".dropdown").hover(
                function() {
                    $('.dropdown-menu', this).stop(true, true).slideDown("fast");
                    $(this).toggleClass('open');
                },
                function() {
                    $('.dropdown-menu', this).stop(true, true).slideUp("fast");
                    $(this).toggleClass('open');
                }
            );
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                plugins: ['interaction', 'list'],
                locale: 'fr',
                defaultView: 'listWeek',
                aspectRatio: 2,
                // customize the button names,
                // otherwise they'd all just say "list"
                views: {
                    listDay: {
                        buttonText: 'Jour'
                    },
                    listWeek: {
                        buttonText: 'Semaine'
                    },
                    listMonth: {
                        buttonText: 'Mois'
                    }
                },

                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'listDay,listWeek,listMonth'
                },
                events: [
                    @foreach($events as $event) {
                        id : {{$event->id}},
                        title: '{{$event->title}}',
                        start: new Date('{{ $event->start}} UTC'),
                        state: '{{$event->state}}',
                        statut: '{{$event->statut}}',
                        end: new Date('{{ $event->end}} UTC'),
                        objet: '{{ $event->objet}}',
                        description: '{{ $event->description}}',
                        backgroundColor: setcolor('{{$event->statut}}'),
                        borderColor:setcolor('{{$event->statut}}'),
                        patient:{ id: {{$event->patients->id}}, name:' {{$event->patients->name}} {{$event->patients->prenom}}',},
                    },
                    @endforeach
                ],
                eventClick: function(info) {
                    eventObj = info.event;
                    info.jsEvent.preventDefault();
                    $('#info_RV_patient').text(eventObj.extendedProps.patient.name);
                    $('#info_RV_objet').text(eventObj.extendedProps.objet);
                    $('#info_RV_statut').text(eventObj.extendedProps.statut);
                    
                    var jour = eventObj.start.toLocaleDateString('fr-FR', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                    });
                    var debut = eventObj.start.toLocaleTimeString('fr-FR');
                    var fin = eventObj.end.toLocaleTimeString('fr-FR');
                    $('#info_RV_dateheure').text('Prévu pour '.concat(jour, ', de ', debut, ' à ', fin));
                    //description
                    $('#info_RV_description').text(eventObj.extendedProps.description);
                    $('#info_RV').modal();

                },
            });

            calendar.render();
        });
    </script>
    <script>
    </script>

    <script>
        $('#ouvrir_dossier_patient').on('click', function() {
            $('#info_RV').modal('hide');
            let url = '{{ route("patients.show", ":id") }}';
            url = url.replace(':id', eventObj.extendedProps.patient.id);
            window.open(url);
            

        });
        function setcolor(statut){
            switch (statut) {
                case "a venir":
                    return 'SteelBlue';
                    break;

                case "vu":
                    return 'DarkCyan';
                    break;
                case "absence excusé":
                    return 'Plum';
                    break;
                case "absence non excusé":
                    return 'SlateBlue';
                    break;
                case "reporté":
                    return 'Tomato';
                    break;
            
                default:
                    return 'SteelBlue';
                    break;
            }
        }
    </script>
</body>

</html>