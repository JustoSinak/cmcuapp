@if($compteRenduBlocOperatoire->id)
    {{ Form::model($compteRenduBlocOperatoire, ['route' => ['compte_rendu_bloc.update', $compteRenduBlocOperatoire->id], 'method' => 'put', 'class'=>'form-horizontal form-label-left']) }}
@else
    {{ Form::open(['route' => 'compte_rendu_bloc.store', 'method' => 'post', 'class'=>'form-horizontal form-label-left']) }}
@endif
@csrf

    <tr>
        <td>
            <h5 class="text-primary"><strong>ENTRE / SORTIE PATIENT</strong></h5>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <b>Date d'entré :</b>
            <span class="text-danger">*</span>
        </td>
        <td>
            <b>Type :</b>
            <span class="text-danger">*</span>
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::date('date_e', null, ['class' => 'form-control', 'required' => 'required']) }}
        </td>
        <td>
            {{ Form::select('type_e', ['Urgence' => 'Urgence', 'Hospitalisation' => 'Hospitalisation', 'Ambulatoire' => 'Ambulatoire'], null, ['class' => 'form-control col-md-6', 'placeholder' => 'Motif d\'entrée', 'required' => 'required']) }}
        </td>
    </tr>
    <tr>
        <td>
            <b>Date de sortie :</b>
            <span class="text-danger">*</span>
        </td>
        <td>
            <b>Type :</b>
            <span class="text-danger">*</span>
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::date('date_s', null, ['class' => 'form-control', 'required' => 'required']) }}
        </td>
        <td>
            {{ Form::select('type_s', ['Retour au domicile' => 'Retour au domicile', 'Transfert' => 'Transfert', 'Convalescence' => 'Convalescence', 'Décédé' => 'Décédé' ], null, ['class' => 'form-control col-md-6', 'placeholder' => 'Motif de sortie', 'required' => 'required']) }}
        </td>
    </tr>
    <tr>
        <td>
            <h5 class="text-primary"><strong>EQUIPE MEDICALE</strong></h5>
        </td>
        <td></td>
    </tr>
    <tr>
        <td><b>Nom du chirurgien :</b> <span class="text-danger">*</span></td>
        <td>
            <select class="form-control col-md-6" name="chirurgien" id="chirurgien" required>
                <option value=""> Nom du chirurgien</option>
                @foreach ($users as $user)
                    <option
                        value="{{ $user->name }} {{ $user->prenom }}" {{old('chirurgien', $compteRenduBlocOperatoire->chirurgien) == ($user->name . ' ' . $user->prenom) ? 'selected' : ''}}>{{ $user->name }} {{ $user->prenom }}
                    </option>
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <td><b>Aide opératoire :</b> <span class="text-danger">*</span></td>
        <td>
            <select class="form-control col-md-6" name="aide_op" id="aide_op" required>
                <option value=""> Nom de l'aide opératoire</option>
                <option value="Aucun"> Aucun</option>
                @foreach ($users as $user)
                    <option
                        value="{{ $user->name }} {{ $user->prenom }}" {{old('aide_op', $compteRenduBlocOperatoire->aide_op) == ($user->name . ' ' . $user->prenom) ? 'selected' : ''}}>{{ $user->name }} {{ $user->prenom }}
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <td><b>Anesthésiste :</b> <span class="text-danger">*</span></td>
        <td>
            <select class="form-control col-md-6" name="anesthesiste" id="anesthesiste" required>
                <option value=""> Nom de l'anesthésiste</option>
                @foreach ($anesthesistes as $anesthesiste)
                    <option
                        value="{{ $anesthesiste->name }} {{ $anesthesiste->prenom }}" {{old('aide_op', $compteRenduBlocOperatoire->anesthesiste) == ($anesthesiste->name . ' ' . $anesthesiste->prenom) ? 'selected' : ''}}>{{ $anesthesiste->name }} {{ $anesthesiste->prenom }}
                    </option>
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <td><b>Infirmier anesthésiste :</b> <span class="text-danger">*</span></td>
        <td>
            <input class="form-control" type="text" name="infirmier_anesthesiste" value="{{ old('infirmier_anesthesiste', $compteRenduBlocOperatoire->infirmier_anesthesiste) }}" placeholder="Nom de l'infirmier anesthésiste" required="">
            <!-- <select class="form-control col-md-6" name="infirmier_anesthesiste" id="infirmier_anesthesiste" required>
                <option value=""> Nom de l'infirmier anesthésiste</option>
                @foreach ($infirmierAnesthesistes as $infirmierAnesthesiste)
                    <option
                        value="{{ $infirmierAnesthesiste->name }} {{ $infirmierAnesthesiste->prenom }}" {{old('infirmier_anesthesiste', $compteRenduBlocOperatoire->infirmier_anesthesiste) == ($infirmierAnesthesiste->name . ' ' . $infirmierAnesthesiste->prenom) ? 'selected' : ''}}>{{ $infirmierAnesthesiste->name }} {{ $infirmierAnesthesiste->prenom }}
                    </option>
                @endforeach
            </select> -->
        </td>
    </tr>
    <tr>
        <td>
            <h5 class="text-primary"><strong>DETAILS OPERATIONS</strong></h5>
        </td>
        <td></td>
    </tr>
    <tr>
        <td><b>Titre de l'intervention</b> <span class="text-danger">*</span></td>
        <td>{{ Form::text('titre_intervention', null, ['class' => 'form-control', 'placeholder' => 'Tire de l\'intervention', 'required' => 'required']) }}</td>
    </tr>
    <tr>
        <td><b>Type d'intervention</b> <span class="text-danger">*</span></td>
        <td>{{ Form::text('type_intervention', null, ['class' => 'form-control', 'placeholder' => 'Type\'intervention', 'required' => 'required']) }}</td>
    </tr>
    <tr>
        <td><b>Date de l'inervention :</b> <span class="text-danger">*</span></td>
        <td>{{ Form::date('date_intervention', null, ['class' => 'form-control col-md-5', 'required' => 'required']) }}</td>
    </tr>
    <tr>
        <td><b>Durée de l'inervention :</b> <span class="text-danger">*</span></td>
        <td>{{ Form::time('dure_intervention', null, ['class' => 'form-control col-md-5', 'required' => 'required']) }}</td>
    </tr>
    <tr>
        <td><b>Indications opératoires :</b> <span class="text-danger">*</span></td>
        <td>{{ Form::textarea('indication_operatoire', null, ['class' => 'form-control splitLines', 'rows' => '4', 'required' => 'required']) }}</td>
    </tr>
    <tr>
        <td><b>Compte-rendu opératoire :</b> <span class="text-danger">*</span></td>
        <td>{{ Form::textarea('compte_rendu_o', null, ['class' => 'form-control splitLines', 'rows' => '4', 'required' => 'required']) }}</td>
    </tr>

    <tr>
        <td><b>Résultats histo-pathologiques :</b></td>
        <td>{{ Form::textarea('resultat_histo', null, ['class' => 'form-control splitLines', 'rows' => '4']) }}</td>
    </tr>
    <tr>
        <td><b>Suites opératoires:</b> <span class="text-danger">*</span></td>
        <td>{{ Form::textarea('suite_operatoire', null, ['class' => 'form-control splitLines', 'rows' => '4', 'required' => 'required']) }}</td>
    </tr>
    <tr>
        <td><b>Traitement proposé :</b></td>
        <td>{{ Form::textarea('traitement_propose', null, ['class' => 'form-control splitLines', 'rows' => '4']) }}</td>
    </tr>
    <tr>
        <td><b>Soins et examens à réaliser :</b></td>
        <td>{{ Form::textarea('soins', null, ['class' => 'form-control splitLines', 'rows' => '4']) }}</td>
    </tr>
    <tr>
        <td><b>Proposition de suivi :</b></td>
        <td>{{ Form::textarea('proposition_suivi', null, ['class' => 'form-control splitLines', 'rows' => '3']) }}</td>
    </tr>
    <tr>
        <td><b>Conclusions :</b> <span class="text-danger">*</span></td>
        <td>{{ Form::textarea('conclusion', null, ['class' => 'form-control splitLines', 'rows' => '4', 'required' => 'required']) }}</td>
    </tr>
    <tr>
        {{ Form::hidden('patient_id', $patient->id) }}
    </tr>
    <tr>
        <td>
            {{ Form::button('Enregistrer', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
        </td>
        <td></td>
    </tr>
{{ Form::close() }}

