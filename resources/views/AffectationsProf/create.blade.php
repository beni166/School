@extends('admin.layout.app')

@section('title', 'Créer une affectation')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="mb-4">
        <a href="{{ route('director.affectations.index') }}" class="text-decoration-none text-secondary small">
            <i class="bi bi-arrow-left me-1"></i>Retour aux affectations
        </a>
        <h1 class="h3 fw-bold mt-3 mb-1">Nouvelle affectation</h1>
        <p class="text-secondary mb-0">Associez un professeur à une matière, une classe et une année scolaire.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-3">
            <div class="fw-semibold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Veuillez corriger les erreurs :</div>
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-icon"><i class="bi bi-person-workspace"></i></div>
                        <div>
                            <h2 class="h5 fw-bold mb-1">Informations de l'affectation</h2>
                            <p class="text-secondary small mb-0">Tous les champs sont obligatoires.</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('director.affectations.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="annee_scolaire_id" class="form-label fw-semibold">Année scolaire <span class="text-danger">*</span></label>
                            <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select form-select-lg @error('annee_scolaire_id') is-invalid @enderror" required>
                                <option value="">Sélectionnez une année scolaire</option>
                                @foreach($annees as $annee)
                                    <option value="{{ $annee->id }}" @selected(old('annee_scolaire_id') == $annee->id)>
                                        {{ $annee->libelle }}
                                        @if($annee->active ?? false) — Année active @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('annee_scolaire_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="classe_id" class="form-label fw-semibold">Classe <span class="text-danger">*</span></label>
                            <select name="classe_id" id="classe_id" class="form-select form-select-lg @error('classe_id') is-invalid @enderror" required>
                                <option value="">Sélectionnez une classe</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" @selected(old('classe_id') == $classe->id)>
                                        {{ $classe->code ?? $classe->nom }}
                                        @if($classe->code && $classe->nom) — {{ $classe->nom }} @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('classe_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="matiere_id" class="form-label fw-semibold">Matière <span class="text-danger">*</span></label>
                            <select name="matiere_id" id="matiere_id" class="form-select form-select-lg @error('matiere_id') is-invalid @enderror" required>
                                <option value="">Sélectionnez une matière</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}" @selected(old('matiere_id') == $matiere->id)>
                                        @if($matiere->code){{ $matiere->code }} — @endif{{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('matiere_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="professeur_id" class="form-label fw-semibold">Professeur <span class="text-danger">*</span></label>
                            <select name="professeur_id" id="professeur_id" class="form-select form-select-lg @error('professeur_id') is-invalid @enderror" required>
                                <option value="">Sélectionnez un professeur</option>
                                @foreach($professeurs as $professeur)
                                    <option value="{{ $professeur->id }}" @selected(old('professeur_id') == $professeur->id)>
                                        {{ trim($professeur->nom . ' ' . $professeur->prenom) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('professeur_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('director.affectations.index') }}" class="btn btn-danger border rounded-3 px-4">Annuler</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4">
                                <i class="bi bi-check2-circle me-2"></i>Enregistrer l'affectation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-icon { width: 52px; height: 52px; border-radius: 15px; display: flex; align-items: center; justify-content: center; background: #eaf1ff; color: #2457c5; font-size: 24px; flex-shrink: 0; }
    .form-control, .form-select { border-radius: 10px; padding: 12px 14px; }
    .form-control:focus, .form-select:focus { border-color: #6d91e8; box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .10); }
    .rounded-4 { border-radius: 16px !important; }
</style>
@endsection
