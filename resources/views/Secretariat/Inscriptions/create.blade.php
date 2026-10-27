@extends('secretariat.layout.app')

@section('title', 'Nouvelle inscription')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="mb-4">
        <a href="{{ route('secretariat.inscriptions.index') }}" class="text-decoration-none text-secondary small"><i class="bi bi-arrow-left me-1"></i>Retour aux inscriptions</a>
        <h1 class="h3 fw-bold text-dark mt-3 mb-1">Nouvelle inscription</h1>
        <p class="text-secondary mb-0">Enregistrez un élève dans une classe pour une année scolaire donnée.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3">
            <div class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>Veuillez corriger les erreurs suivantes :</div>
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-xl-9">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 px-4 px-md-5 pt-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-icon"><i class="bi bi-person-vcard-fill"></i></div>
                        <div><h2 class="h5 fw-bold mb-1">Informations de l’inscription</h2><p class="text-secondary small mb-0">Tous les champs marqués d’un astérisque sont obligatoires.</p></div>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('secretariat.inscriptions.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-12">
                                <label for="eleve_id" class="form-label fw-semibold">Élève <span class="text-danger">*</span></label>
                                <select name="eleve_id" id="eleve_id" class="form-select form-select-lg @error('eleve_id') is-invalid @enderror" required>
                                    <option value="">Sélectionnez un élève</option>
                                    @foreach($eleves as $eleve)
                                        <option value="{{ $eleve->id }}" @selected(old('eleve_id') == $eleve->id)>
                                            {{ $eleve->nom }} {{ $eleve->prenom }} — {{ $eleve->matricule }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('eleve_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if($eleves->isEmpty())<div class="form-text text-warning">Aucun élève n’est enregistré. Ajoutez d’abord un élève.</div>@endif
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="annee_scolaire_id" class="form-label fw-semibold">Année scolaire <span class="text-danger">*</span></label>
                                <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select form-select-lg @error('annee_scolaire_id') is-invalid @enderror" required>
                                    <option value="">Sélectionnez une année</option>
                                    @foreach($annees as $annee)
                                        <option value="{{ $annee->id }}" @selected(old('annee_scolaire_id') == $annee->id)>
                                            {{ $annee->libelle }}{{ $annee->active ? ' (année active)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('annee_scolaire_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if($annees->isEmpty())<div class="form-text text-warning">Aucune année scolaire n’est disponible.</div>@endif
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="classe_id" class="form-label fw-semibold">Classe <span class="text-danger">*</span></label>
                                <select name="classe_id" id="classe_id" class="form-select form-select-lg @error('classe_id') is-invalid @enderror" required>
                                    <option value="">Sélectionnez une classe</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}" @selected(old('classe_id') == $classe->id)>
                                            {{ $classe->code ? $classe->code . ' — ' : '' }}{{ $classe->nom }}
                                            @if($classe->niveau?->nom) — {{ $classe->niveau->nom }} @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('classe_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if($classes->isEmpty())<div class="form-text text-warning">Aucune classe n’est disponible.</div>@endif
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="numero_inscription" class="form-label fw-semibold">Numéro d’inscription <span class="text-danger">*</span></label>
                                <input type="text" name="numero_inscription" id="numero_inscription" class="form-control form-control-lg @error('numero_inscription') is-invalid @enderror" value="{{ old('numero_inscription') }}" maxlength="50" placeholder="Ex. : INS-2026-001" required>
                                @error('numero_inscription')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="date_inscription" class="form-label fw-semibold">Date d’inscription <span class="text-danger">*</span></label>
                                <input type="date" name="date_inscription" id="date_inscription" class="form-control form-control-lg @error('date_inscription') is-invalid @enderror" value="{{ old('date_inscription', now()->format('Y-m-d')) }}" required>
                                @error('date_inscription')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="notice-box mt-4"><i class="bi bi-info-circle-fill me-2"></i>Un élève ne peut avoir qu’une seule inscription par année scolaire. Son historique sera conservé pour les années suivantes.</div>
                        <div class="d-flex flex-wrap justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('secretariat.inscriptions.index') }}" class="btn btn-danger border rounded-3 px-4">Annuler</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4" @disabled($eleves->isEmpty() || $classes->isEmpty() || $annees->isEmpty())><i class="bi bi-check2-circle me-2"></i>Enregistrer l’inscription</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-icon{width:54px;height:54px;display:flex;align-items:center;justify-content:center;border-radius:16px;background:#eaf1ff;color:#2457c5;font-size:24px;flex-shrink:0}
    .form-control,.form-select{border-radius:11px;padding:12px 14px;border-color:#dce3ed}.form-control:focus,.form-select:focus{border-color:#6d91e8;box-shadow:0 0 0 .2rem rgba(37,99,235,.10)}
    .notice-box{background:#f1f6ff;color:#31558d;border-radius:12px;padding:14px 16px;font-size:13px}.rounded-4{border-radius:16px!important}
</style>
@endsection
