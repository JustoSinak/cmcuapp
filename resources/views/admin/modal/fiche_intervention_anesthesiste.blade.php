<div class="modal fade" id="FicheInterventionAnesthesiste" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">FICHE D'INTERVENTION</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('fiche_intervention.store') }}" method="post">
                    @csrf
                    <div class="container">
                        <div class="col-md-10  toppad">
                            <div class="card">
                                <div class="card-body">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <h5 class="text-primary"><strong>PATIENT</strong></h5>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><b>Nom du patient :</b></td>
                                                <td>
                                                    <input type="text" value="{{ $patient->name }}" name="nom_patient" class="form-control" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Prénom du patient :</b></td>
                                                <td>
                                                    <input type="text" value="{{ $patient->prenom }}" name="prenom_patient" class="form-control" >
                                                </td>
                                            </tr>
                                            @foreach ($patient->dossiers as $dossier)
                                            <tr>
                                                <td><b>Sexe :</b></td>
                                                <td>
                                                    <input type="text" value="{{ $dossier->sexe }}" name="sexe_patient" class="form-control" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Date de naissance :</b></td>
                                                <td>
                                                    <input type="date" value="{{ $dossier->date_naissance }}" name="date_naiss_patient" class="form-control" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Téléphone :</b></td>
                                                <td>
                                                    <input type="number" value="{{ $dossier->portable_1 }}" name="portable_patient" class="form-control" >
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td>
                                                    <h5 class="text-primary"><strong>INTERVENTION</strong></h5>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><b>Type :</b> <span class="text-danger">*</span></td>
                                                <td>
                                                    <input type="text" class="form-control" name="type_intervention" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Durée :</b> <span class="text-danger">*</span></td>
                                                <td>
                                                    <input type="time" class="form-control col-md-4" name="dure_intervention" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Position du patient :</b> <span class="text-danger">*</span></td>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="radio" name="position_patient[]" value="Décubitus" class="form-check-input"> Décubitus
                                                        <div class="row offset-1">
                                                            <input type="radio" name="decubitus[]" value="Latéral" class="form-check-input checkmark"> Latéral
                                                            <div class="row offset-2">
                                                                <input type="checkbox" name="laterale[]" value="Droite" class="form-check-input"> Droite
                                                            </div>
                                                            <div class="row offset-3">
                                                                <input type="checkbox" name="laterale[]" value="Gauche" class="form-check-input"> Gauche
                                                            </div>
                                                        </div>
                                                        <div class="row offset-1">
                                                            <input type="radio" name="decubitus[]" value="Dorsal" class="form-check-input"> Dorsal
                                                        </div>
                                                        <div class="row offset-1">
                                                            <input type="radio" name="decubitus[]" value="Ventral" class="form-check-input"> Ventral
                                                        </div>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" name="position_patient[]" value="Lithotomie" class="form-check-input"> Lithotomie
                                                    </div>
                                                    <div class="form-check ms-3">
                                                        <div class="row">
                                                            <input type="radio" name="position_patient[]" value="Lombotomie" class="form-check-input"> Lombotomie
                                                            <div class="row offset-2">
                                                                <input type="checkbox" name="lombotomie[]" value="Droite" class="form-check-input"> Droite
                                                            </div>
                                                            <div class="row offset-3">
                                                                <input type="checkbox" name="lombotomie[]" value="Gauche" class="form-check-input"> Gauche
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" name="position_patient[]" value="Trendelenburg" class="form-check-input"> Trendelenburg
                                                    </div>
                                                    <label for="autre">Autre :</label>
                                                    <input type="text" class="form-control" name="position_patient[]">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Date intervention :</b> <span class="text-danger">*</span></td>
                                                <td>
                                                    <input class="form-control" name="date_intervention" type="date" value='{{ old(' date_intervention ') }}' required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Chirurgien :</b> <span class="text-danger">*</span></td>
                                                <td>
                                                    <select name="medecin" id="medecin" class="form-control" required>
                                                        <option value="">Choisir le médecin</option>
                                                        @foreach($medecin as $medecin)
                                                            <option value="{{ $medecin->name }} {{ $medecin->prenom }}"> {{ $medecin->name }} {{ $medecin->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Aide opératoire :</b> <span class="text-danger">*</span></td>
                                                <td class="small">
                                                    <div class="form-check">
                                                        <input class="form-check-input" tabIndex="1"
                                                               type="checkbox" name="aide_op[]"
                                                               value="Oui"> Oui
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" tabIndex="1"
                                                               type="checkbox" name="aide_op[]"
                                                               value="Non"> Non
                                                    </div>
                                            </tr>
                                            <tr>
                                                <td><b>Hospitalisation :</b> </td>
                                                <td class="small">
                                                    <div class="form-check">
                                                        <input class="form-check-input" tabIndex="1"
                                                               type="radio" name="hospitalisation"
                                                               value="Hospitalisation"> Hospitalisation
                                                        <input type="text" name="heure" placeholder="Heure">
                                                    </div>
                                            </tr>
                                            <tr>
                                                <td><b>Ambulatoire :</b> </td>
                                                <td class="small">
                                                    <div class="form-check">
                                                        <input class="form-check-input" tabIndex="1"
                                                               type="radio" name="ambulatoire"
                                                               value="Ambulatoire"> Ambulatoire
                                                    </div>
                                            </tr>
                                            <tr>
                                                <td><b>Anesthésie :</b> <span class="text-danger">*</span></td>
                                                <td class="small">
                                                    <div class="form-check">
                                                        <input class="form-check-input" tabIndex="1"
                                                               type="checkbox" name="anesthesie[]"
                                                               value="AL"> AL
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" tabIndex="1"
                                                               type="checkbox" name="anesthesie[]"
                                                               value="AG"> AG
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" tabIndex="1"
                                                               type="checkbox" name="anesthesie[]"
                                                               value="LR"> LR
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" tabIndex="1"
                                                               type="checkbox" name="anesthesie[]"
                                                               value="RA"> RA
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" tabIndex="1"
                                                               type="checkbox" name="anesthesie[]"
                                                               value="PD"> PD
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" tabIndex="1"
                                                               type="checkbox" name="anesthesie[]"
                                                               value="ALR"> ALR
                                                    </div>
                                            </tr>
                                            <tr>
                                                <td><b>RECOMMENDATION(S) :</b></td>
                                                <td>
                                            <textarea wrap="hard" name="recommendation" cols="45" rows="5"
                                                      >{{ old('recommendation') }}</textarea>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-primary">Ajouter au dossier</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <input type="hidden" value="{{ $patient->id }}" name="patient_id">
                </form>
            </div>
        </div>
    </div>
</div>
