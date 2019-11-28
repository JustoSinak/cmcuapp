@foreach($surveillance_post_anesthesiques as $surveillance_post_anesthesique)
<div class="modal fade" id="SpostAnesthUpdate" tabindex="-1" role="dialog"
     aria-labelledby="SpostAnesthUpdate" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">SURVEILLANCE POST ANESTHESIQUE</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('surveillance_post_anesthesise.update', $patient->id) }}" method="post" id="update">
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="container">
                        <div class="col-md-10  toppad">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td><b>Surveillance :</b> <span class="text-danger">*</span></td>
                                            <td>
                                                <textarea name="surveillance" class="form-control" cols="55" rows="3">{{ $surveillance_post_anesthesique->surveillance }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Traitement(s) :</b> </td>
                                            <td>
                                                <textarea name="traitement" class="form-control" cols="55" rows="3">{{ $surveillance_post_anesthesique->traitement }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Examen(s) paraclinique(s) post opératoire :</b> </td>
                                            <td>
                                                <textarea name="examen_paraclinique" class="form-control" cols="55" rows="3">{{ $surveillance_post_anesthesique->examen_paraclinique }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Observation(s) :</b> <span class="text-danger">*</span></td>
                                            <td>
                                                <textarea name="observation" class="form-control" cols="55" rows="3">{{ $surveillance_post_anesthesique->observation }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for=""><b>Date de sortie :</b></label>
                                                <input type="date" class="form-control" name="date_sortie" value="{{ $surveillance_post_anesthesique->date_sortie }}">
                                            </td>
                                            <td>
                                                <label for=""><b>Heure de sortie :</b></label>
                                                <input type="time" class="form-control col-md-5" name="heur_sortie" value="{{ $surveillance_post_anesthesique->heur_sortie }}">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <input type="hidden" value="{{ $patient->id }}" name="patient_id">
                    <input type="hidden" value="{{ Carbon\Carbon::now()->ToDateString() }}" name="date_creation">
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
