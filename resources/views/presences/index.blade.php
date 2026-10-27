
@extends('admin.layout.app')

@section('title', 'Gestion des présences')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <span class="text-primary small fw-semibold text-uppercase">
                Gestion scolaire
            </span>
            <h2 class="fw-bold mt-1 mb-1">Présences et absences</h2>
            <p class="text-secondary mb-0">
                Suivez les présences, les retards et les absences des élèves.
            </p>
        </div>

        <a href="{{ route('director.presences.create') }}"
           class="btn btn-primary rounded-3 px-3 py-2">
            <i class="bi bi-plus-lg me-2"></i>Enregistrer un appel
        </a>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistiques de la page --}}
    @php
        $elements = $presences->getCollection();
    @endphp

    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-secondary mb-1">Enregistrements affichés</div>
                            <h3 class="fw-bold mb-0">{{ $presences->total() }}</h3>
                        </div>
                        <div class="rounded-3 bg-primary-subtle text-primary p-3">
                            <i class="bi bi-journal-check fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-secondary mb-1">Présents sur la page</div>
                            <h3 class="fw-bold text-success mb-0">
                                {{ $elements->where('statut', 'present')->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 bg-success-subtle text-success p-3">
                            <i class="bi bi-person-check fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-secondary mb-1">Absents sur la page</div>
                            <h3 class="fw-bold text-danger mb-0">
                                {{ $elements->where('statut', 'absent')->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 bg-danger-subtle text-danger p-3">
                            <i class="bi bi-person-x fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-secondary mb-1">Retards sur la page</div>
                            <h3 class="fw-bold text-warning mb-0">
                                {{ $elements->where('statut', 'retard')->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 bg-warning-subtle text-warning p-3">
                            <i class="bi bi-clock-history fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3 p-lg-4">
            <form action="{{ route('director.presences.index') }}" method="GET">
                <div class="row g-3 align-items-end">

                    <div class="col-md-4">
                        <label for="date" class="form-label fw-semibold">Date de l'appel</label>
                        <input type="date"
                               id="date"
                               name="date"
                               class="form-control"
                               value="{{ request('date') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="statut" class="form-label fw-semibold">Statut</label>
                        <select name="statut" id="statut" class="form-select">
                            <option value="">Tous les statuts</option>
                            <option value="present" @selected(request('statut') === 'present')>Présent</option>
                            <option value="absent" @selected(request('statut') === 'absent')>Absent</option>
                            <option value="retard" @selected(request('statut') === 'retard')>En retard</option>
                            <option value="absence_justifiee" @selected(request('statut') === 'absence_justifiee')>Absence justifiée</option>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-3 flex-grow-1">
                            <i class="bi bi-funnel me-1"></i>Filtrer
                        </button>

                        <a href="{{ route('director.presences.index') }}"
                           class="btn btn-light border rounded-3"
                           title="Réinitialiser les filtres">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 p-4">
            <h5 class="fw-bold mb-1">Historique des appels</h5>
            <p class="text-secondary small mb-0">
                {{ $presences->total() }} enregistrement(s) au total.
            </p>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3">Élève</th>
                        <th>Classe</th>
                        <th>Date</th>
                        <th>Heure d'arrivée</th>
                        <th>Statut</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($presences as $presence)
                        @php
                            $eleve = $presence->inscription?->eleve;
                            $classe = $presence->inscription?->classe;

                            $statuts = [
                                'present' => ['Présent', 'success', 'person-check'],
                                'absent' => ['Absent', 'danger', 'person-x'],
                                'retard' => ['En retard', 'warning', 'clock'],
                                'absence_justifiee' => ['Absence justifiée', 'info', 'file-earmark-check'],
                            ];

                            $etat = $statuts[$presence->statut] ?? [
                                ucfirst($presence->statut),
                                'secondary',
                                'question-circle'
                            ];
                        @endphp

                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-light text-primary d-flex align-items-center justify-content-center"
                                         style="width:42px;height:42px;flex-shrink:0;">
                                        <i class="bi bi-person fs-5"></i>
                                    </div>

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $eleve->prenom ?? '' }} {{ $eleve->nom ?? 'Élève inconnu' }}
                                        </div>
                                        <div class="text-secondary small">
                                            Inscription #{{ $presence->inscription_id }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                {{ $classe->nom ?? $classe->libelle ?? '—' }}
                            </td>

                            <td>
                                {{ $presence->date_presence?->format('d/m/Y') ?? '—' }}
                            </td>

                            <td>
                                {{ $presence->heure_arrivee
                                    ? \Illuminate\Support\Carbon::parse($presence->heure_arrivee)->format('H:i')
                                    : '—' }}
                            </td>

                            <td>
                                <span class="badge rounded-pill bg-{{ $etat[1] }}-subtle text-{{ $etat[1] }} px-3 py-2">
                                    <i class="bi bi-{{ $etat[2] }} me-1"></i>
                                    {{ $etat[0] }}
                                </span>
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('director.presences.show', $presence) }}"
                                       class="btn btn-sm btn-outline-info rounded-3"
                                       title="Consulter">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('director.presences.edit', $presence) }}"
                                       class="btn btn-sm btn-outline-primary rounded-3"
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('director.presences.destroy', $presence) }}"
                                          method="POST"
                                          onsubmit="return confirm('Confirmer la suppression de cet enregistrement ?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger rounded-3"
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-calendar-x text-secondary" style="font-size:3rem;"></i>
                                <h6 class="fw-bold mt-3">Aucun enregistrement trouvé</h6>
                                <p class="text-secondary small mb-3">
                                    Modifiez les filtres ou enregistrez un nouvel appel.
                                </p>
                                <a href="{{ route('director.presences.create') }}"
                                   class="btn btn-primary rounded-3">
                                    <i class="bi bi-plus-lg me-1"></i>Nouvel appel
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($presences->hasPages())
            <div class="card-footer bg-white border-0 p-4">
                {{ $presences->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
