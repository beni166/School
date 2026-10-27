
@extends('secretariat.layout.app')

@section('content')
<div class="container py-4 bulletin-page">

    <div class="mb-4">
        <a href="{{ route('secretariat.bulletins.index') }}"
           class="text-decoration-none text-secondary small">
            <i class="fas fa-arrow-left me-2"></i>Retour aux bulletins
        </a>

        <div class="mt-3">
            <div class="text-primary small fw-semibold mb-1">
                GESTION SCOLAIRE / NOUVEAU BULLETIN
            </div>
            <h2 class="fw-bold mb-1">Créer un bulletin</h2>
            <p class="text-secondary mb-0">
                Sélectionnez l’élève et la période concernée.
            </p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-3 border-0">
            <div class="fw-bold mb-1">Vérifiez les informations</div>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-xl-9">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="create-banner p-4 p-md-5 text-white">
                    <div class="d-flex align-items-center gap-3">
                        <div class="create-banner-icon">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Nouveau bulletin scolaire</h4>
                            <p class="mb-0 opacity-75">
                                Les moyennes seront calculées à partir des notes enregistrées.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('secretariat.bulletins.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="inscription_id" class="form-label fw-semibold">
                                Élève et inscription <span class="text-danger">*</span>
                            </label>

                            <select name="inscription_id" id="inscription_id"
                                    class="form-select form-select-lg rounded-3 @error('inscription_id') is-invalid @enderror"
                                    required>
                                <option value="">Sélectionner une inscription</option>

                                @foreach($inscriptions as $inscription)
                                    <option value="{{ $inscription->id }}"
                                        data-annee="{{ $inscription->anneeScolaire?->libelle }}"
                                        data-classe="{{ $inscription->classe?->libelle ?? $inscription->classe?->nom }}"
                                        @selected(old('inscription_id') == $inscription->id)>
                                        {{ $inscription->eleve?->prenom }}
                                        {{ $inscription->eleve?->nom }}
                                        — {{ $inscription->classe?->libelle ?? $inscription->classe?->nom ?? 'Classe inconnue' }}
                                        — {{ $inscription->anneeScolaire?->libelle ?? 'Année inconnue' }}
                                    </option>
                                @endforeach
                            </select>

                            @error('inscription_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-text">
                                L’inscription détermine la classe et l’année scolaire du bulletin.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="periode_id" class="form-label fw-semibold">
                                Période scolaire <span class="text-danger">*</span>
                            </label>

                            <select name="periode_id" id="periode_id"
                                    class="form-select form-select-lg rounded-3 @error('periode_id') is-invalid @enderror"
                                    required>
                                <option value="">Sélectionner une période</option>

                                @foreach($periodes as $periode)
                                    <option value="{{ $periode->id }}"
                                        data-annee="{{ $periode->anneeScolaire?->libelle }}"
                                        @selected(old('periode_id') == $periode->id)>
                                        {{ $periode->libelle }}
                                        — {{ $periode->anneeScolaire?->libelle ?? 'Année inconnue' }}
                                        @if($periode->cloturee) — Clôturée @endif
                                    </option>
                                @endforeach
                            </select>

                            @error('periode_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="periodeWarning" class="small text-danger mt-2 d-none">
                                L’année scolaire de la période doit correspondre à celle de l’inscription.
                            </div>
                        </div>

                        <div class="alert alert-primary border-0 rounded-3 d-flex gap-3 align-items-start">
                            <i class="fas fa-info-circle mt-1"></i>
                            <div class="small">
                                <strong>À savoir :</strong>
                                le bulletin sera créé en brouillon. Tu pourras ensuite le générer
                                à partir des notes, vérifier les résultats et le valider.
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4">
                            <a href="{{ route('secretariat.bulletins.index') }}"
                               class="btn btn-light border rounded-3 px-4 py-2">
                                Annuler
                            </a>

                            <button type="submit"
                                    class="btn btn-primary rounded-3 px-4 py-2"
                                    id="createBulletinBtn">
                                <i class="fas fa-plus me-2"></i>Créer le bulletin
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center text-secondary small mt-3">
                <i class="fas fa-shield-alt me-1"></i>
                Les bulletins validés ne peuvent pas être supprimés depuis cette interface.
            </div>
        </div>
    </div>
</div>

<style>
.bulletin-page { color: #182230; }
.create-banner {
    background: linear-gradient(120deg, #1746a2 0%, #3478f6 100%);
}
.create-banner-icon {
    width: 58px; height: 58px; border-radius: 17px;
    background: rgba(255,255,255,.16);
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; flex-shrink: 0;
}
.bulletin-page .form-select {
    min-height: 52px;
    border-color: #dbe3ef;
}
.bulletin-page .form-select:focus {
    border-color: #3478f6;
    box-shadow: 0 0 0 .2rem rgba(52,120,246,.12);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inscriptionSelect = document.getElementById('inscription_id');
    const periodeSelect = document.getElementById('periode_id');
    const warning = document.getElementById('periodeWarning');
    const submitButton = document.getElementById('createBulletinBtn');

    function checkSchoolYear() {
        const inscription = inscriptionSelect.options[inscriptionSelect.selectedIndex];
        const periode = periodeSelect.options[periodeSelect.selectedIndex];

        const inscriptionYear = inscription?.dataset.annee;
        const periodeYear = periode?.dataset.annee;

        const mismatch = Boolean(
            inscriptionSelect.value &&
            periodeSelect.value &&
            inscriptionYear !== periodeYear
        );

        warning.classList.toggle('d-none', !mismatch);
        submitButton.disabled = mismatch;
    }

    inscriptionSelect.addEventListener('change', checkSchoolYear);
    periodeSelect.addEventListener('change', checkSchoolYear);
    checkSchoolYear();
});
</script>
@endsection
