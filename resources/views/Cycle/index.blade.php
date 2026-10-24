
@extends('admin.layout.app')

@section('title', 'Gestion des cycles')

@section('content')
<style>
    .cycle-page { background:#f5f8fd; min-height:85vh; padding:32px 0; }
    .cycle-page .page-title { color:#172b4d; font-weight:750; }
    .cycle-page .muted { color:#7b879b; }
    .cycle-page .panel {
        background:#fff; border:1px solid #edf1f7; border-radius:16px;
        box-shadow:0 8px 28px rgba(27,53,87,.045); overflow:hidden;
    }
    .cycle-page .panel-head { padding:22px 24px; border-bottom:1px solid #edf1f7; }
    .cycle-page .btn-primary-custom {
        background:#1769e0; color:white; border:1px solid #1769e0;
        border-radius:10px; padding:10px 16px; font-weight:650;
        text-decoration:none; display:inline-block;
    }
    .cycle-page .btn-primary-custom:hover { background:#1055bc; color:white; }
    .cycle-page .stat {
        padding:20px; background:white; border:1px solid #edf1f7;
        border-radius:15px; height:100%;
    }
    .cycle-page .stat-number { font-size:27px; font-weight:750; color:#172b4d; }
    .cycle-page .stat-label { font-size:13px; color:#7b879b; }
    .cycle-page .cycle-icon {
        width:43px; height:43px; display:flex; align-items:center;
        justify-content:center; border-radius:12px; background:#eaf2ff;
        color:#1769e0; font-size:20px; flex-shrink:0;
    }
    .cycle-page .table { margin:0; }
    .cycle-page .table thead th {
        background:#f7f9fc; color:#6c7b91; font-size:11px;
        letter-spacing:.5px; text-transform:uppercase; padding:15px 20px;
        white-space:nowrap; border-bottom:1px solid #e9eef5;
    }
    .cycle-page .table tbody td { padding:17px 20px; vertical-align:middle; }
    .cycle-page .table tbody tr:hover { background:#f8faff; }
    .cycle-page .table tbody tr:last-child td { border-bottom:0; }
    .cycle-page .action {
        border-radius:8px; padding:7px 10px; font-size:12px;
        font-weight:650; white-space:nowrap;
    }
    .cycle-page .view { background:#e9f7fc; color:#087eaa; border:1px solid #d8f0f9; }
    .cycle-page .edit { background:#edf4ff; color:#1769e0; border:1px solid #dce9ff; }
    .cycle-page .delete { background:#fff0f0; color:#cf414b; border:1px solid #ffe0e0; }
    .cycle-page .count-badge {
        background:#edf4ff; color:#1769e0; border-radius:30px;
        padding:7px 11px; font-weight:650; font-size:12px;
    }
    @media(max-width:576px) {
        .cycle-page { padding:22px 0; }
        .cycle-page .panel-head { padding:18px; }
    }
</style>

<div class="cycle-page">
    <div class="container">

        <div class="d-flex flex-column flex-md-row justify-content-between
                    align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="page-title mb-2">Gestion des cycles</h2>
                <p class="muted mb-0">
                    Organisez les cycles scolaires de votre établissement.
                </p>
            </div>

            <a href="{{ route('director.cycle.create') }}" class="btn-primary-custom">
                + Nouveau cycle
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-3 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-lg-4">
                <div class="stat">
                    <div class="d-flex align-items-center gap-3">
                        <div class="cycle-icon">▦</div>
                        <div>
                            <div class="stat-number">{{ $cycles->total() }}</div>
                            <div class="stat-label">Cycles enregistrés</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="stat">
                    <div class="d-flex align-items-center gap-3">
                        <div class="cycle-icon" style="background:#e8f8f1;color:#12835c;">
                            ✓
                        </div>
                        <div>
                            <div class="stat-number">
                                {{ $cycles->sum(fn($cycle) => $cycle->niveaux->count()) }}
                            </div>
                            <div class="stat-label">Niveaux sur cette page</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-head d-flex flex-column flex-sm-row
                        justify-content-between align-items-sm-center gap-2">
                <div>
                    <h5 class="fw-bold mb-1" style="color:#172b4d;">
                        Liste des cycles
                    </h5>
                    <p class="muted small mb-0">
                        Consultez et gérez les cycles scolaires.
                    </p>
                </div>
                <span class="count-badge">
                    {{ $cycles->total() }} résultat(s)
                </span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Cycle</th>
                            <th>Niveaux associés</th>
                            <th>Nombre de niveaux</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cycles as $cycle)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="cycle-icon">▦</div>
                                        <div>
                                            <div class="fw-bold" style="color:#263b5b;">
                                                {{ $cycle->nom }}
                                            </div>
                                            <small class="muted">
                                                Référence #{{ $cycle->id }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    @forelse($cycle->niveaux->take(3) as $niveau)
                                        <span class="badge rounded-pill mb-1"
                                              style="background:#edf4ff;color:#1769e0;">
                                            {{ $niveau->nom }}
                                        </span>
                                    @empty
                                        <span class="text-muted small">
                                            Aucun niveau associé
                                        </span>
                                    @endforelse

                                    @if($cycle->niveaux->count() > 3)
                                        <span class="badge bg-light text-dark">
                                            +{{ $cycle->niveaux->count() - 3 }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span class="count-badge">
                                        {{ $cycle->niveaux->count() }} niveau(x)
                                    </span>
                                </td>

                                <td class="text-end">
                                    <div class="d-inline-flex gap-1 flex-wrap justify-content-end">
                                        <a href="{{ route('director.cycle.show', $cycle) }}"
                                           class="btn action view">Voir</a>

                                        <a href="{{ route('director.cycle.edit', $cycle) }}"
                                           class="btn action edit">Modifier</a>

                                       <form action="{{ route('director.cycle.destroy', $cycle) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirmDelete(event, @js($cycle->nom))">

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
                                <td colspan="4" class="text-center py-5">
                                    <div class="cycle-icon mx-auto mb-3"
                                         style="width:60px;height:60px;font-size:26px;">
                                        ▦
                                    </div>
                                    <h5 class="fw-bold" style="color:#263b5b;">
                                        Aucun cycle enregistré
                                    </h5>
                                    <p class="muted">
                                        Commencez par créer votre premier cycle.
                                    </p>
                                    <a href="{{ route('director.cycle.create') }}"
                                       class="btn-primary-custom">
                                        + Créer un cycle
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($cycles->hasPages())
                <div class="p-3 border-top">
                    {{ $cycles->links() }}
                </div>
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
                    Supprimer ce cycle ?
                </h5>

                <p class="text-secondary mb-2">
                    Voulez-vous vraiment supprimer ce cycle scolaire ?
                </p>

                <p class="fw-semibold mb-3" id="deleteItemName"></p>

                <div class="alert alert-warning border-0 rounded-3 small text-start">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Vérifiez que ce cycle ne contient aucun niveau utilisé par des classes ou des données scolaires.
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
            itemName || 'Cycle sélectionné';

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
