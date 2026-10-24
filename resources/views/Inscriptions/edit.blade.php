@extends('admin.layout.app')

@section('title', 'Modifier une inscription')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="mb-4">
        <a href="{{ route('director.inscriptions.show', $inscription) }}" class="text-decoration-none text-secondary small"><i class="bi bi-arrow-left me-1"></i>Retour au dossier d’inscription</a>
        <h1 class="h3 fw-bold text-dark mt-3 mb-1">Modifier une inscription</h1>
        <p class="text-secondary mb-0">Modifiez la classe, le numéro ou la date sans changer l’élève ni l’année scolaire.</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3"><div class="fw-bold mb-2">Veuillez corriger les erreurs suivantes :</div><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div class="row g-4 justify-content-center">
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 px-4 pt-4"><h2 class="h5 fw-bold mb-0">Récapitulatif</h2></div>
                <div class="card-body px-4">
                    <div class="summary-avatar mb-3"><i class="bi bi-person-fill"></i></div>
                    <div class="h5 fw-bold mb-1">{{ trim(($inscription->eleve?->nom ?? '') . ' ' . ($inscription->eleve?->prenom ?? '')) ?: 'Élève non associé' }}</div>
                    <div class="text-secondary small mb-4">Matricule : {{ $inscription->eleve?->matricule ?? 'Non disponible' }}</div>
                    <div class="summary-line"><span class="text-secondary">N° inscription</span><span class="fw-semibold text-end">{{ $inscription->numero_inscription }}</span></div>
                    <div class="summary-line"><span class="text-secondary">Année scolaire</span><span class="fw-semibold text-end">{{ $inscription->anneeScolaire?->libelle ?? 'Non précisée' }}</span></div>
                    <div class="summary-line"><span class="text-secondary">Classe actuelle</span><span class="fw-semibold text-end">{{ $inscription->classe?->code ?? $inscription->classe?->nom ?? 'Non définie' }}</span></div>
                    <div class="notice-box mt-4"><i class="bi bi-shield-check me-2"></i>L’élève et l’année scolaire sont verrouillés afin de préserver l’historique.</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 px-4 pt-4"><h2 class="h5 fw-bold mb-1">Informations modifiables</h2><p class="text-secondary small mb-0">Vérifiez les informations avant d’enregistrer.</p></div>
                <div class="card-body p-4">
                    <form action="{{ route('director.inscriptions.update', $inscription) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="classe_id" class="form-label fw-semibold">Classe <span class="text-danger">*</span></label>
                            <select name="classe_id" id="classe_id" class="form-select form-select-lg @error('classe_id') is-invalid @enderror" required>
                                <option value="">Sélectionnez une classe</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" @selected(old('classe_id', $inscription->classe_id) == $classe->id)>
                                        {{ $classe->code ? $classe->code . ' — ' : '' }}{{ $classe->nom }}@if($classe->niveau?->nom) — {{ $classe->niveau->nom }} @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('classe_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="numero_inscription" class="form-label fw-semibold">Numéro d’inscription <span class="text-danger">*</span></label>
                            <input type="text" name="numero_inscription" id="numero_inscription" class="form-control form-control-lg @error('numero_inscription') is-invalid @enderror" value="{{ old('numero_inscription', $inscription->numero_inscription) }}" maxlength="50" required>
                            @error('numero_inscription')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="date_inscription" class="form-label fw-semibold">Date d’inscription <span class="text-danger">*</span></label>
                            <input type="date" name="date_inscription" id="date_inscription" class="form-control form-control-lg @error('date_inscription') is-invalid @enderror" value="{{ old('date_inscription', $inscription->date_inscription ? \Illuminate\Support\Carbon::parse($inscription->date_inscription)->format('Y-m-d') : '') }}" required>
                            @error('date_inscription')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('director.inscriptions.show', $inscription) }}" class="btnbtn-danger border rounded-3 px-4">Annuler</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4"><i class="bi bi-check2-circle me-2"></i>Enregistrer les modifications</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .summary-avatar{width:58px;height:58px;display:flex;align-items:center;justify-content:center;background:#eaf1ff;color:#2457c5;border-radius:18px;font-size:27px}
    .summary-line{display:flex;justify-content:space-between;align-items:flex-start;gap:14px;padding:14px 0;border-bottom:1px solid #edf0f5;font-size:14px}.summary-line:last-of-type{border-bottom:0}
    .form-control,.form-select{border-radius:11px;padding:12px 14px;border-color:#dce3ed}.form-control:focus,.form-select:focus{border-color:#6d91e8;box-shadow:0 0 0 .2rem rgba(37,99,235,.10)}
    .notice-box{background:#f1f6ff;color:#31558d;border-radius:12px;padding:14px;font-size:13px}.rounded-4{border-radius:16px!important}
</style>
@endsection
