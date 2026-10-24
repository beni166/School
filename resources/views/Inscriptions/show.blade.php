@extends('admin.layout.app')

@section('title', 'Détails de l’inscription')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('director.inscriptions.index') }}" class="text-decoration-none text-secondary small"><i class="bi bi-arrow-left me-1"></i>Retour aux inscriptions</a>
            <div class="d-flex align-items-center gap-3 mt-3">
                <div class="inscription-icon"><i class="bi bi-journal-check"></i></div>
                <div>
                    <h1 class="h3 fw-bold text-dark mb-1">Dossier d’inscription</h1>
                    <p class="text-secondary mb-0">Référence : <span class="fw-semibold">{{ $inscription->numero_inscription }}</span></p>
                </div>
            </div>
        </div>
        <a href="{{ route('director.inscriptions.edit', $inscription) }}" class="btn btn-primary rounded-3 px-4"><i class="bi bi-pencil-square me-2"></i>Modifier l’inscription</a>
    </div>

    @if(session('success'))<div class="alert alert-success border-0 shadow-sm rounded-3"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger border-0 shadow-sm rounded-3"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}</div>@endif

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><div class="text-secondary small mb-2">Année scolaire</div><h2 class="h5 fw-bold mb-0">{{ $inscription->anneeScolaire?->libelle ?? 'Non précisée' }}</h2></div></div></div>
        <div class="col-12 col-md-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><div class="text-secondary small mb-2">Classe</div><h2 class="h5 fw-bold mb-0">{{ $inscription->classe?->code ?? $inscription->classe?->nom ?? 'Non définie' }}</h2>@if($inscription->classe?->code && $inscription->classe?->nom)<div class="text-secondary small mt-1">{{ $inscription->classe->nom }}</div>@endif</div></div></div>
        <div class="col-12 col-md-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><div class="text-secondary small mb-2">Bulletins associés</div><h2 class="h4 fw-bold mb-0">{{ $inscription->bulletins->count() }}</h2></div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4"><h2 class="h5 fw-bold mb-0"><i class="bi bi-info-circle text-primary me-2"></i>Informations générales</h2></div>
                <div class="card-body px-4">
                    <div class="detail-row"><span class="text-secondary">Numéro d’inscription</span><span class="fw-semibold text-end">{{ $inscription->numero_inscription }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Date d’inscription</span><span class="fw-semibold">{{ $inscription->date_inscription ? \Illuminate\Support\Carbon::parse($inscription->date_inscription)->format('d/m/Y') : 'Non précisée' }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Créée le</span><span class="fw-semibold">{{ $inscription->created_at?->format('d/m/Y') ?? 'Non disponible' }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Dernière modification</span><span class="fw-semibold">{{ $inscription->updated_at?->format('d/m/Y') ?? 'Non disponible' }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Décision scolaire</span><span class="badge {{ $inscription->decisionScolaire ? 'bg-success-subtle text-success' : 'bg-light text-secondary border' }}">{{ $inscription->decisionScolaire ? 'Enregistrée' : 'Non renseignée' }}</span></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4"><h2 class="h5 fw-bold mb-0"><i class="bi bi-person-vcard text-primary me-2"></i>Élève inscrit</h2></div>
                <div class="card-body px-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="student-avatar">{{ strtoupper(substr($inscription->eleve?->prenom ?? '', 0, 1) . substr($inscription->eleve?->nom ?? '', 0, 1)) ?: 'ÉL' }}</div>
                        <div><h3 class="h5 fw-bold mb-1">{{ trim(($inscription->eleve?->nom ?? '') . ' ' . ($inscription->eleve?->prenom ?? '')) ?: 'Élève non associé' }}</h3><div class="text-secondary small">Matricule : {{ $inscription->eleve?->matricule ?? 'Non disponible' }}</div></div>
                    </div>
                    <div class="detail-row"><span class="text-secondary">Année scolaire</span><span class="fw-semibold text-end">{{ $inscription->anneeScolaire?->libelle ?? 'Non précisée' }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Classe</span><span class="fw-semibold text-end">{{ $inscription->classe?->nom ?? 'Non définie' }}</span></div>
                    @if($inscription->classe?->niveau)
                        <div class="detail-row"><span class="text-secondary">Niveau</span><span class="fw-semibold">{{ $inscription->classe->niveau->nom }}</span></div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 px-4 pt-4"><h2 class="h5 fw-bold mb-1"><i class="bi bi-file-earmark-text text-primary me-2"></i>Bulletins scolaires</h2><p class="text-secondary small mb-0">Bulletins associés à cette inscription.</p></div>
                <div class="card-body p-0 mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light"><tr><th class="ps-4">Bulletin</th><th>Statut</th><th>Date de création</th></tr></thead>
                            <tbody>
                                @forelse($inscription->bulletins as $bulletin)
                                    <tr>
                                        <td class="ps-4 fw-semibold">Bulletin #{{ $bulletin->id }}</td>
                                        <td>
                                            @if(isset($bulletin->statut))
                                                <span class="badge {{ $bulletin->statut === 'valide' ? 'bg-success-subtle text-success' : 'bg-light text-secondary border' }}">{{ ucfirst($bulletin->statut) }}</span>
                                            @else
                                                <span class="text-secondary">—</span>
                                            @endif
                                        </td>
                                        <td>{{ $bulletin->created_at?->format('d/m/Y') ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-secondary py-5"><i class="bi bi-file-earmark-x display-6"></i><p class="mt-2 mb-0">Aucun bulletin associé à cette inscription.</p></td></tr>
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
    .inscription-icon{width:60px;height:60px;display:flex;align-items:center;justify-content:center;border-radius:17px;background:#eaf1ff;color:#2457c5;font-size:26px;flex-shrink:0}
    .student-avatar{width:54px;height:54px;display:flex;align-items:center;justify-content:center;border-radius:16px;background:#eaf1ff;color:#2457c5;font-weight:700;flex-shrink:0}
    .detail-row{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:15px 0;border-bottom:1px solid #edf0f5}.detail-row:last-child{border-bottom:none}
    .table thead th{font-size:11px;text-transform:uppercase;letter-spacing:.45px;color:#64748b;white-space:nowrap;border-bottom:0}.rounded-4{border-radius:16px!important}
</style>
@endsection
