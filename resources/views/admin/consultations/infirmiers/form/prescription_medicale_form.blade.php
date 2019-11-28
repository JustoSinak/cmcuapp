<div class="modal fade" id="PrescriptionMedicale" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">SOINS INFIRMIER</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="col-md-12  toppad">
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                    <form action="{{ route('prescription_medicale.store') }}" method="post">
                                        @csrf
                                        <span class="text-danger">{{ $patient->name }} {{ $patient->prenom }}</span>
                                        <tr>
                                            <td>
                                                <label> <b>Allergie :</b></label>
                                                <input type="text" name="allergie" class="form-control">
                                            </td>
                                            <td>
                                                <label> <b>Date / heure :</b></label>
                                                <input type="date" name="date" class="form-control" required>
                                            </td>
                                            <td>
                                                <label> <b>Médicament :</b></label>
                                                <input type="text" name="medicament" class="form-control" required>
                                            </td>
                                            <td>
                                                <label> <b>Posologie :</b></label>
                                                <input type="text" name="posologie" class="form-control" required>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label> <b>Voie :</b></label>
                                                <input type="text" name="voie" class="form-control" required>
                                            </td>
                                            <td colspan="1">
                                                <label> <b>H :</b></label>
                                                <input type="number" name="heure" class="form-control col-md-6" required>
                                            </td>
                                            <td colspan="2">
                                                <label> <b>M :</b></label>
                                                <input type="checkbox" name="matin">
                                                <label> <b>AM :</b></label>
                                                <input type="checkbox" name="apre_midi">
                                                <label> <b>S :</b></label>
                                                <input type="checkbox" name="soir">
                                                <label> <b>N :</b></label>
                                                <input type="checkbox" name="nuit">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2">
                                                <label> <b>Regime :</b></label>
                                                <textarea name="regime" class="form-control"  rows="3"></textarea>
                                            </td>
                                            <td colspan="2">
                                                <label> <b>Consultations spécialisées :</b></label>
                                                <textarea name="consultation_specialise" class="form-control"  rows="3"></textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="4">
                                                <label> <b>Autre protocole :</b></label>
                                                <textarea name="protocole" class="form-control"  rows="3"></textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><input type="submit" class="btn btn-primary" value="Enregistrer"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                    </form>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
