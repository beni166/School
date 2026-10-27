
@extends('secretariat.layout.app')

@section('title', 'Nouveau cycle')

@section('content')
<style>
    .cycle-form-page { background:#f5f8fd; min-height:85vh; padding:35px 0; }
    .cycle-form-page .title { color:#172b4d; font-weight:750; }
    .cycle-form-page .muted { color:#7b879b; }
    .cycle-form-page .form-card {
        background:white; border:1px solid #edf1f7; border-radius:17px;
        box-shadow:0 8px 28px rgba(27,53,87,.045); overflow:hidden;
    }
    .cycle-form-page .card-head { padding:24px 28px; border-bottom:1px solid #edf1f7; }
    .cycle-form-page .card-body { padding:28px; }
    .cycle-form-page .form-label { color:#263b5b; font-weight:650; }
    .cycle-form-page .form-control {
        min-height:48px; border:1px solid #dce4ef; border-radius:10px;
        padding:11px 14px;
    }
    .cycle-form-page .form-control:focus {
        border-color:#3478e5; box-shadow:0 0 0 4px rgba(52,120,229,.12);
    }
    .cycle-form-page .btn {
        padding:11px 18px; border-radius:10px; font-weight:650;
    }
    .cycle-form-page .btn-save { background:#1769e0; border-color:#1769e0; color:white; }
    .cycle-form-page .btn-save:hover { background:#1055bc; color:white; }
    .cycle-form-page .btn-cancel { background:#ff0000; border:1px solid #dce5f1; color:#fafcff; }
    .cycle-form-page .tip {
        background:#edf4ff; border:1px solid #dce9ff; color:#48668f;
        padding:15px; border-radius:12px;
    }
    @media(max-width:576px) {
        .cycle-form-page .card-head,.cycle-form-page .card-body { padding:20px; }
        .cycle-form-page .form-actions { display:flex; flex-direction:column-reverse; }
        .cycle-form-page .form-actions .btn { width:100%; }
    }
</style>

<div class="cycle-form-page">
    <div class="container" style="max-width:850px;">
        <a href="{{ route('secretariat.cycle.index') }}" class="text-decoration-none">
            ← <span class="fw-semibold">Retour à la liste</span>
        </a>

        <div class="my-4">
            <h2 class="title mb-2">Créer un nouveau cycle</h2>
            <p class="muted mb-0">
                Ajoutez un cycle à l’organisation scolaire de votre établissement.
            </p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-3">
                <strong>Veuillez corriger les erreurs suivantes :</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <div class="card-head">
                <h5 class="title mb-1">Informations du cycle</h5>
                <p class="muted small mb-0">
                    Renseignez le nom du cycle scolaire.
                </p>
            </div>

            <div class="card-body">
                <form action="{{ route('secretariat.cycle.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nom" class="form-label">
                            Nom du cycle <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="nom"
                               id="nom"
                               maxlength="100"
                               class="form-control @error('nom') is-invalid @enderror"
                               placeholder="Ex. : Collège ou Lycée"
                               value="{{ old('nom') }}"
                               required autofocus>

                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="form-text">
                            Le nom doit être unique et comporter au maximum 100 caractères.
                        </div>
                    </div>

                    <div class="tip mb-4">
                        <strong>À savoir :</strong>
                        vous pourrez associer des niveaux à ce cycle après sa création.
                    </div>

                    <div class="form-actions d-flex justify-content-between gap-3 pt-4 border-top">
                        <a href="{{ route('secretariat.cycle.index') }}" class="btn btn-cancel">
                            Annuler
                        </a>

                        <button type="submit" class="btn btn-save">
                            Enregistrer le cycle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
