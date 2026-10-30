
@extends('admin.layout.app')

@section('title', 'Tableau de bord Directeur')

@section('content')
<div class="container-fluid py-4">

    {{-- EN-TÊTE --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Tableau de bord</h3>
            <p class="text-secondary mb-0">
                Bienvenue dans votre espace de direction.
            </p>
        </div>

        <div class="text-secondary small">
            <i class="fas fa-calendar-alt me-2"></i>
            {{ now()->translatedFormat('l d F Y') }}
        </div>
    </div>

    {{-- STATISTIQUES --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-secondary mb-2">Élèves</p>
                        <h3 class="fw-bold mb-0">{{ $totalEleves }}</h3>
                        <small class="text-secondary">Effectif enregistré</small>
                    </div>
                    <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-user-graduate fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-secondary mb-2">Professeurs</p>
                        <h3 class="fw-bold mb-0">{{ $totalProfesseurs }}</h3>
                        <small class="text-secondary">Personnel enseignant</small>
                    </div>
                    <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success">
                        <i class="fas fa-chalkboard-teacher fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-secondary mb-2">Classes</p>
                        <h3 class="fw-bold mb-0">{{ $totalClasses }}</h3>
                        <small class="text-secondary">Classes enregistrées</small>
                    </div>
                    <div class="rounded-3 p-3 bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-school fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-secondary mb-2">Inscriptions</p>
                        <h3 class="fw-bold mb-0">{{ $totalInscriptions }}</h3>
                        <small class="text-secondary">Dossiers enregistrés</small>
                    </div>
                    <div class="rounded-3 p-3 bg-info bg-opacity-10 text-info">
                        <i class="fas fa-file-signature fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- INDICATEURS SCOLAIRES --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Inscriptions en attente</span>
                        <i class="fas fa-hourglass-half text-warning"></i>
                    </div>
                    <h3 class="fw-bold mt-3 mb-2">
                        {{ $inscriptionsEnAttente }}
                    </h3>
                    <a href="{{ route('director.inscriptions.index') }}"
                       class="small text-decoration-none">
                        Examiner les dossiers
                        <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Bulletins générés</span>
                        <i class="fas fa-file-alt text-primary"></i>
                    </div>
                    <h3 class="fw-bold mt-3 mb-2">{{ $totalBulletins }}</h3>
                    <a href="{{ route('director.bulletins.index') }}"
                       class="small text-decoration-none">
                        Consulter les bulletins
                        <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Bulletins en brouillon</span>
                        <i class="fas fa-edit text-danger"></i>
                    </div>
                    <h3 class="fw-bold mt-3 mb-2">
                        {{ $bulletinsBrouillon }}
                    </h3>
                    <small class="text-secondary">
                        Bulletins en attente de validation
                    </small>
                </div>
            </div>
        </div>

    </div>

    {{-- INSCRIPTIONS RÉCENTES --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-3 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Inscriptions récentes</h5>

                <a href="{{ route('director.inscriptions.index') }}"
                   class="btn btn-sm btn-outline-primary">
                    Voir tout
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3">Élève</th>
                            <th>Classe</th>
                            <th>Année scolaire</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($inscriptionsRecentes as $inscription)
                            <tr>
                                <td class="px-3">
                                    <div class="fw-semibold">
                                        {{ $inscription->eleve->nom ?? '' }}
                                        {{ $inscription->eleve->prenom ?? '' }}
                                    </div>
                                </td>

                                <td>
                                    {{ $inscription->classe->libelle
                                        ?? $inscription->classe->nom
                                        ?? '—' }}
                                </td>

                                <td>
                                    {{ $inscription->anneeScolaire->libelle ?? '—' }}
                                </td>

                                <td>
                                    @php
                                        $statut = $inscription->statut ?? 'Non défini';

                                        $badge = match ($statut) {
                                            'validee', 'validée', 'acceptee', 'acceptée' => 'success',
                                            'en_attente' => 'warning',
                                            'refusee', 'refusée' => 'danger',
                                            default => 'secondary',
                                        };
                                    @endphp

                                    <span class="badge text-bg-{{ $badge }}">
                                        {{ ucfirst(str_replace('_', ' ', $statut)) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $inscription->created_at?->format('d/m/Y') ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-secondary">
                                    Aucune inscription enregistrée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- BULLETINS RÉCENTS --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-3 px-3">
            <h5 class="fw-bold mb-0">Derniers bulletins</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3">Élève</th>
                            <th>Classe</th>
                            <th>Période</th>
                            <th>Moyenne</th>
                            <th>État</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($bulletinsRecents as $bulletin)
                            <tr>
                                <td class="px-3">
                                    {{ $bulletin->nom_eleve
                                        ?? trim(($bulletin->inscription->eleve->nom ?? '') . ' ' .
                                        ($bulletin->inscription->eleve->prenom ?? '')) }}
                                </td>

                                <td>
                                    {{ $bulletin->classe_libelle
                                        ?? $bulletin->inscription->classe->libelle
                                        ?? $bulletin->inscription->classe->nom
                                        ?? '—' }}
                                </td>

                                <td>
                                    {{ $bulletin->periode->libelle
                                        ?? $bulletin->periode->nom
                                        ?? '—' }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $bulletin->moyenne_generale !== null
                                        ? number_format((float) $bulletin->moyenne_generale, 2, ',', ' ') . ' / 20'
                                        : '—' }}
                                </td>

                                <td>
                                    @if($bulletin->statut === 'valide')
                                        <span class="badge text-bg-success">Validé</span>
                                    @else
                                        <span class="badge text-bg-warning">Brouillon</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-secondary">
                                    Aucun bulletin enregistré.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection