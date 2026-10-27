
@extends('secretariat.layout.app')

@section('title', 'Détails de la matière')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('secretariat.matieres.index') }}"
               class="text-decoration-none text-secondary small">
                <i class="bi bi-arrow-left me-1"></i>
                Retour aux matières
            </a>

            <div class="d-flex align-items-center gap-3 mt-3">
                <div class="matiere-icon">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>

                <div>
                    <h1 class="h3 fw-bold text-dark mb-1">
                        {{ $matiere->nom }}
                    </h1>
                    <p class="text-secondary mb-0">
                        Code :
                        <span class="fw-semibold">
                            {{ $matiere->code ?? 'Non défini' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <a href="{{ route('secretariat.matieres.edit', $matiere->id) }}"
           class="btn btn-primary rounded-3 px-4">
            <i class="bi bi-pencil-square me-2"></i>
            Modifier la matière
        </a>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- Cartes statistiques --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="stat-label">Identifiant</div>
                    <h3 class="fw-bold mb-0">
                        MAT-{{ str_pad($matiere->id, 3, '0', STR_PAD_LEFT) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="stat-label">Classes programmées</div>
                    <h3 class="fw-bold mb-0">
                        {{ $matiere->programmesClasses->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="stat-label">Affectations de professeurs</div>
                    <h3 class="fw-bold mb-0">
                        {{ $matiere->affectations->count() }}
                    </h3>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">

        {{-- Informations générales --}}
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-header bg-white border-0 px-4 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        Informations générales
                    </h5>
                </div>

                <div class="card-body px-4">

                    <div class="detail-row">
                        <span class="text-secondary">Nom de la matière</span>
                        <span class="fw-semibold text-end">
                            {{ $matiere->nom }}
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="text-secondary">Code</span>
                        <span class="badge text-bg-primary">
                            {{ $matiere->code ?? 'Non défini' }}
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="text-secondary">Identifiant</span>
                        <span class="fw-semibold">
                            #{{ $matiere->id }}
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="text-secondary">Date de création</span>
                        <span class="fw-semibold">
                            {{ $matiere->created_at?->format('d/m/Y') ?? 'Non disponible' }}
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="text-secondary">Dernière modification</span>
                        <span class="fw-semibold">
                            {{ $matiere->updated_at?->format('d/m/Y') ?? 'Non disponible' }}
                        </span>
                    </div>

                </div>
            </div>
        </div>

        {{-- Programme des classes --}}
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-header bg-white border-0 px-4 pt-4">
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-mortarboard text-primary me-2"></i>
                        Programme des classes
                    </h5>
                    <p class="text-secondary small mb-0">
                        Classes dans lesquelles cette matière est enseignée.
                    </p>
                </div>

                <div class="card-body p-0 mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Classe</th>
                                    <th>Niveau</th>
                                    <th>Coefficient</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($matiere->programmesClasses as $programme)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-semibold">
                                                {{ $programme->classe?->code ?? $programme->classe?->nom ?? 'Classe non définie' }}
                                            </div>
                                            @if($programme->classe?->code && $programme->classe?->nom)
                                                <div class="text-secondary small">
                                                    {{ $programme->classe->nom }}
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $programme->classe?->niveau?->nom ?? 'Non défini' }}
                                        </td>

                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                {{ $programme->matiere?->coefficient ?? $matiere->coefficient ?? '—' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-secondary py-5">
                                            <i class="bi bi-journal-x display-6"></i>
                                            <p class="mt-2 mb-0">
                                                Cette matière n'est programmée dans aucune classe.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
        </div>

        {{-- Affectations des professeurs --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0 px-4 pt-4">
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-person-workspace text-primary me-2"></i>
                        Professeurs affectés
                    </h5>
                    <p class="text-secondary small mb-0">
                        Professeurs chargés d'enseigner cette matière dans les différentes classes.
                    </p>
                </div>

                <div class="card-body p-0 mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Professeur</th>
                                    <th>Classe</th>
                                    <th>Niveau</th>
                                    <th>Année scolaire</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($matiere->affectations as $affectation)
                                    <tr>
                                        <td class="ps-4">
                                            @if($affectation->professeur)
                                                <div class="fw-semibold">
                                                    {{ trim(($affectation->professeur->nom ?? $affectation->professeur->name ?? '') . ' ' . ($affectation->professeur->prenom ?? $affectation->professeur->first_name ?? '')) }}
                                                </div>
                                            @else
                                                <span class="text-secondary">
                                                    Professeur non défini
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $affectation->classe?->code ?? $affectation->classe?->nom ?? 'Non définie' }}
                                        </td>

                                        <td>
                                            {{ $affectation->classe?->niveau?->nom ?? 'Non défini' }}
                                        </td>

                                        <td>
                                            {{ $affectation->anneeScolaire?->libelle ?? 'Non précisée' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-secondary py-5">
                                            <i class="bi bi-person-x display-6"></i>
                                            <p class="mt-2 mb-0">
                                                Aucun professeur n'est affecté à cette matière.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    .matiere-icon {
        width: 60px;
        height: 60px;
        border-radius: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eaf1ff;
        color: #2457c5;
        font-size: 26px;
        flex-shrink: 0;
    }

    .stat-label {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 10px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid #edf0f5;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .table thead th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .4px;
        color: #64748b;
        white-space: nowrap;
    }

    .rounded-4 {
        border-radius: 16px !important;
    }
</style>
@endsection
