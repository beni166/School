@extends('secretariat.layout.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('secretariat.classes.index') }}" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left me-1"></i> Retour aux classes
            </a>

            <div class="d-flex align-items-center gap-3 mt-3">
                <div class="class-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div>
                    <h2 class="fw-bold text-dark mb-1">{{ $classe->nom }}</h2>
                    <p class="text-muted mb-0">
                        {{ $classe->niveau?->nom ?? 'Niveau non défini' }}
                        ·
                        {{ $classe->niveau?->cycle?->nom ?? 'Cycle non défini' }}
                    </p>
                </div>
            </div>
        </div>

        <a href="{{ route('secretariat.classes.edit', $classe->id) }}" class="btn btn-primary px-4">
            <i class="bi bi-pencil-square me-2"></i>Modifier la classe
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="text-muted small mb-2">Identifiant</div>
                    <h4 class="fw-bold mb-0">#{{ $classe->id }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="text-muted small mb-2">Niveau</div>
                    <h5 class="fw-bold mb-0">{{ $classe->niveau?->nom ?? 'Non défini' }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="text-muted small mb-2">Inscriptions</div>
                    <h4 class="fw-bold mb-0">{{ $classe->inscriptions->count() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="text-muted small mb-2">Matières programmées</div>
                    <h4 class="fw-bold mb-0">{{ $classe->programmesClasses->count() }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- Informations générales --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-info-circle text-primary me-2"></i>Informations générales
                    </h5>
                </div>

                <div class="card-body px-4">
                    <div class="detail-row">
                        <span class="text-muted">Nom de la classe</span>
                        <span class="fw-semibold">{{ $classe->nom }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="text-muted">Niveau scolaire</span>
                        <span class="fw-semibold">{{ $classe->niveau?->nom ?? 'Non défini' }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="text-muted">Cycle</span>
                        <span class="fw-semibold">{{ $classe->niveau?->cycle?->nom ?? 'Non défini' }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="text-muted">Date de création</span>
                        <span class="fw-semibold">
                            {{ $classe->created_at?->format('d/m/Y') ?? 'Non disponible' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Professeurs affectés --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-person-workspace text-primary me-2"></i>Professeurs affectés
                    </h5>
                </div>

                <div class="card-body p-0 mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Professeur</th>
                                    <th>Matière</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classe->affectations as $affectation)
                                    <tr>
                                        <td class="ps-4">
                                            @if($affectation->professeur)
                                                {{ trim(($affectation->professeur->nom ?? '') . ' ' . ($affectation->professeur->prenom ?? $affectation->professeur->first_name ?? '')) }}
                                            @else
                                                <span class="text-muted">Professeur non défini</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $affectation->matiere?->nom ?? 'Matière non définie' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-4">
                                            Aucune affectation enregistrée pour cette classe.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Inscriptions --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-people text-primary me-2"></i>Élèves inscrits
                    </h5>
                    <p class="text-muted small mb-0">Liste des inscriptions associées à cette classe.</p>
                </div>

                <div class="card-body p-0 mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Élève</th>
                                    <th>Année scolaire</th>
                                    <th>Date d'inscription</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classe->inscriptions as $inscription)
                                    <tr>
                                        <td class="ps-4 fw-semibold">
                                            @if($inscription->eleve)
                                                {{ trim(($inscription->eleve->nom ?? '') . ' ' . ($inscription->eleve->prenom ?? $inscription->eleve->first_name ?? '')) }}
                                            @else
                                                <span class="text-muted">Élève non associé</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $inscription->anneeScolaire?->nom ?? $inscription->annee_scolaire ?? 'Non précisée' }}
                                        </td>
                                        <td>
                                            {{ $inscription->created_at?->format('d/m/Y') ?? 'Non disponible' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <i class="bi bi-people display-6 text-muted"></i>
                                            <p class="text-muted mt-2 mb-0">Aucune inscription trouvée pour cette classe.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Programme des matières --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-journal-bookmark text-primary me-2"></i>Programme des matières
                    </h5>
                    <p class="text-muted small mb-0">Matières programmées pour cette classe.</p>
                </div>

                <div class="card-body p-0 mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Matière</th>
                                    <th>Coefficient</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classe->programmesClasses as $programme)
                                    <tr>
                                        <td class="ps-4 fw-semibold">
                                            {{ $programme->matiere?->nom ?? 'Matière non définie' }}
                                        </td>
                                        <td>
                                            {{ $programme->matiere?->coefficient ?? '—' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-4">
                                            Aucune matière programmée pour cette classe.
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
    .class-icon {
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