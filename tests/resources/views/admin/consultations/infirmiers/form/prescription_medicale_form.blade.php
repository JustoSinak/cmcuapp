<div class="modal fade" id="prescription_medicale_form" tabindex="-1" role="dialog" aria-labelledby="prescription_medicale_formLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informations Importantes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <form action="{{ route('fiche.prescription_medicale.store', $patient->id) }}" method="post">
                                            @csrf
                                            <span class="text-danger">{{ $patient->name }} {{ $patient->prenom }}</span>
                                            <tr>
                                                <td colspan="2">
                                                    <label> <b>Allergie :</b></label>
                                                    <input type="text" name="allergie" class="form-control" required>
                                                </td>
                                                
                                            </tr>
                                            
                                            <tr>
                                                <td >
                                                    <label> <b>Regime :</b></label>
                                                    <textarea name="regime" class="form-control" rows="3" required></textarea>
                                                </td>
                                                <td >
                                                    <label> <b>Consultations spécialisées :</b></label>
                                                    <textarea name="consultation_specialise" class="form-control" rows="3" required></textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <label> <b>Autre protocole :</b></label>
                                                    <textarea name="protocole" class="form-control" rows="3"></textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td  colspan="2"><input type="submit" class="btn btn-primary" value="Enregistrer"></td>
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