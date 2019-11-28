<div class="modal fade" id="SoinsInfirmier" tabindex="-1" role="dialog"
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
                    <div class="col-md-10  toppad">
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                    <form action="{{ route('soins_infirmiers.store') }}" method="post">
                                        @csrf
                                        <tr>
                                            <td>
                                                <label for=""><b>Nom du patient :</b></label>
                                                <select name="patient_externe" class="form-control">
                                                    <option value="">Nom du patient</option>
                                                    @foreach ($patient_externes as $patient_externe)
                                                        <option value="{{ $patient_externe->nom }} {{ $patient_externe->prenom }}"> {{ $patient_externe->nom }} {{ $patient_externe->prenom }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="date"><b>Date :</b></label>
                                                <input name="date" class="form-control"
                                                       value="{{ old('date', Carbon\Carbon::now()->ToDateString()) }}"
                                                       required="required" type="date">
                                            </td>
                                            <td>
                                                <label for="observation"><b>Observations :</b></label>
                                                <textarea name="observation" class="form-control" cols="100" rows="3" required ="required"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input type="submit" class="btn btn-primary" value="Enregistrer"></td>
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
