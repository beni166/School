
@extends('admin.layout.app')

@section('title', 'Années scolaires')

@section('content')
<style>
    .years-page {
        min-height: 85vh;
        background: #f5f8fd;
        padding: 32px 0 45px;
    }

    .years-page .page-title {
        color: #172b4d;
        font-weight: 750;
        letter-spacing: -.5px;
    }

    .years-page .page-subtitle {
        color: #7b879b;
    }

    .years-page .btn-new {
        background: #1769e0;
        border: 1px solid #1769e0;
        color: #fff;
        padding: 11px 17px;
        border-radius: 10px;
        font-weight: 650;
        box-shadow: 0 5px 12px rgba(23, 105, 224, .15);
        transition: .2s;
    }

    .years-page .btn-new:hover {
        background: #1055bc;
        color: #fff;
        transform: translateY(-1px);
    }

    .years-page .stat-card {
        height: 100%;
        background: #fff;
        border: 1px solid #edf1f7;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(27, 53, 87, .035);
    }

    .years-page .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        border-radius: 12px;
        font-size: 22px;
        flex-shrink: 0;
    }

    .years-page .stat-number {
        color: #172b4d;
        font-size: 27px;
        font-weight: 750;
        line-height: 1.2;
    }

    .years-page .stat-label {
        color: #7b879b;
        font-size: 13px;
        margin-top: 5px;
    }

    .years-page .table-card {
        border: 1px solid #edf1f7;
        border-radius: 16px;
        background: #fff;
        overflow: hidden;
        box-shadow: 0 8px 28px rgba(27, 53, 87, .045);
    }

    .years-page .table-card-header {
        padding: 22px 24px;
        border-bottom: 1px solid #edf1f7;
    }

    .years-page .table {
        margin-bottom: 0;
        color: #34445e;
    }

    .years-page .table thead th {
        padding: 15px 20px;
        background: #f7f9fc;
        color: #6c7b91;
        font-size: 11px;
        font-weight: 750;
        letter-spacing: .65px;
        text-transform: uppercase;
        white-space: nowrap;
        border-bottom: 1px solid #e9eef5;
    }

    .years-page .table tbody td {
        padding: 17px 20px;
        border-bottom: 1px solid #eef2f7;
        vertical-align: middle;
    }

    .years-page .table tbody tr:last-child td {
        border-bottom: 0;
    }

    .years-page .table tbody tr {
        transition: background .15s;
    }

    .years-page .table tbody tr:hover {
        background: #f8faff;
    }

    .years-page .year-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 11px;
        background: #eaf2ff;
        color: #1769e0;
        font-size: 19px;
        flex-shrink: 0;
    }

    .years-page .year-name {
        color: #243957;
        font-weight: 700;
    }

    .years-page .year-id {
        color: #9aa5b5;
        font-size: 12px;
    }

    .years-page .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 650;
        white-space: nowrap;
    }

    .years-page .status-badge::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .years-page .status-active {
        color: #12835c;
        background: #e8f8f1;
    }

    .years-page .status-inactive {
        color: #718096;
        background: #eef1f5;
    }

    .years-page .action-buttons {
        display: inline-flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    .years-page .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 7px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 650;
        white-space: nowrap;
        transition: .18s;
    }

    .years-page .action-view {
        color: #087eaa;
        background: #e9f7fc;
        border: 1px solid #d8f0f9;
    }

    .years-page .action-view:hover {
        background: #d5f0fa;
        color: #06698d;
    }

    .years-page .action-edit {
        color: #1769e0;
        background: #edf4ff;
        border: 1px solid #dce9ff;
    }

    .years-page .action-edit:hover {
        background: #dceaff;
        color: #1055bc;
    }

    .years-page .action-delete {
        color: #cf414b;
        background: #fff0f0;
        border: 1px solid #ffe0e0;
    }

    .years-page .action-delete:hover {
        background: #ffe0e0;
        color: #a92732;
    }

    .years-page .empty-state {
        padding: 55px 20px !important;
        text-align: center;
    }

    .years-page .empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 65px;
        height: 65px;
        margin: 0 auto 16px;
        border-radius: 18px;
        background: #edf4ff;
        color: #1769e0;
        font-size: 28px;
    }

    .years-page .date-text {
        color: #61718a;
        white-space: nowrap;
        font-size: 13px;
    }

    @media (max-width: 767px) {
        .years-page {
            padding-top: 22px;
        }

        .years-page .header-actions {
            width: 100%;
        }

        .years-page .btn-new {
            width: 100%;
        }

        .years-page .table-card-header {
            padding: 18px;
        }

        .years-page .table thead th,
        .years-page .table tbody td {
            padding: 14px;
        }
    }
</style>

