@extends('secretariat.layout.app')

@section('title', 'Gestion des notes')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <span class="text-primary fw-semibold small text-uppercase">Évaluations scolaires</span>
            <h1 class="h3 fw-bold text-dark mt-1 mb-1">Gestion des notes</h1>
            <p class="text-secondary mb-0">Consultez et gérez les notes des élèves par matière et par période.</p>
        </div>
        <a href="{{ route('secretariat.notes.create') }}" class="btn btn-primary rounded-3 px-4 py-2">
            <i class="bi bi-plus-circle me-2"></i>Enregistrer des notes
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-journal-check"></i></div>
                <div><div class="text-secondary small">Notes enregistrées</div><div class="fs-3 fw-bold">{{ $notes->total() }}</div></div>
            </div></div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="stat-icon bg-success-subtle text-success"><i class="bi bi-check2-square"></i></div>
                <div><div class="text-secondary small">Notes affichées</div><div class="fs-3 fw-bold">{{ $notes->count() }}</div></div>
            </div></div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-calendar3"></i></div>
                <div><div class="text-secondary small">Par page</div><div class="fs-3 fw-bold">20</div></div>
            </div></div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">
            <h2 class="h5 fw-bold mb-1">Registre des notes</h2>
            <p class="text-secondary small mb-0">Chaque ligne correspond aux notes d’un élève pour une matière et une période.</p>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Élève</th>
                            <th>Classe</th>
                            <th>Période</th>
                            <th>Matière</th>
                            <th class="text-center">Interro. 1</th>
                            <th class="text-center">Interro. 2</th>
                            <th class="text-center">Devoir</th>
                            <th class="text-center">Composition</th>
                            <th class="text-center">Moyenne simple</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notes as $note)
                            @php
                                $moyenneSimple = ((float) $note->interrogation_1 + (float) $note->interrogation_2 + (float) $note->devoir + (float) $note->composition) / 4;
                                $nomEleve = trim(($note->inscription?->eleve?->nom ?? '') . ' ' . ($note->inscription?->eleve?->prenom ?? ''));
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold">{{ $nomEleve !== '' ? $nomEleve : 'Élève non associé' }}</div>
                                    <div class="small text-secondary">{{ $note->inscription?->eleve?->matricule ?? 'Matricule non disponible' }}</div>
                                </td>
                                <td>{{ $note->inscription?->classe?->code ?? $note->inscription?->classe?->nom ?? '—' }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $note->periode?->libelle ?? 'Période non définie' }}</div>
                                    <div class="small text-secondary">{{ ucfirst($note->periode?->type ?? '') }}</div>
                                </td>
                                <td>{{ $note->matiere?->nom ?? 'Matière non définie' }}</td>
                                <td class="text-center">{{ number_format((float) $note->interrogation_1, 2) }}/20</td>
                                <td class="text-center">{{ number_format((float) $note->interrogation_2, 2) }}/20</td>
                                <td class="text-center">{{ number_format((float) $note->devoir, 2) }}/20</td>
                                <td class="text-center">{{ number_format((float) $note->composition, 2) }}/20</td>
                                <td class="text-center"><span class="badge rounded-pill {{ $moyenneSimple >= 10 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} px-3 py-2">{{ number_format($moyenneSimple, 2) }}/20</span></td>
                                <td class="text-end pe-4 text-nowrap">
                                    @if(!$note->periode?->cloturee)
                                        <a href="{{ route('secretariat.notes.edit', $note) }}" class="btn btn-sm btn-outline-primary rounded-3" title="Modifier"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('secretariat.notes.destroy', $note) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirmDelete(event, 'les notes de cette inscription')">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-sm btn-outline-danger rounded-3"
            title="Supprimer"
            aria-label="Supprimer les notes">
        <i class="bi bi-trash"></i>
    </button>
</form>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary"><i class="bi bi-lock-fill me-1"></i>Période clôturée</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-center py-5">
                                <i class="bi bi-journal-x display-5 text-secondary"></i>
                                <p class="fw-semibold mt-3 mb-1">Aucune note enregistrée</p>
                                <p class="text-secondary small mb-3">Commencez par saisir les notes d’un élève.</p>
                                <a href="{{ route('secretariat.notes.create') }}" class="btn btn-primary rounded-3"><i class="bi bi-plus-circle me-2"></i>Ajouter des notes</a>
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($notes->hasPages())
            <div class="card-footer bg-white border-0 px-4 py-3">{{ $notes->links() }}</div>
        @endif
    </div>
</div>

<style>
    .stat-icon{width:52px;height:52px;border-radius:15px;display:flex;align-items:center;justify-content:center;font-size:23px;flex-shrink:0}
    .table thead th{font-size:11px;text-transform:uppercase;letter-spacing:.35px;color:#64748b;white-space:nowrap}
    .table td{font-size:13px;white-space:nowrap}
    .rounded-4{border-radius:16px!important}
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
    Supprimer ces notes ?
</h5>

<p class="text-secondary mb-2">
    Voulez-vous vraiment supprimer ces notes ?
</p>

<p class="fw-semibold mb-3" id="deleteItemName"></p>

<div class="alert alert-warning border-0 rounded-3 small text-start">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    La suppression des notes peut modifier les moyennes et les bulletins de l'élève.
    Vérifiez que ces notes peuvent être supprimées.
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
            itemName || 'Matière sélectionnée';

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
