@if($consultation->id)
    {{ Form::model($consultation, ['route' => ['consultation_chirurgien.update', $consultation->id], 'method' => 'put', 'class'=>'form-horizontal form-label-left']) }}
@else
    {{ Form::open(['route' => 'consultation_chirurgien.store', 'method' => 'post', 'class'=>'form-horizontal form-label-left']) }}
@endif
@csrf
<tr>
    <td>
        <h5 class="text-primary"><strong>CONSULTATION</strong></h5>
    </td>
    <td></td>
</tr>
<tr>
    <td><b>Médecin de référence :</b> <span class="text-danger">*</span></td>

    <td>
        <input type="text" class="form-control splitLines" name="medecin_r" id="medecin_r" value="{{ Auth::user()->name }} {{ Auth::user()->prenom }}" {{old('medecin_r', $consultation->medecin_r) == (Auth::user()->name . ' ' . Auth::user()->prenom)}}>
    </td>
</tr>
<tr>
    <td><b>Motif de consultation :</b> <span class="text-danger">*</span></td>
    <td>{{ Form::textarea('motif_c', null, ['class' => 'form-control splitLines', 'rows' => '4', 'required' => 'required']) }}</td>
</tr>
<tr>
    <td><b>Interrogatoire :</b> <span class="text-danger">*</span></td>
    <td>{{ Form::textarea('interrogatoire', null, ['class' => 'form-control splitLines', 'rows' => '5', 'required' => 'required']) }}</td>
</tr>
{{--    @if (isset($consultation->antecedent_m))--}}
    <tr>
        <td><b>Antécédents médicaux :</b></td>
        <td>{{ Form::textarea('antecedent_m', null, ['class' => 'form-control splitLines', 'rows' => '3']) }}</td>
    </tr>
{{--    @endif--}}
{{--    @if (isset($consultation->antecedent_c))--}}
    <tr>
        <td><b>Antécédents chirurgicaux :</b></td>
        <td>{{ Form::textarea('antecedent_c', null, ['class' => 'form-control splitLines', 'rows' => '3']) }}</td>
    </tr>
{{--    @endif--}}
{{--    @if (isset($consultation->allergie))--}}
    <tr>
        <td><b>Allergies :</b></td>
        <td>{{ Form::textarea('allergie', null, ['class' => 'form-control splitLines', 'rows' => '3']) }}</td>
    </tr>
{{--    @endif--}}
{{--    @if (isset($consultation->groupe))--}}
    <tr>
        <td><b>Goupe sanguin du patient :</b></td>
        <td>
            <select class="form-control col-md-5" name="groupe" id="groupe">
                <option value="">Groupes sanguins</option>
                <option value="O-" {{old( 'groupe',$consultation->groupe)=='O-' ? 'selected' : '' }}>O-</option>
                <option value="O+" {{old( 'groupe',$consultation->groupe)=='O+' ? 'selected' : '' }}>O+</option>
                <option value="B-" {{old( 'groupe',$consultation->groupe)=='B-' ? 'selected' : '' }}>B-</option>
                <option value="B+" {{old( 'groupe',$consultation->groupe)=='B+' ? 'selected' : '' }}>B+</option>
                <option value="A-" {{old( 'groupe',$consultation->groupe)=='A-' ? 'selected' : '' }}>A-</option>
                <option value="A+" {{old( 'groupe',$consultation->groupe)=='A+' ? 'selected' : '' }}>A+</option>
                <option value="AB-" {{old( 'groupe',$consultation->groupe)=='AB-' ? 'selected' : '' }}>AB-</option>
                <option value="AB+" {{old( 'groupe',$consultation->groupe)=='AB+' ? 'selected' : '' }}>AB+</option>
            </select>
        </td>
    </tr>
{{--    @endif--}}
<tr>
    <td>
        <h5 class="text-primary"><strong>EXAMENS</strong></h5>
    </td>
    <td></td>
</tr>
<tr>
    <td>{{ Form::hidden('patient_id', $patient->id, ['class' => 'form-control']) }}</td>
    <td></td>
</tr>
<tr>
    <td><b>Examens physiques :</b> <span class="text-danger">*</span></td>
    <td>{{ Form::textarea('examen_p', null, ['class' => 'form-control splitLines', 'rows' => '4', 'required' => 'required']) }}</td>
</tr>
<tr>
    <td><b>Examens compléméntaires:</b> <span class="text-danger">*</span></td>
    <td>{{ Form::textarea('examen_c', null, ['class' => 'form-control splitLines', 'rows' => '4', 'required' => 'required']) }}</td>
