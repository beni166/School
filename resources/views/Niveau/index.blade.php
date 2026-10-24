
@extends('admin.layout.app')

@section('title', 'Gestion des niveaux')

@section('content')
<style>
.niveau-page{background:#f5f8fd;min-height:85vh;padding:32px 0}
.niveau-page .heading{color:#172b4d;font-weight:750}
.niveau-page .muted{color:#7b879b}
.niveau-page .panel,.niveau-page .stat{background:#fff;border:1px solid #edf1f7;border-radius:16px;box-shadow:0 8px 28px rgba(27,53,87,.04)}
.niveau-page .panel{overflow:hidden}
.niveau-page .panel-head{padding:22px 24px;border-bottom:1px solid #edf1f7}
.niveau-page .stat{padding:20px;height:100%}
.niveau-page .stat-number{font-size:27px;font-weight:750;color:#172b4d}
.niveau-page .stat-label{font-size:13px;color:#7b879b}
.niveau-page .ico{width:43px;height:43px;display:flex;align-items:center;justify-content:center;border-radius:12px;background:#eaf2ff;color:#1769e0;font-size:20px;flex-shrink:0}
.niveau-page .btn-new{background:#1769e0;color:white;border:1px solid #1769e0;border-radius:10px;padding:11px 16px;font-weight:650;text-decoration:none;display:inline-block}
.niveau-page .btn-new:hover{background:#1055bc;color:white}
.niveau-page .table{margin:0}
.niveau-page .table thead th{background:#f7f9fc;color:#6c7b91;font-size:11px;letter-spacing:.5px;text-transform:uppercase;padding:15px 18px;white-space:nowrap}
.niveau-page .table tbody td{padding:16px 18px;vertical-align:middle}
.niveau-page .table tbody tr:hover{background:#f8faff}
.niveau-page .action{border-radius:8px;padding:7px 10px;font-size:12px;font-weight:650;white-space:nowrap}
.niveau-page .view{background:#e9f7fc;color:#087eaa;border:1px solid #d8f0f9}
.niveau-page .edit{background:#edf4ff;color:#1769e0;border:1px solid #dce9ff}
.niveau-page .delete{background:#fff0f0;color:#cf414b;border:1px solid #ffe0e0}
.niveau-page .pill{background:#edf4ff;color:#1769e0;border-radius:30px;padding:7px 11px;font-size:12px;font-weight:650}
@media(max-width:576px){.niveau-page{padding:22px 0}.niveau-page .panel-head{padding:18px}}
</style>

<div class="niveau-page">
<div class="container">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="heading mb-2">Gestion des niveaux</h2>
            <p class="muted mb-0">Organisez les niveaux scolaires de votre établissement.</p>
        </div>
        <a href="{{ route('director.niveau.create') }}" class="btn-new">＋ Nouveau niveau</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-3 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-4">
            <div class="stat">
                <div class="d-flex align-items-center gap-3">
                    <div class="ico">▦</div>
                    <div>
                        <div class="stat-number">{{ $niveaux->total() }}</div>
                        <div class="stat-label">Niveaux enregistrés</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="stat">
                <div class="d-flex align-items-center gap-3">
                    <div class="ico" style="background:#e8f8f1;color:#12835c">▤</div>
                    <div>
                        <div class="stat-number">{{ $niveaux->sum(fn($niveau) => $niveau->classes->count()) }}</div>
                        <div class="stat-label">Classes sur cette page</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
            <div>
                <h5 class="heading mb-1">Liste des niveaux</h5>
                <p class="muted small mb-0">Niveaux, cycles et classes associés.</p>
            </div>
            <span class="pill">{{ $niveaux->total() }} résultat(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Niveau</th>
                        <th>Cycle</th>
                        <th>Classes associées</th>
                        <th>Nombre de classes</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($niveaux as $niveau)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="ico">▦</div>
                                <div>
                                    <div class="fw-bold" style="color:#263b5b">{{ $niveau->nom }}</div>
                                    <small class="muted">Référence #{{ $niveau->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($niveau->cycle)
                                <span class="pill">{{ $niveau->cycle->nom }}</span>
                            @else
                                <span class="text-muted">Non défini</span>
                            @endif
                        </td>
                        <td>
                            @forelse($niveau->classes->take(3) as $classe)
                                <span class="badge bg-light text-dark border mb-1">
                                    {{ $classe->nom ?? $classe->name ?? 'Classe #'.$classe->id }}
                                </span>
                            @empty
                                <span class="muted small">Aucune classe</span>
                            @endforelse

                            @if($niveau->classes->count() > 3)
                                <span class="pill">+{{ $niveau->classes->count() - 3 }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="pill">{{ $niveau->classes->count() }} classe(s)</span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1 flex-wrap justify-content-end">
                                <a href="{{ route('director.niveau.show', $niveau) }}" class="btn action view">Voir</a>
                                <a href="{{ route('director.niveau.edit', $niveau) }}" class="btn action edit">Modifier</a>
                                <form action="{{ route('director.niveau.destroy', $niveau) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirmDelete(event, @js($niveau->nom))">

    @csrf
    @method('DELETE')

    <button type="submit" class="btn action delete">
        <i class="bi bi-trash me-1"></i>
        Supprimer
    </button>
</form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="ico mx-auto mb-3" style="width:60px;height:60px;font-size:26px">▦</div>
                            <h5 class="heading">Aucun niveau enregistré</h5>
                            <p class="muted">Commencez par créer votre premier niveau scolaire.</p>
                            <a href="{{ route('director.niveau.create') }}" class="btn-new">＋ Créer un niveau</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($niveaux->hasPages())
            <div class="p-3 border-top">{{ $niveaux->links() }}</div>
        @endif
    </div>
</div>
</div>

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
                    Supprimer ce niveau ?
                </h5>

                <p class="text-secondary mb-2">
                    Voulez-vous vraiment supprimer ce niveau scolaire ?
                </p>

                <p class="fw-semibold mb-3" id="deleteItemName"></p>

                <div class="alert alert-warning border-0 rounded-3 small text-start">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Vérifiez que ce niveau ne possède pas de classes ou de données scolaires associées.
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
