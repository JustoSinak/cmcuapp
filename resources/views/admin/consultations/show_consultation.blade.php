<tbody id="show_consultation" style="display: contents;">
@can('med_inf_anes', \App\Patient::class)
    @can('chirurgien', \App\Patient::class)
        <tr></tr>
        <tr>
            <td>
                <a href="{{ route('consultations.index', $patient->id) }}">
                    <h1 class="text-info">CONSULTATION</h1>
                </a>
            </td>
            <td></td>
        </tr>

        @if (count($patient->consultations))

            <tr>
                <td class="table-active"><b>DATE :</b></td>
                <td class="table-active"><b>{{ $consultations->created_at->toFormattedDateString() }}</b><a href="{{ route('consultations.edit', $patient->id ) }}" class="btn btn-primary float-right"><i class="fas fa-eye"></i> Editer</a></td>
            </tr>
            <tr>
                <td>
                    <b>NOM et PRENOM du MEDECIN :</b>
                </td>
                <td>{{ ($consultations->medecin_r) }}</td>
            </tr>
            <tr>
                <td>
                    <b>MOTIF DE LA CONSULTATION :</b>
                </td>
                <td>{{ ($consultations->motif_c) }}</td>
            </tr>
            <tr>
                <td><b>ALLERGIES :</b></td>
                <td> {!! nl2br(e($consultations->allergie)) !!}</td>
            </tr>
            <tr>
                <td><b>GROUPE SANGUIN :</b></td>
                <td>
                    <span class="badge badge-primary">{{ $consultations->groupe }}</span>
                </td>
            </tr>
            <tr>
                <td><b>ANTECEDENTS MEDICAUX :</b></td>
                <td>{!! nl2br(e($consultations->antecedent_m)) !!}</td>
            </tr>
            <tr>
                <td><b>ANTECEDENTS CHIRURGICAUX :</b></td>
                <td>{!! nl2br(e( $consultations->antecedent_c)) !!}</td>
            </tr>
            <tr>
                <td><b>INTERROGATOIRE :</b></td>
                <td> {!! nl2br(e($consultations->interrogatoire)) !!}</td>
            </tr>
            <tr>
                <td><b>DIAGNOSTIC :</b></td>
                <td>{!! nl2br(e($consultations->diagnostic)) !!}</td>
            </tr>
            <tr>
                <td><b>PROPOSITION THERAPEUTIQUE :</b></td>
                <td>{!! nl2br(e($consultations->proposition_therapeutique)) !!}</td>
            </tr>
            <tr>
                <td><b>PROPOSITION DE SUIVI :</b></td>
                <td>{!! nl2br(e($consultations->proposition)) !!}</td>
            </tr>
        @else
        <tr>
            <td>
                <b>Aucune consultation de disponible</b>
            </td>
            <td></td>
        </tr>
        @endif
    @endcan

    @can('anesthesiste', \App\Patient::class)
        <tr>
            <td>
                <a href="{{ route('consultations.index_anesthesiste', $patient->id) }}">
                    <h1 class="text-info">CONSULTATION</h1>
                </a>
            </td>
            <td>
                @if(count($patient->consultation_anesthesistes))
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#VisiteAnesthesiste" title="Visite pré-anesthésique du patient" data-whatever="@mdo">
                        <i class="far fa-plus-square"></i>
                        Visite pré-anesthésique
                    </button>
                @endif
            </td>
        </tr>

        @if (count($patient->consultation_anesthesistes))

            <tr>
                <td class="table-active"><b>DATE :</b></td>
                <td class="table-active"><b>{{ $consultation_anesthesistes->created_at->toFormattedDateString() }}</b> <a href="{{ route('consultations.edit', $patient->id) }}" class="btn btn-primary float-right"><i class="fas fa-eye"></i> Editer</a></td>
            </tr>
            <tr>
                <td><b>SERVICE :</b></td>
                <td>{{ ($consultation_anesthesistes->service) }}</td>
            </tr>
            <tr>
                <td>
                    <b>SPECAIALITE :</b>
                </td>
                <td>{{ ($consultation_anesthesistes->specialite) }}</td>
            </tr>
            <tr>
                <td>
                    <b>MEDECIN TRAITANT :</b>
                </td>
                <td>{{ ($consultation_anesthesistes->medecin_traitant) }}</td>
            </tr>
            <tr>
                <td><b>OPERATEUR :</b></td>
                <td>{{ ($consultation_anesthesistes->operateur) }}</td>
            </tr>
            <tr>
                <td><b>DATE D'INTERVENTION :</b></td>
                <td>
                    <span class="badge badge-primary">{{ $consultation_anesthesistes->date_intervention }}</span>
                </td>
            </tr>
            <tr>
                <td><b>MOTIF D'ADMISSION :</b></td>
                <td>{{ $consultation_anesthesistes->motif_admission }}</td>
            </tr>
            <tr>
                <td><b>MEMO :</b></td>
                <td>{{ $consultation_anesthesistes->memo }}</td>
            </tr>
            <tr>
                <td><b>ANESTHESIE EN SALLE :</b></td>
                <td>{{ ($consultation_anesthesistes->anesthesi_salle) }}</td>
            </tr>
            <tr>
                <td><b>DATE D'HOSPITALISATION :</b></td>
                <td>{{ ($consultation_anesthesistes->date_hospitalisation) }}</td>
            </tr>
            <tr>
                <td><b>CLASSE ASA :</b></td>
                <td>{{ ($consultation_anesthesistes->classe_asa) }}</td>
            </tr>
            <tr>
                <td><b>ANTECEDENTS / TRAITEMENT :</b></td>
                <td>{{ ($consultation_anesthesistes->antecedent_traitement) }}</td>
            </tr>
            <tr>
                <td><b>EXAMENS CLINIQUES :</b></td>
                <td>{{ ($consultation_anesthesistes->examen_clinique) }}</td>
            </tr>
            <tr>
                <td><b>ALLERGIE :</b></td>
                <td>
                    <span class="badge badge-primary">{{ ($consultation_anesthesistes->allergie) }}</span>
                </td>
            </tr>
            <tr>
                <td><b>Intubation :</b></td>
                <td>{{ ($consultation_anesthesistes->intubation) }}</td>
            </tr>
            <tr>
                <td><b>Mallampati :</b></td>
                <td>{{ ($consultation_anesthesistes->mallampati) }}</td>
            </tr>
            <tr>
                <td><b>Distance-interincisive :</b></td>
                <td>{{ ($consultation_anesthesistes->distance_interincisive) }}</td>
            </tr>
            <tr>
                <td><b>Distance thyromentonière :</b></td>
                <td>{{ ($consultation_anesthesistes->distance_thyromentoniere) }}</td>
            </tr>
            <tr>
                <td><b>Mobilité cervicale :</b></td>
                <td>{{ ($consultation_anesthesistes->mobilite_servicale) }}</td>
            </tr>
            <tr>
                <td><b>Technique d'anesthésie :</b></td>
                <td>{{ ($consultation_anesthesistes->technique_anesthesie1) }}</td>
            </tr>
            <tr>
                <td><b>Bénéfice / Risque  :</b></td>
                <td>{{ ($consultation_anesthesistes->benefice_risque) }}</td>
            </tr>
            <tr>
                <td><b>Jeune préopératoire :</b></td>
                <td>
                    {{--<p>{{ ($consultation_anesthesistes->jeune_preop) }}</p>--}}
                    <p><b>Solide :</b></p>
                    <p>{{ ($consultation_anesthesistes->solide) }}</p>
                    <p><b>Liquide :</b></p>
                    <p>{{ ($consultation_anesthesistes->liquide) }}</p>
                </td>
            </tr>
            <tr>
                <td><b>Adaptation au traitement personnel :</b></td>
                <td>{{ ($consultation_anesthesistes->adaptation_traitement) }}</td>
            </tr>
            <tr>
                <td><b>Autres adaptations :</b></td>
                <td>{{ ($consultation_anesthesistes->autre1) }}</td>
            </tr>
            <tr>
                <td><b>Technique d'anesthésie envisagée :</b></td>
                <td>
                    @foreach(explode(",", $consultation_anesthesistes->technique_anesthesie) as $technique)
                        <ul>
                            <li>
                                {{ $technique }}
                            </li>
                        </ul>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td><b>Antibioprophylaxie  :</b></td>
                <td>{{ ($consultation_anesthesistes->antibiotique) }}</td>
            </tr>
            <tr>
                <td><b>Synthèse pré-opératoire :</b></td>
                <td>{{ ($consultation_anesthesistes->synthese_preop) }}</td>
            </tr>
            <tr>
                <td><b>Examens paracliniques :</b></td>
                <td>
                    @foreach(explode(",", $consultation_anesthesistes->examen_paraclinique) as $examen)
                        <ul>
                            <li>
                                {{ $examen }}
                            </li>
                        </ul>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>
                    <a href="{{ route('consultations.index_anesthesiste', $patient->id) }}">
                        <h1 class="text-info">VPA / LEMENTS NOUVEAUX</h1>
                    </a>
                </td>
                <td>
                    @if(count($patient->visite_preanesthesiques))
                        <a class="btn btn-info" title="Imprimer le consentement éclairé" href="{{ route('consentement_eclaire.pdf', $patient->id) }}">
                            <i class="far fa-check-circle"></i> Consentement éclairé
                        </a>
                    @endif
                </td>
            </tr>
            @if (count($patient->visite_preanesthesiques))

                <tr>
                    <td class="table-active"><b>DATE :</b></td>
                    <td class="table-active"><b>{{ $visite_anesthesistes->date_visite }}</b> <button class="btn btn-primary float-right"><i class="fas fa-eye"></i> Editer</button></td>
                </tr>
                <tr>
                    <td><b>Eléments nouveaux :</b></td>
                    <td>{{ $visite_anesthesistes->element_nouveaux }}</td>
                </tr>
            @else
                <tr>
                    <td><b>Aucune visite pré-anesthésique disponible :</b></td>
                    <td></td>
                </tr>
            @endif


        @else
            <tr>
                <td>
                    <b>Aucune consultation de disponible</b>
                </td>
                <td></td>
            </tr>
        @endif
    @endcan

    <tr>
        <td>
            <h1 class="text-info"><a href="{{ route('fiche_parametre.index', $patient->id) }}">PARAMETRES</a></h1>
        </td>
        <td></td>
    </tr>

    @if (count($patient->parametres) > 0)

        <tr>
            <td class="table-active"><b>DATE :</b></td>
            <td class="table-active"><b>{{ $parametres->created_at->toFormattedDateString() }}</b> @can('infirmier', \App\Patient::class)<a href="{{ route('consultations.edit', $patient->id) }}" class="btn btn-primary float-right"><i class="fas fa-eye"></i> Editer</a>@endcan</td>
        </tr>
        <tr>
            <td><b>DATE DE NAISSANCE :</b></td>
            <td>{{ $parametres->date_naissance }}</td>
        </tr>
        <tr>
            <td><b>AGE :</b></td>
            <td>{{ $parametres->age }} Ans</td>
        </tr>
        <tr>
            <td><b>POIDS :</b></td>
            <td>{{ $parametres->poids }} Kg</td>
        </tr>
        <tr>
            <td><b>TAILLE :</b></td>
            <td>{{ $parametres->taille }} M</td>
        </tr>
        <tr>
            <td><b>TEMPERATURE :</b></td>
            <td>{{ $parametres->temperature }} °C</td>
        </tr>
        <tr>
            <td><b>GLYCEMIE :</b></td>
            <td>{{ $parametres->glycemie }} g/l</td>
        </tr>
        <tr>
            <td><b>SPO2 :</b></td>
            <td>{{ $parametres->spo2 }} %</td>
        </tr>
        <tr>
            <td><b>IMC / BMI :</b></td>
            <td>{{ $parametres->inc_bmi }}</td>
        </tr>
        <tr>
            <td><b>TA :</b></td>
            <td>
                <b>Bg :</b> {{ $parametres->bras_gauche }} mmHg
                <br>
                <b>Bd :</b> {{ $parametres->bras_droit }} mmHg
            </td>
        </tr>
        <tr>
            <td><b>FR :</b></td>
            <td>{{ $parametres->fr }} Mvts/min</td>
        </tr>
        <tr>
            <td><b>FC :</b></td>
            <td>{{ $parametres->fc }} Pls/min</td>
        </tr>
    @else

        <tr>
            <td>
                <b>Aucun paramètre de disponible</b>
            </td>
            <td></td>
        </tr>
    @endif

    <tr>
        <td>
            @can('medecin', \App\Patient::class)
            <a class="btn btn-danger" href="{{ route('consultations.create', $patient->id) }}" title="Nouvelle consultation du patient">
                <i class="fas fa-book"></i> Nouvelle consultation
            </a>
            @endcan
        </td>
        @if (count($patient->consultations))
            @can('chirurgien', \App\Patient::class)
                <td>
                    <a class="btn btn-success" title="Consultation de suivi" href="{{ route('consultationsdesuivi.create', $patient->id) }}">
                        <i class="fas fa-book"></i> Consultation de suivi
                    </a>
                </td>
            @endcan
        @endif
        <td></td>
    </tr>

    @can('chirurgien', \App\Patient::class)
        <tr>
            <td>
                <a href="{{ route('compte_rendu_bloc.index', $patient->id) }}">
                    <h1 class="text-info">COMPTE-RENDU</h1>
                </a>
            </td>
            <td></td>
        </tr>

        @if (count($patient->compte_rendu_bloc_operatoires))
            <tr>
                <td class="table-active"><b>DATE :</b></td>
                <td class="table-active"><b>{{ $compte_rendu_bloc_operatoires->created_at->toFormattedDateString() }}</b> <a href="{{ route('compte_rendu_bloc.edit', $patient->id) }}" title="Modifier le compte-rendu" class="btn btn-primary float-right"><i class="fas fa-eye"></i> Editer</a></td>
            </tr>
            <tr>
                <td><b>NOM ET PRENOM DU CHIRURGIEN :</b></td>
                <td>{{ $compte_rendu_bloc_operatoires->chirurgien }}</td>
            </tr>
            <tr>
                <td><b>DATE DE L'INTERVENTION :</b></td>
                <td>{{ $compte_rendu_bloc_operatoires->date_intervention }}</td>
            </tr>
            <tr>
                <td><b>DUREE DE L'INTERVENTION :</b></td>
                <td>{{ $compte_rendu_bloc_operatoires->dure_intervention }}</td>
            </tr>
            <tr>
                <td><b>COMPTE-RENDU OPERATOIRE :</b></td>
                <td>{{ $compte_rendu_bloc_operatoires->compte_rendu_o }}</td>
            </tr>
            <tr>
                <td><b>RESULTATS HISTO-PATHOLOGIQUES :</b></td>
                <td>{{ $compte_rendu_bloc_operatoires->resultat_histo }}</td>
            </tr>
            <tr>
                <td><b>SUITES OPERATOIRES :</b></td>
                <td>{{ $compte_rendu_bloc_operatoires->suite_operatoire }}</td>
            </tr>
            <tr>
                <td><b>TRAITEMENT PROPOSE :</b></td>
                <td>{{ $compte_rendu_bloc_operatoires->traitement_propose }}</td>
            </tr>
            <tr>
                <td><b>SOINS ET EXAMENS A REALISER :</b></td>
                <td>{{ $compte_rendu_bloc_operatoires->soins }}</td>
            </tr>
            <tr>
                <td><b>CONCLUSION :</b></td>
                <td>{{ $compte_rendu_bloc_operatoires->conclusion }}</td>
            </tr>
            <tr>
                <td>
                    @if (count($patient->consultations))
                    <a href="{{ route('compte_rendu_bloc.create', $patient->id) }}" title="Rédiger un compte-rendu opératoire" class="btn btn-danger">
                        <i class="far fa-plus-square"></i> Nouveau CRO
                    </a>
                    @endif
                </td>
                <td>
                    @if (count($patient->compte_rendu_bloc_operatoires))
                        <a class="btn btn-success" title="Imprimer le compte-rendu opératoire" href="{{ route('compte_rendu_bloc_pdf.pdf', $patient->id) }}">
                            <i class="fas fa-print"></i> Imprimer le CRO
                        </a>
                    @endif
                </td>
            </tr>
        @else
            <tr>
                <td>
                    @if (count($patient->consultations))
                    <a href="{{ route('compte_rendu_bloc.create', $patient->id) }}" title="Rédiger un compte-rendu opératoire" class="btn btn-danger">
                        <i class="far fa-plus-square"></i> Nouveau CRO
                    </a>
                    @endif
                </td>
                <td></td>
            </tr>
        @endif
    @else

        @can('chirurgien', \App\Patient::class)
            <tr>
                <td>
                    <a class="btn btn-danger" href="{{ route('consultations.create', $patient->id) }}"
                       title="Nouvelle consultation du patient">
                        <i class="fas fa-book"></i> Nouvelle consultation
                    </a>
                </td>
                <td></td>
            </tr>
        @endcan

    @endif


@endcan

</tbody>
