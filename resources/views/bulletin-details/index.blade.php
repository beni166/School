@extends('admin.layout.app')

@section('title', 'Détails du bulletin')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="{{ route('director.bulletins.show', [$bulletin,'details']) }}"
               class="text-decoration-none text-secondary small">
                <i class="bi bi-arrow-left me-1"></i>
                Retour au bulletin
            </a>

            <h2 class="fw-bold mt-3 mb-1">
                <i class="bi bi-journal-text text-primary me-2"></i>
                Détail des matières
            </h2>

            <p class="text-secondary mb-0">
                Notes et résultats par matière pour cet élève.
            </p>
        </div>

        @if($bulletin->statut !== 'valide')
            <a href="{{ route('director.bulletins-details.create', $bulletin) }}"
               class="btn btn-primary rounded-3 px-3 py-2">
                <i class="bi bi-plus-lg me-1"></i>
                Ajouter une matière
            </a>
        @else
            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                <i class="bi bi-shield-check me-1"></i>
                Bulletin validé
            </span>
        @endif
    </div>

    {{-- Informations de l'élève --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">

                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex
                                    align-items-center justify-content-center"
                             style="width:58px;height:58px;flex-shrink:0;">
                            <i class="bi bi-person-fill fs-3"></i>
                        </div>

                        <div>
                            <div class="text-secondary small">Élève</div>
                            <h5 class="fw-bold mb-1">
                                {{ $bulletin->prenom_eleve }}
                                {{ $bulletin->nom_eleve }}
                            </h5>
                            <span class="text-secondary small">
                                {{ $bulletin->classe_libelle ?? 'Classe non renseignée' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text-secondary small mb-1">Année scolaire</div>
                    <div class="fw-semibold">
                        {{ $bulletin->annee_libelle ?? 'Non renseignée' }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text-secondary small mb-1">Statut du bulletin</div>

                    @if($bulletin->statut === 'valide')
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i> Validé
                        </span>
                    @else
                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-2">
                            <i class="bi bi-pencil-square me-1"></i> Brouillon
                        </span>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- Avertissement si le bulletin est validé --}}
    @if($bulletin->statut === 'valide')
        <div class="alert alert-success border-0 rounded-3 mb-4">
            <i class="bi bi-lock-fill me-2"></i>
            Ce bulletin est validé. Ses données sont consultables en lecture seule.
        </div>
    @endif

    {{-- Statistiques --}}
    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small mb-1">Nombre de matières</div>
                            <h3 class="fw-bold mb-0">{{ $bulletinDetails->count() }}</h3>
                        </div>
                        <div class="bg-primary-subtle text-primary rounded-3 p-3">
                            <i class="bi bi-book fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small mb-1">Moyenne générale</div>
                            <h3 class="fw-bold mb-0
                                {{ $bulletin->moyenne_generale !== null
                                    ? ($bulletin->moyenne_generale >= 10 ? 'text-success' : 'text-danger')
                                    : '' }}">
                                {{ $bulletin->moyenne_generale !== null
                                    ? number_format((float) $bulletin->moyenne_generale, 2, ',', ' ') . '/20'
                                    : 'Non calculée' }}
                            </h3>
                        </div>
                        <div class="bg-success-subtle text-success rounded-3 p-3">
                            <i class="bi bi-graph-up-arrow fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small mb-1">Période</div>
                            <h5 class="fw-bold mb-0">
                                {{ optional($bulletin->periode)->libelle
                                    ?? optional($bulletin->periode)->type
                                    ?? 'Non renseignée' }}
                            </h5>
                        </div>
                        <div class="bg-info-subtle text-info rounded-3 p-3">
                            <i class="bi bi-calendar3 fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tableau des matières --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h5 class="fw-bold mb-1">Résultats par matière</h5>
                    <p class="text-secondary small mb-0">
                        Détail des évaluations et des résultats obtenus.
                    </p>
                </div>

                <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                    {{ $bulletinDetails->count() }}
                    {{ $bulletinDetails->count() > 1 ? 'matières' : 'matière' }}
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Matière / Professeur</th>
                            <th class="text-center">Interro. 1</th>
                            <th class="text-center">Interro. 2</th>
                            <th class="text-center">Devoir</th>
                            <th class="text-center">Composition</th>
                            <th class="text-center">Coefficient</th>
                            <th class="text-center">Moyenne</th>
                            <th class="text-center">Rang</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($bulletinDetails as $detail)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold">
                                        {{ $detail->matiere_libelle
                                            ?? optional($detail->matiere)->nom
                                            ?? 'Matière inconnue' }}
                                    </div>

                                    <div class="text-secondary small">
                                        <i class="bi bi-person me-1"></i>
                                        {{ $detail->professeur_libelle ?: 'Professeur non renseigné' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    {{ number_format((float) $detail->interrogation_1, 2, ',', ' ') }}
                                </td>

                                <td class="text-center">
                                    {{ number_format((float) $detail->interrogation_2, 2, ',', ' ') }}
                                </td>

                                <td class="text-center">
                                    {{ number_format((float) $detail->devoir, 2, ',', ' ') }}
                                </td>

                                <td class="text-center">
                                    {{ number_format((float) $detail->composition, 2, ',', ' ') }}
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-light text-dark border">
                                        {{ number_format((float) $detail->coefficient, 2, ',', ' ') }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="fw-bold
                                        {{ $detail->moyenne_matiere >= 10
                                            ? 'text-success'
                                            : 'text-danger' }}">
                                        {{ number_format((float) $detail->moyenne_matiere, 2, ',', ' ') }}/20
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if($detail->rang_matiere)
                                        <span class="badge bg-primary-subtle text-primary rounded-pill">
                                            {{ $detail->rang_matiere }}e
                                        </span>
                                    @else
                                        <span class="text-secondary">—</span>
                                    @endif
                                </td>

                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">

                                        <a href="{{ route('director.bulletins-details.show', [$bulletin, $detail]) }}"
                                           class="btn btn-sm btn-outline-info rounded-3"
                                           title="Consulter">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if($bulletin->statut !== 'valide')
                                            <a href="{{ route('director.bulletins-details.edit', [$bulletin, $detail]) }}"
                                               class="btn btn-sm btn-outline-primary rounded-3"
                                               title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('director.bulletins-details.destroy', [$bulletin, $detail]) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Voulez-vous vraiment supprimer cette matière du bulletin ?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-3"
                                                        title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="bi bi-journal-x text-secondary"
                                           style="font-size:3rem;"></i>
                                    </div>

                                    <h6 class="fw-bold">Aucune matière enregistrée</h6>

                                    <p class="text-secondary small mb-3">
                                        Ce bulletin ne contient pas encore de détail par matière.
                                    </p>

                                    @if($bulletin->statut !== 'valide')
                                        <a href="{{ route('director.bulletins-details.create', $bulletin) }}"
                                           class="btn btn-primary rounded-3">
                                            <i class="bi bi-plus-lg me-1"></i>
                                            Ajouter une matière
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        @if($bulletinDetails->isNotEmpty())
            <div class="card-footer bg-white border-0 px-4 py-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <span class="text-secondary small">
                        Affichage de {{ $bulletinDetails->count() }}
                        {{ $bulletinDetails->count() > 1 ? 'matières' : 'matière' }}.
                    </span>

                    <a href="{{ route('director.bulletins.show', $bulletin) }}"
                       class="btn btn-light border rounded-3">
                        <i class="bi bi-arrow-left me-1"></i>
                        Retour au bulletin
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
