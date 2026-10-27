
@extends('secretariat.layout.app')

@section('title', 'Modifier l’année scolaire')

@section('content')
<style>
    .school-page {
        background: #f5f8fd;
        min-height: 85vh;
        padding: 35px 0;
    }

    .school-page .page-title {
        color: #172b4d;
        font-weight: 750;
        letter-spacing: -0.6px;
    }

    .school-page .subtitle {
        color: #718096;
    }

    .school-page .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 10px;
        background: #eaf2ff;
        color: #1765d1;
        text-decoration: none;
        font-weight: 600;
        transition: .2s;
    }

    .school-page .back-link:hover {
        background: #dceaff;
        transform: translateX(-2px);
    }

    .school-page .year-badge {
        background: #eaf2ff;
        border: 1px solid #d6e6ff;
        border-radius: 14px;
        padding: 16px 20px;
        min-width: 220px;
    }

    .school-page .form-card {
        background: #fff;
        border: 1px solid #edf1f7;
        border-radius: 18px;
        box-shadow: 0 10px 35px rgba(27, 53, 87, .06);
        overflow: hidden;
    }

    .school-page .form-card-header {
        padding: 25px 30px;
        border-bottom: 1px solid #edf1f7;
    }

    .school-page .form-card-body {
        padding: 30px;
    }

    .school-page .form-label {
        color: #263b5b;
        font-weight: 650;
        margin-bottom: 9px;
    }

    .school-page .form-control {
        min-height: 48px;
        border: 1px solid #dce4ef;
        border-radius: 10px;
        padding: 11px 14px;
        color: #253651;
        transition: border-color .2s, box-shadow .2s;
    }

    .school-page .form-control:focus {
        border-color: #3478e5;
        box-shadow: 0 0 0 4px rgba(52, 120, 229, .12);
    }

    .school-page .field-help {
        color: #8794a8;
        font-size: .84rem;
        margin-top: 7px;
    }

    .school-page .active-panel {
        background: #f0fbf7;
        border: 1px solid #c8eee0;
        border-radius: 12px;
        padding: 19px 20px;
    }

    .school-page .form-check-input {
        width: 2.8em;
        height: 1.45em;
        cursor: pointer;
        margin-top: 3px;
    }

    .school-page .form-check-input:checked {
        background-color: #12a878;
        border-color: #12a878;
    }

    .school-page .form-check-input:focus {
        box-shadow: 0 0 0 4px rgba(18, 168, 120, .12);
    }

    .school-page .form-footer {
        border-top: 1px solid #edf1f7;
        margin-top: 28px;
        padding-top: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .school-page .btn {
        border-radius: 10px;
        padding: 11px 19px;
        font-weight: 650;
        transition: .2s;
    }

    .school-page .btn-save {
        background: #1769e0;
        border: 1px solid #1769e0;
        color: white;
    }

    .school-page .btn-save:hover {
        background: #1055bc;
        border-color: #1055bc;
        color: white;
        transform: translateY(-1px);
    }

    .school-page .btn-cancel {
        background: #f5f8fc;
        border: 1px solid #dce5f1;
        color: #263b5b;
    }

    .school-page .btn-cancel:hover {
        background: #eaf0f8;
        color: #172b4d;
    }

    @media (max-width: 576px) {
        .school-page {
            padding: 22px 0;
        }

        .school-page .form-card-header,
        .school-page .form-card-body {
            padding: 20px;
        }

        .school-page .form-footer {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .school-page .form-footer .btn {
            width: 100%;
        }

        .school-page .year-badge {
            min-width: 0;
            width: 100%;
        }
    }
</style>

<div class="school-page">
    <div class="container">

        {{-- Retour --}}
        <div class="mb-4">
            <a href="{{ route('secretariat.annees-scolaires.index') }}"
               class="back-link">
                <span aria-hidden="true">←</span>
                Retour à la liste
            </a>
        </div>

        {{-- En-tête --}}
        <div class="d-flex flex-column flex-md-row
                    justify-content-between align-items-md-center
                    gap-3 mb-4">

            <div>
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="rounded-circle d-flex align-items-center
                                justify-content-center"
                         style="width:55px;height:55px;
                                background:#dfebff;color:#1769e0;
                                font-size:25px;">
                        ✎
                    </div>

                    <div>
                        <h2 class="page-title mb-1">
                            Modifier l’année scolaire
                        </h2>
                        <p class="subtitle mb-0">
                            Mettez à jour les informations de l’année scolaire.
                        </p>
                    </div>
                </div>
            </div>

            <div class="year-badge">
                <div class="d-flex align-items-center gap-3">
                    <span style="font-size:27px;color:#1769e0;"
                          aria-hidden="true">▦</span>
                    <div>
                        <div class="small text-primary">
                            Année concernée
                        </div>
                        <div class="fw-bold fs-5"
                             style="color:#172b4d;">
                            {{ $anneeScolaire->libelle }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Erreurs de validation --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                <div class="fw-bold mb-2">
                    Vérifiez les informations saisies.
                </div>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulaire --}}
        <div class="form-card">
            <div class="form-card-header">
                <h5 class="fw-bold mb-1" style="color:#172b4d;">
                    Informations générales
                </h5>
                <p class="text-muted small mb-0">
                    Les champs marqués d’un astérisque (*) sont obligatoires.
                </p>
            </div>

            <div class="form-card-body">
                <form
                    action="{{ route('secretariat.annees-scolaires.update', $anneeScolaire->id) }}"
                    method="POST">

                    @csrf
                    @method('PUT')

                    {{-- Libellé --}}
                    <div class="mb-4">
                        <label for="libelle" class="form-label">
                            Libellé <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="libelle"
                            id="libelle"
                            maxlength="30"
                            class="form-control @error('libelle') is-invalid @enderror"
                            placeholder="Ex. : 2026-2027"
                            value="{{ old('libelle', $anneeScolaire->libelle) }}"
                            required>

                        @error('libelle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="field-help">
                            Exemple : 2026-2027
                        </div>
                    </div>

                    {{-- Dates --}}
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="date_debut" class="form-label">
                                Date de début
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="date_debut"
                                id="date_debut"
                                class="form-control @error('date_debut') is-invalid @enderror"
                                value="{{ old('date_debut', $anneeScolaire->date_debut ? \Carbon\Carbon::parse($anneeScolaire->date_debut)->format('Y-m-d') : '') }}"
                                required>

                            @error('date_debut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="field-help">
                                Date de début des cours.
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="date_fin" class="form-label">
                                Date de fin
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="date_fin"
                                id="date_fin"
                                class="form-control @error('date_fin') is-invalid @enderror"
                                value="{{ old('date_fin', $anneeScolaire->date_fin ? \Carbon\Carbon::parse($anneeScolaire->date_fin)->format('Y-m-d') : '') }}"
                                required>

                            @error('date_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="field-help">
                                Date de clôture de l’année scolaire.
                            </div>
                        </div>
                    </div>

                    {{-- Année active --}}
                    <div class="active-panel">
                        <div class="d-flex align-items-start gap-3">
                            <div class="form-check form-switch mb-0">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="active"
                                    id="active"
                                    value="1"
                                    @checked((bool) old('active', $anneeScolaire->active))>
                            </div>

                            <div>
                                <label for="active"
                                       class="form-label mb-1"
                                       style="cursor:pointer;">
                                    Année scolaire active
                                </label>

                                <p class="text-muted small mb-0">
                                    Activez cette option si cette année doit
                                    être utilisée dans le système.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Boutons --}}
                    <div class="form-footer">
                        <a href="{{ route('secretariat.annees-scolaires.index') }}"
                           class="btn btn-danger">
                            ← Annuler
                        </a>

                        <button type="submit" class="btn btn-save">
                            Enregistrer les modifications
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <p class="text-muted small mt-3 mb-0">
            <span aria-hidden="true">ⓘ</span>
            Vérifiez les dates avant d’enregistrer vos modifications.
        </p>

    </div>
</div>
@endsection
