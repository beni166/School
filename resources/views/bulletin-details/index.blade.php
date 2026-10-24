{{-- resources/views/bulletin-details/index.blade.php --}}
@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-list-check text-primary me-2"></i>
                Détails du bulletin
            </h2>
            <p class="text-muted mb-0">
                Matières, notes et résultats enregistrés.
            </p>
        </div>

        <div class="d-flex gap-2">
                {{-- <a href="{{ route('bulletins.show', $bulletin->id) }}"
        class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Retour au bulletin
        </a> --}}

            @if($bulletin->statut !== 'valide')
                <a href="{{ route('director.bulletins-details.create', $bulletin) }}"
                   class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Ajouter une matière
                </a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-circle-check me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($bulletin->statut === 'valide')
        <div class="alert alert-warning">
            <i class="fas fa-lock me-2"></i>
            Ce bulletin est validé. Ses détails ne peuvent plus être modifiés.
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <small class="text-muted d-block">Élève</small>
                    <strong>
                        {{ $bulletin->prenom_eleve }} {{ $bulletin->nom_eleve }}
                    </strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">Classe</small>
                    <strong>{{ $bulletin->classe_libelle }}</strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">Année scolaire</small>
                    <strong>{{ $bulletin->annee_libelle }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Résultats par matière</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Matière</th>
                            <th>Professeur</th>
                            <th class="text-center">Interro 1</th>
                            <th class="text-center">Interro 2</th>
                            <th class="text-center">Devoir</th>
                            <th class="text-center">Composition</th>
                            <th class="text-center">Coef.</th>
                            <th class="text-center">Moyenne</th>
                            <th class="text-center">Points coef.</th>
                            <th class="text-center">Rang</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($details as $detail)
                            <tr>
                                <td class="fw-semibold">
                                    {{ $detail->matiere_libelle }}
                                </td>
                                <td>{{ $detail->professeur_libelle ?: '—' }}</td>
                                <td class="text-center">{{ $detail->interrogation_1 }}</td>
                                <td class="text-center">{{ $detail->interrogation_2 }}</td>
                                <td class="text-center">{{ $detail->devoir }}</td>
                                <td class="text-center">{{ $detail->composition }}</td>
                                <td class="text-center">{{ $detail->coefficient }}</td>

                                <td class="text-center">
                                    <span class="badge {{ $detail->moyenne_matiere >= 10 ? 'bg-success' : 'bg-danger' }}">
                                        {{ number_format($detail->moyenne_matiere, 2, ',', ' ') }}/20
                                    </span>
                                </td>

                                <td class="text-center fw-semibold">
                                    {{ number_format($detail->points_coefficientes, 2, ',', ' ') }}
                                </td>

                                <td class="text-center">
                                    {{ $detail->rang_matiere ?: '—' }}
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('director.bulletins-details.show', [$bulletin, $detail]) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="Consulter">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if($bulletin->statut !== 'valide')
                                            <a href="{{ route('director.bulletins-details.edit', [$bulletin, $detail]) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Modifier">
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            <form action="{{ route('director.bulletins-details.destroy', [$bulletin, $detail]) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Supprimer ce détail de matière ?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-2x text-muted mb-3"></i>
                                    <p class="text-muted mb-3">
                                        Aucune matière n'est encore enregistrée dans ce bulletin.
                                    </p>

                                    @if($bulletin->statut !== 'valide')
                                        <a href="{{ route('director.bulletins-details.create', $bulletin) }}"
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i> Ajouter la première matière
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($details->hasPages())
            <div class="card-footer bg-white">
                {{ $details->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
