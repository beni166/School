
@extends('admin.layout.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4 bulletin-page">

    @php
        $eleve = $bulletin->inscription?->eleve;
        $classe = $bulletin->classe_libelle
            ?: ($bulletin->inscription?->classe?->libelle
            ?? $bulletin->inscription?->classe?->nom
            ?? '—');
        $annee = $bulletin->annee_libelle
            ?: ($bulletin->inscription?->anneeScolaire?->libelle ?? '—');
        $moyenne = $bulletin->moyenne_generale;
    @endphp

    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <a href="{{ route('director.bulletins.index') }}"
               class="text-decoration-none text-secondary small">
                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
            </a>

            <div class="text-primary small fw-semibold mt-3 mb-1">
                DOSSIER SCOLAIRE / BULLETIN #{{ $bulletin->id }}
            </div>

            <h2 class="fw-bold mb-1">Bulletin scolaire</h2>
            <p class="text-secondary mb-0">
                {{ $bulletin->periode?->libelle ?? 'Période non définie' }}
                · {{ $annee }}
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            @if($bulletin->statut === 'brouillon')
                <form action="{{ route('director.bulletins.generer', $bulletin) }}" method="POST"
                      onsubmit="return confirm('Calculer ou recalculer les résultats de ce bulletin ?')">
                    @csrf
                    <button type="submit" class="btn btn-primary rounded-3 px-3 py-2">
                        <i class="fas fa-calculator me-2"></i>Générer les résultats
                    </button>
                </form>

                @if($bulletin->details->isNotEmpty() && $moyenne !== null)
                    <form action="{{ route('director.bulletins.valider', $bulletin) }}" method="POST"
                          onsubmit="return confirm('Confirmer la validation définitive de ce bulletin ?')">
                        @csrf
                        <button type="submit" class="btn btn-success rounded-3 px-3 py-2">
                            <i class="fas fa-check me-2"></i>Valider
                        </button>
                    </form>
                @endif
            @else
                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 align-self-center">
                    <i class="fas fa-lock me-1"></i> Bulletin validé
                </span>
            @endif

            <button type="button" onclick="window.print()"
                    class="btn btn-light border rounded-3 px-3 py-2">
                <i class="fas fa-print me-2"></i>Imprimer
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info border-0 rounded-3">
            {{ session('info') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-3">
            <strong>Une erreur est survenue.</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="student-header p-4 p-lg-5 text-white">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="student-profile-icon">
                            {{ strtoupper(substr($bulletin->prenom_eleve ?: $eleve?->prenom ?: 'E', 0, 1)) }}
                        </div>
                        <div>
                            <div class="small opacity-75 mb-1">ÉLÈVE</div>
                            <h3 class="fw-bold mb-1">
                                {{ $bulletin->prenom_eleve ?: $eleve?->prenom }}
                                {{ $bulletin->nom_eleve ?: $eleve?->nom }}
                            </h3>
                            <div class="opacity-75">
                                {{ $classe }} · {{ $annee }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4 text-lg-end">
                    <div class="small opacity-75 mb-1">MOYENNE GÉNÉRALE</div>

                    @if($moyenne !== null)
                        <div class="display-5 fw-bold">
                            {{ number_format((float) $moyenne, 2, ',', ' ') }}
                            <span class="fs-5">/20</span>
                        </div>
                    @else
                        <div class="fs-4 fw-bold">Non calculée</div>
                    @endif

                    <div class="small opacity-75 mt-1">
                        {{ $bulletin->periode?->libelle ?? 'Période non définie' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="info-tile">
                        <div class="text-secondary small mb-1">Classe</div>
                        <div class="fw-bold">{{ $classe }}</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="info-tile">
                        <div class="text-secondary small mb-1">Année scolaire</div>
                        <div class="fw-bold">{{ $annee }}</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="info-tile">
                        <div class="text-secondary small mb-1">Matières évaluées</div>
                        <div class="fw-bold">{{ $bulletin->details->count() }}</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="info-tile">
                        <div class="text-secondary small mb-1">Statut</div>
                        @if($bulletin->statut === 'valide')
                            <span class="badge bg-success-subtle text-success rounded-pill">
                                Validé
                            </span>
                        @else
                            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">
                                Brouillon
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-body p-3 p-md-4 border-bottom">
            <h5 class="fw-bold mb-1">Détail des résultats</h5>
            <p class="text-secondary small mb-0">
                Notes, coefficients et moyennes par matière.
            </p>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 results-table">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">MATIÈRE</th>
                        <th class="py-3 text-center">INTERRO 1</th>
                        <th class="py-3 text-center">INTERRO 2</th>
                        <th class="py-3 text-center">DEVOIR</th>
                        <th class="py-3 text-center">COMPOSITION</th>
                        <th class="py-3 text-center">COEF.</th>
                        <th class="py-3 text-center">MOYENNE</th>
                        <th class="py-3 text-center">POINTS COEF.</th>
                        <th class="py-3">APPRÉCIATION</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bulletin->details as $detail)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-semibold">
                                    {{ $detail->matiere_libelle }}
                                </div>
                                @if($detail->professeur_libelle)
                                    <small class="text-secondary">
                                        {{ $detail->professeur_libelle }}
                                    </small>
                                @endif
                            </td>

                            <td class="text-center">{{ number_format((float) $detail->interrogation_1, 2, ',', ' ') }}</td>
                            <td class="text-center">{{ number_format((float) $detail->interrogation_2, 2, ',', ' ') }}</td>
                            <td class="text-center">{{ number_format((float) $detail->devoir, 2, ',', ' ') }}</td>
                            <td class="text-center">{{ number_format((float) $detail->composition, 2, ',', ' ') }}</td>
                            <td class="text-center">{{ number_format((float) $detail->coefficient, 2, ',', ' ') }}</td>

                            <td class="text-center fw-bold">
                                {{ $detail->moyenne_matiere !== null
                                    ? number_format((float) $detail->moyenne_matiere, 2, ',', ' ')
                                    : '—' }}
                            </td>

                            <td class="text-center fw-semibold text-primary">
                                {{ $detail->points_coefficientes !== null
                                    ? number_format((float) $detail->points_coefficientes, 2, ',', ' ')
                                    : '—' }}
                            </td>

                            <td>
                                <span class="text-secondary small">
                                    {{ $detail->appreciation ?? '—' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="fas fa-clipboard-list fa-2x text-secondary mb-3"></i>
                                <h6 class="fw-bold">Aucun résultat généré</h6>
                                <p class="text-secondary small mb-0">
                                    Vérifiez les notes enregistrées, puis cliquez sur « Générer les résultats ».
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                @if($bulletin->details->isNotEmpty())
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="7" class="px-4 py-3 text-end">
                                Moyenne générale pondérée
                            </th>
                            <th class="text-center text-primary fs-6">
                                {{ $moyenne !== null
                                    ? number_format((float) $moyenne, 2, ',', ' ')
                                    : '—' }}
                            </th>
                            <th>/20</th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-comment-dots text-primary me-2"></i>
                        Appréciation générale
                    </h5>

                    <p class="mb-0 text-secondary">
                        {{ $bulletin->appreciation_generale ?: 'Aucune appréciation disponible pour le moment.' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-history text-primary me-2"></i>
                        Informations de validation
                    </h5>

                    <div class="d-flex justify-content-between gap-3 mb-3">
                        <span class="text-secondary">Statut</span>
                        <span class="fw-semibold">
                            {{ $bulletin->statut === 'valide' ? 'Validé' : 'Brouillon' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between gap-3">
                        <span class="text-secondary">Date de validation</span>
                        <span class="fw-semibold text-end">
                            {{ $bulletin->valide_le?->format('d/m/Y à H:i') ?? 'Non validé' }}
                        </span>
                    </div>

                    @if($bulletin->statut === 'brouillon')
                        <div class="alert alert-warning border-0 rounded-3 small mt-4 mb-0">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Vérifiez toutes les notes avant de valider le bulletin.
                        </div>
                    @else
                        <div class="alert alert-success border-0 rounded-3 small mt-4 mb-0">
                            <i class="fas fa-lock me-1"></i>
                            Ce bulletin est validé. Les actions de génération et de suppression sont désactivées.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bulletin-page { color: #182230; }
.student-header {
    background: linear-gradient(120deg, #173f91 0%, #3478f6 100%);
}
.student-profile-icon {
    width: 68px; height: 68px; border-radius: 21px;
    display: flex; align-items: center; justify-content: center;
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.25);
    font-size: 27px; font-weight: 700; flex-shrink: 0;
}
.info-tile {
    background: #f8faff;
    border: 1px solid #edf1f7;
    border-radius: 14px;
    padding: 16px;
    height: 100%;
}
.results-table thead th {
    font-size: 11px;
    letter-spacing: .4px;
    color: #64748b;
    white-space: nowrap;
}
.results-table tbody tr:hover { background: #f8faff; }
@media print {
    body { background: #fff !important; }
    .sidebar, .navbar, nav, header, footer,
    .btn, form, .alert, a { display: none !important; }
    .container-fluid { padding: 0 !important; }
    .card { box-shadow: none !important; border: 1px solid #ddd !important; }
    .student-header {
        background: #fff !important;
        color: #111 !important;
        border-bottom: 1px solid #ddd;
    }
    .student-header .opacity-75 { opacity: 1 !important; }
    .results-table { font-size: 10px; }
}
</style>
@endsection
