<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<div class="modal fade" id="ordonanceModal" tabindex="-1" role="dialog" aria-labelledby="ordonanceModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" class="btn btn-primary" href="#menu1">BIOLOGIES</a></li>
                    <li><a data-toggle="tab" class="btn btn-primary ms-2" href="#menu2">IMAGERIES</a></li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                    </div>
                    <form id="menu1" class="tab-pane fade" action="{{ route('prescriptions.store') }}" method="POST" >
                        <h3 class="text-center mb-4">BIOLOGIE</h3>
                        @csrf
                        @include('admin.consultations.partials.feuille_examen_biologie')
                        <input type="hidden" value="{{ $patient->id }}" name="patient_id">
                        <button type="button" class="btn btn-secondary btn-md mt-2" data-dismiss="modal">Fermer</button>
                        <button type="submit"class="btn btn-primary btn-md mt-2">Enregistrer</button>
                    </form>

                    <form id="menu2" class="tab-pane fade" action="{{ route('imageries.store') }}" method="post" >
                        <h3 class="text-center mb-4">IMAGERIE</h3>
                        @csrf
                        @include('admin.consultations.partials.feuille_examen_imagerie')
                        <input type="hidden" value="{{ $patient->id }}" name="patient_id">
                        <button type="button" class="btn btn-secondary btn-md mt-2" data-dismiss="modal">Fermer</button>
                        <button type="submit"class="btn btn-primary btn-md mt-2">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
