<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Liste des élèves</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        .entete {
            text-align: center;
            margin-bottom: 20px;
        }

        .entete h2 {
            margin-bottom: 8px;
            color: #17365d;
        }

        .infos {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #bbb;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background: #17365d;
            color: white;
            text-align: center;
        }

        .notes {
            font-size: 8px;
            line-height: 1.7;
        }

        .centre {
            text-align: center;
        }

        .pied {
            margin-top: 15px;
            text-align: right;
            font-size: 9px;
        }
    </style>
</head>

<body>

    <div class="entete">
        <h2>LISTE DES ÉLÈVES PAR CLASSE</h2>
        <div>Année scolaire : {{ $anneeScolaire->libelle }}</div>
    </div>

    <div class="infos">
        <strong>Classe :</strong> {{ $classe->nom }}
        <br>
        <strong>Effectif :</strong> {{ $inscriptions->count() }} élève(s)
    </div>
<table>
    <thead>
        <tr>
            <th style="width: 5%">N°</th>
            <th style="width: 27%">Nom et prénom</th>
            <th style="width: 8%">Sexe</th>
            <th style="width: 12%">Interrogation 1</th>
            <th style="width: 12%">Interrogation 2</th>
            <th style="width: 10%">Devoir</th>
            <th style="width: 12%">Composition</th>
            <th style="width: 14%">Observation / Signature</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($inscriptions as $inscription)
            <tr>
                <td class="centre">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $inscription->eleve->nom ?? '' }}
                    {{ $inscription->eleve->prenom ?? '' }}
                </td>

                <td class="centre">
                    {{ $inscription->eleve->sexe ?? '-' }}
                </td>

                <td class="centre">&nbsp;</td>
                <td class="centre">&nbsp;</td>
                <td class="centre">&nbsp;</td>
                <td class="centre">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="centre">
                    Aucun élève inscrit dans cette classe pour cette année scolaire.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</body>
</html>