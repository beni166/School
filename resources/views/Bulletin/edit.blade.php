
@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="text-muted small mb-2">
                Administration / Scolarité / Bulletins / Modification
            </div>
            <h2 class="fw-bold mb-1">Modifier le bulletin</h2>
            <p class="text-muted mb-0">
                Bulletin #{{ $bulletin->id }}
            </p>
        </div>

        <a href="{{ route('director.bulletins.show', $bulletin) }}"
           class="btn btn-light border rounded-3">
            <i class="fas fa-arrow-left me-2"></i>Retour au bulletin
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-3">
            <strong>Des erreurs ont été détectées :</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-1">Informations du bulletin</h5>
                    <p class="text-muted small mb-0">
                        Seuls les bulletins en brouillon peuvent être modifiés.
                    </p>
                </div>

                <div class="card-body p-4 pt-2">
                    <form action="{{ route('director.bulletins.update', $bulletin) }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="inscription_id" class="form-label fw-semibold">
                                Inscription de l'élève
                                <span class="text-danger">*</span>
                            </label>

                            <select name="inscription_id" id="inscription_id"
                                    class="form-select form-select-lg rounded-3 @error('inscription_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Choisir une inscription --</option>

                                @foreach($inscriptions as $inscription)
                                    <option value="{{ $inscription->id }}"
                                        @selected(old('inscription_id', $bulletin->inscription_id) == $inscription->id)>
                                        {{ $inscription->eleve->prenom ?? '' }}
                                        {{ $inscription->eleve->nom ?? '' }}
                                        — {{ $inscription->classe->libelle
                                            ?? $inscription->classe->nom
                                            ?? $inscription->classe->name
                                            ?? 'Classe non précisée' }}
                                        — {{ $inscription->anneeScolaire->libelle
                                            ?? 'Année non précisée' }}
                                    </option>
                                @endforeach
                            </select>

                            @error('inscription_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="periode_id" class="form-label fw-semibold">
                                Période scolaire
                                <span class="text-danger">*</span>
                            </label>

                            <select name="periode_id" id="periode_id"
                                    class="form-select form-select-lg rounded-3 @error('periode_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Choisir une période --</option>

                                @foreach($periodes as $periode)
                                    <option value="{{ $periode->id }}"
                                        @selected(old('periode_id', $bulletin->periode_id) == $periode->id)>
                                        {{ $periode->libelle
                                            ?? $periode->nom
                                            ?? (($periode->type ?? 'Période') . ' ' . ($periode->numero ?? '')) }}
                                    </option>
                                @endforeach
                            </select>

                            @error('periode_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning border-0 rounded-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Vérifiez l'inscription et la période avant d'enregistrer.
                            Les informations de l'élève et de l'année seront actualisées
                            à partir de l'inscription sélectionnée.
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                            <a href="{{ route('director.bulletins.show', $bulletin) }}"
                               class="btn btn-light border rounded-3 px-4">
                                Annuler
                            </a>

                            <button type="submit"
                                    class="btn btn-primary rounded-3 px-4">
                                <i class="fas fa-save me-2"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
