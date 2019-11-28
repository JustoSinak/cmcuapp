@if($parametre->id)
    {{ Form::model($parametre, ['route' => ['fiche_parametres.update', $parametre->id], 'method' => 'put', 'class'=>'form-horizontal form-label-left']) }}
@else
    {{ Form::open(['route' => 'fiche_parametres.store', 'method' => 'post', 'class'=>'form-horizontal form-label-left']) }}
@endif
@csrf

    @include('partials.flash_form')
    <table class="table">
        <tbody>
        <tr>
            <td>
                <b>Date de naissance : <span class="text-danger">*</span></b>
            </td>
            <td>{{ Form::date('date_naissance', null, ['class' => 'form-control', 'required' => 'required']) }}</td>
        </tr>
        <tr>
            <td><b>TA :</b> <span class="text-danger">*</span></td>
            <td>
                {{ Form::label('Bras gauche :') }}
                {{ Form::text('bras_gauche', null, ['class' => 'form-control', 'placeholder' => ' mmHg', 'required' => 'required']) }}
                {{ Form::label('Bras droit :') }}
                {{ Form::text('bras_droit', null, ['class' => 'form-control', 'placeholder' => ' mmHg', 'required' => 'required']) }}
            </td>
        </tr>
        <tr>
            <td><b>Température :</b> <span class="text-danger">*</span></td>
            <td>{{ Form::number('temperature', null, ['class' => 'form-control col-md-5', 'placeholder' => ' °C', 'required' => 'required', 'step' => 'any']) }}</td>
        </tr>
                {{ Form::hidden('patient_id', $patient->id, []) }}
        <tr>
            <td><b>FR :</b> <span class="text-danger">*</span></td>
            <td>{{ Form::text('fr', null, ['class' => 'form-control', 'placeholder' => '  Mvts/min', 'required' => 'required']) }}</td>
        </tr>
        <tr>
            <td><b>FC :</b> <span class="text-danger">*</span></td>
            <td>{{ Form::text('fc', null, ['class' => 'form-control', 'placeholder' => '  Pls/min', 'required' => 'required']) }}</td>
        </tr>
        <tr>
            <td><b>Gly :</b> </td>
            <td>{{ Form::text('glycemie', null, ['class' => 'form-control', 'placeholder' => '  g/l']) }}</td>
        </tr>
        <tr>
            <td><b>SPO2 :</b></td>
            <td>{{ Form::text('spo2', null, ['class' => 'form-control', 'placeholder' => '  %']) }}</td>
        </tr>
        <tr>
            <td><b>Poids :</b> <span class="text-danger">*</span></td>
            <td>{{ Form::number('poids', null, ['class' => 'form-control col-md-5', 'placeholder' => '  Kgs', 'required' => 'required', 'step' => 'any']) }}</td>
        </tr>
        <tr>
            <td><b>Taille :</b> </td>
            <td>{{ Form::number('taille', null, ['class' => 'form-control col-md-5', 'placeholder' => '  M', 'step' => 'any']) }}</td>
        </tr>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Ajouter au dossier</button>
{{ Form::close() }}
