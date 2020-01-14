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
    <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/list@4.3.0/main.min.css">
    <style>
        /* ... */
    </style>
</head>

<body>
    <div class="wrapper">
        @include('partials.side_bar')
        <div class="container">
            @include('partials.header')
            <div class="col-md-12">
                @include('partials.flash')
                <div class="row mt-0">
                    <div class="col-md-12" id="calendar">

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
                                    <!-- Salut! Je suis un gentil petit commentaire. Lisez-moi avec beaucoup d'attention car je peux être très important! -->
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
    </div>
    <script src="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js"></script>
    <script src="https://unpkg.com/@fullcalendar/timeline@4.3.0/main.min.js"></script>
    <script src="https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js"></script>
    <script src="https://unpkg.com/@fullcalendar/list@4.3.0/main.min.js"></script>


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
                events: [{
                        title: 'Patient N° 1',
                        resourceId: 'a1', // start out in resource 'b1'
                        description: 'description for All Day Event',
                        start: '2020-01-10T10:00:00',
                        end: '2020-01-10T11:00:00',
                        url: 'http://google.com/',

                    },
                    {
                        title: 'Patient N° 2',
                        resourceId: 'a2', // start out in resource 'a2'
                        description: 'description du Patient N° 2',
                        start: '2020-01-11T08:00:00',
                        end: '2020-01-11T08:45:00',
                        url: 'http://google.com/',

                    },
                    {
                        title: 'Patient N° 3',
                        resourceId: 'b1', // start out in resource 'b1'
                        description: 'description du Patient N° 3',
                        start: '2020-01-11T08:00:00',
                        end: '2020-01-11T08:30:00',
                        url: 'http://google.com/',

                    },
                    {
                        title: 'Patient N° 5',
                        resourceId: 'b1', // start out in resource 'b1'
                        description: 'description du Patient N° 5',
                        start: '2020-01-10T08:30:00',
                        end: '2020-01-10T09:00:00',
                        url: 'http://google.com/',

                    },
                    {
                        title: 'Patient N° 4',
                        resourceId: 'b2', // start out in resource 'b1'
                        description: 'description du Patient N° 4',
                        start: '2020-01-12T11:30:00',
                        end: '2020-01-12T12:00:00',
                        url: 'http://google.com/',

                    },
                ],
                //events: 'https://fullcalendar.io/demo-events.json',
                eventClick: function(info) {
                    eventObj = info.event;
                    info.jsEvent.preventDefault();
                    $('#info_RV_patient').text(eventObj.title);
                    $('#info_RV_objet').text(eventObj.extendedProps.objet);
                    //$('#info_RV_objet').text(@json($events)[0].start_time);
                    //$('#info_RV_objet').text(events);
                    // date et heure
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
            if (eventObj.url) {
                window.open(eventObj.url);
                info.jsEvent.preventDefault(); // prevents browser from following link in current tab.
            } else {
                alert('Clicked ' + eventObj.title);
            }

        });
        $('#supprimer_rv').on('click', function() {
            var supprimer = confirm('Voulez-vous supprimer ce rendez-vous?');
            if (supprimer) {
                $('#info_RV').modal('hide');
                eventObj.remove()
                alert('supression éffectuée ! ');
            }
        });
    </script>
    <script>
        function myFunction() {
            if (!confirm("Veuillez confirmer la suppréssion du rendez-vous"))
                event.preventDefault();
        }
        // window.onbeforeunload = function(e) {
        //     var e = e || window.event;

        //     // For IE and Firefox
        //     if (e) {
        //         e.returnValue = 'Quiter cette page ?';
        //     }

        //     // For Safari
        //     return 'Quiter cette page ?';
        // };
    </script>
</body>

</html>