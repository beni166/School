
@extends('secretariat.layout.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4 bulletin-page">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="text-primary small fw-semibold mb-1">
                ESPACE SCOLAIRE / BULLETINS
            </div>
            <h2 class="fw-bold mb-1">Gestion des bulletins</h2>
            <p class="text-secondary mb-0">
                Consultez et gérez les résultats scolaires des élèves.
            </p>
        </div>

        <a href="{{ route('secretariat.bulletins.create') }}" class="btn btn-primary rounded-3 px-4 py-2">
            <i class="fas fa-plus me-2"></i>Créer un bulletin
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info border-0 rounded-3">
            {{ session('info') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="bulletin-icon bg-primary-subtle text-primary">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <div class="text-secondary small">Total des bulletins</div>
                        <h3 class="fw-bold mb-0">{{ $bulletins->total() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="bulletin-icon bg-success-subtle text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <div class="text-secondary small">Bulletins affichés</div>
                        <h3 class="fw-bold mb-0">{{ $bulletins->count() }}</h3>
                        <small class="text-secondary">Sur cette page</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="bulletin-icon bg-warning-subtle text-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="text-secondary small">À traiter</div>
                        <h3 class="fw-bold mb-0">
                            {{ $bulletins->getCollection()->where('statut', 'brouillon')->count() }}
                        </h3>
                        <small class="text-secondary">Sur cette page</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-3 p-md-4 border-bottom">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                <div>
                    <h5 class="fw-bold mb-1">Tous les bulletins</h5>
                    <p class="text-secondary small mb-0">
                        Historique des bulletins enregistrés dans l’établissement.
                    </p>
                </div>

                <div class="input-group bulletin-search">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-secondary"></i>
                    </span>
                    <input type="search" id="bulletinSearch"
                           class="form-control border-start-0"
                           placeholder="Rechercher un élève, une classe...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0" id="bulletinsTable">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">ÉLÈVE</th>
                        <th class="py-3">CLASSE</th>
                        <th class="py-3">ANNÉE SCOLAIRE</th>
                        <th class="py-3">PÉRIODE</th>
                        <th class="py-3">MOYENNE</th>
                        <th class="py-3">STATUT</th>
                        <th class="py-3 text-end pe-4">ACTIONS</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bulletins as $bulletin)
                        @php
                            $eleve = $bulletin->inscription?->eleve;
                            $classe = $bulletin->classe_libelle
                                ?: ($bulletin->inscription?->classe?->libelle
                                ?? $bulletin->inscription?->classe?->nom
                                ?? '—');
                            $annee = $bulletin->annee_libelle
                                ?: ($bulletin->inscription?->anneeScolaire?->libelle ?? '—');
                        @endphp

                        <tr class="bulletin-row">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="student-avatar">
                                        {{ strtoupper(substr($bulletin->prenom_eleve ?: $eleve?->prenom ?: 'E', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">
                                            {{ $bulletin->prenom_eleve ?: $eleve?->prenom }}
                                            {{ $bulletin->nom_eleve ?: $eleve?->nom }}
                                        </div>
                                        <small class="text-secondary">
                                            Bulletin #{{ $bulletin->id }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $classe }}</td>
                            <td>{{ $annee }}</td>
                            <td>
                                <span class="badge rounded-pill bg-light text-dark border">
                                    {{ $bulletin->periode?->libelle ?? '—' }}
                                </span>
                            </td>

                            <td>
                                @if($bulletin->moyenne_generale !== null)
                                    <span class="fw-bold">
                                        {{ number_format((float) $bulletin->moyenne_generale, 2, ',', ' ') }}/20
                                    </span>
                                @else
                                    <span class="text-secondary">Non calculée</span>
                                @endif
                            </td>

                            <td>
                                @if($bulletin->statut === 'valide')
                                    <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Validé
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis px-3 py-2">
                                        <i class="fas fa-clock me-1"></i> Brouillon
                                    </span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <a href="{{ route('secretariat.bulletins.show', $bulletin) }}"
                                   class="btn btn-sm btn-light border rounded-3"
                                   title="Consulter">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($bulletin->statut === 'brouillon')
                                    <form action="{{ route('secretariat.bulletins.destroy', $bulletin) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirmDelete(event, @js(
          'le bulletin de ' .
          ($bulletin->inscription?->eleve?->nom ?? '') . ' ' .
          ($bulletin->inscription?->eleve?->prenom ?? '')
      ))">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-sm btn-outline-danger rounded-3"
            title="Supprimer"
            aria-label="Supprimer le bulletin">
        <i class="fas fa-trash"></i>
    </button>
</form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-secondary mb-3">
                                    <i class="fas fa-folder-open fa-3x"></i>
                                </div>
                                <h6 class="fw-bold">Aucun bulletin pour le moment</h6>
                                <p class="text-secondary small">
                                    Créez un bulletin pour commencer.
                                </p>
                                <a href="{{ route('secretariat.bulletins.create') }}"
                                   class="btn btn-primary rounded-3">
                                    Créer un bulletin
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bulletins->hasPages())
            <div class="card-body border-top">
                {{ $bulletins->links() }}
            </div>
        @endif
    </div>
</div>

<style>
.bulletin-page { color: #182230; }
.bulletin-icon {
    width: 52px; height: 52px; border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 21px; flex-shrink: 0;
}
.student-avatar {
    width: 42px; height: 42px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    background: #eaf1ff; color: #2459c5; font-weight: 700;
}
.bulletin-search { max-width: 340px; }
.bulletin-search .form-control,
.bulletin-search .input-group-text { padding-top: 10px; padding-bottom: 10px; }
#bulletinsTable thead th { font-size: 11px; letter-spacing: .5px; color: #64748b; white-space: nowrap; }
#bulletinsTable tbody tr:hover { background: #f8faff; }
@media(max-width: 576px) {
    .bulletin-search { max-width: 100%; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('bulletinSearch');
    const rows = document.querySelectorAll('#bulletinsTable tbody .bulletin-row');

    if (search) {
        search.addEventListener('input', function () {
            const term = this.value.toLowerCase().trim();

            rows.forEach(function (row) {
                row.style.display = row.innerText.toLowerCase().includes(term)
                    ? ''
                    : 'none';
            });
        });
    }
});
</script>

<div class="modal fade" id="deleteConfirmModal"
     tabindex="-1"
     aria-labelledby="deleteConfirmLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-body text-center p-4 p-md-5">

                <div class="delete-icon mx-auto mb-3">
                    <i class="fas fa-trash-alt"></i>
                </div>

                <h5 class="fw-bold mb-2" id="deleteConfirmLabel">
                    Supprimer ce bulletin ?
                </h5>

                <p class="text-secondary mb-2">
                    Voulez-vous vraiment supprimer ce bulletin en brouillon ?
                </p>

                <p class="fw-semibold mb-3" id="deleteItemName"></p>

                <div class="alert alert-warning border-0 rounded-3 small text-start">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Cette action est définitive. Seuls les bulletins en brouillon devraient pouvoir être supprimés.
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
                        <i class="fas fa-trash me-2"></i>
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
            itemName || 'Bulletin sélectionné';

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
