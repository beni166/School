@extends('admin.layout.app')

@section('title', 'Dossier de l’élève')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('director.eleves.index') }}" class="text-decoration-none text-secondary small"><i class="bi bi-arrow-left me-1"></i>Retour aux élèves</a>
            <div class="d-flex align-items-center gap-3 mt-3">
                <div class="eleve-icon"><i class="bi bi-person-vcard-fill"></i></div>
                <div>
                    <h1 class="h3 fw-bold text-dark mb-1">{{ $eleve->nom }} {{ $eleve->prenom }}</h1>
                    <p class="text-secondary mb-0">Matricule : <span class="fw-semibold">{{ $eleve->matricule }}</span></p>
                </div>
            </div>
        </div>
        <a href="{{ route('director.eleves.edit', $eleve->id) }}" class="btn btn-primary rounded-3 px-4"><i class="bi bi-pencil-square me-2"></i>Modifier le dossier</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4">
                <div class="text-secondary small mb-2">Référence du dossier</div>
                <h4 class="fw-bold mb-0">ELV-{{ str_pad($eleve->id, 4, '0', STR_PAD_LEFT) }}</h4>
            </div></div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4">
                <div class="text-secondary small mb-2">Inscriptions historiques</div>
                <h4 class="fw-bold mb-0">{{ $eleve->inscriptions->count() }}</h4>
            </div></div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4">
                <div class="text-secondary small mb-2">Bulletins associés</div>
                <h4 class="fw-bold mb-0">{{ $eleve->inscriptions->sum(fn ($inscription) => $inscription->bulletins->count()) }}</h4>
            </div></div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4"><h2 class="h5 fw-bold mb-0"><i class="bi bi-info-circle text-primary me-2"></i>Informations personnelles</h2></div>
                <div class="card-body px-4">
                    <div class="detail-row"><span class="text-secondary">Nom complet</span><span class="fw-semibold text-end">{{ $eleve->nom }} {{ $eleve->prenom }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Matricule</span><span class="badge bg-light text-dark border">{{ $eleve->matricule }}</span></div>
                    <div class="detail-row">
                        <span class="text-secondary">Sexe</span>
                        <span class="fw-semibold">{{ $eleve->sexe === 'M' ? 'Masculin' : ($eleve->sexe === 'F' ? 'Féminin' : 'Non précisé') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="text-secondary">Date de naissance</span>
                        <span class="fw-semibold text-end">{{ $eleve->date_naissance ? \Illuminate\Support\Carbon::parse($eleve->date_naissance)->format('d/m/Y') : 'Non renseignée' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="text-secondary">Âge</span>
                        <span class="fw-semibold">{{ $eleve->date_naissance ? \Illuminate\Support\Carbon::parse($eleve->date_naissance)->age . ' ans' : 'Non calculable' }}</span>
                    </div>
                    <div class="detail-row"><span class="text-secondary">Dossier créé le</span><span class="fw-semibold">{{ $eleve->created_at?->format('d/m/Y') ?? 'Non disponible' }}</span></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <h2 class="h5 fw-bold mb-1"><i class="bi bi-mortarboard text-primary me-2"></i>Historique scolaire</h2>
                    <p class="text-secondary small mb-0">Inscriptions de l’élève, avec conservation des années et classes précédentes.</p>
                </div>
                <div class="card-body p-0 mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light"><tr><th class="ps-4">Année scolaire</th><th>Classe</th><th>Inscription</th><th>Bulletins</th></tr></thead>
                            <tbody>
                                @forelse($eleve->inscriptions->sortByDesc('created_at') as $inscription)
                                    <tr>
                                        <td class="ps-4 fw-semibold">{{ $inscription->anneeScolaire?->libelle ?? $inscription->annee_scolaire ?? 'Non précisée' }}</td>
                                        <td>{{ $inscription->classe?->code ?? $inscription->classe?->nom ?? 'Classe non définie' }}</td>
                                        <td>{{ $inscription->created_at?->format('d/m/Y') ?? 'Non disponible' }}</td>
                                        <td><span class="badge rounded-pill bg-primary bg-opacity-10 text-primary">{{ $inscription->bulletins->count() }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-secondary py-5"><i class="bi bi-journal-x display-6"></i><p class="mt-2 mb-0">Aucune inscription enregistrée pour cet élève.</p></td></tr>
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
    .eleve-icon{width:60px;height:60px;border-radius:17px;display:flex;align-items:center;justify-content:center;background:#eaf1ff;color:#2457c5;font-size:26px;flex-shrink:0}
    .detail-row{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:16px 0;border-bottom:1px solid #edf0f5}
    .detail-row:last-child{border-bottom:none}
    .table thead th{font-size:12px;text-transform:uppercase;letter-spacing:.4px;color:#64748b;white-space:nowrap}
    .rounded-4{border-radius:16px!important}
</style>
@endsection
