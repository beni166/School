
@extends('admin.layout.app')

@section('title', 'Consulter une présence')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="{{ route('director.presences.index') }}"
               class="text-decoration-none text-secondary small">
                <i class="bi bi-arrow-left me-1"></i>Retour à la liste
            </a>

            <h2 class="fw-bold mt-3 mb-1">Détail de la présence</h2>
            <p class="text-secondary mb-0">
                Enregistrement du {{ $presence->date_presence?->format('d/m/Y') }}
            </p>
        </div>

        <a href="{{ route('director.presences.edit', $presence) }}"
           class="btn btn-primary rounded-3 px-3">
            <i class="bi bi-pencil me-1"></i>Modifier
        </a>
    </div>

    @php
        $eleve = $presence->inscription?->eleve;
        $classe = $presence->inscription?->classe;

        $statuts = [
            'present' => ['Présent', 'success', 'person-check'],
            'absent' => ['Absent', 'danger', 'person-x'],
            'retard' => ['En retard', 'warning', 'clock'],
            'absence_justifiee' => ['Absence justifiée', 'info', 'file-earmark-check'],
        ];

        $etat = $statuts[$presence->statut] ?? [
            ucfirst($presence->statut),
            'secondary',
            'question-circle'
        ];
    @endphp

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;flex-shrink:0;">
                            <i class="bi bi-person-fill fs-3"></i>
                        </div>

                        <div>
                            <div class="text-secondary small">Élève</div>
                            <h4 class="fw-bold mb-1">
                                {{ $eleve->prenom ?? '' }}
                                {{ $eleve->nom ?? 'Élève inconnu' }}
                            </h4>
                            <div class="text-secondary">
                                {{ $classe->nom ?? $classe->libelle ?? 'Classe non renseignée' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <hr class="text-secondary opacity-25">

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-secondary small mb-1">Date de l'appel</div>
                            <div class="fw-semibold">
                                <i class="bi bi-calendar3 text-primary me-2"></i>
                                {{ $presence->date_presence?->format('d/m/Y') ?? 'Non renseignée' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-secondary small mb-1">Statut</div>
                            <span class="badge bg-{{ $etat[1] }}-subtle text-{{ $etat[1] }} rounded-pill px-3 py-2">
                                <i class="bi bi-{{ $etat[2] }} me-1"></i>{{ $etat[0] }}
                            </span>
                        </div>

                        <div class="col-md-6">
                            <div class="text-secondary small mb-1">Heure d'arrivée</div>
                            <div class="fw-semibold">
                                <i class="bi bi-clock text-primary me-2"></i>
                                {{ $presence->heure_arrivee
                                    ? \Illuminate\Support\Carbon::parse($presence->heure_arrivee)->format('H:i')
                                    : 'Non renseignée' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-secondary small mb-1">Année scolaire</div>
                            <div class="fw-semibold">
                                {{ $presence->inscription?->anneeScolaire?->libelle ?? 'Non renseignée' }}
                            </div>
                        </div>
                    </div>

                    <hr class="text-secondary opacity-25 my-4">

                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-chat-left-text me-2 text-primary"></i>
                        Motif ou justification
                    </h6>

                    @if($presence->motif)
                        <div class="p-3 rounded-3 bg-light">
                            {{ $presence->motif }}
                        </div>
                    @else
                        <p class="text-secondary mb-0">Aucun motif renseigné.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Traçabilité</h5>

                    <div class="mb-3">
                        <div class="text-secondary small">Enregistré par</div>
                        <div class="fw-semibold">
                            {{ $presence->utilisateur?->name ?? 'Utilisateur inconnu' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-secondary small">Créé le</div>
                        <div class="fw-semibold">
                            {{ $presence->created_at?->format('d/m/Y à H:i') ?? '—' }}
                        </div>
                    </div>

                    <div>
                        <div class="text-secondary small">Dernière modification</div>
                        <div class="fw-semibold">
                            {{ $presence->updated_at?->format('d/m/Y à H:i') ?? '—' }}
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('director.presences.index') }}"
               class="btn btn-light border rounded-3 w-100">
                <i class="bi bi-arrow-left me-1"></i>Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection
