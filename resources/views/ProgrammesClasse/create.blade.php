@extends('admin.layout.app')

@section('title', 'Ajouter un programme de classe')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="mb-4">
        <a href="{{ route('director.programmes-classes.index') }}" class="text-decoration-none text-secondary small"><i class="bi bi-arrow-left me-1"></i>Retour aux programmes</a>
        <h1 class="h3 fw-bold text-dark mt-3 mb-1">Ajouter un programme</h1>
        <p class="text-secondary mb-0">Associez une matière à une classe pour une année scolaire et définissez son coefficient.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3">
            <div class="fw-bold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Veuillez corriger les erreurs suivantes :</div>
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-xl-9">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-icon"><i class="bi bi-journal-plus"></i></div>
                        <div><h2 class="h5 fw-bold mb-1">Informations du programme</h2><p class="text-secondary small mb-0">Les quatre champs sont obligatoires.</p></div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('director.programmes-classes.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <label for="annee_scolaire_id" class="form-label fw-semibold">Année scolaire <span class="text-danger">*</span></label>
                                <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select form-select-lg @error('annee_scolaire_id') is-invalid @enderror" required>
                                    <option value="">Sélectionnez une année</option>
                                    @foreach($annees as $annee)
                                        <option value="{{ $annee->id }}" @selected(old('annee_scolaire_id') == $annee->id)>{{ $annee->libelle }}</option>
                                    @endforeach
                                </select>
                                @error('annee_scolaire_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="classe_id" class="form-label fw-semibold">Classe <span class="text-danger">*</span></label>
                                <select name="classe_id" id="classe_id" class="form-select form-select-lg @error('classe_id') is-invalid @enderror" required>
                                    <option value="">Sélectionnez une classe</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}" @selected(old('classe_id') == $classe->id)>{{ $classe->code ? $classe->code.' — ' : '' }}{{ $classe->nom }}</option>
                                    @endforeach
                                </select>
                                @error('classe_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-8">
                                <label for="matiere_id" class="form-label fw-semibold">Matière <span class="text-danger">*</span></label>
                                <select name="matiere_id" id="matiere_id" class="form-select form-select-lg @error('matiere_id') is-invalid @enderror" required>
                                    <option value="">Sélectionnez une matière</option>
                                    @foreach($matieres as $matiere)
                                        <option value="{{ $matiere->id }}" @selected(old('matiere_id') == $matiere->id)>{{ $matiere->code ? $matiere->code.' — ' : '' }}{{ $matiere->nom }}</option>
                                    @endforeach
                                </select>
                                @error('matiere_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">Une matière ne peut être ajoutée qu'une seule fois par classe et par année scolaire.</div>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="coefficient" class="form-label fw-semibold">Coefficient <span class="text-danger">*</span></label>
                                <input type="number" name="coefficient" id="coefficient" class="form-control form-control-lg @error('coefficient') is-invalid @enderror" value="{{ old('coefficient', 1) }}" min="0.01" step="0.01" required placeholder="Ex. : 2">
                                @error('coefficient')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">Doit être strictement supérieur à zéro.</div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 border-top mt-4 pt-4">
                            <a href="{{ route('director.programmes-classes.index') }}" class="btn btn-danger border rounded-3 px-4">Annuler</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4"><i class="bi bi-check2-circle me-2"></i>Enregistrer le programme</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-icon{width:54px;height:54px;display:flex;align-items:center;justify-content:center;border-radius:15px;background:#eaf1ff;color:#2457c5;font-size:24px;flex-shrink:0}
    .form-control,.form-select{border-radius:10px;padding:12px 14px}.form-control:focus,.form-select:focus{border-color:#6d91e8;box-shadow:0 0 0 .2rem rgba(37,99,235,.10)}.rounded-4{border-radius:16px!important}
</style>
@endsection
