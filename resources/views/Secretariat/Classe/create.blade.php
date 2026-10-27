@extends('secretariat.layout.app')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="{{ route('secretariat.classes.index') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Retour aux classes
        </a>

        <h2 class="fw-bold text-dark mt-3 mb-1">Ajouter une classe</h2>
        <p class="text-muted mb-0">Enregistrez une nouvelle classe et rattachez-la à un niveau scolaire.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm">
            <div class="fw-bold mb-2">
                <i class="bi bi-exclamation-triangle me-2"></i>Veuillez corriger les erreurs suivantes :
            </div>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-icon">
                            <i class="bi bi-building-add fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Informations de la classe</h5>
                            <p class="text-muted small mb-0">Les champs marqués d'un astérisque sont obligatoires.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('secretariat.classes.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="nom" class="form-label fw-semibold">
                                Nom de la classe <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="nom"
                                id="nom"
                                class="form-control form-control-lg @error('nom') is-invalid @enderror"
                                value="{{ old('nom') }}"
                                placeholder="Ex. : 6ème A, 3ème B, Terminale D"
                                maxlength="100"
                                required
                            >
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="niveau_id" class="form-label fw-semibold">
                                Niveau scolaire <span class="text-danger">*</span>
                            </label>

                            <select
                                name="niveau_id"
                                id="niveau_id"
                                class="form-select form-select-lg @error('niveau_id') is-invalid @enderror"
                                required
                            >
                                <option value="">Sélectionnez un niveau</option>

                                @foreach($niveaux as $niveau)
                                    <option value="{{ $niveau->id }}"
                                        @selected(old('niveau_id') == $niveau->id)>
                                        {{ $niveau->nom }}
                                        — {{ $niveau->cycle?->nom ?? 'Cycle non défini' }}
                                    </option>
                                @endforeach
                            </select>

                            @error('niveau_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($niveaux->isEmpty())
                                <div class="form-text text-danger">
                                    Aucun niveau n'est disponible. Créez d'abord un niveau scolaire.
                                </div>
                            @else
                                <div class="form-text">
                                    Le niveau détermine le cycle scolaire auquel appartient cette classe.
                                </div>
                            @endif
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('secretariat.classes.index') }}" class="btn btn-danger border px-4">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary px-4"
                                @disabled($niveaux->isEmpty())>
                                <i class="bi bi-check-circle me-2"></i>Enregistrer la classe
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert alert-info border-0 rounded-4 mt-3">
                <i class="bi bi-info-circle me-2"></i>
                Une classe peut ensuite être associée aux inscriptions, aux programmes de matières et aux affectations des professeurs.
            </div>
        </div>
    </div>
</div>

<style>
    .form-icon {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        background: #eaf1ff;
        color: #2457c5;
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px 14px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #6d91e8;
        box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .10);
    }

    .rounded-4 {
        border-radius: 16px !important;
    }
</style>
@endsection
