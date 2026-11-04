@extends('Admin.layout.app')

@section('title', 'Décisions scolaires')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Décisions scolaires</h3>
            <p class="text-muted mb-0">Gestion des résultats annuels des élèves</p>
        </div>

        <a href="{{ route('director.decisions-scolaires.create') }}"
           class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Nouvelle décision
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-semibold">Liste des décisions</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Élève</th>
                            <th>Classe actuelle</th>
                            <th>Moyenne annuelle</th>
                            <th>Décision</th>
                            <th>Classe suivante</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($decisions as $decision)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="fw-semibold">
                                    {{ $decision->inscription->eleve->nom ?? '' }}
                                    {{ $decision->inscription->eleve->prenom ?? '' }}
                                </td>

                                <td>
                                    {{ $decision->inscription->classe->libelle ?? '—' }}
                                </td>

                                <td>
                                    <span class="fw-bold">
                                        {{ number_format($decision->moyenne_annuelle, 2) }}/20
                                    </span>
                                </td>

                                <td>
                                    @php
                                        $badges = [
                                            'admis' => 'success',
                                            'ajourne' => 'danger',
                                            'redoublement' => 'warning',
                                            'transfert' => 'info',
                                        ];
                                    @endphp

                                    <span class="badge bg-{{ $badges[$decision->decision] ?? 'secondary' }}">
                                        {{ ucfirst($decision->decision) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $decision->classeSuivante->libelle ?? '—' }}
                                </td>

                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('director.decisions-scolaires.show', $decision->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('director.decisions-scolaires.edit', $decision->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('director.decisions-scolaires.destroy', $decision->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Supprimer cette décision ?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    Aucune décision scolaire enregistrée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $decisions->links() }}
        </div>
    </div>
</div>
@endsection
