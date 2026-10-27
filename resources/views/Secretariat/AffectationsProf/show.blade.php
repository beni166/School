@extends('secretariat.layout.app')

@section('title', 'Détails de l’affectation')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('secretariat.affectations.index') }}" class="text-decoration-none text-secondary small">
                <i class="bi bi-arrow-left me-1"></i>Retour aux affectations
            </a>
            <div class="d-flex align-items-center gap-3 mt-3">
                <div class="affectation-icon"><i class="bi bi-person-workspace"></i></div>
                <div>
                    <h1 class="h3 fw-bold mb-1">Détails de l'affectation</h1>
                    <p class="text-secondary mb-0">Référence AFF-{{ str_pad($affectation->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>
        <a href="{{ route('secretariat.affectations.edit', $affectation->id) }}" class="btn btn-primary rounded-3 px-4">
            <i class="bi bi-pencil-square me-2"></i>Modifier
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <h2 class="h5 fw-bold mb-0"><i class="bi bi-info-circle text-primary me-2"></i>Informations pédagogiques</h2>
                </div>
                <div class="card-body px-4">
                    <div class="detail-row">
                        <span class="text-secondary">Professeur</span>
                        <span class="fw-semibold text-end">{{ trim(($affectation->professeur?->nom ?? '') . ' ' . ($affectation->professeur?->prenom ?? '')) ?: 'Non défini' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="text-secondary">Matière</span>
                        <span class="fw-semibold text-end">
                            @if($affectation->matiere?->code){{ $affectation->matiere->code }} — @endif{{ $affectation->matiere?->nom ?? 'Non définie' }}
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="text-secondary">Classe</span>
                        <span class="fw-semibold text-end">
                            {{ $affectation->classe?->code ?? $affectation->classe?->nom ?? 'Non définie' }}
                            @if($affectation->classe?->code && $affectation->classe?->nom)<span class="text-secondary fw-normal"> — {{ $affectation->classe->nom }}</span>@endif
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="text-secondary">Niveau</span>
                        <span class="fw-semibold">{{ $affectation->classe?->niveau?->nom ?? 'Non précisé' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="text-secondary">Année scolaire</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary fs-6">{{ $affectation->anneeScolaire?->libelle ?? 'Non définie' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="text-secondary">Date de création</span>
                        <span class="fw-semibold">{{ $affectation->created_at?->format('d/m/Y à H:i') ?? 'Non disponible' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="text-secondary">Dernière modification</span>
                        <span class="fw-semibold">{{ $affectation->updated_at?->format('d/m/Y à H:i') ?? 'Non disponible' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <h2 class="h5 fw-bold mb-0"><i class="bi bi-person-vcard text-primary me-2"></i>Coordonnées du professeur</h2>
                </div>
                <div class="card-body px-4">
                    <div class="text-center py-3">
                        <div class="prof-avatar mx-auto mb-3"><i class="bi bi-person-fill"></i></div>
                        <h3 class="h5 fw-bold mb-1">{{ trim(($affectation->professeur?->nom ?? '') . ' ' . ($affectation->professeur?->prenom ?? '')) ?: 'Professeur non défini' }}</h3>
                        <p class="text-secondary small mb-0">Professeur affecté</p>
                    </div>
                    <hr class="text-secondary opacity-25">
                    <div class="mb-3">
                        <div class="text-secondary small mb-1">E-mail</div>
                        <div class="fw-semibold text-break">{{ $affectation->professeur?->email ?? 'Non renseigné' }}</div>
                    </div>
                    <div>
                        <div class="text-secondary small mb-1">Téléphone</div>
                        <div class="fw-semibold">{{ $affectation->professeur?->telephone ?? 'Non renseigné' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex flex-wrap justify-content-end gap-2">
            <a href="{{ route('secretariat.affectations.index') }}" class="btn btn-danger border rounded-3 px-4">Retour à la liste</a>
            <a href="{{ route('secretariat.affectations.edit', $affectation->id) }}" class="btn btn-primary rounded-3 px-4"><i class="bi bi-pencil-square me-2"></i>Modifier cette affectation</a>
        </div>
    </div>
</div>

<style>
    .affectation-icon { width: 60px; height: 60px; border-radius: 17px; display: flex; align-items: center; justify-content: center; background: #eaf1ff; color: #2457c5; font-size: 26px; flex-shrink: 0; }
    .prof-avatar { width: 76px; height: 76px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #eaf1ff; color: #2457c5; font-size: 36px; }
    .detail-row { display: flex; justify-content: space-between; align-items: center; gap: 18px; padding: 16px 0; border-bottom: 1px solid #edf0f5; }
    .detail-row:last-child { border-bottom: none; }
    .rounded-4 { border-radius: 16px !important; }
</style>
@endsection
