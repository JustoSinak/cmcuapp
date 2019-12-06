<tbody id="editMotifMontform" style="display: none;">
    <form action="{{ route('patients.motif_montant.update', $patient->id) }}" method="POST">
        @csrf @method('PUT')
        <tr>
            <td>
                <label for="name" class="col-form-label text-md-right">Nom du patient :</label>
            </td>
            <td>
                <b>{{ $patient->name }}</b>
            </td>
        </tr>
        <tr>
            <td>
                <label for="motif" class="col-form-label text-md-right">Motif : <span class="text-danger">*</span></label>
            </td>
            <td>
                <select class="form-control" name="motif" id="motif" onchange="new_ckChange(this)">
                    <option {{ old('motif', $patient->motif) ==  'Consultation' ? 'selected' : '' }}>Consultation</option>
                    <option {{ old('motif', $patient->motif) ==  'Acte' ? 'selected' : '' }}>Acte</option>
                    <option {{ old('motif', $patient->motif) ==  'Examen' ? 'selected' : '' }}>Examen</option>
                    <option {{ old('motif', $patient->motif) ==  'Autres' ? 'selected' : '' }}>Autres</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>
                <label for="details_motif" id="label_details_motif" class="col-form-label text-md-right">Détails motif : <span class="text-danger">*</span></label>
            </td>
            <td>
                <input name="details_motif" id="details_motif" class="form-control" value="{{ old('details_motif') ?? $patient->details_motif}}" {{ $patient->motif === "Consultation" ? "disabled" : "" }} type="text" placeholder="Précisez le motif">
            </td>
        </tr>


        <tr>
            <td>
                <label for="montant" class="col-form-label text-md-right">Montant :<span class="text-danger">*</span></label>
            </td>
            <td>
                <input name="montant" class="form-control" value="{{ old('montant') ?? $patient->montant}}" type="number" placeholder="montant">
            </td>
        </tr>
        <tr>
            <td>
                <button type="submit" class="btn btn-primary">Modifier</button>
            </td>
            <td></td>
        </tr>
        
    </form>
</tbody>
@section('script')
<script>
    function new_ckChange(ckType){
        
        var motif = document.getElementById('motif');
        var choix = motif[motif.selectedIndex].value;
        if (choix == 'Consultation') {
            document.getElementById("label_details_motif").innerText = 'Détail motif';
            document.getElementById("details_motif").value = "Consultation";
            document.getElementById("details_motif").disabled = true;
        } else{
            document.getElementById("details_motif").value = "";
            document.getElementById("details_motif").disabled = false;
        }
        if ( choix == 'Acte' || choix == 'Examen') {
            document.getElementById("label_details_motif").innerText = 'Type '+choix.toLowerCase();
        }
        if ( choix == 'Autres') {
            document.getElementById("label_details_motif").innerText = 'Détails motif';
        }
        
    }
        
</script>
@endsection