<!doctype html>
<html lang="fr">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .btnavenir {
            border-color: SteelBlue;
        }
        .btnvu {
            border-color: DarkCyan;
        }
        .btnae {
            border-color: Plum;
        }
        .btnan {
            border-color: SlateBlue;
        }
        .btnreporte {
            border-color: Tomato;
        }
        .btnavenir:hover {
            background-color: SteelBlue;
        }
        .btnvu:hover {
            background-color: DarkCyan;
        }
        .btnae:hover {
            background-color: Plum;
        }
        .btnan:hover {
            background-color: SlateBlue;
        }
        .btnreporte:hover {
            background-color: Tomato;
        }

    </style>
</head>

<body>
    <div class="wrapper">
        @include('partials.side_bar')
        <div class="container_fluid">
            @include('partials.header')
            <div class="row mb-1">
                    <div class="col-sm-12">
                        <h1 class="text-center ">AGENDA</h1>
                    </div>
                </div>
                <hr>
            <div class="col-md-10 mx-auto">
                @include('partials.flash')
                <div class="row  mt-3">
                    <div id="calendar">

                    </div>
                </div>
            </div>


            <!-- The Modal -->
            <div class="modal fade" id="info_RV">
                <div class="modal-dialog modal-lg">
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

                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-outline-success" id="ouvrir_dossier_patient"><i class="fas fa-folder"></i> Ouvrir le dossier patient</button>
                                    @can('create', \App\Event::class)
                                    <button class="btn btn-outline-danger" id="supprimer_rv"><i class="fas fa-trash"></i> Supprimer ce rendez-vous</button>
                                    <button type="button" class="btn btn-outline-primary" data-toggle="collapse" data-target="#demo">Statut</button>
                                    @endcan
                                </div>

                                <div id="demo" class=" col-sm-12 collapse text-center">
                                    <hr>
                                    <button class="btn btnavenir edit_statut_rv" data-statut="a venir">à venir</button>
                                    <button class="btn btnvu edit_statut_rv" data-statut="vu">vu</button>
                                    <button class="btn btnae edit_statut_rv" data-statut="absence excusé">absence excusé</button>
                                    <button class="btn btnan edit_statut_rv" data-statut="absence non excusé">absence non excusé</button>
                                    <button class="btn btnreporte edit_statut_rv" data-statut="reporté">reporté</button>
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
                                            @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}"> {{ $patient->name.' '.$patient->prenom}}</option>
                                            @endforeach
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
            editedEvents = [];
            var createdEventId = 1;
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                plugins: ['interaction', 'resourceTimeline'],
                @can('create', \App\Event::class)
                selectable: true,
                editable: true,
                customButtons: {
                    Sauvegarder: {
                        text: 'Sauvegarder',
                        click: function() {
                            if (editedEvents.length > 0) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                        statusCode: {
                                            404: function() {
                                                alert("page introuvable");
                                            }
                                        },
                                        method: "PUT",
                                        url: "{{ route('events.update')}}",
                                        data: {
                                            events: JSON.stringify(editedEvents)
                                        },
                                        dataType: "json",
                                    })
                                    .done(function(data) {
                                        alert(data.info);
                                        editedEvents.length = 0;
                                        createdEventId = 1;
                                        window.location.reload();
                                        //

                                    })
                                    .fail(function(data) {
                                        var message = "";
                                        $.each(data.responseJSON, function(key, value) {
                                            message += " " + JSON.stringify(value);
                                        });

                                        alert(message);
                                    });
                            } else {
                                alert('Vous n\'avez effectué aucun changement !');
                            }

                        }
                    }
                },
                @endcan
                
                selectOverlap: false,
                eventOverlap: false, //pas de chevauchement
                slotDuration: '00:15:00', // unité de temps
                locale: 'fr',
                //timeZone: 'UTC',
                scrollTime: '08:00:00',
                defaultView: 'resourceTimelineDay',
                aspectRatio: 2,
                resourceAreaWidth: '15%',
                eventTextColor: 'white',
                resourceLabelText: 'Médecins',
                //minTime: '08:00:00', // heure de début (Affichage)
                //maxTime: '17:00:00',
                // displayEventTime: true,
                // displayEventEnd: true,
                resourceRender: function(info) {
                    var questionMark = document.createElement('a');

                    questionMark.innerText = info.el.innerText;
                    let url = '{{ route("events.medecinEvents", ":id") }}';
                    questionMark.href = url.replace(':id', info.resource.id);
                    //questionMark.href = "events/medecin/" + info.resource.id;
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
                    right: 'Sauvegarder today',
                },
                resources: [
                    @foreach($ressources as $ressource) {
                        id : {{$ressource->id}},
                        title: '{{$ressource->name}} {{$ressource->prenom}}',
                    },
                    @endforeach
                ],
                
                events: [
                    @foreach($events as $event) {
                        id : {{$event->id}},
                        title: '{{$event->title}}',
                        resourceId: {{ $event->user_id }},
                        start: new Date('{{ $event->start}} UTC'),
                        state: '{{$event->state}}',
                        statut: '{{$event->statut}}',
                        end: new Date('{{ $event->end}} UTC'),
                        objet: '{{ $event->objet}}',
                        description: '{{ $event->description}}',
                        backgroundColor: setcolor('{{$event->statut}}'),
                        borderColor:setcolor('{{$event->statut}}'),
                        patient:{ id: {{$event->patients->id}},},
                    },
                    @endforeach
                ],
                
                eventDrop: function(info) {
                    let oldItemIndex = editedEvents.findIndex((item) =>
                        item.id === info.event.id
                    );
                    info.event.resourceId = info.event.getResources()[0].id
                    if (info.event.extendedProps.state == 'aucun') {
                        info.event.setExtendedProp('state', 'mod');
                        oldItemIndex = editedEvents.push(eventObjToJSON(info.event)) - 1;
                    } else {
                        editedEvents[oldItemIndex] = eventObjToJSON(info.event)

                    }
                    //alert(editedEvents[oldItemIndex].state + " a été déplacé !"); // + info.newResource.title
                },
                eventResize: function(info) {
                    let oldItemIndex = editedEvents.findIndex((item) =>
                        item.id === info.event.id
                    );
                    info.event.resourceId = info.event.getResources()[0].id
                    if (info.event.extendedProps.state == 'aucun') {
                        info.event.setExtendedProp('state', 'mod');
                        oldItemIndex = editedEvents.push(eventObjToJSON(info.event)) - 1;
                    } else {
                        editedEvents[oldItemIndex] = eventObjToJSON(info.event)

                    }
                    //alert(editedEvents[oldItemIndex].state + " a été modifié !"); // + info.newResource.title
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
                var patient_name = $("#patient option:selected").text();
                var patient_id = $("#patient option:selected").val();
                var description = $('#description').val();
                var objet = $("input[name='objet']:checked").val();
                newEvent = {
                    title: patient_name,
                    start: nouveau_rv.start,
                    end: nouveau_rv.end,
                    resourceId: nouveau_rv.resource.id,
                    description: description,
                    objet: objet,
                    statut: "a venir",
                    state: "cre",
                    patient: {
                        id: patient_id,
                    },
                    id: 'cre_' + createdEventId++,
                }
                var parsedEvent = calendar.addEvent(newEvent);
                parsedEvent.resourceId = newEvent.resourceId;
                editedEvents.push(eventObjToJSON(parsedEvent));
                $("#patient option:selected").text('');
                $("#patient option:selected").val();
            });

            calendar.render();
        });

        $('#ouvrir_dossier_patient').on('click', function() {
            $('#info_RV').modal('hide');
            let url = '{{ route("patients.show", ":id") }}';
            url = url.replace(':id', eventObj.extendedProps.patient.id);
            window.open(url);
            

        });
        
        $('.edit_statut_rv').on('click', function() {
            let new_statut = $(this).data('statut');
            $('#info_RV').modal('hide');
            let oldItemIndex = editedEvents.findIndex((item) =>
                item.id === eventObj.id
            );
            eventObj.resourceId = eventObj.getResources()[0].id;
            eventObj.setExtendedProp('statut', new_statut);
            if (eventObj.extendedProps.state == 'aucun') {
                eventObj.setExtendedProp('state', 'mod');
                oldItemIndex = editedEvents.push(eventObjToJSON(eventObj)) - 1;
            } else {
                editedEvents[oldItemIndex] = eventObjToJSON(eventObj)
            }

        });
        $('#supprimer_rv').on('click', function() {
            var supprimer = confirm('Voulez-vous supprimer ce rendez-vous?');
            if (supprimer) {
                $('#info_RV').modal('hide');
                if (eventObj.extendedProps.state === 'cre') {
                    let oldItemIndex = editedEvents.findIndex((item) =>
                        item.id === eventObj.id
                    );
                    editedEvents.splice(oldItemIndex, 1)[0].state;
                } else {
                    if (eventObj.extendedProps.state === 'mod') {
                        let oldItemIndex = editedEvents.findIndex((item) =>
                            item.id === eventObj.id
                        );
                        editedEvents[oldItemIndex].state = 'sup';
                        //alert('editedEvents[oldItemIndex].state : '+editedEvents[oldItemIndex].state )
                    } else {
                        eventObj.setExtendedProp('state', 'sup');
                        editedEvents.push(eventObjToJSON(eventObj));
                        //alert('editedEvents.push : '+ eventObj.extendedProps.state)
                    }
                }
                eventObj.remove();
            }
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

        function eventObjToJSON(event) {
            return {
                id: event.id,
                title: event.title,
                start: event.start,
                end: event.end,
                resourceId : event.resourceId,
                description: event.extendedProps.description,
                objet: event.extendedProps.objet,
                statut: event.extendedProps.statut,
                state: event.extendedProps.state,
                patient: event.extendedProps.patient,
            }

        }
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