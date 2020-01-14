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
    <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/resource-timeline@4.3.0/main.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/timeline@4.3.0/main.min.css">
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
                    <div id="calendar">

                    </div>
                </div>
            </div>


            <!-- The Modal -->
            <div class="modal fade" id="info_RV">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Que voulez-vous faire ?</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <h4 class="mt-3">Informations de ce rendez-vous</h4>
                            <hr class="mt-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p><span>Patient:</span> <span class="font-weight-bold" id="info_RV_patient"></span></p>
                                    <p><span>Objet:</span> <span class="font-weight-bold" id="info_RV_objet"></span></p>
                                    <p><span>Médecin:</span> <span class="font-weight-bold" id="info_RV_medecin"></span></p>
                                    <!-- Salut! Je suis un gentil petit commentaire. Lisez-moi avec beaucoup d'attention car je peux être très important! -->
                                    <p class="border border-info rounded p-3 my-3 text-nowrap"><span class="text-info align-top"><i class="fas fa-exclamation-circle"></i></span>&nbsp<i id="info_RV_description" class="text-wrap"></i></p>

                                    <p class="mt-2 mx-0 text-sm-right"><i id="info_RV_dateheure"></i></p>
                                    <hr>
                                </div>

                                <div class="col-sm-12">
                                    <button class="btn btn-outline-success" id="ouvrir_dossier_patient"><i class="fas fa-folder"></i> Ouvrir le dossier patient</button>
                                    <button class="btn btn-outline-danger" id="supprimer_rv"><i class="fas fa-trash"></i> Supprimer ce rendez-vous</button>
                                </div>

                            </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- The Modal -->
            <div class="modal fade" id="nouveauRV">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Nouveau Rendez-vous</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="sel1">Patient:</label>
                                        <select class="form-control" id="patient">
                                            <option></option>
                                            <option>Patient N° 1</option>
                                            <option>Patient N° 2</option>
                                            <option>Patient N° 3</option>
                                            <option>Patient N° 4</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="medecin">Médecin:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Dr</span>
                                            </div>
                                            <input type="text" class="form-control" id="medecin" readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-5 ">
                                    <span class="mt-3">Objet:</span>
                                    <div class="form-check  ml-2">
                                        <label class="form-check-label"><input type="radio" class="form-check-input" value="Consultation" name="objet">Consultation</label>
                                    </div>
                                    <div class="form-check ml-2">
                                        <label class="form-check-label"><input type="radio" class="form-check-input" value="Examen" name="objet">Examen</label>
                                    </div>
                                    <div class="form-check ml-2">
                                        <label class="form-check-label"><input type="radio" class="form-check-input" value="Acte" name="objet">Acte</label>
                                    </div>
                                    <div class="form-check ml-2">
                                        <label class="form-check-label"><input type="radio" class="form-check-input" value="Autres" name="objet">Autres</label>
                                    </div>
                                </div>

                                <div class="col-sm-7">
                                    <div class="form-group mt-3">
                                        <label for="date">Date:</label>
                                        <input type="text" class="form-control" id="date" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="heure">Heure:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_time" readonly>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> - </span>
                                            </div>
                                            <input type="text" class="form-control" id="end_time" readonly>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description">Commentaire:</label>
                                        <textarea class="form-control" rows="2" id="description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal" id="enregistrer">Enregistrer</button>
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
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
    <script src="https://unpkg.com/@fullcalendar/resource-common@4.3.1/main.min.js"></script>
    <script src="https://unpkg.com/@fullcalendar/resource-timeline@4.3.0/main.min.js"></script>

    <script>
        $('#nouveauRV').on('shown.bs.modal', function() {
            $('#patient').focus();
        })
    </script>
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
                plugins: ['interaction', 'resourceTimeline'],
                selectable: true,
                selectOverlap: false,
                eventOverlap: false, //pas de chevauchement
                slotDuration: '00:15:00', // unité de temps
                locale: 'fr',
                //timeZone: 'UTC',
                scrollTime: '08:00:00',
                defaultView: 'resourceTimelineDay',
                aspectRatio: 2,
                resourceAreaWidth: '15%',
                editable: true,
                eventTextColor: 'white',
                resourceLabelText: 'Médecins',
                //minTime: '08:00:00', // heure de début (Affichage)
                //maxTime: '17:00:00',
                // displayEventTime: true,
                // displayEventEnd: true,
                resourceRender: function(info) {
                    var questionMark = document.createElement('a');

                    questionMark.innerText = info.el.innerText;
                    questionMark.href = "events/medecin/"+info.resource.id;
                    info.el.style.cursor = 'pointer';
                    info.el.querySelector('.fc-cell-text').innerText = '';
                    info.el.querySelector('.fc-cell-text').appendChild(questionMark);


                },
                businessHours: [{
                        daysOfWeek: [1, 2, 3, 4, 5], // Mon,Tue,Wed,Thu,Fri
                        startTime: '08:00',
                        endTime: '13:00',
                    },
                    {
                        daysOfWeek: [1, 2, 3, 4, 5], // Mon,Tue,Wed,Thu,Fri
                        startTime: '14:00',
                        endTime: '17:00',
                    },

                ],
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today',
                },
                resources: [{
                        id: 13,
                        eventColor: 'Chocolate',
                        title: 'NJINOU',
                        url: 'google.com',
                        businessHours: [{
                                startTime: '11:00',
                                endTime: '13:00',
                                daysOfWeek: [1, 3, 5] // Mon,Wed,Fri
                            },
                            {
                                startTime: '14:00',
                                endTime: '17:00',
                                daysOfWeek: [1, 3, 5] // Mon,Wed,Fri
                            }
                        ],
                    }, {
                        id: 14,
                        title: 'KAMADJOU Cyril',
                        eventColor: 'DarkCyan',
                    },
                    {
                        id: 16,
                        eventColor: 'Plum',
                        title: 'KUITCHE Jerry'
                    }, {
                        id: 29,
                        eventColor: 'SteelBlue',
                        title: 'EYOMGETA Divine'
                    },
                ],

                events: [{
                        title: 'Patient N° 1',
                        resourceId: 13, // start out in resource 16
                        description: 'description for All Day Event',
                        start: '2020-01-10T10:00:00',
                        end: '2020-01-10T11:00:00',
                        url: 'http://google.com/',
                        constraint: {
                            constraint: 'businessHours',
                            resourceIds: [13, 29] // constrain dragging to these
                        }
                    },
                    {
                        title: 'Patient N° 2',
                        resourceId: 14, // start out in resource 14
                        description: 'description du Patient N° 2',
                        start: '2020-01-10T08:00:00',
                        end: '2020-01-10T08:45:00',
                        url: 'http://google.com/',
                        constraint: {
                            resourceIds: [29, 16] // constrain dragging to these
                        }
                    },
                    {
                        title: 'Patient N° 3',
                        resourceId: 16, // start out in resource 16
                        description: 'description du Patient N° 3',
                        start: '2020-01-10T08:00:00',
                        end: '2020-01-10T08:30:00',
                        url: 'http://google.com/',
                        constraint: {
                            resourceIds: [29, 16, 13, 14] // constrain dragging to these
                        }
                    },
                    {
                        title: 'Patient N° 5',
                        resourceId: 16, // start out in resource 16
                        description: 'description du Patient N° 5',
                        start: '2020-01-10T08:30:00',
                        end: '2020-01-10T09:00:00',
                        url: 'http://google.com/',
                        constraint: {
                            resourceIds: [29, 16, 13, 14] // constrain dragging to these
                        }
                    },
                    {
                        title: 'Patient N° 4',
                        resourceId: 29, // start out in resource 16
                        description: 'description du Patient N° 4',
                        start: '2020-01-10T11:30:00',
                        end: '2020-01-10T12:00:00',
                        url: 'http://google.com/',
                        constraint: {
                            resourceIds: [29, 16, 13, 14] // constrain dragging to these
                        }
                    },
                ],
                eventDrop: function(info) {
                    alert(info.event.title + " a été affecté au Dr " + info.newResource.title);
                },

                eventClick: function(info) {
                    eventObj = info.event;
                    info.jsEvent.preventDefault();
                    $('#info_RV_patient').text(eventObj.title);
                    $('#info_RV_objet').text(eventObj.extendedProps.objet);
                    //ressources
                    var resources = eventObj.getResources();
                    var resourceTitles = resources.map(function(resource) {
                        return resource.title
                    });

                    $('#info_RV_medecin').text('Dr ' + resourceTitles);
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

                select: function(info) {
                    nouveau_rv = info;
                    $("#nouveauRV").modal('show');
                },

                slotLabelFormat: {
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: 'short'
                },

            });

            $('#nouveauRV').on('show.bs.modal', function() {
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                };

                $(this).find('#date').val(nouveau_rv.start.toLocaleDateString('fr-FR', options));

                $(this).find('#start_time').val(nouveau_rv.start.toLocaleTimeString('fr-FR'));
                $(this).find('#end_time').val(nouveau_rv.end.toLocaleTimeString('fr-FR'));
                $(this).find('#medecin').val(nouveau_rv.resource.title);

            });

            $('#nouveauRV').on('click', '#enregistrer', function() {
                var patient = $("#patient option:selected").text();
                var description = $('#description').val();
                var objet = $("input[name='objet']:checked").val();
                newEvent = calendar.addEvent({
                    //id: Math.random(),
                    title: patient,
                    start: nouveau_rv.start,
                    end: nouveau_rv.end,
                    resourceId: nouveau_rv.resource.id.toString(),
                    description: description,
                    objet: objet,
                });
            });



            calendar.render();
        });
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