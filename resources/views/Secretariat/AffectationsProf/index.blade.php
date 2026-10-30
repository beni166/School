@extends('secretariat.layout.app')

@section('title', 'Affectations des professeurs')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Affectations des professeurs</h1>
            <p class="text-secondary mb-0">Gérez les professeurs responsables de chaque matière, classe et année scolaire.</p>
        </div>
        <a href="{{ route('secretariat.affectations.create') }}" class="btn btn-primary rounded-3 px-4">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle affectation
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 px-4 pt-4">
            <h2 class="h5 fw-bold mb-1">Liste des affectations</h2>
            <p class="text-secondary small mb-0">{{ $affectations->total() }} affectation(s) enregistrée(s).</p>
        </div>
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Professeur</th>
                            <th>Matière</th>
                            <th>Classe</th>
                            <th>Année scolaire</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($affectations as $affectation)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold">{{ trim(($affectation->professeur?->nom ?? '') . ' ' . ($affectation->professeur?->prenom ?? '')) ?: 'Professeur non défini' }}</div>
                                    @if($affectation->professeur?->email)
                                        <div class="text-secondary small">{{ $affectation->professeur->email }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $affectation->matiere?->nom ?? 'Matière non définie' }}</div>
                                    @if($affectation->matiere?->code)
                                        <div class="text-secondary small">{{ $affectation->matiere->code }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        {{ $affectation->classe?->code ?? $affectation->classe?->nom ?? 'Classe non définie' }}
                                    </span>
                                    @if($affectation->classe?->code && $affectation->classe?->nom)
                                        <div class="text-secondary small mt-1">{{ $affectation->classe->nom }}</div>
                                    @endif
                                </td>
                                <td>{{ $affectation->anneeScolaire?->libelle ?? 'Année non définie' }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('secretariat.affectations.show', $affectation->id) }}" class="btn btn-sm btn-outline-secondary" title="Voir" aria-label="Voir l'affectation">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('secretariat.affectations.edit', $affectation->id) }}" class="btn btn-sm btn-outline-primary" title="Modifier" aria-label="Modifier l'affectation">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                       <form action="{{ route('secretariat.affectations.destroy', $affectation->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirmDelete(event, '{{ addslashes(trim(($affectation->professeur?->nom ?? '') . ' ' . ($affectation->professeur?->prenom ?? ''))) }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Supprimer"
                                                    aria-label="Supprimer l'affectation">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-person-workspace display-5 text-secondary"></i>
                                    <p class="fw-semibold mt-3 mb-1">Aucune affectation enregistrée</p>
                                    <p class="text-secondary small mb-3">Commencez par associer un professeur à une matière et à une classe.</p>
                                    <a href="{{ route('secretariat.affectations.create') }}" class="btn btn-primary btn-sm rounded-3">
                                        <i class="bi bi-plus-circle me-1"></i>Créer une affectation
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($affectations->hasPages())
            <div class="card-footer bg-white border-0 px-4 py-3">{{ $affectations->links() }}</div>
        @endif
    </div>
</div>

<style>
    .rounded-4 { border-radius: 16px !important; }
    .table thead th { font-size: 12px; text-transform: uppercase; letter-spacing: .35px; color: #64748b; white-space: nowrap; }
    .table td { padding-top: 14px; padding-bottom: 14px; }
</style>

{{-- Popup de confirmation de suppression --}}
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
                    Confirmer la suppression
                </h5>

                <p class="text-secondary mb-2">
                    Voulez-vous vraiment supprimer cette affectation ?
                </p>

                <p class="fw-semibold mb-3" id="deleteItemName"></p>

                <div class="alert alert-warning border-0 rounded-3 small text-start">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Cette action est définitive. Vérifiez que cette affectation peut être supprimée.
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
        font-size: 30px;
    }

    #deleteConfirmModal .modal-content {
        overflow: hidden;
    }

    #deleteConfirmModal .btn {
        transition: all .2s ease;
    }

    #deleteConfirmModal .btn-danger:hover {
        background: #b91c1c;
        transform: translateY(-1px);
    }
</style>

<script>
    let deleteFormToSubmit = null;

    function confirmDelete(event, itemName) {
        event.preventDefault();

        deleteFormToSubmit = event.currentTarget;

        document.getElementById('deleteItemName').textContent =
            itemName || 'Affectation sélectionnée';

        const modalElement = document.getElementById('deleteConfirmModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

        modal.show();

        return false;
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (deleteFormToSubmit) {
            deleteFormToSubmit.submit();
        }
    });
</script>
@endsection
