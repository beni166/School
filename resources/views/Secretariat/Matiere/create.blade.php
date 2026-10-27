
@extends('secretariat.layout.app')

@section('title', 'Ajouter une matière')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">

    {{-- En-tête --}}
    <div class="mb-4">
        <a href="{{ route('secretariat.matieres.index') }}"
           class="text-decoration-none text-secondary small">
            <i class="bi bi-arrow-left me-1"></i>
            Retour aux matières
        </a>

        <h1 class="h3 fw-bold mt-3 mb-1">Ajouter une matière</h1>
        <p class="text-secondary mb-0">
            Renseignez le code et le nom de la nouvelle matière.
        </p>
    </div>

    {{-- Messages d'erreur --}}
    @if($errors->any())
        <div class="alert alert-danger rounded-3">
            <div class="fw-bold mb-2">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Veuillez corriger les erreurs suivantes :
            </div>

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">

            <div class="card border-0 shadow-sm rounded-4">

                {{-- En-tête de la carte --}}
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-icon">
                            <i class="bi bi-journal-bookmark fs-4"></i>
                        </div>

                        <div>
                            <h2 class="h5 fw-bold mb-1">
                                Informations de la matière
                            </h2>
                            <p class="text-secondary small mb-0">
                                Les champs marqués d'un astérisque sont obligatoires.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Formulaire --}}
                <div class="card-body p-4">
                    <form action="{{ route('secretariat.matieres.store') }}" method="POST">
                        @csrf

                        {{-- Code --}}
                        <div class="mb-4">
                            <label for="code" class="form-label fw-semibold">
                                Code de la matière
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="code"
                                id="code"
                                class="form-control form-control-lg @error('code') is-invalid @enderror"
                                value="{{ old('code') }}"
                                placeholder="Ex. : MAT001, MATH, PC"
                                maxlength="10"
                                required
                            >

                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="form-text">
                                10 caractères maximum. Le code doit être unique.
                            </div>
                        </div>

                        {{-- Nom --}}
                        <div class="mb-4">
                            <label for="nom" class="form-label fw-semibold">
                                Nom de la matière
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="nom"
                                id="nom"
                                class="form-control form-control-lg @error('nom') is-invalid @enderror"
                                value="{{ old('nom') }}"
                                placeholder="Ex. : Mathématiques"
                                maxlength="100"
                                required
                            >

                            @error('nom')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex flex-wrap justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('secretariat.matieres.index') }}"
                               class="btn btn-light border rounded-3 px-4">
                                <i class="bi bi-x-circle me-1"></i>
                                Annuler
                            </a>

                            <button type="submit"
                                    class="btn btn-primary rounded-3 px-4">
                                <i class="bi bi-check2-circle me-2"></i>
                                Enregistrer la matière
                            </button>
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

    .form-control {
        border-radius: 10px;
        padding: 12px 14px;
    }

    .form-control:focus {
        border-color: #6d91e8;
        box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .10);
    }

    .rounded-4 {
        border-radius: 16px !important;
    }
</style>
@endsection
