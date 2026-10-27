@extends('secretariat.layout.app')

@section('title', 'Enregistrer des notes')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="mb-4">
        <a href="{{ route('secretariat.notes.index') }}" class="text-decoration-none text-secondary small"><i class="bi bi-arrow-left me-1"></i>Retour aux notes</a>
        <h1 class="h3 fw-bold mt-3 mb-1">Enregistrer des notes</h1>
        <p class="text-secondary mb-0">Sélectionnez l’inscription, la période et la matière, puis saisissez les quatre notes sur 20.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3">
            <div class="fw-semibold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Veuillez corriger les erreurs suivantes :</div>
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    @if(session('error'))<div class="alert alert-danger border-0 shadow-sm rounded-3">{{ session('error') }}</div>@endif

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <form action="{{ route('secretariat.notes.store') }}" method="POST">
                @csrf
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 px-4 pt-4">
                        <h2 class="h5 fw-bold mb-1"><i class="bi bi-journal-text text-primary me-2"></i>Contexte scolaire</h2>
                        <p class="text-secondary small mb-0">La période doit appartenir à l’année de l’inscription et la matière doit figurer au programme de la classe.</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <label for="inscription_id" class="form-label fw-semibold">Élève et inscription <span class="text-danger">*</span></label>
                                <select name="inscription_id" id="inscription_id" class="form-select form-select-lg @error('inscription_id') is-invalid @enderror" required>
                                    <option value="">Sélectionnez une inscription</option>
                                    @foreach($inscriptions as $inscription)
                                        @php $nomEleve = trim(($inscription->eleve?->nom ?? '') . ' ' . ($inscription->eleve?->prenom ?? '')); @endphp
                                        <option value="{{ $inscription->id }}" @selected(old('inscription_id') == $inscription->id)>
                                            {{ $nomEleve !== '' ? $nomEleve : 'Élève non associé' }} — {{ $inscription->eleve?->matricule ?? 'Sans matricule' }} — {{ $inscription->classe?->code ?? $inscription->classe?->nom ?? 'Classe non définie' }} (inscription #{{ $inscription->id }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('inscription_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="periode_id" class="form-label fw-semibold">Période scolaire <span class="text-danger">*</span></label>
                                <select name="periode_id" id="periode_id" class="form-select form-select-lg @error('periode_id') is-invalid @enderror" required>
                                    <option value="">Sélectionnez une période</option>
                                    @foreach($periodes as $periode)
                                        <option value="{{ $periode->id }}" @selected(old('periode_id') == $periode->id)>
                                            {{ $periode->libelle }} — {{ ucfirst($periode->type) }} {{ $periode->numero }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('periode_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">Les périodes clôturées ne sont pas proposées.</div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="matiere_id" class="form-label fw-semibold">Matière <span class="text-danger">*</span></label>
                                <select name="matiere_id" id="matiere_id" class="form-select form-select-lg @error('matiere_id') is-invalid @enderror" required>
                                    <option value="">Sélectionnez une matière</option>
                                    @foreach($matieres as $matiere)
                                        <option value="{{ $matiere->id }}" @selected(old('matiere_id') == $matiere->id)>{{ $matiere->code ? $matiere->code . ' — ' : '' }}{{ $matiere->nom }}</option>
                                    @endforeach
                                </select>
                                @error('matiere_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 px-4 pt-4">
                        <h2 class="h5 fw-bold mb-1"><i class="bi bi-pencil-square text-primary me-2"></i>Résultats des évaluations</h2>
                        <p class="text-secondary small mb-0">Toutes les notes sont obligatoires et doivent être comprises entre 0 et 20.</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @foreach([
                                'interrogation_1' => 'Interrogation 1',
                                'interrogation_2' => 'Interrogation 2',
                                'devoir' => 'Devoir',
                                'composition' => 'Composition',
                            ] as $champ => $libelle)
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label for="{{ $champ }}" class="form-label fw-semibold">{{ $libelle }} <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <input type="number" name="{{ $champ }}" id="{{ $champ }}" class="form-control @error($champ) is-invalid @enderror" value="{{ old($champ) }}" min="0" max="20" step="0.01" placeholder="0 à 20" required>
                                        <span class="input-group-text">/20</span>
                                        @error($champ)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex flex-wrap justify-content-end gap-2 border-top pt-4 mt-4">
                            <a href="{{ route('secretariat.notes.index') }}" class="btn btn-danger border rounded-3 px-4">Annuler</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4"><i class="bi bi-check2-circle me-2"></i>Enregistrer les notes</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control,.form-select,.input-group-text{border-radius:10px}
    .form-control:focus,.form-select:focus{border-color:#6d91e8;box-shadow:0 0 0 .2rem rgba(37,99,235,.10)}
    .rounded-4{border-radius:16px!important}
</style>
@endsection
