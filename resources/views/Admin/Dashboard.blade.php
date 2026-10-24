
@extends('admin.layout.app')

@section('title', 'Tableau de bord Directeur')

@section('content')
<div class="container-fluid py-4">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between
                align-items-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold mb-1">Tableau de bord</h3>
            <p class="text-muted mb-0">
                Vue générale de votre établissement scolaire.
            </p>
        </div>

        <span class="badge bg-primary-subtle text-primary p-2">
            <i class="fas fa-calendar-alt me-1"></i>
            {{ now()->translatedFormat('d F Y') }}
        </span>
    </div>

    {{-- Indicateurs --}}
    <div class="row g-3 mb-4">

        @php
            $stats = [
                [
                    'label' => 'Élèves inscrits',
                    'value' => $totalEleves ?? 0,
                    'icon' => 'fa-user-graduate',
                    'color' => 'primary',
                ],
                [
                    'label' => 'Enseignants',
                    'value' => $totalProfesseurs ?? 0,
                    'icon' => 'fa-chalkboard-teacher',
                    'color' => 'success',
                ],
                [
                    'label' => 'Classes',
                    'value' => $totalClasses ?? 0,
                    'icon' => 'fa-school',
                    'color' => 'warning',
                ],
                [
                    'label' => 'Bulletins à valider',
                    'value' => $bulletinsEnAttente ?? 0,
                    'icon' => 'fa-file-alt',
                    'color' => 'danger',
                ],
            ];
        @endphp

        @foreach ($stats as $stat)
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex
                                justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-2">
                                {{ $stat['label'] }}
                            </p>
                            <h3 class="fw-bold mb-0">
                                {{ $stat['value'] }}
                            </h3>
                        </div>

                        <div class="rounded-3 bg-{{ $stat['color'] }}
                                    bg-opacity-10 text-{{ $stat['color'] }}
                                    p-3">
                            <i class="fas {{ $stat['icon'] }} fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Activités récentes --}}
    <div class="row g-4">

        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-1">
                        <i class="fas fa-history text-primary me-2"></i>
                        Dernières inscriptions
                    </h5>
                    <p class="text-muted small mb-0">
                        Suivi récent des élèves inscrits.
                    </p>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Élève</th>
                                    <th>Classe</th>
                                    <th>Année scolaire</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dernieresInscriptions ?? [] as $inscription)
                                    <tr>
                                        <td>
                                            {{ $inscription->eleve->nom ?? '' }}
                                            {{ $inscription->eleve->prenom ?? '' }}
                                        </td>
                                        <td>
                                            {{ $inscription->classe->libelle
                                                ?? $inscription->classe->nom
                                                ?? '—' }}
                                        </td>
                                        <td>
                                            {{ $inscription->anneeScolaire->libelle
                                                ?? '—' }}
                                        </td>
                                        <td>
                                            <a href="{{ route(
                                                'director.inscriptions.index'
                                            ) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                Consulter
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="text-center text-muted py-4">
                                            Aucune inscription récente.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Accès rapides
                    </h5>
                </div>

                <div class="card-body d-grid gap-3">
                    <a href="{{ route('director.eleves.index') }}"
                       class="btn btn-outline-primary text-start p-3">
                        <i class="fas fa-user-graduate me-2"></i>
                        Gestion des élèves
                    </a>

                    <a href="{{ route('director.inscriptions.index') }}"
                       class="btn btn-outline-success text-start p-3">
                        <i class="fas fa-user-plus me-2"></i>
                        Suivi des inscriptions
                    </a>

                    <a href="{{ route('director.bulletins.index') }}"
                       class="btn btn-outline-warning text-start p-3">
                        <i class="fas fa-file-alt me-2"></i>
                        Consulter les bulletins
                    </a>

                    <a href="{{ route('director.annees-scolaires.index') }}"
                       class="btn btn-outline-secondary text-start p-3">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Années scolaires
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
