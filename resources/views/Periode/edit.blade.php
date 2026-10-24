@extends('admin.layout.app')

@section('title', 'Modifier une période')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="mb-4">
        <a href="{{ route('director.periodes.show', $periode) }}" class="text-decoration-none text-secondary small"><i class="bi bi-arrow-left me-1"></i>Retour aux détails</a>
        <h1 class="h3 fw-bold mt-3 mb-1">Modifier la période</h1>
        <p class="text-secondary mb-0">Modifiez les informations de « {{ $periode->libelle }} ».</p>
    </div>

    @if(session('error'))<div class="alert alert-danger border-0 shadow-sm rounded-3"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger border-0 shadow-sm rounded-3"><div class="fw-bold mb-2">Veuillez corriger les erreurs :</div><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    @if($periode->cloturee)
        <div class="alert alert-warning border-0 rounded-3"><i class="bi bi-lock-fill me-2"></i><strong>Période clôturée :</strong> cette période ne peut plus être modifiée.</div>
    @endif

    <div class="row justify-content-center"><div class="col-12 col-xl-9">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 px-4 pt-4"><div class="d-flex align-items-center gap-3"><div class="form-icon"><i class="bi bi-pencil-square"></i></div><div><h2 class="h5 fw-bold mb-1">Informations de la période</h2><p class="text-secondary small mb-0">Identifiant : PER-{{ str_pad($periode->id, 3, '0', STR_PAD_LEFT) }}</p></div></div></div>
            <div class="card-body p-4">
                <form action="{{ route('director.periodes.update', $periode) }}" method="POST">
                    @csrf @method('PUT')
                    <fieldset @disabled($periode->cloturee)>
                        <div class="row g-4">
                            <div class="col-12">
                                <label for="annee_scolaire_id" class="form-label fw-semibold">Année scolaire <span class="text-danger">*</span></label>
                                <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select form-select-lg @error('annee_scolaire_id') is-invalid @enderror" required>
                                    <option value="">Sélectionnez une année scolaire</option>
                                    @foreach($annees as $annee)
                                        <option value="{{ $annee->id }}" @selected(old('annee_scolaire_id', $periode->annee_scolaire_id) == $annee->id)>{{ $annee->libelle }}</option>
                                    @endforeach
                                </select>
                                @error('annee_scolaire_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="type" class="form-label fw-semibold">Organisation <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-select form-select-lg @error('type') is-invalid @enderror" required>
                                    <option value="trimestre" @selected(old('type', $periode->type) === 'trimestre')>Trimestrielle</option>
                                    <option value="semestre" @selected(old('type', $periode->type) === 'semestre')>Semestrielle</option>
                                </select>
                                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="numero" class="form-label fw-semibold">Numéro <span class="text-danger">*</span></label>
                                <select name="numero" id="numero" class="form-select form-select-lg @error('numero') is-invalid @enderror" required>
                                    @foreach([1, 2, 3] as $n)
                                        <option value="{{ $n }}" @selected((string) old('numero', $periode->numero) === (string) $n)>{{ $n }}</option>
                                    @endforeach
                                </select>
                                @error('numero')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text" id="numeroHelp">Le numéro dépend du type de période.</div>
                            </div>
                            <div class="col-12">
                                <label for="libelle" class="form-label fw-semibold">Libellé <span class="text-danger">*</span></label>
                                <input type="text" name="libelle" id="libelle" maxlength="100" value="{{ old('libelle', $periode->libelle) }}" class="form-control form-control-lg @error('libelle') is-invalid @enderror" required>
                                @error('libelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="date_debut" class="form-label fw-semibold">Date de début <span class="text-danger">*</span></label>
                                <input type="date" name="date_debut" id="date_debut" value="{{ old('date_debut', $periode->date_debut ? \Illuminate\Support\Carbon::parse($periode->date_debut)->format('Y-m-d') : '') }}" class="form-control form-control-lg @error('date_debut') is-invalid @enderror" required>
                                @error('date_debut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="date_fin" class="form-label fw-semibold">Date de fin <span class="text-danger">*</span></label>
                                <input type="date" name="date_fin" id="date_fin" value="{{ old('date_fin', $periode->date_fin ? \Illuminate\Support\Carbon::parse($periode->date_fin)->format('Y-m-d') : '') }}" class="form-control form-control-lg @error('date_fin') is-invalid @enderror" required>
                                @error('date_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </fieldset>
                    <div class="d-flex flex-wrap justify-content-between gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('director.periodes.show', $periode) }}" class="btn btn-danger border rounded-3 px-4">Annuler</a>
                        @unless($periode->cloturee)
                            <button type="submit" class="btn btn-primary rounded-3 px-4"><i class="bi bi-check2-circle me-2"></i>Enregistrer les modifications</button>
                        @endunless
                    </div>
                </form>
            </div>
        </div>
    </div></div>
</div>
<style>
.form-icon{width:52px;height:52px;border-radius:15px;display:flex;align-items:center;justify-content:center;background:#fff3d8;color:#b77908;font-size:23px;flex-shrink:0}.form-control,.form-select{border-radius:10px;padding:12px 14px}.form-control:focus,.form-select:focus{border-color:#6d91e8;box-shadow:0 0 0 .2rem rgba(37,99,235,.1)}.rounded-4{border-radius:16px!important}fieldset:disabled{opacity:.75}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const type = document.getElementById('type');
    const numero = document.getElementById('numero');
    const help = document.getElementById('numeroHelp');
    function adjustNumero() {
        const isSemestre = type.value === 'semestre';
        const option3 = numero.querySelector('option[value="3"]');
        option3.hidden = isSemestre;
        option3.disabled = isSemestre;
        if (isSemestre && numero.value === '3') numero.value = '1';
        help.textContent = isSemestre ? 'Un semestre porte le numéro 1 ou 2.' : 'Un trimestre peut porter le numéro 1, 2 ou 3.';
    }
    type.addEventListener('change', adjustNumero);
    adjustNumero();
    const debut = document.getElementById('date_debut');
    const fin = document.getElementById('date_fin');
    debut.addEventListener('change', function () { fin.min = debut.value; });
    if (debut.value) fin.min = debut.value;
});
</script>
@endsection