<div class="years-page">
    <div class="container">

        {{-- En-tête --}}
        <div class="d-flex flex-column flex-md-row
                    justify-content-between align-items-md-center
                    gap-3 mb-4">

            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span style="color:#1769e0;font-size:25px;"
                          aria-hidden="true">▦</span>
                    <h2 class="page-title mb-0">
                        Années scolaires
                    </h2>
                </div>

                <p class="page-subtitle mb-0">
                    Gérez les périodes scolaires de votre établissement.
                </p>
            </div>

            <div class="header-actions">
                <a href="{{ route('director.annees-scolaires.create') }}"
                   class="btn btn-new">
                    <span class="me-1" aria-hidden="true">＋</span>
                    Nouvelle année scolaire
                </a>
            </div>
        </div>

        {{-- Messages --}}
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 shadow-sm
                        d-flex align-items-center gap-2 mb-4">
                <span aria-hidden="true">✓</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-3 shadow-sm
                        d-flex align-items-center gap-2 mb-4">
                <span aria-hidden="true">!</span>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        {{-- Statistiques --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon"
                             style="background:#eaf2ff;color:#1769e0;">
                            ▦
                        </div>
                        <div>
                            <div class="stat-number">
                                {{ $annees->count() }}
                            </div>
                            <div class="stat-label">
                                Année(s) enregistrée(s)
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon"
                             style="background:#e8f8f1;color:#12835c;">
                            ✓
                        </div>
                        <div>
                            <div class="stat-number">
                                {{ $annees->where('active', true)->count() }}
                            </div>
                            <div class="stat-label">
                                Année(s) active(s)
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon"
                             style="background:#eef1f5;color:#718096;">
                            ◷
                        </div>
                        <div>
                            <div class="stat-number">
                                {{ $annees->where('active', false)->count() }}
                            </div>
                            <div class="stat-label">
                                Année(s) inactive(s)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="table-card">
            <div class="table-card-header
                        d-flex flex-column flex-sm-row
                        justify-content-between align-items-sm-center gap-2">

                <div>
                    <h5 class="fw-bold mb-1" style="color:#172b4d;">
                        Liste des années scolaires
                    </h5>
                    <p class="text-muted small mb-0">
                        Consultez et gérez les années de votre établissement.
                    </p>
                </div>

                <span class="badge rounded-pill px-3 py-2"
                      style="background:#edf4ff;color:#1769e0;">
                    {{ $annees->count() }} résultat(s)
                </span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Année scolaire</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Statut</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($annees as $anneeScolaire)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="year-icon">
                                            ▦
                                        </div>
                                        <div>
                                            <div class="year-name">
                                                {{ $anneeScolaire->libelle }}
                                            </div>
                                            <div class="year-id">
                                                Référence #{{ $anneeScolaire->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="date-text">
                                        {{ \Carbon\Carbon::parse($anneeScolaire->date_debut)->format('d/m/Y') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="date-text">
                                        {{ \Carbon\Carbon::parse($anneeScolaire->date_fin)->format('d/m/Y') }}
                                    </span>
                                </td>

                                <td>
                                    @if($anneeScolaire->active)
                                        <span class="status-badge status-active">
                                            Active
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    <div class="action-buttons">

                                        <a href="{{ route('director.annees-scolaires.show', $anneeScolaire->id) }}"
                                           class="btn action-btn action-view"
                                           title="Consulter">
                                            Voir
                                        </a>

                                        <a href="{{ route('director.annees-scolaires.edit', ['annees_scolaire' => $anneeScolaire->id]) }}"
                                           class="btn action-btn action-edit"
                                           title="Modifier">
                                            Modifier
                                        </a>

                                      <form
    action="{{ route('director.annees-scolaires.destroy', $anneeScolaire->id) }}"
    method="POST"
    class="d-inline"
    onsubmit="return confirmDelete(event, @js($anneeScolaire->libelle))"
>
    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn action-btn action-delete"
            title="Supprimer">
        <i class="bi bi-trash me-1"></i>
        Supprimer
    </button>
</form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <div class="empty-icon">▦</div>

                                    <h5 class="fw-bold"
                                        style="color:#263b5b;">
                                        Aucune année scolaire
                                    </h5>

                                    <p class="text-muted mb-3">
                                        Vous n’avez pas encore enregistré
                                        d’année scolaire.
                                    </p>

                                    <a href="{{ route('director.annees-scolaires.create') }}"
                                       class="btn btn-new">
                                        + Créer une année scolaire
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination si le contrôleur utilise paginate() --}}
            @if(method_exists($annees, 'links'))
                <div class="p-3 border-top">
                    {{ $annees->links() }}
                </div>
            @endif
        </div>

        <p class="text-muted small mt-3 mb-0">
            Les statuts affichés correspondent à la valeur du champ
            <code>active</code> de chaque année scolaire.
        </p>

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
                    Confirmer la suppression
                </h5>

                <p class="text-secondary mb-2">
                    Voulez-vous vraiment supprimer cette année scolaire ?
                </p>

                <p class="fw-semibold mb-3" id="deleteItemName"></p>

                <div class="alert alert-warning border-0 rounded-3 small text-start">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Cette action peut être irréversible.
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
</style>

<script>
    let deleteFormToSubmit = null;

    function confirmDelete(event, itemName) {
        event.preventDefault();

        deleteFormToSubmit = event.currentTarget;

        document.getElementById('deleteItemName').textContent =
            itemName || 'Année scolaire sélectionnée';

        bootstrap.Modal
            .getOrCreateInstance(document.getElementById('deleteConfirmModal'))
            .show();

        return false;
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (deleteFormToSubmit) {
            deleteFormToSubmit.submit();
        }
    });
</script>
@endsection
