@extends('Admin.layout.app')

@section('title', 'Nouvelle décision scolaire')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="{{ route('director.decisions-scolaires.index') }}"
           class="text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>

        <h3 class="fw-bold mt-3">Nouvelle décision scolaire</h3>
        <p class="text-muted">Enregistrer le résultat annuel d'un élève.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Informations de la décision</h5>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('director.decisions-scolaires.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Inscription de l'élève</label>

                        <select name="inscription_id" class="form-select @error('inscription_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un élève</option>

                            @foreach($inscriptions as $inscription)
                                <option value="{{ $inscription->id }}"
                                    @selected(old('inscription_id') == $inscription->id)>
                                    {{ $inscription->eleve->nom }}
                                    {{ $inscription->eleve->prenom }}
                                    — {{ $inscription->classe->libelle ?? '' }}
                                    — {{ $inscription->anneeScolaire->libelle ?? '' }}
                                </option>
                            @endforeach
                        </select>

                        @error('inscription_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Moyenne annuelle / 20</label>

                        <input type="number"
                               name="moyenne_annuelle"
                               class="form-control @error('moyenne_annuelle') is-invalid @enderror"
                               min="0"
                               max="20"
                               step="0.01"
                               value="{{ old('moyenne_annuelle') }}"
                               placeholder="Exemple : 14.50"
                               required>

                        @error('moyenne_annuelle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Décision finale</label>

                        <select name="decision" class="form-select @error('decision') is-invalid @enderror" required>
                            <option value="">Choisir une décision</option>
                            <option value="admis" @selected(old('decision') == 'admis')>Admis</option>
                            <option value="ajourne" @selected(old('decision') == 'ajourne')>Ajourné</option>
                            <option value="redoublement" @selected(old('decision') == 'redoublement')>Redoublement</option>
                            <option value="transfert" @selected(old('decision') == 'transfert')>Transfert</option>
                        </select>

                        @error('decision')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Classe suivante</label>

                        <select name="classe_suivante_id" class="form-select">
                            <option value="">Aucune classe suivante</option>

                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}"
                                    @selected(old('classe_suivante_id') == $classe->id)>
                                    {{ $classe->libelle }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Observation</label>

                        <textarea name="observation"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Ajouter une observation éventuelle...">{{ old('observation') }}</textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('director.decisions-scolaires.index') }}"
                       class="btn btn-light border">
                        Annuler
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
