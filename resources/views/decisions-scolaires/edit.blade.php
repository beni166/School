@extends('Admin.layout.app')

@section('title', 'Modifier une décision')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="{{ route('decisions-scolaires.index') }}" class="text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>

        <h3 class="fw-bold mt-3">Modifier la décision scolaire</h3>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('decisions-scolaires.update', $decision->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Inscription</label>

                        <select name="inscription_id" class="form-select" required>
                            @foreach($inscriptions as $inscription)
                                <option value="{{ $inscription->id }}"
                                    @selected(old('inscription_id', $decision->inscription_id) == $inscription->id)>
                                    {{ $inscription->eleve->nom }}
                                    {{ $inscription->eleve->prenom }}
                                    — {{ $inscription->classe->libelle ?? '' }}
                                </option>
                            @endforeach
                        </select>

                        @error('inscription_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Moyenne annuelle</label>

                        <input type="number"
                               name="moyenne_annuelle"
                               min="0"
                               max="20"
                               step="0.01"
                               value="{{ old('moyenne_annuelle', $decision->moyenne_annuelle) }}"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Décision</label>

                        <select name="decision" class="form-select" required>
                            @foreach(['admis', 'ajourne', 'redoublement', 'transfert'] as $choix)
                                <option value="{{ $choix }}"
                                    @selected(old('decision', $decision->decision) == $choix)>
                                    {{ ucfirst($choix) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Classe suivante</label>

                        <select name="classe_suivante_id" class="form-select">
                            <option value="">Aucune</option>

                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}"
                                    @selected(old('classe_suivante_id', $decision->classe_suivante_id) == $classe->id)>
                                    {{ $classe->libelle }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Observation</label>

                        <textarea name="observation"
                                  rows="4"
                                  class="form-control">{{ old('observation', $decision->observation) }}</textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('decisions-scolaires.index') }}" class="btn btn-light border">
                        Annuler
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Mettre à jour
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
