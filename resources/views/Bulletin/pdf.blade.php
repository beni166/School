
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin scolaire</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 5mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 7px;
            color: #17365d;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #1684ed;
            padding-bottom: 5px;
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .school-name {
            font-size: 17px;
            font-weight: bold;
            color: #06458c;
        }

        .subtitle {
            color: #1675cf;
            font-size: 8px;
        }

        .bulletin-title {
            font-size: 14px;
            font-weight: bold;
            color: #06458c;
        }

        .motto {
            font-style: italic;
            color: #1675cf;
            margin-top: 3px;
        }

        .panel {
            border: 1px solid #8ccaff;
            padding: 5px;
            margin-bottom: 5px;
        }

        .section-title {
            color: #06458c;
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .info-table td {
            padding: 3px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            color: #06458c;
        }

        .grades {
            table-layout: fixed;
            margin-bottom: 6px;
        }

        .grades th {
            background: #06458c;
            color: #fff;
            padding: 4px 2px;
            border: 1px solid #8bbce9;
            text-align: center;
            font-size: 6px;
            line-height: 1.25;
        }

        .grades td {
            padding: 4px 2px;
            border: 1px solid #b8d9f3;
            text-align: center;
            vertical-align: middle;
            font-size: 6px;
            line-height: 1.25;
            word-wrap: break-word;
        }

        .grades tbody tr:nth-child(even) {
            background: #eef7ff;
        }

        .grades td.subject {
            text-align: left;
            font-weight: bold;
        }

        .appreciation {
            font-size: 6px;
            font-weight: bold;
            color: #0759a8;
        }

        .signature-cell {
            height: 25px;
        }

        .signature-line {
            display: block;
            width: 42px;
            margin: 12px auto 0;
            border-bottom: 1px solid #176bc1;
        }

        .signature-caption {
            display: block;
            font-size: 5px;
            margin-top: 2px;
            color: #476989;
        }

        .summary-table td {
            padding: 3px;
            border-bottom: 1px solid #d6eaff;
        }

        .average-box {
            text-align: center;
            background: #0878ed;
            color: #fff;
            padding: 7px;
            margin-top: 3px;
        }

        .average-value {
            font-size: 19px;
            font-weight: bold;
        }

        .decision {
            background: #e2f7ed;
            color: #08794c;
            padding: 5px;
            font-weight: bold;
            text-align: center;
        }

        .comment-box {
            background: #eef7ff;
            border: 1px solid #d1e8ff;
            padding: 5px;
            line-height: 1.4;
            min-height: 25px;
        }

        .signatures td {
            width: 33.33%;
            text-align: center;
            vertical-align: top;
            padding: 4px 2px;
        }

        .general-signature-line {
            width: 85px;
            margin: 18px auto 2px;
            border-bottom: 1px solid #176bc1;
        }

        .footer {
            border-top: 1px solid #1684ed;
            margin-top: 5px;
            padding-top: 4px;
            text-align: center;
            color: #1765ad;
            font-size: 6px;
            line-height: 1.4;
        }

        .muted {
            color: #5d7895;
        }

        .no-break {
            page-break-inside: avoid;
        }

        .bottom-table {
            table-layout: fixed;
        }

        .bottom-table > tbody > tr > td {
            vertical-align: top;
        }
    </style>
</head>

<body>

@php
    $inscription = $bulletin->inscription;
    $eleve = $inscription?->eleve;
    $classe = $inscription?->classe;
    $annee = $inscription?->anneeScolaire;
    $periode = $bulletin->periode;

    $details = $bulletin->details ?? collect();

    $nomEleve = $bulletin->nom_eleve
        ?? trim(($eleve->nom ?? '') . ' ' . ($eleve->prenom ?? ''));

    $classeLibelle = $bulletin->classe_libelle
        ?? $classe?->libelle
        ?? $classe?->nom
        ?? 'Non renseignée';

    $anneeLibelle = $bulletin->annee_libelle
        ?? $annee?->libelle
        ?? 'Non renseignée';

    $moyenne = $bulletin->moyenne_generale;
@endphp

{{-- EN-TÊTE --}}
<div class="header">
    <table>
        <tr>
            <td width="45%">
                <div class="school-name">SCHOOL</div>
                <div class="subtitle">Gestion scolaire</div>
                <div class="motto">Discipline • Travail • Réussite</div>
            </td>

            <td width="55%" style="text-align:right;">
                <div class="bulletin-title">BULLETIN DE NOTES</div>
                <div><strong>Année scolaire :</strong> {{ $anneeLibelle }}</div>
                <div>
                    <strong>Période :</strong>
                    {{ $periode->libelle ?? $periode->nom ?? 'Période scolaire' }}
                </div>
                <div class="motto">Ensemble pour l'excellence</div>
            </td>
        </tr>
    </table>
</div>

{{-- INFORMATIONS ÉLÈVE --}}
<div class="panel">
    <div class="section-title">INFORMATIONS DE L'ÉLÈVE</div>

    <table class="info-table">
        <tr>
            <td width="18%" class="label">Nom et prénom :</td>
            <td width="32%">{{ $nomEleve ?: 'Non renseigné' }}</td>
            <td width="18%" class="label">Classe :</td>
            <td width="32%">{{ $classeLibelle }}</td>
        </tr>

        <tr>
            <td class="label">Matricule :</td>
            <td>{{ $eleve->matricule ?? '—' }}</td>
            <td class="label">Année scolaire :</td>
            <td>{{ $anneeLibelle }}</td>
        </tr>

        <tr>
            <td class="label">Sexe :</td>
            <td>{{ $eleve->sexe ?? '—' }}</td>
            <td class="label">Date d'édition :</td>
            <td>{{ now()->format('d/m/Y') }}</td>
        </tr>
    </table>
</div>

{{-- TABLEAU DES NOTES --}}
<div class="section-title">DÉTAIL DES NOTES PAR MATIÈRE</div>

<table class="grades">
    <colgroup>
        <col style="width:4%">
        <col style="width:15%">
        <col style="width:5%">
        <col style="width:6%">
        <col style="width:6%">
        <col style="width:6%">
        <col style="width:7%">
        <col style="width:7%">
        <col style="width:12%">
        <col style="width:11%">
        <col style="width:21%">
    </colgroup>

    <thead>
        <tr>
            <th rowspan="2">N°</th>
            <th rowspan="2">Matière</th>
            <th rowspan="2">Coef.</th>
            <th colspan="4">Notes sur 20</th>
            <th rowspan="2">Moyenne</th>
            <th rowspan="2">Professeur</th>
            <th rowspan="2">Appréciation</th>
            <th rowspan="2">Signature du professeur</th>
        </tr>
        <tr>
            <th>Interro 1</th>
            <th>Interro 2</th>
            <th>Devoir</th>
            <th>Composition</th>
        </tr>
    </thead>

    <tbody>
        @forelse($details as $detail)
            @php
                $matiere = $detail->matiere;

                $professeur = $detail->professeur
                    ?? $detail->affectationProfesseur?->professeur;

                $coefficient = $detail->coefficient
                    ?? $matiere?->coefficient
                    ?? 1;

                $notes = [
                    $detail->interrogation_1,
                    $detail->interrogation_2,
                    $detail->devoir,
                    $detail->composition,
                ];

                $notesCompletes = collect($notes)
                    ->filter(fn ($note) => $note !== null && $note !== '');

                $moyenneMatiere = $detail->moyenne
                    ?? ($notesCompletes->count() === 4
                        ? round($notesCompletes->avg(), 2)
                        : null);

                $appreciation = $detail->appreciation
                    ?? ($moyenneMatiere === null
                        ? 'Non évalué'
                        : ($moyenneMatiere >= 16
                            ? 'Excellent'
                            : ($moyenneMatiere >= 14
                                ? 'Très bien'
                                : ($moyenneMatiere >= 12
                                    ? 'Bien'
                                    : ($moyenneMatiere >= 10
                                        ? 'Assez bien'
                                        : 'Insuffisant')))));
            @endphp

            <tr>
                <td>{{ $loop->iteration }}</td>

                <td class="subject">
                    {{ $matiere->nom ?? $matiere->libelle ?? 'Matière' }}
                </td>

                <td>{{ $coefficient }}</td>

                <td>{{ $detail->interrogation_1 ?? '—' }}</td>
                <td>{{ $detail->interrogation_2 ?? '—' }}</td>
                <td>{{ $detail->devoir ?? '—' }}</td>
                <td>{{ $detail->composition ?? '—' }}</td>

                <td>
                    <strong>
                        {{ $moyenneMatiere !== null
                            ? number_format((float) $moyenneMatiere, 2, ',', ' ')
                            : '—' }}
                    </strong>
                </td>

                <td>
                    {{ $professeur
                        ? trim(($professeur->nom ?? '') . ' ' . ($professeur->prenom ?? ''))
                        : '—' }}
                </td>

                <td class="appreciation">{{ $appreciation }}</td>

                <td class="signature-cell">
                    <span class="signature-line"></span>
                    <span class="signature-caption">Signature du professeur</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="11">Aucune note disponible pour ce bulletin.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- RÉSUMÉ --}}
