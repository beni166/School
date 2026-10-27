@extends('admin.layout.app')

@section('title', 'Consulter une matière')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="{{ route('director.bulletins-details.index', $bulletin) }}"
               class="text-decoration-none small">
                <i class="bi bi-arrow-left me-1"></i> Retour aux matières
            </a>
            <h2 class="fw-bold mt-3 mb-1">{{ $detail->matiere_libelle }}</h2>
            <p class="text-secondary mb-0">
                {{ $bulletin->prenom_eleve }} {{ $bulletin->nom_eleve }}
                — {{ $bulletin->classe_libelle }}
            </p>
        </div>

        @if($bulletin->statut !== 'valide')
            <a href="{{ route('director.bulletins-details.edit', [$bulletin, $detail]) }}"
               class="btn btn-primary rounded-3">
                <i class="bi bi-pencil me-1"></i> Modifier
            </a>
        @endif
    </div>

    @if($bulletin->statut === 'valide')
        <div class="alert alert-success rounded-3">
            <i class="bi bi-shield-check me-2"></i>
            Bulletin validé : les données sont consultables en lecture seule.
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Résultats des évaluations</h5>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Évaluation</th>
                                    <th class="text-end">Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Interrogation 1</td>
                                    <td class="text-end fw-semibold">{{ number_format((float) $detail->interrogation_1, 2, ',', ' ') }}/20</td>
                                </tr>
                                <tr>
                                    <td>Interrogation 2</td>
                                    <td class="text-end fw-semibold">{{ number_format((float) $detail->interrogation_2, 2, ',', ' ') }}/20</td>
                                </tr>
                                <tr>
                                    <td>Devoir</td>
                                    <td class="text-end fw-semibold">{{ number_format((float) $detail->devoir, 2, ',', ' ') }}/20</td>
                                </tr>
                                <tr>
                                    <td>Composition</td>
                                    <td class="text-end fw-semibold">{{ number_format((float) $detail->composition, 2, ',', ' ') }}/20</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <div class="text-secondary small">Moyenne de la matière</div>
                                <div class="fs-3 fw-bold {{ $detail->moyenne_matiere >= 10 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format((float) $detail->moyenne_matiere, 2, ',', ' ') }}/20
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <div class="text-secondary small">Points coefficientés</div>
                                <div class="fs-3 fw-bold text-primary">
                                    {{ number_format((float) $detail->points_coefficientes, 2, ',', ' ') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Informations générales</h5>

                    <div class="mb-3">
                        <div class="text-secondary small">Professeur</div>
                        <div class="fw-semibold">
                            {{ $detail->professeur_libelle ?: 'Non renseigné' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-secondary small">Coefficient</div>
                        <div class="fw-semibold">
                            {{ number_format((float) $detail->coefficient, 2, ',', ' ') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-secondary small">Rang</div>
                        <div class="fw-semibold">
                            {{ $detail->rang_matiere ? $detail->rang_matiere . 'e' : 'Non calculé' }}
                        </div>
                    </div>

                    <div>
                        <div class="text-secondary small">Appréciation</div>
                        <div class="fw-semibold">
                            {{ $detail->appreciation ?: 'Non renseignée' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold">Règle de calcul</h6>
                    <p class="text-secondary small mb-2">
                        Moyenne de la matière = somme des quatre notes divisée par quatre.
                    </p>
                    <p class="text-secondary small mb-0">
                        Points coefficientés = moyenne de la matière multipliée par le coefficient.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
