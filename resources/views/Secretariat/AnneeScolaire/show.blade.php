
@extends('secretariat.layout.app')

@section('title', 'Détails de l’année scolaire')

@section('content')
<style>
    .year-show {
        min-height: 85vh;
        background: #f5f8fd;
        padding: 32px 0 45px;
    }

    .year-show .page-title {
        color: #172b4d;
        font-weight: 750;
        letter-spacing: -.5px;
    }

    .year-show .subtitle {
        color: #7b879b;
    }

    .year-show .back-link {
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

    .year-show .back-link:hover {
        background: #dceaff;
        transform: translateX(-2px);
    }

    .year-show .year-card {
        background: #fff;
        border: 1px solid #edf1f7;
        border-radius: 17px;
        box-shadow: 0 8px 28px rgba(27, 53, 87, .045);
        overflow: hidden;
    }

    .year-show .card-heading {
        padding: 24px 28px;
        border-bottom: 1px solid #edf1f7;
    }

    .year-show .card-content {
        padding: 28px;
    }

    .year-show .year-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 62px;
        height: 62px;
        border-radius: 16px;
        background: #eaf2ff;
        color: #1769e0;
        font-size: 28px;
        flex-shrink: 0;
    }

    .year-show .year-label {
        font-size: 13px;
        color: #8491a5;
        margin-bottom: 7px;
    }

    .year-show .year-value {
        color: #263b5b;
        font-weight: 700;
        font-size: 16px;
        overflow-wrap: anywhere;
    }

    .year-show .detail-box {
        height: 100%;
        padding: 20px;
        background: #f8faff;
        border: 1px solid #eaf0f7;
        border-radius: 13px;
    }

    .year-show .date-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 11px;
        background: #eaf2ff;
        color: #1769e0;
        font-size: 20px;
        margin-bottom: 15px;
    }

    .year-show .status-panel {
        padding: 20px;
        border-radius: 13px;
        border: 1px solid #c8eee0;
        background: #f0fbf7;
    }

    .year-show .status-panel.inactive {
        background: #f7f8fa;
        border-color: #e4e8ee;
    }

    .year-show .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 13px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 650;
    }

    .year-show .status-badge::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .year-show .status-active {
        color: #12835c;
        background: #e0f7ed;
    }

    .year-show .status-inactive {
        color: #718096;
        background: #e9edf2;
    }

    .year-show .btn {
        padding: 10px 17px;
        border-radius: 10px;
        font-weight: 650;
        transition: .2s;
    }

    .year-show .btn-edit {
        color: #fff;
        background: #1769e0;
        border: 1px solid #1769e0;
    }

    .year-show .btn-edit:hover {
        color: #fff;
        background: #1055bc;
        transform: translateY(-1px);
    }

    .year-show .btn-back {
        color: #263b5b;
        background: #f5f8fc;
        border: 1px solid #dce5f1;
    }

    .year-show .btn-back:hover {
        background: #eaf0f8;
    }

    .year-show .info-note {
        background: #edf4ff;
        border: 1px solid #dce9ff;
        color: #48668f;
        border-radius: 12px;
        padding: 15px 18px;
    }

    @media (max-width: 576px) {
        .year-show {
            padding-top: 22px;
        }

        .year-show .card-heading,
        .year-show .card-content {
            padding: 20px;
        }

        .year-show .actions {
            display: flex;
            flex-direction: column-reverse;
        }

        .year-show .actions .btn {
            width: 100%;
        }
    }
</style>

