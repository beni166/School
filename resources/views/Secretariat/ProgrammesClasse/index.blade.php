@extends('secretariat.layout.app')

@section('title', 'Programmes des classes')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <span class="text-primary fw-semibold small text-uppercase">Pédagogie</span>
            <h1 class="h3 fw-bold text-dark mb-1 mt-1">Programmes des classes</h1>
            <p class="text-secondary mb-0">Gérez les matières enseignées dans chaque classe, par année scolaire et leur coefficient.</p>
        </div>
        <a href="{{ route('secretariat.programmes-classes.create') }}" class="btn btn-primary rounded-3 px-4 py-2">
            <i class="bi bi-plus-circle me-2"></i>Ajouter un programme
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
                <div class="stat-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
                <div><div class="text-secondary small mb-1">Programmes affichés</div><div class="h3 fw-bold mb-0">{{ $programmes->total() }}</div></div>
            </div></div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="stat-icon stat-icon-green"><i class="bi bi-collection"></i></div>
                <div><div class="text-secondary small mb-1">Éléments sur cette page</div><div class="h3 fw-bold mb-0">{{ $programmes->count() }}</div></div>
            </div></div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="stat-icon stat-icon-orange"><i class="bi bi-calculator"></i></div>
                <div><div class="text-secondary small mb-1">Coefficient total (page)</div><div class="h3 fw-bold mb-0">{{ number_format((float) $programmes->sum('coefficient'), 2, ',', ' ') }}</div></div>
            </div></div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div><h2 class="h5 fw-bold mb-1">Liste des programmes</h2><p class="text-secondary small mb-0">{{ $programmes->total() }} programme(s) enregistré(s)</p></div>
                <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2"><i class="bi bi-shield-check me-1"></i>Gestion pédagogique</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr>
                    <th class="ps-4">Année scolaire</th><th>Classe</th><th>Matière</th><th>Coefficient</th><th class="text-end pe-4">Actions</th>
                </tr></thead>
                <tbody>
                @forelse($programmes as $programme)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-semibold">{{ $programme->anneeScolaire?->libelle ?? 'Année non définie' }}</div>
                            @if($programme->anneeScolaire?->date_debut && $programme->anneeScolaire?->date_fin)
                                <div class="small text-secondary">{{ \Illuminate\Support\Carbon::parse($programme->anneeScolaire->date_debut)->format('d/m/Y') }} – {{ \Illuminate\Support\Carbon::parse($programme->anneeScolaire->date_fin)->format('d/m/Y') }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="fw-semibold">{{ $programme->classe?->code ?? $programme->classe?->nom ?? 'Classe non définie' }}</span>
                            @if($programme->classe?->code && $programme->classe?->nom)
                                <div class="small text-secondary">{{ $programme->classe->nom }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $programme->matiere?->nom ?? 'Matière non définie' }}</div>
                            @if($programme->matiere?->code)<div class="small text-secondary">Code : {{ $programme->matiere->code }}</div>@endif
                        </td>
                        <td><span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2">× {{ number_format((float) $programme->coefficient, 2, ',', ' ') }}</span></td>
                        <td class="text-end pe-4">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('secretariat.programmes-classes.edit', $programme->id) }}" class="btn btn-sm btn-light border rounded-3" title="Modifier" aria-label="Modifier le programme">
                                    <i class="bi bi-pencil-square text-primary"></i>
                                </a>
                               <form action="{{ route('secretariat.programmes-classes.destroy', $programme->id) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirmDelete(event, @js($programme->libelle ??''))">
    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-sm btn-light border rounded-3"
            title="Supprimer"
            aria-label="Supprimer le programme">
        <i class="bi bi-trash text-danger"></i>
    </button>
</form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-5">
                        <div class="empty-icon mx-auto mb-3"><i class="bi bi-journal-x"></i></div>
                        <h3 class="h6 fw-bold">Aucun programme enregistré</h3>
                        <p class="text-secondary small mb-3">Ajoutez une matière au programme d'une classe pour une année scolaire.</p>
                        <a href="{{ route('secretariat.programmes-classes.create') }}" class="btn btn-primary rounded-3"><i class="bi bi-plus-circle me-2"></i>Créer un programme</a>
                    </td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($programmes->hasPages())
            <div class="card-footer bg-white border-0 px-4 py-3">{{ $programmes->links() }}</div>
        @endif
    </div>
</div>

<style>
    .stat-icon{width:50px;height:50px;display:flex;align-items:center;justify-content:center;border-radius:15px;background:#eaf1ff;color:#2457c5;font-size:22px;flex-shrink:0}
    .stat-icon-green{background:#e8f8ef;color:#16834a}.stat-icon-orange{background:#fff3e4;color:#b96b0c}
    .empty-icon{width:58px;height:58px;display:flex;align-items:center;justify-content:center;border-radius:18px;background:#f1f5f9;color:#64748b;font-size:26px}
    .rounded-4{border-radius:16px!important}.table thead th{font-size:12px;text-transform:uppercase;letter-spacing:.4px;color:#64748b;white-space:nowrap}
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
                    Supprimer le programme de classe ?
                </h5>

                <p class="text-secondary mb-2">
                    Voulez-vous vraiment supprimer le programme de classe ?
                </p>

                <p class="fw-semibold mb-3" id="deleteItemName"></p>

                <div class="alert alert-warning border-0 rounded-3 small text-start">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Vérifiez que le programme de classe ne possède pas de matière ou de données scolaires associées.
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
