@extends('secretariat.layout.app')

@section('title', 'Nouveau niveau')

@section('content')
<style>
.niveau-form{background:#f5f8fd;min-height:85vh;padding:35px 0}
.niveau-form .heading{color:#172b4d;font-weight:750}
.niveau-form .muted{color:#7b879b}
.niveau-form .form-card{background:#fff;border:1px solid #edf1f7;border-radius:17px;box-shadow:0 8px 28px rgba(27,53,87,.045);overflow:hidden}
.niveau-form .card-head{padding:24px 28px;border-bottom:1px solid #edf1f7}
.niveau-form .card-body{padding:28px}
.niveau-form .form-label{color:#263b5b;font-weight:650}
.niveau-form .form-control,.niveau-form .form-select{min-height:48px;border:1px solid #dce4ef;border-radius:10px;padding:11px 14px}
.niveau-form .form-control:focus,.niveau-form .form-select:focus{border-color:#3478e5;box-shadow:0 0 0 4px rgba(52,120,229,.12)}
.niveau-form .btn{padding:11px 18px;border-radius:10px;font-weight:650}
.niveau-form .save{background:#1769e0;color:white;border:1px solid #1769e0}
.niveau-form .save:hover{background:#1055bc;color:white}
.niveau-form .cancel{background:#fc0000;color:#ffffff;border:1px solid #ff0000}
.niveau-form .tip{background:#edf4ff;border:1px solid #dce9ff;color:#48668f;padding:15px;border-radius:12px}
@media(max-width:576px){.niveau-form .card-head,.niveau-form .card-body{padding:20px}.niveau-form .actions{flex-direction:column-reverse}.niveau-form .actions .btn{width:100%}}
</style>

<div class="niveau-form">
<div class="container" style="max-width:850px">

    <a href="{{ route('secretariat.niveau.index') }}" class="text-decoration-none">← Retour à la liste</a>

    <div class="my-4">
        <h2 class="heading mb-2">Créer un nouveau niveau</h2>
        <p class="muted mb-0">Ajoutez un niveau et rattachez-le à un cycle scolaire.</p>
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
            <h5 class="heading mb-1">Informations du niveau</h5>
            <p class="muted small mb-0">Les champs marqués d'un astérisque sont obligatoires.</p>
        </div>

        <div class="card-body">
            <form action="{{ route('secretariat.niveau.store') }}" method="POST">
                @csrf

                {{-- Nom du niveau --}}
                <div class="mb-4">
                    <label for="nom" class="form-label">
                        Nom du niveau <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        maxlength="100"
                        class="form-control @error('nom') is-invalid @enderror"
                        value="{{ old('nom') }}"
                        placeholder="Ex. : Sixième, Cinquième, Seconde"
                        required
                        autofocus
                    >

                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Ordre du niveau --}}
                <div class="mb-4">
                    <label for="ordre" class="form-label">
                        Ordre du niveau
                    </label>

                    <input
                        type="number"
                        id="ordre"
                        name="ordre"
                        min="0"
                        step="1"
                        class="form-control @error('ordre') is-invalid @enderror"
                        value="{{ old('ordre') }}"
                        placeholder="Ex. : 1, 2, 3..."
                    >

                    @error('ordre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-text">
                        Champ facultatif. Il permet de définir l'ordre d'affichage des niveaux.
                    </div>
                </div>

                {{-- Cycle scolaire --}}
                <div class="mb-4">
                    <label for="cycle_id" class="form-label">
                        Cycle scolaire <span class="text-danger">*</span>
                    </label>

                    <select
                        name="cycle_id"
                        id="cycle_id"
                        class="form-select @error('cycle_id') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Sélectionner un cycle --</option>

                        @foreach($cycles as $cycle)
                            <option
                                value="{{ $cycle->id }}"
                                @selected(old('cycle_id') == $cycle->id)
                            >
                                {{ $cycle->nom }}
                            </option>
                        @endforeach
                    </select>

                    @error('cycle_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if($cycles->isEmpty())
                        <div class="form-text text-danger">
                            Aucun cycle n'est disponible. Créez d'abord un cycle.
                        </div>
                    @else
                        <div class="form-text">
                            Choisissez le cycle auquel ce niveau sera rattaché.
                        </div>
                    @endif
                </div>

                <div class="tip mb-4">
                    <strong>À savoir :</strong> les classes pourront ensuite être associées à ce niveau.
                    Le champ ordre permet de les classer dans la progression scolaire.
                </div>

                <div class="actions d-flex justify-content-between gap-3 pt-4 border-top">
                    <a href="{{ route('secretariat.niveau.index') }}" class="btn cancel">
                        Annuler
                    </a>

                    <button type="submit" class="btn save" @disabled($cycles->isEmpty())>
                        Enregistrer le niveau
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
