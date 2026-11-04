@extends('Admin.layout.app')

@section('title', 'Détail de la décision')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Détail de la décision</h3>
            <p class="text-muted mb-0">Résultat annuel de l'élève</p>
        </div>

        <a href="{{ route('director.decisions-scolaires.index') }}" class="btn btn-light border">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">Informations de l'élève</h5>

            <div class="row g-4">

                <div class="col-md-6">
                    <small class="text-muted">Nom et prénom</small>
                    <h6 class="fw-semibold">
                        {{ $decision->inscription->eleve->nom ?? '' }}
                        {{ $decision->inscription->eleve->prenom ?? '' }}
                    </h6>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Classe actuelle</small>
                    <h6 class="fw-semibold">
                        {{ $decision->inscription->classe->libelle ?? '—' }}
                    </h6>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Moyenne annuelle</small>
                    <h4 class="fw-bold text-primary">
                        {{ number_format($decision->moyenne_annuelle, 2) }}/20
                    </h4>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Décision finale</small>
                    <h5 class="fw-bold">
                        {{ ucfirst($decision->decision) }}
                    </h5>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Classe suivante</small>
                    <h6 class="fw-semibold">
                        {{ $decision->classeSuivante->libelle ?? 'Aucune' }}
                    </h6>
                </div>

                <div class="col-md-12">
                    <small class="text-muted">Observation</small>
                    <p class="mb-0">
                        {{ $decision->observation ?: 'Aucune observation.' }}
                    </p>
                </div>

            </div>

            <hr>

            <div class="text-muted small">
                Décision enregistrée le :
                {{ $decision->created_at?->format('d/m/Y à H:i') }}
            </div>

        </div>
    </div>
</div>
@endsection
