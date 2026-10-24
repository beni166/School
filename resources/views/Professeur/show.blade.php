@extends('admin.layout.app')

@section('title', 'Profil du professeur')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('director.professeurs.index') }}" class="text-decoration-none text-secondary small "><i class="bi bi-arrow-left me-1"></i>Retour aux professeurs</a>
            <div class="d-flex align-items-center gap-3 mt-3">
                <div class="profile-avatar"><i class="bi bi-person-fill"></i></div>
                <div>
                    <h1 class="h3 fw-bold mb-1">{{ $professeur->nom }} {{ $professeur->prenom }}</h1>
                    <p class="text-secondary mb-0">Identifiant : PROF-{{ str_pad($professeur->id, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>
        <a href="{{ route('director.professeurs.edit', $professeur->id) }}" class="btn btn-primary rounded-3 px-4"><i class="bi bi-pencil-square me-2"></i>Modifier le profil</a>
    </div>

    @if(session('success'))<div class="alert alert-success border-0 shadow-sm rounded-3">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger border-0 shadow-sm rounded-3">{{ session('error') }}</div>@endif

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><div class="text-secondary small mb-2">Identifiant</div><h4 class="fw-bold mb-0">#{{ $professeur->id }}</h4></div></div></div>
        <div class="col-12 col-md-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><div class="text-secondary small mb-2">Affectations</div><h4 class="fw-bold mb-0">{{ $professeur->affectations->count() }}</h4></div></div></div>
        <div class="col-12 col-md-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><div class="text-secondary small mb-2">Date d'enregistrement</div><h5 class="fw-bold mb-0">{{ $professeur->created_at?->format('d/m/Y') ?? 'Non disponible' }}</h5></div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4"><h2 class="h5 fw-bold mb-0"><i class="bi bi-person-vcard text-primary me-2"></i>Informations personnelles</h2></div>
                <div class="card-body px-4">
                    <div class="detail-row"><span class="text-secondary">Nom</span><span class="fw-semibold">{{ $professeur->nom }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Prénom(s)</span><span class="fw-semibold">{{ $professeur->prenom }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Adresse e-mail</span><span class="fw-semibold text-end">@if($professeur->email)<a href="mailto:{{ $professeur->email }}" class="text-decoration-none">{{ $professeur->email }}</a>@else<span class="text-secondary">Non renseignée</span>@endif</span></div>
                    <div class="detail-row"><span class="text-secondary">Téléphone</span><span class="fw-semibold">@if($professeur->telephone)<a href="tel:{{ $professeur->telephone }}" class="text-decoration-none">{{ $professeur->telephone }}</a>@else<span class="text-secondary">Non renseigné</span>@endif</span></div>
                    <div class="detail-row"><span class="text-secondary">Dernière modification</span><span class="fw-semibold">{{ $professeur->updated_at?->format('d/m/Y') ?? 'Non disponible' }}</span></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4"><h2 class="h5 fw-bold mb-1"><i class="bi bi-journal-bookmark text-primary me-2"></i>Affectations pédagogiques</h2><p class="text-secondary small mb-0">Classes, matières et années scolaires associées à ce professeur.</p></div>
                <div class="card-body p-0 mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light"><tr><th class="ps-4">Année scolaire</th><th>Classe</th><th>Matière</th></tr></thead>
                            <tbody>
                                @forelse($professeur->affectations as $affectation)
                                    <tr>
                                        <td class="ps-4">{{ $affectation->anneeScolaire?->libelle ?? 'Non précisée' }}</td>
                                        <td>{{ $affectation->classe?->code ?? $affectation->classe?->nom ?? 'Classe non définie' }}</td>
                                        <td>{{ $affectation->matiere?->nom ?? 'Matière non définie' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-secondary py-5"><i class="bi bi-journal-x display-6"></i><p class="mt-2 mb-0">Aucune affectation enregistrée pour ce professeur.</p></td></tr>
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
    .profile-avatar{width:60px;height:60px;border-radius:17px;display:flex;align-items:center;justify-content:center;background:#eaf1ff;color:#2457c5;font-size:28px;flex-shrink:0}
    .detail-row{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;padding:16px 0;border-bottom:1px solid #edf0f5}
    .detail-row:last-child{border-bottom:none}
    .table thead th{font-size:12px;text-transform:uppercase;letter-spacing:.4px;color:#64748b;white-space:nowrap}
    .rounded-4{border-radius:16px!important}
</style>
@endsection
