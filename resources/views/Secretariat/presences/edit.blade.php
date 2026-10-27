
@extends('secretariat.layout.app')

@section('title', 'Modifier une présence')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">

    <div class="mb-4">
        <a href="{{ route('secretariat.presences.index') }}"
           class="text-decoration-none text-secondary small">
            <i class="bi bi-arrow-left me-1"></i>Retour aux présences
        </a>

        <h2 class="fw-bold mt-3 mb-1">Modifier un enregistrement</h2>
        <p class="text-secondary mb-0">
            Corrigez les informations de présence de l'élève.
        </p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-3">
            <div class="fw-semibold mb-2">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Certaines informations sont invalides.
            </div>
            <ul class="mb-0 ps-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $eleve = $presence->inscription?->eleve;
        $classe = $presence->inscription?->classe;
    @endphp

    <div class="row g-4">
        <div class="col-lg-8">

            {{-- Rappel de l'élève --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                             style="width:54px;height:54px;flex-shrink:0;">
                            <i class="bi bi-person-fill fs-3"></i>
                        </div>

                        <div>
                            <div class="text-secondary small">Élève concerné</div>
                            <h5 class="fw-bold mb-1">
                                {{ $eleve->prenom ?? '' }}
                                {{ $eleve->nom ?? 'Élève inconnu' }}
                            </h5>
                            <div class="text-secondary small">
                                {{ $classe->nom ?? $classe->libelle ?? 'Classe non renseignée' }}
                                · {{ $presence->date_presence?->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Formulaire --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-1">Informations à corriger</h5>
                    <p class="text-secondary small mb-0">
                        L'élève et la date d'appel ne peuvent pas être modifiés ici.
                    </p>
                </div>

                <div class="card-body p-4 pt-0">
                    <form action="{{ route('secretariat.presences.update', $presence) }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="statut" class="form-label fw-semibold">
                                Statut <span class="text-danger">*</span>
                            </label>

                            <select name="statut"
                                    id="statut"
                                    class="form-select @error('statut') is-invalid @enderror"
                                    required>
                                <option value="present"
                                    @selected(old('statut', $presence->statut) === 'present')>
                                    Présent
                                </option>

                                <option value="absent"
                                    @selected(old('statut', $presence->statut) === 'absent')>
                                    Absent
                                </option>

                                <option value="retard"
                                    @selected(old('statut', $presence->statut) === 'retard')>
                                    En retard
                                </option>

                                <option value="absence_justifiee"
                                    @selected(old('statut', $presence->statut) === 'absence_justifiee')>
                                    Absence justifiée
                                </option>
                            </select>

                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4" id="heure-arrivee-container">
                            <label for="heure_arrivee" class="form-label fw-semibold">
                                Heure d'arrivée
                            </label>

                            <input type="time"
                                   name="heure_arrivee"
                                   id="heure_arrivee"
                                   class="form-control @error('heure_arrivee') is-invalid @enderror"
                                   value="{{ old(
                                       'heure_arrivee',
                                       $presence->heure_arrivee
                                           ? \Illuminate\Support\Carbon::parse($presence->heure_arrivee)->format('H:i')
                                           : ''
                                   ) }}">

                            @error('heure_arrivee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="motif" class="form-label fw-semibold">
                                Motif ou justification
                            </label>

                            <textarea name="motif"
                                      id="motif"
                                      rows="4"
                                      maxlength="2000"
                                      class="form-control @error('motif') is-invalid @enderror"
                                      placeholder="Précisez le motif éventuel...">{{ old('motif', $presence->motif) }}</textarea>

                            @error('motif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2">
                            <a href="{{ route('secretariat.presences.index') }}"
                               class="btn btn-light border rounded-3 px-4">
                                Annuler
                            </a>

                            <button type="submit" class="btn btn-primary rounded-3 px-4">
                                <i class="bi bi-check-lg me-1"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="rounded-3 bg-warning-subtle text-warning-emphasis d-inline-flex p-3 mb-3">
                        <i class="bi bi-pencil-square fs-4"></i>
                    </div>

                    <h5 class="fw-bold">Historique de l'enregistrement</h5>

                    <div class="mt-3">
                        <div class="text-secondary small">Créé le</div>
                        <div class="fw-semibold">
                            {{ $presence->created_at?->format('d/m/Y à H:i') ?? '—' }}
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="text-secondary small">Dernière modification</div>
                        <div class="fw-semibold">
                            {{ $presence->updated_at?->format('d/m/Y à H:i') ?? '—' }}
                        </div>
                    </div>

                    <hr>

                    <p class="text-secondary small mb-0">
                        Toute modification est enregistrée dans la base de données.
                        Pour conserver un historique complet des corrections, un journal
                        d'audit distinct sera nécessaire.
                    </p>
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
