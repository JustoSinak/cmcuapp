<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
<style>
    .cpi-titulo3 {
        font-size: 12px;
    }
    .logo{
        width: 100px;
    }
    p {
        line-height: 40%;
    }
    hr {
        display: block; height: 1px;
        border: 0; border-top: 1px solid red;
        margin: 1em 0; padding: 0;
    }
    .footer {
        padding-top: 1px;
        padding-bottom: 15px;
        position:fixed;
        bottom:5px;
        width:100%;
    }

    .cmcu_dossier_cons{
        /*border: solid 1px;*/
        /*border-radius: 2px;*/
        text-align: center;
    }
    .par_first{
        line-height: 200%;
        text-align: justify;
    }

</style>
<div class="container-fluid">

    <div class="row">
        <div class="col-2">
            <img class="logo img-responsive float-start" src="{{ asset('admin/images/logo.jpg') }}">
        </div>
        <div class="col-7 offset-3">
            <div class="text-center">
                <p>CENTRE MEDICO-CHIRURGICAL D'UROLOGIE</p>
                <p>VALLEE MANGA BELL DOUALA-BALI</p>
                <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small>
                <p><small>www.cmcu-cm.com</small></p>
            </div>
        </div>
    </div>
    <div class="row">
        <hr class="text-danger">
    </div>
    <br>
    <br>
    <div class="row">
        <div class="cmcu_dossier_cons">
            <h2 class="text-center"><u>CONSENTEMENT ECLAIRE</u></h2>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-5">
            <p>Nom patient : <b>{{ $patient->name }}</b></p>
            <p>Pénom patient : <b>{{ $patient->prenom }}</b></p>
            <p>Nom parent :</p>
            <p>Adresse : <b>{{ $dossiers->adresse }}</b></p>
            <p>Téléphone : <b>{{ $dossiers->portable_1 }}</b></p>
        </div>
        <div class="col-8 offset-6">
            <p>Date intervention : <b>{{ $consultation_anesthesiste->date_intervention }}</b></p>
            <p>Type intrvention : <b>{{ $fiche_intervention->type_intervention }}</b></p>
            <p>Type d'anesthésie : <b>{{ $consultation_anesthesiste->technique_anesthesie1 }}</b></p>
            <p>Chirugien : <b>Dr. {{ $consultation_anesthesiste->operateur }}</b></p>
            <p>Anesthésiste : <b>Dr. {{ $consultation_anesthesiste->user->name }} {{ $consultation_anesthesiste->user->prenom }}</b></p>
        </div>
    </div>

    <div class="row">
        <div class="row ">
            <div class="col-12">
                <p class="par_first">
                    Je déclare avoir reçu une information claire sur les risques et bénéfices des techniques d’anesthésies pour l’intervention prévue le <b>{{ $consultation_anesthesiste->date_intervention }}</b>, lors de la consultation d’anesthésie du <b>{{ $consultation_anesthesiste->created_at->ToDateString() }}</b>.
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="row">
            <div class="col-12">
                <p class="par_first">
                    Je suis conscient d’une possibilité d’un changement de technique d’anesthésie au dernier moment selon l’évolution de mon état de santé ou de l’acte chirurgical.
                    Je suis conscient du changement d’anesthésie avant l’intervention.
                </p>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="row">
            <div class="col-12">
                <p>
                    Fait à Douala, {{ Carbon\Carbon::now()->ToDateString() }}
                </p>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <p>
            Signature du patient ou de son représentant (précédée de la mention lu, approuvé et compris)
        </p>
    </div>

    <footer class="footer">
        <div class="text-center col-6 offset-2">
            <small>TEL:(+237) 233 423 389 / 674 068 988 / 698 873 945</small>
            <small>www.cmcu-cm.com</small>
        </div>
    </footer>
</div>
