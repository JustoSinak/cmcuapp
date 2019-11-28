<!doctype html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
    <link rel="stylesheet" href="{{ mix('css/all.css') }}"/>
    <script src="{{ mix('js/all.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <link href="//fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <script src="{{ asset('admin/js/modernizr.js') }}"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <style>
        /* ... */
    </style>
</head>
<body>
<div class="wrapper">
    @include('partials.side_bar')
    <div class="container">
        @include('partials.header')
        <div id="fullCalModal" class="modal fade">
            <div class="col-lg-12 col-md-12">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            @if (count($events)>0)
                                <p class="btn btn-primary offset-2">Dr
                                    <strong>
                                    {{ Auth()->user()->name }} {{ Auth()->user()->prenom }}
                                    </strong> la liste de vos rendez-vous en cours</p>
                            @else
                                <p class="btn btn-info offset-2">Dr <strong>
                                    {{ Auth()->user()->name }} {{ Auth()->user()->prenom }}
                                </strong> Vous n'avez pas de rendez-vous disponible <i class="fas fa-exclamation-circle"></i></p>
                            @endif
                            {{--@if(auth()->user()->role_id == 4)--}}
                                    {{--<p class="btn btn-info offset-2"><strong>--}}
                                            {{--{{ Auth()->user()->name }} {{ Auth()->user()->prenom }}--}}
                                {{--</strong> La liste des rendez-vous disponible <i class="fas fa-exclamation-circle"></i></p>--}}
                            {{--@endif--}}
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                            <h4 id="modalTitle" class="modal-title"></h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>MOTIF</th>
                                    <th>PATIENT</th>
                                    <th>DATE</th>
                                    <th>MEDECIN</th>
                                    <th class="text-center">HEURE</th>
                                    <th class="text-center">EDITER</th>
                                    <th class="text-center">SUPPRIMER</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($events as $event)
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>{{ $event->title }}</td>
                                            <td>{{ $event->patients->name }}</td>
                                            <td>{{ $event->date }}</td>
                                            <td>{{ $event->user->name }} {{ $event->user->prenom }}</td>
                                            <td>{{ date("H:i", strtotime($event->start_time)) }}</td>
                                            <td class="td-actions text-right">
                                                <a href="{{ route('events.edit', $event->id) }}" rel="tooltip" class="btn btn-success btn-just-icon btn-sm" title="Modifier les informations relative a ce rendez-vous">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <form action="{{ route('events.destroy', $event->id) }}" method="post">
                                                    @csrf @method('DELETE')
                                                    <p data-placement="top" data-toggle="tooltip" title="Supprimer définiivement le rendez-vous">
                                                        <button type="submit" class="btn btn-danger btn-just-icon btn-sm"  onclick="return myFunction()">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </p>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 offset-2">
            @include('partials.flash')
            <div class="row mt-0">
                <div id="calendar">
                    {{--{!! $calendar->calendar() !!}--}}
                    {{--{!! $calendar->script() !!}--}}
                </div>
                <a href="{{ route('patients.index') }}" class="btn btn-info mt-1" title="Consulter la liste des patients"><i class="fas fa-users"></i> Liste des patients</a>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.1/lang-all.js"></script>
        <script>
            //paste this code under head tag or in a seperate js file.
            // Wait for window load
            $(window).load(function () {
                // Animate loader off screen
                $(".se-pre-con").fadeOut("slow");;
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $(".dropdown").hover(
                    function () {
                        $('.dropdown-menu', this).stop(true, true).slideDown("fast");
                        $(this).toggleClass('open');
                    },
                    function () {
                        $('.dropdown-menu', this).stop(true, true).slideUp("fast");
                        $(this).toggleClass('open');
                    }
                );
            });
        </script>
        <script>
            $('#calendar').fullCalendar({
                dayClick: function(date, jsEvent, view) {
                    $('#fullCalModal').modal('show');
                },
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay',
                },
                navLinks: true,
                editable: true,
                eventLimit: false,
                lang: 'fr',
                events: [
                        @foreach($events as $event){
                        title : '{{ $event->title }}',
                        color : '{{ $event->color }}',
                        medecin : '{{ $event->medecin }}',
                        start : '{{ $event->date }}',
                        end : '{{ $event->end_date }}'
                    },
                    @endforeach
                ],
            });
        </script>
        <script>
            function myFunction() {
                if (!confirm("Veuillez confirmer la suppréssion du rendez-vous"))
                    event.preventDefault();
            }
        </script>
    </div>
</div>
</body>
</html>
