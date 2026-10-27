@extends('secretariat.layout.app')

@section('title', 'Tableau de bord Secrétariat')

@section('content')
<div class="container-fluid py-4">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Espace secrétariat</h3>
            <p class="text-muted mb-0">
                Gérez les inscriptions, les élèves et les dossiers scolaires.
            </p>
        </div>

        <a href="{{ route('secretary.inscriptions.create') }}"
           class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Nouvelle inscription
        </a>
    </div>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Fermer"></button>
        </div>
    @endif

    {{-- Indicateurs --}}
    @php
        $stats = [
            [
                'label' => 'Inscriptions en attente',
                'value' => $inscriptionsEnAttente ?? 0,
                'icon' => 'fa-user-clock',
                'color' => 'warning',
                'route' => 'secretary.inscriptions.index',
            ],
            [
                'label' => 'Élèves inscrits',
                'value' => $totalEleves ?? 0,
                'icon' => 'fa-user-graduate',
                'color' => 'primary',
                'route' => 'secretary.eleves.index',
            ],
            [
                'label' => 'Inscriptions récentes',
                'value' => $inscriptionsRecentes->count() ?? 0,
                'icon' => 'fa-user-plus',
                'color' => 'success',
                'route' => 'secretary.inscriptions.index',
            ],
            [
                'label' => 'Bulletins en brouillon',
                'value' => $bulletinsBrouillon ?? 0,
                'icon' => 'fa-file-alt',
                'color' => 'danger',
                'route' => 'secretary.bulletins.index',
            ],
        ];
    @endphp

    <div class="row g-3 mb-4">
        @foreach($stats as $stat)
            <div class="col-12 col-sm-6 col-xl-3">
                <a href="{{ route($stat['route']) }}"
                   class="text-decoration-none text-reset">
                    <div class="card border-0 shadow-sm h-100 dashboard-stat-card">
                        <div class="card-body p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-2">
                                    {{ $stat['label'] }}
                                </p>
                                <h3 class="fw-bold mb-0">
                                    {{ $stat['value'] }}
                                </h3>
                            </div>

                            <div class="stat-icon bg-{{ $stat['color'] }} bg-opacity-10
                                        text-{{ $stat['color'] }}">
                                <i class="fas {{ $stat['icon'] }} fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    {{-- Contenu principal --}}
    <div class="row g-4">

        {{-- Actions rapides --}}
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 p-4 pb-2">
                    <h5 class="fw-bold mb-1">Actions rapides</h5>
                    <p class="text-muted small mb-0">
                        Accédez rapidement aux principales fonctionnalités.
                    </p>
                </div>

                <div class="card-body p-4">
                    <div class="d-grid gap-3">

                        <a href="{{ route('secretary.inscriptions.index') }}"
                           class="btn btn-primary py-3 text-start">
                            <i class="fas fa-user-plus me-2"></i>
                            Gérer les inscriptions
                            <i class="fas fa-arrow-right float-end mt-1"></i>
                        </a>

                        <a href="{{ route('secretary.eleves.index') }}"
                           class="btn btn-outline-primary py-3 text-start">
                            <i class="fas fa-user-graduate me-2"></i>
                            Consulter les élèves
                            <i class="fas fa-arrow-right float-end mt-1"></i>
                        </a>

                        <a href="{{ route('secretary.affectations.index') }}"
                           class="btn btn-outline-secondary py-3 text-start">
                            <i class="fas fa-chalkboard-teacher me-2"></i>
                            Affectations des professeurs
                            <i class="fas fa-arrow-right float-end mt-1"></i>
                        </a>

                        <a href="{{ route('secretary.bulletins.index') }}"
                           class="btn btn-outline-success py-3 text-start">
                            <i class="fas fa-file-alt me-2"></i>
                            Suivre les bulletins
                            <i class="fas fa-arrow-right float-end mt-1"></i>
                        </a>

                        <a href="{{ route('secretary.presences.index') }}"
                           class="btn btn-outline-warning py-3 text-start">
                            <i class="fas fa-calendar-check me-2"></i>
                            Gérer les présences
                            <i class="fas fa-arrow-right float-end mt-1"></i>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        {{-- Dernières inscriptions --}}
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h5 class="fw-bold mb-1">Dernières inscriptions</h5>
                            <p class="text-muted small mb-0">
                                Consultez les derniers dossiers enregistrés.
                            </p>
                        </div>

                        <a href="{{ route('secretary.inscriptions.index') }}"
                           class="btn btn-sm btn-outline-primary">
                            Tout afficher
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Élève</th>
                                    <th>Classe</th>
                                    <th>Année scolaire</th>
                                    <th>Date</th>
                                    <th class="pe-4">Statut</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse(($dernieresInscriptions ?? collect()) as $inscription)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-semibold">
                                                {{ $inscription->eleve?->nom ?? 'Nom inconnu' }}
                                                {{ $inscription->eleve?->prenom ?? '' }}
                                            </div>
                                            <small class="text-muted">
                                                Dossier #{{ $inscription->id }}
                                            </small>
                                        </td>

                                        <td>
                                            {{ $inscription->classe?->libelle
                                                ?? $inscription->classe?->nom
                                                ?? '—' }}
                                        </td>

                                        <td>
                                            {{ $inscription->anneeScolaire?->libelle ?? '—' }}
                                        </td>

                                        <td>
                                            {{ $inscription->created_at?->format('d/m/Y') ?? '—' }}
                                        </td>

                                        <td class="pe-4">
                                            @php
                                                $statut = $inscription->statut ?? 'en_attente';

                                                $badgeClass = match($statut) {
                                                    'validee', 'validée', 'acceptee', 'acceptée' => 'success',
                                                    'refusee', 'refusée' => 'danger',
                                                    default => 'warning',
                                                };

                                                $statutLabel = match($statut) {
                                                    'validee', 'validée', 'acceptee', 'acceptée' => 'Validée',
                                                    'refusee', 'refusée' => 'Refusée',
                                                    default => 'En attente',
                                                };
                                            @endphp

                                            <span class="badge rounded-pill bg-{{ $badgeClass }}-subtle
                                                         text-{{ $badgeClass }}-emphasis">
                                                {{ $statutLabel }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fas fa-folder-open fa-2x text-muted mb-3"></i>
                                            <p class="text-muted mb-0">
                                                Aucune inscription récente.
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

{{-- Styles du tableau de bord --}}
<style>
    .dashboard-stat-card {
        border-radius: 14px;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .dashboard-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .08) !important;
    }

    .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table th {
        font-size: .8rem;
        font-weight: 600;
        color: #64748b;
        white-space: nowrap;
    }

    .table td {
        font-size: .9rem;
    }
</style>
@endsection
