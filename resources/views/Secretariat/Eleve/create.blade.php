@extends('secretariat.layout.app')

@section('title', 'Ajouter un élève')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="mb-4">
        <a href="{{ route('secretariat.eleves.index') }}" class="text-decoration-none text-secondary small"><i class="bi bi-arrow-left me-1"></i>Retour aux élèves</a>
        <h1 class="h3 fw-bold mt-3 mb-1">Ajouter un élève</h1>
        <p class="text-secondary mb-0">Créez le dossier administratif d'un nouvel élève.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-3">
            <div class="fw-bold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Veuillez corriger les erreurs suivantes :</div>
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-lg-9 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-icon"><i class="bi bi-person-plus fs-4"></i></div>
                        <div>
                            <h2 class="h5 fw-bold mb-1">Informations personnelles</h2>
                            <p class="text-secondary small mb-0">Les champs marqués d'un astérisque sont obligatoires.</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('secretariat.eleves.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="matricule" class="form-label fw-semibold">Matricule <span class="text-danger">*</span></label>
                                <input type="text" name="matricule" id="matricule" maxlength="50" required value="{{ old('matricule') }}" placeholder="Ex. : ELV-2026-001" class="form-control form-control-lg @error('matricule') is-invalid @enderror">
                                @error('matricule')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">Chaque élève doit avoir un matricule unique.</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="sexe" class="form-label fw-semibold">Sexe <span class="text-danger">*</span></label>
                                <select name="sexe" id="sexe" required class="form-select form-select-lg @error('sexe') is-invalid @enderror">
                                    <option value="">Sélectionnez le sexe</option>
                                    <option value="M" @selected(old('sexe') === 'M')>Masculin</option>
                                    <option value="F" @selected(old('sexe') === 'F')>Féminin</option>
                                </select>
                                @error('sexe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="nom" class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                                <input type="text" name="nom" id="nom" maxlength="100" required value="{{ old('nom') }}" placeholder="Ex. : Mensah" class="form-control form-control-lg @error('nom') is-invalid @enderror">
                                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="prenom" class="form-label fw-semibold">Prénom(s) <span class="text-danger">*</span></label>
                                <input type="text" name="prenom" id="prenom" maxlength="150" required value="{{ old('prenom') }}" placeholder="Ex. : Kossi" class="form-control form-control-lg @error('prenom') is-invalid @enderror">
                                @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="date_naissance" class="form-label fw-semibold">Date de naissance</label>
                                <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}" max="{{ now()->format('Y-m-d') }}" class="form-control form-control-lg @error('date_naissance') is-invalid @enderror">
                                @error('date_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">Facultative, mais ne peut pas être dans le futur.</div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 pt-4 mt-3 border-top">
                            <a href="{{ route('secretariat.eleves.index') }}" class="btn btn-danger border rounded-3 px-4">Annuler</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4"><i class="bi bi-check2-circle me-2"></i>Enregistrer l'élève</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-icon{width:54px;height:54px;display:flex;align-items:center;justify-content:center;border-radius:15px;background:#eaf1ff;color:#2457c5}
    .form-control,.form-select{border-radius:10px;padding:12px 14px}
    .form-control:focus,.form-select:focus{border-color:#6d91e8;box-shadow:0 0 0 .2rem rgba(37,99,235,.10)}
    .rounded-4{border-radius:16px!important}
</style>
@endsection
