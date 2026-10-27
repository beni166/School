@extends('secretariat.layout.app')

@section('title', 'Gestion des périodes scolaires')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <span class="text-primary fw-semibold small text-uppercase">Organisation scolaire</span>
            <h1 class="h3 fw-bold mt-1 mb-1">Périodes scolaires</h1>
            <p class="text-secondary mb-0">Configurez les trimestres et semestres de chaque année scolaire.</p>
        </div>
        <a href="{{ route('secretariat.periodes.create') }}" class="btn btn-primary rounded-3 px-4 py-2">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle période
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="metric-icon metric-blue"><i class="bi bi-calendar3"></i></div>
                <div><div class="text-secondary small mb-1">Périodes affichées</div><div class="fs-3 fw-bold">{{ $periodes->total() }}</div></div>
            </div></div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="metric-icon metric-purple"><i class="bi bi-calendar-range"></i></div>
                <div><div class="text-secondary small mb-1">Trimestres sur cette page</div><div class="fs-3 fw-bold">{{ $periodes->getCollection()->where('type', 'trimestre')->count() }}</div></div>
            </div></div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="metric-icon metric-green"><i class="bi bi-calendar2-check"></i></div>
                <div><div class="text-secondary small mb-1">Semestres sur cette page</div><div class="fs-3 fw-bold">{{ $periodes->getCollection()->where('type', 'semestre')->count() }}</div></div>
            </div></div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 px-4 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div><h2 class="h5 fw-bold mb-1">Liste des périodes</h2><p class="small text-secondary mb-0">{{ $periodes->firstItem() ?? 0 }}–{{ $periodes->lastItem() ?? 0 }} sur {{ $periodes->total() }} période(s)</p></div>
            <span class="badge rounded-pill text-bg-light border"><i class="bi bi-arrow-down-up me-1"></i>Tri par numéro</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr>
                    <th class="ps-4">Période</th><th>Type</th><th>Année scolaire</th><th>Dates</th><th>État</th><th class="text-end pe-4">Actions</th>
                </tr></thead>
                <tbody>
                @forelse($periodes as $periode)
                    <tr>
                        <td class="ps-4"><div class="fw-semibold">{{ $periode->libelle }}</div><div class="small text-secondary">N° {{ $periode->numero }} · ID #{{ $periode->id }}</div></td>
                        <td>
                            @if($periode->type === 'trimestre')
                                <span class="badge rounded-pill badge-trimestre">Trimestre</span>
                            @else
                                <span class="badge rounded-pill badge-semestre">Semestre</span>
                            @endif
                        </td>
                        <td>{{ $periode->anneeScolaire?->libelle ?? 'Année non définie' }}</td>
                        <td><div class="small"><i class="bi bi-calendar-event text-secondary me-1"></i>{{ $periode->date_debut ? \Illuminate\Support\Carbon::parse($periode->date_debut)->format('d/m/Y') : '—' }}</div><div class="small text-secondary mt-1"><i class="bi bi-arrow-right me-1"></i>{{ $periode->date_fin ? \Illuminate\Support\Carbon::parse($periode->date_fin)->format('d/m/Y') : '—' }}</div></td>
                        <td>
                            @if($periode->cloturee)
                                <span class="badge rounded-pill text-bg-secondary"><i class="bi bi-lock-fill me-1"></i>Clôturée</span>
                            @else
                                <span class="badge rounded-pill text-bg-success"><i class="bi bi-unlock me-1"></i>Ouverte</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('secretariat.periodes.show', $periode) }}" class="btn btn-sm btn-light border rounded-3" title="Consulter"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('secretariat.periodes.edit', $periode) }}" class="btn btn-sm btn-light border rounded-3 {{ $periode->cloturee ? 'disabled' : '' }}" title="Modifier"><i class="bi bi-pencil-square"></i></a>
                                @unless($periode->cloturee)
                                    <form action="{{ route('secretariat.periodes.destroy', $periode) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirmDelete(event, @js($periode->libelle ?? $periode->type ?? 'Période scolaire'))">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-sm btn-light border text-danger rounded-3"
            title="Supprimer"
            aria-label="Supprimer cette période">
        <i class="bi bi-trash"></i>
    </button>
</form>
                                @endunless
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-5"><div class="empty-icon mx-auto mb-3"><i class="bi bi-calendar-x"></i></div><h3 class="h6 fw-bold">Aucune période enregistrée</h3><p class="text-secondary small mb-3">Créez une période pour organiser l'année scolaire.</p><a href="{{ route('director.periodes.create') }}" class="btn btn-primary btn-sm rounded-3 px-3">Créer une période</a></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($periodes->hasPages())<div class="card-footer bg-white border-0 px-4 py-3">{{ $periodes->links() }}</div>@endif
    </div>
</div>

<style>
.metric-icon{width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:21px;flex-shrink:0}.metric-blue{background:#eaf1ff;color:#2457c5}.metric-purple{background:#f1eaff;color:#7046c8}.metric-green{background:#e5f8ee;color:#16834a}.badge-trimestre{background:#eaf1ff;color:#2457c5}.badge-semestre{background:#f1eaff;color:#7046c8}.empty-icon{width:60px;height:60px;background:#f1f5f9;color:#64748b;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:27px}.table thead th{font-size:11px;text-transform:uppercase;letter-spacing:.45px;color:#64748b;white-space:nowrap}.rounded-4{border-radius:16px!important}
</style>

<div class="modal fade" id="deleteConfirmModal"
     tabindex="-1"
     aria-labelledby="deleteConfirmLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-body text-center p-4 p-md-5">

                <div class="delete-icon mx-auto mb-3">
                    <i class="bi bi-trash3"></i>
                </div>

               <h5 class="fw-bold mb-2" id="deleteConfirmLabel">
    Supprimer cette période ?
</h5>

<p class="text-secondary mb-2">
    Voulez-vous vraiment supprimer cette période scolaire ?
</p>

<p class="fw-semibold mb-3" id="deleteItemName"></p>

<div class="alert alert-warning border-0 rounded-3 small text-start">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    Vérifiez que cette période n'est pas utilisée par des notes ou des bulletins.
    La suppression pourrait affecter l'historique scolaire.
</div>

                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="button"
                            class="btn btn-light border rounded-3 px-4"
                            data-bs-dismiss="modal">
                        Annuler
                    </button>

                    <button type="button"
                            class="btn btn-danger rounded-3 px-4"
                            id="confirmDeleteBtn">
                        <i class="bi bi-trash me-2"></i>
                        Oui, supprimer
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .delete-icon {
        width: 75px;
        height: 75px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fee2e2;
        color: #dc2626;
        font-size: 28px;
    }

    #deleteConfirmModal .modal-content {
        overflow: hidden;
    }
</style>

<script>
    let deleteFormToSubmit = null;

    function confirmDelete(event, itemName) {
        event.preventDefault();

        deleteFormToSubmit = event.currentTarget;

        document.getElementById('deleteItemName').textContent =
            itemName || 'Niveau sélectionné';

        bootstrap.Modal
            .getOrCreateInstance(
                document.getElementById('deleteConfirmModal')
            )
            .show();

        return false;
    }

    document.getElementById('confirmDeleteBtn')
        .addEventListener('click', function () {
            if (deleteFormToSubmit) {
                deleteFormToSubmit.submit();
            }
        });
</script>


@endsection
