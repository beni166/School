@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="{{ route('director.bulletins-details.index', $bulletin) }}"
           class="text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-1"></i> Retour aux détails
        </a>

        <h2 class="fw-bold mt-3 mb-1">
            <i class="fas fa-plus-circle text-primary me-2"></i>
            Ajouter une matière
        </h2>
        <p class="text-muted mb-0">
            Saisissez les notes et les informations de la matière.
        </p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Veuillez corriger les erreurs suivantes :</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">Informations de la matière</h5>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('director.bulletins-details.store', $bulletin) }}"
                  method="POST">
                @csrf

                
@php
    $isEdit = isset($detail);
@endphp

<div class="row g-3">

    <div class="col-md-6">
        <label for="matiere_id" class="form-label fw-semibold">
            Matière <span class="text-danger">*</span>
        </label>

        <select name="matiere_id"
                id="matiere_id"
                class="form-select @error('matiere_id') is-invalid @enderror"
                required>
            <option value="">-- Sélectionner une matière --</option>

            @foreach($matieres as $matiere)
                <option value="{{ $matiere->id }}"
                    @selected(old('matiere_id', $detail->matiere_id ?? '') == $matiere->id)>
                    {{ $matiere->nom }}
                </option>
            @endforeach
        </select>

        @error('matiere_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="professeur_libelle" class="form-label fw-semibold">
            Nom du professeur
        </label>

        <input type="text"
               name="professeur_libelle"
               id="professeur_libelle"
               class="form-control @error('professeur_libelle') is-invalid @enderror"
               value="{{ old('professeur_libelle', $detail->professeur_libelle ?? '') }}"
               maxlength="255"
               placeholder="Nom et prénom du professeur">

        @error('professeur_libelle')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <hr>
        <h6 class="fw-bold">
            <i class="fas fa-pen-to-square text-primary me-2"></i>
            Notes sur 20
        </h6>
    </div>

    @foreach([
        'interrogation_1' => 'Interrogation 1',
        'interrogation_2' => 'Interrogation 2',
        'devoir' => 'Devoir',
        'composition' => 'Composition',
    ] as $field => $label)
        <div class="col-md-3">
            <label for="{{ $field }}" class="form-label fw-semibold">
                {{ $label }} <span class="text-danger">*</span>
            </label>

            <input type="number"
                   name="{{ $field }}"
                   id="{{ $field }}"
                   class="form-control note-input @error($field) is-invalid @enderror"
                   value="{{ old($field, $detail->$field ?? '') }}"
                   min="0"
                   max="20"
                   step="0.01"
                   required>

            @error($field)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endforeach

    <div class="col-md-4">
        <label for="coefficient" class="form-label fw-semibold">
            Coefficient <span class="text-danger">*</span>
        </label>

        <input type="number"
               name="coefficient"
               id="coefficient"
               class="form-control @error('coefficient') is-invalid @enderror"
               value="{{ old('coefficient', $detail->coefficient ?? 1) }}"
               min="0.01"
               step="0.01"
               required>

        @error('coefficient')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="rang_matiere" class="form-label fw-semibold">
            Rang dans la matière
        </label>

        <input type="number"
               name="rang_matiere"
               id="rang_matiere"
               class="form-control @error('rang_matiere') is-invalid @enderror"
               value="{{ old('rang_matiere', $detail->rang_matiere ?? '') }}"
               min="1"
               placeholder="Ex. : 3">

        @error('rang_matiere')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Moyenne calculée</label>
        <input type="text"
               id="moyenne_apercu"
               class="form-control bg-light"
               readonly
               value="{{ $isEdit ? number_format($detail->moyenne_matiere, 2, ',', ' ') . ' / 20' : '—' }}">
        <small class="text-muted">Moyenne des quatre notes.</small>
    </div>

    <div class="col-12">
        <label for="appreciation" class="form-label fw-semibold">
            Appréciation
        </label>

        <textarea name="appreciation"
                  id="appreciation"
                  rows="3"
                  class="form-control @error('appreciation') is-invalid @enderror"
                  placeholder="Ex. : Bon travail, continuez ainsi.">{{ old('appreciation', $detail->appreciation ?? '') }}</textarea>

        @error('appreciation')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('director.bulletins-details.index', $bulletin) }}"
       class="btn btn-danger">
        Annuler
    </a>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save me-1"></i>
        {{ $isEdit ? 'Enregistrer les modifications' : 'Enregistrer la matière' }}
    </button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fields = [
        'interrogation_1',
        'interrogation_2',
        'devoir',
        'composition'
    ];

    const moyenne = document.getElementById('moyenne_apercu');

    function calculerMoyenne() {
        const values = fields.map(function (field) {
            return document.getElementById(field).value.trim();
        });

        if (values.some(value => value === '')) {
            moyenne.value = '—';
            return;
        }

        const notes = values.map(Number);

        if (notes.some(note => !Number.isFinite(note) || note < 0 || note > 20)) {
            moyenne.value = 'Notes invalides';
            return;
        }

        const resultat = notes.reduce((total, note) => total + note, 0) / 4;
        moyenne.value = resultat.toFixed(2).replace('.', ',') + ' / 20';
    }

    fields.forEach(function (field) {
        document.getElementById(field).addEventListener('input', calculerMoyenne);
    });

    calculerMoyenne();
});
</script>
@endpush

            </form>
        </div>
    </div>

</div>
@endsection
