@extends('secretariat.layout.app')

@section('title', 'Modifier un professeur')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="mb-4">
        <a href="{{ route('secretariat.professeurs.index') }}" class="text-decoration-none text-secondary small"><i class="bi bi-arrow-left me-1"></i>Retour aux professeurs</a>
        <h1 class="h3 fw-bold mt-3 mb-1">Modifier le professeur</h1>
        <p class="text-secondary mb-0">Modifiez les informations de <strong>{{ $professeur->nom }} {{ $professeur->prenom }}</strong>.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-3">
            <div class="fw-bold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Veuillez corriger les erreurs suivantes :</div>
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-icon"><i class="bi bi-pencil-square fs-4"></i></div>
                        <div><h2 class="h5 fw-bold mb-1">Informations du professeur</h2><p class="text-secondary small mb-0">Identifiant : PROF-{{ str_pad($professeur->id, 3, '0', STR_PAD_LEFT) }}</p></div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('secretariat.professeurs.update', $professeur->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6 mb-2">
                                <label for="nom" class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                                <input type="text" name="nom" id="nom" maxlength="100" required value="{{ old('nom', $professeur->nom) }}" class="form-control form-control-lg @error('nom') is-invalid @enderror">
                                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="prenom" class="form-label fw-semibold">Prénom(s) <span class="text-danger">*</span></label>
                                <input type="text" name="prenom" id="prenom" maxlength="150" required value="{{ old('prenom', $professeur->prenom) }}" class="form-control form-control-lg @error('prenom') is-invalid @enderror">
                                @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 mb-2">
                                <label for="email" class="form-label fw-semibold">Adresse e-mail</label>
                                <input type="email" name="email" id="email" maxlength="255" value="{{ old('email', $professeur->email) }}" class="form-control form-control-lg @error('email') is-invalid @enderror">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 mb-2">
                                <label for="telephone" class="form-label fw-semibold">Téléphone</label>
                                <input type="tel" name="telephone" id="telephone" maxlength="30" value="{{ old('telephone', $professeur->telephone) }}" class="form-control form-control-lg @error('telephone') is-invalid @enderror">
                                @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pt-4 mt-3 border-top">
                            <a href="{{ route('secretariat.professeurs.show', $professeur->id) }}" class="btn btn-light border rounded-3 px-4"><i class="bi bi-eye me-1"></i>Voir le profil</a>
                            <div class="d-flex gap-2">
                                <a href="{{ route('secretariat.professeurs.index') }}" class="btn btn-danger border rounded-3 px-4">Annuler</a>
                                <button type="submit" class="btn btn-primary rounded-3 px-4"><i class="bi bi-check2-circle me-2"></i>Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-icon{width:54px;height:54px;display:flex;align-items:center;justify-content:center;border-radius:15px;background:#eaf1ff;color:#2457c5}
    .form-control{border-radius:10px;padding:12px 14px}
    .form-control:focus{border-color:#6d91e8;box-shadow:0 0 0 .2rem rgba(37,99,235,.10)}
    .rounded-4{border-radius:16px!important}
</style>
@endsection
