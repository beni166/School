@extends('secretariat.layout.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">Gestion des classes</h2>
            <p class="text-muted mb-0">Consultez et gérez les classes de votre établissement.</p>
        </div>

        <a href="{{ route('secretariat.classes.create') }}" class="btn btn-primary px-4 py-2">
            <i class="bi bi-plus-circle me-2"></i> Nouvelle classe
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="bi bi-building fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Nombre total de classes</div>
                        <h3 class="fw-bold mb-0">{{ $classes->total() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="bi bi-diagram-3 fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Niveaux associés sur cette page</div>
                        <h3 class="fw-bold mb-0">
                            {{ $classes->getCollection()->pluck('niveau_id')->unique()->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-layers fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Classes affichées</div>
                        <h3 class="fw-bold mb-0">{{ $classes->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 px-4 pt-4">
            <h5 class="fw-bold mb-1">Liste des classes</h5>
            <p class="text-muted small mb-0">Retrouvez les classes et leurs niveaux scolaires.</p>
        </div>

        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Classe</th>
                            <th>Niveau</th>
                            <th>Cycle</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $classe)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="class-avatar">
                                            <i class="bi bi-mortarboard"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $classe->nom }}</div>
                                            <small class="text-muted">ID : {{ $classe->id }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    @if($classe->niveau)
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                            {{ $classe->niveau->nom }}
                                        </span>
                                    @else
                                        <span class="text-muted">Non défini</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $classe->niveau?->cycle?->nom ?? 'Non défini' }}
                                </td>

                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('secretariat.classes.show', $classe) }}"
                                           class="btn btn-sm btn-light border"
                                           title="Consulter">
                                            <i class="bi bi-eye text-primary"></i>
                                        </a>

                                        <a href="{{ route('secretariat.classes.edit', $classe) }}"
                                           class="btn btn-sm btn-light border"
                                           title="Modifier">
                                            <i class="bi bi-pencil-square text-warning"></i>
                                        </a>

                                        <form action="{{ route('secretariat.classes.destroy', $classe) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirmDelete(event, @js($classe->nom))">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-sm btn-light border"
            title="Supprimer"
            aria-label="Supprimer la classe">
        <i class="bi bi-trash text-danger"></i>
    </button>
</form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="bi bi-building display-5 text-muted"></i>
                                    <h6 class="fw-bold mt-3">Aucune classe enregistrée</h6>
                                    <p class="text-muted mb-3">Commencez par ajouter une classe.</p>
                                    <a href="{{ route('secretariat.classes.create') }}" class="btn btn-primary">
                                        Ajouter une classe
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($classes->hasPages())
            <div class="card-footer bg-white border-0 px-4 py-3">
                {{ $classes->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .stat-icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .class-avatar {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #eaf1ff;
        color: #2457c5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .table thead th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #64748b;
        white-space: nowrap;
    }

    .table tbody tr:hover {
        background-color: #f8faff;
    }

    .rounded-4 {
        border-radius: 16px !important;
    }
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
                    Supprimer cette classe ?
                </h5>

                <p class="text-secondary mb-2">
                    Voulez-vous vraiment supprimer cette classe ?
                </p>

                <p class="fw-semibold mb-3" id="deleteItemName"></p>

                <div class="alert alert-warning border-0 rounded-3 small text-start">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Vérifiez qu'aucune inscription ou donnée scolaire ne dépend de cette classe.
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
            itemName || 'Classe sélectionnée';

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
