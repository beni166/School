
@extends('secretariat.layout.app')

@section('title', 'Tableau de bord Secrétariat')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <h3 class="fw-bold mb-1">Espace secrétariat</h3>
        <p class="text-muted mb-0">
            Gérez les inscriptions, les élèves et les dossiers scolaires.
        </p>
    </div>

    {{-- Indicateurs --}}
    <div class="row g-3 mb-4">

        @php
            $stats = [
                [
                    'label' => 'Inscriptions en attente',
                    'value' => $inscriptionsEnAttente ?? 0,
                    'icon' => 'fa-user-clock',
                    'color' => 'warning',
                ],
                [
                    'label' => 'Élèves inscrits',
                    'value' => $totalEleves ?? 0,
                    'icon' => 'fa-user-graduate',
                    'color' => 'primary',
                ],
                [
                    'label' => 'Inscriptions récentes',
                    'value' => $inscriptionsRecentes ?? 0,
                    'icon' => 'fa-user-plus',
                    'color' => 'success',
                ],
                [
                    'label' => 'Bulletins en brouillon',
                    'value' => $bulletinsBrouillon ?? 0,
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

    {{-- Actions et inscriptions --}}
    <div class="row g-4">

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Actions rapides</h5>

                    <div class="d-grid gap-3">
                        <a href="{{ route('director.inscriptions.index') }}"
                           class="btn btn-primary py-3">
                            <i class="fas fa-user-plus me-2"></i>
                            Gérer les inscriptions
                        </a>

                        <a href="{{ route('director.eleves.index') }}"
                           class="btn btn-outline-primary py-3">
                            <i class="fas fa-user-graduate me-2"></i>
                            Consulter les élèves
                        </a>

                        <a href="{{ route('director.bulletins.index') }}"
                           class="btn btn-outline-success py-3">
                            <i class="fas fa-file-alt me-2"></i>
                            Suivre les bulletins
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-1">Dernières inscriptions</h5>
                    <p class="text-muted small mb-0">
                        Les dossiers récemment enregistrés.
                    </p>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Élève</th>
                                    <th>Classe</th>
                                    <th>Date</th>
                                    <th>Statut</th>
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
                                            {{ $inscription->created_at
                                                ? $inscription->created_at->format('d/m/Y')
                                                : '—' }}
                                        </td>

                                        <td>
                                            <span class="badge bg-warning-subtle
                                                         text-warning-emphasis">
                                                À vérifier
                                            </span>
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

    </div>
</div>
@endsection