</tr>
<tr>
    <td><b>Diagnostic médical :</b> <span class="text-danger">*</span></td>
    <td>{{ Form::textarea('diagnostic', null, ['class' => 'form-control splitLines', 'rows' => '4', 'required' => 'required']) }}</td>
</tr>
<tr>
    <td><b>Proposition thérapeutique :</b> <span class="text-danger">*</span></td>
    <td>{{ Form::textarea('proposition_therapeutique', null, ['class' => 'form-control splitLines', 'rows' => '4', 'required' => 'required']) }}</td>
</tr>
<tr>
    <td><b>Proposition de suivi :</b> <span class="text-danger">*</span></td>
    <td class="form-group small">
        <div class="form-check">
            <input class="form-check-input" onClick="ckChange(this)" type="checkbox" name="proposition[]" id="decision1" value="Hospitalisation" {{old( 'proposition',$consultation->proposition)=='Hospitalisation' ? 'checked' : '' }}> Hospitalisation
        </div>
        <div class="form-check">
            <input class="form-check-input" onClick="ckChange(this)" type="checkbox" name="proposition[]" id="decision2" value="Intervention chirurgicale" {{old( 'proposition',$consultation->proposition)=='Intervention chirurgicale' ? 'checked' : '' }}> Intervention chirurgicale
        </div>
        <div class="form-check">
            <input class="form-check-input" onClick="ckChange(this)" type="checkbox" name="proposition[]" id="decision3" value="Consultation" {{old( 'proposition',$consultation->proposition)=='Consultation' ? 'checked' : '' }}> Consultation
        </div>
        <div class="form-check">
            <input class="form-check-input" onClick="ckChange(this)" type="checkbox" name="proposition[]" id="decision4" value="Actes à réaliser" {{old( 'proposition',$consultation->proposition)=='Actes à réaliser' ? 'checked' : '' }}> Actes à réaliser
        </div>
        <div class="form-check">
            <input class="form-check-input" onClick="ckChange(this)" type="checkbox" name="proposition[]" id="decision5" value="Consultation d'anesthésiste" {{old( 'proposition',$consultation->proposition)=='Consultation d\'anesthésiste' ? 'checked' : '' }}> Consultation d'anesthésiste
        </div>
    </td>
</tr>
<tr id="type_intervention" style='display:none;'>
    <td><b>Type d'intervention :</b></td>
    <td>{{ Form::textarea('type_intervention', null, ['class' => 'form-control splitLines', 'rows' => '4']) }}</td>
</tr>
<tr>
    <td><b>Date intervention :</b></td>
    <td>{{ Form::date('date_intervention', null, ['class' => 'form-control col-md-5']) }}</td>
</tr>
<tr id="type_acte" style='display:none;'>
    <td><b>Type d'actes à réaliser :</b></td>
    <td>
        <div class="form-check">
            <input type="checkbox" name="acte[]" value="Echographie de l'arbre urinaire" {{old( 'acte',$consultation->acte)=='Echographie de l\'arbre urinaire' ? 'checked' : '' }}> Echographie de l'arbre urinaire
        </div>
        <div class="form-check">
            <input type="checkbox" name="acte[]" value="Cystoscopie" {{old( 'acte',$consultation->acte)=='Cystoscopie' ? 'checked' : '' }}> Cystoscopie
        </div>
        <div class="form-check">
            <input type="checkbox" name="acte[]" value="Biopsie prostatique" {{old( 'acte',$consultation->acte)=='Biopsie prostatique' ? 'checked' : '' }}> Biopsie prostatique
        </div>
        <div class="form-check">
            <input type="checkbox" name="acte[]" value="Débitmétrie" {{old( 'acte',$consultation->acte)=='Débitmétrie' ? 'checked' : '' }}> Débitmétrie
        </div>
        <div class="form-check">
            <input type="checkbox" name="acte[]" value="Echographie prostatique sous rectale" {{old( 'acte',$consultation->acte)=='Echographie prostatique sous rectale' ? 'checked' : '' }}> Echographie prostatique sous rectale
        </div>
    </td>
</tr>
<tr id="anesthesiste" style='display:none;'>
    <td><b>Date consultation anesthésiste :</b></td>
    <td>{{ Form::date('date_consultation_anesthesiste', null, ['class' => 'form-control col-md-6']) }}</td>
</tr>
<tr>
    <td></td>
    <td></td>
</tr>
<tr id="consultation" style='display:none;'>
    <td><b>Date de consultation :</b></td>
    <td>{{ Form::date('date_consultation', null, ['class' => 'form-control col-md-6']) }}</td>
</tr>
<tr>
    <td>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </td>
    <td></td>
</tr>
{{ Form::close() }}
