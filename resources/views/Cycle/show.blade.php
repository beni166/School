
@extends('admin.layout.app')

@section('title', 'Détails du cycle')

@section('content')
<style>
    .cycle-show { background:#f5f8fd; min-height:85vh; padding:32px 0; }
    .cycle-show .title { color:#172b4d; font-weight:750; }
    .cycle-show .muted { color:#7b879b; }
    .cycle-show .panel {
        background:#fff; border:1px solid #edf1f7; border-radius:16px;
        box-shadow:0 8px 28px rgba(27,53,87,.045); overflow:hidden;
    }
    .cycle-show .panel-head { padding:24px 28px; border-bottom:1px solid #edf1f7; }
    .cycle-show .panel-body { padding:28px; }
    .cycle-show .cycle-icon {
        width:60px; height:60px; display:flex; align-items:center;
        justify-content:center; border-radius:16px; background:#eaf2ff;
        color:#1769e0; font-size:27px; flex-shrink:0;
    }
    .cycle-show .detail-box {
        height:100%; padding:20px; border-radius:13px;
        background:#f8faff; border:1px solid #eaf0f7;
    }
    .cycle-show .detail-label { color:#8491a5; font-size:13px; margin-bottom:7px; }
    .cycle-show .detail-value { color:#263b5b; font-size:17px; font-weight:700; }
    .cycle-show .level-card {
        border:1px solid #e8edf5; border-radius:12px;
        padding:18px; background:#fff; height:100%;
    }
    .cycle-show .level-title { color:#263b5b; font-weight:700; }
    .cycle-show .class-pill {
        display:inline-block; background:#f0f4fa; color:#52647e;
        padding:5px 9px; border-radius:7px; font-size:12px; margin:3px 3px 0 0;
    }
    .cycle-show .btn { padding:10px 16px; border-radius:10px; font-weight:650; }
    .cycle-show .btn-edit { background:#1769e0; color:white; border:1px solid #1769e0; }
    .cycle-show .btn-edit:hover { background:#1055bc; color:white; }
    .cycle-show .btn-back { background:#f5f8fc; color:#263b5b; border:1px solid #dce5f1; }
    .cycle-show .btn-back:hover { background:#eaf0f8; }
    @media(max-width:576px) {
        .cycle-show .panel-head,.cycle-show .panel-body { padding:20px; }
        .cycle-show .actions { display:flex; flex-direction:column-reverse; }
        .cycle-show .actions .btn { width:100%; }
    }
</style>

<div class="cycle-show">
    <div class="container">

        <div class="mb-4">
            <a href="{{ route('director.cycle.index') }}" class="text-decoration-none">
                ← <span class="fw-semibold">Retour à la liste</span>
            </a>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between
                    align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="title mb-2">Détails du cycle</h2>
                <p class="muted mb-0">
                    Consultez les informations et les niveaux associés.
                </p>
            </div>

            <a href="{{ route('director.cycle.edit', $cycle) }}" class="btn btn-edit">
                ✎ Modifier le cycle
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="panel mb-4">
            <div class="panel-head">
                <div class="d-flex align-items-center gap-3">
                    <div class="cycle-icon">▦</div>
                    <div>
                        <div class="muted small mb-1">Cycle scolaire</div>
                        <h3 class="title mb-1">{{ $cycle->nom }}</h3>
                        <div class="muted small">Référence #{{ $cycle->id }}</div>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <h5 class="title mb-3">Vue d’ensemble</h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="detail-box">
                            <div class="detail-label">Nom du cycle</div>
                            <div class="detail-value">{{ $cycle->nom }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-box">
                            <div class="detail-label">Niveaux associés</div>
                            <div class="detail-value">
                                {{ $cycle->niveaux->count() }} niveau(x)
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center
                            flex-wrap gap-2 mb-3">
                    <h5 class="title mb-0">Niveaux de ce cycle</h5>
                    <span class="badge rounded-pill px-3 py-2"
                          style="background:#edf4ff;color:#1769e0;">
                        {{ $cycle->niveaux->count() }} niveau(x)
                    </span>
                </div>

                @forelse($cycle->niveaux as $niveau)
                    <div class="level-card mb-3">
                        <div class="d-flex justify-content-between
                                    align-items-start gap-2 flex-wrap mb-3">
                            <div>
                                <div class="level-title">
                                    {{ $niveau->nom }}
                                </div>
                                <div class="muted small mt-1">
                                    Niveau #{{ $niveau->id }}
                                </div>
                            </div>

                            <span class="badge rounded-pill"
                                  style="background:#e8f8f1;color:#12835c;">
                                Niveau associé
                            </span>
                        </div>

                        <div class="small fw-semibold mb-2"
                             style="color:#52647e;">
                            Classes associées
                        </div>

                        @forelse($niveau->classes as $classe)
                            <span class="class-pill">
                                {{ $classe->nom ?? $classe->name ?? 'Classe #' . $classe->id }}
                            </span>
                        @empty
                            <span class="muted small">
                                Aucune classe associée à ce niveau.
                            </span>
                        @endforelse
                    </div>
                @empty
                    <div class="text-center py-4">
                        <div class="cycle-icon mx-auto mb-3">▦</div>
                        <h6 class="title">Aucun niveau associé</h6>
                        <p class="muted mb-0">
                            Ce cycle ne contient pas encore de niveaux.
                        </p>
                    </div>
                @endforelse

                <div class="actions d-flex justify-content-between gap-3
                            mt-4 pt-4 border-top">
                    <a href="{{ route('director.cycle.index') }}" class="btn btn-danger">
                        ← Retour à la liste
                    </a>

                    <a href="{{ route('director.cycle.edit', $cycle) }}" class="btn btn-edit">
                        Modifier les informations
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
