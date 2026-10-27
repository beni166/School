
@extends('secretariat.layout.app')

@section('title', 'Enregistrer une présence')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">

    <div class="mb-4">
        <a href="{{ route('secretariat.presences.index') }}"
           class="text-decoration-none text-secondary small">
            <i class="bi bi-arrow-left me-1"></i>Retour aux présences
        </a>

        <h2 class="fw-bold mt-3 mb-1">Enregistrer une présence</h2>
        <p class="text-secondary mb-0">
            Enregistrez le statut d'un élève pour une journée scolaire.
        </p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-3">
            <div class="fw-semibold mb-2">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Vérifiez les informations saisies.
            </div>
            <ul class="mb-0 ps-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-1">Informations de l'appel</h5>
                    <p class="text-secondary small mb-0">
                        Les champs marqués d'un * sont obligatoires.
                    </p>
                </div>

                <div class="card-body p-4 pt-0">
                    <form action="{{ route('secretariat.presences.store') }}"
                          method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="inscription_id" class="form-label fw-semibold">
                                Élève inscrit <span class="text-danger">*</span>
                            </label>

                            <select name="inscription_id"
                                    id="inscription_id"
                                    class="form-select @error('inscription_id') is-invalid @enderror"
                                    required>
                                <option value="">Sélectionner un élève</option>

                                @foreach($inscriptions as $inscription)
                                    @php
                                        $eleve = $inscription->eleve;
                                        $classe = $inscription->classe;
                                    @endphp

                                    <option value="{{ $inscription->id }}"
                                        @selected((string) old('inscription_id') === (string) $inscription->id)>
                                        {{ $eleve->prenom ?? '' }}
                                        {{ $eleve->nom ?? 'Élève inconnu' }}
                                        — {{ $classe->nom ?? $classe->libelle ?? 'Classe non renseignée' }}
                                        — Inscription #{{ $inscription->id }}
                                    </option>
                                @endforeach
                            </select>

                            @error('inscription_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="date_presence" class="form-label fw-semibold">
                                    Date de l'appel <span class="text-danger">*</span>
                                </label>

                                <input type="date"
                                       name="date_presence"
                                       id="date_presence"
                                       class="form-control @error('date_presence') is-invalid @enderror"
                                       value="{{ old('date_presence', now()->format('Y-m-d')) }}"
                                       required>

                                @error('date_presence')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="statut" class="form-label fw-semibold">
                                    Statut <span class="text-danger">*</span>
                                </label>

                                <select name="statut"
                                        id="statut"
                                        class="form-select @error('statut') is-invalid @enderror"
                                        required>
                                    <option value="present" @selected(old('statut', 'present') === 'present')>
                                        Présent
                                    </option>
                                    <option value="absent" @selected(old('statut') === 'absent')>
                                        Absent
                                    </option>
                                    <option value="retard" @selected(old('statut') === 'retard')>
                                        En retard
                                    </option>
                                    <option value="absence_justifiee" @selected(old('statut') === 'absence_justifiee')>
                                        Absence justifiée
                                    </option>
                                </select>

                                @error('statut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6" id="heure-arrivee-container">
                                <label for="heure_arrivee" class="form-label fw-semibold">
                                    Heure d'arrivée
                                </label>

                                <input type="time"
                                       name="heure_arrivee"
                                       id="heure_arrivee"
                                       class="form-control @error('heure_arrivee') is-invalid @enderror"
                                       value="{{ old('heure_arrivee') }}">

                                @error('heure_arrivee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="motif" class="form-label fw-semibold">
                                    Motif ou justification
                                </label>

                                <textarea name="motif"
                                          id="motif"
                                          rows="4"
                                          maxlength="2000"
                                          class="form-control @error('motif') is-invalid @enderror"
                                          placeholder="Ex. : absence pour raison familiale, retard de transport...">{{ old('motif') }}</textarea>

                                @error('motif')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                            <a href="{{ route('secretariat.presences.index') }}"
                               class="btn btn-light border rounded-3 px-4">
                                Annuler
                            </a>

                            <button type="submit" class="btn btn-primary rounded-3 px-4">
                                <i class="bi bi-check-lg me-1"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="rounded-3 bg-primary-subtle text-primary d-inline-flex p-3 mb-3">
                        <i class="bi bi-info-circle fs-4"></i>
                    </div>
                    <h5 class="fw-bold">À savoir</h5>
                    <p class="text-secondary small mb-3">
                        Un seul enregistrement est autorisé par inscription et par date.
                    </p>
                    <p class="text-secondary small mb-0">
                        Si l'appel existe déjà, consultez la liste pour modifier son statut.
                    </p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Signification des statuts</h6>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge bg-success-subtle text-success">Présent</span>
                        <span class="text-secondary small">Élève présent en classe.</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge bg-danger-subtle text-danger">Absent</span>
                        <span class="text-secondary small">Élève absent.</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge bg-warning-subtle text-warning-emphasis">Retard</span>
                        <span class="text-secondary small">Arrivée après l'heure prévue.</span>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-info-subtle text-info">Justifiée</span>
                        <span class="text-secondary small">Absence accompagnée d'un motif.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const statut = document.getElementById('statut');
    const heureContainer = document.getElementById('heure-arrivee-container');

    function actualiserHeure() {
        heureContainer.classList.toggle(
            'd-none',
            statut.value !== 'retard'
        );
    }

    statut.addEventListener('change', actualiserHeure);
    actualiserHeure();
});
</script>
@endsection
