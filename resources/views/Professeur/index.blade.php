@extends('admin.layout.app')

@section('title', 'Gestion des professeurs')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Gestion des professeurs</h1>
            <p class="text-secondary mb-0">Consultez et gérez les professeurs de l'établissement.</p>
        </div>
        <a href="{{ route('director.professeurs.create') }}" class="btn btn-primary rounded-3 px-4">
            <i class="bi bi-plus-circle me-2"></i>Ajouter un professeur
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
                <div class="prof-icon"><i class="bi bi-people-fill"></i></div>
                <div><div class="text-secondary small mb-1">Professeurs enregistrés</div><div class="h3 fw-bold mb-0">{{ $professeurs->total() }}</div></div>
            </div></div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 px-4 pt-4">
            <h2 class="h5 fw-bold mb-1">Liste des professeurs</h2>
            <p class="text-secondary small mb-0">{{ $professeurs->count() }} résultat(s) sur cette page.</p>
        </div>
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Professeur</th>
                            <th>Contact</th>
                            <th>Affectations</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($professeurs as $professeur)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-prof">{{ mb_strtoupper(mb_substr($professeur->prenom, 0, 1).mb_substr($professeur->nom, 0, 1)) }}</div>
                                        <div>
                                            <div class="fw-semibold">{{ $professeur->nom }} {{ $professeur->prenom }}</div>
                                            <div class="text-secondary small">ID : PROF-{{ str_pad($professeur->id, 3, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($professeur->email)<div><i class="bi bi-envelope text-secondary me-2"></i>{{ $professeur->email }}</div>@endif
                                    @if($professeur->telephone)<div class="text-secondary small mt-1"><i class="bi bi-telephone me-2"></i>{{ $professeur->telephone }}</div>@endif
                                    @if(!$professeur->email && !$professeur->telephone)<span class="text-secondary">Aucun contact renseigné</span>@endif
                                </td>
                                <td><span class="badge rounded-pill bg-primary bg-opacity-10 text-primary">{{ $professeur->affectations->count() }}</span></td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('director.professeurs.show', $professeur->id) }}" class="btn btn-sm btn-light border" title="Détails" aria-label="Détails"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('director.professeurs.edit', $professeur->id) }}" class="btn btn-sm btn-light border" title="Modifier" aria-label="Modifier"><i class="bi bi-pencil-square"></i></a>
                                       <form action="{{ route('director.professeurs.destroy', $professeur->id) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirmDelete(
          event,
          @js(trim(($professeur->nom ?? '') . ' ' . ($professeur->prenom ?? '')))
      )">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-sm btn-outline-danger"
            title="Supprimer"
            aria-label="Supprimer ce professeur">
        <i class="bi bi-trash"></i>
    </button>
</form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-5">
                                <i class="bi bi-person-x display-5 text-secondary"></i>
                                <p class="fw-semibold mt-3 mb-1">Aucun professeur enregistré</p>
                                <p class="text-secondary small mb-3">Ajoutez votre premier professeur pour commencer.</p>
                                <a href="{{ route('director.professeurs.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Ajouter un professeur</a>
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($professeurs->hasPages())
            <div class="card-footer bg-white border-0 px-4 py-3">{{ $professeurs->links() }}</div>
        @endif
    </div>
</div>

<style>
    .prof-icon,.avatar-prof{display:flex;align-items:center;justify-content:center;flex-shrink:0;background:#eaf1ff;color:#2457c5}
    .prof-icon{width:54px;height:54px;border-radius:15px;font-size:24px}
    .avatar-prof{width:42px;height:42px;border-radius:13px;font-size:13px;font-weight:700}
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
    Supprimer ce professeur ?
</h5>

<p class="text-secondary mb-2">
    Voulez-vous vraiment supprimer ce professeur ?
</p>

<p class="fw-semibold mb-3" id="deleteItemName"></p>

<div class="alert alert-warning border-0 rounded-3 small text-start">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    Vérifiez que ce professeur n'est plus associé à des affectations ou à des données scolaires.
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
