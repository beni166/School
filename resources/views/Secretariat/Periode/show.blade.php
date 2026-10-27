@extends('secretariat.layout.app')

@section('title', 'Détails de la période')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('secretariat.periodes.index') }}" class="text-decoration-none text-secondary small"><i class="bi bi-arrow-left me-1"></i>Retour aux périodes</a>
            <div class="d-flex align-items-center gap-3 mt-3">
                <div class="periode-icon"><i class="bi bi-calendar2-week-fill"></i></div>
                <div>
                    <h1 class="h3 fw-bold mb-1">{{ $periode->libelle }}</h1>
                    <p class="text-secondary mb-0">{{ $periode->anneeScolaire?->libelle ?? 'Année scolaire non définie' }} · Période n° {{ $periode->numero }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('secretariat.periodes.edit', $periode) }}" class="btn btn-primary rounded-3 px-4 {{ $periode->cloturee ? 'disabled' : '' }}"><i class="bi bi-pencil-square me-2"></i>Modifier</a>
            <a href="{{ route('secretariat.periodes.index') }}" class="btn btn-light border rounded-3 px-3">Fermer</a>
        </div>
    </div>

    @if(session('success'))<div class="alert alert-success border-0 shadow-sm rounded-3">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger border-0 shadow-sm rounded-3">{{ session('error') }}</div>@endif

    @if($periode->cloturee)
        <div class="alert alert-secondary border-0 rounded-3"><i class="bi bi-lock-fill me-2"></i>Cette période est clôturée. Elle ne peut plus être modifiée.</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><div class="text-secondary small mb-2">Type de période</div><div class="fs-5 fw-bold">{{ ucfirst($periode->type) }}</div></div></div></div>
        <div class="col-12 col-md-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><div class="text-secondary small mb-2">Numéro</div><div class="fs-5 fw-bold">{{ $periode->numero }}</div></div></div></div>
        <div class="col-12 col-md-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><div class="text-secondary small mb-2">État</div>@if($periode->cloturee)<span class="badge rounded-pill text-bg-secondary px-3 py-2"><i class="bi bi-lock-fill me-1"></i>Clôturée</span>@else<span class="badge rounded-pill text-bg-success px-3 py-2"><i class="bi bi-unlock me-1"></i>Ouverte</span>@endif</div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4"><h2 class="h5 fw-bold mb-0"><i class="bi bi-info-circle text-primary me-2"></i>Informations générales</h2></div>
                <div class="card-body px-4">
                    <div class="detail-row"><span class="text-secondary">Libellé</span><span class="fw-semibold text-end">{{ $periode->libelle }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Année scolaire</span><span class="fw-semibold text-end">{{ $periode->anneeScolaire?->libelle ?? 'Non définie' }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Type</span><span class="fw-semibold">{{ ucfirst($periode->type) }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Numéro</span><span class="fw-semibold">{{ $periode->numero }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Date de début</span><span class="fw-semibold">{{ $periode->date_debut ? \Illuminate\Support\Carbon::parse($periode->date_debut)->format('d/m/Y') : 'Non renseignée' }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Date de fin</span><span class="fw-semibold">{{ $periode->date_fin ? \Illuminate\Support\Carbon::parse($periode->date_fin)->format('d/m/Y') : 'Non renseignée' }}</span></div>
                    <div class="detail-row"><span class="text-secondary">Créée le</span><span class="fw-semibold">{{ $periode->created_at?->format('d/m/Y') ?? 'Non disponible' }}</span></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4"><h2 class="h5 fw-bold mb-0"><i class="bi bi-shield-check text-primary me-2"></i>État et règles</h2></div>
                <div class="card-body px-4">
                    <div class="rule-item"><i class="bi bi-calendar-check text-primary"></i><div><div class="fw-semibold">Période définie</div><div class="small text-secondary">Du {{ $periode->date_debut ? \Illuminate\Support\Carbon::parse($periode->date_debut)->format('d/m/Y') : '—' }} au {{ $periode->date_fin ? \Illuminate\Support\Carbon::parse($periode->date_fin)->format('d/m/Y') : '—' }}.</div></div></div>
                    <div class="rule-item"><i class="bi bi-journal-check text-primary"></i><div><div class="fw-semibold">Organisation {{ $periode->type === 'trimestre' ? 'trimestrielle' : 'semestrielle' }}</div><div class="small text-secondary">{{ $periode->type === 'trimestre' ? 'Le numéro doit être compris entre 1 et 3.' : 'Le numéro doit être 1 ou 2.' }}</div></div></div>
                    <div class="rule-item"><i class="bi {{ $periode->cloturee ? 'bi-lock-fill text-secondary' : 'bi-unlock text-success' }}"></i><div><div class="fw-semibold">{{ $periode->cloturee ? 'Modification verrouillée' : 'Modification autorisée' }}</div><div class="small text-secondary">{{ $periode->cloturee ? 'Une période clôturée ne peut plus être modifiée.' : 'La période reste modifiable tant qu’elle n’est pas clôturée.' }}</div></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.periode-icon{width:60px;height:60px;border-radius:17px;display:flex;align-items:center;justify-content:center;background:#eaf1ff;color:#2457c5;font-size:26px;flex-shrink:0}.detail-row{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:16px 0;border-bottom:1px solid #edf0f5}.detail-row:last-child{border-bottom:none}.rule-item{display:flex;align-items:flex-start;gap:13px;padding:17px 0;border-bottom:1px solid #edf0f5}.rule-item:last-child{border-bottom:none}.rule-item>i{font-size:19px;margin-top:2px}.rounded-4{border-radius:16px!important}
</style>
@endsection
