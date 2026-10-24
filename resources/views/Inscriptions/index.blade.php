@extends('admin.layout.app')

@section('title', 'Gestion des inscriptions')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <span class="text-primary small fw-semibold text-uppercase">Scolarité</span>
            <h1 class="h3 fw-bold text-dark mt-1 mb-1">Gestion des inscriptions</h1>
            <p class="text-secondary mb-0">Consultez les inscriptions et suivez l’historique scolaire des élèves.</p>
        </div>
        <a href="{{ route('director.inscriptions.create') }}" class="btn btn-primary rounded-3 px-4 py-2">
            <i class="bi bi-plus-lg me-2"></i>Nouvelle inscription
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="stat-icon blue"><i class="bi bi-person-vcard"></i></div>
                <div><div class="text-secondary small">Inscriptions affichées</div><div class="h3 fw-bold mb-0">{{ $inscriptions->count() }}</div></div>
            </div></div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="stat-icon purple"><i class="bi bi-journal-check"></i></div>
                <div><div class="text-secondary small">Total des inscriptions</div><div class="h3 fw-bold mb-0">{{ $inscriptions->total() }}</div></div>
            </div></div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4 d-flex align-items-center gap-3">
                <div class="stat-icon amber"><i class="bi bi-calendar3"></i></div>
                <div><div class="text-secondary small">Page actuelle</div><div class="h3 fw-bold mb-0">{{ $inscriptions->currentPage() }} <span class="fs-6 text-secondary fw-normal">/ {{ max($inscriptions->lastPage(), 1) }}</span></div></div>
            </div></div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">
            <h2 class="h5 fw-bold mb-1">Registre des inscriptions</h2>
            <p class="text-secondary small mb-0">{{ $inscriptions->total() }} inscription(s) enregistrée(s).</p>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Élève</th>
                        <th>Numéro</th>
                        <th>Année scolaire</th>
                        <th>Classe</th>
                        <th>Date d’inscription</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inscriptions as $inscription)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-initials">
                                        {{ strtoupper(substr($inscription->eleve?->prenom ?? '', 0, 1) . substr($inscription->eleve?->nom ?? '', 0, 1)) ?: 'ÉL' }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">{{ trim(($inscription->eleve?->nom ?? '') . ' ' . ($inscription->eleve?->prenom ?? '')) ?: 'Élève non associé' }}</div>
                                        <div class="text-secondary small">{{ $inscription->eleve?->matricule ?? 'Matricule indisponible' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $inscription->numero_inscription }}</span></td>
                            <td>{{ $inscription->anneeScolaire?->libelle ?? 'Année non définie' }}</td>
                            <td>
                                <span class="fw-semibold">{{ $inscription->classe?->code ?? $inscription->classe?->nom ?? 'Classe non définie' }}</span>
                                @if($inscription->classe?->code && $inscription->classe?->nom)
                                    <div class="text-secondary small">{{ $inscription->classe->nom }}</div>
                                @endif
                            </td>
                            <td>{{ $inscription->date_inscription ? \Illuminate\Support\Carbon::parse($inscription->date_inscription)->format('d/m/Y') : '—' }}</td>
                            <td class="text-end pe-4">
                                <div class="d-inline-flex align-items-center gap-1">
                                    <a href="{{ route('director.inscriptions.show', $inscription) }}" class="btn btn-sm btn-light border" title="Consulter" aria-label="Consulter"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('director.inscriptions.edit', $inscription) }}" class="btn btn-sm btn-light border" title="Modifier" aria-label="Modifier"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('director.inscriptions.destroy', $inscription) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirmDelete(
          event,
          @js(trim(
              ($inscription->eleve?->nom ?? '') . ' ' .
              ($inscription->eleve?->prenom ?? '')
          ))
      )">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-sm btn-light border text-danger"
            title="Supprimer"
            aria-label="Supprimer cette inscription">
        <i class="bi bi-trash3"></i>
    </button>
</form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5">
                            <div class="empty-icon mx-auto mb-3"><i class="bi bi-journal-x"></i></div>
                            <h3 class="h6 fw-bold">Aucune inscription trouvée</h3>
                            <p class="text-secondary small mb-3">Commencez par enregistrer une nouvelle inscription.</p>
                            <a href="{{ route('director.inscriptions.create') }}" class="btn btn-primary btn-sm rounded-3"><i class="bi bi-plus-lg me-1"></i>Ajouter une inscription</a>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($inscriptions->hasPages())
            <div class="card-footer bg-white border-0 px-4 py-3">{{ $inscriptions->links() }}</div>
        @endif
    </div>
</div>

<style>
    .stat-icon{width:52px;height:52px;display:flex;align-items:center;justify-content:center;border-radius:15px;font-size:23px;flex-shrink:0}
    .stat-icon.blue{background:#eaf1ff;color:#2457c5}.stat-icon.purple{background:#f1eaff;color:#7047bd}.stat-icon.amber{background:#fff4dc;color:#a66a00}
    .avatar-initials{width:42px;height:42px;display:flex;align-items:center;justify-content:center;border-radius:13px;background:#eaf1ff;color:#2457c5;font-size:12px;font-weight:700;flex-shrink:0}
    .empty-icon{width:58px;height:58px;display:flex;align-items:center;justify-content:center;border-radius:18px;background:#f1f5f9;color:#64748b;font-size:26px}
    .table thead th{font-size:11px;text-transform:uppercase;letter-spacing:.45px;color:#64748b;white-space:nowrap;border-bottom:0;padding-top:14px;padding-bottom:14px}
    .table tbody td{padding-top:15px;padding-bottom:15px}.rounded-4{border-radius:16px!important}
</style>

<div class="modal fade" id="deleteConfirmModal"
     tabindex="-1"
     aria-labelledby="deleteConfirmLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-body text-center p-4 p-md-5">

                <div class="delete-icon mx-auto mb-3">
                    <i class="bi bi-person-x"></i>
                </div>

                <h5 class="fw-bold mb-2" id="deleteConfirmLabel">
                    Supprimer cette inscription ?
                </h5>

                <p class="text-secondary mb-2">
                    Voulez-vous vraiment supprimer l'inscription de cet élève ?
                </p>

                <p class="fw-semibold mb-3" id="deleteItemName"></p>

                <div class="alert alert-warning border-0 rounded-3 small text-start">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Une inscription liée à des notes, des bulletins ou à un historique scolaire doit être protégée.
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
                        <i class="bi bi-trash3 me-2"></i>
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
            itemName || 'Inscription sélectionnée';

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
