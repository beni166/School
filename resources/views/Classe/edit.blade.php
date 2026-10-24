@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="{{ route('director.classes.index') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Retour aux classes
        </a>

        <h2 class="fw-bold text-dark mt-3 mb-1">Modifier une classe</h2>
        <p class="text-muted mb-0">
            Modification de la classe <strong>{{ $classes->nom }}</strong>.
        </p>
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
                            <i class="bi bi-pencil-square fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Informations de la classe</h5>
                            <p class="text-muted small mb-0">Modifiez le nom ou le niveau scolaire.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('director.classes.update', $classes->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nom" class="form-label fw-semibold">
                                Nom de la classe <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="nom"
                                id="nom"
                                class="form-control form-control-lg @error('nom') is-invalid @enderror"
                                value="{{ old('nom', $classes->nom) }}"
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
                                        @selected(old('niveau_id', $classes->niveau_id) == $niveau->id)>
                                        {{ $niveau->nom }}
                                        — {{ $niveau->cycle?->nom ?? 'Cycle non défini' }}
                                    </option>
                                @endforeach
                            </select>

                            @error('niveau_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pt-3 border-top">
                            <a href="{{ route('director.classes.show', $classes) }}" class="btn btn-light border px-4">
                                <i class="bi bi-eye me-1"></i> Voir la classe
                            </a>

                            <div class="d-flex gap-2">
                                <a href="{{ route('director.classes.index') }}" class="btn btn-danger border px-4">
                                    Annuler
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle me-2"></i>Enregistrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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