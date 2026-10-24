
@extends('admin.layout.app')

@section('title', 'Gestion des matières')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="text-primary fw-semibold small mb-2">
                ADMINISTRATION SCOLAIRE / PÉDAGOGIE
            </div>
            <h1 class="h3 fw-bold mb-1">Gestion des matières</h1>
            <p class="text-secondary mb-0">
                Organisez les disciplines enseignées dans votre établissement.
            </p>
        </div>

        <a href="{{ route('director.matieres.create') }}"
           class="btn btn-primary px-4 py-2 rounded-3">
            <span class="me-2">+</span> Nouvelle matière
        </a>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Fermer"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Fermer"></button>
        </div>
    @endif

    {{-- Statistiques --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-primary bg-opacity-10 text-primary
                                d-flex align-items-center justify-content-center"
                         style="width:54px;height:54px;font-size:24px;">
                        <i class="bi bi-journal-bookmark"></i>
                    </div>
                    <div>
                        <div class="text-secondary small">Total des matières</div>
                        <div class="h3 fw-bold mb-0">
                            {{ $matieres->total() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h2 class="h5 fw-bold mb-1">Toutes les matières</h2>
                    <p class="text-secondary small mb-0">
                        Consultez et gérez les disciplines enregistrées.
                    </p>
                </div>

                <div class="input-group" style="max-width:300px;">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="search" id="rechercheMatiere"
                           class="form-control bg-light border-start-0"
                           placeholder="Rechercher une matière...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small">MATIÈRE</th>
                        <th class="py-3 text-secondary small">IDENTIFIANT</th>
                        <th class="py-3 text-secondary small text-end pe-4">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="tableauMatieres">
                    @forelse($matieres as $matiere)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 bg-primary bg-opacity-10
                                                text-primary d-flex align-items-center
                                                justify-content-center fw-bold"
                                         style="width:42px;height:42px;">
                                        {{ strtoupper(substr($matiere->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark nom-matiere">
                                            {{ $matiere->nom }}
                                        </div>
                                        <div class="text-secondary small">
                                            Discipline scolaire
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge text-bg-light border">
                                    MAT-{{ str_pad($matiere->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('director.matieres.show', $matiere->id) }}"
                                       class="btn btn-sm btn-light border rounded-3"
                                       title="Consulter">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('director.matieres.edit', $matiere->id) }}"
                                       class="btn btn-sm btn-light border rounded-3"
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                   <form action="{{ route('director.matieres.destroy', $matiere->id) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirmDelete(event, @js($matiere->nom))">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-sm btn-light border border-danger-subtle
                   text-danger rounded-3"
            title="Supprimer"
            aria-label="Supprimer cette matière">
        <i class="bi bi-trash"></i>
    </button>
</form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="text-secondary mb-3">
                                    <i class="bi bi-journal-x" style="font-size:40px;"></i>
                                </div>
                                <h3 class="h6 fw-bold">Aucune matière enregistrée</h3>
                                <p class="text-secondary small">
                                    Commencez par ajouter votre première discipline.
                                </p>
                                <a href="{{ route('director.matieres.create') }}"
                                   class="btn btn-primary rounded-3">
                                    Ajouter une matière
                                </a>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="aucunResultat" style="display:none;">
                        <td colspan="3" class="text-center py-4 text-secondary">
                            Aucun résultat pour cette recherche.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-0 px-4 py-3">
            {{ $matieres->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const recherche = document.getElementById('rechercheMatiere');
    const lignes = document.querySelectorAll('#tableauMatieres tr');
    const aucunResultat = document.getElementById('aucunResultat');

    recherche.addEventListener('input', function () {
        const terme = this.value.toLocaleLowerCase('fr');
        let resultats = 0;

        lignes.forEach(function (ligne) {
            if (ligne.id === 'aucunResultat') return;

            const nom = ligne.querySelector('.nom-matiere');

            // Ne pas compter les lignes de message ou de pagination.
            if (!nom) return;

            const correspond = nom.textContent.toLocaleLowerCase('fr').includes(terme);
            ligne.style.display = correspond ? '' : 'none';

            if (correspond) resultats++;
        });

        aucunResultat.style.display = resultats === 0 ? '' : 'none';
    });
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
                    <i class="bi bi-trash3"></i>
                </div>

                <h5 class="fw-bold mb-2" id="deleteConfirmLabel">
                    Supprimer cette matière ?
                </h5>

                <p class="text-secondary mb-2">
                    Voulez-vous vraiment supprimer cette matière ?
                </p>

                <p class="fw-semibold mb-3" id="deleteItemName"></p>

                <div class="alert alert-warning border-0 rounded-3 small text-start">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Vérifiez que cette matière n'est pas utilisée dans des notes, des programmes de classe ou des affectations de professeurs.
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