<div class="year-show">
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
                <h2 class="page-title mb-2">
                    Détails de l’année scolaire
                </h2>
                <p class="subtitle mb-0">
                    Consultez les informations de cette période scolaire.
                </p>
            </div>

            <div>
                <a href="{{ route('secretariat.annees-scolaires.edit', [
                    'annees_scolaire' => $anneeScolaire->id
                ]) }}" class="btn btn-edit">
                    ✎ Modifier cette année
                </a>
            </div>
        </div>

        {{-- Messages --}}
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-3 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Carte principale --}}
        <div class="year-card mb-4">

            <div class="card-heading">
                <div class="d-flex align-items-center gap-3">
                    <div class="year-icon" aria-hidden="true">
                        ▦
                    </div>

                    <div>
                        <div class="text-muted small mb-1">
                            Année scolaire
                        </div>

                        <h3 class="page-title mb-1">
                            {{ $anneeScolaire->libelle }}
                        </h3>

                        <div class="text-muted small">
                            Référence #{{ $anneeScolaire->id }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-content">

                <h5 class="fw-bold mb-3" style="color:#263b5b;">
                    Informations générales
                </h5>

                <div class="row g-3 mb-4">

                    {{-- Date de début --}}
                    <div class="col-md-6">
                        <div class="detail-box">
                            <div class="date-icon" aria-hidden="true">
                                ▦
                            </div>

                            <div class="year-label">
                                Date de début
                            </div>

                            <div class="year-value">
                                {{ $anneeScolaire->date_debut
                                    ? \Carbon\Carbon::parse($anneeScolaire->date_debut)->format('d/m/Y')
                                    : 'Non renseignée' }}
                            </div>
                        </div>
                    </div>

                    {{-- Date de fin --}}
                    <div class="col-md-6">
                        <div class="detail-box">
                            <div class="date-icon" aria-hidden="true">
                                ▦
                            </div>

                            <div class="year-label">
                                Date de fin
                            </div>

                            <div class="year-value">
                                {{ $anneeScolaire->date_fin
                                    ? \Carbon\Carbon::parse($anneeScolaire->date_fin)->format('d/m/Y')
                                    : 'Non renseignée' }}
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Statut --}}
                <h5 class="fw-bold mb-3" style="color:#263b5b;">
                    Statut de l’année
                </h5>

                <div class="status-panel {{ $anneeScolaire->active ? '' : 'inactive' }}">
                    <div class="d-flex flex-column flex-sm-row
                                justify-content-between align-items-sm-center gap-3">

                        <div>
                            <div class="fw-bold mb-1"
                                 style="color:#263b5b;">
                                {{ $anneeScolaire->active
                                    ? 'Cette année scolaire est active'
                                    : 'Cette année scolaire est inactive' }}
                            </div>

                            <p class="text-muted small mb-0">
                                {{ $anneeScolaire->active
                                    ? 'Cette année est marquée comme active dans le système.'
                                    : 'Cette année n’est actuellement pas marquée comme active.' }}
                            </p>
                        </div>

                        @if($anneeScolaire->active)
                            <span class="status-badge status-active">
                                Active
                            </span>
                        @else
                            <span class="status-badge status-inactive">
                                Inactive
                            </span>
                        @endif

                    </div>
                </div>

                {{-- Dates techniques --}}
                @if($anneeScolaire->created_at || $anneeScolaire->updated_at)
                    <div class="row mt-4 g-3">
                        @if($anneeScolaire->created_at)
                            <div class="col-md-6">
                                <div class="year-label">
                                    Date de création
                                </div>
                                <div class="year-value">
                                    {{ $anneeScolaire->created_at->format('d/m/Y à H:i') }}
                                </div>
                            </div>
                        @endif

                        @if($anneeScolaire->updated_at)
                            <div class="col-md-6">
                                <div class="year-label">
                                    Dernière modification
                                </div>
                                <div class="year-value">
                                    {{ $anneeScolaire->updated_at->format('d/m/Y à H:i') }}
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Actions --}}
                <div class="d-flex flex-column flex-sm-row
                            justify-content-between gap-3 mt-4 pt-4 border-top">

                    <a href="{{ route('secretariat.annees-scolaires.index') }}"
                       class="btn btn-danger">
                        ← Retour à la liste
                    </a>

                    <a href="{{ route('secretariat.annees-scolaires.edit', [
                        'annees_scolaire' => $anneeScolaire->id
                    ]) }}" class="btn btn-edit">
                        ✎ Modifier les informations
                    </a>
                </div>

            </div>
        </div>

        {{-- Note informative --}}
        <div class="info-note">
            <strong>Information :</strong>
            vérifiez les dates et le statut avant de modifier cette année scolaire.
        </div>

    </div>
</div>
@endsection
