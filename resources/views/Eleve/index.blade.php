@extends('admin.layout.app')

@section('title', 'Gestion des élèves')

@section('content')

<div class="container-fluid py-4">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-user-graduate text-primary me-2"></i>
                Gestion des élèves
            </h2>
            <p class="text-muted mb-0">
                Consulte, recherche et gère les élèves de ton établissement.
            </p>
        </div>

        <a href="{{ route('director.eleves.create') }}"
           class="btn btn-primary rounded-3 px-4 py-2 shadow-sm">
            <i class="fas fa-plus me-2"></i>
            Nouvel élève
        </a>
    </div>

    {{-- Messages de notification --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm"
             role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Fermer"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm"
             role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Fermer"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm">
            <strong>Une erreur est survenue :</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Statistiques --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div>
                        <p class="text-muted mb-1">Nombre d'élèves</p>
                        <h3 class="fw-bold mb-0">
                            {{ $eleves->total() }}
                        </h3>
                        <small class="text-muted">Résultats correspondant aux filtres</small>
                    </div>
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div>
                        <p class="text-muted mb-1">Classes disponibles</p>
                        <h3 class="fw-bold mb-0">{{ $classes->count() }}</h3>
                        <small class="text-muted">Classes de l'établissement</small>
                    </div>
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="fas fa-school"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div>
                        <p class="text-muted mb-1">Page actuelle</p>
                        <h3 class="fw-bold mb-0">{{ $eleves->currentPage() }}</h3>
                        <small class="text-muted">
                            Sur {{ $eleves->lastPage() }} page(s)
                        </small>
                    </div>
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recherche et filtre --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-1">
                <i class="fas fa-search text-primary me-2"></i>
                Rechercher un élève
            </h5>
            <p class="text-muted small mb-0">
                Recherche par nom, prénom ou matricule et filtre par classe.
            </p>
        </div>

        <div class="card-body px-4 pb-4">
            <form action="{{ route('director.eleves.index') }}"
                  method="GET"
                  id="filtreElevesForm">

                <div class="row g-3 align-items-end">

                    {{-- Recherche --}}
                    <div class="col-12 col-lg-5">
                        <label for="recherche" class="form-label fw-semibold">
                            Nom, prénom ou matricule
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>

                            <input type="text"
                                   name="recherche"
                                   id="recherche"
                                   class="form-control border-start-0 ps-0"
                                   placeholder="Ex. : Kossi, Ama, ELV001..."
                                   value="{{ request('recherche') }}">
                        </div>
                    </div>

                    {{-- Filtre par classe --}}
                    <div class="col-12 col-lg-4">
                        <label for="classe_id" class="form-label fw-semibold">
                            Classe
                        </label>

                        <select name="classe_id"
                                id="classe_id"
                                class="form-select">
                            <option value="">Toutes les classes</option>

                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}"
                                    @selected((string) request('classe_id') === (string) $classe->id)>
                                    {{ $classe->code ?? $classe->libelle ?? $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Boutons --}}
                    <div class="col-12 col-lg-3">
                        <div class="d-flex gap-2">
                            <button type="submit"
                                    class="btn btn-primary flex-grow-1">
                                <i class="fas fa-filter me-1"></i>
                                Filtrer
                            </button>

                            <a href="{{ route('director.eleves.index') }}"
                               class="btn btn-outline-secondary"
                               title="Réinitialiser les filtres">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </form>

            {{-- Filtres actifs --}}
            @if(request()->filled('recherche') || request()->filled('classe_id'))
                <div class="mt-3 pt-3 border-top">
                    <span class="text-muted small me-2">Filtres actifs :</span>

                    @if(request()->filled('recherche'))
                        <span class="badge bg-primary-subtle text-primary me-1">
                            Recherche : {{ request('recherche') }}
                        </span>
                    @endif

                    @if(request()->filled('classe_id'))
                        @php
                            $classeSelectionnee = $classes->firstWhere(
                                'id',
                                request('classe_id')
                            );
                        @endphp

                        @if($classeSelectionnee)
                            <span class="badge bg-success-subtle text-success">
                                Classe :
                                {{ $classeSelectionnee->code
                                    ?? $classeSelectionnee->libelle
                                    ?? $classeSelectionnee->nom }}
                            </span>
                        @endif
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Liste des élèves --}}
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h5 class="fw-bold mb-1">Liste des élèves</h5>
                    <p class="text-muted small mb-0">
                        @if($eleves->total() > 0)
                            Affichage de {{ $eleves->firstItem() }}
                            à {{ $eleves->lastItem() }}
                            sur {{ $eleves->total() }} élève(s)
                        @else
                            Aucun élève trouvé
                        @endif
                    </p>
                </div>

                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                    <i class="fas fa-users me-1"></i>
                    {{ $eleves->total() }} élève(s)
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Élève</th>
                            <th>Matricule</th>
                            <th>Sexe</th>
                            <th>Date de naissance</th>
                            <th>Classe actuelle</th>
                            <th class="text-center pe-4">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($eleves as $eleve)
                            @php
                                $derniereInscription = $eleve->inscriptions
                                    ->sortByDesc('created_at')
                                    ->first();
                            @endphp

                            <tr>
                                {{-- Identité --}}
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-eleve">
                                            {{ strtoupper(substr($eleve->prenom ?? '', 0, 1)) }}{{ strtoupper(substr($eleve->nom ?? '', 0, 1)) }}
                                        </div>

                                        <div>
                                            <div class="fw-semibold text-dark">
                                                {{ $eleve->nom }} {{ $eleve->prenom }}
                                            </div>
                                            <small class="text-muted">
                                                Élève #{{ $eleve->id }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                {{-- Matricule --}}
                                <td>
                                    @if($eleve->matricule)
                                        <span class="badge bg-light text-dark border">
                                            {{ $eleve->matricule }}
                                        </span>
                                    @else
                                        <span class="text-muted">Non renseigné</span>
                                    @endif
                                </td>

                                {{-- Sexe --}}
                                <td>
                                    @if($eleve->sexe === 'M')
                                        <span class="badge bg-primary-subtle text-primary">
                                            <i class="fas fa-mars me-1"></i> Masculin
                                        </span>
                                    @elseif($eleve->sexe === 'F')
                                        <span class="badge bg-danger-subtle text-danger">
                                            <i class="fas fa-venus me-1"></i> Féminin
                                        </span>
                                    @else
                                        <span class="text-muted">Non renseigné</span>
                                    @endif
                                </td>

                                {{-- Date de naissance --}}
                                <td>
                                    @if($eleve->date_naissance)
                                        {{ \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">Non renseignée</span>
                                    @endif
                                </td>

                                {{-- Classe --}}
                                <td>
                                    @if($derniereInscription && $derniereInscription->classe)
                                        <span class="badge bg-success-subtle text-success">
                                            {{ $derniereInscription->classe->code
                                                ?? $derniereInscription->classe->libelle
                                                ?? $derniereInscription->classe->nom }}
                                        </span>

                                        @if($derniereInscription->anneeScolaire)
                                            <div class="small text-muted mt-1">
                                                {{ $derniereInscription->anneeScolaire->libelle }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            Non inscrit
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="text-center pe-4">
                                    <div class="d-inline-flex gap-1">

                                        <a href="{{ route('director.eleves.show', $eleve->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="Voir la fiche">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('director.eleves.edit', $eleve->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('director.eleves.destroy', $eleve->id) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirmDelete(
          event,
          @js(trim(($eleve->nom ?? '') . ' ' . ($eleve->prenom ?? '')))
      )">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-sm btn-outline-danger"
            title="Supprimer"
            aria-label="Supprimer cet élève">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>

                                        <h6 class="fw-bold">Aucun élève trouvé</h6>

                                        <p class="text-muted mb-3">
                                            Essaie de modifier les critères de recherche
                                            ou ajoute un nouvel élève.
                                        </p>

                                        @if(request()->filled('recherche') || request()->filled('classe_id'))
                                            <a href="{{ route('director.eleves.index') }}"
                                               class="btn btn-outline-primary btn-sm me-2">
                                                <i class="fas fa-redo me-1"></i>
                                                Réinitialiser
                                            </a>
                                        @endif

                                        <a href="{{ route('director.eleves.create') }}"
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i>
                                            Ajouter un élève
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($eleves->hasPages())
            <div class="card-footer bg-white border-0 px-4 py-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <small class="text-muted">
                        Page {{ $eleves->currentPage() }}
                        sur {{ $eleves->lastPage() }}
                    </small>

                    <div>
                        {{ $eleves->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        @endif

    </div>

</div>

@endsection

@push('styles')
<style>
    .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .avatar-eleve {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: #e8efff;
        color: #2458c6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .9rem;
        flex-shrink: 0;
    }

    .table thead th {
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .035em;
        color: #667085;
        white-space: nowrap;
        padding-top: 16px;
        padding-bottom: 16px;
    }

    .table tbody td {
        padding-top: 14px;
        padding-bottom: 14px;
    }

    .table tbody tr:last-child td {
        border-bottom: 0;
    }

    .empty-state {
        max-width: 400px;
        margin: 0 auto;
    }

    .card {
        overflow: hidden;
    }

    .pagination {
        margin-bottom: 0;
        flex-wrap: wrap;
        gap: 4px;
    }

    .pagination .page-link {
        border-radius: 8px;
        border: none;
        color: #344054;
        margin: 0 2px;
    }

    .pagination .active .page-link {
        background-color: #0d6efd;
        color: #fff;
    }

    @media (max-width: 768px) {
        .table thead th,
        .table tbody td {
            white-space: nowrap;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const classeSelect = document.getElementById('classe_id');
        const filtreForm = document.getElementById('filtreElevesForm');

        // Filtre automatiquement lorsque la classe change.
        if (classeSelect && filtreForm) {
            classeSelect.addEventListener('change', function () {
                filtreForm.submit();
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
                    <i class="fas fa-user-times"></i>
                </div>

                <h5 class="fw-bold mb-2" id="deleteConfirmLabel">
                    Supprimer cet élève ?
                </h5>

                <p class="text-secondary mb-2">
                    Voulez-vous vraiment supprimer cet élève ?
                </p>

                <p class="fw-semibold mb-3" id="deleteItemName"></p>

                <div class="alert alert-warning border-0 rounded-3 small text-start">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Cette action peut être irréversible. Vérifiez que cet élève ne possède pas d'inscriptions, de notes ou de bulletins à conserver.
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
                        <i class="fas fa-trash-alt me-2"></i>
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
            itemName || 'Élève sélectionné';

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

@endpush
