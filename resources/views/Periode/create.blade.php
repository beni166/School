@extends('admin.layout.app')

@section('title', 'Créer une période scolaire')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="mb-4">
        <a href="{{ route('director.periodes.index') }}" class="text-decoration-none text-secondary small"><i class="bi bi-arrow-left me-1"></i>Retour aux périodes</a>
        <h1 class="h3 fw-bold mt-3 mb-1">Créer une période scolaire</h1>
        <p class="text-secondary mb-0">Définissez le type de période, son année scolaire et ses dates.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-3 shadow-sm"><div class="fw-bold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Veuillez corriger les erreurs :</div><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div class="row justify-content-center"><div class="col-12 col-xl-9">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 px-4 pt-4"><div class="d-flex align-items-center gap-3"><div class="form-icon"><i class="bi bi-calendar2-plus"></i></div><div><h2 class="h5 fw-bold mb-1">Informations de la période</h2><p class="text-secondary small mb-0">Les dates de fin doivent être postérieures aux dates de début.</p></div></div></div>
            <div class="card-body p-4">
                <form action="{{ route('director.periodes.store') }}" method="POST" id="periodeForm">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="annee_scolaire_id" class="form-label fw-semibold">Année scolaire <span class="text-danger">*</span></label>
                            <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select form-select-lg @error('annee_scolaire_id') is-invalid @enderror" required>
                                <option value="">Sélectionnez une année scolaire</option>
                                @foreach($annees as $annee)
                                    <option value="{{ $annee->id }}" @selected(old('annee_scolaire_id') == $annee->id)>{{ $annee->libelle }}</option>
                                @endforeach
                            </select>
                            @error('annee_scolaire_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="type" class="form-label fw-semibold">Organisation <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-select form-select-lg @error('type') is-invalid @enderror" required>
                                <option value="">Sélectionnez le type</option>
                                <option value="trimestre" @selected(old('type') === 'trimestre')>Trimestrielle (3 trimestres)</option>
                                <option value="semestre" @selected(old('type') === 'semestre')>Semestrielle (2 semestres)</option>
                            </select>
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="numero" class="form-label fw-semibold">Numéro de la période <span class="text-danger">*</span></label>
                            <select name="numero" id="numero" class="form-select form-select-lg @error('numero') is-invalid @enderror" required>
                                <option value="">Sélectionnez le numéro</option>
                                <option value="1" @selected((string) old('numero') === '1')>1</option>
                                <option value="2" @selected((string) old('numero') === '2')>2</option>
                                <option value="3" @selected((string) old('numero') === '3')>3</option>
                            </select>
                            @error('numero')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text" id="numeroHelp">Un trimestre peut porter le numéro 1, 2 ou 3.</div>
                        </div>
                        <div class="col-12">
                            <label for="libelle" class="form-label fw-semibold">Libellé <span class="text-danger">*</span></label>
                            <input type="text" name="libelle" id="libelle" maxlength="100" value="{{ old('libelle') }}" placeholder="Ex. : Premier trimestre" class="form-control form-control-lg @error('libelle') is-invalid @enderror" required>
                            @error('libelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="date_debut" class="form-label fw-semibold">Date de début <span class="text-danger">*</span></label>
                            <input type="date" name="date_debut" id="date_debut" value="{{ old('date_debut') }}" class="form-control form-control-lg @error('date_debut') is-invalid @enderror" required>
                            @error('date_debut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="date_fin" class="form-label fw-semibold">Date de fin <span class="text-danger">*</span></label>
                            <input type="date" name="date_fin" id="date_fin" value="{{ old('date_fin') }}" class="form-control form-control-lg @error('date_fin') is-invalid @enderror" required>
                            @error('date_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('director.periodes.index') }}" class="btn btn-danger border rounded-3 px-4">Annuler</a>
                        <button type="submit" class="btn btn-primary rounded-3 px-4"><i class="bi bi-check2-circle me-2"></i>Créer la période</button>
                    </div>
                </form>
            </div>
        </div>
    </div></div>
</div>
<style>
.form-icon{width:52px;height:52px;border-radius:15px;display:flex;align-items:center;justify-content:center;background:#eaf1ff;color:#2457c5;font-size:23px;flex-shrink:0}.form-control,.form-select{border-radius:10px;padding:12px 14px}.form-control:focus,.form-select:focus{border-color:#6d91e8;box-shadow:0 0 0 .2rem rgba(37,99,235,.1)}.rounded-4{border-radius:16px!important}
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
        if (isSemestre && numero.value === '3') numero.value = '';
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
