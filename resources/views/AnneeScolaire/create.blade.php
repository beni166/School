
@extends('admin.layout.app')

@section('title', 'Nouvelle année scolaire')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('director.annees-scolaires.index') }}"
           class="text-decoration-none">
            ← Retour à la liste
        </a>

        <h2 class="fw-bold mt-3">Nouvelle année scolaire</h2>
        <p class="text-muted">
            Renseignez les informations de la nouvelle année.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('director.annees-scolaires.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="libelle" class="form-label">
                        Libellé de l'année scolaire
                    </label>

                    <input type="text"
                           name="libelle"
                           id="libelle"
                           class="form-control @error('libelle') is-invalid @enderror"
                           placeholder="Ex. : 2026-2027"
                           value="{{ old('libelle') }}"
                           required>

                    @error('libelle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="date_debut" class="form-label">
                            Date de début
                        </label>

                        <input type="date"
                               name="date_debut"
                               id="date_debut"
                               class="form-control @error('date_debut') is-invalid @enderror"
                               value="{{ old('date_debut') }}"
                               required>

                        @error('date_debut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="date_fin" class="form-label">
                            Date de fin
                        </label>

                        <input type="date"
                               name="date_fin"
                               id="date_fin"
                               class="form-control @error('date_fin') is-invalid @enderror"
                               value="{{ old('date_fin') }}"
                               required>

                        @error('date_fin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input"
                           type="checkbox"
                           name="active"
                           id="active"
                           value="1"
                           @checked(old('active'))>

                    <label class="form-check-label" for="active">
                        Définir comme année scolaire active
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Enregistrer
                    </button>

                    <a href="{{ route('director.annees-scolaires.index') }}"
                       class="btn btn-danger">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