<table class="bottom-table">
    <tr>
        <td width="57%" style="padding-right:4px;">

            <div class="panel no-break">
                <div class="section-title">APPRÉCIATION GÉNÉRALE</div>

                <div class="comment-box">
                    {{ $bulletin->appreciation_generale
                        ?? 'Aucune appréciation générale renseignée.' }}
                </div>
            </div>

            <div class="panel no-break">
                <div class="section-title">
                    OBSERVATIONS DU PROFESSEUR PRINCIPAL
                </div>

                <div class="comment-box">
                    {{ $bulletin->observation_professeur_principal
                        ?? 'Observations à compléter.' }}
                </div>
            </div>

        </td>

        <td width="43%" style="padding-left:4px;">

            <div class="panel no-break">
                <div class="section-title">MOYENNE GÉNÉRALE</div>

                <div class="average-box">
                    <div class="average-value">
                        {{ $moyenne !== null
                            ? number_format((float) $moyenne, 2, ',', ' ')
                            : '—' }}
                        <span style="font-size:10px;">/ 20</span>
                    </div>
                </div>
            </div>

            <div class="panel no-break">
                <div class="section-title">CLASSEMENT</div>

                <table class="summary-table">
                    <tr>
                        <td>Rang de l'élève</td>
                        <td style="text-align:right;">
                            {{ $bulletin->rang ?? '—' }}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="panel no-break">
                <div class="section-title">DÉCISION DU CONSEIL DE CLASSE</div>

                <div class="decision">
                    {{ $bulletin->decision ?? 'Décision à compléter' }}
                </div>
            </div>

        </td>
    </tr>
</table>

{{-- SIGNATURES FINALES --}}
<div class="panel no-break">
    <div class="section-title">VALIDATION DU BULLETIN</div>

    <table class="signatures">
        <tr>
            <td>
                <strong>Professeur principal</strong>
                <div class="muted">Nom et signature</div>
                <div class="general-signature-line"></div>
            </td>

            <td>
                <strong>Secrétariat</strong>
                <div class="muted">Nom et signature</div>
                <div class="general-signature-line"></div>
            </td>

            <td>
                <strong>Chef d'établissement</strong>
                <div class="muted">Signature et cachet</div>
                <div class="general-signature-line"></div>
            </td>
        </tr>
    </table>
</div>

{{-- PIED DE PAGE --}}
<div class="footer">
    <strong>Établissement scolaire</strong>
    &nbsp; | &nbsp;
    Adresse : ........................................
    <br>
    Téléphone : ........................
    &nbsp; | &nbsp;
    Email : ................................
    <br>
    <span class="motto">Ensemble pour l'excellence</span>
</div>

</body>
</html>
